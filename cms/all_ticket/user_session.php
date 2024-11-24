<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
session_start();
 $SType=$_SESSION['SType'];
 
$SUserID = $_SESSION['SUserID'];
$Sdivision=$_SESSION['Sdivision'];
$Sdistrict=$_SESSION['Sdistrict'];
$Supozela=$_SESSION['Supozela'];
$Supozela=$_SESSION['Supozela'];
$SDesignation= $_SESSION['SDesignation'];
$SType=$_SESSION['SType'];


$sql="SELECT
  `id`,
  `group_id`,
  `service_id`
FROM
  `tbl_group_service`
WHERE `group_id`  =".$SType."";
$res = mysql_query($sql);
$typearray=array();
while ($row = mysql_fetch_array($res))
	{
		array_push($typearray,$row['service_id']);
	}

//print_r($typearray);

if($SType==1){
	
}
elseif(($SType>=2 && $SType<=6) || $SType>21 ){	
	if(!empty($typearray)){
	$cond .=" AND (`service_type` in (".implode(',',$typearray).") or  `complain_manage` = '".$SDesignation."') ";
	}
}elseif($SType==7 || $SType==8){	
	if(!empty($typearray)){
		$cond .=" AND (`service_type` in (".implode(',',$typearray).") or  `complain_manage` = '".$SDesignation."') ";
	}
		$cond .=" and division='$Sdivision'";
}
elseif($SType==9 || $SType==10){
	if(!empty($typearray)){
		$cond .=" AND (`service_type` in (".implode(',',$typearray).") or  `complain_manage` = '".$SDesignation."') ";
	}
		$cond .=" and district='$Sdistrict'";
	
}
elseif($SType==11 || $SType==12){	
	if(!empty($typearray)){
		$cond .=" AND (`service_type` in (".implode(',',$typearray).") or  `complain_manage` = '".$SDesignation."') ";
	}
		$cond .=" and  upozila='$Supozela'";
	
}	
elseif($SType==21 ){
	if(!empty($typearray)){
		$cond .=" AND (`service_type` in (".implode(',',$typearray).") or  `complain_manage` = '".$SDesignation."') ";
	}
}	
	
?>