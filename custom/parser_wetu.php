<?php
/**
 * This function makes a call to get a list of all pins. Then check each pin's last_modified date. The function requests the full descriptions 
 * of all the pins with last_modified dates that are more recent than the newest backup available. It then backs up those pins to a json file.
 */
function backupPins_wetu(){
    $temp = 0;                                          //this is a dummy variable 
    $pinIDlist = listPins_wetu();                       //get a list of all pins in SA
    $pinIDString = "";                                  //the getPins call accepts a comma separated list of pin IDs. This will hold that list. 
    for ($a = 0; $a < count($pinIDlist); $a++){         
        if ($pinIDlist[$a]->last_modified > $temp){      //if last modified is more recent than backup, then fetch that pin
            $pinIDString = $pinIDString . $pinIDlist[$a]->id . ",";
        } 
    }

    $pins_backup = getPin_wetu($pinIDString);           //pins_backup is an array of JSON objects. Each object is the big description of a pin
    file_put_contents("./backups/pins_backup.json", json_encode($pins_backup));     //dump to a file 
}

/**
 * This function returns an array of json objects. Each object is a brief description of a pin, including its ID. 
 */
function listPins_wetu(){
    $LP = curlGet("https://wetu.com/API/Pins/4PLEDRIUFRIAMOAM/List?countries=ZA");
    return json_decode($LP);
}

/**
 * This function takes a string of pin IDs and returns an array of json objects. Each object is the description of a pin. 
 */
function getPin_wetu($ids){
    $GP = curlGet("https://wetu.com/API/Pins/4PLEDRIUFRIAMOAM/Get?type=Accommodation&ids=" . $ids);
    return json_decode($GP);
}

/**
 * This function calls Wetu to get a list of itineraries, and uses the GUIDs from that call to request the full information for each itinerary. 
 * It then backs up the itineraries to a json file. Functionality will be added to first check the last_modified date of each itinerary before 
 * requesting the itinerary description. 
 */
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
    $IL = curlGet("https://wetu.com/API/Itinerary/4PLEDRIUFRIAMOAM/V8/List?type=Sample&results=1&sort=LastModifiedAsc");
    $jsonIL = json_decode($IL);         //a json object containing all the itineraries 
    $jsonIL = $jsonIL->itineraries;     //removing a useless wrapping

    $identifierList = array();          //initialize the list

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
    return json_decode($IG);     //return the json object that contains the whole big itinerary. 
}

?>