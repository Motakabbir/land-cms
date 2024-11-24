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
									LEFT JOIN  _nisl_mas_member ON _nisl_mas_member.User_ID = tbl_task.claim_by
									LEFT JOIN  tbl_taskstatus ON tbl_taskstatus.task_statusid = tbl_task.`task_status`
									LEFT JOIN tbl_service_type ON tbl_service_type.prob_id=tbl_task.service_type
				".$Condition." order by tbl_task.open_date desc";
		//echo $query;
		//exit;
		$ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());
		?>
		</br>
                    <table class="table table-condensed table-bordered" cellpadding="0" cellspacing="0" style="width:100%">
                    	<thead>
                        	<tr>
                            	<th>আইডি</th>
                            	<th>বিষয়</th>
                            	<th>অভিযোগের সময়</th>
                            	<th>বর্তমান অবস্থা</th>
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
                            	
                            	<td><span class="label label-<?php echo $class_color;?>"><?php echo $task_statusname ."</span>"; if($diff>1){?> <img style="width: 20px;" src="red_flag.png" alt=""><?php }?> <span class="badge"><?php echo $tdays;?></span></td>
                                <td>
                                	<a href="#" class="btn btn-warning btn-xs send" data-id="<?php echo $task_id;?>" >বিস্তারিত </a>
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
	
?>