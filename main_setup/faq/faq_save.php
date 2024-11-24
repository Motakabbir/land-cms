<?php
	include "../../Library/dbconnect.php";

	$id=$_POST['id'];   
 	$faq_question=$_POST['faq_question'];
 	$faq_answer=$_POST['faq_answer'];
 	$active_status=$_POST['active_status'];
 	$mode=$_POST['mode'];
 	if ($mode == 1) 
 	{
 		if(isset($id))
		{
			$Asql = mysqli_query($conn,"INSERT INTO
									  `tbl_faq`(									    
									    `faq_question`,
									    `faq_answer`,
									    `active_status`
									  )
									VALUES(
									  '".mysqli_real_escape_string($conn,$faq_question)."',
									  '".mysqli_real_escape_string($conn,$faq_answer)."',
									  '".mysqli_real_escape_string($conn,$active_status)."'
									)");
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
 		if(isset($id))
		{
			
			$Usql = mysqli_query($conn, "UPDATE tbl_faq 
								SET faq_question =  '".mysqli_real_escape_string($conn,$faq_question)."',
								 faq_answer =  '".mysqli_real_escape_string($conn,$faq_answer)."',
								 active_status =  '".mysqli_real_escape_string($conn,$active_status)."'
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