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
	if(1)//mysqli_real_escape_string($conn,$postdata->keyvalue)==md5("xxx"))
	{		
		$rollnumber=mysqli_real_escape_string($conn,"15UITE001");
		if($rollnumber!="")
		{			
			$sql = $db->sql_query("SELECT dept_sec_id,year FROM mentor WHERE rollNumber='$rollnumber'");
			$r = $db->sql_fetchrow($sql);
			$dept_sec_id=$r['dept_sec_id'];
			$year=$r['year'];
			$sql = $db->sql_query("SELECT * FROM `regulation` WHERE `years` LIKE '%$year%'");
			$r = $db->sql_fetchrow($sql);
			$uid=$r['uid'];
			$sql = $db->sql_query("SELECT * FROM section WHERE dept_sec_id='$dept_sec_id'");
			$r = $db->sql_fetchrow($sql);
			$deptId=$r['deptId'];	
			$sql = $db->sql_query("SELECT * FROM semester");
			$r = $db->sql_fetchrow($sql);
			if($r['current']=="ODD"){
				if($year==1)
					$semester=1;
				if($year==2)
					$semester=3;
				if($year==3)
					$semester=5;
				if($year==4)
					$semester=7;
			}
			else{
				if($year==1)
					$semester=2;
				if($year==2)
					$semester=4;
				if($year==3)
					$semester=6;
				if($year==4)
					$semester=8;
			}		
			$q="SELECT s.subcode as subjectcode,s.subname as subjectname,st.staffName  AS facultyname FROM staff_subject AS i, subject AS s, staff AS st WHERE i.dept_sec_id='$dept_sec_id' AND i.sem='$semester' AND s.semester='$semester' AND st.staffid=i.main AND s.deptId='$deptId' AND s.uid='$uid' AND i.subcode=s.subcode ORDER BY i.subcode";
			$sql = $db->sql_query($q);
			$rows = array();
			while($r = $db->sql_fetchrow($sql)) {
					$rows[] = $r;		
					$flag=1;
			}
			if(empty($rows))
				$s->error = "Not Available";
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
