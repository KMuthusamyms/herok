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
{"staffName":"Dr.P. Subathra","subcode":"CS8451","subname":"Design and Analysis of Algorthims"},
{"staffName":"Mrs.T. Akilandeswari","subcode":"CS8491","subname":"Computer Architecture"},
{"staffName":"Mrs.E. Vakaimalar","subcode":"CS8492","subname":"Database Management Systems"},
{"staffName":"Mrs.M.Chengathir Selvi","subcode":"CS8493","subname":"Operating Systems"},
{"staffName":"Dr.S. Luna Eunice","subcode":"GE8291","subname":"Environmental Science and Engineering"},
{"staffName":"Mr.K.M. Sathish Kumar","subcode":"MA8391","subname":"Probability and Statistics"},
{"staffName":"Mrs.M.Chengathir Selvi","subcode":"CS8461","subname":"Operating Systems Laboratory"},
{"staffName":"Mrs.E. Vakaimalar","subcode":"CS8481","subname":"Database Management Systems Laboratory"},
{"staffName":"Dr.N. Pratheeba","subcode":"HS8461","subname":"Advanced Reading and Writing"}
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
