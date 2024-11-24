<?php
	include_once "../../Library/dbconnect.php";
	include_once "../../Library/Library.php";
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
	$USER_ID=pick("_nisl_mas_user","MAX(User_ID)+1",NULL);
	
	if(isset($Name))
	{
		$insert_query2 = "insert into _nisl_mas_user
		(
			User_ID,
		    Name,
		    Designation,
		    CompanyName,
		    Address,
			permanent_address,
		    Email,
		    Phone,
			user_status,
			division,
			district,
			upozela,
			nid_number,
			show_status
		)
		values
		(
			'$USER_ID',
		    '$Name',
		    '$Designation',
		    '$CompanyName',
		    '$Address',
			'$permanent_address',
		    '$Email',
		    '$Phone',
			'$user_status',
			'$division_id',
			'$district',
			'$upozila',
			'$nid_number',
			'1'
		)
        ";
		mysqli_query($conn, $insert_query2) or die(mysqli_error());

		
		
		if($_FILES['user_image']['name'] !=''){
  					$uploaddir = '../../upload/';
  					$uploadfile = $uploaddir .$id.basename($_FILES['user_image']['name']);
  					move_uploaded_file($_FILES['user_image']['tmp_name'], $uploadfile);
  					$Usql="UPDATE _nisl_mas_user SET
  								user_image='".mysqli_real_escape_string($conn,$id.$_FILES['user_image']['name'])."'
  							WHERE User_ID='$USER_ID'";
  					mysql_query($Usql) or die(mysql_error());	
		}
		if($_FILES['user_nid']['name'] !=''){
  					$uploaddir = '../../upload/';
  					$uploadfile = $uploaddir .$id.basename($_FILES['user_nid']['name']);
  					move_uploaded_file($_FILES['user_nid']['tmp_name'], $uploadfile);
  					$Usql="UPDATE _nisl_mas_user SET
  								user_nid='".mysqli_real_escape_string($conn,$id.$_FILES['user_nid']['name'])."'
  							WHERE User_ID='$USER_ID'";
  					mysql_query($Usql) or die(mysql_error());	
		}

		

		$insert_query1 = "insert into _nisl_mas_member
		                  (
		                        User_Name,
		                        User_ID,
		                        Password,
		                        Type,
		                        suboffice_id,
								reseller_id
		                  )
		                  values
		                  (
		                        '$User_Name',
		                        '$USER_ID',
		                        '$Password',
		                        '$Type',
		                        '$suboffice_id',
								'$reseller_id'
		                  )
		                  ";


		$res2 = mysqli_query($conn, $insert_query1) or die(mysqli_error());

		if($res2)
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
	
	

	
?>