<style>
 	.tabs-75 .tab_content {
		font-size: 14px;
		color: #000000;
		text-align: left;
		background-color: #FFFFFF;
		line-height: 20px;
		width: 100%;
	}
	.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 0;
    border-radius: 4px;
    float: right;
}
</style>	
<?php 
include_once "../../Library/SessionValidate.php";
include "../../pagination.php";

	if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
		$actionfunction = $_REQUEST['actionfunction'];
		$limit=10;
	   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
	}

function showData($data, $con, $limit, $adjacent){
$page = $data['page'];
$cond='';
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
$cond=' where 1=1';
 $pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
 $due=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
 $overdue=pick('tbl_progressstatus','duration','tbl_progressstatus.id=3');

include_once("user_session");
 echo $SUserID;
function time_elapsed_string($datetime, $full = false) {
	date_default_timezone_set("Asia/Dhaka");
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'বছর',
        'm' => 'মাস',
        'w' => 'সপ্তাহ',
        'd' => 'দিন',
        'h' => 'ঘন্টা',
        'i' => 'মিনিট',
        's' => 'সেকেন্ড',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' পূর্বে' : 'এক্ষুনি';
}
$SUserID = $_SESSION['SUserID'];
$SType=$_SESSION['SType'];


if(isset($_REQUEST['txtclients_id']) && $_REQUEST['txtclients_id'] !="-1"){
$cond.=" AND tbl_task.clients_id='".$_REQUEST['txtclients_id']."'";
}
if(isset($_REQUEST['txtclients_servid']) && $_REQUEST['txtclients_servid'] !="-1"){
$cond.=" AND tbl_task.clients_servid='".$_REQUEST['txtclients_servid']."'";
}
if(isset($_REQUEST['service_type']) && $_REQUEST['service_type'] >"0"){
$cond.=" AND tbl_task.service_type='".$_REQUEST['service_type']."'";
}
if(isset($_REQUEST['division_id']) && $_REQUEST['division_id'] >"0"){
 	$cond.=" AND tbl_task.division='".$_REQUEST['division_id']."'";
 }
if(isset($_REQUEST['district']) && $_REQUEST['district'] >"0"){
 	$cond.=" AND tbl_task.district='".$_REQUEST['district']."'";
 }
if(isset($_REQUEST['upozila']) && $_REQUEST['upozila'] >"0"){
 	$cond.=" AND tbl_task.upozila='".$_REQUEST['upozila']."'";
 } 
 
 if(isset($_REQUEST['filter']) && $_REQUEST['filter'] !=""){
	 if($_REQUEST['serch_by']=='ticket'){
 		$cond.=" AND (tbl_task.task_no like '%".$_REQUEST['filter']."%'  OR clients_info.mobile1 like '%".$_REQUEST['filter']."%')";
	 }
 }
 if(isset($_REQUEST['txttask_department']) && $_REQUEST['txttask_department'] >0){
 	$cond.=" AND tbl_task.task_department ='".$_REQUEST['txttask_department']."'";
 }
if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=""){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
  if($cond!=NULL){
 	$cond.=" AND (DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')<='".$txttoopen_date."')";
 	}else{
	$cond=" WHERE (DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')<='".$txttoopen_date."')";}
 }
// echo $cond;

 if($cond==' where 1=1'){
	// $limit='Limit 100';
	// $head="সর্বশেষ ".bn2enNumber (100)." অভিযোগ";
	
	 }
