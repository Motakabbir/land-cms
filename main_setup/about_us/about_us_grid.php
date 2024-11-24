 <?php
include_once '../header.php';
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
<body  data-skin-type="skin-polaris-blue" class="skin-colortic" onload="viewdata()">
	<div id="u-app-wrapper"   class="collapse-true panel-fixed" >

		<div class="content-wrapper">
			<div class="col-md-12 pl0 pr0 main-body">
				<div class="blog blog-info">
					<div class="blog-header text-center">
						<h5 class="blog-title">আমাদের সম্পর্কে</h5>
					</div>
					<div class="blog-body ">
						<div class="col-sm-12 ">
							<!-- Modal -->
							<div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<!--MODAL CONTENT-->
										
									</div>
								</div>
							</div>

							<div style="margin-top: 10px;" id="viewdata">
					
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	include_once '../footer.php';
	?>

	<script type="text/javascript">
		$(document).ready(function() {
		    $(window).keydown(function(event) {
		        if (event.keyCode == 13) {
		            event.preventDefault();
		            return false;
		        }
		    });
		});
	
		function viewdata() {
		    $.ajax({
		        type: "GET",
		        url: "about_us_get.php",
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
		        url: "about_us_modal.php",
		        data: {
		            mode: mode
		        },
		        success: function(response) {
		            //alert('add');
		            $('.modal-content').html(response);
		        }
		    });
		});

		function save() {
			//alert('yes');
			var valid;	
			valid = validateContact();
			if(valid) {
				$.ajax({
			        type: "POST",
			        url: "about_us_save.php",
			        data: $('#modal_form').serialize(),

			    }).done(function(msg) {
			        alert(msg);
			        //viewdata();
			        $('#close').click();
			        window.location.href = 'area_grid.php';
			    }).fail(function() {
			        alert("error");
			    });
			}
		}
		
		function validateContact() {
			var valid = true;	
			
			$(".info").html('');
		
			if($("#area_name").val() == '') {
				$("#area_name-info").html("Please fill the Area *");
				$("#area_name").css('border','1px solid #F96666');
				valid = false;
			}
			
			return valid;
		}
	</script>
</body>
</html>