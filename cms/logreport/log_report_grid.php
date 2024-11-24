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
						<h5 class="blog-title">রিপোর্ট</h5>
					</div>
					<div class="blog-body ">
						<form id="search">
                        	<div class="form-group col-sm-1 pl0 pr0">
                          		<input type="text" name="txtfromopen_date" id="txtfromopen_date" class="form-control datetimepicker  input-sm" placeholder="হতে" />
                            </div>
                            <div class="form-group col-sm-1 pl0 pr0">
                                <input type="text" name="txttoopen_date" id="txttoopen_date" class="form-control datetimepicker  input-sm"  placeholder="থেকে"  />
                            </div>	

                            	
                            <div class="form-group col-sm-2 ">
                                <select name="division_id" id="division_id" class="form-control input-sm option1">
		                            <?php 
		                            createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ","");
		                            ?>
		                        </select>
                            </div>
                            <div class="form-group col-sm-2 ">
                                <select name="district" id="district" class="form-control input-sm option1">
		                           <option value="-1">প্রথমে বিভাগ নির্বাচন করুন</option>
		                        </select>
                            </div>
                            <div class="form-group col-sm-2 ">
                                <select name="upozila" id="upozila" class="form-control input-sm option1">
		                           <option value="-1">প্রথমে জেলা নির্বাচন করুন</option>
		                        </select>
                            </div>
                            <div class="form-group col-sm-2 ">
                                <select name="role" id="role" class="form-control input-sm option1">
		                          	<?php 
		                            createCombo("পদবী","tbl_user_type","type_name","type_name"," ORDER BY type_name ","");
		                            ?>
		                        </select>
                            </div>	
                            <div class="form-group col-sm-2 ">
                                <select name="status" id="status" class="form-control input-sm option1">
		                          	<option value="-1">অবস্থা নির্বাচন করুন</option>
		                          	<option value="Success">Success</option>
		                          	<option value="Fail">Fail</option>
		                        </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <input type="text" name="data" id="data" class="form-control input-sm"  placeholder="অন্যান্য"  />                                        
                               
                            </div>	                            
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary btn-sm" onclick="sendData()" >অনুসন্ধান করুন</button>
                                <button type="button"  class="btn btn-warning btn-sm" onClick="doPrint()">প্রিন্ট</button>
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
	

	   	$('.datetimepicker').datetimepicker({
			format:'m/d/Y',
			//formatDate:'Y/m/d',
			//value:'2015/04/15 05:03',
			step:5,
			timepicker:false
		});
	
		function sendData() {
			
		    $.ajax({
		        type: "GET",
		        url: "log_report_get.php",
		        data: $('#search').serialize(),
		    }).done(function(msg) {
		        $("#content").html(msg);
				//alert(msg);
		    }).fail(function(jqXHR, textStatus) {
		        alert("Request failed: " + textStatus);
		    });
		}
	
        $(document).ready(function () {
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });   
        });


         $('#division_id').on('change',function(){
      var division_id = $('#division_id').val();
      var mode = '1';
      //alert(txtclients_id);
      if(division_id >0){
      $.ajax({
      	type: "POST",
      	url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
      	data: {
      		mode: mode,
      		division_id:division_id,							
      		table:'tbl_district ',
      		conditions:'where division_id=' +division_id,
      		firstText:'জেলা নির্বাচন করুন',
      	},
      	success: function(response) {
      		var value= "<option value=\"-1\">সকল জেলা </option>" +response;
      		$('#district').html(value);
      	}
      });
      }else{
      	$('#district').html('');
      	}
      });
      
      $('#district').on('change',function(){
      var district = $('#district').val();
      var mode = '1';
      //alert(txtclients_id);
      if(district >0){
      $.ajax({
      	type: "POST",
      	url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
      	data: {
      		mode: mode,
      		district:district,							
      		table:'tbl_upozila ',
      		conditions:'where district=' +district,
      		firstText:'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
      	},
      	success: function(response) {
      		var value= "<option value=\"-1\">সকল উপজেলা </option>" +response;
      		$('#upozila').html(response);
      	}
      });
      }else{
      	$('#upozila').html('');
      	}
      });
    </script>
</body>
</html>