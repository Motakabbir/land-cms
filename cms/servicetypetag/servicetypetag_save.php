<?php
	include "../../Library/dbconnect.php";

	$prob_id=$_POST['prob_id'];   
 	$name=$_POST['name'];
 	$service_type=$_POST['service_type'];

 	$mode=$_POST['mode'];

 	if ($mode == 1) 
 	{
 		if(isset($name))
		{
			$Asql = mysql_query("INSERT INTO tbl_service_tag (name,service_type) VALUES ('$name','$service_type')");
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
			$Usql = mysql_query("UPDATE tbl_service_tag 
								SET name = '$name',
									service_type = '$service_type'
								WHERE id  = '$prob_id' ");
			if($Usql)
			{
				echo "ডেটা সফলভাবে আপডেট হয়েছে";
			} 
			else
			{
				echo "ডেটা আপডেট করতে ব্যর্থ হয়েছে";
			}
		}else
		{
			echo "ডেটা আপডেট করার সময় ত্রুটি হয়েছে";
		}
 	}
?>