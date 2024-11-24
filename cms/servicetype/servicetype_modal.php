<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_POST['mode'] == '1'){
	?>
		<h4 class="modal-title" id="myModalLabel"> সেবার ধরন যুক্ত করুন</h4>
	<?php }
	if ($_POST['mode'] == '2'){
	?>
		<h4 class="modal-title" id="myModalLabel"> সেবার ধরন সম্পাদনা করুন</h4>
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
				
				
				 $SeNTlist = "SELECT
								  `prob_id`,
								  `prob_name`,
								  `entryby`,
								  `entrydate`,
								  `show_problem`,
								  `show_upozila`,
								  `end_user`,
								  end_user1,
								  srv_type
								FROM
								  `tbl_service_type`
							WHERE prob_id = '$prob_id' ";
		 		$ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
		 		while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
		 		{
		 			extract($rowNewsTl);
		 		}
			}
			?>

			<div class="form-group col-xs-12">
				<input type="hidden" name="prob_id" id="prob_id" value="<?php if(isset($rowNewsTl)) {echo $_POST['prob_id'];} ?>">
				<label for="prob_name"> সেবার ধরন </label>
				<div class="col-sm-12 pl0">
	                <span id="prob_name-info" class="info" ></span>
					<input type="text" class="form-control input-sm" name="prob_name" id="prob_name" value="<?php if(isset($rowNewsTl)) {echo $prob_name;}?>" placeholder=" সেবার ধরণ">
				</div>
			</div>
            
            <div class="form-group col-xs-6">
				<label for="prob_name"> সেবার ধরন দেখাবে </label>
				<div class="col-sm-12 pl0">
	                <label class="radio-inline">
                      <input type="radio" name="show_problem" id="show_problem" value="1" <?php if($show_problem==1){ echo 'checked';}?> > হাঁ 
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="show_problem" id="show_problem1" value="2" <?php if($show_problem==2){ echo 'checked';}?>> না 
                    </label>
           
				</div>
			</div>
            <div class="form-group col-xs-6">
				<label for="show_upozila"> উপজেলা দেখাবে </label>
				<div class="col-sm-12 pl0">
	                <label class="radio-inline">
                      <input type="radio" name="show_upozila" id="show_upozila" value="1"   <?php if($show_upozila==1){ echo 'checked';}?>> হাঁ 
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="show_upozila" id="show_upozila1" value="2"  <?php if($show_upozila==2){ echo 'checked';}?>> না 
                    </label>
           
				</div>
			</div>
        <div class="form-group col-sm-12">
                <label for="srv_type">ক্যাটাগরি</label>
                <div class="col-sm-12 pl0" style="left: -4px;">
                    <select name="srv_type" id="srv_type" class="form-control input-sm">                    
                    <option value="1" <?php if($srv_type==1){ echo 'selected';}?>></optio>অভিযোগ</option>
                    <option value="2" <?php if($srv_type==2){ echo 'selected';}?>>আবেদন</option>
                    <option value="3" <?php if($srv_type==3){ echo 'selected';}?>>তথ্য</option>
                   </select>
                </div>
            </div>
        
            <div class="form-group col-sm-12">
                <label for="end_user">সর্বশেষ ব্যাবহারকারী এক</label>
                <div class="col-sm-12 pl0" style="left: -4px;">
                    <select name="end_user" id="end_user" class="form-control input-sm">
                    <?php 
                        createCombo("সর্বশেষ ব্যাবহারকারী এক","tbl_user_type","id","type_name"," ORDER BY type_name ",$end_user);
                      ?>
                   </select>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <label for="end_user">সর্বশেষ ব্যাবহারকারী দুই</label>
                <div class="col-sm-12 pl0" style="left: -4px;">
                    <select name="end_user1" id="end_user1" class="form-control input-sm">
                    <?php 
                        createCombo("সর্বশেষ ব্যাবহারকারী দুই","tbl_user_type","id","type_name"," ORDER BY type_name ",$end_user1);
                      ?>
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