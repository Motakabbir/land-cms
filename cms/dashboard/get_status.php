
<script src="../../bower_components/chart.js/dist/Chart.js"></script>
<script src="../../bower_components/chart.js/utils.js"></script>


<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
 session_start();
$SUserID = $_SESSION['SUserID'];
$Sdivision=$_SESSION['Sdivision'];
$Sdistrict=$_SESSION['Sdistrict'];
$Supozela=$_SESSION['Supozela'];
$SType=$_SESSION['SType'];
$SDesignation= $_SESSION['SDesignation'];

$cond=' where 1=1';

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

$pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
$dues=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
$overdue=pick('tbl_progressstatus','duration','tbl_progressstatus.id=3');
$range=$_REQUEST['range'];
$today=date('Y-m-d');

 $cond = " where 1=1 ";

  if($range==1){
	  $cond .=" and DATE_FORMAT(open_date,'%Y-%m-%d')=DATE(NOW())";
	  $value= 'আজ';
	  }
	elseif($range==2){
		$cond .=" and DATE_FORMAT(open_date,'%Y-%m-%d')>=DATE(NOW()) - INTERVAL 7 DAY";
		$value= 'শেষ ৭ দিন';
		}
	elseif($range==3){
		$cond .=" and DATE_FORMAT(open_date,'%Y-%m-%d')>=DATE(NOW()) - INTERVAL 1 MONTH ";
		$value= 'সর্বশেষ ১ মাস';
		}
	
	elseif($range==4){
		$cond .="and DATE_FORMAT(open_date,'%Y-%m-%d')>=DATE(NOW()) - INTERVAL 1 YEAR ";
		$value= 'সর্বশেষ ১ বছর';
		}	
	elseif($range==5){
		
		$value= 'এ পর্যন্ত ';
		}
	elseif($range==6){
		$cond .="and DATE_FORMAT(open_date,'%Y-%m-%d')= DATE(NOW() - INTERVAL 1 DAY)";
	  $value= 'গতকাল';
		}
		
if($SType==1){
	
}
elseif(($SType>=2 && $SType<=6) || ($SType>=21 && $SType<=35) ){	
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

elseif($SType==36 ){
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
}

if(isset($_REQUEST['division_id']) && $_REQUEST['division_id'] !='-1' ){
	 $ehead .=' বিভাগ= '.pick('tbl_division','name','id ='.$_REQUEST['division_id'].'').', ';
 	$cond .=" AND tbl_task.division='".$_REQUEST['division_id']."'";
 }
if(isset($_REQUEST['district']) && $_REQUEST['district'] !='-1'){
	$ehead .=' জেলা= '.pick('tbl_district','name','id ='.$_REQUEST['district'].'').', ';
 	$cond .=" AND tbl_task.district='".$_REQUEST['district']."'";
 }

if(isset($_REQUEST['upozila']) && $_REQUEST['upozila'] !='-1'){
	$ehead .=' উপজেলা = '.pick('tbl_upozila','name','id ='.$_REQUEST['upozila'].'').', ';
 	$cond .=" AND tbl_task.upozila='".$_REQUEST['upozila']."'";
 } 	

 
    $sql="SELECT
				  COUNT(`task_id`) as total_ticket,
				  SUM(IF(`task_status`=1,1,0)) AS close_task,
				  SUM(IF(`task_status`=2,1,0)) AS open_task,
				  SUM(IF(`task_status`=3,1,0)) AS new_task,
				  SUM(CASE
					 when (task_status=1 ) THEN 1
					 ELSE 0
					 END) AS assign_task,
				  SUM(CASE
					 when (task_status=1 ) THEN 1
					 ELSE 0
					 END) AS unassign_task,
				  SUM(CASE
					 when (task_status<>1 AND ( TIMESTAMPDIFF(DAY, open_date,NOW()) <=".$pen."  )) THEN 1
					 ELSE 0
					 END) AS pending,
					 SUM(CASE
					 when (task_status<>1 AND ( TIMESTAMPDIFF(DAY, open_date,NOW()) >=".$pen." And TIMESTAMPDIFF(DAY, open_date,NOW()) <=".$dues.")) THEN 1
					 ELSE 0
					 END) AS due,
					 SUM(CASE
					 when (task_status<>1 AND (TIMESTAMPDIFF(DAY, open_date,NOW()) >=".$overdue.")) THEN 1
					 ELSE 0
					 END) AS over_due
				FROM
				  `tbl_task`
				  $cond ";
			$ores = mysql_query($sql);
			$json_data=array();
    while($rowquery=mysql_fetch_array($ores))
    {
      extract($rowquery);
    	 $json_array='"'.$new_task.'"'; 		 
		 $json_array .=','.'"'.$open_task.'"'; 
		 $json_array .=','.'"'.$close_task. '"'; 
		
		
    }	
		if($SType==36 ) {
	 $call="অভিযোগ"; 
	}else {
		$call="কল";
	}
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 5px;">
    	<center><strong>  সময়কাল: <?php echo $value;?></strong></center>
    </div>
</div>
<div id="canvas-holder" >
    <canvas id="chart-areas" style="height:350px; width:100%">
    
    </canvas>
</div>
<script>
		
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:[<?php echo $json_array;?>],
					backgroundColor: [
						'#00c0ef',
						'#3c8dbc',
						'#00a65a',	
					],
					label: 'Dataset 1'
				}],
				labels: [
					'নতুন <?php echo $call; ?> [<?php echo bn2enNumber ($new_task);?>]',
					'চলমান <?php echo $call; ?> [<?php echo bn2enNumber ($open_task);?>]',
					'নিষ্পন্ন <?php echo $call; ?> [ <?php echo bn2enNumber ($close_task);?>]',
				],
			},
			options: {
				responsive: true,
				legend: {
						position: 'left',
					}
			},
		};
		var ctx = document.getElementById('chart-areas').getContext('2d');
		window.myPie = new Chart(ctx, config);
		
		
		
</script>