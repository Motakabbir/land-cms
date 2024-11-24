<?php
if(isset($_REQUEST) && $_REQUEST['id']>0){ 
function datediff_task($start_time,$endtime, $full = false) {
    $now = new DateTime($endtime);
    $ago = new DateTime($start_time);

	if(strtotime($endtime)>0 && strtotime($start_time)>0){
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}

session_start();
require_once '../../Library/dbconnect.php';
require_once '../../Library/Library.php';

$id=$_REQUEST['id'];
$Ssuboffice_id = $_SESSION['Ssuboffice_id'];
$Sreseller_id=$_SESSION['reseller_id'];
$SType=$_SESSION['SType'];
$SUserID = $_SESSION['SUserID'];
$system_user_id=pick("mas_employees","emp_id","mas_employees.system_user_id=".$SUserID."");

  $sql="SELECT
		  tbl_task.`task_id`,
		  tbl_task.`task_no`,
		  tbl_task.`clients_id`,
		  tbl_task.`contact_number`,
		  tbl_task.`clients_servid`,
		  tbl_task.`router_id`,
		  tbl_task.`switch_id`,
		  tbl_task.`contact_person`,
		  tbl_task.`contact_person_no`,
		  tbl_task.`email`,
		  tbl_task.`prob_type`,
		  tbl_task.`subject`,
		  tbl_task.`description`,
		  tbl_task.`open_date`,
		  tbl_task.`close_date`,
		  tbl_task.`task_status`,
		  tbl_task.`task_department`,
		  tbl_task.`task_priority`,
		  tbl_task.`task_type`,
		  tbl_task.`created_by`,
		  tbl_task.`schedule_id`,
		  tbl_task.`entry_by`,
		  tbl_task.`entry_date`,
		  tbl_task.`update_by`,
		  tbl_task.`update_date`,
		  tbl_task.`que_status`,		  
		  tbl_task.`claim_time`,
		  tbl_task.`down_time`,
		  tbl_task.`solv_by`,
		  tbl_task.`solv_solution`,
		  tbl_task.`note`,
		  tbl_task.`scheduled_to`,
		  tbl_task.`scheduled_date`,
		  tbl_task.`scheduled_by`,
		  tbl_task.`mobile_no`,
		  tbl_task.`address`,
		  tbl_task.`note_by`,
		  tbl_task.`note_date`,
		  trn_clients_service.user_id,
		  trn_clients_service.link_from,
		  trn_clients_service.area,
		  clients_info.clients_name,
		  tbl_task.claim_by,
		  tbl_task.address,
		  tbl_task.block_email,
		  mas_employees.email as claim_name,
          _nisl_mas_member.User_Name as claim_by_name,
		  a.emp_name as assign_to,
		  mas_department_cms.department,
          tbl_district.name as disname,
          tbl_division.name as divname,
          tbl_upozila.name as upname,
          tbl_service_type.prob_name as sname,
          tbl_problem.prob_name as pname,
		  tbl_task.task_priority_change,
		  tbl_task.service_type,
		  tbl_taskstatus.task_statusname,
		  `tbl_taskpriority`.`task_priorityname`
		FROM `tbl_task`
		LEFT JOIN tbl_taskpriority ON tbl_taskpriority.task_priorityid=tbl_task.task_priority
        LEFT JOIN _nisl_mas_member ON _nisl_mas_member.User_ID=tbl_task.claim_by
		LEFT JOIN mas_employees ON mas_employees.system_user_id=tbl_task.`claim_by`
		LEFT JOIN tbl_taskstatus ON tbl_taskstatus.task_statusid=tbl_task.`task_status`
		LEFT JOIN trn_clients_service ON trn_clients_service.srv_id=tbl_task.clients_servid
		LEFT JOIN clients_info ON clients_info.id=trn_clients_service.client_id
		LEFT JOIN mas_employees AS a ON a.emp_id=tbl_task.scheduled_to
		LEFT JOIN mas_department_cms  ON mas_department_cms.depart_id=tbl_task.task_department
		LEFT JOIN tbl_district ON tbl_district.id=tbl_task.district
        LEFT JOIN tbl_division ON tbl_division.id=tbl_task.division
        LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_task.upozila
        LEFT JOIN tbl_service_type ON tbl_service_type.prob_id=tbl_task.service_type
        LEFT JOIN tbl_problem ON tbl_problem.prob_id=tbl_task.prob_type
		where task_id='$id'";
		$res=mysql_query($sql);  
while ($row = mysql_fetch_array($res)){
                        extract($row);
						}
$last_user_group=pick("tbl_service_type","end_user","prob_id=".$service_type."");	
$last_user_group1=pick("tbl_service_type","end_user1","prob_id=".$service_type."");   					
?>


<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">কলের বিবরণ</h4>
</div>
	<form id="modal_form" name="MyForm">
	<div class="modal-body">
<div class="col-sm-12">
<h4>বিষয় : <?php  echo $subject;?> </h4>
    <div class="row">
        <div class="col-sm-4">
            <div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px;">
           		 <style>
							table.borderTable tr {
					border-bottom: 1px solid #c6d7f9;
				}
				
				table.borderTable td {
					padding: 3px 12px;
				}
				
				
				table.borderTable {
					font-size: 12px;
				}
				</style>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="borderTable">
            	<tr>
            		<td><strong>নাম:</strong></td>
            		<td><?php echo  $contact_person;?></td>
            	</tr>
                <tr>
            		<td><strong>ইমেইল:</strong></td>
            		<td><?php echo  $email;?></td>
            	</tr>
                <tr>
            		<td><strong> যোগাযোগ:</strong></td>
            		<td><?php echo  $contact_number;?></td>
            	</tr>
                <tr>
            		<td><strong>টিকিট আইডি:</strong></td>
            		<td><?php echo  $task_no;?></td>
            	</tr>
                <tr>
            		<td><strong> ঠিকানা :</strong></td>
            		<td><?php echo  $address;?></td>
            	</tr>
                <tr>
                	<td><strong>বর্তমান অবস্থা :</strong></td>
                	<td><?php echo $task_statusname;?></td>
                </tr>
                
                <tr>
                	<td><strong>অগ্রাধিকার :</strong></td>
                    <td><?php echo $task_priorityname;?></td>
                </tr>
            </table>
            </div>
         
        </div>
        <div class="col-sm-4">
        	<div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px;">
           
        	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="borderTable">
            	<tr>
            		<td><strong>কালের তারিখ:</strong></td>
            		<td><?php if(strtotime($down_time)>0){ echo date('d M Y H:i:s',strtotime($down_time));} ?></td>
            	</tr>
               
                <tr>   
            		<td> <strong>সেবার ধরন: </strong></td>
            		<td><?php echo  $sname;?></td>
            	</tr>
                <tr>
            		<td><strong> সমস্যার ধরণ:</strong> </td>
            		<td><?php echo  $pname;?></td>
            		
            	</tr>
                 <tr>
            		<td><strong>বিভাগ: </strong></td>
            		<td><?php echo $divname;?></td>
            	</tr>
                <tr>
            		<td><strong> জেলা: </strong></td>
            		<td><?php echo  $disname;?></td>
            	</tr>
                <tr>
            		<td><strong>উপজেলা: </strong></td>
            		<td><?php echo  $upname;?></td>
            	</tr>
               
            </table>
           </div>
           
        </div>	
        <div class="col-sm-4">
            
         <div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px;">   
         <strong>কলের বিবরণ:</strong> <?php echo  $description;?>
        </div>
        	
        </div>

    </div>
	<style>
    .w3-example {
        background-color: #acc7e8;
        padding: 1px 5px;
        margin: 4px 0;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
    }
    
    .w3-section, .w3-code {
        margin-top: 10px!important;
        margin-bottom: 10px!important;
    }
    .w3-code {
        width: auto;
        background-color: #fff;
        padding: 1px 3px;			
        word-wrap: break-word;
    }
    .w3-left {			
        border-left: 4px solid #4CAF50;			
    }
    .w3-right {			
        border-right: 4px solid #4CAF50;			
    }
    .w3-code, .w3-codespan {
        font-family: Consolas,"courier new";
        font-size: 12px;
    }
    </style>

    <div class="row">
    	<div class="col-sm-4">
        	<div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px; padding: 5px;">
            <strong>  গৃহীত কার্যক্রম </strong>
            <?php if($SType==$last_user_group || $SType==$last_user_group1){?>
            	<div class="row">
                	<div class="col-sm-12">
                    	  
                    </div>
                </div>
               <?php }?>
               
                    <?php 
                    $comsql="SELECT 
                          tbl_task_history.`task_id`,
                          tbl_task_history.`email`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`description`,
                          tbl_task_history.subject,
                          tbl_task_history.`task_status`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`type`,  
                          tbl_task_history.`update_by`,
                          tbl_task_history.`update_date`,
                          mas_employees.emp_name,
                          clients_info.clients_name,
                          _nisl_mas_member.User_Name
                        FROM
                          `tbl_task_history`
                        LEFT JOIN tbl_task ON tbl_task.task_id =tbl_task_history.task_id
                        LEFT JOIN mas_employees on  mas_employees.system_user_id= tbl_task_history.update_by
                        LEFT JOIN _nisl_mas_member on  _nisl_mas_member.User_ID= tbl_task_history.update_by
                        LEFT JOIN clients_info ON clients_info.id=tbl_task_history.update_by
                        WHERE
                         tbl_task_history.`task_id` = $task_id and short_dsc='গৃহীত কার্যক্রম' order by tbl_task_history.`update_date` desc";
                          $res_com=mysql_query($comsql); 
						  $editvalue=mysql_num_rows($res_com); 
                            while ($row_com = mysql_fetch_array($res_com)){
                                        extract($row_com);
                                        if($type=='I'){
                                        ?>
                    <div class="w3-example">
                        <div class="w3-code w3-left notranslate htmlHigh">
                            <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span> <span class="commentcolor" >
                                    <?php echo $emp_name .'('.$User_Name.')'?> </span> <br>
                                    <span style="color: #86001f; font-size: 11px; font-family: Consolas,"courier new";"> <?php echo date('d M Y h:i:s A',strtotime($update_date));?></span>
                                    <p style="border-top:2px solid "><?php echo $description?></p>
                                </div>
                               
                            </div>
                    </div></div>
                    <?php 
                    }else{
                    ?>
                    <div class="w3-example">
                        <div class="w3-code w3-right notranslate htmlHigh">
                        <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span><span class="commentcolor" style="color:#191919; font-size:10px; font-family: Consolas,"courier new";">
                                    <?php echo $clients_name;?><br>
                                    <?php echo date('d M Y h:i:s A',strtotime($update_date));?>
                                  </span>  
                                    <p><?php echo $description?></p>
                                </div>
                                
                            </div>
                     </div></div>
                    <?php 	
                        }
                    }
                    ?> 
			</div>
        </div>
        <div class="col-sm-4">
        	<div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px; padding: 5px;">
             <strong>  সমাধানের পদ্ধতি </strong>
            <?php if(($SType==$last_user_group || $SType==$last_user_group1) && $editvalue>0){?>
            <div class="row">
                	<div class="col-sm-12">
                 
                 </div>
                 </div>
            <?php }?>     
                    <?php 
                    $comsql="SELECT 
                          tbl_task_history.`task_id`,
                          tbl_task_history.`email`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`description`,
                          tbl_task_history.subject,
                          tbl_task_history.`task_status`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`type`,  
                          tbl_task_history.`update_by`,
                          tbl_task_history.`update_date`,
                          mas_employees.emp_name,
                          clients_info.clients_name,
                          _nisl_mas_member.User_Name
                        FROM
                          `tbl_task_history`
                        LEFT JOIN tbl_task ON tbl_task.task_id =tbl_task_history.task_id
                        LEFT JOIN mas_employees on  mas_employees.system_user_id= tbl_task_history.update_by
                        LEFT JOIN _nisl_mas_member on  _nisl_mas_member.User_ID= tbl_task_history.update_by
                        LEFT JOIN clients_info ON clients_info.id=tbl_task_history.update_by
                        WHERE
                         tbl_task_history.`task_id` = $task_id and short_dsc='সমাধানের পদ্ধতি' order by tbl_task_history.`update_date` desc";
                          $res_com=mysql_query($comsql);  
                            while ($row_com = mysql_fetch_array($res_com)){
                                        extract($row_com);
                                        if($type=='I'){
                                        ?>
                    <div class="w3-example">
                        <div class="w3-code w3-left notranslate htmlHigh">
                            <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span> <span class="commentcolor" >
                                    <?php echo $emp_name .'('.$User_Name.')'?> </span> <br>
                                    <span style="color: #86001f; font-size: 11px; font-family: Consolas,"courier new";"> <?php echo date('d M Y h:i:s A',strtotime($update_date));?></span>
                                    <p style="border-top:2px solid "><?php echo $description?></p>
                                </div>
                               
                            </div>
                    </div></div>
                    <?php 
                    }else{
                    ?>
                    <div class="w3-example">
                        <div class="w3-code w3-right notranslate htmlHigh">
                        <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span><span class="commentcolor" style="color:#191919; font-size:10px; font-family: Consolas,"courier new";">
                                    <?php echo $clients_name;?><br>
                                    <?php echo date('d M Y h:i:s A',strtotime($update_date));?>
                                  </span>  
                                    <p><?php echo $description?></p>
                                </div>
                                
                            </div>
                     </div></div>
                    <?php 	
                        }
                    }
                    ?> 
            </div>       
        </div>
        <div class="col-sm-4">
        	<div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 156px; padding: 5px;">
            <strong>  আপনার মন্তব্য: </strong>
            	<div class="row">
                	<div class="col-sm-12">
                <form  id="replay_form" name="replay_form">
              
                <input type="hidden" value="<?php echo $task_id;?>" name="task_id" id="task_id">
               
                
                </form> 
                </div>
                </div>
                    <?php 
                     $comsql="SELECT 
                          tbl_task_history.`task_id`,
                          tbl_task_history.`email`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`description`,
                          tbl_task_history.subject,
                          tbl_task_history.`task_status`,
                          tbl_task_history.`short_dsc`,
                          tbl_task_history.`type`,  
                          tbl_task_history.`update_by`,
                          tbl_task_history.`update_date`,
                          mas_employees.emp_name,
                          clients_info.clients_name,
                          _nisl_mas_member.User_Name
                        FROM
                          `tbl_task_history`
                        LEFT JOIN tbl_task ON tbl_task.task_id =tbl_task_history.task_id
                        LEFT JOIN mas_employees on  mas_employees.system_user_id= tbl_task_history.update_by
                        LEFT JOIN _nisl_mas_member on  _nisl_mas_member.User_ID= tbl_task_history.update_by
                        LEFT JOIN clients_info ON clients_info.id=tbl_task_history.update_by
                        WHERE
                         tbl_task_history.`task_id` = $task_id and ( short_dsc<>'সমাধানের পদ্ধতি' and short_dsc<>'গৃহীত কার্যক্রম') order by tbl_task_history.`update_date` desc";
                          $res_com=mysql_query($comsql);  
                            while ($row_com = mysql_fetch_array($res_com)){
                                        extract($row_com);
                                        if($type=='I'){
                                        ?>
                    <div class="w3-example">
                        <div class="w3-code w3-left notranslate htmlHigh">
                            <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span> <span class="commentcolor" >
                                    <?php echo $emp_name .'('.$User_Name.')'?> </span> <br>
                                    <span style="color: #86001f; font-size: 11px; font-family: Consolas,"courier new";"> <?php echo date('d M Y h:i:s A',strtotime($update_date));?></span>
                                    <p style="border-top:2px solid "><?php echo $description?></p>
                                </div>
                               
                            </div>
                    </div></div>
                    <?php 
                    }else{
                    ?>
                    <div class="w3-example">
                        <div class="w3-code w3-right notranslate htmlHigh">
                        <div class="row">
                                <div class="col-sm-12">
                                    <span class="commentcolor" style="color:#003D5F"><?php echo $short_dsc.'-'.$subject;?></span><span class="commentcolor" style="color:#191919; font-size:10px; font-family: Consolas,"courier new";">
                                    <?php echo $clients_name;?><br>
                                    <?php echo date('d M Y h:i:s A',strtotime($update_date));?>
                                  </span>  
                                    <p><?php echo $description?></p>
                                </div>
                                
                            </div>
                     </div></div>
                    <?php 	
                        }
                    }
                    ?> 
			</div>
        </div>
    </div>

</div>	


</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>		
	</div>
	<?php }?>