<?php
	include "../../Library/dbconnect.php";

	$id=$_REQUEST['id'];   
 	$command=$_REQUEST['command'];
	$description=$_REQUEST['description'];
 	$mode=$_POST['mode'];
	$status=$_REQUEST['status'];
 	if ($mode == 1) 
 	{
 		if(isset($command))
		{
			$Asql = mysqli_query($conn, "INSERT
										INTO
										  `tbl_sms_template`(
										  `command`,
										  `description`,
										  status
										  )
										VALUES(
										 '".mysqli_real_escape_string($conn,$command)."', 
										 '".mysqli_real_escape_string($conn,$description)."',
										 '".mysqli_real_escape_string($conn,$status)."')");
			if($Asql)
			{
				echo "Data successfully added";
			}
			else
			{
				echo "Failed to add data";
			}
		} 
		else
		{
			echo "Error in adding data";
		}
 	}

 	else if ($mode == 2)
 	{
 		if(isset($command))
		{
			$sql11="UPDATE tbl_sms_template
                                                                SET
                                                                command =  '".mysqli_real_escape_string($conn,$command)."',
                                                                status  =  '".mysqli_real_escape_string($conn,$status)."',
								description= '".mysqli_real_escape_string($conn,$description)."'
                                                                WHERE id  = '$id' ";

			$Usql = mysqli_query($conn, "UPDATE tbl_sms_template 
								SET 
								command =  '".mysqli_real_escape_string($conn,$command)."',
								status  =  '".mysqli_real_escape_string($conn,$status)."',
								description= '".mysqli_real_escape_string($conn,$description)."' 
								WHERE id  = '$id' ");
			if($Usql)
			{
				echo "Data successfully updated";
			} 
			else
			{
				echo "Failed to update data";
			}
		}else
		{
			echo "Error in updating data";
		}
 	}
?>
