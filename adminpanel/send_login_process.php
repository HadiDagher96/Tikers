<?php
    session_start();
	include ("../include/config.inc.php");
	include_once ("../include/sendmail.php");
	include ("../include/functions.php");
	
  $db=mysqli_connect($DBSERVER, $USERNAME, $PASSWORD);
  mysqli_select_db($DATABASENAME,$db);    
if($_REQUEST["Submit"])
{	
	$query = "update user set username='".addslashes($_REQUEST["username"])."',password='".addslashes($_REQUEST["password"])."' where id=".$_REQUEST['id']; 
	mysqli_query($db,$query) or die(mysqli_error($db));
	
	$result=mysqli_query($db,"select * from user where password='".addslashes($_REQUEST["password"])."' and username='".addslashes($_REQUEST["username"])."'");	
	
	if(mysqli_num_rows($result) > 0)
	{	
		$row=mysqli_fetch_array($result);
		//$to=$_REQUEST["email"];
		$to=$_REQUEST["email"];
		$from=$_REQUEST["email"];
		$subject="Login Detail from Amin";
		$mailcontent='<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
				<td colspan="2">Here is your login information:</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" width="40%">Username :
				</td>
				<td>'.stripslashes($row["username"]).'		
				</td>
			</tr>
			<tr>
				<td align="right" width="40%">Password :
				</td>
				<td>'.stripslashes($row["password"]).'		
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
		</table>';
		echo $mailcontent;
		exit;
		//SendHTMLMail1($to,$subject,$mailcontent,$from);
		echo '<script language="javascript">location.href="sendlogin.php?msg=1";</script>';
	}
	else
	{
		echo '<script language="javascript">location.href="sendlogin.php?msg=2";</script>';
	}
}
?>
