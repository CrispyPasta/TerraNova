<?php


/**
 * This function gets a list of locations from tourplan and updates the database if it is missing any locations.
 * cURL is used to send an API request that returns the list of locations.
 * It then makes executes a SQL statement to retrieve the list of locations from the database and compares the two lists.
 * If the list from the API call has any entries that are not already in the DB, they get added to the DB. A backup of the DB
 * is made before adding the new locations. 
 */
function backup_tourplan($xmldata, $verbose = false){
    $allRequestsCollection = [
        '<GetServicesRequest>' => array(
            'table' => 'getservices',
            'columns' => array(
                'code' => '<Code>',
                'name' => '<Name>',
            )
        ),
        '<GetLocationsRequest>' => array(
            'table' => 'getlocations',
            'columns' => array(
                'code' => '<Code>',
                'name' => '<Name>',
            )
        )
    ];
    
    $requestType = '';
    if (strpos($xmldata, "<GetServicesRequest>") != false){
        $requestType = "<GetServicesRequest>";
    } elseif (strpos($xmldata, "<GetLocationsRequest>") != false){
        $requestType = "<GetLocationsRequest>";
    }

    $apiReply = curlPost($xmldata);
    $replyArray = explode("\n", $apiReply);    //split into an array of lines
    $localArray = array();
    $dbconnection = new Sql();     //create sql connection object
    $sqlResult = $dbconnection->runQuery("SELECT code, name FROM {$allRequestsCollection[$requestType]['table']}");       //run the query to retrieve all the locations and codes 
    $dbBackup = array();   

    if ($verbose){     
        echo("API Request:\n" . $xmldata);
        echo("\n\nReply:\n" . $apiReply);
    }

    for ($a = 0; $a < count($replyArray); $a++){
        if (strpos($replyArray[$a], "<Code>") !== false) {       //grab the code and location pair
            $code = getContents_tourplan($replyArray[$a]);
            $locationName = getContents_tourplan($replyArray[$a+1]);  //name of location will always be next line after <code>
            $localArray += [$code => $locationName];             //append to array
        }
    }
    //now we have an associative array of codes and their names

    if ($sqlResult->num_rows > 0){
        while($row = $sqlResult->fetch_assoc()){
            $dbBackup += [$row["code"] => $row["name"]];       //add each row to the local array
        }
    }
    //$localArray and $dbBackup are now both populated with key-value pairs in the same format. 
    
    $differenceArray = array_diff_assoc($localArray, $dbBackup);     //differenceArray holds items found in $localArray that aren't in the DB.
    if (count($differenceArray) > 0){
        backupTable_tourplan($dbBackup, $allRequestsCollection[$requestType]['table']);        //backup the table to a json file
        if ($verbose){
            echo("\nDatabase backup complete.\n");
        }
        
        foreach ($differenceArray as $key => $value) {
            $dbconnection->runQuery("INSERT INTO {$allRequestsCollection[$requestType]['table']} (code, name) VALUES ('$key', '$value')");      //add each row to the db
            if ($verbose){
                echo("Added $key | $value to the databse.\n");
            }
        }
    } elseif ($verbose){
        echo("There were no new locations. No backup created. No changes made to database.\n");
    }

    return;
}

/**
 * Returns the 3 letter code from the line.
 */
function getContents_tourplan($line){        
    $start = strpos($line, '>') + 1;
    $end = strpos($line, "</");
    return substr($line, $start, $end - $start);
}


/**
 * Save the array to a json file.
 * Used to backup the database.
 */
function backupTable_tourplan($data, $tablename){
    $output = '';
    
    foreach($data as $key => $value){
        $output = $output . "INSERT INTO getservices (code, name) VALUES ('$key', '$value');\n";
    }
    file_put_contents("./backups/" . $tablename . ".txt", $output);

}

?>
