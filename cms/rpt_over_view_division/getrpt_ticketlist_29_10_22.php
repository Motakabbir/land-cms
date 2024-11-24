<div class="clr"></div>
<div class="row">
<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
 $pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
  $dues=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
  $overdue=pick('tbl_progressstatus','duration','tbl_progressstatus.id=3');
 session_start();	
$SUserID = $_SESSION['SUserID'];
$Sdivision=$_SESSION['Sdivision'];
$Sdistrict=$_SESSION['Sdistrict'];
$Supozela=$_SESSION['Supozela'];
$SType=$_SESSION['SType'];

$cond='';
$probtype= $_REQUEST['probtype'];
if( is_array($probtype)){
    $invalue="";
	while (list ($key, $val) = each ($probtype)) {
	   
		if($val=='-1'){
			$invalue='';
			break;
		}else{
		    
			 if($invalue==''){
					$invalue=$val;
					 //echo "$val <br>";
				}else{
					$invalue=$invalue.','.$val;
				}
		}
	}
}

 $ehead='';	
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

if($invalue!=''){
	$cond .="and tbl_task.service_type IN ($invalue)";
	}
if(isset($_REQUEST['task_statusid']) && $_REQUEST['task_statusid'] !='-1'){
	$ehead .=' অবস্থা = '.pick('tbl_taskstatus','task_statusname','task_statusid ='.$_REQUEST['task_statusid'].'').', ';
 	$cond .=" AND tbl_task.task_status='".$_REQUEST['task_statusid']."'";
 } 	

if(isset($_REQUEST['filter']) && $_REQUEST['filter'] !=""){
 		$cond.=" AND (tbl_task.task_no like '%".$_REQUEST['filter']."%'  OR `tbl_task`.`contact_number` like '%".$_REQUEST['filter']."%')";
 }

 if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
	$ehead .="<br>তারিখ ".bn2enNumber ($_REQUEST['txtfromopen_date'])." থেকে ".bn2enNumber ($_REQUEST['txttoopen_date']);
 	$cond .=" AND (DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')<='".$txttoopen_date."')";
 }
 
 
 
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
	$cond .=" AND `service_type` in (".implode(',',$typearray).")";
	}
}
elseif($SType==7 || $SType==8){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and division='$Sdivision'";
}

elseif($SType==9 || $SType==10){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and district='$Sdistrict'";
	
}
elseif($SType==11 || $SType==12){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and  upozila='$Supozela'";
	
}	

elseif($SType==21 ){
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
}


				$SeNTlist1="SELECT
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
									 END) AS over_due,
									 tbl_division.name,
									 `tbl_district`.`name` as disname
								FROM
								  `tbl_task`
								LEFT JOIN tbl_division ON tbl_division.id = tbl_task.division
       					LEFT JOIN tbl_district ON tbl_district.id = tbl_task.district and tbl_district.division_id=tbl_division.id
							where 1=1 and tbl_task.division!=0 and tbl_task.district!=0
							$cond
							group  By tbl_district.id order by tbl_division.name, `tbl_district`.`name`";
		//echo $SeNTlist1;		
		
		
      $rSeNTlist1=mysql_query($SeNTlist1) or die();
      $numrows=mysql_num_rows($rSeNTlist1);
      if($numrows>0)
      {
       $i=0;
	   
	   echo "<div id='dvContainer'>";
       drawCompanyInformationDiv("সারসংক্ষেপ প্রতিবেদন ",$ehead);
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '   >
            <tr>
						<th align='justify'  rowspan='2' > ক্রমিক</th>
						<th align='justify' rowspan='2'  >বিভাগ</th>
						<th align='justify' rowspan='2'  >জেলা</th>
						<th align='justify'  rowspan='2' > মোট কল</th>
						<th align='justify'  rowspan='2' >নিস্পন্ন কল</th>
						<th align='justify' rowspan='2'  >মোট অনিস্পন্ন</th>
						<th align='justify'  colspan='3' >অনিস্পন্ন কল</th>
            </tr><tr>
            	<th >১৫ দিনের মধ্যে</th>
            	<th>১৫-৩০ দিনের মধ্যে</th>
            	<th>৩০ দিনের অধিক</th>
            </tr>
            ";
			$i=1;
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
			
			
			if($name!=NULL){
				
				$ttotal_ticket=$total_ticket+$total_ticket;
				$tclose_task=$close_task+$tclose_task;
				$tnew_task=$new_task+$open_task+$tnew_task;
				$tpending=$pending+$tpending;
				$tdue=$due+$tdue;
				$tover_due=$over_due+$tover_due;
           ?>
           <tr>
           	<td><?php echo $i;?></td>
            <td><?php echo $name ;?></td>
            <td><?php echo $disname;?></td>
           	<td><?php echo bn2enNumber ($total_ticket) ;?></td>
           	<td><?php echo bn2enNumber ($close_task) ;?></td>
           	<td><?php echo bn2enNumber ($new_task+$open_task) ;?></td>
           	<td><?php echo bn2enNumber ($pending) ;?></td>
           	<td><?php echo bn2enNumber ($due) ;?></td>
           	<td><?php echo bn2enNumber ($over_due) ;?></td>
           </tr>
           <?php
			$i++;
			}
			
			
			
			
            }
			?>
            <tr>
            	<td colspan="3">সর্বমোট	 </td>
            	<td><?php echo bn2enNumber ($ttotal_ticket) ;?></td>
            	<td><?php echo bn2enNumber ($tclose_task) ;?></td>
            	<td><?php echo bn2enNumber ($tnew_task) ;?></td>
            	<td><?php echo bn2enNumber ($tpending) ;?></td>
            	<td><?php echo bn2enNumber ($tdue) ;?></td>
            	<td><?php echo bn2enNumber ($tover_due) ;?></td>
            </tr>
			
			<?php 
			echo"</table> </div>";
      }
	  else{
	  echo "<center><b> তথ্য পাওয়া যায়নি.....</b>";
	  }


?>
<script language="JavaScript">

	function taskview(val)
	{
	
	w=700;
	h=500;
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
		var popit=window.open("../rpttaskhistory.php?task_id="+val+"",'console','status,scrollbars,width=650,height=350,top='+top+',left='+left);
	}

</script></div>