<?php
include_once "../header.php";
include_once "../../Library/SessionValidate.php";
?>
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
<body onload="viewdata()">  
<div class="col-md-12 pl0 pr0 main-body">
	<div class="blog blog-info">
		<div class="blog-header text-center">
			<h5 class="blog-title">ব্যবহারকারী</h5>
		</div>
		
		<div class="blog-body ">
			<div class="col-sm-12 ">
				<button type="button" id="btn1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> নতুন ব্যবহারকারী যুক্ত করুন</button>
				
				<div style="margin-top: 10px;" id="viewdata">
					<!--?php include_once('getdistrict.php');?-->
				</div>
				<div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog modal-lg">
						<div class="modal-content modal-lg">
							<!--MODAL CONTENT-->
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include_once "../footer.php";
?>
<script type="text/javascript">

	function viewdata() {
	    $.ajax({
	        type: "GET",
	        url: "user_get.php",
	        dataType: "html"
	    }).done(function(msg) {
	        $("#viewdata").html(msg);
	    }).fail(function(jqXHR, textStatus) {
	        alert("Request failed: " + textStatus);
	    });
	}

	$('#btn1').click(function() {
		//alert();
		var mode = '1';
	    $.ajax({
	        type: "POST",
	        url: "user_modal.php",
	        data: {
	            mode: mode
	        },
	        success: function(response) {
	            //alert('add');
	            $('.modal-content').html(response);
	        }
	    });
	});

/*function save() {
		//alert('yes');
		var valid;	
			valid = validateContact();
			if(valid) {
			$.ajax({
				type: "POST",
				url: "saveuser.php",
				data: $('#modal_form').serialize(),
	
			}).done(function(msg) {
				alert(msg);
				viewdata();
				document.getElementById("close").click();
			}).fail(function() {
				alert("error");
			});
			}
	}
function updatedata(id) {
		//alert(id);
		var valid;	
			valid = validateContact();
			if(valid) {
			$.ajax({
				type: "POST",
				url: "updateuser.php",
				data : $('#modal_form').serialize(),
	
			}).done(function(msg) {
				alert(msg);
				viewdata();
				document.getElementById("close").click();
			}).fail(function() {
				alert("error");
			});
			}
	}*/
	

</script>
</body>
</html>