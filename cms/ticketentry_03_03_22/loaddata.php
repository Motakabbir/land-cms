<?php
session_start();

$SUserID = $_SESSION['SUserID'];
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
include ('../../vendor/autoload.php');
include ('support_function.php');
//print_r($_SESSION);
use \Firebase\JWT\JWT;
$txtcontact_number = $_REQUEST['txtcontact_number'];
if ($txtcontact_number != '' && strlen($txtcontact_number) >= 10)
{

    $txtcontact_person = $_REQUEST['txtcontact_person'];
    $txtcontact_number = $_REQUEST['txtcontact_number'];
    $service_type = $_REQUEST['service_type'];
    $division_id = $_REQUEST['division_id'];
    $district = $_REQUEST['district'];
    $upozila = $_REQUEST['upozila'];
    $service_tag = $_REQUEST['service_tag'];
    $txtcontact_person_no = $_REQUEST['txtcontact_person_no'];
    $nid = $_REQUEST['nid'];
    $dateOfBirth = $_REQUEST['dateOfBirth'];
    if ($division_id > 0)
    {
        $division_bbs = pick("tbl_division", "division_bbs_code", " id='" . $division_id . "'");
    }
    if ($district > 0)
    {
        $district_bbs = pick("tbl_district", "district_bbs_code", " id='" . $district . "'");
    }
    if ($upozila > 0)
    {
        $upozila_bbs = pick("tbl_upozila", "upozila_bbs_code", " id='" . $upozila . "'");
    }
    if ($service_type > 0)
    {
        $url = pick("tbl_service_type", "url", " prob_id='" . $service_type . "'");
    }

    $rdata = array();
    $status = array(
        'status' => '1'
    );
    $data = $_SESSION['SSOdata'];
    $user_data = $data;
    $citizen_data = array(
        'citizen_mobile' => $txtcontact_number,
        'citizen_name' => $txtcontact_person,
        'application_type' => $service_type,
        'division_bbs' => $division_bbs,
        'district_bbs' => $district_bbs,
        'upozila_bbs' => $upozila_bbs,
        'nid' => $nid
    );
    //print_r($citizen_data);
    $issuedAt = time();
    $expirationTime = $issuedAt + 2592000; // jwt valid for 60 seconds from the issued time
    $serverName = "hotline.land.gov.bd";
    $payload = array(
        'user_data' => $user_data,
        'citizen_data' => $citizen_data,
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'serverName' => $serverName,
        'service_type' => 'application'
    );
    $key = 'dPo1W653CNg6LiMFMLg7b9Xs6hwbe814';
    $alg = 'HS256';
    $jwt = JWT::encode($payload, $key, $alg);
    $nurl = '';
    if ($txtcontact_number != '' && $txtcontact_person != '' && $service_type > 0 && $service_tag > 0 && $division_id > 0 && $district > 0 && $upozila > 0 )
    {
        if ($service_type == 16)
        {

            $nurl = '<a type="submit" href="' . $url . '/' . $jwt . '" class="btn btn-primary btn-sm submit" name="submit" id="submit" >আবেদন <i class="fa fa-floppy-o" aria-hidden="true"></i></a> ';

            call_success($SUserID, $txtcontact_number, $txtcontact_person, $service_type, "অনলাইন ভূমি উন্নয়ন কর এর আবেদনের জন্য", "অনলাইন ভূমি উন্নয়ন কর আবেদনের জন্য কলটি করেছিল ", '', '', $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth, $service_tag);
        }

        elseif ($service_type == 17)
        {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://eporcha.gov.bd/api/v1/auth/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
    "grant_type" : "app_token",
    "client_id":"14",
    "client_secret":"Evtub7cGt6g7ziLDvpUG63cN76ZmCYVIqde91zKD",
    "id":"8725357",
    "key":"KH5DHxqD",
    "service":"hotline"
}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ) ,
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $resuls = json_decode($response, true);
            //writeLog('tocken',print_r($resuls, true));
            $curl = curl_init();
            $resuls['access_token'];

            $post = '{
                "reference_id": "16122",
                "agent": {
                    "id": 5446,
                    "app": "3",
                    "uid": "LA1617882774",
                    "code": "880",
                    "name": "' . $_SESSION['SSOdata']['user_name'] . '",
                    "email": "' . $_SESSION['SSOdata']['email'] . '",
                    "token": "' . $resuls['access_token'] . '",
                    "app_id": "100010",
                    "mobile": "' . $_SESSION['SSOdata']['phone'] . '",
                    "name_en": null,
                    "username": "' . $_SESSION['SSOdata']['user_name'] . '",
                    "user_type": 3
                },  
                "citizen": {
                    "id": 1,
                    "uid": null,
                    "code": 880,
                    "mobile": "' . $txtcontact_number . '",
                    "name": null,
                    "name_en": "' . $txtcontact_person . '",
                    "fname": null,
                    "fname_en": null,
                    "mname": null,
                    "mname_en": null,
                    "sname": null,
                    "sname_en": null,
                    "dob": null,
                    "photo": null,
                    "national_id_no": "' . $nid . '",
                    "verified_national_id_no": 0,
                    "passport_no": null,
                    "verified_passport_no": 0,
                    "birth_certificate_no": null,
                    "verified_birth_certificate_no": 0,
                    "driving_licence_no": null,
                    "verified_driving_licence_no": 0,
                    "tin_no": null,
                    "educational_qualification": null,
                    "email": null,
                    "nationality": null,
                    "gender": null,
                    "occupation": null,
                    "religion": null,
                    "registration_on": null,
                    "user_type": 3,
                    "age": 35,
                    "picture": null,
                    "disk_usages": null,
                    "pre_address1": null,
                    "pre_address2": null,
                    "per_address1": null,
                    "per_address2": null,
                    "office_address1": null,
                    "office_address2": null,
                    "address1": null,
                    "address2": null,
                    "username": null,
                    "citizen_mobile": "' . $txtcontact_number . '",
                    "citizen_name": "' . $txtcontact_person . '",
                    "application_type": "' . $service_type . '",
                    "division_bbs": "' . $division_bbs . '",
                    "district_bbs": "' . $district_bbs . '",
                    "upozila_bbs": "' . $upozila_bbs . '",
                    "nid": "' . $nid . '"
                }
            }';

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://eporcha.gov.bd/api/v1/hotline/agent-info',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $resuls['access_token'] . '',
                    'Content-Type: application/json'
                ) ,
            ));

            $response = curl_exec($curl);
            
           

            $final_result = json_decode($response, true);
           
            $nurl = "<a href=\"#\" class=\" send btn btn-primary btn-sm \" data-href=\"" . $final_result['data']['redirect'] . '?secure_token=' . $final_result['data']['secure_token'] . "\" data-SUserID=\"" . $SUserID . "\" data-txtcontact_person=\"" . $txtcontact_person . "\"  data-txtcontact_number=\"" . $txtcontact_number . "\"  data-service_type=\"" . $service_type . "\"  data-subject=\"ই-পর্চা এর আবেদন\" data-description=\"ই-পর্চা এর আবেদন এর জন্য কলটি করেছিল \" data-division_id=\"" . $division_id . "\"  data-district=\"" . $district . "\"  data-upozila=\"" . $upozila . "\" data-txtcontact_person_no=\"" . $txtcontact_person_no . "\" data-nid=\"" . $nid . "\" data-dateOfBirth=\"" . $dateOfBirth . "\" data-service_tag=\"" . $service_tag . "\"  >আবেদন <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></a> ";

        }
        elseif ($service_type == 15)
        {

            $nurl = "<a href=\"#\" class=\" send btn btn-primary btn-sm \"  data-href=\"https://mutation.land.gov.bd/\" data-SUserID=\"" . $SUserID . "\" data-txtcontact_person=\"" . $txtcontact_person . "\"  data-txtcontact_number=\"" . $txtcontact_number . "\"  data-service_type=\"" . $service_type . "\"  data-subject=\"ই-নামজারি এর আবেদন\" data-description=\"ই-নামজারি এর আবেদন এর জন্য কলটি করেছিল \" data-division_id=\"" . $division_id . "\"  data-district=\"" . $district . "\"  data-upozila=\"" . $upozila . "\"  data-txtcontact_person_no=\"" . $txtcontact_person_no . "\" data-nid=\"" . $nid . "\" data-dateOfBirth=\"" . $dateOfBirth . "\" data-service_tag=\"" . $service_tag . "\">আবেদন <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></a> ";

        }
    }
    $app = array(
        'app' => $nurl . ' '
    );
    //'<a type="submit" href="https://eksheba.gov.bd/assistant/landcall/' . $jwt . '" class="btn btn-primary btn-sm submit" name="submit" id="submit" >আবেদন মাইগভ <i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
    $payload = array(
        'user_data' => $user_data,
        'citizen_data' => $citizen_data,
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'serverName' => $serverName,
        'service_type' => 'info'
    );

    $jwt_info = JWT::encode($payload, $key, $alg);
    $info = array(
        'info' => '<a type="submit" href="https://eksheba.gov.bd/assistant/landcall/' . $jwt_info . '" class="btn btn-primary btn-sm submit" name="submit" id="submit" >অনুসন্ধান <i class="fa fa-floppy-o" aria-hidden="true"></i></a>'
    );

    $rdata = $status + $app + $info;
    echo json_encode($rdata);
    //print_r($rdata);
    
}
else
{
    $status = array(
        'status' => '2'
    );

    echo json_encode($status);

}
?>
