<?									
include("connect.php");

if(isset($_REQUEST['btnDelete']))
{
	$count1 = $_REQUEST['count'];
	
	for($i = 1;$i <= $count1;$i++)
	{
		$pid = "pid".$i;
		$chk = "chk".$i;
		if(isset($_REQUEST[$chk]))
		{
			$query = "DELETE FROM  user where id=".$_REQUEST[$pid];
		}
		mysql_query($query);
		
	}
	location("manage_user.php?msg=3");
}
$LeftLinkSection = 1;
$pagetitle="User";
$sel= "select * from user where email like '".$_GET["order"]."%' order by email" ;$result=$prs_pageing->number_pageing($sel,20000,10,'N','Y');

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><? echo $pagetitle; ?> | <?=$SITE_NAME?></title>
    
    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/open-sans.css">
    
    <link rel="stylesheet" type="text/css" href="css/select2.css" />
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css" />
    
    
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    
    <link rel="icon" type="image/png" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">
    
<SCRIPT language=javascript src="body.js"></SCRIPT>

</head>

<body>

   <? include("top.php"); ?>

    <div id="container">    <!-- Start : container -->

    <? include("left.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        
                        <li class="current"><? echo $pagetitle; ?></li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Manage <? echo $pagetitle; ?></h3>
                        
                    </div>
                </div>  <!-- End : Page Header -->
                <? if($_GET["msg"]) { ?>
                <div class="alert alert-danger show">
                        <button class="close" data-dismiss="alert"></button>
                        
                          <span style="color:#CC6600;">
                          <?
                                    if($_GET["msg"]==1)
                                            echo "User Added Successfully.";
                                    elseif($_GET["msg"]==2)
                                            echo "User Updated Successfully.";
                                    elseif($_GET["msg"]==3)
                                            echo "User Deleted Successfully.";
                                    elseif($_GET["msg"]==4)
                                            echo "User with this name is already Exist.";	
                                    elseif($_GET["msg"]==5)
                                            echo "This User is in use. You can not delete this User.";	

                             ?>
                           </span>
                         
                 </div>
                 <? } 					  
                        ?> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i><? echo $pagetitle; ?></div>
                                                                
                                
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                <form name="frmNewsList" method="post" action="">
                                    <table class="table table-bordered table-hover DynamicTable">
                                        <thead>                                            
                                        <tr>
											<th width="25px">
												<input type="checkbox" name="chkAll" id="chkAll" value="chkAll" onclick="chkSelectAll();" />
											</th>
											<th width="25px">No.</th>
											<th>Email</th>
											<th>Username</th>
											<th>Phone</th>
											<th>Full Name</th>
											<th>User Type</th>
											<th>Register Type</th>
                                             <th>Actions</th>                                               
                                         </tr>
                                         </thead>
                                        <tbody>
                                            
						  <? $count=0; 
							 while($get=mysql_fetch_object($result[0])) 
							 {  
								$count++;
						 ?>	 
							 <tr>
							  <td>
							  <input type="hidden" name="pid<?=$count;?>" id="pid<?=$count;?>" value="<?=$get->id;?>" />
							  <input type="checkbox" name="chk<?=$count;?>" id="chk<?=$count;?>" value="<?=$count;?>" /></td>
							 <td><?=$count;?>.</td>
						 
							  <td > <strong> <? echo stripslashes($get->email); ?></strong></td>
							  <td > <strong> <? echo stripslashes($get->username); ?></strong></td>
							  <td > <strong> <? echo stripslashes($get->phone_number); ?></strong></td>
							  <td > <strong> <? echo stripslashes($get->first_name)." ".stripslashes($get->last_name); ?></strong></td>
							  <td > <strong> <? echo stripslashes($get->user_type); ?></strong></td>
							  <td > <strong> <? echo stripslashes($get->register_type); ?></strong></td>
							  <td nowrap>				 
		<a class="btn mini blue" href="#" onClick="window.location.href='add_user.php?id=<?php echo ($get->id); ?>&mode=edit'"><i class="fa fa-pencil"></i></a> 
                <a class="btn mini red" href="#" onClick="deleteconfirm('Are you sure you want to delete this <?=$pagetitle;?>?. \n','add_user.php?id=<?php echo($get->id); ?>&mode=delete');"><i class="fa fa-trash-o"></i></a>                  
</td>
			</tr>	  
                <? } ?>	
                             </tbody>
                       </table>
			  
				
                                 <div class="row"><div class="col-md-6">
				 <input type="hidden" name="count" id="count" value="<?=$count;?>" />   
				 <input style="margin-right:7px;" type="submit" name="btnDelete" id="btnDelete" value="Delete"  onclick="return chkDelete();" class="btn red pull-left" />&nbsp;
				 <input style="margin-right:7px;" type="button" name="button2" id="button2" value="ADD NEW"  onclick="location.href='add_user.php?mode=add'" class="btn green pull-left" />
                                    &nbsp; 
                                 
                                  <? // $result[1] ?> 								
                                   
                                    </div></div>
                                    </form>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>  <!-- End : Inner Page container -->
            <a href="javascript:void(0);" class="scrollup">Scroll</a>
        </div>  <!-- End : Inner Page Content -->

    </div>  <!-- End : container -->
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jquery.event.move.js"></script>
    <script type="text/javascript" src="js/lodash.compat.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script type="text/javascript" src="js/excanvas.js"></script>
    <script type="text/javascript" src="js/breakpoints.js"></script>
    <script type="text/javascript" src="js/touch-punch.min.js"></script>
    
    <script type="text/javascript" src="js/select2.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/DT_bootstrap.js"></script>
    
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    
    <script>
        $(document).ready(function(){
            App.init();
            DataTabels.init();
        });        
    </script>
    
<script>
    function chkSelectAll()
    {
            totchk=document.getElementById("count").value;
            if(document.getElementById("chkAll").checked==true)
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=true;
                    }
            }
            else
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=false;
                    }
            }
    }
    function chkDelete()
    {
            return confirm("Are you sure that you want to delete the selected User.");
    }
</script>    

</body>
</html>