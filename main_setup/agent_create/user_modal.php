 <?php
	include_once '../../Library/dbconnect.php';
	include_once "../../Library/Library.php";
	include_once "../../Library/SessionValidate.php";
?>
<link rel="stylesheet" href="../../dropify/dist/css/dropify.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_POST['mode'] == '1'){
	?>
	<h4 class="modal-title" id="myModalLabel">ব্যবহারকারী যুক্ত করুন</h4>
	<?php }
	if ($_POST['mode'] == '2'){
	?>
	<h4 class="modal-title" id="myModalLabel">ব্যবহারকারী সম্পাদনা করুন</h4>
	<?php }?>
</div>
<div class="modal-body">
<div class="col-sm-12">
	<form id="modal_form" name="user">

		<?php
		if ($_POST['mode'] == '2')
		{
			$User_ID = $_POST['User_ID'];
			$res = mysql_query("SELECT * FROM _nisl_mas_user WHERE User_ID = '$User_ID'");
			$row = mysql_fetch_array($res);
			
			$res2 = mysql_query("SELECT * FROM _nisl_mas_member WHERE User_ID = '$User_ID'");
			$row2 = mysql_fetch_array($res2);

			extract($row);
			extract($row2);
		}
		?>
		<div class="row	">
        	<div class="col-sm-6">
                <div class="form-group col-sm-12">
                    <label for="Name" class="col-sm-4 control-label input-sm">নাম</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="User_ID" value="<?php if(isset($row)) {echo $User_ID;} ?>">
                         <span id="name-info" class="info" ></span>
                        <input type="text" class="form-control input-sm" name="Name" id="Name" placeholder="নাম" value="<?php if(isset($row)) {echo $Name;} ?>" required>
                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <label for="Email" class="col-sm-4 control-label input-sm">ইমেইল</label>
                    <div class="col-sm-8">
                    <span id="Email-info" class="info" ></span>
                        <input type="email" class="form-control input-sm" name="Email" id="Email" placeholder="ইমেইল" value="<?php if(isset($row)) {echo $Email;} ?>" required>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="Phone" class="col-sm-4 control-label input-sm">ফোন</label>
                    <div class="col-sm-8">
                    <span id="Phone-info" class="info" ></span>
                        <input type="text" class="form-control input-sm" name="Phone" id="Phone" placeholder="ফোন" value="<?php if(isset($row)) {echo $Phone;} ?>">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="Type" class="col-sm-4 control-label input-sm">দল</label>
                    <div class="col-sm-8">
                     <span id="Type-info" class="info" ></span>
                        <select class="form-control input-sm" name='Type' id='Type'>
                            <?php
                            createCombo("দল","tbl_user_type","id","type_name"," where id in (16,17,36) Order by id",$Type);
                            ?>
                        </select>
                    </div>
                </div>
  				<div class="form-group col-sm-12">
            	
                    <label for="Re-Password" class="col-sm-4 control-label input-sm">এনআইডি</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm"  id="nid_number" name="nid_number" placeholder="" value="<?php if(isset($row)) {echo $nid_number;} ?>"  required >
                    </div>
               
           	 </div>
             <div class="form-group col-sm-12">
				<label for="Address" class="col-sm-4 control-label input-sm">বর্তমান ঠিকানা</label>
				<div class="col-sm-8">
                <span id="Address-info" class="info" ></span>
					<textarea type="text" class="form-control" name="Address" id="Address" placeholder="বর্তমান ঠিকানা"  rows="2"><?php if(isset($row)) {echo $Address;} ?></textarea>
				</div>
			</div>
            </div>
           <div class="col-sm-6">
                
           
            <div class="form-group col-sm-12">
				<label for="Address" class="col-sm-4 control-label input-sm">স্থায়ী ঠিকানা</label>
				<div class="col-sm-8">
                <span id="Address-info" class="info" ></span>
					<textarea type="text" class="form-control" name="permanent_address" id="permanent_address" placeholder="স্থায়ী ঠিকানা" ><?php if(isset($row)) {echo $permanent_address;} ?></textarea>
				</div>
			</div>
                <div class="form-group col-sm-12">
                    <label for="user_status" class="col-sm-6 control-label input-sm">ব্যবহারকারী অবস্থা</label>
                    <div class="col-sm-6">
                    <span id="user_status-info" class="info" ></span>
                        <select class="form-control input-sm" name='user_status' id='user_status'>
                            <?php
                            createCombo("হাল","tbl_status","stat_id","stat_desc","Order by stat_desc",$user_status);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="User_Name" class="col-sm-4 control-label input-sm">আইডি</label>
                    <div class="col-sm-8">
                    <span id="User_Name-info" class="info" ></span>
                        <input type="text" class="form-control input-sm" name="User_Name" id="User_Name" placeholder="ব্যবহারকারীর আইডি" value="<?php if(isset($row)) {echo $User_Name;} ?>" required>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="Password" class="col-sm-6 control-label input-sm">পাসওয়ার্ড</label>
                    <div class="col-sm-6">
                    <span id="Password-info" class="info" ></span>
                        <input type="password" class="form-control input-sm" name="Password" id="Password" placeholder="Password" value="<?php if(isset($row)) {echo $Password;} ?>" required onkeyup="checkPass(); return false;">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="Re-Password" class="col-sm-6 control-label input-sm">পাসওয়ার্ড পুনরায় প্রবেশ</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input-sm" name="" id="Re-Password" placeholder="Re-Enter Password" value="<?php if(isset($row)) {echo $Password;} ?>" required onkeyup="checkPass(); return false;">
                    </div>
                </div>
           </div> 
		</div>
        <div class="row">
        	 <div class="col-sm-6">
              <label >ব্যবহারকারী চিত্র <span class="color">*</span></label>
               <div class="white-box">
                    <input type="file" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png JPEG gif" data-max-file-size="1M" name="user_image" value="<?php if(isset($rowNewsTls)) {echo $user_image;}?>" <?php
                    if ($_POST['mode'] == '2'){ ?>data-default-file="../../upload/<?php echo $user_image;?>" <?php }?>/> 
                </div>
             </div>  
             <div class="col-sm-6">
            <label >এনআইডি ছবি<span class="color">*</span></label>
                        <div class="white-box">
                    <input type="file" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png JPEG gif" data-max-file-size="1M" name="user_nid" value="<?php if(isset($rowNewsTls)) {echo $user_nid;}?>" <?php
                    if ($_POST['mode'] == '2'){ ?>data-default-file="../../upload/<?php echo $user_nid;?>" <?php }?>/> 
                </div>
             </div>  
        </div>
		<div class="form-group col-sm-12">
			<div class="col-md-12 pl0 pr0 text-right modal-f" >
				<button type="button" id="close" class="btn btn-default btn-sm " data-dismiss="modal" id="close">বাতিল করুন</button>
				<?php
				if ($_POST['mode'] == '1'){
				?>
                <input type="hidden" name="mode" value="1">
                <input type="hidden" id="save_type" value="1">
				<button type="submit" class="btn btn-success btn-sm sub" id="check" disabled>সংরক্ষণ করুন </button>
				<?php }
				if ($_POST['mode'] == '2'){
				?>
                <input type="hidden" name="mode" value="2">
                <input type="hidden" id="save_type" value="2">
				<button type="submit"  class="btn btn-primary btn-sm sub" >হালনাগাদ করুন</button>
				<?php }?>
			</div>
		</div>
	</form> 
