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
        "SOAPAction: \"run\"",
        'Cookie: .WETUAUTH=3B513CE8DA5C53764F278BCEA2031626D36FA7D75648CD102CF1CA1A6BB54B308108D3893F74F815A6E60DF69FEBD09454CA9B72147FDA435BDD87D3400A7004BF6EF07BFDB3E5E9F3FAC64E0C87301AF707EC0C0D10F6118CCACB0290870831948A316EFA83C9BEBEDE654145893577977A27AD72F0BC06223B2E6A6EB0323780F3081E5FD8F77939B9BE3829F1F91B6EB78E64B7A16B06F2B70D6340BA4C7D'
    );

    $ch = curl_init();  //curl object
    if (!$ch) {
        die("Could not initialize CURL handle.");
    }

    curl_setopt($ch, CURLOPT_URL, $url);                //sets the url to fetch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //true makes the transfer be returned as a string instead of outputting it directly 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);              //sets the max time that a curl function may execute for
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
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