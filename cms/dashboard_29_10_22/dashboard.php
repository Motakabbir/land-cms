<?php 
  include_once '../../Library/dbconnect.php';
  include_once '../../Library/Library.php';
  $pen=pick('tbl_progressstatus','duration','tbl_progressstatus.id=1');
  $due=pick('tbl_progressstatus','duration','tbl_progressstatus.id=2');
  $overdue=pick('tbl_progressstatus','duration','tbl_progressstatus.id=3');
  session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$Type=$_SESSION['SType'];
if (!isset($_SESSION['SUserID'])) {
	header("Location: login.php");
	exit;
}
$SDesignation=$_SESSION['SDesignation'];
$division=$_SESSION['Sdivision'] ;
$district=$_SESSION['Sdistrict'];
$upozela=$_SESSION['Supozela'];

?>
<!doctype html>
<html lang="en"><head>
	<meta charset="UTF-8">
	<title>দলিল</title>
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/alertify.core.css">
    <link rel="stylesheet" href="../../css/alertify.default.css" />
    <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
  	<link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../css/morris.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/new.css">
    <link rel="stylesheet" href="../../css/dbcss.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	  <script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="../../morris/morris.js"></script>
    
    <script src="../../js/alertify.js"></script>
    
<style>
	#alertify-cover{
		z-index:99999 !important;
		}
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
</head>
<body >
<div class="loading" id="loading" style=""> লোডিং হচ্ছে …</div>
 <div class="col-md-12" style="margin-top:5px">
  <!-- Custom Tabs (Pulled to the right) -->
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
    	
      <li class="dropdown">
        
        <select name="duration" id="duration" class="form-control input-sm option1">
            	<option value="-1"> সময়কাল </option>
            	<option value="1"> আজ</option>
            	<option value="6">গতকাল</option>
            	<option value="2">৭ দিন</option>
            	<option value="3">১ মাস</option>
            	<option value="4">১ বছর</option>
            	<option value="5">সব</option>
            </select>
      
      </li>
      <li>      
            <div class=" form-group pl0 pr0">
            
            </div>
        </li>
       <li>      
            <div class=" form-group pl0 pr0">
             <?php if($upozela>0){?>
           		<select  class="form-control input-sm option1" disabled>
					<?php 
                    createCombo("উপজেলার/সার্কেলের নাম","tbl_upozila","id","name"," where district=".$district." ORDER BY name ",$upozela);
                    ?>
                </select>
                <input type="hidden" name="upozila" id="upozila" value="<?php echo $upozela;?>">
           	 <?php }
			 else{
				 if($district>0 ){
					 ?>
                <select  class="form-control input-sm option1" name="upozila" id="upozila">
					<?php 
                        createCombo("উপজেলার/সার্কেলের নাম","tbl_upozila","id","name"," where district=".$district." ORDER BY name ",$upozela);
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
        </li>
       <li>      
            <div class=" form-group pl0 pr0">
             <?php if($district>0){?>
          		 <select  class="form-control input-sm option1" disabled>
					<?php 
                    createCombo("জেলা","tbl_district","id","name"," where division_id=".$division." ORDER BY name ",$district);
                    ?>
                </select>
                <input type="hidden" name="district" id="district" value="<?php echo $district;?>">
            <?php }
			else{
				
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
       </li>
      <li >
            <div class=" form-group  pl0 pr0">
            <?php 
			
				//echo $SDesignation;
				/* && ($SDesignation!=1 || $SDesignation!=2 || $SDesignation!=3 || $SDesignation!=4 || $SDesignation!=5)*/
			if($division>0 && ($SDesignation!=1 && $SDesignation!=2 && $SDesignation!=3 && $SDesignation!=4 && $SDesignation!=5 && $SDesignation!=25 && $SDesignation!=34 && $SDesignation!=35)){?>
				<select  class="form-control input-sm option1" disabled>
					<?php 
                    createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",$division);
                    ?>
                </select>
                <input type="hidden" name="division_id" id="division_id" value="<?php echo $division;?>">
				<?php
				}else{?>
                <select name="division_id" id="division_id" class="form-control input-sm option1">
					<?php 
                    createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",'');
                    ?>
                </select>
            <?php }?>
            </div>
      </li>
     
     
      <li class="pull-left header"><i class="fa fa-th"></i> ড্যাসবোর্ড</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
      <div class="tab-pane active" id="tab_1">
      </div>
      </div>
    </div>
  </div>
</div>
 <div class="col-md-6" style="margin-top:5px">
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
      
      <li class="pull-left header"><i class="fa fa-th"></i> সকল কল</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
     
      <div class="tab-pane active" id="tab_2">
      
   
      </div>
       
      
    </div>
  </div>
</div>
 <div class="col-md-6" style="margin-top:5px">
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
      
      <li class="pull-left header"><i class="fa fa-th"></i>অনিষ্পন্ন কল</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
     
      <div class="tab-pane active" id="tab_4">
      
   
      </div>
       
      
    </div>
  </div>
</div>

 <div class="col-md-12" style="margin-top:5px">
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
      
      <li class="pull-left header"><i class="fa fa-th"></i>  সেবা এর প্রকারভেদ অনুযায়ী কল</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
     
      <div class="tab-pane active" id="tab_5">
      
   
      </div>
       
      
    </div>
  </div>
</div>


<!-- <div class="col-md-6" style="margin-top:5px">
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
         সময়কাল <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li role="presentation"><a href="javascript:void(0)" role="menuitem" tabindex="-1" class="option6" href="#" data-value='1'>আজ</a></li>
          <li role="presentation"><a href="javascript:void(0)" role="menuitem" tabindex="-1" class="option6" href="#" data-value='2'>৭ দিন</a></li>
          <li role="presentation"><a href="javascript:void(0)" role="menuitem" tabindex="-1" class="option6" href="#" data-value='3'>১ মাস</a></li>
          <li role="presentation"><a href="javascript:void(0)" role="menuitem" tabindex="-1" class="option6" href="#" data-value='4'>১ বছর</a></li>
          <li role="presentation"><a href="javascript:void(0)" role="menuitem" tabindex="-1" class="option6" href="#" data-value='5'>সব</a></li>
        </ul>
      </li>
      <li class="pull-left header"><i class="fa fa-th"></i> প্রাধান্য অনুযায়ী কল</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
     
      <div class="tab-pane active" id="tab_6">
      
   
      </div>
       
      
    </div>
  </div>
</div>
-->
<?php if($Type==17 || $Type==1){?>
 <div class="col-md-12" style="margin-top:5px">
  <div class="nav-tabs-custom box-danger">
    <ul class="nav nav-tabs pull-right">
      <li class="pull-left header"><i class="fa fa-th"></i>  এজেন্ট</li>
    </ul>
    <div class="tab-content" style="background:#E8E8E8">
     
      <div class="tab-pane active" id="tab_6">
      
   
      </div>
       
      
    </div>
  </div>
</div>
<?php }?>

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../bower_components/chart.js/Chart.js"></script>
<script src="../../bower_components/chart.js/utils.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

  <script>
var $loading = $('#loading').hide();
$('#loading').hide();	
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
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
				var value= response;
				$('#district').html(value);
			}
		});
		}else{
			$('#district').html('<option value="-1">প্রথমে বিভাগ নির্বাচন করুন</option>');
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
				var value=response;
				$('#upozila').html(response);
			}
		});
		}else{
			$('#upozila').html('<option value="-1">প্রথমে জেলা নির্বাচন করুন</option>');
			}
	});
	$('.option1').on('change', function () {
		var duration = $('#duration').val();
		duration
		
		sendData(duration);
		sendData1(duration);
		sendData2(duration);
		sendData3(duration);
		sendData4(duration);
		//var $el = $(this);
		
		/*sendData($el.data('value'));
		sendData1($el.data('value'));
		sendData2($el.data('value'));
		sendData3($el.data('value'));
		sendData4($el.data('value'));*/
	});
  	function sendData(data){
			$loading.show();
			var division_id = $('#division_id').val();
			var district = $('#district').val();
			var upozila = $('#upozila').val();
			$.ajax({
				url:"get_top.php",
				type:"POST",
				data:{
				range:data,
				division_id:division_id,
				district:district,
				upozila:upozila				
					},
				cache: false,
				success: function(response){
					$('#tab_1').html(response);
					 $loading.hide();
				}
			});
			return false;
		};
	function sendData1(data){
			$loading.show();
			var division_id = $('#division_id').val();
			var district = $('#district').val();
			var upozila = $('#upozila').val();
			$.ajax({
				url:"get_status.php",
				type:"POST",
				data:{
					range:data,
				division_id:division_id,
				district:district,
				upozila:upozila	
					},
				cache: false,
				success: function(response){
					$('#tab_2').html(response);
					 $loading.hide();
				}
			});
			return false;
		};	
	function sendData2(data){			
			$loading.show();
			var division_id = $('#division_id').val();
			var district = $('#district').val();
			var upozila = $('#upozila').val();
			$.ajax({
				url:"get_status_ex.php",
				type:"POST",
				data:{
					range:data,
				division_id:division_id,
				district:district,
				upozila:upozila				
					},
				cache: false,
				success: function(response){
					$('#tab_4').html(response);
					 $loading.hide();
				}
			});
			return false;
		};	
	function sendData3(data){			
			$loading.show();
			var division_id = $('#division_id').val();
			var district = $('#district').val();
			var upozila = $('#upozila').val();
			$.ajax({
				url:"get_problemtype.php",
				type:"POST",
				data:{
					range:data,
				division_id:division_id,
				district:district,
				upozila:upozila			
					},
				cache: false,
				success: function(response){
					$('#tab_5').html(response);
					 $loading.hide();
				}
			});
			return false;
		};
	function sendData4(data){			
			$loading.show();
			var division_id = $('#division_id').val();
			var district = $('#district').val();
			var upozila = $('#upozila').val();
			$.ajax({
				url:"get_usertop.php",
				type:"POST",
				data:{
					range:data,
				division_id:division_id,
				district:district,
				upozila:upozila		
					},
				cache: false,
				success: function(response){
					$('#tab_6').html(response);
					 $loading.hide();
				}
			});
			return false;
		};			
		$( document ).ready(function() {
				sendData(1);
				sendData1(1);
				sendData2(1);
				sendData3(1);
				sendData4(1);
			});
			
  </script>
 		<script>
      /*  window.onload = function() {
        document.addEventListener("contextmenu", function(e){
        e.preventDefault();
        }, false);
        document.addEventListener("keydown", function(e) {
        //document.onkeydown = function(e) {
        // "I" key
        if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
        disabledEvent(e);
        }
        // "J" key
        if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        disabledEvent(e);
        }
        // "S" key + macOS
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        disabledEvent(e);
        }
        // "U" key
        if (e.ctrlKey && e.keyCode == 85) {
        disabledEvent(e);
        }
        // "F12" key
        if (event.keyCode == 123) {
        disabledEvent(e);
        }
        }, false);
        function disabledEvent(e){
        if (e.stopPropagation){
        e.stopPropagation();
        } else if (window.event){
        window.event.cancelBubble = true;
        }
        e.preventDefault();
        return false;
        }
        };
        document.oncontextmenu = function () { // Use document as opposed to window for IE8 compatibility
        return false;
        };
        
        window.addEventListener('contextmenu', function (e) { // Not compatible with IE < 9
        e.preventDefault();
        }, false);
        */
		
		
        </script>

</body>
</html>
