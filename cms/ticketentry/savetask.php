<?php
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
include_once '../../Library/common_function.php';
include_once '../../Library/sms_function.php';
include_once "../../phpmailer/PHPMailerAutoload.php";
include_once '../../Library/email_function.php';

session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
	
$txtclients_id=$_REQUEST['txtclients_id'];
$txtclients_servid=$_REQUEST['txtclients_servid'];
$txtprob_type=$_REQUEST['txtprob_type'];
$txtsubject=$_REQUEST['txtsubject'];
$txtdescription=$_REQUEST['txtdescription'];
$txttask_status=3;
$txttask_department=$_REQUEST['txttask_department'];
$txttask_priority=$_REQUEST['txttask_priority'];
$txtcontact_number=$_REQUEST['txtcontact_number'];
$txtcontact_person=$_REQUEST['txtcontact_person'];
$txtcontact_person_no=$_REQUEST['txtcontact_person_no'];
$down_time=$_REQUEST['down_time'];
$txtcontact_email=$_REQUEST['txtcontact_email'];
$txtaddress=$_REQUEST['txtaddress'];
$task_type=$_REQUEST['task_type'];

if($task_type==1)
{
	$txttask_status=4;
}else{
	$txttask_status=3;
}

$division_id=$_REQUEST['division_id'];
$district=$_REQUEST['district'];
$upozila=$_REQUEST['upozila'];
$prob_id=$_REQUEST['prob_id'];
$service_type=$_REQUEST['service_type'];
$nid=$_REQUEST['nid'];
$date_of_birth=$_REQUEST['date_of_birth'];
$service_tag=$_REQUEST['service_tag'];

// $pieces = explode("/", $date_of_birth);
// $prate_change_date=$pieces[2]."-".$pieces[1]."-".$pieces[0];
// $down_time=$prate_change_date." ".$pieces1[1];

if($service_type==8 || $service_type==12 || $service_type==11){
	$txttask_status=1;
	}
	
if($down_time!=null){
	$pieces1 = explode(" ", $down_time);
	$pieces = explode("/", $pieces1[0]);
	$prate_change_date=$pieces[2]."-".$pieces[1]."-".$pieces[0];
	$down_time=$prate_change_date." ".$pieces1[1];
}
else{
	$down_time=date('Y/m/d H:i:s');
}

if ( $division_id > 0 ) {
     $div_bbs = pick( "tbl_division", "id", " division_bbs_code='" . $division_id . "'" );
}else{
	$div_bbs ='00';
}
if ( $district > 0 ) {
	$dis_bbs = pick( "tbl_district", "id", " district_bbs_code='" . $district . "'" );
}else{
	$dis_bbs ='00';
}

// $div_bbs=pick("tbl_division","division_bbs_code","id='$division_id'");

// $dis_bbs=pick("tbl_district","district_bbs_code","id='$district'");

$stodate=date('Y/m/d');

$txttask_no=pick("tbl_task","max(task_no)","DATE_FORMAT(`open_date`,'%Y/%m/%d')='$stodate'");

if($txttask_no<1){
	$timestamp=date('y/m/d');	
	$pieces = explode("/", $timestamp);
	 $txttask_no=$div_bbs.''.$dis_bbs.''.$pieces[0].$pieces[1].$pieces[2]."00001";
}else{
	 $txttask_no=pick("tbl_task","max(RIGHT(task_no, 5))+1","DATE_FORMAT(`open_date`,'%Y/%m/%d')='$stodate'");
	 $txttask_nos=str_pad($txttask_no, 5, '0', STR_PAD_LEFT);
	 $timestamp=date('y/m/d');	
	 $pieces = explode("/", $timestamp);
	 $txttask_no =$div_bbs.''.$dis_bbs.''.$pieces[0].''.$pieces[1].''.$pieces[2].''.$txttask_nos;
}

$txtsubject=$txtsubject;

$others_problem=$_REQUEST['others_problem'];
$solv_solution=$_REQUEST['solv_solution'];


$hascitizen=pick('tbl_citizen','id',"mobile='".$txtcontact_number."'");

