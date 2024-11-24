<?php
include_once '../header.php';
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
?>
<style>
.help-block {
    display: block;
    margin-top: 5px;
    margin-bottom: 10px;
    color: #d80303;
    position: absolute;
    z-index: 999;
    right: 20px;
    top: -20px;
    font-size: 11px;
    font-style: normal;
}
.form-group {
    margin-bottom: 17px;
}

.color{
	font-size: 9px;
	color: red;
}
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
	
.demo {
  min-height: 280px;
}
.tab-content {
  padding: 10px;
}
@media (max-width: 767px) {
  .nav-tabs.nav-tabs-dropdown,
  .nav-tabs-dropdown {
    border: 1px solid #dddddd;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
  }
  .nav-tabs.nav-tabs-dropdown::after,
  .nav-tabs-dropdown::after {
    content: "☰";
    position: absolute;
    top: 8px;
    right: 15px;
    z-index: 2;
    pointer-events: none;
  }
  .nav-tabs.nav-tabs-dropdown.open a,
  .nav-tabs-dropdown.open a {
    position: relative;
    display: block;
  }
  .nav-tabs.nav-tabs-dropdown.open > li.active > a,
  .nav-tabs-dropdown.open > li.active > a {
    background-color: #eeeeee;
  }
  .nav-tabs.nav-tabs-dropdown li,
  .nav-tabs-dropdown li {
    display: block;
    padding: 0;
    vertical-align: bottom;
  }
  .nav-tabs.nav-tabs-dropdown > li > a,
  .nav-tabs-dropdown > li > a {
    position: absolute;
    top: 0;
    left: 0;
    margin: 0;
    width: 100%;
    height: 100%;
    display: inline-block;
    border-color: transparent;
  }
  .nav-tabs.nav-tabs-dropdown > li > a:focus,
  .nav-tabs-dropdown > li > a:focus,
  .nav-tabs.nav-tabs-dropdown > li > a:hover,
  .nav-tabs-dropdown > li > a:hover,
  .nav-tabs.nav-tabs-dropdown > li > a:active,
  .nav-tabs-dropdown > li > a:active {
    border-color: transparent;
  }
  .nav-tabs.nav-tabs-dropdown > li.active > a,
  .nav-tabs-dropdown > li.active > a {
    display: block;
    border-color: transparent;
    position: relative;
    z-index: 1;
    background: #fff;
  }
  .nav-tabs.nav-tabs-dropdown > li.active > a:focus,
  .nav-tabs-dropdown > li.active > a:focus,
  .nav-tabs.nav-tabs-dropdown > li.active > a:hover,
  .nav-tabs-dropdown > li.active > a:hover,
  .nav-tabs.nav-tabs-dropdown > li.active > a:active,
  .nav-tabs-dropdown > li.active > a:active {
    border-color: transparent;
  }
}

	.active>a {
    background: #25417a !important;
    color: #fff !important;
    font-weight: bold;
    font-size: 16px !important;
}
	
