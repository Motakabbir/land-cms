
<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';

session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SDesignation = $_SESSION['SDesignation'];
$division_id = $_REQUEST['division_id'];
$district = $_REQUEST['district'];
$upozila = $_REQUEST['upozila'];
$role = $_REQUEST['role'];

$cond=' where 1=1';

 $ehead='';

 if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
	$ehead .="<br>তারিখ ".bn2enNumber ($_REQUEST['txtfromopen_date'])." থেকে ".bn2enNumber ($_REQUEST['txttoopen_date']);
 	$cond.=" AND (DATE_FORMAT(tbl_access_log.time,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_access_log.time,'%Y-%m-%d')<='".$txttoopen_date."')";
 }

	
 if(isset($_REQUEST['division_id']) && $_REQUEST['division_id'] !='-1' ){
	$ehead .=' বিভাগ= '.pick('tbl_division','name','id ='.$_REQUEST['division_id'].'').', ';
 	$cond .=" AND tbl_access_log.division='".$_REQUEST['division_id']."'";
}

if(isset($_REQUEST['district']) && $_REQUEST['district'] !='-1'){	
	$ehead .=' জেলা= '.pick('tbl_district','name','id ='.$_REQUEST['district'].'').', ';
 	$cond .=" AND tbl_access_log.district='".$_REQUEST['district']."'";
}

if(isset($_REQUEST['upozila']) && $_REQUEST['upozila'] !='-1'){	
	$ehead .=' উপজেলা = '.pick('tbl_upozila','name','id ='.$_REQUEST['upozila'].'').', ';
 	$cond .=" AND tbl_access_log.upojila='".$_REQUEST['upozila']."'";
} 

if(isset($_REQUEST['role']) && $_REQUEST['role'] !='-1'){
	$ehead .=' পদবী = '.$_REQUEST['role'].', ';
 	$cond .=" AND tbl_access_log.designation like '%".$_REQUEST['role']."%'";
} 	
if(isset($_REQUEST['role']) && $_REQUEST['role'] !='-1'){
	$ehead .=' পদবী = '.$_REQUEST['role'].', ';
 	$cond .=" AND tbl_access_log.designation like '%".$_REQUEST['role']."%'";
}
if(isset($_REQUEST['status']) && $_REQUEST['status'] !='-1'){
	$ehead .=' অবস্থা = '.$_REQUEST['status'].', ';
 	$cond .=" AND tbl_access_log.status like '%".$_REQUEST['status']."%'";
}  

 if(isset($_REQUEST['data']) &&  $_REQUEST['data'] !=''){
	$ehead .=' অন্যান্য = '.$_REQUEST['data'].', ';
 	$cond .=" AND tbl_access_log.emp_name like '%".$_REQUEST['data']."%' or  tbl_access_log.emp_name_bn like '%".$_REQUEST['data']."%' or tbl_access_log.designation like '%".$_REQUEST['data']."%' or tbl_access_log.user_name like '%".$_REQUEST['data']."%'";
	 //print_r($target);
 }





 echo "<div id='dvContainer'>";
       drawCompanyInformationDiv("Access Log",$ehead);
	$SeNTlist1="SELECT
				tbl_access_log.`id`, 
				`user_name`,
				`ipaddress`, 
				`time`, 
				`return_data`,
				tbl_access_log.status,
				tbl_division.name as div_name,
				tbl_district.name AS dis_name,
				tbl_upozila.name AS upo_name,
				`emp_name`,
				`emp_name_bn`,
				`emp_id`,
				`email`,
				`mobile`,
				`designation`
			FROM `tbl_access_log` 
			LEFT JOIN tbl_division ON tbl_division.id=tbl_access_log.division
                  LEFT JOIN tbl_district ON tbl_district.id=tbl_access_log.district
                  LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_access_log.upojila
			$cond
			Order By tbl_access_log.id desc";
	//echo $SeNTlist1;
		
		
		
      $rSeNTlist1=mysql_query($SeNTlist1) or die();
      $numrows=mysql_num_rows($rSeNTlist1);
      if($numrows>0)
      {
       $i=0;
	   
	  
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '>
            <tr>
		<th align='center'> SL</th>
		<th align='center'> ব্যবহারকারীর নাম</th>
		<th align='center'> নাম</th>
		<th align='center'> মুঠোফোন</th>
		<th align='center'> ইমেইল</th>
		<th align='center'> বিভাগ </th>
		<th align='center'> জেলা </th>
		<th align='center'> উপজেলা</th>
		<th align='center'> পদবী </th>
		<th align='center'> আইপি ঠিকানা</th>
		<th align='center'> লগইন সময় </th>
		<th align='center'> স্ট্যাটাস </th>
						
            </tr>
            ";
			$i=1;
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
            ?>
			<tr>
				<td align='left' >
					<?php echo $i; ?>
				</td>
				<td align='left' >
					<?php echo $user_name; ?>
				</td>
				<td align='left' >
					<?php echo $emp_name; ?>
				</td>
				<td align='left' >
					<?php echo $mobile; ?>
				</td>
				<td align='left' >
					<?php echo $email; ?>
				</td>
				<td align='left' >
					<?php echo $div_name; ?>
				</td>
				<td align='left' >
					<?php echo $dis_name; ?>
				</td>
				<td align='left' >
					<?php echo $upo_name; ?>
				</td>
				<td align='left' >
					<?php echo $designation; ?>
				</td>
				<td align='left' >
					<?php echo $ipaddress; ?>
				</td>
				<td align='left'  >
					<?php echo $time; ?>
				</td>
					<td align='left'  >
					<?php echo $status; ?>
				</td>
			</tr>
		<?php 
			$i++; 
            }

			echo"</table> </div>";
      }
	  else{
	  echo "<center><b> তথ্য পাওয়া যায়নি.....</b>";
	  }



?>
<span style="color:red"></span>