<?php
	header("Content-type: application/json");
	include("connect.php");
			 
	if($_REQUEST['user_id'] != '' && $_REQUEST['challenge_id'] != '' && $_REQUEST['store_id'] != '' )
	{
		
		if($_FILES['challenge_image']['name']!="")
		{	
			$challenge_image = str_replace(" ","_",rand(1,999).trim($_FILES['challenge_image']['name']));
			move_uploaded_file($_FILES["challenge_image"]["tmp_name"],"../complete_challenge_image/".$challenge_image);
		}

		$counter;
		$q1 = "select counter from store_challenges where id='".$_REQUEST['challenge_id']."'";
		
		$get_query_res2 = mysqli_query($db,$q1)or die(mysqli_error($db));

		if(mysqli_num_rows($get_query_res2)>0)
		{
			while($get_query_date2 = mysqli_fetch_array($get_query_res2))
			{$counter = $get_query_date2['counter'];

			}
			$counter++;
		}
		$insert_query1 = "update store_challenges  set counter ='".$counter."' where id='".$_REQUEST['challenge_id']."'";
		mysqli_query($db,$insert_query1)or die(mysqli_error($db));

				
				$error = "Challenge Completed Successfully";
				$result=array('message'=> $error, 'result'=>'1');
		
		$insert_query = "insert into store_challenge_complete_by_user set 					
				user_id='".$_REQUEST['user_id']."',
				challenge_id='".$_REQUEST['challenge_id']."',
				store_id='".$_REQUEST['store_id']."',
				challenge_image='".$challenge_image."',				
				add_date = NOW()";
				mysqli_query($db,$insert_query)or die(mysqli_error($db));
				$post_id = mysqli_insert_id();
				
				$error = "Challenge Completed Successfully";
				$result=array('message'=> $error, 'result'=>'1');
	}
	else
	{
		$error = "Please enter all required fields";
		$result=array('message'=> $error, 'result'=>'0');
	}	
	$result=json_encode($result);
	echo $result;
?>