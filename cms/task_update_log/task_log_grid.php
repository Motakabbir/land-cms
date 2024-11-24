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
.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 0;
    border-radius: 4px;
    float: right;
}
</style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic" >
	<div id="u-app-wrapper"   class="collapse-true panel-fixed" >
		<div id="load" style=" position: fixed; margin-top: 18%;left: 44%; z-index: 99999;color: #4569af;font-size: 20px;text-align: center;"> <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
         <p>Please Wait....</p>
    <span class="sr-only">Loading...</span>
         </div>
		<div class="content-wrapper">
			<div class="col-md-12 pl0 pr0 main-body">
				<div class="blog blog-info">
					<div class="blog-header text-center">
						<h5 class="blog-title">SMS Log Report</h5>
					</div>
					<div class="blog-body ">
						
								<form id="search" class="form-horizontal">
                                	<div class="col-sm-4">
                                    	<div class="form-group">
                                            <label for="cbocustomer" class="col-sm-4 control-label">From</label>
                                            <div class="col-sm-8">
                                            <?php $nowdate=date('m/d/Y');?>
                                              <input type="text" name="txtfromopen_date" id="txtfromopen_date" class="form-control datetimepicker  input-sm" value='<?php echo $nowdate; ?>' />
                                            </div>
                                        </div>
                                    </div>
                                	<div class="col-sm-4">
                                    	<div class="form-group">
                                            <label for="cbocustomer" class="col-sm-4 control-label">To</label>
                                            <div class="col-sm-8">
                                               <input type="text" name="txttoopen_date" id="txttoopen_date" class="form-control datetimepicker  input-sm" value='<?php echo $nowdate; ?>'  />
                                            </div>
                                        </div>
                                    </div>
                           			
                                    
                                    
		                            <div class="col-sm-12 text-center">
		                                <button type="button" class="btn btn-primary btn-sm" id="Searchbt" >View</button>
		                                <button type="button"  class="btn btn-warning btn-sm" onClick="doPrint()">Print</button>
							<button  onclick="myFunction()" type="button" class="btn btn-success btn-sm" ><i class="fa fa-file-excel-o"></i>&nbsp; Excel </button>
		                            </div>
		                        </form>

								<div class="col-sm-12" id="dvContainer" style="margin-top:10px">
		                        	<div id="content" >
									
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
	
		var $loading = $('#load').hide();
	function sendData(page){
		
		$loading.show();
		$.ajax({
			url:"task_log_get.php",
			type:"POST",
			data:$('#search').serialize()+"&actionfunction=showData&page="+page,
			cache: false,
			success: function(response){
				$('#content').html(response);
				$loading.hide();
			}
		});
		return false;
	};
	$('#Searchbt').on('click',function(){
				$loading.show();
				$.ajax({
					url:"task_log_get.php",
					type:"POST",
					data:$('#search').serialize()+"&actionfunction=showData&page=1",
					cache: false,
					success: function(response){
						$('#content').html(response);
						$loading.hide();
					}
				});
			});	

	$(document).ready(function() {
		sendData(1);
	});
	
		function myFunction() {
      		//alert("I am an alert box!");
      		window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=content]').html()));
						} 
						
						
	</script>
    
    <script type="text/javascript">
		$('.select2').select2();
	</script>
</body>
</html>