 <?php
include '../header.php';
include '../../Library/dbconnect.php';
include '../../Library/Library.php';
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if(isset($_POST["import"]))
{
    
    
  $allowedFileType = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
          
            $Reader->ChangeSheet($i);
			
 
            foreach ($Reader as $Row)
            {
          		
                $name = "";
                if(isset($Row[0])) {
                    $name = mysqli_real_escape_string($conn,$Row[0]);
                }
                $service_type = "";
                if(isset($Row[1])) {
                    $service_type = mysqli_real_escape_string($conn,$Row[1]);
                }
				
				
                if (!empty($name) && !empty($service_type)  && $name!='Service tag name') {
                   $query = "Insert INTO
										  `tbl_service_tag`(
											`name`,
											`service_type`
										  )
										VALUES(
										  '".$name."',
										  '".$service_type."'
										)";
								
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
		 
         }
		 
		 unlink($targetPath);
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
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
						<h5 class="blog-title">সার্ভিস টাইপ ট্যাগ</h5>
					</div>
					<div class="blog-body ">
						<div class="col-sm-12 ">

							<!-- Button trigger modal -->
							
							 <form method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
							 	<div class="col-sm-2">
									<button type="button" id="btn1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> নতুন যুক্ত করুন</button>
								</div>
							 	<div class="col-sm-3">
					               <input type="file" name="file" id="file" accept=".xls,.xlsx">
					             </div>
							  <div class="col-sm-2"> 
					              
					                <button type="submit" id="submit" name="import" class="btn-submit btn btn-success btn-sm">পাঠান</button>
					        
					            </div>
							 <div class="col-sm-2"> 
				              
				                <a href="samplesheet.xlsx"  class="btn btn-primary btn-sm " download="">এক্সেল শীটের উদাহরণ</a>
				        
				            </div>
							 </form>
							
							<br>          
    						<div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
							<!-- Modal -->
							<div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog" role="document">
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
	include '../footer.php';
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
		        url: "servicetypetag_get.php",
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
		        url: "servicetypetag_modal.php",
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
			        url: "servicetypetag_save.php",
			        data: $('#modal_form').serialize(),

			    }).done(function(msg) {
			        alert(msg);
			        //viewdata();
			        $('#close').click()
			        window.location.href = 'servicetypetag_grid.php';
			    }).fail(function() {
			        alert("error");
			    });
			} 
		}
		
		function validateContact() {
			var valid = true;	
			
		$(".info").html('');
		
		if($("#prob_name").val() == '') {
			$("#prob_name-info").html("সেবার ধরণ পূরণ করুন *");
			$("#prob_name").css('border','1px solid #F96666');
			valid = false;
		}
		
		return valid;
	}
	</script>
</body>
</html>