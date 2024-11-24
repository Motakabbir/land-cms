<?php
session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];

if (!isset($_SESSION['SUserID'])) {
	header("Location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from 0.s3.envato.com/files/156110003/default.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2016 11:35:23 GMT -->
<head>
	<meta charset="utf-8">
	<title>ভূমি মন্ত্রণালয়</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="author" content="admin">
	<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
	<!-- <link href="../../http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css" /> -->
	<link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="../../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
	<link href="../../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
	<link href="../../css/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
	<link href="../../css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="../../bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css"> -->
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/alertify.min.css">
	<link rel="stylesheet" href="../../css/select2.min.css">
	<link rel="stylesheet" href="../../css/sumoselect.css">
	
	<!--<link href="../../https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"> -->
	<!-- For Image Uploading -->
	
    
	

    <style type="text/css">
		ul.dropdown-menu {
    		margin-top: 6px;
		}
		.paging-nav {
		  text-align: center;
		  padding-top: 2px;
		}

		.paging-nav a {
		  margin: auto 1px;
		  text-decoration: none;
		  display: inline-block;
		  padding: 1px 7px;
		  background: #337AB7;
		  color: white;
		  border-radius: 3px;
		}

		.paging-nav .selected-page {
		  background: #335C80;
		}
    </style>
   

</head>