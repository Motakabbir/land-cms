
<style>
	i.glyphicon {
    margin-top: 10px;
}
.info-box {
    display: block;
    min-height: 64px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 2px;
}
.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 64px;
    width: 90px;
    text-align: center;
    font-size: 45px;
    line-height: 74px;
    background: rgba(0,0,0,0.2);
}
span.send {
    cursor: pointer;
}
</style>
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
  $cond = "";
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
	echo "1-$SType - $cond";
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
					 when (task_status<>1 AND ( TIMESTAMPDIFF(DAY, open_date,NOW()) >".$pen." And TIMESTAMPDIFF(DAY, open_date,NOW()) <=".$dues.")) THEN 1
					 ELSE 0
					 END) AS due,
					 SUM(CASE
					 when (task_status<>1 AND (TIMESTAMPDIFF(DAY, open_date,NOW()) >=".$overdue.")) THEN 1
					 ELSE 0
					 END) AS over_due
				FROM
				  `tbl_task`
				where 1=1  
				  $cond and task_status <=3";
				  
			$ores = mysql_query($sql);	  
	 while ($orow = mysql_fetch_array($ores))
                           {
							  // print_r($orow);
                              extract($orow);
						   }
	if($SType==36 ) {
	 $call="অভিযোগ"; 
	}else {
		$call="কল";
	}
 
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 5px;">
    	<center><strong>সময়কাল: <?php echo $value;?></strong></center>
    </div>
</div>
  <div class="row">
      <div class="col-md-12" >
      		<span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="all" data-comments="সময়কাল: <?php echo $value;?><br>মোট কল">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-globe"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">মোট <?php echo $call; ?></span>
                  <span class="info-box-number"><?php echo bn2enNumber ($total_ticket) ;?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            </span>
            <!-- /.col -->
            <span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="new" data-comments="সময়কাল: <?php echo $value;?><br>নতুন কল">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-new-window"></i></span>
    
                <div class="info-box-content">
                  <span class="info-box-text">নতুন <?php echo $call; ?></span>
                  <span class="info-box-number"><?php echo bn2enNumber ($new_task);?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            </span>
            <!-- /.col -->
    
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
    		<span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="open"  data-comments="সময়কাল: <?php echo $value;?><br>চলমান কল">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-light-blue"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
    
                <div class="info-box-content">
                  <span class="info-box-text">চলমান <?php echo $call; ?></span>
                  <span class="info-box-number"><?php echo bn2enNumber ($open_task);?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            </span>
            <!-- /.col -->
            <span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="complete" data-comments="সময়কাল: <?php echo $value;?><br>নিষ্পন্ন ">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-hourglass-end"></i></span>
    
                <div class="info-box-content">
                  <span class="info-box-text">নিষ্পন্ন <?php echo $call; ?></span>
                  <span class="info-box-number"><?php echo bn2enNumber ($close_task);?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            </span>
            <!-- /.col -->
            </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="margin-top:15px">

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
 		<span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="uncomplete"  data-comments="সময়কাল: <?php echo $value;?><br>অনিষ্পন্ন " >
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="glyphicon glyphicon-time"></i></span>
            
            <div class="info-box-content">
              <span class="info-box-text">অনিষ্পন্ন <?php echo $call; ?></span>
              <span class="info-box-number"><?php echo bn2enNumber($new_task+$open_task );?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </span>
        <!-- /.col -->
         <span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="15" data-comments="সময়কাল: <?php echo $value;?><br>১৫ দিনের মধ্যে " >
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-stopwatch"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">১৫ দিনের মধ্যে <?php echo $call; ?></span>
              <span class="info-box-number"><?php echo  bn2enNumber($pending);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="30" data-comments="সময়কাল: <?php echo $value;?><br>১৫-৩০ দিনের মধ্যে">
         <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-stopwatch"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"> ১৫-৩০ দিনের মধ্যে <?php echo $call; ?></span>
              <span class="info-box-number"><?php echo bn2enNumber($due) ;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </span>
        <!-- /.col -->
        <span href="#" class="send" data-cond="<?php echo $cond;?>" data-type="31" data-comments="সময়কাল: <?php echo $value;?><br>৩০ দিনের অধিক" >
          <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-stopwatch"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"> ৩০ দিনের অধিক <?php echo $call; ?></span>
              <span class="info-box-number"><?php echo bn2enNumber($over_due) ;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </span>
        <!-- /.col -->
        </div>
      </div>
      <script>
      	    $(document).ready(function () { 
          $('span.send').click(function() {			  
			  var cond = $(this).data('cond');   
			  var type = $(this).data('type'); 
			  var comments = $(this).data('comments'); 
               $('body').append($('<form/>', {
                    id: 'form',
                    method: 'POST',
                    action: 'getrpt_ticketlist.php'
               }));

               $('#form').append($('<input/>', {
                    type: 'hidden',
                    name: 'cond',
                    value: cond
               }));
              $('#form').append($('<input/>', {
                    type: 'hidden',
                    name: 'type',
                    value: type
               }));
			   $('#form').append($('<input/>', {
                    type: 'hidden',
                    name: 'comments',
                    value: comments
               }));
              $('#form').submit();
               return false;
          });
     } );

      </script>