</div>
</div>
<div class="clr"></div>

<style type="text/css">
.ui-datepicker{
z-index: 99999999 !important;
}
</style>
<script src="../../dropify/dist/js/dropify.min.js"></script>
<script language='Javascript'>
function checkPass() {
    var password = $("#Password").val();
    var confirmPassword = $("#Re-Password").val();

    if (password != confirmPassword) {
        //$("#Password").css("border", "1px solid rgba(240,0,4,1.00)");
        $("#Re-Password").css("border", "1px solid rgba(240,0,4,1.00)");
        $("#check").prop("disabled", true);
        return false;
    } else {
        //$("#Password").css("border", "1px solid rgba(18,135,0,1.00)");
        $("#Re-Password").css("border", "1px solid rgba(18,135,0,1.00)");
        $("#check").prop("disabled", false);
        return true;
    }
}

$("#User_Name").change(function(){
	//alert("The text has been changed.");
	var User_Name = $("#User_Name").val();
	$.ajax({
		type: "POST",
		url: "../../checkforuser.php",
		data: {
			User_Name: User_Name
		},
		success: function(response) {
			if (response != "") 
			{
				alert(response);
				$("#User_Name").val("");
			}
			//$('.modal-content').html(response);
		}
	});
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
			firstText:'উপজেলা নির্বাচন করুন',
		},
		success: function(response) {
			$('#upozila').html(response);
		}
	});
	}else{
		$('#upozila').html('');
		}
});

