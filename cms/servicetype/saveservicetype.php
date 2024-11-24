<?php
	include "../../Library/dbconnect.php";

	$prob_id=$_POST['prob_id'];   
 	$prob_name=$_POST['prob_name'];
	$show_problem=$_REQUEST['show_problem'];
	$show_upozila=$_REQUEST['show_upozila'];
	$end_user=$_REQUEST['end_user'];
	$end_user1=$_REQUEST['end_user1'];
 	$mode=$_POST['mode'];
 	$srv_type=$_POST['srv_type'];

 	if ($mode == 1) 
 	{
 		if(isset($prob_id))
		{
			$Asql = mysql_query("INSERT INTO 
										tbl_service_type (
										prob_name,
										show_problem,
										show_upozila,
										end_user,
										end_user1,
										srv_type)
								 VALUES (
								 		'$prob_name',
										'$show_problem',
										'$show_upozila',
										'$end_user',
										'$end_user1',
                                        '$srv_type'
										)");
			if($Asql)
			{
				echo "ডেটা সফলভাবে যুক্ত করা হয়েছে";
			}
			else
			{
				echo "ডেটা যুক্ত করতে ব্যর্থ";
			}
		} 
		else
		{
			echo "ডেটা যুক্ত করতে ত্রুটি হয়েছে";
		}
 	}

 	else if ($mode == 2)
 	{
 		if(isset($prob_id))
		{
			$Usql = mysql_query("UPDATE tbl_service_type 
								SET
								 prob_name = '$prob_name',
								`show_problem` = '$show_problem',
							    `show_upozila` = '$show_upozila',
							    `end_user` = '$end_user',
								end_user1 = '$end_user1',
								srv_type = '$srv_type'
								WHERE prob_id  = '$prob_id' ");
			if($Usql)
			{
				echo "ডেটা সফলভাবে আপডেট হয়েছে";
			} 
			else
			{
				echo "ডেটা আপডেট করতে ব্যর্থ হয়েছে";
			}
		}else
		{
			echo "ডেটা আপডেট করার সময় ত্রুটি হয়েছে";
		}
 	}
?>