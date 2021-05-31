<?php
//=========================Includes=============================\\
include "./base/includes.php";
include "./custom/includes.php";
//=========================Includes=============================\\
//=========================Variables============================\\
$xmldata = file_get_contents("./requests/tourplan/GetLocation.xml");
$url = "http://demo2.tourplan.com:8080/iCom310/servlet/conn";
// $wetu_request = file_get_contents("./requests/wetu/pins-get2.txt");
//=========================Variables============================\\

$urls = array(
    "Pins-get" => "https://wetu.com/API/Pins/4PLEDRIUFRIAMOAM/Get?type=Accommodation&ids=10876,43154",
    "Itinerary-list" => "https://wetu.com/API/Itinerary/4PLEDRIUFRIAMOAM/V8/List?type=Sample&results=4&sort=LastModifiedAsc",
    "Itinerary-get" => "https://wetu.com/API/Itinerary/V8/Get?id=8c58fb48-83cc-4557-b68e-8b04e2fd22a9",
    "Pin-get" => "https://wetu.com/API/Pins/4PLEDRIUFRIAMOAM/Get?ids=713"
);

// $arr = itineraryList_wetu();
backupItineraries_wetu();

?>
