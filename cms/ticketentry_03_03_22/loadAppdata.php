<?php
session_start();
include( 'support_function.php' );
$SUserID = $_SESSION[ 'SUserID' ];
header( 'Content-Type: text/html; charset=utf-8' );
$service_type = $_REQUEST[ 'service_type' ];
$txtcontact_number = $_REQUEST[ 'txtcontact_number' ];
$traking_id = $_REQUEST[ 'traking_id' ];

$info_type = $_REQUEST[ 'service_type' ];
$task_type = $_REQUEST[ 'task_type' ];
$txtcontact_person = $_REQUEST[ 'txtcontact_person' ];
$division_id = $_REQUEST[ 'division_id' ];
$district = $_REQUEST[ 'district' ];
$upozila = $_REQUEST[ 'upozila' ];

$txtcontact_person_no = $_REQUEST[ 'txtcontact_person_no' ];

$nid=$_REQUEST['nid'];
$date_of_birth=$_REQUEST['date_of_birth'];
$service_tag=$_REQUEST['service_tag'];
//print_r( $_REQUEST );
if ( $txtcontact_person != '' && $txtcontact_number != '' && $division_id > 0 && $district > 0 && $upozila > 0 && $service_type > 0 && $service_tag > 0) {

  if ( $service_type == '21' ) {
    if($traking_id!=''){
      $refno=$traking_id;
    }else{
      $refno=$txtcontact_number;
    }

    $curl = curl_init();
    curl_setopt_array( $curl, array(
      CURLOPT_URL => 'https://eporcha.gov.bd/api/v1/application/track',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
								"reference" : "' . $refno . '"
							}',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ) );

    $response = curl_exec( $curl );
    if ( $response === false ) {

      echo 'Curl error: ' . curl_error( $curl );
    } else {


    }
//print_r($response);
    curl_close( $curl );
    $stories = json_decode( $response, true );

    if ( empty( $stories[ 'data' ] ) ) {
      echo "<h1 class='text-center'> ".$stories[ 'message' ]."</h1>";

    } else {
      if ( count( $stories[ 'data' ] ) > 0 ): ?>
        <table class="table table-condensed table-bordered" cellpadding="0" cellspacing="0" style="width:100%">
          <thead>
            <tr>
              <th><?php echo implode('</th><th>', array_keys(current($stories['data']))); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stories['data'] as $row): array_map('htmlentities', $row); ?>
            <tr>
              <td><?php echo implode('</td><td>', $row); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php
    endif;
    call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, "ই-পর্চা এর আবেদনের অবস্থা জানার জন্য", "ই-পর্চা এর  আবেদনের অবস্থা জানার জন্য কলটি করেছিল ", '', '', $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth,$service_tag);

    }
}
  elseif ( $service_type == '19' ) {
    $curl = curl_init();

    curl_setopt_array( $curl, array(
      CURLOPT_URL => 'https://mutation-api-stage.land.gov.bd/api/getToken',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'username=mutation_api&password=a2i%40myGov&clientid=myGov',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ) );

    $response = curl_exec( $curl );

    curl_close( $curl );
    $tarray = json_decode( $response, true );
    if ( $traking_id == '' ) {
      $curl = curl_init();
      curl_setopt_array( $curl, array(
        CURLOPT_URL => 'https://mutation-api-stage.land.gov.bd/api/get-applicant-info',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'mobile_no=' . $txtcontact_number . '&divisionId=' . $division_id . '',
        CURLOPT_HTTPHEADER => array(
          'APIAuthorization: ' . $tarray[ 'token' ] . ''
        ),
      ) );

      $response = curl_exec( $curl );

      curl_close( $curl );
    } else {
      $curl = curl_init();

      curl_setopt_array( $curl, array(
        CURLOPT_URL => 'https://mutation-api-stage.land.gov.bd/api/get-applicant',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'trackingNo=' . $traking_id . '&divisionId=' . $division_id . '',
        CURLOPT_HTTPHEADER => array(
          'APIAuthorization: ' . $tarray[ 'token' ] . ''
        ),
      ) );

      $response = curl_exec( $curl );

      curl_close( $curl );

    }
    $stories = json_decode( $response, true );
    if ( empty( $stories[ 'data' ] ) ) {
      echo "<h1 class='text-center'>কোন তথ্য পাওয়া যায়নি </h1>";

    } else {
      if ( count( $stories[ 'data' ] ) > 0 ): ?>
<table class="table table-condensed table-bordered" cellpadding="0" cellspacing="0" style="width:100%">
  <thead>
    <tr>
      <th><?php echo implode('</th><th>', array_keys(current($stories['data']))); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($stories['data'] as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
endif;
		
	call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, "ই-নামজারি এর আবেদনের অবস্থা জানার জন্য", "ই-নামজারি এর  আবেদনের অবস্থা জানার জন্য কলটি করেছিল ", '', '', $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth,$service_tag);

}
} 
  elseif($service_type == '22'){
		if($_REQUEST['certificate']==1){
			$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://prottoyon.olivineltd.com/api/verifyCertificate',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"userName": "SsoOL&",
		"password": "SsO@Olivine",
		"applicationNo": "'.$traking_id.'"
		}',
		CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;	
		$stories = json_decode( $response, true );
			if($stories['status']=='warning'){
				$class="warning";
			}elseif($stories['status']=='error'){
				$class="danger";
			}elseif($stories['status']=='success'){
				$class="success";
			}
			
		echo "<style>
		p {
				padding: 10px;
			}
		</style>
		<p class=\"bg-".$class."\">Status: ".$stories['response']."</p>
		";	
		}
	    else{
			$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://prottoyon.olivineltd.com/api/getApplicationStatus',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"userName": "SsoOL&",
		"password": "SsO@Olivine",
		"applicationNo": "'.$traking_id.'"
		}',
		CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$stories = json_decode( $response, true );
			if($stories['status']=='warning'){
				$class="warning";
			}elseif($stories['status']=='error'){
				$class="danger";
			}elseif($stories['status']=='success'){
				$class="success";
			}
			
		echo "<style>
		p {
				padding: 10px;
			}
		</style>
		<p class=\"bg-".$class."\">Status: ".$stories['response']."</p>
		";	
		}
		call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, "প্রত্যয়ন এর আবেদনের অবস্থা জানার জন্য", "প্রত্যয়ন এর  আবেদনের অবস্থা জানার জন্য কলটি করেছিল ", '', '', $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth,$service_tag);
			
	}else {
  echo "<h1 class='text-center'> সকল তথ্য প্রয়োজনীয়</h1>";
}
} else {
  echo "<h1 class='text-center'> সকল তথ্য প্রয়োজনীয়</h1>";
}
?>
