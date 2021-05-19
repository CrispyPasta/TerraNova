<?php

/**
 * @brief uses cURL to send XML data to a given URL using HTTP Post.
 * @param $xmldata The contents of the XML request that should be sent.
 * @param $url The url that the request should be sent to. This has a defualt value. 
 */
function curlPost($xmldata, $url = "http://demo2.tourplan.com:8080/iCom310/servlet/conn"){
    $curlHeaders = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: \"run\""
    );

    $ch = curl_init();  //curl object
    if (!$ch) {
        die("Could not initialize CURL handle.");
    }

    curl_setopt($ch, CURLOPT_URL, $url);                //sets the url to fetch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //true makes the transfer be returned as a string instead of outputting it directly 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);              //sets the max time that a curl function may execute for
    curl_setopt($ch, CURLOPT_POST, true);               //this makes libcurl do a regular HTTP post. It also makes the library use the header in the next line
    curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders); //this sets an array of header fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);     //the data that should be POSTed
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     //making this true menas that the any "location" header should be followed.
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //this stops curl from verifying the peer's certificate
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //don't verify the host.

    $result = curl_exec($ch);           //this executes the call
    return $result;      //sanitise the string before returning. 
}

function curlGet($url){
    $curlHeaders =
    array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: \"run\""
    );

    $ch = curl_init();  //curl object
    if (!$ch) {
        die("Could not initialize CURL handle.");
    }

    curl_setopt($ch, CURLOPT_URL, $url);                //sets the url to fetch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //true makes the transfer be returned as a string instead of outputting it directly 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);              //sets the max time that a curl function may execute for
    // curl_setopt($ch, CURLOPT_POST, true);               //this makes libcurl do a regular HTTP post. It also makes the library use the header in the next line
    curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders); //this sets an array of header fields
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);     //the data that should be POSTed
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     //making this true menas that the any "location" header should be followed.
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //this stops curl from verifying the peer's certificate
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //don't verify the host.

    $result = curl_exec($ch);           //this executes the call
    return $result;      //sanitise the string before returning. 
}
?>