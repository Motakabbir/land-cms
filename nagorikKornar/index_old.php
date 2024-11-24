<?php 
session_start();
ini_set('display_errors', 'Off');
error_reporting(E_ALL);
require_once 'config.php';
require_once 'Facebook/autoload.php';
$loginurl = $gClient->createAuthUrl();
if (isset($_GET['state'])){
    $_SESSION['FBRLH_state'] = $_GET['state'];
}
$fb = new \Facebook\Facebook([
    'app_id' => '598083411583442',
    'app_secret' => 'ffced0583882d6bc3f691fb0026605fd',
    'default_graph_version' => 'v12.0',
    //'default_access_token' => '{access-token}', // optional
]);
if (empty($_SESSION['facebook_id'])){
    $fbLgnBtn = "<a href='{$fb->getRedirectLoginHelper()->getLoginUrl('https://hotline.land.gov.bd/nagorikKornar/fb.php')}' class='loginBtn loginBtn--facebook' data-toggle='tooltip'  title='Login with Facebook'>
    Login with Facebook
     </a>";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ভূমি মন্ত্রণালয়</title>
    <link href="http://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
   <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
        <link rel="stylesheet" href="../landing/fonts/fontawesome/css/font-awesome.min.css">
        <link rel=icon href="../images/bd1png.png"  sizes="16x16" type="image/png">       
        <link rel="stylesheet" href="../landing/css/helpers.css">
        <link rel="stylesheet" href="../landing/css/style.css">
        <link rel="stylesheet" href="../landing/css/landing-2.css">
        <link href="https://fonts.maateen.me/adorsho-lipi/font.css" rel="stylesheet">
        <link rel="stylesheet" href="../landing/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="../jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/select2.min.css">
    <style>
.pb_navbar ul > li > a.active {
background: white;
color: green !important;
}
a.nav-link:hover {
    background: white;
    color: green !important;
}
            nav#pb-navbar {
            padding: 13px;
        }


        .dataShowTableSection {
            background: #fff;
        }
        body{
            
                background: #059e11;
                background: -moz-linear-gradient(45deg, #059e11 0%, #269740 100%);
                background: -webkit-linear-gradient(45deg, #059e11 0%, #269740 100%);
                background: -o-linear-gradient(45deg, #059e11 0%, #269740 100%);
                background: linear-gradient(45deg, #059e11 0%, #269740 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#059e11', endColorstr='#269740',GradientType=1 );
            
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
           a.navbar-brand {
                display: block;
            }

            a.navbar-brand img {
                float: left;
                margin-right: 10px;
            }

            a.navbar-brand span {
                display: block;
                padding-top: 22px;
            }

            section#mainContent {
                display: block;
                overflow: hidden;
                padding-top: 50px;
            }
        
            .form-control {
                height: 29px;
                outline: none;
                border-radius: 0;
                border: none;
                font-size: 14px;
                line-height: 19px;
                padding: 0 12px;
            }

            textarea.form-control {
                min-height: 45px;
                padding-top: 5px;
            }

            label {
                font-size: 14px;
            }

            .error {
                font-size: 13px;
                color: #981c1c;
                margin-bottom: -10px;
            }

            .form-group {
                margin-bottom: 10px;
            }
            .footerPartner {
                text-align: center;
            }

            .footerPartner span {
                display: block;
                font-size: 13px;
            }

            .footerPartner a {
                display: block;
                text-align: center;
            }

            .footerPartner a img {
                width: 113px;
                margin: auto;
                padding-top: 8px;
            }
            .control-label {
                color: #eaeaea;
                font-family: auto;
            }
             select{
                -webkit-appearance: none;
            }
            /* Shared */
            .loginBtn {
              box-sizing: border-box;
              position: relative;
              /* width: 13em;  - apply for fixed size */
              margin: 0.2em;
              padding: 0 15px 0 46px;
              border: none;
              text-align: left;
              line-height: 34px;
              white-space: nowrap;
              border-radius: 0.2em;
              font-size: 16px;
              color: #FFF;
            }
            .loginBtn:before {
              content: "";
              box-sizing: border-box;
              position: absolute;
              top: 0;
              left: 0;
              width: 34px;
              height: 100%;
            }
            .loginBtn:focus {
              outline: none;
            }
            .loginBtn:active {
              box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
            }


            /* Facebook */
            .loginBtn--facebook {
              background-color: #4C69BA;
              background-image: linear-gradient(#4C69BA, #3B55A0);
              /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
              text-shadow: 0 -1px 0 #354C8C;
            }
            .loginBtn--facebook:before {
              border-right: #364e92 1px solid;
              background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
            }
            .loginBtn--facebook:hover,
            .loginBtn--facebook:focus {
              background-color: #5B7BD5;
              background-image: linear-gradient(#5B7BD5, #4864B1);
            }


            /* Google */
            .loginBtn--google {
              /*font-family: "Roboto", Roboto, arial, sans-serif;*/
              background: #DD4B39;
            }
            .loginBtn--google:before {
              border-right: #BB3F30 1px solid;
              background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
            }
            .loginBtn--google:hover,
            .loginBtn--google:focus {
              background: #E74B37;
            }

            /* mygov */
            .loginBtn--mygov {
              /*font-family: "Roboto", Roboto, arial, sans-serif;*/
              background: #c92461;
            }
            .loginBtn--mygov:before {
                border-right: #BB3F30 1px solid;              
                content: "\M";
                display: inline-block;
                padding-right: 3px;
                vertical-align: middle;
                font-weight: 900;
                padding-left: 7px;
                font-size: 24px;
                border-right: 1px solid #7c7c7c;
            }
            .loginBtn--mygov:hover,
            .loginBtn--mygov:focus {
              background: #c92461;
            }

             
            section#mainContent {
                text-align: center;
            }

            section#mainContent:hover a, section#mainContent button:hover {
                color: #fff;
            }

            section#mainContent a, section#mainContent button {
                height: 38px;
                display: inline-block;
                font-size: 13px;
                line-height: 38px;
                text-decoration: none;
            }
            section#mainContent h2 {
                margin: 0;
                color: #fff;
                font-size: 23px;
                margin-bottom: 16px;
            }
			
			footer a img{
				margin:auto;
			}
			
			@media screen and (max-width: 600px) {
				.collapse.in {
					display: block !important;
				}
				
				footer a img {
					width: 50px !important;
					max-height:50px;
				}
				
				
				.navbar-toggler {
					position: relative;
					display: block !important;
					left: 0;
					top: -3px;
					width: 24px;
					height: 3px !important;
					content: "";
					background: #333;
					border-radius: 0;
					border: none !important;
					padding: 0;
				}
				
				.navbar-toggler::after {
					position: absolute;
					right: 0;
					top: 14px;
					width: 24px;
					height: 3px;
					background: #333;
					content: "";
				}
				
				.navbar-toggler::before {
					position: absolute;
					right: 0;
					top: 7px;
					width: 24px;
					height: 3px;
					background: #333;
					content: "";
				}
			}



    </style>
</head>
<?php 

include_once '../Library/dbconnect.php';
include_once '../Library/Library.php';
 
?>
<body data-spy="scroll" data-target="#pb-navbar" data-offset="200" style="font-family:'AdorshoLipi', Montserrat, sans-serif !important;">
<nav class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light" id="pb-navbar">

            <div class="container">


                <a class="navbar-brand" href="/"><img src="../landing/images/logo.png" class="img-responsive"> <span>ভূমি মন্ত্রণালয়</span></a>

                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span><i class="ion-navicon"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="probootstrap-navbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="../login.php">প্রশাসনিক লগইন</a></li>
                        <li class="nav-item"><a class="nav-link" href="/portal">কল অনুসন্ধান</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#">নাগরিক কর্নার</a></li>
                    </ul>

                </div>
            </div>
        </nav>
       

<section id="mainContent" >

<?php 

    if($_SESSION['google_id']=='' &&  $_SESSION['facebook_id']==''){
?>

<h2>ফেইসবুক অথবা গুগল দিয়ে লগইন করুন</h2>
 <?php //echo $fbLgnBtn; ?>
<button href="javascript:void(0)" onclick="window.location = '<?php echo $loginurl;?>'"  data-toggle="tooltip"  class="loginBtn loginBtn--google" > Login with Google</button>
<button href="javascript:void(0)" onclick="window.location = '../nagorik'"  data-toggle="tooltip"  class="loginBtn loginBtn--mygov" > Login with My Gov</button>
<?php }else{?>
<div class=" ">
<div class="col-sm-12 ">                               
        <form class="form-horizontal" id="sales_form" action="">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                        <input type="hidden" name="task_type" value="3">
                            <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                            <div class="col-sm-8">
                                <span id="txtcontact_person-info" class="info" ></span>
                                <input type="text" class="form-control " name="txtcontact_person" id="txtcontact_person"  placeholder="নাম " value="<?php echo $_SESSION['facebook_name'].$_SESSION['google_name'];?>" readonly>
                                <input type="hidden" name="fb_id"   value="<?php echo $_SESSION["facebook_id"];?>">
                                <input type="hidden" name="google_id" value="<?php echo $_SESSION["google_id"]?>">
                            </div>
                        </div>
                    </div>
                     <div class="col-xs-6">
                        <div class="form-group">
                            <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                            <div class="col-sm-8">
                                <span id="txtcontact_person_no-info" class="info" ></span>
                                <input type="text" class="form-control " name="txtcontact_number" id="txtcontact_number" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 ">
                        <div class="form-group">
                            <label for="txtcontact_number" class="col-sm-4 control-label">ইমেইল </label>
                            <div class="col-sm-8 ">
                                <input type="email" class="form-control " name="txtcontact_email" id="txtcontact_email" value="<?php echo $_SESSION["google_email"]?>" placeholder="ইমেইল ">
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
                               <select class="form-control  " name='service_type' id='service_type' style="width:100%">
                                    <?php
                                    createCombo("সেবার ধরন","tbl_service_type","prob_id","prob_name"," where srv_type=1 Order by prob_id",'');
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-6" id="pro_others" style="display:none">
                        <div class="form-group">
                            <label for="others_problem" class="col-sm-4 control-label">অন্যান্য </label>
                            <div class="col-sm-8">
                                <span id="others_problem-info" class="info" ></span>                                                        <input type="text" class="form-control " name="others_problem" id="others_problem" value="" placeholder="অন্যান্য">
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-6" id="pro_diaplay">
                        <div class="form-group">
                            <label for="prob_id" class="col-sm-4 control-label">সমস্যার ধরন <span class="color">*</span></label>
                            <div class="col-sm-8">
                                <span id="prob_id-info" class="info" ></span>                                                        
                                <select class="form-control "  name='prob_id' id='prob_id'  >
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
                            <select name="division_id" id="division_id" class="form-control ">
                            <?php 
                                createCombo("বিভাগ","tbl_division","id","name"," ORDER BY name ",$division_id);
                              ?>
                           </select>
                        </div>
                    </div> 
                   </div>
                   <div class="col-sm-6">
                    <div class="form-group ">
                            <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                            <div class="col-sm-8">
                                <span id="name-info" class="info" ></span>
                                <select name="district" id="district" class="form-control ">
                                    <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                </select>
                            </div>
                           </div> 
                   </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" id="upodisplay">
                        <div class="form-group ">
                            <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                            <div class="col-sm-8">
                                <span id="name-info" class="info" ></span>
                                <select name="upozila" id="upozila" class="form-control ">
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
                                <input type="hidden" class="form-control  time " name="down_time" id="down_time" value="<?php echo date('d/m/Y H:i');?>" placeholder="dd/mm/yy">
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
                                <input type="text" class="form-control " name="txtsubject" id="txtsubject" value="" placeholder="কলের বিষয়">
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class=" col-sm-8">
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
                 <div class="row" id="montobo" style="display:none">
                    <div class=" col-xs-8">
                        <div class="form-group">
                            <label for="solv_solution" class="col-sm-3 control-label">
মন্তব্য <span class="color">*</span></label>
                            <div class="col-sm-9">
                                <span id="solv_solution-info" class="info" ></span>
                                <textarea type="text" class="form-control " name='solv_solution' id='solv_solution' placeholder="কলের বিবরণ"></textarea>
                            </div>
                        </div>
                    </div>
                  
                </div>
              
                
                <div class="row text-center">
                      <div class="col-xs-4 col-xs-offset-4 text-center">
                        <button type="submit" id="btn" class="btn btn-primary btn-sm submit" name="submit" id="submit" >জমা দিন <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
    </div>
</div>
<?php }?>
</section>

<style>
	.footer{
		padding:10px;position:
		fixed;width: 100%;
		height: auto;
		background: #fff;bottom: 0;
		}
	
		/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
	.footer{
		padding:10px;
		position:inherit;
		width: 100%;
		height: auto;
		background: #fff;bottom: 0;
		}
		.footerPartner span {
                display: block;
                font-size: 10px;
            }
		}




	
	
</style>
<footer class="pb_ footer bg- light" role="contentinfo" style="padding:10px;position: fixed;width: 100%;height: auto;background: #fff;bottom: 0;">
    <div class="container">
        <div class="row" style="margin-top:5px"><br>
            
            <div class="col-sm-4 col-4 col-md-4 col-xl-4 text-center " style="color:black; font-weight: 400">                       
                    <a href="https://minland.gov.bd/"><img style="width: 40%;" src="../landing/images/logo-mobile.png" class="img-responsive"></a>
                     <span style="font-size:12px; font-weight:400; color:#000;">© মেধাস্বত্ত্ব ভূমি মন্ত্রণালয় 
            </span>
            </div>
            <div class="col-sm-4 col-4 col-md-4 col-xl-4 text-center " style="color:black; font-weight: 400">
             
            </div>
           <div class="col-sm-4 col-4 col-md-4 col-xl-4 text-center">
            <div style="color:black; font-weight: 400">
                <a href="http://nextech.com.bd/"><img src="../landing/images/nextechlogo-1.png" class="img-responsive" style="width:46%"></a>
               <span style="font-size:12px; font-weight:400; color:#000;">সফটওয়্যার উন্নয়নে</span>
            </div>
           </div>
        </div>

    </div>
</footer>

    
   
   <script src="../js/select2.min.js"></script>
    <script src="../js/alertify.min.js"></script>
     <script src="../js/jquery.form.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
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
            var btn = document.getElementById('btn');
                    btn.disabled = true;
                    btn.innerText = 'Posting...'
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
                    //console.log(msg);
                    if(msg==1){
                        alertify.success('আপনার অভিযোগ গৃহীত হয়েছে.');
                      //  document.getElementById("sales_form").reset();
                       window.location.assign("http://hotline.land.gov.bd") 
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
            url: "../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
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
            url: "../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
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
    /*$('#txtcontact_number').on('change',function(){
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
    });*/
    $('#service_type').on('change',function(){
        var service_type = $(this).val();
        
        
        if(service_type==14){
            $('#pro_others').show();
        }else{
            $('#pro_others').hide();
            }
        if(service_type==8 || service_type==12 || service_type==11){
                $('#montobo').show();
            }else{
                $('#montobo').hide();

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
<?php 
session_unset();
    session_destroy();

?>



