<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challange_id'] != '' )
	{
		
		$get_query2 = "select * from store_challenges where id = '".$_REQUEST['challange_id']."' and famous_user_id = '".$_REQUEST['user_id']."' and is_deleted = 0 and is_approved = 1 order by id desc ";
		$get_query_res2 =   mysql_query($get_query2)or die(mysql_error());
		
		if(mysql_num_rows($get_query_res2)>0)
		{
			$get_query_date2 = mysql_fetch_array($get_query_res2);
			
				$id = $get_query_date2['id'];
				$challenge_type_id = $get_query_date2['challenge_type_id'];
				$challenge_type_name = GetValue("challenge_type","name","id",$challenge_type_id);
				$challenge_name = $get_query_date2['name'];
				$challeng_image = $get_query_date2['challeng_image'];
				$description = $get_query_date2['description'];
				$location = $get_query_date2['location'];
				$lattitude = $get_query_date2['lattitude'];
				$longitude = $get_query_date2['longitude'];
				$points = $get_query_date2['points'];
				$famous_user_id = $get_query_date2['famous_user_id'];
				$created_date = $get_query_date2['created_date'];
				$approved_date = $get_query_date2['approved_date'];
				$expired_date = $get_query_date2['expired_date'];
				$is_expired = 0;
				$challenge_gender = $get_query_date2['gender'];

				
				if(file_exists("../challenge_image/".$challeng_image) && $challeng_image!="")
				{
					$challeng_image = $SITE_URL."/challenge_image/".$challeng_image;
				}
				else
				{
					$challeng_image = "";
				}						
				
				if($expired_date < date("Y-m-d"))
				{
					$is_expired = 1;
				}
				$data[]=array(
					"challange_id"=>$id,
					"challenge_type_id"=>$challenge_type_id,
					"challenge_type_name"=>$challenge_type_name,
					"challenge_name"=>$challenge_name, 
					"challeng_image"=>$challeng_image,
					"challenge_gender"=>$challenge_gender,
					"description"=>$description,
					"location"=>$location,
					"lattitude"=>$lattitude,
					"longitude"=>$longitude,
					"points"=>$points,
					"famous_user_id"=>$famous_user_id,
					"created_date"=>$created_date,
					"approved_date"=>$approved_date,
					"expired_date"=>$expired_date,
					"is_expired"=>$is_expired
				);
				
				
			$message="Challenge found.";
			$result=array('message'=> $message, 'result'=>'1','responseData'=>$data);		
		}
		else
		{
			$error = "Challenge not found.";
			$result=array('message'=> $error, 'result'=>'0');
		}
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>