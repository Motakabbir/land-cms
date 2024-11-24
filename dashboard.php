<?php
session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SType=$_SESSION['SType'];
$SSO_User=$_SESSION['SSO_User'];
if (!isset($_SESSION['SUserID'])) {
	header("Location: login.php");
	exit;
}
include_once 'Library/dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ভূমি মন্ত্রণালয় || কল</title>
    <link rel="shortcut icon" href="favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="author" content="admin">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css" />
	<link href="css/fontawase.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="fullscreenmodal/css/bootstrap-modal-carousel.min.css">
    <link rel="stylesheet" href="fullscreenmodal/css/modal.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="clock/jqClock.css">
    <link rel="stylesheet" href="css/style.css">
<style type="text/css">
    
    
ul.dropdown-menu {
	margin-top: 6px;
}
.topbar-button>li {
    margin-right: 25px;
}
#u-topbar .title {
    text-align: left;
    background-color: #474c5a;
    font-size: 24px;
    padding: 4px 20px 4px 10px;
    /* margin-right: 5px; */
    color: #2dc0e8;
    font-weight: 100;
    float: left;
    line-height: 12px;
    width: 240px;
    background: rgba(255,255,255,1.00)!important;
    border-bottom: 1px solid rgba(0,67,139,1.00);
}
#u-topbar .title, .topbar-button>li>a {
    position: relative;
}
.topbar-button, .topbar-button>li, .topbar-user, .topbar-user span {
    display: inline-block;
}
.message-btn {
    color: rgba(255,255,255,1.00);
    font-size: 18px;
}
span#clock1 {
    color: #fff;
}
.topbar-button {
    margin: 1px 0 0 60px;
}
    </style>
    
     
</head>
<?php 
	$query="SELECT * FROM `tbl_company` WHERE company_id='1'";
    $Exquery=mysql_query($query) or die(mysql_error());
    while($rowquery=mysql_fetch_array($Exquery))
    {
        extract($rowquery);
    }
