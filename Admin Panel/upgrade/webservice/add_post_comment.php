<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['post_id'] != '' && $_REQUEST['comment'] != '')
	{
		
		$insert_query = "insert into post_comment set 					
				user_id='".$_REQUEST['user_id']."',
				post_id='".$_REQUEST['post_id']."',
				add_date=NOW(),				
				comment	= '".$_REQUEST['comment']."'";
				mysql_query($insert_query)or die(mysql_error());
				$post_id = mysql_insert_id();
				
				$add_date = GetValue("post_comment","add_date","id",$post_id);
				
				$update_comment_count = "update post set comment_count = comment_count +1 where id = '".$_REQUEST['post_id']."' ";
				mysql_query($update_comment_count)or die(mysql_error());				
				
				
				
				$error = "Post Added Successfully";
				$result=array('message'=> $error, 'result'=>'1','post_id'=>$post_id,'add_date'=>$add_date);
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>