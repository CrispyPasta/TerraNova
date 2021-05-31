<?php


function backupItineraries_wetu(){
    $identifierList = itineraryList_wetu();
    $itinerary_backup = array();
    for ($a = 0; $a < count($identifierList); $a++) {
        array_push($itinerary_backup, itineraryGet_wetu($identifierList[$a]));  //send a request to get the itinerary 
    }
    $dumpToFile = json_encode($itinerary_backup);
    file_put_contents("./backups/itineraries_backup.json", $dumpToFile);
}
/**
 * This function executes the itinerary list call and returns a list of "identifiers". One for each itinerary
 * @return identifierList An array of strings, 36 chars long. 
 */
function itineraryList_wetu(){
    $IL = curlGet("https://wetu.com/API/Itinerary/4PLEDRIUFRIAMOAM/V8/List?type=Sample&results=1000&sort=LastModifiedAsc");
    $jsonIL = json_decode($IL);     //a json object containing all the itineraries 
    $jsonIL = $jsonIL->itineraries;     //removing a useless wrapping

    $identifierList = array();      //initialize the list

    for ($a = 0; $a < count($jsonIL); $a++){
        // echo($jsonIL[$a]->identifier . "\n");
        array_push($identifierList, $jsonIL[$a]->identifier);       //push just the identifier onto the list
    }
       
    return $identifierList;
}


function itineraryGet_wetu($identifier){
    $url = "https://wetu.com/API/Itinerary/V8/Get?id=" . $identifier;
    $IG = curlGet($url);
    $jsonIG = json_decode($IG);     //a json object holding the entire intinerary 
    return $jsonIG;     //return the json object. 
}

?>