<?php 
include_once '../../Library/dbconnect.php';
$thana_id=$_REQUEST['thana_id'];
if(isset($thana_id))
	{
$Asql = mysqli_query($conn, "DELETE FROM `tbl_thana` WHERE `thana_id`='$thana_id'");
 
 if($Asql)
		{
			echo "Thana Delete successfully";
		} 
		else
		{
			echo "Failed to Delete Thana";
		}
	}else
	{
		echo "Error in Deleting Thana";
	}
?>