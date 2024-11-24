<?php
	include "../../Library/dbconnect.php";
	include_once '../../Library/Library.php';
	include_once '../../Library/common_function.php';
	include_once '../../Library/sms_function.php';
	include_once "../../phpmailer/PHPMailerAutoload.php";
	include_once '../../Library/email_function.php';
	
	session_start();
	$SUserID = $_SESSION['SUserID'];
	$comments=$_REQUEST['comments'];   
	$task_id=$_REQUEST['task_id'];
	$replay=$_REQUEST['replay'];
		$service_tag=$_REQUEST['service_tag'];	
		$txtaddress=$_REQUEST['txtaddress'];	
		$txtsubject=$_REQUEST['txtsubject'];
		$txtdescription=$_REQUEST['txtdescription'];
		
		$service_tag_old=$_REQUEST['service_tag_old'];
		$subject_old=$_REQUEST['subject_old_old'];
		$description_old=$_REQUEST['description_old'];
		$address_old=$_REQUEST['address_old'];
		$task_status_old=$_REQUEST['task_status_old'];
		$entry_by=$_REQUEST['entry_by'];
		
	
	if(isset($task_id))
	{
				
			
	
		$sql= "INSERT INTO tbl_task_log (
							task_no,							
							service_tag_old,
							service_tag_new,
							subject_old,
							subject_new,
							description_old,
							description_new,
							address_old,
							address_new,
							task_status_old,
							task_status_new,
							entry_by,
							update_by,
							update_date
						) VALUES (
							'".mysql_real_escape_string($task_id)."',
							'".mysql_real_escape_string($service_tag_old)."',
							'".mysql_real_escape_string($service_tag)."',
							'".mysql_real_escape_string($subject_old)."',
							'".mysql_real_escape_string($txtsubject)."',
							'".mysql_real_escape_string($description_old)."',
							'".mysql_real_escape_string($txtdescription)."',
							'".mysql_real_escape_string($address_old)."',
							'".mysql_real_escape_string($txtaddress)."',
							'".mysql_real_escape_string($task_status_old)."',
							'3',
							'".mysql_real_escape_string($entry_by)."',
							'".mysql_real_escape_string($SUserID)."',
							NOW()
						)
						";
		mysql_query($sql) or die(mysql_error());
		

		
		$sql= "Update tbl_task set							
							update_date=NOW(),
							service_tag='".mysql_real_escape_string($service_tag)."',
							address='".mysql_real_escape_string($txtaddress)."',
							subject='".mysql_real_escape_string($txtsubject)."',
							description='".mysql_real_escape_string($txtdescription)."',
							task_status='3',
							update_by='".mysql_real_escape_string($SUserID)."'
						Where task_id='$task_id'";
						
			mysql_query($sql) or die(mysql_error());
			
			
		$sql1="SELECT
		 tbl_task.task_no as txttask_no,
		  tbl_task.`contact_number`,
		  tbl_task.`prob_type` as prob_id,
		  tbl_task.`service_type`
		FROM `tbl_task`
		where task_id='$task_id'";
		
		$res=mysql_query($sql1);  
		while ($row = mysql_fetch_array($res)){
                        extract($row);
						}
			
			
			/////////////SMS Send ////////
				$smsstatus = pick( 'tbl_sms_template', 'status', " command='grs_ticket_update'" );
				if ( $smsstatus > 0 ) {
					
	//			$txtcontact_number = pick( 'tbl_task', 'contact_number', " task_id='".$task_id."'" );
	//			$service_type = pick( 'tbl_task', 'service_type', " task_id='".$task_id."'" );
	//			$prob_id = pick( 'tbl_task', 'prob_type', " task_id='".$task_id."'" );
				
				$smsbody = pick( 'tbl_sms_template', 'description', " command='grs_ticket_update'" );

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
					$test="test";
					$smsbody = bind_to_template( $row, $smsbody );
					 if ( $contact_number != "" ) {
					   SmsSendSystem( $contact_number, $smsbody, $api_id );
					 }	
				}
				 
				}	
				
		
		
		if($sql)
		{
			echo "অপারেশন সফলভাবে সম্পন্ন হয়েছে ";
		}
		else
		{
			echo "অপারেশন ব্যর্থ হয়েছে";
		}
	} 
	else
	{
		echo "পরিচালনায় ত্রুটি";
	}
?>