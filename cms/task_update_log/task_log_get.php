<style>
h5 {
  text-align: center;
}
</style>

<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
include "pagination.php";

if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
		$actionfunction = $_REQUEST['actionfunction'];
	   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
	}
function showData($data,$con,$limit,$adjacent){
	 global $conn;
	  $page = $data['page'];
	  $cond='';
session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SDesignation = $_SESSION['SDesignation'];

$cond='';

if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
if($cond!=NULL){
	$cond.=" AND (DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')<='".$txttoopen_date."')";
	}else{$cond=" WHERE (DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')<='".$txttoopen_date."')";}
 }

 
	
if($page==1){
	   $start = 0;
	  }
	  else{
	  $start = ($page-1)*$limit;
	  }
		$count_query   = mysqli_query($conn, "SELECT COUNT(*) AS numrows FROM  `tbl_task_log`
							 $cond");
		$row     = mysqli_fetch_array($count_query);
		 $Countrow = $row['numrows'];	
			
				$SeNTlist1="SELECT							  
							tbl_task_log.service_tag_old,
							tbl_task_log.service_tag_new,
							tbl_task_log.subject_old,
							tbl_task_log.subject_new,
							tbl_task_log.description_old,
							tbl_task_log.description_new,
							tbl_task_log.address_old,
							tbl_task_log.address_new,
							tbl_task_log.task_status_old,
							tbl_task_log.task_status_new,
							tbl_task_log.entry_by,
							tbl_task_log.update_by,
							tbl_task_log.update_date,
							tbl_task.task_no,	
							tbl_service_tag.name as tag_name,
							_nisl_mas_member.User_Name as update_name,
							DATE_FORMAT(tbl_task.open_date,'%d/%m/%Y %h:%i') as down_time,
							tbl_division.name as division,
							tbl_district.name as district,
							tbl_upozila.name as upozila,
							tbl_task.contact_number as contact_number,
							tbl_problem.prob_name as prob_name,
							tbl_service_type.prob_name as service_name,
							tbl_task.contact_person as contact_person
				
							FROM
							  `tbl_task_log`
							  left join tbl_service_tag on tbl_service_tag.id=tbl_task_log.service_tag_new
							  left join tbl_task on tbl_task.task_id=tbl_task_log.task_no
							    left join _nisl_mas_member on _nisl_mas_member.User_ID=tbl_task_log.update_by
							LEFT JOIN tbl_division ON tbl_division.id=tbl_task.division
                            LEFT JOIN tbl_district ON tbl_district.id=tbl_task.district
                            LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_task.upozila
							LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type
							LEFT JOIN tbl_problem ON  tbl_problem.prob_id = tbl_task.prob_type

							$cond order by update_date desc LIMIT $start,$limit ";
	//echo $SeNTlist1;
	
      $rSeNTlist1=mysqli_query($conn, $SeNTlist1) or die();
      $numrows=mysqli_num_rows($rSeNTlist1);
      if($numrows>0)
      {
		  
		  		?>

						,<br><h5 class="blog-title">জিএমটি  লগ </h5> <br>

	<?php
       $i=0;
            echo "
            <table id='result_tbl' border='1' class='table table-bordered table-responsive'   >
            <tr>
				<th align='center' class='title_cell_e' >কলের আইডি নম্বর</th>
				<th align='center' class='title_cell_e' >কলের তারিখ</th>
				<th align='center class='title_cell_e'   > নাম</th>
				<th align='center' class='title_cell_e' > মোবাইল নম্বর</th>
				<th align='center' class='title_cell_e' > বিভাগ</th>
				<th align='center' class='title_cell_e' > জেলা</th>
				<th align='center' class='title_cell_e' > উপজেলা</th>
				<th align='center' class='title_cell_e' > সেবার ধরণ</th>
				<th align='center' class='title_cell_e' > সমস্যার ধরন</th>
				<th align='center' class='title_cell_e' >পুরাতন সার্ভিস  ট্যাগ</th>
				<th align='center' class='title_cell_e' >নতুন সার্ভিস  ট্যাগ</th>
				<th align='center' class='title_cell_e' >পুরাতন বিষয় </th>
				<th align='center' class='title_cell_e'  >নতুন বিষয় </th>
				<th align='center' class='title_cell_e'  >পুরাতন বিবরণ</th>
				<th align='center' class='title_cell_e'  >নতুন বিবরণ</th>
				<th align='center' class='title_cell_e'  >পুরাতন ঠিকানা </th>
				<th align='center' class='title_cell_e'  >নতুন ঠিকানা </th>
				<th align='center' class='title_cell_e'  >আপডেট কারীা</th>
				
            </tr>
            ";
            while($rows=mysqli_fetch_array($rSeNTlist1))
            {
            extract($rows);
			$service_tag_old_name=pick("tbl_service_tag","name","id=".$service_tag_old."");
                   echo"
                       <TR >
					   <td class='$class' align='left' >
							<font class='Eoutput'>$task_no</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$down_time</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$contact_person</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$contact_number</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$division</font>
						</td>
											   <td class='$class' align='left' >
							<font class='Eoutput'>$district</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$upozila</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$service_name</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$prob_name</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$service_tag_old_name</font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'><code>".$tag_name."</code></font>
						</td>
						<td class='$class' align='left' >
							<font class='Eoutput'>$subject_old</font>
						</td>
						<td class='$class' align='left'  >
							<font class='Eoutput'><code>".$subject_new."</code></font>
						</td>
						<td class='$class' align='left'  >
							<font class='Eoutput'>$description_old</font>
						</td>
						<td class='$class' align='left'  >
							<font class='Eoutput'><code>".$description_new."</code></font>
						</td>
						<td class='$class' align='right'  >
							<font class='Eoutput'> $address_old</font>
						</td>
						<td class='$class' align='right'  >
							<font class='Eoutput'> <code>".$address_new."</code></font>
						</td>
						 <td class='$class' align='right'  >
                              <font class='Eoutput'> $update_name</font>
                               </td>
                                                
						</TR>
                        ";
					  $exinfo='';
					  $i++;
            }
			echo"</table> </div>";
			echo '<div class=\'col-sm-4 pl0 pr0\'>Showing '.number_format($start+1).' to ' .number_format($start+$i-1).  ' of '.number_format($Countrow).' entries </div>';		
	echo "<div class=\"col-sm-8 pl0 pr0\"><nav aria-label=\"Page navigation\">";
     pagination($limit,$adjacent,$Countrow,$page);
	 echo "</nav></div><br>";
      }else{
	  echo "<center><b> Data Not Found.....</b>";
	  }
 
	}
	

?>
