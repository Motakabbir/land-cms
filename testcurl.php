<?php 
//   $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'http://hotline.land.gov.bd/return/message/message_internal.php',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => array('agent_id' => '100011','citizen_mobile' => '01771882876','citizen_name' => 'Morshed','application_type' => '16','subject' => 'অনলাইন ভূমি উন্নয়ন কর এর আবেদনের জন্য','description' => 'অনলাইন ভূমি উন্নয়ন কর আবেদনের জন্য কলটি করেছিল ','email' => '','address' => '','division_bbs' => '3','district_bbs' => '13','upozila_bbs' => '49','application_code' => '','txtcontact_person_no' => '01771882876','nid' => '5076217693','dateOfBirth' => '1990-09-30','service_tag' => '3'),
//   CURLOPT_HTTPHEADER => array(
//     'appkey: AcLufb15shIUTwYLuQFtNhaXb2u6skZk',
//     'secret: 8h5dg9iBou'
//   ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;

$fields=array('agent_id' => '100011','citizen_mobile' => '01771882876','citizen_name' => 'Morshed','application_type' => '16','subject' => 'অনলাইন ভূমি উন্নয়ন কর এর আবেদনের জন্য','description' => 'অনলাইন ভূমি উন্নয়ন কর আবেদনের জন্য কলটি করেছিল ','email' => '','address' => '','division_bbs' => '3','district_bbs' => '13','upozila_bbs' => '49','application_code' => '','txtcontact_person_no' => '01771882876','nid' => '5076217693','dateOfBirth' => '1990-09-30','service_tag' => '3');

$fields = http_build_query($_POST);
$ch = curl_init('http://hotline.land.gov.bd/return/message/message_internal.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);


//curl_exec($ch);
if (curl_errno($ch)) { 
   echo $error_msg = curl_error($ch);
}
echo $result;



// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'http://hotline.land.gov.bd/return/message/message_internal.php',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 3,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_SSL_VERIFYPEER=> false,
//   CURLOPT_SSL_VERIFYHOST=> false,
//   CURLOPT_PROTOCOLS=> CURLPROTO_HTTP,
//   CURLOPT_POST=> true,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//                           "agent_id":"100011",
//                           "citizen_mobile":"01771882876",
//                           "citizen_name":"Morshed",
//                           "application_type":"16",
//                           "subject":"অনলাইন ভূমি উন্নয়ন কর এর আবেদনের জন্য",
//                           "description":"অনলাইন ভূমি উন্নয়ন কর আবেদনের জন্য কলটি করেছিল ",
//                           "email":""
//                           "address":""
//                           "division_bbs":"3",
//                           "district_bbs":"13",
//                           "upozila_bbs":"49",
//                           "application_code":""
//                           "txtcontact_person_no":"01771882876",
//                           "nid":"5076217693",
//                           "dateOfBirth":"1990-09-30",
//                           "service_tag":"3"
//                         }',
//   CURLOPT_HTTPHEADER => array(
//     'appkey: AcLufb15shIUTwYLuQFtNhaXb2u6skZk',
//     'secret: 8h5dg9iBou'
//   ),
// ));

// $response = curl_exec($curl);
// if ($response ) {
//    echo $error_msg = curl_error($curl);
// }
// curl_close($curl);
//echo $response;
?>