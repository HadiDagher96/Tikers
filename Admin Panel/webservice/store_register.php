<?php
	header("Content-type: application/json");
	include("connect.php");
	
	
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['store_name'] != '' && $_REQUEST['store_type_id'] != '' && $_REQUEST['location'] != '' && $_REQUEST['latitude'] != '' && $_REQUEST['longitude'] != '' && $_REQUEST['phone_number'] != '' && $_REQUEST['payment_type'] != '' && $_REQUEST['amount'] != '' && $_REQUEST['payment_token'] != '' && $_REQUEST['gender'] != '')
	{
		$check_is_famous = mysql_query("select id from user where id='".$_REQUEST['user_id']."' and is_Famous_Req = '1' ") or die(mysql_error());
		if(mysql_num_rows($check_is_famous) > 0)
		{
			$message = "User has already requested for Famous account.";
			$result=array('message'=> $message, 'result'=>'0');
		}
		else
		{
			$check_customer_mobile = mysql_query("select id from store where user_id='".$_REQUEST['user_id']."' ") or die(mysql_error());	
			if(mysql_num_rows($check_customer_email) > 0)
			{
				$message = "User has already created store.";
				$result=array('message'=> $message, 'result'=>'0');	
			}				
			else
			{
				/*   gender  */
				/*	0 = Male /  1 = Female  /  2 = not specified  */
				
				$store_image="";
				if(isset($_FILES["store_image"]))
				{
					if ($_FILES["store_image"]["error"] > 0)
					{
						//echo "Error: " . $_FILES["full"]["error"] . "<br />";
					}
					else
					{
						 $store_image = rand(1,999).trim($_FILES["store_image"]["name"]); 
						 move_uploaded_file($_FILES["store_image"]["tmp_name"],"../store_image/".$store_image);
					}
				}
				
				$add_date = date("Y-m-d");
				if($_REQUEST['payment_type'] == "month")
				{
					$expire_date = date('Y-m-d', strtotime("+1 months", strtotime($add_date)));	
				}
				elseif($_REQUEST['payment_type'] == "yearly")
				{
					$expire_date = date('Y-m-d', strtotime("+1 year", strtotime($add_date)));
				}
				

				
				
				$insert_query = "insert into store set 					
						user_id='".$_REQUEST['user_id']."',
						name='".$_REQUEST['store_name']."',
						store_type_id='".$_REQUEST['store_type_id']."',
						location='".$_REQUEST['location']."',
						latitude='".$_REQUEST['latitude']."',
						longitude='".$_REQUEST['longitude']."',
						phone_number='".$_REQUEST['phone_number']."',
						is_Store_req = '1',	
						payment_type = '".$_REQUEST['payment_type']."',
						amount = '".$_REQUEST['amount']."',
						payment_token = '".$_REQUEST['payment_token']."',
						add_date=NOW(),
						expire_date = '".$expire_date."',
						gender = '".$_REQUEST['gender']."' ";
				
						if($profile_image!="")
						{	
							$insert_query.=" , profile_image='$profile_image'";
						} 
						mysql_query($insert_query)or die(mysql_error());
						$store_id = mysql_insert_id();
						
						//$query2 = "update user set user_type = 'Store', latitude = '".$_REQUEST['latitude']."', longitude = '".$_REQUEST['longitude']."' where id=".$_REQUEST['user_id'];
						//mysql_query($query2) or die(mysql_error());
						
						//$store_challenge_query = "insert into store_challenges set store_id='$store_id', name='Visit the Store', points = '10', challenge_category = 'Free', created_date=now(), gender = '".$_REQUEST['gender']."' "; 
				
						//mysql_query($store_challenge_query) or die(mysql_error());
				
						$error = "Store Request Sent Successfully";
						$result=array('message'=> $error, 'result'=>'1','user_id'=>$_REQUEST['user_id'],'store_id'=>$store_id);
			}
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