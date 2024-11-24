 <?php
include_once '../header.php';
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';

session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SDesignation = $_SESSION['SDesignation'];
?>
<link rel="stylesheet" href="sumoselect.css">
<style>
.input-group{
    position:relative !important;
}
.SumoSelect{
	height:26px}
</style>
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
.large{
	width:95%;
	}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	padding: 4px;
	line-height: 1.42857143;
	vertical-align: top;
	font-size: 13px;
	border-top: 1px solid #ddd;
}
</style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic" >
	<div id="u-app-wrapper"   class="collapse-true panel-fixed" >

		<div class="content-wrapper">
			<div class="col-md-12 pl0 pr0 main-body">
				<div class="blog blog-info">
					<div class="blog-header text-center">
						<h5 class="blog-title">এজেন্ট রিপোর্ট</h5>
					</div>
					<div class="blog-body ">
								<form id="search">
		                            <div class="form-group col-sm-3">
		                               <input type="text" name="txtfromopen_date" id="txtfromopen_date" class="form-control datetimepicker  input-sm" placeholder="হতে" />
		                                </div>
		                                <div class="form-group col-sm-3">
		                                        <input type="text" name="txttoopen_date" id="txttoopen_date" class="form-control datetimepicker  input-sm"  placeholder="থেকে"  />                                        
		                                   
		                                </div>
                                        
                                         <div class="col-sm-3">
                                        
                                            <select class="form-control input-sm" name='scheduled_to' id='scheduled_to'>
                                                <?php
                                                
                                                createCombo("এজেন্ট","_nisl_mas_user","_nisl_mas_user.User_ID","_nisl_mas_user.Name"," 
												LEFT JOIN mas_designation ON mas_designation.desig_id = _nisl_mas_user.Designation
											  	LEFT JOIN _nisl_mas_member ON _nisl_mas_member.User_ID= _nisl_mas_user.User_ID
											    Where _nisl_mas_user.Designation<>13 and `_nisl_mas_member`.`Type`=36 ",'');
                                                ?>
                                            </select>
                                        </div>
                                  
		                            
		                            <div class="col-sm-3">
		                                <button type="button" class="btn btn-primary btn-sm" onclick="sendData()" >দেখুন</button>
		                                <button type="button"  class="btn btn-warning btn-sm" onClick="doPrint()">প্রিন্ট</button>
										<button  onclick="myFunction()" type="button" class="btn btn-success btn-sm" ><i class="fa fa-file-excel-o"></i>&nbsp; Excel </button>
		                            </div>
		                        </form>

								<div class="col-sm-12" id="dvContainer">
		                        	<div id="content" class="table-responsive">
									
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
<script src="jquery.sumoselect.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    $(window).keydown(function(event) {
		        if (event.keyCode == 13) {
		            event.preventDefault();
		            return false;
		        }
		    });
		});
	
		

		
		function validateContact() {
			var valid = true;	
			
			$(".info").html('');
		
			if($("#department").val() == '') {
				$("#department-info").html("Please fill the Department *");
				$("#department").css('border','1px solid #F96666');
				valid = false;
			}
			
			return valid;
		}
		
		  function doPrint() {
						
						var divContents = $("#dvContainer").html();
						var printWindow = window.open('', '', 'height=400,width=800');
						printWindow.document.write('<html><head><title>DIV Contents</title>');
						printWindow.document.write('</head><body >');
						printWindow.document.write(divContents);
						printWindow.document.write('</body></html>');
						printWindow.document.close();
						printWindow.print();
					}
					
					
	function myFunction() {
      		//alert("I am an alert box!");
      		window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=content]').html()));
						} 
      	
	</script>
    <script>

	   	$('.datetimepicker').datetimepicker({
			format:'m/d/Y',
			//formatDate:'Y/m/d',
			//value:'2015/04/15 05:03',
			step:5,
			timepicker:false
		});
	</script>
    <script>
		function sendData() {
			
		    $.ajax({
		        type: "GET",
		        url: "getrpt_gmt_ticketlist.php",
		        data: $('#search').serialize(),
		    }).done(function(msg) {
		        $("#content").html(msg);
				//alert(msg);
		    }).fail(function(jqXHR, textStatus) {
		        alert("Request failed: " + textStatus);
		    });
		}
	</script>
    <script type="text/javascript">
        $(document).ready(function () {
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });   
        });
    </script>
</body>
</html>