<?php
	header("Content-type: application/json");
	include("connect.php");
	include "function_pushnotification.php";
			 
	if($_REQUEST['store_id'] != '' && $_REQUEST['challenge_id'])
	{
		$get_chalange = "select * from store_challenges where store_id = '".$_REQUEST['store_id']."' and id = '".$_REQUEST['challenge_id']."' ";
		$get_chalange_res = mysql_query($get_chalange) or die(mysql_error());
		$get_chalange_row = mysql_fetch_array($get_chalange_res);
		
		$expired_date = $get_chalange_row['expired_date'];		
		
		
		if($expired_date < date("Y-m-d"))
		{	
			$update_che = "update store_challenges set expired_date = DATE_ADD(expired_date, INTERVAL +1 MONTH), is_renewed = 1 where store_id = '".$_REQUEST['store_id']."' and id = '".$_REQUEST['challenge_id']."' ";
			
			mysql_query($update_che) or die(mysql_error());
			
			$error = "Challenge Re-Post Successfully";
			$result=array('message'=> $error, 'result'=>'1','store_id'=>$_REQUEST['store_id'],'challenge_id'=>$_REQUEST['challenge_id']);
			
		}
		else
		{
			$error = "Challenge is currently active so you can not Re-post it.";
			$result=array('message'=> $error, 'result'=>'0');
		}
		
	}
	
	$result=json_encode($result);
	echo $result;
		
?>