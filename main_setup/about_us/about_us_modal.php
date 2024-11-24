<link rel="stylesheet" href="../../dropify/dist/css/dropify.min.css">
<style>
	.dropify-wrapper .dropify-preview {
	    display: block;
	    
	}
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php
	if ($_POST['mode'] == '1'){
	?>
		<h4 class="modal-title" id="myModalLabel">যোগ করুন</h4>
	<?php }
	if ($_POST['mode'] == '2'){
	?>
		<h4 class="modal-title" id="myModalLabel">সম্পাদনা করুন</h4>
	<?php }?>

</div>
	<form id="modal_form" name="MyForm">
	<div class="modal-body">

			<?php
			include_once '../../Library/dbconnect.php';
			if ($_POST['mode'] == '2')
			{
				$id=$_POST['id'];
				
				
				$SeNTlist = "SELECT
								  `id`,
								  `au_description`,
								  `short_description`,
								  `au_image`,
								  `user_id`,
								  `updated_at`,
								  `created_at`
								FROM
								  `tbl_about_us` where id = '$id' ";
		 		$ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
		 		while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
		 		{
		 			extract($rowNewsTl);
		 		}
			}
			?>
			<div class="form-group col-xs-12">
				<input type="hidden" name="id" id="id" value="<?php if(isset($rowNewsTl)) {echo $_POST['id'];} ?>">
				<label for="short_description">সংক্ষিপ্ত বিবরণ </label>
				<div id="short_description">
					<?php if(isset($rowNewsTl)) {echo $short_description;}?>
				</div>				
			</div>
			<div class="form-group col-xs-12">
				<label for="au_description"> বিবরণ </label>
				<div id="au_description">
					<?php if(isset($rowNewsTl)) {echo $au_description;}?>
				</div>
			</div>
			<div class="form-group col-sm-6">
              <label >চিত্র <span class="color">*</span></label>
               <div class="white-box">
                    <input type="file" id="input-file-now" class="dropify" data-allowed-file-extensions="jpg png JPEG gif" data-max-file-size="1M" name="au_image" value="<?php if(isset($rowNewsTls)) {echo $au_image;}?>"  data-default-file="../../upload/<?php echo $au_image;?>"/> 
                </div>
             </div>  
			

	</div>
	<div class="clr"></div>
	<div class="modal-footer">
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
</form>
<script src="../../dropify/dist/js/dropify.min.js"></script>
<script src="../../bower_components/ckeditor/ckeditor.js"></script>
<script>
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

	var editorval = CKEDITOR.instances['short_description'].getData();
	data.append('short_description',editorval);

	var editorval1 = CKEDITOR.instances['au_description'].getData();
	data.append('au_description',editorval1);
	console.log(data);
		$.ajax({
			url: 'about_us_save.php',
			type: "POST", // Type of request to be send, called as method
			data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false, // The content type used when sending data to the server.
			cache: false, // To unable request pages to be cached
			processData: false // To send DOMDocument or non processed data file it is set to false
		}).
		done(function(msg) {
			 console.log(msg);
			//  viewdata();
			// $('#close').click();
		}).
		fail(function() {
			alertify.error('Error');
		}).
		complete (function(){
		});
		
	}));
});

if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 100;
CKEDITOR.config.width = 'auto';

var initSample = ( function() {
	var wysiwygareaAvailable = isWysiwygareaAvailable(),
		isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

	return function() {
		var editorElement = CKEDITOR.document.getById( 'short_description' );
		var editorElement2 = CKEDITOR.document.getById( 'au_description' );

	
		if ( wysiwygareaAvailable ) {
			CKEDITOR.replace( 'short_description' );
			CKEDITOR.replace( 'au_description' );
		} else {
			editorElement.setAttribute( 'contenteditable', 'true' );
			editorElement2.setAttribute( 'contenteditable', 'true' );
			CKEDITOR.inline( 'short_description' );
			CKEDITOR.inline( 'au_description' );

			// TODO we can consider displaying some info box that
			// without wysiwygarea the classic editor may not work.
		}
	};

	function isWysiwygareaAvailable() {
		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
			return true;
		}

		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
	}
} )();

initSample();

</script>