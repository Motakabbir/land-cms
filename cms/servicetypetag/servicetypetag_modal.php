<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_POST['mode'] == '1'){
	?>
		<h4 class="modal-title" id="myModalLabel"> সার্ভিস টাইপ ট্যাগ যুক্ত করুন</h4>
	<?php }
	if ($_POST['mode'] == '2'){
	?>
		<h4 class="modal-title" id="myModalLabel"> সার্ভিস টাইপ ট্যাগ সম্পাদনা করুন</h4>
	<?php }?>

</div>
	<form id="modal_form" name="MyForm">
	<div class="modal-body">

			<?php
			include_once '../../Library/dbconnect.php';
			include_once '../../Library/Library.php';
			if ($_POST['mode'] == '2')
			{
				$prob_id=$_POST['prob_id'];
				$SeNTlist = "SELECT `id`, `name`, `service_type` FROM `tbl_service_tag` WHERE `id` = '$prob_id' ";
		 		$ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
		 		while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
		 		{
		 			extract($rowNewsTl);
		 		}
			}
			?>

			<div class="form-group col-xs-12">
				<input type="hidden" name="prob_id" id="prob_id" value="<?php if(isset($rowNewsTl)) {echo $_POST['prob_id'];} ?>">
				<label for="name"> সার্ভিস টাইপ ট্যাগ </label>
				<div class="col-sm-12 pl0">
	                <span id="name-info" class="info" ></span>
					<input type="text" class="form-control input-sm" name="name" id="name" value="<?php if(isset($rowNewsTl)) {echo $name;}?>" placeholder=" সার্ভিস টাইপ ট্যাগ">
				</div>
			</div>
			<div class="form-group col-sm-12">
                <label for="service_type">ক্যাটাগরি</label>
                <div class="col-sm-12 pl0" style="left: -4px;">
                    <select name="service_type" id="service_type" class="form-control input-sm">                    
	                    <option value="1" <?php if($service_type==1){ echo 'selected';}?>>অভিযোগ</option>
	                    <option value="2" <?php if($service_type==2){ echo 'selected';}?>>আবেদন</option>
	                    <option value="3" <?php if($service_type==3){ echo 'selected';}?>>তথ্য</option>
                   </select>
                </div>
            </div>
		
		
	</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal"> বাতিল করুন</button>
		<?php
		if ($_POST['mode'] == '1'){
		?>
			<input type="hidden" name="mode" value="1">
			<button type="button" class="btn btn-primary btn-sm" onclick="save()" > পাঠান</button>
		<?php }
		if ($_POST['mode'] == '2'){
		?>
			<input type="hidden" name="mode" value="2">
			<button type="button" onclick="save()" class="btn btn-primary btn-sm"> আপডেট করুন</button>
		<?php }?>
	</div>
</form>