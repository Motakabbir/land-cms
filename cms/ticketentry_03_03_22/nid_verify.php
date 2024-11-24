<?php 
 include_once '../../Library/dbconnect.php';
 include_once '../../Library/Library.php';
function getAccessToken() {
  $token_url = "https://idp.land.gov.bd/auth/realms/prod/protocol/openid-connect/token";
  $client_id = 'nextech';
  $client_secret = "ad4736b7-68fd-4948-b459-4bf1e985e2f6";
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

function callSmsFunction($url,$authorization, $dateOfBirth, $nid ) {       
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
                             "dateOfBirth":"' . $dateOfBirth . '",
                             "nid":"' . $nid . '"
                            }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $authorization . '',
        'Content-Type: application/json'
      ),
    ) );
    $response = curl_exec( $curl );

    curl_close( $curl );
   return $response;
   // echo $response;
}
$result='';
$url="https://micro-api.land.gov.bd/api/broker-service/nid/details-v1";
$authorization = getAccessToken();
//print_r( $_REQUEST);
 $dateOfBirth=$_REQUEST['dateOfBirth'];
 $nid=$_REQUEST['nid'];
//$dateOfBirth='1990-09-30';
//$nid='5076217693';



if($dateOfBirth!=''&& $nid!=''){
    $result=callSmsFunction($url,$authorization, $dateOfBirth, $nid );
    $fresust=json_decode($result, true);
     //echo '<pre>';
    // print_r($fresust);
    if($fresust['status']==400){  
      $message=$fresust['generalErrors'][0].$fresust['data']['message'];  
      $new_array=array('status'=>$fresust['status'],'message'=>$message);
      echo json_encode($new_array);
    }elseif($fresust['status']==200){
      $dis_id=pick('tbl_district','id',"name='".$fresust['data']['presentAddress']['district']."'");
      $new_array=array(
                    'status'=>$fresust['status'],
                    'name'=>$fresust['data']['name'],
                    'gender'=>$fresust['data']['gender'],
                    'father'=>$fresust['data']['father'],
                    'mother'=>$fresust['data']['mother'],
                    'nationalId'=>$fresust['data']['nationalId'],
                    'division'=>$fresust['data']['presentAddress']['division'],
                    'division_id'=>pick('tbl_division','id',"name='".$fresust['data']['presentAddress']['division']."'"),
                    'district'=>$fresust['data']['presentAddress']['district'],
                    'district_id'=>pick('tbl_district','id',"name='".$fresust['data']['presentAddress']['district']."'"),
                    'upozila'=>$fresust['data']['presentAddress']['upozila'],
                    'upozila_id'=>pick('tbl_upozila','id',"name='".$fresust['data']['presentAddress']['upozila']."' and district='".$dis_id."'"),
                    'unionOrWard'=>$fresust['data']['presentAddress']['unionOrWard'],
                    'postOffice'=>$fresust['data']['presentAddress']['postOffice'],
                    'additionalMouzaOrMoholla'=>$fresust['data']['presentAddress']['additionalMouzaOrMoholla'],
                    'additionalVillageOrRoad'=>$fresust['data']['presentAddress']['additionalVillageOrRoad'],
                    'region'=>$fresust['data']['presentAddress']['region'],
                    'mobile'=>$fresust['data']['mobile'],
                    'region'=>$fresust['data']['religion'],
                  );
      //print_r($new_array);
      echo json_encode($new_array,JSON_UNESCAPED_UNICODE );
    }

    //echo '</pre>';
}

?>