if($hascitizen<=0){
	if ( $upozila > 0 && $upozila > 0 ) {
		$upozila_bbs=pick('tbl_upozila','upozila_bbs_code',"id='".$upozila."'");
        
      }else{
      	$upozila_bbs='00';
      }
	
	
		mysql_query("INSERT
			INTO
			  `tbl_citizen`(
			    `mobile`,
			    `name`,
			    `email`,
			    `address`,
			    `division_bbs`,
			    `district_bbs`,
			    `upozila_bbs`,
			    `nid`,
			    `date_of_birth`
			  )
			VALUES(
			  '".mysql_real_escape_string($txtcontact_number)."',
			  '".mysql_real_escape_string($txtcontact_person)."',
			  '".mysql_real_escape_string($txtcontact_email)."',
			  '".mysql_real_escape_string($txtaddress)."',
			  '".mysql_real_escape_string($div_bbs)."',
			  '".mysql_real_escape_string($dis_bbs)."',
			  '".mysql_real_escape_string($upozila_bbs)."',
			  '".mysql_real_escape_string($nid)."',
			  '".mysql_real_escape_string($date_of_birth)."'
			)");
}

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
							others_problem,
							solv_solution,
							nid,
							date_of_birth,
							service_tag,
							task_type
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
							'".mysql_real_escape_string($others_problem)."',
							'".mysql_real_escape_string($solv_solution)."',
							'".mysql_real_escape_string($nid)."',
							'".mysql_real_escape_string($date_of_birth)."',
							'".mysql_real_escape_string($service_tag)."',
							'$task_type'
						)";
				//echo $Asql;
   				mysql_query($Asql) or die(mysql_error());
   				$task_id=mysql_insert_id();
				

				if($txttask_status==1){
					$sql= "Update tbl_task set
							close_date=NOW(),
							solv_by='".mysql_real_escape_string($SUserID)."',
							solv_solution='".mysql_real_escape_string($solv_solution)."'
						Where task_id='$task_id'	
						";
						mysql_query($sql) or die(mysql_error());	
					$status_name=pick('tbl_taskstatus','task_statusname',"task_statusid='".$task_id."'");
						$sql= "INSERT INTO tbl_task_history (
											task_id,							
											short_dsc,
											subject,
											description,
											type,
											email,
											update_by,
											update_date
										) VALUES (
											'".mysql_real_escape_string($task_id)."',
											'".mysql_real_escape_string("সমাধানের পদ্ধতি")."',
											'".mysql_real_escape_string($status_name)."',
											'".mysql_real_escape_string($solv_solution)."',
											'".mysql_real_escape_string('I')."',
											'".mysql_real_escape_string($txtcontact_email)."',
											'".mysql_real_escape_string($SUserID)."',
											NOW()
										)
										";
						mysql_query($sql) or die(mysql_error());
					
					}
					
		if($task_type>1)
		{
				$smsstatus = pick( 'tbl_sms_template', 'status', " command='ticket_recieved'" );
				if ( $smsstatus > 0 ) {
				 $smsbody = pick( 'tbl_sms_template', 'description', " command='ticket_recieved'" );

				 $api_id = 1;
				 $snames=pick('tbl_service_type','prob_name',"prob_id='".$service_type."'");
				 $probnames='';
				 if($prob_id>0){
				 	$probnames=pick('tbl_problem','prob_name',"prob_id='".$prob_id."'");
				 }
				 $row=array('ticket_no'=>$txttask_no,'service'=>$snames,'problem'=>$probnames);

				$newsql="SELECT `prob_id` FROM `tbl_service_type` WHERE `srv_type`=1";
				$NewResultSet= mysql_query($newsql) or die("Invalid query: " . mysql_error());

				$servdata=array();
				while ($Newrow = mysql_fetch_assoc($NewResultSet)){
					//$servdata=$servdata+$Newrow;	
					 array_push( $servdata,$Newrow['prob_id']);
				}
				if(in_array($service_type, $servdata)){
					$smsbody = bind_to_template( $row, $smsbody );
					 if ( $txtcontact_number != "" ) {
					   SmsSendSystem( $txtcontact_number, $smsbody, $api_id );
					 }	
				}
				 
				}
		}				
				
				// $email_status=1;
				// if($email_status==1){
				// 	$email_id=1;
				// 	SendMails($txtcontact_email, $txtcontact_person, $txtsubject, $smsbody."<br> কলের বিবরণ  :".$txtdescription, $email_id);
				// }
									
				
	if(mysql_query("COMMIT"))
   {
        echo "1";
   }
   else
   {
   		echo "অপারেশন করা হয়নি";
   }
?>