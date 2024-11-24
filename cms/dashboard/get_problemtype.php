
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
$pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
$due=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
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
		$cond .=" AND `service_type` in (".implode(',',$typearray).")  ";
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
		  `prob_name`,
		  COUNT(tbl_task.task_id) AS total
		FROM
		  `tbl_service_type`
		LEFT JOIN  tbl_task ON tbl_service_type.prob_id = tbl_task.service_type
		$cond
		GROUP BY tbl_service_type.prob_id order by tbl_service_type.prob_id";
			$ores = mysql_query($sql);
			$json_data=array();
    while($rowquery=mysql_fetch_array($ores))
    {
      extract($rowquery);
	    $rand_color ='#'.substr(md5(rand()), 0, 6);
    	$json_data[]=$total;
		 
		$json_lebel[]=$prob_name.'['.bn2enNumber ($total).']';  
		$json_color[]=$rand_color;  
    }	
	//echo json_encode($json_data)
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 5px;">
    	<center><strong> সময়কাল: <?php echo $value;?></strong></center>
    </div>
</div>
<div id="canvas-holder" >
    <canvas id="chart-area2" style="height:450px; width:100%">
    
    </canvas>
</div>
<script>
		
		var config = {
			type: 'bar',
			data: {
				datasets: [{
					data:<?php echo json_encode($json_data);?>,
					backgroundColor: <?php echo json_encode($json_color);?>,
					label: ''
				}],
				labels: <?php echo json_encode($json_lebel);?>,
			},
			options: {
				responsive: true,
				legend: {
						position: 'left',
						display: false,
						fullWidth: true
					},
				
			},
			
		};
				var ctx = document.getElementById('chart-area2').getContext('2d');
				
				window.myPie = new Chart(ctx, config);
</script>
