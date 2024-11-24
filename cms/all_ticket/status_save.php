<?php
	include "../../Library/dbconnect.php";
	include_once '../../Library/Library.php';
	include_once '../../Library/common_function.php';
	include_once '../../Library/sms_function.php';
	
	
	session_start();
	$SUserID = $_SESSION['SUserID'];
	$id=$_REQUEST['id'];   
	$task_id=$_REQUEST['task_id'];
	$comments=$_REQUEST['comments'];
	if(isset($id))
	{
			 $sql= "Update tbl_task set
							task_status='".mysql_real_escape_string($id)."',
							update_by='".mysql_real_escape_string($SUserID)."',
							update_date=NOW()
						Where task_id='$task_id'	
						";
			mysql_query($sql) or die(mysql_error());			
			if($id==1){
				$sql= "Update tbl_task set
							close_date=NOW(),
							solv_by='".mysql_real_escape_string($SUserID)."',
							solv_solution='".mysql_real_escape_string($comments)."'
						Where task_id='$task_id'	
						";
				mysql_query($sql) or die(mysql_error());			
				
				}			
						
		$status_name=pick('tbl_taskstatus','task_statusname',"task_statusid='".$id."'");
		
		if($id==1){
		
		
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
							'".mysql_real_escape_string('কার্য অবস্থা পরিবর্তন')."',
							'".mysql_real_escape_string($status_name)."',
							'".mysql_real_escape_string($comments)."',
							'".mysql_real_escape_string('I')."',
							'".mysql_real_escape_string($email)."',
							'".mysql_real_escape_string($SUserID)."',
							NOW()
						)
						";
		mysql_query($sql) or die(mysql_error());
		
		
		
		$uniqid=uniqid();
			$esql="INSERT INTO `emails`(`uniqid`,
									   `time`, 
									   `name`, 
									   `email`, 
									   `subject`,
									
									   `body_html`,
									   `type`) VALUES (
									   '".mysql_real_escape_string($uniqid)."',
									    NOW(),
										'".mysql_real_escape_string($clients_name)."',
										'".mysql_real_escape_string($email)."',
										'".mysql_real_escape_string($subject)."',									
										'".mysql_real_escape_string($body)."',
										'".mysql_real_escape_string('I')."')";
			mysql_query($esql) or die(mysql_error());
		
		}
		else{
			
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
							'".mysql_real_escape_string('কার্য অবস্থা পরিবর্তন')."',
							'".mysql_real_escape_string($status_name)."',
							'".mysql_real_escape_string($comments)."',
							'".mysql_real_escape_string('I')."',
							'".mysql_real_escape_string('')."',
							'".mysql_real_escape_string($SUserID)."',
							NOW()
						)
						";
		mysql_query($sql) or die(mysql_error());
			
			}
		
		
		
		
		if($sql)
		{
						/////////////SMS Send ////////
						
		$sql1="SELECT
		 tbl_task.task_no as txttask_no,
		  tbl_task.`contact_number`,
		  tbl_task.`prob_type` as prob_id,
		  tbl_task.`service_type`,
		  tbl_task.`task_type`
		FROM `tbl_task`
		where task_id='$task_id'";
		
		$res=mysql_query($sql1);  
		while ($row = mysql_fetch_array($res)){
                        extract($row);
						}
						
			if ( $task_type==1 && $status_name=="নিষ্পন্ন") {		
				$smsstatus = pick( 'tbl_sms_template', 'status', " command='comp_ticket_solved'" );
				if ( $smsstatus > 0 ) {
					
	//			$txtcontact_number = pick( 'tbl_task', 'contact_number', " task_id='".$task_id."'" );
	//			$service_type = pick( 'tbl_task', 'service_type', " task_id='".$task_id."'" );
	//			$prob_id = pick( 'tbl_task', 'prob_type', " task_id='".$task_id."'" );
				
				$smsbody = pick( 'tbl_sms_template', 'description', " command='comp_ticket_solved'" );

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
			}
			////////////
		
			echo "অপারেশন সফলভাবে সম্পন্ন হয়েছে ";
		}
		else
		{
			echo "অপারেশন ব্যর্থ হয়েছে";
		}
	} 
	else
	{
		echo "পরিচালনায় ত্রুটি হয়েছে";
	}
?>