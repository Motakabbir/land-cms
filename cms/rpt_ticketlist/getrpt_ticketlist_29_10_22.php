<div class="clr"></div>
<div class="row">



<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
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
 	if($_REQUEST['division_id']!=''){
	 	$ehead .=' বিভাগ= '.pick('tbl_division','name','id ='.$_REQUEST['division_id'].'').', ';
 		$cond .=" AND tbl_task.division='".$_REQUEST['division_id']."'";
 	}
 }
if(isset($_REQUEST['district']) && $_REQUEST['district'] !='-1'){
	if($_REQUEST['district']!=''){
		$ehead .=' জেলা= '.pick('tbl_district','name','id ='.$_REQUEST['district'].'').', ';
	 	$cond .=" AND tbl_task.district='".$_REQUEST['district']."'";
 	}
 }

if(isset($_REQUEST['upozila']) && $_REQUEST['upozila'] !='-1'){
	if($_REQUEST['upozila']!=''){
		$ehead .=' উপজেলা = '.pick('tbl_upozila','name','id ='.$_REQUEST['upozila'].'').', ';
 		$cond .=" AND tbl_task.upozila='".$_REQUEST['upozila']."'";
	}
	
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
							tbl_task.task_id,
							tbl_task.task_no,
							tbl_problem.prob_name as prob_type,
							tbl_task.subject,
							tbl_task.description,
							DATE_FORMAT(tbl_task.open_date,'%d/%m/%Y') as open_date1,
							DATE_FORMAT(tbl_task.close_date,'%d/%m/%Y') as close_date,
							DATE_FORMAT(tbl_task.open_date,'%d/%m/%Y %h:%i') as down_time,
							DATE_FORMAT(tbl_task.close_date,'%b %d %Y %h:%i') as close_date_time,
							tbl_taskstatus.task_statusname as task_status,
							mas_department.department as task_department,
							tbl_taskpriority.task_priorityname as task_priority,
							_nisl_mas_member.User_Name as created_by,
							tbl_task.schedule_id,
							tbl_task.que_status,
							t1.User_Name as solv_by,
							tbl_task.solv_solution,
							tbl_task.contact_person,
							tbl_task.contact_number,
							tbl_task.entry_by,
							tbl_task.entry_date,
							tbl_task.update_by,
							tbl_task.update_date,
							tbl_service_type.prob_name,
                            tbl_division.name as div_name,
                            tbl_district.name AS dis_name,
                            tbl_upozila.name AS upo_name
						FROM 
							tbl_task						
							LEFT JOIN tbl_problem ON  tbl_problem.prob_id = tbl_task.prob_type
							LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type
							LEFT JOIN tbl_taskstatus ON  tbl_taskstatus.task_statusid = tbl_task.task_status
							LEFT JOIN mas_department ON  mas_department.depart_id = tbl_task.task_department
							LEFT JOIN tbl_taskpriority ON  tbl_taskpriority.task_priorityid = tbl_task.task_priority
                            left join tbl_division on tbl_division.id=tbl_task.division
							left join tbl_district on tbl_district.id=tbl_task.district and tbl_district.division_id =tbl_division.id
							left join tbl_upozila on tbl_upozila.id=tbl_task.upozila and
								  `tbl_upozila`.`division_id`=tbl_division.id
							LEFT JOIN _nisl_mas_member ON  _nisl_mas_member.User_ID = tbl_task.created_by
							LEFT JOIN _nisl_mas_member as t1 ON  t1.User_ID = tbl_task.solv_by
							where 1=1
							$cond
							Order By tbl_division.id asc,tbl_district.id asc, tbl_upozila.id";
		//echo $SeNTlist1;
		
		
		
      $rSeNTlist1=mysql_query($SeNTlist1) or die();
      $numrows=mysql_num_rows($rSeNTlist1);
      if($numrows>0)
      {
       $i=0;
	   
	   echo "<div id='dvContainer'>";
       drawCompanyInformationDiv("কলের তথ্য ",$ehead);
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '  width='100%' cellpadding=\"0\" cellspacing=\"0\">
            <tr>
						<th align='justify'   > কলের আইডি নম্বর</th>
						<th align='justify'   > নাম</th>
						<th align='justify'   > কলের তারিখ </th>
						<th align='justify'   > সেবার ধরণ</th>
						<th align='justify'   > বিবরণ</th>
						<th align='justify'   > মোবাইল নম্বর</th>
						<th align='justify'   > বর্তমান অবস্থা</th>
						
            </tr>
            ";
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
           
					  
				if($div_name!=$ndiv_name){
                ?>
                <tr>
                	<th>বিভাগ</th>
                    <th colspan="6"><?php echo $div_name;?></th>
                </tr>
                <?php }
				if($dis_name!=$ndis_name){
                ?>
                <tr>
                	<th >জেলা</th>
                    <th colspan="6"><?php echo $dis_name;?></th>
                </tr>
                <?php }
				if($upo_name!=$nupo_name){
                ?>
                <tr>
                	<th>উপজেলা</th>
                    <th colspan="6"><?php echo $upo_name;?></th>
                </tr>
                <?php }?>
                      <TR >
						<td align='left' >
							<?php echo bn2enNumber ($task_no); ?>
						</td>
						<td align='justify' >
							<?php echo $contact_person; ?>
						</td>
						<td align='left'  >
							<?php echo bn2enNumber ($down_time); ?>
						</td>
						<td align='justify'  >
							<?php echo $prob_name; ?>
						</td>
						<td align='justify'  >
							<?php echo $description; ?>
						</td>
						<td align='left'  >
							<?php echo bn2enNumber ($contact_number); ?>
						</td>
						<td align='justify' >
							<?php echo $task_status; ?>
						</td>
						
						
                        
						</TR>
                   <?php
				$ndiv_name=$div_name;
				$ndis_name=$dis_name;
				$nupo_name=$upo_name;
					  $i++;
            }
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