<?php 
session_start();
require_once 'config.php';

$_SESSION['facebook_id']='';
$_SESSION['facebook_name']='';
$_SESSION['email']='';
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

    
  $accesToken = $fb->getRedirectLoginHelper()->getAccessToken();
if (isset($accesToken)){
        $responseUser = $fb->get('/me?fields=id, name, email',$accesToken);
        $fbUser = $responseUser->getGraphUser();
      
        $_SESSION['facebook_id']=$fbUser->getId();
        $_SESSION['facebook_name']=$fbUser->getName();
        $_SESSION['email']=$fbUser->getField('email');
       
        header("Location: index.php");
    }
?>