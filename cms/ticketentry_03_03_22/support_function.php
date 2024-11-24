<?php 
function writeLog($logName, $logData){
        file_put_contents('./log-'.$logName.date("j.n.Y").'.log',$logData,FILE_APPEND);
    }
function call_success($agent_id, $citizen_mobile, $citizen_name, $application_type, $subject=null, $description=null, $email=null, $address=null, $division_bbs, $district_bbs, $upozila_bbs, $application_code=null, $txtcontact_person_no=null, $nid=null, $dateOfBirth=null,$service_tag=null ){
	

$curl = curl_init();
	
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://hotline.land.gov.bd/return/message/message_internal.php',
 // CURLOPT_URL => 'http://192.168.8.44/landnew//return/message/message_internal.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('agent_id' => $agent_id,'citizen_mobile' => $citizen_mobile,'citizen_name' => $citizen_name,'application_type' => $application_type,'subject' => $subject,'description' => $description,'email' => $email,'address' => $address,'division_bbs' => $division_bbs,'district_bbs' => $district_bbs,'upozila_bbs' => $upozila_bbs,'application_code' => $application_code,'txtcontact_person_no' => $txtcontact_person_no,'nid' => $nid,'dateOfBirth' => $dateOfBirth ,'service_tag' =>$service_tag),

  CURLOPT_HTTPHEADER => array(
    'appkey: AcLufb15shIUTwYLuQFtNhaXb2u6skZk',
    'secret: 8h5dg9iBou'
  ),
));


$response = curl_exec($curl);

curl_close($curl);
echo $response;
}
?>