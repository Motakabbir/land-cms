<?php
	include_once "../../Library/dbconnect.php";
	include_once "../../Library/Library.php";
	$User_ID = $_POST['User_ID'];
	$Name = $_POST['Name'];
	$Designation = $_POST['Designation'];
	$CompanyName = $_POST['CompanyName'];
	$Address = $_POST['Address'];
	$permanent_address=$_REQUEST['permanent_address'];
	$Email = $_POST['Email'];
	$Phone = $_POST['Phone'];
	$Type = $_POST['Type'];
	$suboffice_id = $_POST['suboffice_id'];
	$User_Name = $_POST['User_Name'];
	$Password = $_POST['Password'];
	$user_status=$_REQUEST['user_status'];
	$reseller_id=$_REQUEST['reseller_id'];
	
	$division_id=$_REQUEST['division_id'];
	$district=$_REQUEST['district'];
	$upozila=$_REQUEST['upozila'];
	$nid_number=$_REQUEST['nid_number'];
	if(isset($Name))
	{
		$res1 = mysqli_query($conn,"UPDATE _nisl_mas_user 
								SET 
								Name = '$Name',
								Designation = '$Designation',
								CompanyName = '$CompanyName',
								Address = '$Address',
								permanent_address='$permanent_address',
								Email = '$Email',
								Phone = '$Phone',
								user_status='$user_status',
								division='$division_id',
								district='$district',
								upozela='$upozila',
								nid_number='$nid_number'
								WHERE User_ID = '$User_ID'
							");
		
		UploadImage($_FILES['user_image']['name'],$_FILES['user_image']['size'],$_FILES['user_image']['temp'],'_nisl_mas_user','user_image',$User_ID,'../../upload/');
		
		UploadImage($_FILES['user_nid']['name'],$_FILES['user_nid']['size'],$_FILES['user_nid']['temp'],'_nisl_mas_user','user_nid',$User_ID,'../../upload/');
		
		
		
		$res2 = mysqli_query($conn,"  UPDATE _nisl_mas_member 
								SET 
								User_Name = '$User_Name',
								Password = '$Password',
								Type = '$Type',
								suboffice_id = '$suboffice_id',
								reseller_id ='$reseller_id'
								WHERE User_ID = '$User_ID'
							");
		if($res2)
		{
			echo "Data successfully updated.";
		} 
		else
		{
			echo "Failed to update data";
		}
		
	}else
	{
		echo "Error in updating data";
	}
?>