?>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic">
	<div id="u-app-wrapper"   class="collapse-true panel-fixed" >
		<div id="u-topbar">
			<div class="title text-center hidden-xs hidden-sm">
				<?php
					if (isset($company_image) && $company_image != "") {
					 	$src = $company_image;
					}else {
						$src = "default.jpg";
					}
					
					if (isset($company_image)) {
					 	$company_name = $company_name;
					}else {
						$company_name = "Nextech Limited";
					}
				?>
				<img style="height: 46px; margin:0px auto;" src="images/<?php echo $src;?>" alt="" class="img-responsive" >
			</div>
           
			<span class="left-panel-toggle" style="margin-left: 5px;">
				<i class="fa fa-bars"></i>
			</span>
            <ul class="topbar-button list-unstyled">
					<li class="message-btn">
						<?php //echo $company_name;?>
					</li>
					<li class="hidden-sm hidden-xs"><span id="clock1"></span></li>
				</ul>
			<ul class="topbar-button list-unstyled text-right hidden-xs hidden-sm">
				<span style="font-size:10px; color:#FFFFFF " style="width:50px">
					<?php 
					$squery="SELECT
								  tbl_district.name as disname,
								  tbl_division.name as divname,
								  tbl_upozila.name AS upname
								FROM
								_nisl_mas_user
								left JOIN tbl_district ON tbl_district.id=_nisl_mas_user.district
								LEFT JOIN tbl_division ON tbl_division.id=_nisl_mas_user.division
								LEFT JOIN tbl_upozila ON tbl_upozila.id=_nisl_mas_user.upozela
								WHERE `User_ID`=".$_SESSION['SUserID']."";
					
					$sExquery=mysql_query($squery) or die(mysql_error());
					while($srowquery=mysql_fetch_array($sExquery))
					{
						extract($srowquery);
						
					}
				?>
                অফিস : <?php if($divname!=''){echo $divname.' / ';}
							if($disname!=''){echo $disname.' / ';}
							if($upname!=''){
							echo $upname;}?>
				
				
                <?php 
					 $dquery="SELECT * FROM `tbl_user_type` WHERE tbl_user_type.id=".$_SESSION['SType']."";
					
					$dExquery=mysql_query($dquery) or die(mysql_error());
					while($drowquery=mysql_fetch_array($dExquery))
					{
						extract($drowquery);
						
					}
				?>
				,<br> উপাধি : <?php echo $type_name;?>
                
			</span>
			</ul>

			<ul class="topbar-user list-unstyled ">
            	
				<li class="dropdown" style="padding-top: 12.5px;">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
						<span class="topbar-username"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $SUserName;?><i class="fa fa-angle-down"></i></span>
					</a>
					<ul class="dropdown-menu">
                    	<!--<li>
							<a href="changepass.php">
								<i class="fa fa-key" aria-hidden="true"></i> Change password
							</a>
						</li>-->
						<li>
							<a href="changepass/PasswordChangeFrm.php" target="triger">
								<i class="fa fa-key" aria-hidden="true"></i> পাসওয়ার্ড পরিবর্তন করুন
							</a>
						</li>
						<li>
							<a href="logout.php">
								<i class="fa fa-sign-out" aria-hidden="true"></i> সাইন আউট
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="u-left-panel" class="u-left-panel1">
			<div id="u-left-menu">
				<ul class="left-menu-wrapper list-unstyled">
                	<?php 
					if($SSO_User==1){
					?>
					<li class="left-menu-parent ">
						<a href="<?php echo $_SESSION['SURL'];?>" class="" style="text-align: center; background: #5d933a;">
							<span class="left-menu-link-icon">
								<i class="fa fa-home "></i>
							</span>
							<span class="left-menu-link-info">
								<span class="link-name" style="font-size: 13px; font-weight: bold;">land.gov.bd</span>
							</span>
						</a>
					</li>
				<?php }	?>
					<li class="left-menu-parent ">
						<a href="dashboard.php"  class="" >
							<span class="left-menu-link-icon">
								<i class="fa fa-tachometer" aria-hidden="true"></i>
							</span>
							<span class="left-menu-link-info">
								<span class="link-name">ড্যাসবোর্ড</span>
							</span>
						</a>
					</li>
                    <?php 
					$parentsid=$_REQUEST['id'];
					 if($parentsid){
						 $result = mysql_query("SELECT _nisl_tree_entries.id, _nisl_tree_entries.pid, _nisl_tree_entries.NodeName, _nisl_tree_entries.url, _nisl_tree_entries.view_status, _nisl_tree_entries.icon, _nisl_tree_entries.sl
							FROM _nisl_tree_entries
							where _nisl_tree_entries.id='".$parentsid."'
							");
							
							 while($rowquery=mysql_fetch_array($result))
								{
									extract($rowquery);?>
                                   <li class="left-menu-parent ">
                                        <a href="dashboard.php?id=<?php echo $id;?>"  class="active" style="text-align: center; background: #5d933a;">
                                            <span class="left-menu-link-icon">
                                                <i class="fa <?php echo $icon; ?> "></i>
                                            </span>
                                            <span class="left-menu-link-info">
                                                <span class="link-name" style="font-size: 13px; font-weight: bold;"><?php echo $NodeName;?></span>
                                            </span>
                                        </a>
                                    </li>	
					<?php 
						}
					}
					?>	
					<?php include('lefttree.php');?>
				</ul>	
			</div>
		</div>
		<div class="content-wrapper">
			<div class="content-panel content-shrink map">
            	<style>
                	html,body        {height:100%;}
.h_iframe iframe {position:absolute;top:0;left:0;width:100%; height:calc(100% - 20px);}

                </style>
                 <div class="h_iframe">
                 	<?php $link="cms/dashboard/dashboard.php";?>
                    <iframe  frameborder="0" allowfullscreen src="<?php echo $link;?>"  name="triger"></iframe>
                </div>
				<!--<div class="col-xs-12 map-responsive pr0 pl0">
                	<div class="embed-responsive embed-responsive-16by9" style="">
                        <iframe class="embed-responsive-item" src="home.php"  name="triger">
                            
                        </iframe>
                    </div>
				</div>-->
			</div>

		</div>
	
	</div><!--Global-->

	<script src="js/jquery.js" type="text/javascript"></script>
    
    <script src="fullscreenmodal/js/bootstrap-modal-carousel.min.js"></script>
	<script src="clock/jqClock.js"></script>
     <script type="text/javascript">
			$(document).ready(function(){
			/*  $.clock.locale = {"pt":{"weekdays":["Domingo","Segunda-feira", "Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira", "Sábado"],"months":["Janeiro","Fevereiro","Março","Abril", "Maio","Junho","Julho","Agosto","Setembro","October","Novembro", "Dezembro"] } };*/
			  $("#clock1").clock({"format":"12","calendar":"true"});
			 // year, month, day, hours, minutes, seconds, milliseconds
			  customtimestamp = new Date(<?php echo date('Y, m, d, H, i, s')?>);
			  customtimestamp = customtimestamp.getTime();
			  customtimestamp = customtimestamp+1123200000+10800000+14000;
			  $("#clock5").clock({"timestamp":customtimestamp});
			});    
		  </script>
    <script>
    	$('.left-menu-wrapper a').click(function(e) {
			
			/*e.preventDefault();*/ //prevent the link from being followed
			$('.left-menu-wrapper a').removeClass('active');
			$(this).addClass('active');
		});
    </script>
 <div class="modal fade modal-fullscreen force-fullscreen" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close " data-dismiss="modal" id="close" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="mytitle">Modal title</h4>
  </div>
  <div class="modal-body modal-body-lg">
   <iframe src="" id="myiframe" frameborder="0" height="596px" width="100%"></iframe>
  </div>
  
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->           
    
    
    
    
<style>
.navbar-text {
    margin-top: 2px;
    margin-bottom: 2px;
    font-size: 12px;
}
.pr0{
	padding-right:0px
	}
</style>    
<div class="navbar navbar-default navbar-fixed-bottom" style="min-height: 23px !important; z-index:1">
    <div class="container">
    	<div class="col-sm-1"></div>
    	<div class="col-sm-3">
        	<p class="navbar-text pull-left">&nbsp;&nbsp; © <?php echo date('Y');?> মেধাস্বত্ত্ব ভূমি মন্ত্রণালয় <br>&nbsp;&nbsp;
               <a href="https://minland.gov.bd/" target="_blank" >minland.gov.bd</a>
            </p>
        </div>
    	<div class="col-sm-4">
        	
                
        </div>
    	<div class="col-sm-4">
            <p class="navbar-text pull-right">সফটওয়্যার উন্নয়নে <br>Nextech Limited
               <a href="https://www.nextech.com.bd/" target="_blank" >www.nextech.com.bd</a>
           </p>
        </div>
    </div>
</div>
<div class="modal fade" id="ProfileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="pmodal">
      
    </div>
  </div>
</div>
<?php //include_once('chat/chatbox.php');?>
</body>
<script>
	function renderModal(selector,formdata,title) {
		var search = formdata;
		$("#mytitle").text(title);
		$("#myiframe").attr("src", selector+'?'+search);
		$("#myModal1").modal('show');
	}
	/*$('#myModal1').on('hidden.bs.modal', function () {
		window.location.reload(true);
	})*/
	</script>
 <script>
    
   
    document.addEventListener("keydown", function(e) {
    //document.onkeydown = function(e) {
    // "I" key
    if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
    disabledEvent(e);
    }
    // "J" key
    if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
    disabledEvent(e);
    }
    // "S" key + macOS
    if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
    disabledEvent(e);
    }
    // "U" key
    if (e.ctrlKey && e.keyCode == 85) {
    disabledEvent(e);
    }
    // "F12" key
    if (event.keyCode == 123) {
    disabledEvent(e);
    }
    }, false);
	
    function disabledEvent(e){
    if (e.stopPropagation){
    e.stopPropagation();
    }
	else if (window.event){
    window.event.cancelBubble = true;
    }
    e.preventDefault();
    return false;
    }

    
    window.addEventListener('contextmenu', function (e) { // Not compatible with IE < 9
    e.preventDefault();
    }, false);
    
    </script>