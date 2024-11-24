<style>
.input-group{
    position:relative !important;
}

.info {
    position: absolute;
    z-index: 9999;
    color: red;
    top: -11px;
    font-size: 9px;
    left: 61%;
}
</style>
<?php
	include_once '../../Library/dbconnect.php';
	include_once '../../Library/Library.php';

	session_start();
	$SUserName = $_SESSION['SUserName'];
	$SUserID = $_SESSION['SUserID'];
	$SDesignation = $_SESSION['SDesignation'];
 $mode=$_REQUEST['mode'];
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
	
	<h4 class="modal-title" id="myModalLabel">অবস্থা পরিবর্তন</h4>

</div>
<?php
	$task_id=$_POST['task_id'];
	$id=$_REQUEST['id'];
	
	 $SeNTlist ="SELECT
						 task_status
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
        <?php if($mode==2){?>
        <div class="col-sm-12">
       <div class="form-group ">
            <label for="id" class="col-sm-4 control-label">অবস্থা<span class="color">*</span></label>
            <div class="col-sm-8 " >
            	<span id="id-info" class="info" ></span>
                <select name="id" id="id" class="form-control input-sm">
                <?php 
				if($task_status==1){
					$task_status=1;
					}else{
					$task_status=2;	
						}
                    createCombo("অবস্থা","tbl_taskstatus","task_statusid","task_statusname"," where task_statusid<=3 ORDER BY task_statusid ",$task_status);
                  ?>
               </select>
            </div>
        </div> 
       </div>
        <?php }else{?>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <?php 
		
		}?>
	    <div class="row">
             <div class=" col-xs-12">
	            <div class="form-group">
	                <label for="comments" class="col-sm-4 control-label">মন্তব্য</label>
	                <div class="col-sm-8">
	                    <span id="comments-info" class="info" ></span>
                        <textarea class="form-control" name="comments" id="comments" rows="4"></textarea>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">বন্ধ করুন </button>
		<button type="button" class="btn btn-primary btn-sm" onclick="solv_solution()" >সংরক্ষণ করুন</button>
	
	</div>
</form>
<script>
function solv_solution() {
	 	 var valid;	
		 valid = validateStatus();
		 if(valid) {
         $.ajax({
              type: "POST",
              url: "status_save.php",
              data: $('#modal_form').serialize(),
          }).done(function(msg) {
             alertify.success(msg); 
			  location.reload();              
          }).fail(function() {
              alertify.error('Error'); 
          });
		}
   } 
   
   function validateStatus() {
			var valid = true;	
			$(".info").html('');
			if($("#comments").val() == '') {
				$("#comments-info").html("দয়া করে মন্তব্য লিখুন ");
				$("#comments").css('border','1px solid #F96666');
				valid = false;
			}
			if($("#id").val() == '' && $("#id").val() >0) {
				$("#id-info").html("দয়া করে অবস্থা নির্বাচন করুন");
				$("#id").css('border','1px solid #F96666');
				valid = false;
			}
			return valid;
		}
</script>