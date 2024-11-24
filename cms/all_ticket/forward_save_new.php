<?php
	include "../../Library/dbconnect.php";
	include_once '../../Library/Library.php';
	include_once '../../Library/common_function.php';
	include_once '../../Library/sms_function.php';
	
	session_start();
	$SUserID = $_SESSION['SUserID'];
	$id=$_REQUEST['task_id'];   
	$division_id=$_REQUEST['division_id'];   
	$district=$_REQUEST['district'];   
	$upozila=$_REQUEST['upozila'];
	$complain_manage=$_REQUEST['complain_manage'];
	
	$department=$_REQUEST['department'];
	if(isset($id))
	{
			$sql= "Update tbl_task set
							division='".mysql_real_escape_string($division_id)."',
							district='".mysql_real_escape_string($district)."',
							upozila='".mysql_real_escape_string($upozila)."',
							complain_manage='".mysql_real_escape_string($complain_manage)."',
							update_date=NOW(),
							update_by='".mysql_real_escape_string($SUserID)."'
						Where task_id='$id'	
						";
						
			mysql_query($sql) or die(mysql_error());
			
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
							'".mysql_real_escape_string('টাস্ক ফরোয়ার্ড')."',
							'".mysql_real_escape_string($subject)."',
							'".mysql_real_escape_string($body)."',
							'".mysql_real_escape_string('I')."',
							'".mysql_real_escape_string($employee_email)."',
							'".mysql_real_escape_string($SUserID)."',
							NOW()
						)
						";
			mysql_query($sql) or die(mysql_error());
			
			$nsql="INSERT INTO `cms_task_note`(`task_id`,
											   `task_note`,
											   `entry_by`, 
											   `enrty_date`) 
											   VALUES (
											   '".mysql_real_escape_string($task_id)."',
											   '".mysql_real_escape_string($schedule_to_comments)."',
											   '".mysql_real_escape_string($SUserID)."',
												NOW()
											   )";
			mysql_query($nsql) or die(mysql_error());								   
		if($sql)
		{
			echo "অপারেশন সফলভাবে সম্পন্ন হয়েছে";
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