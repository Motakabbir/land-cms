<?php
session_start();
include 'Library/dbconnect.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ভূমি মন্ত্রণালয়  || Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate (1).css">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- <link rel="stylesheet" href="css/loginreset.css">-->
    
   
        
    <link rel="stylesheet" href="css/loginstyle.css">
  </head>
  <body style="background-image: url('images/smart_land1.png'); background-repeat: no-repeat; background-size: cover; height: 100vh; background-attachment: fixed;">
    <div class="text-center" >
	<br><br>
      <div class="col-md-4 col-sm-6 col-xs-8 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
        <div class=" cf ">
          <div class="signin animated flipInY">
		 
            <div >
				<img src="upload/whitemybillinglogo.png" alt="" ><br>
				ভূমি মন্ত্রণালয়<br>
				গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
			</div>
            <form action="Authenticate.php" method="post" name="login">
              <div class="inputrow">
                <input type="text" id="name" autocomplete="off" name="name"  placeholder="ব্যবহারকারীর নাম " required/>
                <label for="name" class="ion-person-stalker"></label>
              </div>
              <div class="inputrow">
                <input type="password" id="pass" autocomplete="off"  name="pass" placeholder="পাসওয়ার্ড" required/>
                <label for="pass" class="ion-locked"></label>
              </div>
              <div class="col-sm-6 pl0">
                <input type="checkbox" name="remember" id="remember"/>
                <label for="remember" class="radio"  id="remember" name="remember">লগ ইন করে থাকুন</label>
              </div>
              <div class="col-sm-6 pr0 forgot">
                <a href="/"><i  class="ion-home" style="font-size: 26px;"></i> </a>
              </div>
              <div class="clr"></div>
              <div class="">
                <button type="submit"  class="btn  button1" value="" name="" id="" >প্রবেশ করুন</button>
              </div>
            </form>
          </div>
		  
        </div>
		
      </div>

	  
    </div>
	
	<div class="row">
	 <h1 class="heading text-center" style="padding-top: 450px; font-size: 50px"> স্মার্ট ভূমি সেবায় আপনাকে স্বাগতম
</h1>
	  </div>
 
  </body>
</html>

