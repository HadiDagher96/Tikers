<?php
	header('Content-type: application/json');
	include("connect.php");
	
	$user_id = addslashes($_REQUEST['user_id']);
	
	if($user_id != "")
	{
		$search = mysql_query("update push_counter set push_counter = 0 where user_id='".$user_id."'");
		$count = mysql_affected_rows($search);
		
			$fetch = mysql_fetch_array($search);
			$error="Data found successfully.";
			$result["responseData"]=array('result'=>'success',
			'message'=>$error						
			);
	}
	else
	{
		$error="Please enter all the required fields";
		$result['responseData']=array('result'=>'failed','message'=>$error);
	}
$result=json_encode($result);
print_r($result);
?>