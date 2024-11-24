<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ভূমি মন্ত্রণালয়</title>
    <link href="http://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="../landing/css/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="../landing/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="../landing/fonts/law-icons/font/flaticon.css">
        <link rel="stylesheet" href="../landing/fonts/fontawesome/css/font-awesome.min.css">
        <link rel=icon href="../images/bd1png.png"  sizes="16x16" type="image/png">
        <link rel="stylesheet" href="../landing/css/slick.css">
        <link rel="stylesheet" href="../landing/css/slick-theme.css">
        <link rel="stylesheet" href="../landing/css/helpers.css">
        <link rel="stylesheet" href="../landing/css/style.css">
        <link rel="stylesheet" href="../landing/assets/css/landing-2.css">
        <link href="https://fonts.maateen.me/adorsho-lipi/font.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="../jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>

	<style>
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
			button#mybtn {
				background: #084614;
				color: #fbfbfb;
				border: none;
			}
			.pb_navbar .nav-link {
				font-size: 17px;
				padding-left: 1rem !important;
				padding-right: 1rem !important;
				color: #fff;
				font-weight: bold;
			}
			.searchFrom {
				position: absolute;
				top: 45%;
				left: 50%;
				transform: translate(-50%, -50%);
			}
			div#searchData {
				padding-top: 185px;
			}
			
			
			.searchFrom input.form-control {
				padding: 12px 12px;
				height: 24px;
				border-radius: 0;
				border: 0;
				font-size: 12px;
				width: 126px;
			}
			
			.searchFrom img {
				height: 25px;
				margin-right: 7px;
			}
			
			.searchFrom input#captcha {
				width: 50px;
			}
			
			.searchFrom #mybtn {
				border: 0;
				border-radius: 0;
				padding: 1px 12px;
				font-size: 13px;
				height: 26px;
			}
			
			.searchFrom i.fa {
				margin-right: 10px;
				color: #fff;
			}
			
			@media only screen and (max-width: 600px) {
			  .searchFrom {
					top: 31%;
				}
				.searchFrom input.form-control{
					margin:10px;
				}
				.searchFrom img{
					margin:10px;
				}
			}
	</style>
</head>
<body data-spy="scroll" data-target="#pb-navbar" data-offset="200" style="font-family:'AdorshoLipi', Montserrat, sans-serif !important; background-image: url('../images/smart_land1.png'); background-repeat: no-repeat; background-size: cover; height: 100vh; background-attachment: fixed;">
<nav class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light" id="pb-navbar">

            <div class="container">


                <a class="navbar-brand" href="/"><img src="../landing/images/logo.png" class="img-responsive"> ভূমি মন্ত্রণালয়</a>

                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span><i class="ion-navicon"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="probootstrap-navbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="../login.php">অ্যাডমিন</a></li>
                        <li class="nav-item"><a class="nav-link" href="/portal">কল অনুসন্ধান</a></li>
						<li class="nav-item"><a class="nav-link" href="/nagorikKornar">নাগরিক কর্নার</a></li>
                    </ul>

                </div>
            </div>
        </nav>


<div class="searchFrom">
<form class="form-inline my-2 my-lg-0 ml-auto" id="search" >
      <input class="form-control mr-sm-2" type="search" name="mobile" id="mobile" placeholder="মুঠোফোন">
      <input class="form-control mr-sm-2" type="search" name="ticket_number" id="ticket_number" placeholder="কলের নাম্বার">
      
      <img src="captcha.php" id="captcha_image">
      <i class="fa fa-refresh" aria-hidden="true" id="reload_captcha" style="cursor:pointer"></i>
      <input type="text" class="form-control mr-sm-2" type="search" name="captcha" id="captcha" >
      <button id="mybtn" class="btn btn-outline-info my-2 my-sm-0" type="button" onClick="sendData()">অনুসন্ধান</button>
    </form>
</div>



<div class="container mt-5" id="searchData">
<div class="dataShowTableSection" id="content">
	
</div>
</div>
<footer class="pb_ footer bg- light" role="contentinfo" style="padding:10px;position: fixed;width: 100%;height: auto;background: #fff;bottom: 0;">
            <div class="container">
                <div class="row" style="margin-top:5px"><br>
                    
                    <div class="col-sm-4 text-center " style="color:black; font-weight: 400">
                        <span style="color:black; font-weight: 400;font-size: 14px;">© লেখস্বত্ত্ব ভূমি মন্ত্রণালয় 
                            <br> <a href="https://minland.gov.bd/"><img style="width: 23%;" src="../landing/images/logo-mobile.png" class="img-responsive"></a>
                    </span></div>
                    <div class="col-sm-4 text-center " style="color:black; font-weight: 400">
                        <span  style="color:black; font-weight: 400;font-size: 14px;">কারিগরি সহায়তায়
                            <br/> <a  href="https://www.tss.com.bd/"><img style="width: 13%;" src="../landing/images/tss.png" class="img-responsive" ></a>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div style="color:black; font-weight: 400">
                            <span style="color:black; font-weight: 400;font-size: 14px;">সফটওয়্যার উন্নয়নে</span>
                            <br> <a href="http://nextech.com.bd/"><img src="../landing/images/nextechlogo-1.png" class="img-responsive" style="width:23%"></a>
                        </div>
                    </div>
                </div>

            </div>
        </footer>

<script>

		function sendData() {
			console.log($('#search').serialize());
		    $.ajax({
		        type: "POST",
		        url: "getrpt_ticketlist.php",
		        data: $('#search').serialize(),
		    }).done(function(msg) {
				
		        $("#content").html(msg);
				//alert(msg);
		    }).fail(function(jqXHR, textStatus) {
		        alert("Request failed: " + textStatus);
		    });
		}
$('#reload_captcha').click(function(event){
  $('#captcha_image').attr('src', $('#captcha_image').attr('src')+'#');
});
</script>
	
</body>
</html>




