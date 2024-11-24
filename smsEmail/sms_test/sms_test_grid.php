<?php
	include_once '../header.php';
	include_once "../../Library/SessionValidate.php";
    include_once "../../Library/dbconnect.php";
    include_once "../../Library/Library.php";
?>
<style>
    .color{
        font-size: 9px;
        color: red;
    }
	.btn-group-lg>.btn, .btn-lg {
	    padding: 3px 7px;
	    font-size: 14px;
	    line-height: 1.3333333;
	    border-radius: 2px;
	}
	.form-horizontal .control-label {
        padding-top: 7px;
        margin-bottom: 0; 
    }
fieldset.scheduler-border {
    border: 1px groove rgba(46, 134, 191, 0.57) !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #8A8A8A;
    box-shadow: 0px 0px 0px 0px #2e86bf;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;

}
legend {
    display: block;
     width: auto !important; 
    padding: 0;
    margin-bottom: 20px;
    font-size: 21px;
    line-height: inherit;
    color: #333;
    border: 0;
    border-bottom: 0px ; 
}
.input-sm {
    height: 25px !important;
    line-height: 27px !important;
    border-radius: 2px;
    padding: 3px 10px;
}
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 600;
    font-size: 12px;
}
</style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic">
	<div id="u-app-wrapper"   class="collapse-true panel-fixed" >
		<div class="col-md-12 pl0 pr0 main-body">
			<div class="blog blog-info">
				<div class="blog-header text-center">
					<h5 class="blog-title">SMS Test</h5>
				</div>
				<div class="blog-body ">
					<div class="col-sm-12 ">
						<div style="margin-top: 10px;" id="viewdata">
							<form id="emailandsms" name="MyForm" method="post" action="mail&sms.php">
								<div class="row" style="padding-top:10px">
									<div class="col-sm-6" id="emaildiv" >
										<fieldset class="scheduler-border">
											<legend class="scheduler-border">&nbsp;SMS &nbsp;</legend>
											<div class="form-group">
												<label for="emailsubject">Mobile No (01711111111) </label>
												<input type="text" class="form-control" name="mobile" id="mobile">
											</div>
												
											<div class="form-group">
												<label for="emailbody">Body </label>
												<textarea name="smsbody" id="smsbody" class="form-control"></textarea>
											</div>
											<div class="form-group" >
												<label for="service_type_id" >Use api</label>
												<select class="form-control input-sm" name='api_id' id='api_id' required>
													<?php 
														$api_id=1;
														createCombo("API Name","tbl_sms_setup","id","name"," Order by name",$api_id);                           
													?>
												</select>
											</div>
										</fieldset>
									</div>       
								</div>
								<div class="row text-right">
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary btn-sm" id="btn-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send </button>
									</div>	
								</div>
								
							</form>
							<div id="content" class="col-md-12" >
								
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include '../footer.php';
    mysql_close();
	?>
	<script language='javascript'>
	                 
		function enabledate()
		{
	        if(document.MyForm.ckdatecontrol.checked==true)
	        {
	            document.MyForm.cbofDay.disabled=false;
	            document.MyForm.cbofMonth.disabled=false;
	            document.MyForm.cbofYear.disabled=false;
	            document.MyForm.cbotDay.disabled=false;
	            document.MyForm.cbotMonth.disabled=false;
	            document.MyForm.cbotYear.disabled=false;
	                
	        }
	        else
	        {
	            document.MyForm.cbofDay.disabled=true;
	            document.MyForm.cbofMonth.disabled=true;
	            document.MyForm.cbofYear.disabled=true;
	            document.MyForm.cbotDay.disabled=true;
	            document.MyForm.cbotMonth.disabled=true;
	            document.MyForm.cbotYear.disabled=true;
	        }
		}
	</script>
	<script type="text/javascript">
		$('.select2').select2();
	</script>
	<script type="text/javascript">
		$(document).ready(function(e){
	    	$("#emailandsms").on('submit', (function(e){
			e.preventDefault();  
	     	$.ajax({
	     	type : 'POST',
	     	url  : 'mail&sms.php',
	     	data: new FormData(this), 
			contentType: false, 
			cache: false, 
			processData: false,
	     	beforeSend: function()
	     	{
				//alert('0');
	     		$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Sending <i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
				$("#content").html('<br><br><div class="alert alert-warning" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Sending <i class="fa fa-spin fa-spinner" aria-hidden="true"></i></div>');
	     	},
	     	success :  function(data)
	     	{
				
				//alert (data);
				// $('#content').html(data);
	     		
	     		if(data==1)
	     		{
	     			$("#content").html('<div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success! </strong>Send Successfully.</div> ');
					$("#btn-submit").html('<i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; Send');
					//$('#content').html(data);
	     		}
	     		else{
	     			$("#content").html('<div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! </strong>Error to Send.</div> ');
					$("#btn-submit").html('<i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; send');
					//$('#content').html(data);
	     		}
	     		$("#content").fadeTo(2000, 500).slideUp(500, function(){
	     				//$("#content").alert('close');
	     			});
	     		$('#search').trigger("reset");
	     	}
	     	});
	     	return false;
			
	     }));
	     });


		
	</script>
    

</body>
