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
            echo '[
{"day":"Monday","Ihr":"MA8391","IIhr":"CS8451","IIIhr":"CS8461(2),CS8481(1)","IVhr":"CS8461(2),CS8481(1)","Vhr":"CS8461(2),CS8481(1)","VIhr":"CS8461(2),CS8481(1)","VIIhr":"GE8291"},
{"day":"Tuesday","Ihr":"CS8451","IIhr":"CS8492,GE8291","IIIhr":"HS8461(1),HS8461(2)","IVhr":"HS8461(1),HS8461(2)","Vhr":"CS8492","VIhr":"CS8493","VIIhr":"MA8391"},
{"day":"Wednesday","Ihr":"CS8491","IIhr":"MA8391","IIIhr":"CS8461(1),CS8481(2)","IVhr":"CS8461(1),CS8481(2)","Vhr":"CS8461(1),CS8481(2)","VIhr":"CS8461(1),CS8481(2)","VIIhr":"Counselling"}
{"day":"Thursday","Ihr":"CS8492","IIhr":"GE8291","IIIhr":"CS8493","IVhr":"CS8491","Vhr":"CS8451","VIhr":"MA8391","VIIhr":"CS8493"},
{"day":"Friday","Ihr":"CS8493","IIhr":"CS8491","IIIhr":"CS8492","IVhr":"MA8391","Vhr":"GE8291","VIhr":"CS8451","VIIhr":"CS8491"}
]';
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
