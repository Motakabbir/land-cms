<?php
	include_once '../../Library/dbconnect.php';
	include_once '../../Library/Library.php';

	session_start();
	$SUserName = $_SESSION['SUserName'];

	$SDesignation = $_SESSION['SDesignation'];

$id=$_REQUEST['task_id'];
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
		  tbl_task.`service_tag`,
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
						
if (!$entry_by)
	{$entry_by=0;}
$last_user_group=pick("tbl_service_type","end_user","prob_id=".$service_type."");

$entry_by_id=pick("_nisl_mas_member","User_Name","User_ID=".$entry_by."");
$entry_by_name=pick("_nisl_mas_user","Name","User_ID=".$entry_by."");

$service_tag_old=$service_tag;
$subject_old_old=$subject;
$description_old=$description;
$address_old=$address;
$task_status_old=$task_status;

?>	

	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
	
	<h4 class="modal-title" id="myModalLabel">আপডেট</h4>

</div>
<div class="col-sm-12">
<h4>বিষয় : <?php  echo $subject;?> </h4>
    <div class="row" style="margin-left: 15px; margin-right: 15px;">
        <div class="col-sm-6">
            <div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 100px;">
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
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="borderTable" >
            	<tr>
            		<td><strong>নাম:</strong></td>
            		<td><?php echo  $contact_person;?></td>
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
                	<td><strong>বর্তমান অবস্থা :</strong></td>
					<td><?php echo $task_statusname; if($solv_by>1) echo $solv_by;?></td>

                </tr>
            </table>
            </div>
         
        </div>
        <div class="col-sm-6">
        	<div style="border: 1px solid #5b90bf; border-top: 2px solid #5b90bf; min-height: 100px;">
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
					                <tr>
            		<td><strong> তথ্য সংযুক্তকারী :</strong> </td>
            		<td><?php echo  "$entry_by_id - Name:$entry_by_name";?></td>
            	</tr>
            	</tr>

            </table>
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

</div>


					<form class="form-horizontal" id="modal_form" name="MyForm">

									<input type="hidden" value="<?php echo $task_id;?>" name="task_id" id="task_id">
									<input type="hidden" value="<?php echo $service_tag_old;?>" name="service_tag_old" id="service_tag_old">
									<input type="hidden" value="<?php echo $subject_old_old;?>" name="subject_old_old" id="subject_old_old">
									<input type="hidden" value="<?php echo $description_old;?>" name="description_old" id="description_old">
									<input type="hidden" value="<?php echo $address_old;?>" name="address_old" id="address_old">
									<input type="hidden" value="<?php echo $task_status_old;?>" name="task_status_old" id="task_status_old">
									<input type="hidden" value="<?php echo $entry_by;?>" name="entry_by" id="entry_by">

                                    <div class="row" style="margin-left: 15px; margin-right: 25px;">

                                       <div class="col-xs-12">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-3 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (1) Order by id", $service_tag );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
									    </div>
                                    <div class="row" style="margin-left: 15px; margin-right: 25px;">
									   	<div class="col-xs-12">
										  <div class="form-group">
											<label for="txtaddress" class="col-sm-3 control-label">ঠিকানা</label>
											<div class="col-sm-9 "> <span id="txtaddress-info" class="info" ></span>
											  <textarea type="text" class="form-control " name='txtaddress' id='' placeholder="ঠিকানা" ><?php echo $address;?></textarea>
											</div>
										  </div>
										</div>
                                    </div>
                                    <div class="row" style="margin-left: 15px; margin-right: 25px;">

                                       <div class=" col-xs-12">
                                          <div class="form-group">
                                             <label for="txtsubject" class="col-sm-3 control-label"> কলের বিষয় <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtsubject-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtsubject" id="txtsubject" value="<?php echo $subject;?>" placeholder="কলের বিষয়" onchange="allSyn(this,'input','txtsubject')">
                                             </div>
                                          </div>
                                       </div>
                  
                                    </div>                                  
                                    <div class="row" style="margin-left: 15px; margin-right: 25px;">
      
                                       <div class=" col-xs-12">
                                          <div class="form-group">
                                             <label for="txtdescription" class="col-sm-3 control-label"> কলের বিবরণ <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtdescription-info" class="info" ></span>
											 
										<textarea type="text" class="form-control" name="txtdescription" id="txtdescription" placeholder="কলের  বিবরণ" onchange="allSyn(this,'input','txtdescription')"> <?php echo $description;?></textarea>

                                             </div>
                                          </div>
                                       </div>
                                    </div>

	<div class="clr "></div>
	<div class="modal-footer" style=" margin-right: 25px;">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">বন্ধ করুন</button>
		
			<button type="button" class="btn btn-danger btn-sm" onclick="cancel(1)" >বাতিল  করুন </button>
			<button type="button" class="btn btn-primary btn-sm" onclick="save()" >সংরক্ষণ করুন </button>
	
	</div>
	

</form>



<script>

   function save() {
         $.ajax({
              type: "POST",
              url:"update_task.php",
              data: $('#modal_form').serialize(),
          }).done(function(msg) {
              alert(msg);
              location.reload();
             
          }).fail(function() {
              alert("error");
          });
      
   }

   function cancel($calcel_st) {
         $.ajax({
              type: "POST",
              url:"update_task.php",
           //   data: $('#modal_form').serialize(),
			  data:$('#modal_form').serialize() + '&calcel_st=' + $calcel_st,
          }).done(function(msg) {
              alert(msg);
              location.reload();
             
          }).fail(function() {
              alert("error");
          });
      
   }
	$('#scheduled_department').on('change',function(){
	var scheduled_department = $('#scheduled_department').val();
	var mode = '1';
	//alert(txtclients_id);
	if(scheduled_department >0){
	$.ajax({
		type: "POST",
		url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=emp_id,emp_name",
		data: {
			mode: mode,
			department:scheduled_department,							
			table:'mas_employees ',
			conditions:'where department=' +scheduled_department,
			firstText:'Select a Employee',
		},
		success: function(response) {
			$('#scheduled_to').html(response);
		}
	});
	}else{
		$('#scheduled_to').html('');
		}
});

	$('#division_id').on('change',function(){
		var division_id = $('#division_id').val();
		var mode = '1';
		//alert(txtclients_id);
		if(division_id >0){
		$.ajax({
			type: "POST",
			url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
			data: {
				mode: mode,
				division_id:division_id,							
				table:'tbl_district ',
				conditions:'where division_id=' +division_id,
				firstText:'জেলা নির্বাচন করুন',
			},
			success: function(response) {
				$('#district').html(response);
			}
		});
		}else{
			$('#district').html('');
			}
	});
	$('#district').on('change',function(){
		var district = $('#district').val();
		var mode = '1';
		//alert(txtclients_id);
		if(district >0){
		$.ajax({
			type: "POST",
			url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
			data: {
				mode: mode,
				district:district,							
				table:'tbl_upozila ',
				conditions:'where district=' +district,
				firstText:'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
			},
			success: function(response) {
				$('#upozila').html(response);
			}
		});
		}else{
			$('#upozila').html('');
			}
	});

</script>