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
	include("../classes/config.php");
	error_reporting(0);
	if(mysqli_real_escape_string($conn,$postdata->keyvalue)==md5("xxx"))
	{			
		$rollnumber=mysqli_real_escape_string($conn,$postdata->rollnumber);
		$dob=mysqli_real_escape_string($conn,$postdata->dob);		
		if($rollnumber!="" AND $dob!="")
		{		
			$k="";
			$a=strtotime($dob);
			$dob= date('d.m.Y',$a);
			$sql = $db->sql_query("SELECT * FROM student WHERE rollNumber='$rollnumber' AND dob=''$dob");
			if(mysqli_num_rows($sql))
			{				
				$s->status = "Vaild User";				
			}
			else
			{
				$s->status="Invalid User";
			}												
		}
		else
			$s->error = "Empty Data";		
	}
	else
		$s->error = "Invaild Action";
	print json_encode($s);
?>