$(document).ready(function() {
	        // Basic
	        $('.dropify').dropify();
	        // Translated
	        $('.dropify-fr').dropify({
	            messages: {
	                default: 'Drag and drop a file here or click',
	                replace: 'Drag and drop a file or click to replace',
	                remove: 'Remove',
	                error: 'Sorry, the file is too large'
	            }
	        });
	        // Used events
	       var drEvent = $('#input-file-events').dropify();
			
	        drEvent.on('dropify.beforeClear', function(event, element) {
	            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
	        });
	        drEvent.on('dropify.afterClear', function(event, element) {
	            alert('File deleted');
	        });
	        drEvent.on('dropify.errors', function(event, element) {
	            console.log('Has Errors');
	        });
			drEvent.on('dropify.error.fileSize', function(event, element){
				alert('Filesize error message!');
			});
			drEvent.on('dropify.error.minWidth', function(event, element){
				alert('Min width error message!');
			});
			drEvent.on('dropify.error.maxWidth', function(event, element){
				alert('Max width error message!');
			});
			drEvent.on('dropify.error.minHeight', function(event, element){
				alert('Min height error message!');
			});
			drEvent.on('dropify.error.maxHeight', function(event, element){
				alert('Max height error message!');
			});
			drEvent.on('dropify.error.imageFormat', function(event, element){
				alert('Image format error message!');
			});
						
	        var drDestroy = $('#input-file-to-destroy').dropify();
	        drDestroy = drDestroy.data('dropify')
	        $('#toggleDropify').on('click', function(e) {
	            e.preventDefault();
	            if (drDestroy.isDropified()) {
	                drDestroy.destroy();
	            } else {
	                drDestroy.init();
	            }
	        })
	    });
$(document).ready(function(e) {
	$("#modal_form").on('submit', (function(e) {
	//alert('hello');
	e.preventDefault();
	var data=new FormData(this);
		
		var valid;	
	var types=$('#save_type').val();
	
	if(types==1){
		url='user_save.php';
		}else if(types==2){
		url='user_update.php';
	}
		valid = validateContact();
		if(valid) {
			$.ajax({
				url: url, // Url to which the request is send
				type: "POST", // Type of request to be send, called as method
				data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false // To send DOMDocument or non processed data file it is set to false
			}).
			done(function(msg) {
				 alert(msg);
				 viewdata();
				$('#close').click();
			}).
			fail(function() {
				alertify.error('Error');
			}).
			complete (function(){
				
			});
		}
	}));
});

	
function validateContact() {
			var valid = true;	
			
		$(".info").html('');
		
		if(!$("#Name").val()) {
			$("#name-info").html("নাম পূরণ করুন *");
			$("#Name").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#Email").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
			$("#Email-info").html("ইমেল পূরণ করুন *");
			$("#Email").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#Email").val()) {
			$("#Email-info").html("ইমেল পূরণ করুন *");
			$("#Email").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#Phone").val()) {
			$("#Phone-info").html("ফোন পূরণ করুন *");
			$("#Phone").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#Type").val() && $("#Type").val()<1) {
			$("#Type-info").html("টাইপ পূরণ করুন *");
			$("#Type").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#User_Name").val()) {
			$("#User_Name-info").html("ব্যবহারকারীর নাম পূরণ করুন *");
			$("#User_Name").css('border','1px solid #F96666');
			valid = false;
		}
		if(!$("#Password").val()) {
			$("#Password-info").html("টাইপ পূরণ করুন *");
			$("#Password").css('border','1px solid #F96666');
			valid = false;
		}
		//alert($("#Type").val());
		if($("#Type").val()==3){
		if(!$("#reseller_id").val() && $("#reseller_id").val()<1) {
			$("#reseller_id-info").html(" রিসেলার ব্যবহারকারী পূরণ করুন *");
			$("#reseller_id").css('border','1px solid #F96666');
			valid = false;
		}
		}
		return valid;
	}	
</script>