?>
<style>
	.blog-body {
    padding: 15px;
    /* position: relative; */
    overflow: inherit;
    border: 1px solid #dfe6ee;
}
</style>
<table class="table table-bordered table-condensed table-striped table-hover" >
	<thead>
		<tr>
			<th>কলের আইডি নম্বর</th>
			<th>বিষয়</th>
			<th>বর্তমান কার্যক্রম </th>
			<th>বর্তমান অবস্থা</th>
			<th>ক্রিয়া</th>    
		</tr>
	</thead>
    <tbody>
	<?php

	 if($page==1){
	    $start = 0;
	  }
	  else{
	 	$start = ($page-1)*$limit;
	  }
	$count_query   = mysql_query("SELECT COUNT(*) AS numrows FROM `tbl_task`
					LEFT JOIN  tbl_taskpriority ON tbl_taskpriority.task_priorityid = tbl_task.task_priority
					LEFT JOIN  tbl_taskstatus ON tbl_taskstatus.task_statusid = tbl_task.`task_status`  $cond and tbl_task.task_status=4");
	$row     = mysql_fetch_array($count_query);
	$Countrow = $row['numrows'];
 
	$res = mysql_query("SELECT
							  `task_id`,
							  `task_no`,
							  `subject`,
							  tbl_taskpriority.task_priorityname,
							 
							  DATEDIFF(NOW(),
							  tbl_task.`open_date`) AS diff,
							  tbl_taskstatus.task_statusname,
							  tbl_task.description,
							  CASE 
							   WHEN  datediff(NOW(),open_date) < ".$pen."  THEN  '15'
							  WHEN  (datediff(NOW(),open_date) > ".$pen.") AND (datediff(NOW(),open_date) <".$due.") THEN  '30'
							  WHEN  datediff(NOW(),open_date) >".$due."  THEN  '30+'
							  ELSE '0'
							  END AS  tdays,
							  tbl_taskstatus.class_color,
							  task_priority_change,
							  `tbl_taskpriority`.`cl_code`,
							  tbl_taskpriority.task_priorityid,
							  tbl_task.service_type
							FROM
							  `tbl_task`
							LEFT JOIN  tbl_taskpriority ON tbl_taskpriority.task_priorityid = tbl_task.task_priority
							LEFT JOIN  tbl_taskstatus ON tbl_taskstatus.task_statusid = tbl_task.`task_status`
						$cond and tbl_task.task_status=4 order by tbl_taskpriority.task_priorityid desc,open_date asc LIMIT $start,$limit ");
						
	
	$i = 1;
	while ($row = mysql_fetch_array($res))
	{
		 extract($row);
	?>
	<tr style="background: <?php echo $cl_code;?>" >
			<td><?php echo $task_no;?></td>
			
			<td ><?php echo readMore($subject, '100');?></td>
		
			<td><?php echo $last_comments;?></td>
			
			<td><span class="label label-<?php echo $class_color;?>"><?php echo $task_statusname ."</span>";  if($tdays=='15'){ ?> <span class="label label-success "><?php echo bn2enNumber($tdays);?></span><?php  }elseif($tdays=='30'){ ?> <span class="label label-warning "><?php echo bn2enNumber($tdays);?></span><?php  }elseif($tdays=='30+'){ ?> <span class="label label-danger "><?php echo bn2enNumber($tdays);?></span><?php  }
			
			if($task_priorityid==1){?> <img style="width: 20px;" src="green_flag.jpg" alt=""><?php }elseif($task_priorityid==2){?> <img style="width: 20px;" src="orange_flag.png" alt=""><?php }elseif($task_priorityid==3){?> <img style="width: 20px;" src="red_flag.png" alt=""><?php }?>
			</td>
			<td>
		<?php	if($SType ==36)
			{
				?>
			<button type="button"  class="btn btn-primary btn-sm" onclick="update_task(<?php echo $task_id;?>)" data-toggle="modal" data-target="#myModalsmall"><i class="fa fa-share" aria-hidden="true"></i> টিকিট খুলুন</button> 
			<?php
			}
			?>
			
			
	<!--		<a href="#" class="btn btn-warning btn-xs send1" data-id="<?php echo $task_id;?>" >Open Ticket </a> -->
				
			</td>
		</tr>
	
	<?php
	$i++;
	}
	?>	
    </tbody>
</table>
<?php echo '<div class=\'col-sm-4 pl0 pr0\'>Showing '.number_format($start+1).' to ' .number_format($start+$i-1).  ' of '.number_format($Countrow).' entries </div>';		
	echo "<div class=\"col-sm-8 pl0 pr0\"><nav aria-label=\"Page navigation\">";
     pagination($limit,$adjacent,$Countrow,$page, 'all_gmt_ticket_get.php' , '#tab43');
	 echo "</nav></div><br>";
	}

?>
<script>
	
    $(document).ready(function () { 
          $('a.send1').click(function() {			  
			  var mid = $(this).data('id');   
			  var cid = $(this).data('client_id');
			 // console.log(mid);
			 // console.log(cid);
               $('body').append($('<form/>', {
                    id: 'form',
                    method: 'POST',
                    action: 'ticket_details_gmt.php'
               }));

               $('#form').append($('<input/>', {
                    type: 'hidden',
                    name: 'id',
                    value: mid
               }));
              
              $('#form').submit();
               return false;
          });
     } );
	 
	 function update_task(task_id) {
 //alert(task_id);
  $.ajax({
	 type: "POST",
	 url: "task_update_modal.php",
	 data: {
		task_id : task_id,
		shedule : 1
	 },
	 success: function (response)
	 {   
		$( '#small_modal' ).html(response);
	 }
  });
}

</script>

                    