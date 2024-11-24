<?php
require_once "../Library/dbconnect.php";
      //include "Library/dbconnect.php";
      //include "Library/Library.php";
      //include "Library/SessionValidate.php";


$response = array("respons" => 0);

if(empty($_REQUEST['condition'])) {echo json_encode($response); exit;}

  $str="SELECT ".$_REQUEST['column']."  FROM ".$_REQUEST['table']." WHERE ".$_REQUEST['condition'].""; 


$query=mysqli_query($conn, $str);
if(mysqli_num_rows($query)<=0) {echo json_encode($response); exit;}

$response = mysqli_fetch_array($query); 
	//$a["respons"] = 1;
	//$a["colvalue"] = $response[0];
	
echo json_encode($response); exit;

?>