</style>
<style>
        /* Absolute Center Spinner */
	.loading {
	  position: fixed;
	  z-index: 999999;
	  height: 2em;
	  width: 2em;
	  overflow: show;
	  margin: auto;
	  top: 0;
	  left: 0;
	  bottom: 0;
	  right: 0;
	}
	
	/* Transparent Overlay */
	.loading:before {
	  content: '';
	  display: block;
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  background-color: rgba(0,0,0,0.3);
	}
	
	/* :not(:required) hides these rules from IE9 and below */
	.loading:not(:required) {
	  /* hide "loading..." text */
	  font: 0/0 a;
	  color: transparent;
	  text-shadow: none;
	  background-color: transparent;
	  border: 0;
	}
	
	.loading:not(:required):after {
	  content: '';
	  display: block;
	  font-size: 15px;
	  width: 1em;
	  height: 1em;
	  margin-top: -0.5em;
	  color:#fff;
	  -webkit-animation: spinner 1500ms infinite linear;
	  -moz-animation: spinner 1500ms infinite linear;
	  -ms-animation: spinner 1500ms infinite linear;
	  -o-animation: spinner 1500ms infinite linear;
	  animation: spinner 1500ms infinite linear;
	  border-radius: 0.5em;
	  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
	  box-shadow: rgba(0,56,104,1.00) 1.5em 0 0 0, 
				  rgba(0,56,104,1.00) 1.1em 1.1em 0 0,
				 rgba(0,56,104,1.00) 0 1.5em 0 0,rgba(0,56,104,1.00) -1.1em 1.1em 0 0,rgba(0,56,104,1.00) -1.5em 0 0 0,rgba(0,56,104,1.00) -1.1em -1.1em 0 0,rgba(0,56,104,1.00) 0 -1.5em 0 0,rgba(0,56,104,1.00) 1.1em -1.1em 0 0;
	}
	
	/* Animation */
	
	@-webkit-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@-moz-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@-o-keyframes spinner {
	  0% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	  }
	  100% {
		-webkit-transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		transform: rotate(360deg);
	  }
	}
	@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
 </style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic">
<div class="loading" id="loading" style="">
লোড হচ্ছে ...</div>
	<div id="u-app-wrapper"   class="collapse-true panel-fixed">

		<div class="content-wrapper">
			<div class="col-md-12 pl0 pr0 main-body">
				<div class="blog blog-info">
					<div class="blog-header text-center">
						<h5 class="blog-title">
কল এন্ট্রি</h5>
					</div>
					<div class="blog-body ">
                    <div class="demo">
                    
                     
							<div class="col-sm-12 ">                               
                             	<form class="form-horizontal" id="sales_form" action="">
                                        <div class="row">
                                        	<div class="col-xs-6">
                                                <div class="form-group">
                                                <input type="hidden" name="task_type" value="3">
                                                    <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="txtcontact_person-info" class="info" ></span>
                                                        <input type="text" class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম ">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="txtcontact_person_no-info" class="info" ></span>
                                                        <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number" value="" placeholder="মুঠোফোন">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 ">
                                                <div class="form-group">
                                                    <label for="txtcontact_number" class="col-sm-4 control-label">ইমেইল </label>
                                                    <div class="col-sm-8 ">
                                                        <input type="email" class="form-control input-sm" name="txtcontact_email" id="txtcontact_email" value="" placeholder="ইমেইল ">
                                                    </div>
                                               </div>     
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label for="txtaddress" class="col-sm-4 control-label">ঠিকানা</label>
                                                    <div class="col-sm-8 ">
                                                        <span id="txtaddress-info" class="info" ></span>
                                                        <textarea type="text" class="form-control " name='txtaddress' id='' placeholder="ঠিকানা" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-xs-6">
                                                <div class="form-group">
                                                    <label for="service_type" class="col-sm-4 control-label">সেবার ধরন<span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="service_type-info" class="info" ></span>
                                                       <select class="form-control input-sm select2" name='service_type' id='service_type' style="width:100%">
                                                            <?php
                                                     createCombo("সেবার ধরন","tbl_service_type","prob_id","prob_name"," where srv_type =1 Order by prob_id",'');
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-6" id="pro_others" style="display:none">
                                                <div class="form-group">
                                                    <label for="others_problem" class="col-sm-4 control-label">অন্যান্য </label>
                                                    <div class="col-sm-8">
                                                        <span id="others_problem-info" class="info" ></span>                                                        <input type="text" class="form-control input-sm" name="others_problem" id="others_problem" value="" placeholder="অন্যান্য">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-6" id="pro_diaplay">
                                                <div class="form-group">
                                                    <label for="prob_id" class="col-sm-4 control-label">সমস্যার ধরন <span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="prob_id-info" class="info" ></span>                                                        
                                                        <select class="form-control input-sm"  name='prob_id' id='prob_id'  >
                                                            <?php
                                                            createCombo("সমস্যার ধরন","tbl_problem","prob_id","prob_name","Order by prob_id",'');
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                           <div class="col-sm-6">
                                           <div class="form-group ">
                                                <label for="division_id" class="col-sm-4 control-label">বিভাগের নাম <span class="color">*</span></label>
                                                <div class="col-sm-8 " >
                                                    <select name="division_id" id="division_id" class="form-control input-sm">
                                                    <?php 
                                                        createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",$division_id);
                                                      ?>
                                                   </select>
                                                </div>
                                            </div> 
                                           </div>
                                           <div class="col-sm-6">
                                                    <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="name-info" class="info" ></span>
                                                        <select name="district" id="district" class="form-control input-sm">
                                                       		<option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-6" id="upodisplay">
                                           		<div class="form-group ">
                                                    <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                                    <div class="col-sm-8">
                                                        <span id="name-info" class="info" ></span>
                                                        <select name="upozila" id="upozila" class="form-control input-sm">
                                                       		<option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                           
                                           <!-- <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label for="down_time"  class="col-sm-4 control-label">প্রশ্নের সময়</label>
                                                    <div class="col-sm-8 ">
                                                        <span id="down_time-info" class="info" ></span>-->
                                                        <input type="hidden" class="form-control datetimepicker time input-sm" name="down_time" id="down_time" value="<?php echo date('d/m/Y H:i');?>" placeholder="dd/mm/yy">
                                                  <!--  </div>
                                                </div>
                                            </div>-->
                                        </div>
                                         <div class="row">
                                            <div class=" col-xs-8">
                                                <div class="form-group">
                                                    <label for="txtsubject" class="col-sm-3 control-label">
