<?php
	include "../../Library/dbconnect.php";
	//include_once "Library/Library.php";

	$id=$_POST['id'];   
 	$short_description=$_POST['short_description'];
 	$au_description=$_POST['au_description'];
 	$mode=$_POST['mode'];

 	

 	if ($mode == 1) 
 	{
 		if(isset($id))
		{
			$Asql = mysql_query("INSERT INTO tbl_about_us (
					au_description, 
					short_description) 
				VALUES (
					'$au_description',
				 	'$short_description')"
				);

			
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
			$Usql = mysql_query("UPDATE tbl_about_us 
								SET 
								au_description = '$au_description',
								short_description = '$short_description'
								WHERE id  = '$id' ");
			if($_FILES['au_image']['name'] !=''){
  					$uploaddir = '../../upload/';
  					$uploadfile = $uploaddir .$id.basename($_FILES['au_image']['name']);
  					move_uploaded_file($_FILES['au_image']['tmp_name'], $uploadfile);
  					$Usql="UPDATE tbl_about_us SET
  							au_image='".mysqli_real_escape_string($conn,$id.$_FILES['au_image']['name'])."'
  							WHERE id='$id'";
  					mysql_query($Usql) or die(mysql_error());	
			}


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