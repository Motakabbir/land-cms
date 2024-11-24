<?php
	include_once '../../Library/dbconnect.php';
	include_once '../../Library/Library.php';

	session_start();
	$SUserName = $_SESSION['SUserName'];
	$SUserID = $_SESSION['SUserID'];
	$SDesignation = $_SESSION['SDesignation'];

?>
<style>
	
	.color {
   font-size: 9px;
   color: red;
   }
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
	
	<h4 class="modal-title" id="myModalLabel">স্থানান্তর</h4>

</div>
<?php
	$task_id=$_POST['task_id'];
	$shedule=$_REQUEST['shedule'];
	$SeNTlist ="SELECT
						  `division`,
						  `district`,
						  `upozila`,
						  complain_manage,
						  service_type
						FROM
						  `tbl_task`
				WHERE tbl_task.task_id = $task_id
				";
	$ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
	while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
	{
		extract($rowNewsTl);
	}

?>
<form class="form-horizontal" id="modal_form" name="MyForm">
	<div class="col-sm-12">
	   
	    <input type="hidden" name="task_id" value="<?php echo $task_id;?>">
       <div class="col-sm-12">
       <div class="form-group ">
            <label for="division_id" class="col-sm-4 control-label">বিভাগের নাম <span class="color">*</span></label>
            <div class="col-sm-8 " >
            	<?php if($service_type==23 || $service_type==24){?>
            		<select class="form-control input-sm" disabled>
	                	<?php 
	                    createCombo("বিভাগের নাম","tbl_division","id","name"," ORDER BY name ",$division);
	                  ?>
	               	</select>
	               	<input name="division_id" id="division_id" value="<?php echo $division;?>" type="hidden">
            	<?php }else{?>
	                <select name="division_id" id="division_id" class="form-control input-sm" >
	                <?php 
	                    createCombo("বিভাগের নাম","tbl_division","id","name"," ORDER BY name ",$division);
	                  ?>
	               </select>
           		<?php }?>
            </div>
        </div> 
       </div>
       <div class="col-sm-12">
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                <div class="col-sm-8">
                    <span id="name-info" class="info" ></span>
                    <?php if($service_type==23 || $service_type==24){?>
	            		<select class="form-control input-sm" disabled>
		                	<?php 
		                    createCombo("জেলার নাম","tbl_district","id","name"," where  `tbl_district`.`division_id`=".$division." ORDER BY name ",$district);
		                  ?>
		               	</select>
		               	<input name="district" id="district" value="<?php echo $district;?>" type="hidden">
	            	<?php }else{?>
		                <select name="district" id="district" class="form-control input-sm" >
		                <?php 
		                    createCombo("জেলার নাম","tbl_district","id","name"," where  `tbl_district`.`division_id`=".$division." ORDER BY name ",$district);
		                  ?>
		               </select>
	           		<?php }?>
                </div>
            </div>
        </div>
	    <div class="col-sm-12" >
		 <div class="form-group ">
		    <label for="name" class="col-sm-4 control-label">উপজেলার/সার্কেলের নাম <span class="color">*</span></label>
		    <div class="col-sm-8">
		        <span id="name-info" class="info" ></span>
		        <?php if($service_type==23 || $service_type==24){?>
            		<select class="form-control input-sm" disabled>
	                	<?php 
	                    createCombo("উপজেলার/সার্কেলের নাম ","tbl_upozila","id","name"," where  `tbl_upozila`.`district`=".$district." ORDER BY name ",$upozila);
	                  ?>
	               	</select>
	               	<input name="upozila" id="upozila" value="<?php echo $district;?>" type="hidden">
            	<?php }else{?>
	                <select name="upozila" id="upozila" class="form-control input-sm" >
	                <?php 
	                    createCombo("উপজেলার/সার্কেলের নাম ","tbl_upozila","id","name"," where  `tbl_upozila`.`district`=".$district." ORDER BY name ",$upozila);
	                  ?>
	               </select>
	           	<?php }?>
		    </div>
		 </div>
        </div>
        <?php if($service_type==23 || $service_type==24){?>
       <div class="col-sm-12" >
            <div class="form-group ">
                <label for="name" class="col-sm-4 control-label">যে সমাধান করবে <span class="color">*</span></label>
                <div class="col-sm-8">
                    <span id="complain_manage-info" class="info" ></span>
                    <select name="complain_manage" id="complain_manage" class=" form-control input-sm">
                      <?php
                       createCombo( "যে সমাধান করবে", "tbl_user_type", "id", "type_name", "  ORDER BY type_name ", $complain_manage );
                       ?>
                    </select>
                </div>
            </div>
       </div>
   		<?php }?>

	</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">বাতিল করুন</button>
		
			<button type="button" class="btn btn-primary btn-sm" onclick="save()" >সংরক্ষণ করুন </button>
	
	</div>
</form>
<script>

   function save() {
     //alert(check);
     var division_id = $('#division_id').val();
	 var district = $('#district').val();
	if(division_id>0 && district>0){
         $.ajax({
              type: "POST",
              url:"forward_save.php",
              data: $('#modal_form').serialize(),
          }).done(function(msg) {
              alert(msg);
              location.reload();
             
          }).fail(function() {
              alert("error");
          });
	}else{ alert('All Field Reqiured');}
      
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