<?php include_once '../header.php';?>
<body>
<div class="blog blog-info">
<div class="blog-header text-center">
    <h5 class="blog-title">কলের বিবরণ</h5>
</div>
<div class="blog-body ">
<?php

if(isset($_POST) && $_POST['id']>0){ 
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


include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
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

$solv_by_name=pick("_nisl_mas_member","User_Name","User_ID=".$solv_by."");

$last_user_group_name=pick("tbl_user_type","type_name","id=".$last_user_group."");						
?>

<style>
body {
    margin: 5px !important;
}
        /* Absolute Center Spinner */
	.loading {
	  position: fixed;
	  z-index: 999999;
	  height: 2em;
	  width: 2em;
	  overflow: show;
	  margin: auto;
	  top: 0;
	  left: 0;
	  bottom: 0;
	  right: 0;
	}
	/* Transparent Overlay */
	.loading:before {
	  content: '';
	  display: block;
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  background-color:rgba(232,232,232,0.98);
	}
	/* :not(:required) hides these rules from IE9 and below */
	.loading:not(:required) {
	  /* hide "loading..." text */
	  font: 0/0 a;
	  color: transparent;
	  text-shadow: none;
	  background-color: transparent;
	  border: 0;
	}
	.loading:not(:required):after {
	  content: '';
	  display: block;
	  font-size: 15px;
	  width: 1em;
	  height: 1em;
	  margin-top: -0.5em;
	  color:#fff;
	  -webkit-animation: spinner 1500ms infinite linear;
	  -moz-animation: spinner 1500ms infinite linear;
	  -ms-animation: spinner 1500ms infinite linear;
	  -o-animation: spinner 1500ms infinite linear;
	  animation: spinner 1500ms infinite linear;
	  border-radius: 0.5em;
	  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
	  box-shadow: rgba(0,56,104,1.00) 1.5em 0 0 0, 
				  rgba(0,56,104,1.00) 1.1em 1.1em 0 0,
				 rgba(0,56,104,1.00) 0 1.5em 0 0,rgba(0,56,104,1.00) -1.1em 1.1em 0 0,rgba(0,56,104,1.00) -1.5em 0 0 0,rgba(0,56,104,1.00) -1.1em -1.1em 0 0,rgba(0,56,104,1.00) 0 -1.5em 0 0,rgba(0,56,104,1.00) 1.1em -1.1em 0 0;
	}
	/* Animation */
	@-webkit-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@-moz-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@-o-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
hr {
    margin-top: 0px;
    margin-bottom: 4px;
    border: 0;
    border-top: 1px solid #eee;
}
.h4, .h5, .h6, h4, h5, h6 {
    margin-top: 4px;
    margin-bottom: 3px;
}
.blog-body {
    padding: 0px;
    position: relative;
    overflow: hidden;
    border: 1px solid #dfe6ee;
}
</style>

<div class="loading" id="loading" style="">লোড হচ্ছে ...</div>
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
					 <td><?php echo"ভুল তথ্যের কারণে বাতিল ,  বাতিলকারী  : $solv_by_name"; 
					?></td>
					 
					 
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
            <hr>
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
            <hr>
            
            
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
            <?php if($SType==$last_user_group){?>
            	<div class="row">
                	<div class="col-sm-12">
                    	<form  id="update_form" name="replay_form">
                      	
                        <input type="hidden" value="<?php echo $task_id;?>" name="task_id" id="task_id">
                        <textarea name="comments" id="comments_update"  class="form-control" rows="2"></textarea>
   
                        </form>  
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
            <?php if($SType==$last_user_group && $editvalue>0){?>
            <div class="row">
                	<div class="col-sm-12">
                <form  id="status_form" name="replay_form">
             
                <input type="hidden" value="<?php echo $task_id;?>" name="task_id" id="task_id">
                <textarea name="comments" id="comments_stat"  class="form-control" rows="2"></textarea> 
                </form> 
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
                <textarea name="comments" id="comments"  class="form-control" rows="2"></textarea>
              
                
                <button type="button" onClick=" save_comments('মন্তব্য')" class="btn btn-warning btn-sm" ><i class="fa fa-" aria-hidden="true"></i> সংরক্ষণ করুন</button>	
                <!--<button  type="button" class="btn btn-warning btn-sm" onclick="taskview(<?php //echo $task_id;?>)" ><i class="fa fa-print" aria-hidden="true"></i>প্রিন্ট</button>-->
                
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

<div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-lg large" role="document">
      <div class="modal-content" id="big_modal">
         <!--MODAL CONTENT-->
       
      </div>
   </div>
</div>
<div id="myModalsmall" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog " role="document">
      <div class="modal-content" id="small_modal">
         <!--MODAL CONTENT-->
       
      </div>
   </div>
</div>
<?php include_once '../footer.php';?>	
<script language="JavaScript">

var $loading = $('#loading').hide();
$('#loading').hide();
function taskview(val)
{
   w=700;
   h=500;
   var left = (screen.width/2)-(w/2);
   var top = (screen.height/2)-(h/2);
   var popit=window.open("../rpttaskhistory.php?task_id="+val+"",'console','status,scrollbars,width=650,height=350,top='+top+',left='+left);
}
function block_email(id) {
// alert($('#noteForm').serialize());
	 $.ajax({
		  type: "POST",
		  url: "block_email_save.php",
		  data: {
			  id:id				  
			  },
	  }).done(function(msg) {
		   alertify.success(msg); 
		  location.reload();              
	  }).fail(function() {
		  alert("error");
	  });
}
function save_claim(id) {
// alert($('#noteForm').serialize());
	 $.ajax({
		  type: "POST",
		  url: "claim_save.php",
		  data: {
			  id:id				  
			  },
	  }).done(function(msg) {
		 alertify.success(msg); 
		  location.reload();              
	  }).fail(function() {
		  alertify.error('Error'); 
	  });
}
function changePriority(id,task_id) {
//alert(task_id);
$.ajax({
 type: "POST",
 url: "priority_modal.php",
 data: {
	id:id,
	task_id : task_id
 },
 success: function (response)
 {   
	$( '#small_modal' ).html(response);
 }
});
}
function changestatus(id,task_id) {
	  // alert(id+','+task_id);
    // alert($('#noteForm').serialize());
        $.ajax({
         type: "POST",
         url: "status_change_modal.php",
         data: {
			  id:id,
			  task_id:task_id				  
			  },
         success: function (response)
         {   
            $( '#small_modal' ).html(response);
         }
      });
   }
function assign_task(task_id) {
 //alert(task_id);
  $.ajax({
	 type: "POST",
	 url: "scheduling_modal.php",
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
function forward_task(task_id) {
 //alert(task_id);
  $.ajax({
	 type: "POST",
	 url: "forward_modal.php",
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
function save_comments(replay) {
	var comments=$('#comments').val();
	if(comments!=''){
         $.ajax({
              type: "POST",
              url: "comments_save.php",
              data:$('#replay_form').serialize()+'&replay='+replay,
          }).done(function(msg) {
             alertify.success(msg); 
			 location.reload();              
          }).fail(function() {
              alertify.error('Error'); 
          });
	}else{
		alert('Please enter your comments');
		}
   }
function save_stats_inline(replay) {
	var comments=$('#comments_stat').val();
	if(comments!=''){
         $.ajax({
              type: "POST",
              url: "task_status_save.php",
              data:$('#status_form').serialize()+'&replay='+replay,
          }).done(function(msg) {
             alertify.success(msg); 
			 location.reload();              
          }).fail(function() {
              alertify.error('Error'); 
          });
	}else{
		alert('Please enter your comments');
		}
   }
function save_update_inline(replay) {
	var comments=$('#comments_update').val();
	if(comments!=''){
         $.ajax({
              type: "POST",
              url: "task_all_update_save.php",
              data:$('#update_form').serialize()+'&replay='+replay,
          }).done(function(msg) {
             alertify.success(msg); 
			 location.reload();              
          }).fail(function() {
              alertify.error('Error'); 
          });
	}else{
		alert('Please enter your comments');
		}
   }

  
</script>

<?php  }else{
	
	echo "Unauthenticated Access";
	} ?>
</div>
</div>
</body>
</html>