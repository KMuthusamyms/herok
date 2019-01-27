<?php
    //http://stackoverflow.com/questions/18382740/cors-not-working-php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    header("Content-Type: application/json; charset=UTF-8");
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: POST");         
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
       $username = $request->rollnumber;
      
        if ($username != "") {
            echo '[{"subcode":"EC6018","subname":"Multimedia Compression and Communication","test1":"12","assign1":"80"},{"subcode":"GE6757","subname":"Total Quality Management","test1":"2","assign1":"0"}]';
           // print $postdata;
        }
        else {
            echo '[{"Error" : "Empty username parameter!"}]';
        }
    }
    else {
        echo '[{"Error" : "Empty username parameter!"}]';
    }
    //print $postdata;
    //print_r($_POST);
?>
