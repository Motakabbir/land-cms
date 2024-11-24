<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_POST['mode'] == '1'){
	?>
		<h4 class="modal-title" id="myModalLabel">প্রশ্ন যোগ করুন</h4>
	<?php }
	if ($_POST['mode'] == '2'){
	?>
		<h4 class="modal-title" id="myModalLabel">প্রশ্ন সম্পাদনা করুন</h4>
	<?php }?>

</div>
	<form id="modal_form" name="MyForm">
	<div class="modal-body">

			<?php
			include_once '../../Library/dbconnect.php';
			include_once '../../Library/Library.php';
			if ($_POST['mode'] == '2')
			{
				$id=$_POST['id'];
				
				
				$SeNTlist = "SELECT * FROM `tbl_faq` WHERE id = '$id' ";
		 		$ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
		 		while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
		 		{
		 			extract($rowNewsTl);
		 		}
			}
			?>

			<div class="form-group col-xs-12">
				<input type="hidden" name="id" id="id" value="<?php if(isset($rowNewsTl)) {echo $_POST['id'];} ?>">
				<label for="faq_question">প্রশ্ন </label>
				<div class="col-sm-12 pl0">
	                <span id="faq_question-info" class="info" ></span>
	                <textarea name="faq_question" id="faq_question" class="form-control "  placeholder="প্রশ্ন"><?php if(isset($rowNewsTl)) {echo $faq_question;}?></textarea>
				</div>
			</div>
			<div class="form-group col-xs-12">
				<label for="faq_answer">উত্তর </label>
				<div class="col-sm-12 pl0">
	                <span id="faq_answer-info" class="info" ></span>
	                <textarea name="faq_answer" id="faq_answer" class="form-control " placeholder="উত্তর"><?php if(isset($rowNewsTl)) {echo $faq_answer;}?></textarea>
				</div>
			</div>
			<div class="form-group col-xs-12">				
				<label for="active_status">অবস্থা </label>
				<div class="col-sm-12 pl0">
	                <span id="active_status-info" class="info" ></span>
	                
	                <select name="active_status" id="active_status" class="form-control input-sm">
                    <?php 
                        createCombo("অবস্থা","tbl_status","stat_id","stat_desc"," ORDER BY stat_desc ",$active_status);
                      ?>
                   </select>
				</div>
			</div>

	</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">বন্ধ করুন</button>
		<?php
		if ($_POST['mode'] == '1'){
		?>
			<input type="hidden" name="mode" value="1">
			<button type="button" class="btn btn-primary btn-sm" onclick="save()" >সংরক্ষণ করুন</button>
		<?php }
		if ($_POST['mode'] == '2'){
		?>
			<input type="hidden" name="mode" value="2">
			<button type="button" onclick="save()" class="btn btn-primary btn-sm">হালনাগাদ করুন</button>
		<?php }?>
	</div>
</form>
<script>
	
	function save() {
			//alert('yes');
			var valid;	
			valid = validateContact();
			if(valid) {
				$.ajax({
			        type: "POST",
			        url: "faq_save.php",
			        data: $('#modal_form').serialize(),

			    }).done(function(msg) {
			        alert(msg);
			        viewdata();
			        $('#close').click();
			     
			    }).fail(function() {
			        alert("error");
			    });
			}
		}
</script>