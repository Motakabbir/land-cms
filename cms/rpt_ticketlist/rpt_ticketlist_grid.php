<?php
   include_once '../header.php';
   include_once '../../Library/dbconnect.php';
   include_once '../../Library/Library.php';
   session_start();
   $SUserName = $_SESSION['SUserName'];
   $SUserID = $_SESSION['SUserID'];
   $SDesignation = $_SESSION['SDesignation'];
   $division=$_SESSION['Sdivision'] ;
   $district=$_SESSION['Sdistrict'];
   $upozela=$_SESSION['Supozela'];
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
   .blog-info .blog-body {
   border: 0px; 
   background: white;
   }
   .blog-body {
   padding: 15px;
   position: relative;
   overflow: inherit;
   border: 0px; 
   }
</style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic" >
   <div id="load" style="    position: fixed; margin-top: 18%;left: 44%; z-index: 99999999;color: #4569af;font-size: 20px;text-align: center;">
      <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
      <p>অনুগ্রহপূর্বক অপেক্ষা করুন....</p>
      <span class="sr-only">লোডিং...</span>
   </div>
   <div id="u-app-wrapper"   class="collapse-true panel-fixed" >
      <div class="content-wrapper">
         <div class="col-md-12 pl0 pr0 main-body">
            <div class="blog blog-info">
               <div class="blog-header text-center">
                  <h5 class="blog-title">কলের তালিকা </h5>
               </div>
               <div class="blog-body ">
                  <form id="search">
                     <div class="form-group col-xs-1  pr0 ">
                        <input type="text" name="txtfromopen_date" id="txtfromopen_date" class="form-control datetimepicker  input-sm" placeholder="From Date" />
                     </div>
                     <div class="form-group col-xs-1 pl0 pr0 ">
                        <input type="text" name="txttoopen_date" id="txttoopen_date" class="form-control datetimepicker  input-sm" placeholder="To Date"  />
                     </div>
                     <div class=" form-group col-sm-3">
                        <select  name='probtype[]' multiple="multiple" placeholder="সকল সেবার ধরণ " class="SlectBox from-control input-sm">
                        <?php createCombo("সকল সেবার ধরণ ","tbl_service_type","prob_id","prob_name","ORDER BY prob_id",$prob_type); ?>       
                        </select>
                     </div>
                     <div class=" form-group col-sm-1 pl0 pr0">
						<?php if($division>0 && ($SDesignation!=1 && $SDesignation!=2 && $SDesignation!=3 && $SDesignation!=4 && $SDesignation!=5 && $SDesignation!=25 && $SDesignation!=34 && $SDesignation!=35)){?>
                        <select  class="form-control input-sm option1" disabled>
                            <?php 
                            createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",$division);
                            ?>
                        </select>
                        <input type="hidden" name="division_id" id="division_id" value="<?php echo $division;?>">
                        <?php
                        }
                        else{?>
                        <select name="division_id" id="division_id" class="form-control input-sm option1">
                            <?php 
                            createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",$division);
                            ?>
                        </select>
                    <?php }?>
                    </div>
                     <div class=" form-group col-sm-1 pl0 pr0">
                        <?php if($district>0){?>
                        <select  class="form-control input-sm option1" disabled>
                        <?php 
                           createCombo("জেলা","tbl_district","id","name"," where division_id=".$division." ORDER BY name ",$district);
                           ?>
                        </select>
                        <input type="hidden" name="district" id="district" value="<?php echo $district;?>">
                        <?php }else{
                           if($division>0 ){?>
                        <select  class="form-control input-sm option1" name="district" id="district" >
                        <?php 
                           createCombo("জেলা","tbl_district","id","name"," where division_id=".$division." ORDER BY name ",$district);
                           ?>
                        </select>
                        <?php
                           }else{
                           ?>
                        <select name="district" id="district" class="form-control input-sm option1">
                           <option value="-1">প্রথমে বিভাগ নির্বাচন করুন</option>
                        </select>
                        <?php }}?>
                     </div>
                     <div class=" form-group col-sm-1 pl0 pr0">
                        <?php if($upozela>0){?>
                        <select  class="form-control input-sm option1" disabled>
                        <?php 
                           createCombo("জেলা","tbl_upozila","id","name"," where district=".$district." ORDER BY name ",$upozela);
                           ?>
                        </select>
                        <input type="hidden" name="upozila" id="upozila" value="<?php echo $upozila;?>">
                        <?php }else{
                           if($district>0 ){
                            ?>
                        <select  class="form-control input-sm option1" name="upozila" id="upozila">
                        <?php 
                           createCombo("উপজেলার/সার্কেলের নাম","tbl_upozila","id","name"," where district=".$district." ORDER BY name ",$upozila);
                           ?>
                        </select>
                        <?php
                           }
                           else{
                           ?>                
                        <select name="upozila" id="upozila" class="form-control input-sm option1">
                           <option value="-1">প্রথমে জেলা নির্বাচন করুন</option>
                        </select>
                        <?php }
                           }
                           
                           ?>
                     </div>
                     <div class="col-sm-2">
                        <select name="task_statusid" id="task_statusid" class="form-control input-sm">
                        <?php 
                           createCombo("অবস্থা","tbl_taskstatus","task_statusid","task_statusname"," ORDER BY task_statusid ",'');
                           ?>
                        </select>
                     </div>
                     <div class="form-group col-xs-2 ">
                        <input type="text" name="filter" id="filter" class="form-control input-sm" placeholder="Search"  />
                     </div>
                     <div class="col-sm-12 pl0 pr0 text-center">
                        <button type="button" class="btn btn-primary btn-sm" onclick="sendData()" >দেখুন</button>
                        <button type="button"  class="btn btn-warning btn-sm" onClick="doPrint()">প্রিন্ট</button>
                        <button  onclick="myFunction()" type="button" class="btn btn-success btn-sm" ><i class="fa fa-file-excel-o"></i>&nbsp; Excel </button>
                     </div>
                  </form>
                  <div  id="dvContainer">
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
      $(document).ready(function() {
          $(window).keydown(function(event) {
              if (event.keyCode == 13) {
                  event.preventDefault();
                  return false;
              }
          });
      });
      
      var $loading = $('#load').hide();
      
      
      function validateContact() {
      	var valid = true;	
      	
      	$(".info").html('');
      
      	if($("#department").val() == '') {
      		$("#department-info").html("দয়া করে ডিপার্টমেন্টটি পূরণ করুন *");
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
      	$loading.show();
          $.ajax({
              type: "GET",
              url: "getrpt_ticketlist.php",
              data: $('#search').serialize(),
          }).done(function(msg) {
              $("#content").html(msg);
      		$loading.hide();
      		//alert(msg);
          }).fail(function(jqXHR, textStatus) {
              alert("Request failed: " + textStatus);
          });
      }
            $(document).ready(function () {
                window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });   
            });
      function myFunction() {
      		//alert("I am an alert box!");
      		window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=content]').html()));
      	} 
      	
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