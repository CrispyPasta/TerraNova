<?php
//=========================Includes=============================\\
include "./base/includes.php";
include "./custom/includes.php";
//=========================Includes=============================\\
//=========================Variables============================\\
$xmldata = file_get_contents("./requests/tourplan/GetLocation.xml");
$url = "http://demo2.tourplan.com:8080/iCom310/servlet/conn";
//=========================Variables============================\\

// backup_tourplan(file_get_contents("./requests/tourplan/GetLocation.xml"), true);
// echo(curlPost(file_get_contents("./requests/GetServices.xml")));
// echo(curlPost(file_get_contents("./requests/GetLocation.xml")));

// echo(curlGet("https://wetu.com/API/Pins/4PLEDRIUFRIAMOAM/Get?ids=713"));
echo(curlGet("https://wetu.com/Admin/Operators/Suppliers?id=2297&totalRecordsLoaded=0&recordsPerPage=100&searchName=&searchDestination="));

?>
