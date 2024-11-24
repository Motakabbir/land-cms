<?php

function convertBanglatoUnicode( $BanglaText ) {
  $unicodeBanglaTextForSms = strtoupper( bin2hex( iconv( 'UTF-8', 'UCS-2BE', $BanglaText ) ) );
  return $unicodeBanglaTextForSms;
}

function getAccessToken() {
  $token_url = "https://idp.land.gov.bd/auth/realms/prod/protocol/openid-connect/token";
  $client_id = 'lsg-notification';
  $client_secret = "0RYSslLCBrSrvKdAyK9bx1au0IAIH1DA";
  $authorization = base64_encode( "$client_id:$client_secret" );
  $header = array( "Authorization: Basic {$authorization}", "Content-Type: application/x-www-form-urlencoded" );
  $content = "grant_type=client_credentials&scope=openid";
  $curl = curl_init();
  curl_setopt_array( $curl, array(
    CURLOPT_URL => $token_url,
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $content
  ) );
  $response = curl_exec( $curl );

  curl_close( $curl );
  if ( $response === false ) {
    return false;

  }

  return json_decode( $response )->access_token;
}
 function callSmsFunction($url,$authorization, $destination, $msg ) {
       
        $curl = curl_init();

        curl_setopt_array( $curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{	
							"op": "SMS",
							"chunk": "S",
							"smsclass": "GENERAL",
							"sms":"' . $msg . '",
							"mobile":"' . $destination . '",
							"charset": "ASCII",
							"validity": "1440"
							}',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $authorization . '',
            'Content-Type: application/json'
          ),
        ) );
        $response = curl_exec( $curl );
        curl_close( $curl );
        return $response;
    //    echo $response;
      }

function SmsSendSystem( $mobile, $smsbody, $sms_id = NULL ) {
  ini_set( 'display_errors', 'Off' );
  error_reporting( E_ALL );

  session_start();
  $SUser_ID = $_SESSION[ 'SUserID' ];
  global $conn;
  $SeNTlist = "SELECT
					  `id`,
					  `name`,
					  `sms_url`,
					  `submit_param`,
					  `return_param`,
					  `return_value_type`,
					  type
					FROM
					  `tbl_sms_setup`
					WHERE id=" . $sms_id . "";
  $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
  $data = array();
  while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
    extract( $rowNewsTl );
    $url = $sms_url;
    $values = explode( ',', $submit_param );
    foreach ( $values as $value ) {
      $nval = explode( '=', $value );
      $nval[ 0 ] . '=>' . $nval[ 1 ];

      array_push( $data[ $nval[ 0 ] ] = $nval[ 1 ] );
    }
  }
  if ( $id == 1 ) {
    if ( $mobile != "" ) {

      $url = $sms_url;
      $authorization = getAccessToken();
      $result = callSmsFunction($url,$authorization, $mobile, $smsbody );
	  
//$return_res = serialize( $result );
//$status=$return_res[status];
//$st_details=$return_res[details];
//echo "$status-$st_details";

      $sql = "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('" . $mobile . "','" . $smsbody . "','" . $result . "','" . $sms_id . "','" . $SUser_ID . "','true',NOW())";
      $Asql = mysqli_query( $conn, $sql );
      // printf("Errormessage: %s\n", mysqli_error($conn));
      return true;
    }
  } else {
    if ( $mobile != "" ) {
      $fields_string = '';
      $url = $url;
      $fields = $data;
      if ( $type == 'get' ) {
        foreach ( $fields as $key => $value ) {
          $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = rtrim( $fields_string, '&' );
        $furl = $url . '?' . $fields_string;


        if ( $sms_id == 4 ) {
          $smsbody_in = $smsbody;
          $smsbody = convertBanglatoUnicode( $smsbody );

        } else {
          $smsbody_in = $smsbody;
          $smsbody = preg_replace( "/\r|\n/", "", convert_text( $smsbody ) );
        }
        $furl = bind_to_template( array( 'mobile' => $mobile, 'smsbody' => $smsbody ), $furl );


        $ch = curl_init( $furl );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec( $ch );
        if ( $result === false ) {
          //return 'Curl error: ' . curl_error($ch);
          if ( substr( $result, 0, 5 ) == "<?xml" ) {
            $xml = simplexml_load_string( $result );
            $json = json_encode( $xml );
            $result = json_decode( $json, TRUE );

            $return_val = serialize( $result );
          } else {
            $return_val = serialize( $result );
          }
          $Asql = mysqli_query( $conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('" . $mobile . "','" . $smsbody_in . "','" . $return_val . "','" . $sms_id . "','" . $SUser_ID . "','false',NOW())" );
          return false;
        } else {
          // return 'Operation completed without any errors';
          if ( substr( $result, 0, 5 ) == "<?xml" ) {
            $xml = simplexml_load_string( $result );
            $json = json_encode( $xml );
            $result = json_decode( $json, TRUE );

            $return_val = serialize( $result );
          } else {
            $return_val = serialize( $result );
          }

          $sql = "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('" . $mobile . "','" . $smsbody_in . "','" . $return_val . "','" . $sms_id . "','" . $SUser_ID . "','true',NOW())";
          $Asql = mysqli_query( $conn, $sql );
          // printf("Errormessage: %s\n", mysqli_error($conn));
          return true;
        }
        //close connection
        curl_close( $ch );
      } elseif ( $type == 'post' ) {
        $fields = bind_to_template( array( 'mobile' => $mobile, 'smsbody' => $smsbody ), $fields );
        $payload = json_encode( $fields );
        //print_r($payload);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );


        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen( $payload ) ) );
        //Execute CURL
        $result = curl_exec( $ch );
		
		//$result = $result['status'];

        if ( $result === 'FAILED' ) {

          if ( substr( $result, 0, 5 ) == "<?xml" ) {
            $xml = simplexml_load_string( $result );
            $json = json_encode( $xml );
            $result = json_decode( $json, TRUE );

            $return_val = serialize( $result );
          } else {
            $return_val = serialize( $result );
          }
          $Asql = mysqli_query( $conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('" . $mobile . "','" . $smsbody . "','" . $return_val . "','" . $sms_id . "','" . $SUser_ID . "','false',NOW())" );
          return false;
          //return 'Curl error: ' . curl_error($ch);
        } else {
          // echo 'Curl error: ' . curl_error($ch);
          if ( substr( $result, 0, 5 ) == "<?xml" ) {
            $xml = simplexml_load_string( $result );
            $json = json_encode( $xml );
            $result = json_decode( $json, TRUE );

            $return_val = serialize( $result );
          } else {
            $return_val = serialize( $result );
          }

          $Asql = mysqli_query( $conn, "INSERT INTO tbl_sms_log (`number`, `sms_body`, `return_message`, `from_api`, `snder_id`, sms_status, date_time) VALUES ('" . $mobile . "','" . $smsbody . "','" . $return_val . "','" . $sms_id . "','" . $SUser_ID . "','true',NOW())" );
          return true;
          //return 'Operation completed without any errors';							
        }
        curl_close( $ch );
      }
    }
  }
}
?>
