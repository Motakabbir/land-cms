<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_REQUEST['mode'] == '1'){
	?>
		<h4 class="modal-title" id="myModalLabel">এসএমএস টেমপ্লেট যোগ করুন</h4>
	<?php }
	if ($_REQUEST['mode'] == '2'){
	?>
		<h4 class="modal-title" id="myModalLabel">এসএমএস টেমপ্লেট সম্পাদনা করুন</h4>
	<?php }?>

</div>
	<form id="modal_form" name="MyForm">
	<div class="modal-body">

			<?php
			if ($_REQUEST['mode'] == '2')
			{
				$id=$_REQUEST['id'];
				include_once '../../Library/dbconnect.php';
				
				$SeNTlist = "SELECT `id`, `command`, `description`,status FROM `tbl_sms_template` where id= '$id' ";
		 		$ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error());
				$rowNewsTls=mysqli_num_rows($ExSeNTlist); 
		 		while($rowNewsTl=mysqli_fetch_array($ExSeNTlist))
		 		{
		 			extract($rowNewsTl);
		 		}
			}
			?>

			<div class="form-group col-xs-12">
				<input type="hidden" name="id" id="id" value="<?php if(isset($rowNewsTls)) {echo $_REQUEST['id'];} ?>">
				<label for="command">জন্য </label>
				<div class="col-sm-12 pl0">
	                <span id="command-info" class="info" ></span>
					<input type="text" class="form-control input-sm" name="command" id="command" value="<?php if(isset($rowNewsTls)) {echo $command;}?>" placeholder="For" <?php if($_REQUEST['mode'] == '2'){ echo 'readonly';}?> >
				</div>
			</div>
            <div class="form-group col-xs-12">
				
				<label for="description">এসএমএস বডি </label>
				<div class="col-sm-12 pl0">
	                <span id="description-info" class="info" ></span>
                  <!--    <label for="smsbody">বডি- কীওয়ার্ড: <span>{{name}}</span> , <span>{{ticket_no}}</span> , <span>{{mobile}}</span> , <span>{{otp}}</span>,<span>{{service}}</span> </label> -->
                    <textarea name="description" id="description" class="form-control " ><?php if(isset($rowNewsTls)) {echo $description;}?> </textarea>
             Total Characters: <span id="totalChars"><?php if ($_REQUEST['mode'] == '2'){ echo strlen($description);}else{ echo '0';}?></span><br/>
				</div>
			</div>
            <div class="form-group col-xs-12">
			<label for="status">অবস্থা </label>
			<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-black-tie"></i></div>
				
                <span id="status-info" class="info" ></span>
                <select class="form-control input-sm" name="status" id="status">
                <?php
					$a='';
					$b='';
				 if(isset($rowNewsTls)) {
					
				
				 if($status==1){
					 $a='selected';
					 }
				elseif($status==2){
					$b='selected';	 
				}
				 }?>
                	<option value="0">Select a option</option>
                	<option value="1" <?php if($a!=''){ echo $a;}?>>On</option>
                    <option value="2" <?php if($b!=''){echo $b;}?>>Off</option>
                </select>
				
			</div>
		</div>


	</div>
	<div class="clr"></div>
	<div class="modal-footer">
		<button type="button" id="close" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
		<?php
		if ($_REQUEST['mode'] == '1'){
		?>
			<input type="hidden" name="mode" value="1">
			<button type="button" class="btn btn-primary btn-sm" onclick="save()" >Submit</button>
		<?php }
		if ($_REQUEST['mode'] == '2'){
		?>
			<input type="hidden" name="mode" value="2">
			<button type="button" onclick="save()" class="btn btn-primary btn-sm">Update</button>
		<?php }?>
	</div>
</form>
<script>
$(document).ready(function() {
	counter = function() {
    var value = $('#description').val();

    if (value.length == 0) {
        $('#totalChars').html(0);
        return;
    }
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    $('#totalChars').html(totalChars);
};
});
$(document).ready(function() {
    $('#description').change(counter);
    $('#description').keydown(counter);
    $('#description').keypress(counter);
    $('#description').keyup(counter);
    $('#description').blur(counter);
    $('#description').focus(counter);
});

$('span').click(function(e) {
  var txtarea = $('#description').val();
  var txt = $(e.target).text();
  $('#description').val(txtarea + txt + ' ');
});
</script>