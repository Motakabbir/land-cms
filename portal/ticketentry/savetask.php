<?php
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
include_once '../../Library/common_function.php';
include_once '../../Library/sms_function.php';
include_once '../../Library/sms_function.php';
include_once "../../phpmailer/PHPMailerAutoload.php";
include_once '../../Library/email_function.php';

session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = 4;
	
$txtclients_id=$_REQUEST['txtclients_id'];
$txtclients_servid=$_REQUEST['txtclients_servid'];
$txtprob_type=$_REQUEST['txtprob_type'];
$txtsubject=$_REQUEST['txtsubject'];
$txtdescription=$_REQUEST['txtdescription'];
$txttask_status=4;
$txttask_department=$_REQUEST['txttask_department'];
$txttask_priority=$_REQUEST['txttask_priority'];
$txtcontact_number=$_REQUEST['txtcontact_number'];
$txtcontact_person=$_REQUEST['txtcontact_person'];
$txtcontact_person_no=$_REQUEST['txtcontact_person_no'];
$down_time=$_REQUEST['down_time'];
$txtcontact_email=$_REQUEST['txtcontact_email'];
$txtaddress=$_REQUEST['txtaddress'];
$task_type=$_REQUEST['task_type'];

$division_id=$_REQUEST['division_id'];
$district=$_REQUEST['district'];
$upozila=$_REQUEST['upozila'];
$prob_id=$_REQUEST['prob_id'];
$service_type=$_REQUEST['service_type'];
if($down_time!=null){
	$pieces1 = explode(" ", $down_time);
	$pieces = explode("/", $pieces1[0]);
	$prate_change_date=$pieces[2]."-".$pieces[1]."-".$pieces[0];
	$down_time=$prate_change_date." ".$pieces1[1];
}
else{
	$down_time=date('Y/m/d H:i:s');
}
 $div_bbs=pick("tbl_division","division_bbs_code","id='$division_id'");

 $dis_bbs=pick("tbl_district","district_bbs_code","id='$district'");

$stodate=date('Y/m');

$txttask_no=pick("tbl_task","max(task_no)","DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'");

if($txttask_no<1){
	$timestamp=date('y/m/d');	
	$pieces = explode("/", $timestamp);
	 $txttask_no=$div_bbs.''.$dis_bbs.''.$pieces[0].$pieces[1]."0001";
}else{
	 $txttask_no=pick("tbl_task","max(RIGHT(task_no, 4))","DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'")+1;
	 $txttask_nos=str_pad($txttask_no, 4, '0', STR_PAD_LEFT);
	 $timestamp=date('y/m/d');	
	 $pieces = explode("/", $timestamp);
	 $txttask_no =$div_bbs.''.$dis_bbs.''.$pieces[0].''.$pieces[1].''.$txttask_nos;
}

$txtsubject=$txtsubject;

$others_problem=$_REQUEST['others_problem'];

 $Asql="INSERT INTO tbl_task (
							task_no,
							clients_servid,
							clients_id,
							prob_type,
							contact_number,
							contact_person,
							contact_person_no,
							subject,
							description,
							open_date,
							task_status,
							task_department,
							task_priority,
							down_time,
							created_by,
							entry_by,
							entry_date,
							email,
							address,
							division,
							district,
							upozila,
							service_type,
							others_problem
						) VALUES (
							'".mysql_real_escape_string($txttask_no)."',
							'".mysql_real_escape_string($txtclients_servid)."',
							'".mysql_real_escape_string($txtclients_id)."',
							'".mysql_real_escape_string($prob_id)."',
							'".mysql_real_escape_string($txtcontact_number)."',
							'".mysql_real_escape_string($txtcontact_person)."',
							'".mysql_real_escape_string($txtcontact_person_no)."',
							'".mysql_real_escape_string($txtsubject)."',
							'".mysql_real_escape_string($txtdescription)."',
							NOW(),
							'".mysql_real_escape_string($txttask_status)."',
							'".mysql_real_escape_string($txttask_department)."',
							'".mysql_real_escape_string($txttask_priority)."',
							'".mysql_real_escape_string($down_time)."',
							'$SUserID',
							'$SUserID',
							NOW(),
							'".mysql_real_escape_string($txtcontact_email)."',
							'".mysql_real_escape_string($txtaddress)."',
							'".mysql_real_escape_string($division_id)."',
							'".mysql_real_escape_string($district)."',
							'".mysql_real_escape_string($upozila)."',
							'".mysql_real_escape_string($service_type)."',
							'".mysql_real_escape_string($others_problem)."'
						)";
				//echo $Asql;
   				mysql_query($Asql) or die(mysql_error());
   			//	$task_id=mysql_insert_id();
				
				
				$sms_status=1;
				if($sms_status==1){
					$smsbody="আপনার অভিযোগ গৃহীত হয়েছে. আপনার টিকিট নম্বরটি হচ্ছে[".$txttask_no."]";
					SmsSendSystem($txtcontact_number, $smsbody,1);
				}
				$email_status=1;
				if($email_status==1){
					$email_id=1;
					SendMails($txtcontact_email, $txtcontact_person, $txtsubject, $smsbody."<br> কলের বিবরণ  :".$txtdescription, $email_id);
				}
									
				
	if(mysql_query("COMMIT"))
   {
        echo "1";
   }
   else
   {
   		echo "অপারেশন করা হয়নি";
   }
?>