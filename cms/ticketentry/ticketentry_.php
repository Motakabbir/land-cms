<?php
   include( '../../vendor/autoload.php' );
   use\ Firebase\ JWT\ JWT;
   
   include_once '../header.php';
   include_once '../../Library/dbconnect.php';
   include_once '../../Library/Library.php';
   $mobile =  substr($_REQUEST[ 'mobile' ], -11);
   
   function get_client_ip() {
     $ipaddress = '';
     if ( isset( $_SERVER[ 'HTTP_CLIENT_IP' ] ) )
       $ipaddress = $_SERVER[ 'HTTP_CLIENT_IP' ];
     else if ( isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) )
       $ipaddress = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
     else if ( isset( $_SERVER[ 'HTTP_X_FORWARDED' ] ) )
       $ipaddress = $_SERVER[ 'HTTP_X_FORWARDED' ];
     else if ( isset( $_SERVER[ 'HTTP_FORWARDED_FOR' ] ) )
       $ipaddress = $_SERVER[ 'HTTP_FORWARDED_FOR' ];
     else if ( isset( $_SERVER[ 'HTTP_FORWARDED' ] ) )
       $ipaddress = $_SERVER[ 'HTTP_FORWARDED' ];
     else if ( isset( $_SERVER[ 'REMOTE_ADDR' ] ) )
       $ipaddress = $_SERVER[ 'REMOTE_ADDR' ];
     else
       $ipaddress = 'UNKNOWN';
     return $ipaddress;
   }
   $newip = get_client_ip();
   $pices = explode( ".", $newip );
   $localip = $pices[ '0' ] . '.' . $pices[ '1' ] . '.' . $pices[ '2' ];
   //if($localip!='192.168.111' && $mobile!=''){
   // die;
   //  header("Location : ../../dashboard.php");
   // }
   
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
   .color {
   font-size: 9px;
   color: red;
   }
   .input-group {
   position: relative !important;
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
   .nav-tabs.nav-tabs-dropdown, .nav-tabs-dropdown {
   border: 1px solid #dddddd;
   border-radius: 5px;
   overflow: hidden;
   position: relative;
   }
   .nav-tabs.nav-tabs-dropdown::after, .nav-tabs-dropdown::after {
   content: "☰";
   position: absolute;
   top: 8px;
   right: 15px;
   z-index: 2;
   pointer-events: none;
   }
   .nav-tabs.nav-tabs-dropdown.open a, .nav-tabs-dropdown.open a {
   position: relative;
   display: block;
   }
   .nav-tabs.nav-tabs-dropdown.open > li.active > a, .nav-tabs-dropdown.open > li.active > a {
   background-color: #eeeeee;
   }
   .nav-tabs.nav-tabs-dropdown li, .nav-tabs-dropdown li {
   display: block;
   padding: 0;
   vertical-align: bottom;
   }
   .nav-tabs.nav-tabs-dropdown > li > a, .nav-tabs-dropdown > li > a {
   position: absolute;
   top: 0;
   left: 0;
   margin: 0;
   width: 100%;
   height: 100%;
   display: inline-block;
   border-color: transparent;
   }
   .nav-tabs.nav-tabs-dropdown > li > a:focus, .nav-tabs-dropdown > li > a:focus, .nav-tabs.nav-tabs-dropdown > li > a:hover, .nav-tabs-dropdown > li > a:hover, .nav-tabs.nav-tabs-dropdown > li > a:active, .nav-tabs-dropdown > li > a:active {
   border-color: transparent;
   }
   .nav-tabs.nav-tabs-dropdown > li.active > a, .nav-tabs-dropdown > li.active > a {
   display: block;
   border-color: transparent;
   position: relative;
   z-index: 1;
   background: #fff;
   }
   .nav-tabs.nav-tabs-dropdown > li.active > a:focus, .nav-tabs-dropdown > li.active > a:focus, .nav-tabs.nav-tabs-dropdown > li.active > a:hover, .nav-tabs-dropdown > li.active > a:hover, .nav-tabs.nav-tabs-dropdown > li.active > a:active, .nav-tabs-dropdown > li.active > a:active {
   border-color: transparent;
   }
   }
   .active>a {
   background: #0da25e !important;
   color: #fff !important;
   font-weight: bold;
   font-size: 16px !important;
   }
   .blog-body {
   /* padding: 15px; */
   position: relative;
   overflow: hidden;
   border: 1px solid #dfe6ee;
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
   li>a {
   color: green;
   }
   .blog-body {
   padding: 0px; 
   position: relative;
   overflow: hidden;
   border: 1px solid #dfe6ee;
   }
</style>
<body  data-skin-type="skin-polaris-blue" class="skin-colortic">
   <div class="loading" id="loading" style=""> লোড হচ্ছে ...</div>
   <div id="u-app-wrapper"   class="collapse-true panel-fixed">
      <div class="content-wrapper">
         <div class="col-md-12 pl0 pr0 main-body">
            <div class="blog blog-info">
               <div class="blog-body ">
                  <div class="demo">
                     <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified nav-tabs-dropdown" role="tablist">
                           <li role="presentation" class="active"><a href="#complaint" aria-controls="complaint" role="tab" data-toggle="tab">অভিযোগ</a></li>
                           <li role="presentation" class=""><a href="#info_app" aria-controls="info_app" role="tab" data-toggle="tab">তথ্য অনুসন্ধান সেবা</a></li>
                           <li role="presentation"><a href="#request" aria-controls="request" role="tab" data-toggle="tab">আবেদন</a></li>
                           <li role="presentation"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"> আবেদনের অবস্থা</a></li>
                           <li role="presentation"><a href="#service" aria-controls="info" role="tab" data-toggle="tab">সেবা সংক্রান্ত তথ্য</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                           <div role="tabpanel" class="tab-pane active" id="complaint">
                              <div class="col-sm-12 ">
                                 <form class="form-horizontal" id="complaint_form" name="complaint_form" action="">
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="nid" class="col-sm-4 control-label">জাতীয় পরিচয়পত্র<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="nid-info" class="info"></span>
                                                <input type="text" class="form-control input-sm" name="nid" id="nid" value="" placeholder="জাতীয় পরিচয়পত্র" onchange="getNifdData(complaint_form);allSyn(this,'input','nid')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="dateOfBirth" class="col-sm-4 control-label">জন্ম তারিখ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="dateOfBirth-info" class="info"></span>
                                                <input type="text" class="form-control datetimepicker input-sm" name="dateOfBirth" id="dateOfBirth" value="" placeholder="জন্ম তারিখ" onchange="getNifdData(complaint_form);allSyn(this,'input','dateOfBirth')">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <input type="hidden" name="task_type" value="1">
                                             <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম " onchange="allSyn(this,'input','txtcontact_person')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txttxtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?>>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_person_no" class="col-sm-4 control-label">অন্যান্য মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person_no" id="txtcontact_person_no" value="<?php echo $mobile;?>" placeholder="অন্যান্য মুঠোফোন" onchange="allSyn(this,'input','txtcontact_person_no')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-4 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (1) Order by id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6 ">
                                          <div class="form-group">
                                             <label for="txtcontact_email" class="col-sm-4 control-label">ইমেইল </label>
                                             <div class="col-sm-8 ">
                                                <input type="email" class="form-control input-sm" name="txtcontact_email" id="txtcontact_email" value="" placeholder="ইমেইল " onchange="allSyn(this,'input','txtcontact_email')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtaddress" class="col-sm-4 control-label">ঠিকানা</label>
                                             <div class="col-sm-8 "> <span id="txtaddress-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='txtaddress' id='' placeholder="ঠিকানা" onchange="allSyn(this,'textarea','txtaddress')"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_type" class="col-sm-4 control-label">সেবার ধরন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_type-info" class="info" ></span>
                                                <select class="form-control input-sm  service_type" name='service_type' id='service_type' style="width:100%" onchange="allSyn(this,'select','service_type')">
                                                <?php
                                                   createCombo( "সেবার ধরন", "tbl_service_type", "prob_id", "prob_name", " where srv_type in (1) Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6 pro_others"  style="display:none">
                                          <div class="form-group">
                                             <label for="others_problem" class="col-sm-4 control-label">অন্যান্য </label>
                                             <div class="col-sm-8"> <span id="others_problem-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="others_problem" id="others_problem" value="" placeholder="অন্যান্য" onchange="allSyn(this,'input','others_problem')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6 pro_diaplay" >
                                          <div class="form-group">
                                             <label for="prob_id" class="col-sm-4 control-label">সমস্যার ধরন <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="prob_id-info" class="info" ></span>
                                                <select class="form-control input-sm"  name='prob_id' id='prob_id' onchange="allSyn(this,'select','prob_id')" >
                                                <?php
                                                   createCombo( "সমস্যার ধরন", "tbl_problem", "prob_id", "prob_name", "Order by prob_id", '' );
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
                                                <select name="division_id" id="division_id" class="division_id form-control input-sm" onchange="allSyn(this,'select','division_id')">
                                                <?php
                                                   createCombo( "বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division_id );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                          <div class="col-sm-8">
                                             <span id="name-info" class="info" ></span>
                                             <select name="district" id="district" class="district form-control input-sm" onchange="allSyn(this,'select','district')">
                                                <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6 upodisplay"  >
                                          <div class="form-group ">
                                             <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="upozila" id="upozila" class="upozila form-control input-sm" onchange="allSyn(this,'select','upozila')">
                                                   <option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row"> </div>
                                    <div class="row">
                                       <input type="hidden" class="form-control datetimepicker time input-sm" name="down_time" id="down_time" value="<?php echo date('d/m/Y H:i');?>" placeholder="dd/mm/yy">
                                    </div>
                                    <div class="row">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="txtsubject" class="col-sm-3 control-label"> কলের বিষয় <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtsubject-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtsubject" id="txtsubject" value="" placeholder="কলের বিষয়" onchange="allSyn(this,'input','txtsubject')">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="txtdescription" class="col-sm-3 control-label"> কলের বিবরণ <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtdescription-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='txtdescription' id='txtdescription' placeholder="কলের বিবরণ" onchange="allSyn(this,'textarea','txtdescription')"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row montobo"   style="display:none">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="solv_solution" class="col-sm-3 control-label"> মন্তব্য <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="solv_solution-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='solv_solution' id='solv_solution' placeholder="কলের বিবরণ" onchange="allSyn(this,'textarea','solv_solution')"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row "  >
                                       <div class=" col-xs-2">
                                       </div>
                                       <div class=" col-xs-8">
                                          <div class="checkbox">
                                            <label><input type="checkbox" value="1" name="protaion" id="protaion" required >আমি এই মর্মে প্রত্যয়ন করিতেছি যে আমি এখানে যে সকল তথ্য দিয়েছে তা সঠিক ।</label>
                                          </div>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row text-center">
                                       <button type="submit" class="btn btn-primary btn-sm submit" name="submit" id="submit" >জমা দিন <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </div>
                                    <br>
                                    <div class="row" id="view"></div>
                                 </form>
                              </div>
                           </div>
                           <div role="tabpanel" class="tab-pane " id="info_app">
                              <div class="col-sm-12 ">
                                 <form class="form-horizontal" id="info_app_form" class="info_app_form" action="">
                                    <input type="hidden" name="task_type" value="3">
                                    <!-- <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="nid" class="col-sm-4 control-label">জাতীয় পরিচয়পত্র<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="nid-info" class="info"></span>
                                                <input type="text" class="form-control input-sm" name="nid" id="nid" value="" placeholder="জাতীয় পরিচয়পত্র" onchange="getNifdData(complaint_form);allSyn(this,'input','nid')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="dateOfBirth" class="col-sm-4 control-label">জন্ম তারিখ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="dateOfBirth-info" class="info"></span>
                                                <input type="text" class="form-control datetimepicker input-sm" name="dateOfBirth" id="dateOfBirth" value="" placeholder="জন্ম তারিখ" onchange="getNifdData(complaint_form);allSyn(this,'input','dateOfBirth')">
                                             </div>
                                          </div>
                                       </div>
                                    </div> -->
                                    <div class="row">
                                       <!-- <div class="col-xs-6">
                                          <div class="form-group">
                                             
                                             <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম " onchange="allSyn(this,'input','txtcontact_person')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txttxtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?>>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <!-- <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_person_no" class="col-sm-4 control-label">অন্যান্য মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person_no" id="txtcontact_person_no" value="<?php echo $mobile;?>" placeholder="অন্যান্য মুঠোফোন" onchange="allSyn(this,'input','txtcontact_person_no')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-4 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (3) Order by id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <!-- <div class="col-xs-6 ">
                                          <div class="form-group">
                                             <label for="txtcontact_email" class="col-sm-4 control-label">ইমেইল </label>
                                             <div class="col-sm-8 ">
                                                <input type="email" class="form-control input-sm" name="txtcontact_email" id="txtcontact_email" value="" placeholder="ইমেইল " onchange="allSyn(this,'input','txtcontact_email')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <!-- <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtaddress" class="col-sm-4 control-label">ঠিকানা</label>
                                             <div class="col-sm-8 "> <span id="txtaddress-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='txtaddress' id='' placeholder="ঠিকানা" onchange="allSyn(this,'textarea','txtaddress')"></textarea>
                                             </div>
                                          </div>
                                       </div> -->
                                    </div> 
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_type" class="col-sm-4 control-label">সেবার ধরন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_type-info" class="info" ></span>
                                                <select class="form-control input-sm  service_type" name='service_type' id='service_type' style="width:100%" onchange="allSyn(this,'select','service_type')">
                                                <?php
                                                   createCombo( "সেবার ধরন", "tbl_service_type", "prob_id", "prob_name", " where srv_type in (3) and prob_id=12 Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- <div class="col-xs-6 pro_others"  style="display:none">
                                          <div class="form-group">
                                             <label for="others_problem" class="col-sm-4 control-label">অন্যান্য </label>
                                             <div class="col-sm-8"> <span id="others_problem-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="others_problem" id="others_problem" value="" placeholder="অন্যান্য" onchange="allSyn(this,'input','others_problem')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <!-- <div class="col-xs-6 pro_diaplay" >
                                          <div class="form-group">
                                             <label for="prob_id" class="col-sm-4 control-label">সমস্যার ধরন <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="prob_id-info" class="info" ></span>
                                                <select class="form-control input-sm"  name='prob_id' id='prob_id' onchange="allSyn(this,'select','prob_id')" >
                                                <?php
                                                   //createCombo( "সমস্যার ধরন", "tbl_problem", "prob_id", "prob_name", "Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div> -->
                                    </div>
                                   <!--  <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group ">
                                             <label for="division_id" class="col-sm-4 control-label">বিভাগের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8 " >
                                                <select name="division_id" id="division_id" class="division_id form-control input-sm" onchange="allSyn(this,'select','division_id')">
                                                <?php
                                                   createCombo( "বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division_id );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                          <div class="col-sm-8">
                                             <span id="name-info" class="info" ></span>
                                             <select name="district" id="district" class="district form-control input-sm" onchange="allSyn(this,'select','district')">
                                                <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div> -->
                                    <!-- <div class="row">
                                       <div class="col-sm-6 upodisplay"  >
                                          <div class="form-group ">
                                             <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="upozila" id="upozila" class="upozila form-control input-sm" onchange="allSyn(this,'select','upozila')">
                                                   <option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div> -->
                                    <div class="row"> </div>
                                    <div class="row">
                                       <input type="hidden" class="form-control datetimepicker time input-sm" name="down_time" id="down_time" value="<?php echo date('d/m/Y H:i');?>" placeholder="dd/mm/yy">
                                    </div>
                                    <div class="row">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="txtsubject" class="col-sm-3 control-label"> কলের বিষয় <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtsubject-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtsubject" id="txtsubject" value="" placeholder="কলের বিষয়" onchange="allSyn(this,'input','txtsubject')">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="txtdescription" class="col-sm-3 control-label"> কলের বিবরণ <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="txtdescription-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='txtdescription' id='txtdescription' placeholder="কলের বিবরণ" onchange="allSyn(this,'textarea','txtdescription')"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row montobo"   style="display:none">
                                       <div class=" col-xs-8">
                                          <div class="form-group">
                                             <label for="solv_solution" class="col-sm-3 control-label"> মন্তব্য <span class="color">*</span></label>
                                             <div class="col-sm-9"> <span id="solv_solution-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='solv_solution' id='solv_solution' placeholder="কলের বিবরণ" onchange="allSyn(this,'textarea','solv_solution')"></textarea>
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
                           </div>
                           <div role="tabpanel" class="tab-pane " id="request">
                              <div class="col-sm-12 ">
                                 <form class="form-horizontal" id="request_form" action="">
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="nid" class="col-sm-4 control-label">জাতীয় পরিচয়পত্র<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="nid-info" class="info"></span>
                                                <input type="text" class="form-control input-sm" name="nid" id="nid" value="" placeholder="জাতীয় পরিচয়পত্র" onchange="getNifdData(complaint_form);allSyn(this,'input','nid')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="dateOfBirth" class="col-sm-4 control-label">জন্ম তারিখ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="dateOfBirth-info" class="info"></span>
                                                <input type="text" class="form-control datetimepicker input-sm" name="dateOfBirth" id="dateOfBirth" value="" placeholder="জন্ম তারিখ" onchange="getNifdData(complaint_form);allSyn(this,'input','dateOfBirth')">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input type="hidden" name="task_type" value="2">
                                             <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person-info" class="info" ></span>
                                                <input type="text" onChange="getInfo();allSyn(this,'input','txtcontact_person')" class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম " >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txttxtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?> onChange="getInfo()" >
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_person_no" class="col-sm-4 control-label">অন্যান্য মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person_no" id="txtcontact_person_no" value="<?php echo $mobile;?>" placeholder="অন্যান্য মুঠোফোন" onchange="allSyn(this,'input','txtcontact_person_no')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-4 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (2) Order by id", '' );
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
                                                <select name="division_id" id="division_id" class="division_id form-control input-sm" onChange="getInfo();allSyn(this,'select','division_id')">
                                                <?php
                                                   createCombo( "বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division_id );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                          <div class="col-sm-8">
                                             <span id="name-info" class="info" ></span>
                                             <select name="district" id="district" class="district form-control input-sm" onChange="getInfo();allSyn(this,'select','district')">
                                                <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6 upodisplay"  >
                                          <div class="form-group ">
                                             <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="upozila" id="upozila" class="upozila form-control input-sm" onChange="getInfo();allSyn(this,'select','upozila')">
                                                   <option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_type" class="col-sm-4 control-label">আবেদনের নাম<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_type-info" class="info" ></span>
                                                <select class="form-control input-sm select2 service_type" name='service_type' id='service_type' style="width:100%" onChange="getInfo();allSyn(this,'select','service_type')">
                                                <?php
                                                   //and prob_id in (15,17);
                                                   createCombo( "সেবার ধরন", "tbl_service_type", "prob_id", "prob_name", " where srv_type in (2)  Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-12 text-center" id="application"> </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div role="tabpanel" class="tab-pane " id="info">
                              <div class="col-sm-12 ">
                                 <form class="form-horizontal" id="info_form" action="">
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="nid" class="col-sm-4 control-label">জাতীয় পরিচয়পত্র<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="nid-info" class="info"></span>
                                                <input type="text" class="form-control input-sm" name="nid" id="nid" value="" placeholder="জাতীয় পরিচয়পত্র" onchange="getNifdData(complaint_form);allSyn(this,'input','nid')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="dateOfBirth" class="col-sm-4 control-label">জন্ম তারিখ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="dateOfBirth-info" class="info"></span>
                                                <input type="text" class="form-control datetimepicker input-sm" name="dateOfBirth" id="dateOfBirth" value="" placeholder="জন্ম তারিখ" onchange="getNifdData(complaint_form);allSyn(this,'input','dateOfBirth')">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txttxtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number_info" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?>>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-1"> অথবা </div>
                                       <div class="col-xs-5">
                                          <div class="form-group">
                                             <label for="traking_id" class="col-sm-4 control-label">আবেদনের নম্বর <span class="color">*</span></label>
                                             <div class="col-sm-6"> <span id="traking_id-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="traking_id" id="traking_id_info" value="" placeholder="আবেদনের নম্বর" >
                                             </div>
                                             <div class="col-sm-6">
                                                <label>
                                                <input type="checkbox" value="1" name="certificate">
                                                সনদপত্র এর স্থিতি </label> 
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_person_no" class="col-sm-4 control-label">অন্যান্য মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person_no" id="txtcontact_person_no" value="<?php echo $mobile;?>" placeholder="অন্যান্য মুঠোফোন" onChange="allSyn(this,'input','txtcontact_person_no')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-4 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (3) Order by id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input type="hidden" name="task_type" value="3">
                                             <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person-info" class="info" ></span>
                                                <input type="text" onChange="getInfo();allSyn(this,'input','txtcontact_person')" class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম ">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group ">
                                             <label for="division_id" class="col-sm-4 control-label">বিভাগের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8 " >
                                                <select name="division_id" id="division_id" class="division_id form-control input-sm" onChange="getInfo();allSyn(this,'select','division_id')">
                                                <?php
                                                   createCombo( "বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division_id );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
                                             <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="district" id="district" class="district form-control input-sm" onChange="getInfo();allSyn(this,'select','district')">
                                                   <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6 upodisplay"  >
                                          <div class="form-group ">
                                             <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="upozila" id="upozila" class="upozila form-control input-sm" onchange="allSyn(this,'select','upozila')">
                                                   <option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_type" class="col-sm-4 control-label">সকল সেবা<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_type-info" class="info" ></span>
                                                <select class="form-control input-sm  info_type" name='service_type' id='service_type' style="width:100%" onchange="allSyn(this,'select','service_type')">
                                                <?php
                                                   createCombo( "সকল সেবা", "tbl_service_type", "prob_id", "prob_name", " where srv_type in (3) and prob_id<>12 Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6 text-center" >
                                          <button type="button" onClick="getAppicationdetails()" class="btn btn-primary btn-sm submit" >অনুসন্ধান <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                       </div>
                                    </div>
                                    <div class="row" id="tracking_info"> </div>
                                 </form>
                              </div>
                           </div>
                           <div role="tabpanel" class="tab-pane " id="service">
                              <div class="col-sm-12 ">
                                 <form class="form-horizontal" id="service_form" action="">
                                    <input type="hidden" name="task_type" value="3">
                                    <!-- <div class="row">
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="nid" class="col-sm-4 control-label">জাতীয় পরিচয়পত্র<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="nid-info" class="info"></span>
                                                <input type="text" class="form-control input-sm" name="nid" id="nid" value="" placeholder="জাতীয় পরিচয়পত্র" onchange="getNifdData(complaint_form);allSyn(this,'input','nid')">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="dateOfBirth" class="col-sm-4 control-label">জন্ম তারিখ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="dateOfBirth-info" class="info"></span>
                                                <input type="text" class="form-control datetimepicker input-sm" name="dateOfBirth" id="dateOfBirth" value="" placeholder="জন্ম তারিখ" onchange="getNifdData(complaint_form);allSyn(this,'input','dateOfBirth')">
                                             </div>
                                          </div>
                                       </div>
                                    </div> -->
                                    <div class="row">
                                       <!-- <div class="col-md-6">
                                          <div class="form-group">
                                             
                                             <label for="txtcontact_person" class="col-sm-4 control-label">নাম <span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person-info" class="info" ></span>
                                                <input type="text"  class="form-control input-sm" name="txtcontact_person" id="txtcontact_person" value="" placeholder="নাম " onchange="allSyn(this,'input','txtcontact_person')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_number" class="col-sm-4 control-label">মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txttxtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_number" id="txtcontact_number" value="<?php echo $mobile;?>" placeholder="মুঠোফোন" <?php if($mobile!=''){ echo 'readonly';} ?> >
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <!-- <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtcontact_person_no" class="col-sm-4 control-label">অন্যান্য মুঠোফোন<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="txtcontact_person_no-info" class="info" ></span>
                                                <input type="text" class="form-control input-sm" name="txtcontact_person_no" id="txtcontact_person_no" value="<?php //echo $mobile;?>" placeholder="অন্যান্য মুঠোফোন" onchange="allSyn(this,'input','txtcontact_person_no')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_tag" class="col-sm-4 control-label">সার্ভিস টাইপ ট্যাগ<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_tag-info" class="info" ></span>
                                                <select class="form-control input-sm select2  service_tag" name='service_tag' id='service_tag' style="width:100%" onchange="allSyn(this,'select','service_tag')">
                                                <?php
                                                   createCombo( "সার্ভিস টাইপ ট্যাগ", "tbl_service_tag", "id", "name", " where service_type in (3) Order by id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <!-- <div class="col-xs-6 ">
                                          <div class="form-group">
                                             <label for="txtcontact_email" class="col-sm-4 control-label">ইমেইল </label>
                                             <div class="col-sm-8 ">
                                                <input type="email" class="form-control input-sm" name="txtcontact_email" id="txtcontact_email" value="" placeholder="ইমেইল " onchange="allSyn(this,'input','txtcontact_email')">
                                             </div>
                                          </div>
                                       </div> -->
                                       <!-- <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="txtaddress" class="col-sm-4 control-label">ঠিকানা</label>
                                             <div class="col-sm-8 "> <span id="txtaddress-info" class="info" ></span>
                                                <textarea type="text" class="form-control " name='txtaddress' id='' placeholder="ঠিকানা" onchange="allSyn(this,'textarea','txtaddress')"></textarea>
                                             </div>
                                          </div>
                                       </div> -->
                                    </div>
                                  <!--   <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group ">
                                             <label for="division_id" class="col-sm-4 control-label">বিভাগের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8 " >
                                                <select name="division_id" id="division_id" class="division_id form-control input-sm" onchange="allSyn(this,'select','division_id')" >
                                                <?php
                                                  // createCombo( "বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division_id );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <label for="name" class="col-sm-4 control-label">জেলার নাম <span class="color">*</span></label>
                                          <div class="col-sm-8">
                                             <span id="name-info" class="info" ></span>
                                             <select name="district" id="district" class="district form-control input-sm" onchange="allSyn(this,'select','district')">
                                                <option value="">প্রথমে বিভাগ নির্বাচন করুন</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div> -->
                                    <div class="row">
                                       <!-- <div class="col-sm-6 upodisplay"  >
                                          <div class="form-group ">
                                             <label for="name" class="col-sm-4 control-label">উপজেলা/সার্কেলের নাম <span class="color">*</span></label>
                                             <div class="col-sm-8">
                                                <span id="name-info" class="info" ></span>
                                                <select name="upozila" id="upozila" class="upozila form-control input-sm" onchange="allSyn(this,'select','upozila')">
                                                   <option value="">প্রথমে জেলা নির্বাচন করুন</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div> -->
                                       <div class="col-xs-6">
                                          <div class="form-group">
                                             <label for="service_type" class="col-sm-4 control-label">সকল সেবা<span class="color">*</span></label>
                                             <div class="col-sm-8"> <span id="service_type-info" class="info" ></span>
                                                <select class="form-control input-sm  info_type" name='service_type' id='service_type' style="width:100%" onChange=""onchange="allSyn(this,'select','service_type')">
                                                <?php
                                                   createCombo( "সকল সেবা", "tbl_service_type", "prob_id", "prob_name", " where srv_type in (3) and prob_id<>12  Order by prob_id", '' );
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class=" col-xs-12">
                                             <div class=" col-xs-8">
                                                <div class="form-group">
                                                   <label for="txtsubject" class="col-sm-3 control-label"> কলের বিষয় <span class="color">*</span></label>
                                                   <div class="col-sm-9"> <span id="txtsubject-info" class="info" ></span>
                                                      <input type="text" class="form-control input-sm" name="txtsubject" id="txtsubject" value="" placeholder="কলের বিষয়" onchange="allSyn(this,'input','txtsubject')">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class=" col-xs-12">
                                             <div class=" col-xs-8">
                                                <div class="form-group">
                                                   <label for="txtdescription" class="col-sm-3 control-label"> কলের বিবরণ <span class="color">*</span></label>
                                                   <div class="col-sm-9"> <span id="txtdescription-info" class="info" ></span>
                                                      <textarea type="text" class="form-control " name='txtdescription' id='txtdescription' placeholder="কলের বিবরণ" onchange="allSyn(this,'textarea','txtdescription')"></textarea>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-sm-12 text-center">
                                             <button type="button" onclick="get_faq()" class="btn btn-primary btn-sm submit">অনুসন্ধান <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-12" id="faq"> </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>

                         <hr>
                        <div class="row">
                           <div class="history"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog  modal-lg" role="document">
         <div class="modal-content">
            <!--MODAL CONTENT-->
         </div>
      </div>
   </div>
   <div id="myModal1" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog  modal-lg" role="document">
         <div class="modal-content">
            <!--MODAL CONTENT-->
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
      
      $('.select2').select2()
      
      $(document).ready(function() {
          jQuery.validator.addMethod("mobileValidation", function(value, element) {
              var regex = new RegExp("(^[01]{2}[0-9]{9})$");

              if (!regex.test(value)) {
                  return false;
              }
              return true;
          });

          $('#complaint_form').validate({ 
              rules: {


                  scheduled_department: {
                      required: true,
                      min: 1
                  },
                  txtcontact_number: {
                      required: true,
                      //mobileValidation: true
                  },
                  txtcontact_person: {
                      required: true
                  },

                  prob_id: {
                      required: true,
                      min: 1
                  },
                  service_type: {
                      required: true,
                      min: 1
                  },
                  division_id: {
                      required: true,
                      min: 1
                  },
                  district: {
                      required: true,
                      min: 1
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
                  service_tag: {
                      required: true,
                      min: 1
                  },
                  protaion: {
                      required: true
                  },
              },
              messages: {
                  txtcontact_number: {
                      //  mobileValidation: "শুধুমাত্র ০১ দ্বারা শুরু হয় এমন নম্বরটি বৈধ যার সংখ্যা ১১ পর্যন্ত",
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
              errorPlacement: function(error, element) {
                  // Add the `help-block` class to the error element
                  error.addClass("help-block");

                  if (element.prop("type") === "checkbox") {
                      error.insertAfter(element.parent("label"));
                  } else {
                      error.insertAfter(element);
                  }
              },
              highlight: function(element, errorClass, validClass) {
                  $(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
              },
              unhighlight: function(element, errorClass, validClass) {
                  $(element).parents(".col-sm-5").addClass("has-success").removeClass("has-error");
              },
              submitHandler: function(form) {
                  var data = new FormData();
                  var form_data = $('#complaint_form').serializeArray();
                  $.each(form_data, function(key, input) {
                      data.append(input.name, input.value);
                  });
                 // console.log('aSAsaS');
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
                      if (msg == 1) {
                          alertify.success('ডেটা সফলভাবে যোগ করা হয়েছে');
                          document.getElementById("complaint_form").reset();

                      } else {
                          alertify.error(msg);
                      }
                      $loading.hide();
                  }).
                  fail(function() {
                      alertify.error('Error');
                      $loading.hide();
                  }).
                  complete(function() {});
                  return false; // ajax used, block the normal submit
              }
          });
          $('#info_app_form').validate({ 
              rules: {
                  scheduled_department: {
                      required: true,
                      min: 1
                  },
                  txtcontact_number: {
                      required: true,
                      //mobileValidation: true
                  },
                  service_type: {
                      required: true,
                      min: 1
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
                  service_tag: {
                      required: true,
                      min: 1
                  },

              },
              messages: {


                  txtcontact_number: {
                      //  mobileValidation: "শুধুমাত্র ০১ দ্বারা শুরু হয় এমন নম্বরটি বৈধ যার সংখ্যা ১১ পর্যন্ত",
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
              errorPlacement: function(error, element) {
                  // Add the `help-block` class to the error element
                  error.addClass("help-block");

                  if (element.prop("type") === "checkbox") {
                      error.insertAfter(element.parent("label"));
                  } else {
                      error.insertAfter(element);
                  }
              },
              highlight: function(element, errorClass, validClass) {
                  $(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
              },
              unhighlight: function(element, errorClass, validClass) {
                  $(element).parents(".col-sm-5").addClass("has-success").removeClass("has-error");
              },
              submitHandler: function(form) {
                  var data = new FormData();
                  var form_data = $('#info_app_form').serializeArray();
                  $.each(form_data, function(key, input) {
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
                      //console.log(msg);
                      if (msg == 1) {
                          alertify.success('ডেটা সফলভাবে যোগ করা হয়েছে');
                         // document.getElementById("info_app_form").reset();

                      } else {
                          alertify.error(msg);
                      }
                      $loading.hide();
                  }).
                  fail(function() {
                      alertify.error('Error');
                      $loading.hide();
                  }).
                  complete(function() {});
                  return false; // ajax used, block the normal submit
              }
          });
      })
      
      $('.division_id').on('change',function(){
         var division_id = $(this).val();
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
               $('.district').html(response);
               $('.upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
            }
         });
         }else{
            $('.district').html('<option value="">প্রথমে বিভাগ নির্বাচন করুন</option>');
            $('.upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
            }
      });
      $('.district').on('change',function(){
         var district = $(this).val();
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
               $('.upozila').html(response);
            }
         });
         }else{
            $('.upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
            }
      });
         
      $('#txtcontact_number,#txtcontact_number_info').on('change',function(){
         var txtcontact_number = $(this).val();
         //alert(txtcontact_number);
         if(txtcontact_number){
            $.ajax({
               type:'POST',
               url:'ajaxData.php',
               data:'txtcontact_number='+txtcontact_number,
               success:function(html){
                       //  alert('sdasdasdasd');
                  //alert(html)
                         getInfo(txtcontact_number);
                         getCitizenData(txtcontact_number);
                  $('.history').html(html);
               }
            });
         }
      });
         
      function getInfo(){     
             $.ajax({
               type:'POST',
               url:'loaddata.php',
               data:$("#request_form").serialize(),
               success:function(html){                    
                        //console.log(html);
                  msg = JSON.parse(html); 
                         if(msg.status==1){
                            $('#application').html(msg.app);
                     $('#information').html(msg.info);
                            }else{
                             $('#application').html('');
                      $('#information').html('');     
                            }
               }
            });
         }  
      function get_faq(){ 
      
             $.ajax({
               type:'POST',
               url:'info.php',
               data:$("#service_form").serialize(),
               success:function(html){   
                  //console.log(html);
                       $('#faq').html(html);
               }
            });
         }  
      
      
      function getAppicationdetails(){     
             $.ajax({
               type:'POST',
               url:'loadAppdata.php',
               data:$("#info_form").serialize(),
               success:function(html){                    
                       //  console.log(html);
                  $('#tracking_info').html(html);
               }
            });
         }     
      
      $('.service_type').on('change',function(){
         var service_type = $(this).val();
         if(service_type==14){
            $('.pro_others').show();
         }else{
            $('.pro_others').hide();
            }
         if(service_type==8 || service_type==12 || service_type==11){
               $('.montobo').show();
            }
             else{
               $('.montobo').hide();
               }
         //alert(building);
         if(service_type){
            $.ajax({
               type:'POST',
               url:'ajaxData.php',
               data:'service_type='+service_type,
               success:function(html){
                  var obj = JSON.parse(html);
                  if(obj.show_problem==1){
                     $('.pro_diaplay').show();
                     }else{
                     $('.pro_diaplay').hide();  
                        }
                  if(obj.show_upozila==1){
                     $('.upodisplay').show();
                     }else{
                     $('.upodisplay').hide();   
                        }
               }
            });
            getSubject(service_type);
         }
      });
      function getSubject(service_type){
      $.ajax({
               type:'POST',
               url:'ajaxData.php',
               data:'service_types='+service_type,
               success:function(html){
                  $("#txtsubject").val(html)
               }
            });
      }
      
      
      $(document).on("click", "a.send", function() {  
      
        
               var href = '';   
               var suserid = '';
               var txtcontact_number = '';
               var txtcontact_person = '';
               var subject = ''; 
               var service_type = '';  
               var description = '';   
               var division_id = '';   
               var district = '';   
               var upozila = ''; 
               var form_ex ='form_ex';
              
               var href = $(this).data('href');   
               var suserid = $(this).data('suserid');
               var txtcontact_number = $(this).data('txtcontact_number');
               var txtcontact_person = $(this).data('txtcontact_person');
               var service_type = $(this).data('service_type');
               var subject = $(this).data('subject');
               var description = $(this).data('description');
               var division_id = $(this).data('division_id');
               var district = $(this).data('district');
               var upozila = $(this).data('upozila');
               var no = $(this).data('txtcontact_person_no');
               var nid = $(this).data('nid');
               var dateOfBirth = $(this).data('dateOfBirth');
               var service_tag = $(this).data('service_tag');
              //console.log(href);
              $("#"+form_ex).remove();
              // console.log(url+','+mobile+','+email +','+tocken);
                $('body').append($('<form/>', {
                    // id: 'form'+id,
                     id: form_ex,
                     method: 'POST',
                     target: 'self', 
                     action: 'redirect.php'
                }));
                $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'suserid',
                     value: suserid
                }));
                $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'href',
                     value: href
                }));
               $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'txtcontact_number',
                     value: txtcontact_number
                }));
               $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'txtcontact_person',
                     value: txtcontact_person
                }));
      
               $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'service_type',
                     value: service_type
                })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'subject',
                     value: subject
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'service_type',
                     value: service_type
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'description',
                     value: description
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'division_id',
                     value: division_id
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'district',
                     value: district
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'upozila',
                     value: upozila
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'no',
                     value: no
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'nid',
                     value: nid
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'dateOfBirth',
                     value: dateOfBirth
                  })); 
            $('#'+form_ex).append($('<input/>', {
                     type: 'hidden',
                     name: 'service_tag',
                     value: service_tag
                  })); 
              // $('#form'+id).submit();
               $('#'+form_ex).submit();
                return false;
           });    
         
      function getCitizenData(mobile){
            $.ajax({
               type:'POST',
               url:'ajaxData.php',
               data:'mobile='+mobile,
               success:function(html){
                  var obj = JSON.parse(html);
                  if(obj.status==200){                
                     $("input[name='txtcontact_person']").val(obj.name);
                     $("input[name='txtcontact_person_no']").val(mobile);
                     $("input[name='txtcontact_email']").val(obj.email);
                     $("textarea[name='txtaddress']").html(obj.address);
                     $("select[name='division_id']").val(obj.division_bbs);
                        $.ajax({
                           type: "POST",
                           url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                           data: {
                              mode: 1,
                              division_id:obj.division_bbs,                   
                              table:'tbl_district ',
                              conditions:'where division_id=' +obj.division_bbs,
                              firstText:'জেলা নির্বাচন করুন',
                           },
                           success: function(response) {
                              $('.district').html(response);
                              $("select[name='district']").val(obj.district_bbs);
      
                              $.ajax({
                                       type: "POST",
                                       url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                                       data: {
                                          mode: 1,
                                          district:obj.district_bbs,                   
                                          table:'tbl_upozila ',
                                          conditions:'where district=' +obj.district_bbs,
                                          firstText:'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
                                       },
                                       success: function(response) {
                                          $('.upozila').html(response);
                                          $("select[name='upozila']").val(obj.upozila_bbs);
                                       }
                                    });
                           }
                        });
                  }
                  
               }
            });   
      }
      

      function getNifdData(fromane){         
         let nid= document.forms.complaint_form.elements["nid"].value;
         let dateOfBirth= document.forms.complaint_form.elements["dateOfBirth"].value;         
            if(nid!='' && dateOfBirth!=''){
              //  console.log(nid+','+dateOfBirth);
             $.ajax({
               type:'POST',
               url:'nid_verify.php',
               data:{
                  'nid':nid,
                  'dateOfBirth':dateOfBirth,
               },
               success:function(html){
                 // console.log(html);
                  var obj = JSON.parse(html);
                  if(obj.status==200){                
                     $("input[name='txtcontact_person']").val(obj.name);
                     $("input[name='txtcontact_person_no']").val(obj.mobile);
                     // $("input[name='txtcontact_email']").val(obj.email);
                      $("textarea[name='txtaddress']").html(obj.additionalMouzaOrMoholla+","+obj.additionalVillageOrRoad);
                     $("select[name='division_id']").val(obj.division_id);
                        $.ajax({
                           type: "POST",
                           url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                           data: {
                              mode: 1,
                              division_id:obj.division_id,                   
                              table:'tbl_district ',
                              conditions:'where division_id=' +obj.division_id,
                              firstText:'জেলা নির্বাচন করুন',
                           },
                           success: function(response) {
                              $('.district').html(response);
                              $("select[name='district']").val(obj.district_id);
      
                              $.ajax({
                                       type: "POST",
                                       url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                                       data: {
                                          mode: 1,
                                          district:obj.district_id,                   
                                          table:'tbl_upozila ',
                                          conditions:'where district=' +obj.district_id,
                                          firstText:'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
                                       },
                                       success: function(response) {
                                          $('.upozila').html(response);
                                          $("select[name='upozila']").val(obj.upozila_id);
                                       }
                                    });
                           }
                        });
                  }else if(obj.status==400){
                     alert(obj.message);
                  }                  
               }
            });
          }
      }
      function showDetails(id) {
          //alert(tid);
          var mode = '2';
          $.ajax({
              type: "POST",
              url: "ticket_details.php",
              data: {
                  mode: mode,
                  id : id,
              },
              success: function (response)
                 {   
                     //alert ('edit');
                     $( '.modal-content' ).html(response);
                 }
          });
      }
      
      $('.datetimepicker').datetimepicker({
         format:'Y-m-d',         
         step:5,
         timepicker:false
      });
      
      function reopen(task_id){
      
      $.ajax({
               type:'POST',
               url:'ajaxData.php',
               data:'task_id='+task_id,
               success:function(html){
                  //console.log(html);
                   var obj = JSON.parse(html);
                   if(obj.status==200){   
                   //var obj = JSON.parse(html);               
                      $("input[name='txtcontact_person']").val(obj.contact_person);
                      $("input[name='txtcontact_person_no']").val(obj.contact_number);
                      $("input[name='txtcontact_email']").val(obj.email);
                      $("textarea[name='txtaddress']").html(obj.address);
      
                     $("select[name='service_type']").val(obj.service_type);
                     $("select[name='prob_id']").val(obj.prob_type);
                     $("input[name='txtsubject']").val(obj.subject);
                     $("textarea[name='txtdescription']").html(obj.description);
                     $("select[name='division_id']").val(obj.division);
                     $.ajax({
                           type: "POST",
                           url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                           data: {
                              mode: 1,
                              division_id:obj.division,                    
                              table:'tbl_district ',
                              conditions:'where division_id=' +obj.division,
                              firstText:'জেলা নির্বাচন করুন',
                           },
                           success: function(response) {
                              $('.district').html(response);
                              $("select[name='district']").val(obj.district);
      
                              $.ajax({
                                       type: "POST",
                                       url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
                                       data: {
                                          mode: 1,
                                          district:obj.district,                    
                                          table:'tbl_upozila ',
                                          conditions:'where district=' +obj.district,
                                          firstText:'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
                                       },
                                       success: function(response) {
                                          $('.upozila').html(response);
                                          $("select[name='upozila']").val(obj.upozila);
                                       }
                                    });
                              }
                        });
               
               $(".select2").select2('destroy'); 
               $('.select2').select2()
                   }
                  
               }
            });   
      }
      $("input[name='txtcontact_person']").on('change',function(){
         var district = $(this).val();
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
               $('.upozila').html(response);
            }
         });
         }else{
            $('.upozila').html('<option value="">প্রথমে জেলা নির্বাচন করুন</option>');
            }
      });
      
      function allSyn(sel,type,name){
         var value = sel.value;  
         if(type=='txtaddress'){
            $(""+type+"[name='"+name+"']").html(value);
         }else{
            $(""+type+"[name='"+name+"']").val(value);
         }         
           // console.log(type+','+value+','+name );
         }
      
   </script>
   <?php if(isset($_REQUEST['mobile'])){?>
   <script>
      var txtcontact_number = $("#txtcontact_number").val();
      //alert(building);
      if(txtcontact_number){
         $.ajax({
            type:'POST',
            url:'ajaxData.php',
            data:'txtcontact_number='+txtcontact_number,
            success:function(html){
               //alert(html)
               $('.history').html(html);
               getCitizenData(txtcontact_number)
            }
         });
      }
      
      
      
      
        
   </script>
   <style>
      .navbar-text {
      margin-top: 2px;
      margin-bottom: 2px;
      font-size: 12px;
      }
      .pr0{
      padding-right:0px
      }
   </style>
   <!-- Modal -->
   
   <div class="navbar navbar-default navbar-fixed-bottom" style="min-height: 23px !important; z-index:1">
      <div class="container">
         <div class="col-sm-1"></div>
         <div class="col-sm-5">
            <p class="navbar-text pull-left">&nbsp;&nbsp; © <?php echo date('Y');?> লেখস্বত্ত্ব ভূমি মন্ত্রণালয় <br>
               &nbsp;&nbsp; <a href="https://minland.gov.bd/" target="_blank" >minland.gov.bd</a> 
            </p>
         </div>
         <div class="col-sm-6">
            <p class="navbar-text pull-right">কারিগরি সহায়তায় এবং সফটওয়্যার উন্নয়নে <br>
               Nextech Limited <a href="http://www.nextech.com.bd/" target="_blank" >www.nextech.com.bd</a> 
            </p>
         </div>
      </div>
   </div>
   <?php }?>
</body>
</html>