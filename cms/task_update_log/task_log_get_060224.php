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
							  task_no,							
							service_tag_old,
							service_tag_new,
							subject_old,
							subject_new,
							description_old,
							description_new,
							address_old,
							address_new,
							task_status_old,
							task_status_new,
							entry_by,
							update_by,
							update_date,
							tbl_service_tag.name as tag_name,
							_nisl_mas_member.User_Name as update_name
							FROM
							  `tbl_task_log`
							  left join tbl_service_tag on tbl_service_tag.id=tbl_task_log.service_tag_new
							    left join _nisl_mas_member on _nisl_mas_member.User_ID=tbl_task_log.update_by

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
            <table id='result_tbl' border='1' class='table table-bordered '   >
            <tr>
				<th align='center' class='title_cell_e' >Task Number</th>
					<th align='center' class='title_cell_e' >Old Service Tag</th>
				<th align='center' class='title_cell_e' >New Service Tag</th>
				<th align='center' class='title_cell_e' >Old Subject</th>
				<th align='center' class='title_cell_e'  >New Subject</th>
				<th align='center' class='title_cell_e'  >Old Description</th>
				<th align='center' class='title_cell_e'  >New Description</th>
				<th align='center' class='title_cell_e'  >Old Address</th>
				<th align='center' class='title_cell_e'  >New Address</th>
				<th align='center' class='title_cell_e'  >Update By</th>
				
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
