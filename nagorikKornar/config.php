<?php
session_start();
// 
// 
require_once 'googleApi/vendor/autoload.php';


$gClient = new Google_Client();
$gClient->setClientId("215841761752-t8kc00r7a2mo7rvfn0l0tfeob8c2s5ma.apps.googleusercontent.com");
$gClient->setClientSecret("vZ3jzbtmaNW1m1NshOHPIb96");
$gClient->setApplicationName("Hotline");
$gClient->setRedirectUri("https://hotline.land.gov.bd/nagorikKornar/google.php");
$gClient->addScope("email");
$gClient->addScope("profile");

