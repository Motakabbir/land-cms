<?php
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';

$mode=$_POST["mode"];


if(isset($_POST["txtcontact_number"]) && !empty($_POST["txtcontact_number"])){
	 $pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
	 $due=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
	 $overdue=pick('tbl_progressstatus','duration','tbl_progressstatus.id=3');
	$txtcontact_number=$_POST["txtcontact_number"];
	$Condition='where contact_number="'.$txtcontact_number.'"';
	
	$query="SELECT
			  `task_id`,
			  `task_no`,
			  `subject`,
			  tbl_taskpriority.task_priorityname,
			  _nisl_mas_member.User_Name AS claim_by_name,
			  tbl_task.`entry_date`,
			  DATEDIFF(NOW(),
			  tbl_task.`entry_date`) AS diff,
			  tbl_task.`update_date`,
			  tbl_taskstatus.task_statusname,
			  tbl_task.description,
			  tbl_task.contact_number,
			  tbl_taskpriority.color,
			  tbl_task.`task_status`,
			  tbl_task.service_type,
			  tbl_service_type.end_user,
			  CASE 
			  WHEN  datediff(entry_date,NOW()) < ".$pen."  THEN  '15'
			  WHEN  (datediff(entry_date,NOW()) > ".$pen.") AND (datediff(entry_date,NOW()) <".$due.") THEN  '30'
			  WHEN  datediff(entry_date,NOW()) >".$due."  THEN  '30+'
			  ELSE '0'
			  END AS  tdays,
			  tbl_taskstatus.class_color
			FROM
			  `tbl_task`
			LEFT JOIN  tbl_taskpriority ON tbl_taskpriority.task_priorityid = tbl_task.task_priority
			LEFT JOIN  _nisl_mas_member ON _nisl_mas_member.User_ID = tbl_task.entry_by
			LEFT JOIN  tbl_taskstatus ON tbl_taskstatus.task_statusid = tbl_task.`task_status`
			LEFT JOIN tbl_service_type ON tbl_service_type.prob_id=tbl_task.service_type
			".$Condition." order by tbl_task.open_date desc";
	
	$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());


	$newsql="SELECT `prob_id` FROM `tbl_service_type` WHERE `srv_type`=1";
	$NewResultSet= mysql_query($newsql) or die("Invalid query: " . mysql_error());

	$servdata=array();
	while ($Newrow = mysql_fetch_assoc($NewResultSet)){
		//$servdata=$servdata+$Newrow;	
		 array_push( $servdata,$Newrow['prob_id']);
	}

	


	?>
	</br>
               <table class="table table-condensed table-bordered" cellpadding="0" cellspacing="0" style="width:100%">
               	<thead>
                   	<tr>
                       	<th>আইডি</th>
                       	<th>বিষয়</th>
                       	<th>অভিযোগের সময়</th>
                       	<th>বর্তমান অবস্থা</th>
                       	<th>এজেন্টের নাম</th>
                           <th>ক্রিয়া</th>
                       </tr>
                   </thead>
                   <tbody>
                   <?php 
					
					$i = 1;
					while ($row = mysql_fetch_array($ResultSet))
					{
                  			extract($row);
					?> 
					<tr class="<?php echo $color;?>" >
                       	<td><?php echo $task_no;?></td>
                       	
                       	<td ><?php echo readMore($subject, '100');?></td>
                       
                       	<td><?php echo $entry_date;?></td>
                       	
                       	<td>
                       		<span class="label label-<?php echo $class_color;?>"><?php echo $task_statusname ."</span>"; if($diff>1){?> 
                       		<img style="width: 20px;" src="red_flag.png" alt=""><?php }?> <span class="badge"><?php echo $tdays;?></span>

                       	</td>
                       	<td><?php echo $claim_by_name;?></td>
                           <td>
                           	<button type="button" id="btn1" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal " onclick="showDetails(<?php echo $task_id;?>)" ><i class="fa fa-info-circle"></i> বিস্তারিত</button>
                           	
                           	<?php if($task_status==1 && in_array($service_type, $servdata)){
                           		?>
                           	<button type="button" id="btn1" class="btn btn-success btn-sm"  onclick="reopen(<?php echo $task_id;?>)" ><i class="fa fa-refresh" aria-hidden="true"></i> পুনরায় শুরু</button>
                           	<?php } ?>
                           </td>
                       </tr>
					<?php 
					}
					?>
                   </tbody>
               </table>
		<script>
       	    $(document).ready(function () { 
     $('a.send').click(function() {			  
		  var mid = $(this).data('id');   
		  var cid = $(this).data('client_id');
		 // console.log(mid);
		 // console.log(cid);
          $('body').append($('<form/>', {
               id: 'form',
               method: 'POST',
               action: '../all_ticket/ticket_details.php'
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

       </script>						
<?php
}


if(isset($_POST["txtclients"]) && !empty($_POST["txtclients"])){
	$txtclients=$_POST["txtclients"];
	$Condition='where clients_info.id='.$txtclients;
	
	$query="SELECT 
				clients_info.mobile1,clients_info.email,address
			FROM clients_info
           ".$Condition;
	
	$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
	
   while ($qry_row=mysql_fetch_array($ResultSet))
   {
		extract($qry_row);
   }
	$data=array('mobile'=>$mobile1,'email'=>$email,'address'=>$address);

	echo  json_encode($data);					
}


if(isset($_POST["service_type"]) && !empty($_POST["service_type"])){
	$service_type=$_POST["service_type"];
	
	
	$query="SELECT  
			  `show_problem`,
			  `show_upozila`,
			  `end_user`
			FROM
			  `tbl_service_type`
			WHERE 
			   `prob_id`='".$service_type."'";
	
	$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
	
   while ($qry_row=mysql_fetch_array($ResultSet))
   {
		extract($qry_row);
   }
	$data=array('show_problem'=>$show_problem,'show_upozila'=>$show_upozila,'end_user'=>$end_user);

	echo  json_encode($data);					
}

if(isset($_POST["txtclients_servid_trn"]) && !empty($_POST["txtclients_servid_trn"])){
	$txtclients_servid_trn=$_POST["txtclients_servid_trn"];
	$Condition='where trn_clients_service.srv_id='.$txtclients_servid_trn;
	
	 $query="SELECT 
				clients_info.mobile1,clients_info.email,clients_info.address,clients_info.id 
			FROM clients_info
			 LEFT JOIN trn_clients_service On trn_clients_service.client_id=clients_info.id 
           ".$Condition;
	
	$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
	
   while ($qry_row=mysql_fetch_array($ResultSet))
   {
		extract($qry_row);
   }
	$data=array('mobile'=>$mobile1,'email'=>$email,'address'=>$address,'client_id'=>$id);

	echo  json_encode($data);					
}


if(isset($_POST["service_types"]) && !empty($_POST["service_types"])){
	echo pick('tbl_service_type','prob_name',"prob_id=".$_POST["service_types"]);
}

if(isset($_POST["mobile"]) && !empty($_POST["mobile"])){
	$mobile=$_POST["mobile"];
	
	
	 $query="SELECT
				  `mobile`,
				  tbl_citizen.`name`,
				  `email`,
				  `address`,
				  tbl_division.id AS division_bbs,
				  tbl_district.id as district_bbs,
				  tbl_upozila.id as upozila_bbs,
				  `pasword`
				FROM `tbl_citizen`
				LEFT JOIN tbl_division ON tbl_division.division_bbs_code = tbl_citizen.division_bbs
				LEFT JOIN tbl_district on tbl_district.district_bbs_code=tbl_citizen.district_bbs
				LEFT JOIN tbl_upozila ON tbl_upozila.upozila_bbs_code=tbl_citizen.upozila_bbs and tbl_upozila.district_bbs_code=tbl_citizen.district_bbs
			WHERE 
			   `mobile`='".$mobile."'";
	
	 $ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
	$rowcount=mysql_num_rows($ResultSet);
	if($rowcount>0){
		while ($qry_row=mysql_fetch_assoc($ResultSet))
        {
			

			extract($qry_row);
			$data=$qry_row+array('status'=>200);
        }
	}else{
		$data=array('status'=>402);
	}
   


	echo  json_encode($data);					
}

if(isset($_POST["task_id"]) && !empty($_POST["task_id"])){
	$task_id=$_POST["task_id"];
	 $query="SELECT
				  `task_id`,
				  `task_no`,
				  `clients_id`,
				  `contact_number`,
				  `clients_servid`,
				  `router_id`,
				  `switch_id`,
				  `contact_person`,
				  `contact_person_no`,
				  `email`,
				  `prob_type`,
				  `service_type`,
				  `subject`,
				  `description`,
				  `open_date`,
				  `close_date`,
				  `task_status`,
				  `task_department`,
				  `task_priority`,
				  `task_type`,
				  `created_by`,
				  `schedule_id`,
				  `entry_by`,
				  `entry_date`,
				  `update_by`,
				  `update_date`,
				  `que_status`,
				  `claim_by`,
				  `claim_time`,
				  `down_time`,
				  `solv_by`,
				  `solv_solution`,
				  `note`,
				  `scheduled_to`,
				  `scheduled_department`,
				  `schedule_to_comments`,
				  `scheduled_date`,
				  `scheduled_by`,
				  `mobile_no`,
				  `address`,
				  `note_by`,
				  `note_date`,
				  `block_email`,
				  `email_block_by`,
				  `email_block_date`,
				  `division`,
				  `district`,
				  `upozila`,
				  `others_problem`,
				  `task_priority_change`,
				  `google_id`,
				  `fb_id`,
				  `nid`
				FROM
				  `tbl_task`
				WHERE  `task_id`='".$task_id."'";
	
	$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
	$rowcount=mysql_num_rows($ResultSet);
	if($rowcount>0){
		while ($qry_row=mysql_fetch_assoc($ResultSet))
        {
			extract($qry_row);
			$data=$qry_row+array('status'=>200);
        }
	}else{
		$data=array('status'=>402);
	}        
	echo  json_encode($data);					
}

?>