<?php 
require_once('sms_conf.php');
$token_url = "https://idp.land.gov.bd/auth/realms/prod/protocol/openid-connect/token";
$client_id=client_id;
$client_secret=client_secret;
function getAccessToken() {
	global $token_url,$client_id, $client_secret;
	$authorization = base64_encode("$client_id:$client_secret");
	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");
	$content = "grant_type=client_credentials&scope=openid";
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $token_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$response = curl_exec($curl);
	curl_close($curl);
	if ($response === false) {
		echo "Failed";
		echo curl_error($curl);
		echo "Failed";
	} 
    
	return json_decode($response)->access_token;
}
echo $authorization= getAccessToken();
?>