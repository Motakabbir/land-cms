<?php
include_once "../../Library/dbconnect.php";
include_once "../../Library/Library.php";
include_once "../../Library/sms_function.php";
include_once "../../Library/common_function.php";
$mobile = $_REQUEST['mobile'];
$smsbody    = $_REQUEST['smsbody'];
$api_id =$_REQUEST['api_id'];
$mobile = "8801819213430";
$smsbody    = "test";
$api_id=1;

if($api_id=='-1'){
	$api_id=1;
	}			
echo  SmsSendSystem($mobile, $smsbody,$api_id);
?>