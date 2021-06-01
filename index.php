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

// $arr = itineraryList_wetu();
backupItineraries_wetu();

?>
