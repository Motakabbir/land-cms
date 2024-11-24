<?php
$requestMethod = $_SERVER[ "REQUEST_METHOD" ];
function writeLog($logName, $logData){
        file_put_contents('./log-'.$logName.date("j.n.Y").'.log',$logData,FILE_APPEND);
    }
//writeLog('payment',print_r($_REQUEST , true)); 

$_SERVER[ "HTTP_APPKEY" ];
$_SERVER[ "HTTP_SECRET" ];
$error_handeler_code = array(
  "200" => "Successful transaction.",
  "401" => "Authentication failed . APPKEY  or SECRET not mtched",
  "402" => "Mandatory Field missing This is when any one of applicationId, mobile , name are empty or null.",
  "403" => "Mobile number missing"
);

//print_r($_REQUEST);

if ( $_SERVER[ "HTTP_APPKEY" ] == "AcLufb15shIUTwYLuQFtNhaXb2u6skZk" && $_SERVER[ "HTTP_SECRET" ] == "8h5dg9iBou" ) {
  include( '../class/Rest.php' );

  $api = new Rest();

  switch ( $requestMethod ) {
    case 'POST':

      $agent_id = '';
      $citizen_mobile = '';
      $citizen_name = '';
      $application_type = '';
      $subject = '';
      $description = '';
      $email = '';
      $address = '';
      $division_bbs = '';
      $district_bbs = '';
      $upozila_bbs = '';
      $application_code = '';
      $txtcontact_person_no = '';
      $nid = '';
      $dateOfBirth = '';
      $service_tag = '';
      if ( $_REQUEST[ 'citizen_mobile' ] ) {
        $citizen_mobile = $_REQUEST[ 'citizen_mobile' ];
      }
      if ( $_REQUEST[ 'agent_id' ] ) {
        $agent_id = $_REQUEST[ 'agent_id' ];
      }
      if ( $_REQUEST[ 'citizen_name' ] ) {
        $citizen_name = $_REQUEST[ 'citizen_name' ];
      }
      if ( $_REQUEST[ 'application_type' ] ) {
        $application_type = $_REQUEST[ 'application_type' ];
      }
      if ( $_REQUEST[ 'subject' ] ) {
        $subject = $_REQUEST[ 'subject' ];
      }
      if ( $_REQUEST[ 'description' ] ) {
        $description = $_REQUEST[ 'description' ];
      }
      if ( $_REQUEST[ 'email' ] ) {
        $email = $_REQUEST[ 'email' ];
      }
      if ( $_REQUEST[ 'address' ] ) {
        $address = $_REQUEST[ 'address' ];
      }
      if ( $_REQUEST[ 'division_bbs' ] ) {
        $division_bbs = $_REQUEST[ 'division_bbs' ];
      }
      if ( $_REQUEST[ 'district_bbs' ] ) {
        $district_bbs = $_REQUEST[ 'district_bbs' ];
      }
      if ( $_REQUEST[ 'upozila_bbs' ] ) {
        $upozila_bbs = $_REQUEST[ 'upozila_bbs' ];
      }
      if ( $_REQUEST[ 'application_code' ] ) {
        $application_code = $_REQUEST[ 'application_code' ];
      }
      if ( $_REQUEST[ 'txtcontact_person_no' ] ) {
        $txtcontact_person_no = $_REQUEST[ 'txtcontact_person_no' ];
      }
      if ( $_REQUEST[ 'nid' ] ) {
        $nid = $_REQUEST[ 'nid' ];
      }
      if ( $_REQUEST[ 'dateOfBirth' ] ) {
        $dateOfBirth = $_REQUEST[ 'dateOfBirth' ];
      }
      if ( $_REQUEST[ 'service_tag' ] ) {
        $service_tag = $_REQUEST[ 'service_tag' ];
      }


    
      if ( $citizen_mobile == '' || $citizen_name == '' || $application_type == '' ) {
        $error_handeler_code[ '402' ];
        $error = array( "Error_code" => '402', "Error_msg" => $error_handeler_code[ '402' ] );
        echo json_encode( $error );
        die;
      }
      // writeLog('message','here'); 
      $api->saveDataInternal( $agent_id, $citizen_mobile, $citizen_name, $application_type, $subject, $description, $email, $address, $division_bbs, $district_bbs, $upozila_bbs, $application_code, $error_handeler_code,$txtcontact_person_no, $nid, $dateOfBirth,$service_tag  );



      break;
    default:
      header( "HTTP/1.0 405 Method Not Allowed" );
      break;
  }

} else {
  $error_handeler_code[ '401' ];
  $error = array( "Error_code" => '401', "Error_msg" => $error_handeler_code[ '401' ] );
  echo json_encode( $error );
  die;
}


?>