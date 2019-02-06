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
	$flag=1;
    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
	include("../classes/config.php");
	error_reporting(0);
	if(mysqli_real_escape_string($conn,$postdata->keyvalue)==md5("xxx"))
	{			
		$rollnumber=mysqli_real_escape_string($conn,$postdata->rollnumber);
		if($rollnumber!="")
		{		
			$q= $db->sql_fetchrow ($db->sql_query("SELECT * FROM student WHERE rollNumber='$rollnumber'"));			
			
			$q1= $db->sql_fetchrow ($db->sql_query("SELECT * FROM mentor WHERE rollNumber='$rollnumber'"));
			$q2= $db->sql_fetchrow ($db->sql_query("SELECT * FROM chair_person WHERE rollNumber='$rollnumber' AND dept_sec_id='$q1[dept_sec_id]'"));
			$q3= $db->sql_fetchrow ($db->sql_query("SELECT staffName, qualification FROM staff WHERE staffid='$q1[staffid]'"));
			$q4= $db->sql_fetchrow ($db->sql_query("SELECT staffName, qualification FROM staff WHERE staffid='$q2[staffid]'"));
			$q5= $db->sql_fetchrow ($db->sql_query("SELECT dept_name FROM department WHERE deptId='$q[deptId]'"));
			$a->studentname=$q['studName'];
			$a->dob=$q['dob'];
			$a->department=$q5['dept_name'];
			$a->fathername=$q['fathername'];
			$a->mothername=$q['mothername'];
			$a->email=$q['email'];
			$a->mentor=$q3['staffName'].$q3['qualification'];
			$a->chairperson=$q4['staffName'].$q4['qualification'];
			$rows[] = $a;		
			unset($a);
			
			if(empty($rows))
				$s->error = "Not Available";
			else
				$flag=1;
		}
		else
			$s->error = "Empty Data";		
	}
	else
		$s->error = "Invaild Action";
	if($flag==1)
		print json_encode($rows);
	else
		print json_encode($s);
?>
