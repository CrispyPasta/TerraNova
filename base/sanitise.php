<?php 
function sanitise(){
    $url = $_SERVER['REDIRECT_URL'];
    $url = explode('/', $url);      //put redirect URL into an array of its own
    if (count($url) != 3) {          //check whether the URL array has three elements (first entry is empty)
        // sendResponse(false, "Number of URL elements is incorrect. Please ensure the request conforms to the class/function rule.");
        exit(0);
    }
    sanitiseURL($url);            //sanitise the array
    unset($url[0]);                 //remove empty first entry. Do it after sanitise because unset removes index 0 from array
    sanitiseQuery($_POST);    //sanitise the data from the JSON
    return $url;
}

/**
 * Sanitise the array containing the URL. Pass by reference so it does not return anything. 
 */
function sanitiseURL(&$arr){
    if ($arr === NULL){
        exit(0);
    }

    if (count($arr) > 0) {
        for ($a = 0; $a < count($arr); $a++) {
            $arr[$a] = sanitiseParam($arr[$a]);
        }
    }
}

/**
 * Sanitise the array containing the Query. Pass by reference so it does not return anything. 
 * Had to make a separate function because of PHP's associative arrays not working with indeces at all. 
 */
function sanitiseQuery(&$arr){
    if ($arr === NULL){
        exit(0);
    }

    if (count($arr) > 0) {
        foreach($arr as  $key => $value){
            //set the value of each element to the sanitised version of itself
            $arr[$key] = sanitiseParam($value);
        }
    }
}

/**
 * Sanitise the incoming string. Strip HTML tags and escape special characters.
 */
function sanitiseParam(string $params): string{
    $params = trim($params);
    $params = strip_tags($params);
    $params = htmlspecialchars($params);
    return $params;
}

?>
