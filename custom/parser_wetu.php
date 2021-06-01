<?php


function backupItineraries_wetu(){
    $identifierList = itineraryList_wetu();     //this holds the list of identifiers
    $itinerary_backup = array();                //this will hold the list of itinerary objects

    for ($a = 0; $a < count($identifierList); $a++) {
        array_push($itinerary_backup, itineraryGet_wetu($identifierList[$a]));  //send a request to get each itinerary 
    }

    $dumpToFile = json_encode($itinerary_backup);
    file_put_contents("./backups/itineraries_backup.json", $dumpToFile);
}

/**
 * This function executes the itinerary list call and returns a list of "identifiers". One for each itinerary
 * @return identifierList An array of strings, 36 chars long. 
 */
function itineraryList_wetu(){
    $IL = curlGet("https://wetu.com/API/Itinerary/4PLEDRIUFRIAMOAM/V8/List?type=Sample&results=20&sort=LastModifiedAsc");
    $jsonIL = json_decode($IL);     //a json object containing all the itineraries 
    $jsonIL = $jsonIL->itineraries;     //removing a useless wrapping

    $identifierList = array();      //initialize the list

    for ($a = 0; $a < count($jsonIL); $a++){
        array_push($identifierList, $jsonIL[$a]->identifier);       //push just the identifier onto the list
    }
       
    return $identifierList;
}

/**
 * This function sends a request using the itinerary identifier and returns the result as a json object. 
 * @return jsonIG A JSON-encoded object that contains all the information about the itinerary from Wetu. 
 */
function itineraryGet_wetu($identifier){
    $url = "https://wetu.com/API/Itinerary/V8/Get?id=" . $identifier;
    $IG = curlGet($url);
    $jsonIG = json_decode($IG);     //a json object holding the entire intinerary 
    return $jsonIG;     //return the json object. 
}

?>