কলের বিষয় <span class="color">*</span></label>
                                                    <div class="col-sm-9">
                                                        <span id="txtsubject-info" class="info" ></span>
                                                        <input type="text" class="form-control input-sm" name="txtsubject" id="txtsubject" value="" placeholder="কলের বিষয়">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class=" col-xs-8">
                                                <div class="form-group">
                                                    <label for="txtdescription" class="col-sm-3 control-label">
কলের বিবরণ <span class="color">*</span></label>
                                                    <div class="col-sm-9">
                                                        <span id="txtdescription-info" class="info" ></span>
                                                        <textarea type="text" class="form-control " name='txtdescription' id='txtdescription' placeholder="কলের বিবরণ"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row text-center">
                                            <button type="submit" class="btn btn-primary btn-sm submit" name="submit" id="submit" >জমা দিন <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="row" id="view"></div>
                                    </form>
                            </div> 
                        <hr>
                      <div class="row">
                      	<div id="history"></div>
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
    <style type="text/css">
		.select2-container--default .select2-selection--single {
		    background-color: #fff;
		    border: 1px solid #5b90bf;
		    border-radius: 2px;
		}
	</style>
	<script>
	var $loading = $('#loading').hide();
	$('#loading').hide();
	$('.datetimepicker').datetimepicker({
		format:'d/m/Y H:i',
		step:5,
		timepicker:true,
		language: 'bn'
	});
	$('.select2').select2()
	
	$(document).ready(function () {
	jQuery.validator.addMethod("mobileValidation", function( value, element ) {
        var regex = new RegExp("(^[01]{2}[0-9]{9})$");

        if ( !regex.test(value) ) {
            return false;
        }
        return true;
    });	
		
	
	
    $('#sales_form').validate({  // initialize plugin
	//var data=new FormData(this)
        rules: {
           
			
			scheduled_department: {
                required: true ,
				min:1
            },
			txtcontact_number: {
                required: true,
				mobileValidation: true
            },
			txtcontact_person: {
                required: true
            },
			
			prob_id: {
                required: true ,
				min:1
            },
			service_type: {
                required: true ,
				min:1
            },
			division_id: {
                required: true ,
				min:1
            },
			district: {
                required: true ,
				min:1
            },			
			down_time: {
                required: true 
            },
			txtsubject: {
                required: true 
            },
			txtdescription: {
                required: true 
            },
			
        },
		messages: {
			
			
			txtcontact_number: {
                mobileValidation: "শুধুমাত্র ০১ দ্বারা শুরু হয় এমন নম্বরটি বৈধ যার সংখ্যা ১১ পর্যন্ত",
                required: "বৈধ মোবাইল নম্বর প্রবেশ করুন"
            },
			service_type: "সমস্যার ধরন নির্বাচন করুন",
			prob_id: "সমস্যার ধরন নির্বাচন করুন",
			txtprob_type: "দয়া করে একটি প্রকার নির্বাচন করুন",
			division_id: "দয়া করে বিভাগের নাম নির্বাচন করুন",
			district: "দয়া করে জেলার নাম নির্বাচন করুন",
			txtsubject: "সাবজেক্ট প্রবেশ করুন",
			txtdescription: "বর্ণনা লিখুন",
			txtaddress: "ঠিকানা লিখুন দয়া করে",
			},
       		errorElement: "em",
			errorPlacement: function ( error, element ) {
				// Add the `help-block` class to the error element
				error.addClass( "help-block" );

				if ( element.prop( "type" ) === "checkbox" ) {
					error.insertAfter( element.parent( "label" ) );
				} else {
					error.insertAfter( element );
				}
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
			},
			unhighlight: function (element, errorClass, validClass) {
				$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
			},
       		submitHandler: function (form) {
			var data = new FormData();
			var form_data = $('#sales_form').serializeArray();
			$.each(form_data, function (key, input) {
				data.append(input.name, input.value);
			});
			/*var file_data = $('input[name="up_image"]')[0].files;
			for (var i = 0; i < file_data.length; i++) {
				data.append("up_image[]", file_data[i]);
			}*/
			data.append('key', 'value');
			$loading.show();
             $.ajax({
			            url: "savetask.php",
			            type: "POST", 
			            data: data, 
			            contentType: false, 
					    mimeType: "multipart/form-data",
			            cache: false,
			            processData: false
			        }).
				done(function(msg) {
					console.log(msg);
					if(msg==1){
						alertify.success('ডেটা সফলভাবে যোগ করা হয়েছে');
						document.getElementById("sales_form").reset();
						
					}					
					else{
						alertify.error(msg); 
					 }	
					 $loading.hide();
				}).
				fail(function() {
					alertify.error('Error');
					$loading.hide();
				}).
				complete (function(){
			});
            return false; // ajax used, block the normal submit
        }
    });
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
				$('#district').html(response);
				$('#upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
			}
		});
		}else{
			$('#district').html('<option value="">প্রথমে বিভাগ নির্বাচন করুন</option>');
			$('#upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
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
				$('#upozila').html(response);
			}
		});
		}else{
			$('#upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
			}
	});
	$('#txtcontact_number').on('change',function(){
		var txtcontact_number = $(this).val();
		//alert(building);
		if(txtcontact_number){
			$.ajax({
				type:'POST',
				url:'ajaxData.php',
				data:'txtcontact_number='+txtcontact_number,
				success:function(html){
					//alert(html)
					$('#history').html(html);
				}
			});
		}
	});
	$('#service_type').on('change',function(){
		var service_type = $(this).val();
		
		
		if(service_type==14){
			$('#pro_others').show();
		}else{
			$('#pro_others').hide();
			}
		
		
		//alert(building);
		if(service_type){
			$.ajax({
				type:'POST',
				url:'ajaxData.php',
				data:'service_type='+service_type,
				success:function(html){
					//console.log(html);
					var obj = JSON.parse(html);
					if(obj.show_problem==1){
						$('#pro_diaplay').show();
						}else{
						$('#pro_diaplay').hide();	
							}
					if(obj.show_upozila==1){
						$('#upodisplay').show();
						}else{
						$('#upodisplay').hide();	
							}
					
					
				}
			});
		}
	});
</script>
</body>
</html>