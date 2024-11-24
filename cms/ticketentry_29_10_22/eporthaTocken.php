<?php
 $curl = curl_init();
    curl_setopt_array( $curl, array(
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
      ),
    ) );
    $response = curl_exec( $curl );
    curl_close( $curl );

    $resuls = json_decode( $response, true );

    $curl = curl_init();
    $resuls['access_token'];

 $post='{
    "reference_id": "16122",
    "agent": {
        "id": 5446,
        "app": "3",
        "uid": "LA1617882774",
        "code": "880",
        "name": "সুইটি",
        "email": "sweety@yahoo.com",
        "token": "'.$resuls['access_token'].'",
        "app_id": "100010",
        "mobile": "01771882876",
        "name_en": null,
        "username": "sweety",
        "user_type": 3
    },
    "citizen": {
        "id": 1,
        "uid": "CI1557287820",
        "code": 880,
        "mobile": "01717303200",
        "name": "\u09ae\u09cb\u0983 \u09ae\u09c1\u09a8\u09bf\u09b0 \u09b9\u09cb\u09b8\u09c7\u09a8",
        "name_en": "MD. MUNIR HOSSAIN",
        "fname": "\u09ae\u09cb\u0983 \u0986\u09ac\u09cd\u09a6\u09c1\u09b2 \u09ae\u09be\u09b2\u09c7\u0995",
        "fname_en": "Md.Abdul Malek",
        "mname": "\u09b0\u09be\u09b9\u09bf\u09ae\u09be \u09ac\u09c7\u0997\u09ae",
        "mname_en": "Rahima Begum",
        "sname": "test",
        "sname_en": null,
        "dob": "09-11-1986",
        "photo": "1-1580191272.jpg",
        "national_id_no": "6427882573",
        "verified_national_id_no": 1,
        "passport_no": "test",
        "verified_passport_no": 0,
        "birth_certificate_no": null,
        "verified_birth_certificate_no": 0,
        "driving_licence_no": null,
        "verified_driving_licence_no": 0,
        "tin_no": null,
        "educational_qualification": null,
        "email": "munir019@yahoo.com",
        "nationality": null,
        "gender": "male",
        "occupation": "TEST",
        "religion": null,
        "registration_on": "\u09e8\u09e6\u09e8\u09e6-\u09e6\u09e9-\u09e8\u09e9T\u09e7\u09e7:\u09e6\u09e6:\u09e7\u09e9",
        "user_type": 3,
        "age": 35,
        "picture": "storage\/citizen\/4b55e8a82a0f5971f4467f3c3046c625\/1-1615044161.jpg",
        "disk_usages": 27058426,
        "pre_address1": "Gazipura",
        "pre_address2": null,
        "per_address1": "Orangebd",
        "per_address2": null,
        "office_address1": null,
        "office_address2": null,
        "address1": "Gazipura",
        "address2": null,
        "username": "munir019"
    }
}';
    curl_setopt_array( $curl, array(
      CURLOPT_URL => 'https://eporcha.gov.bd/api/v1/hotline/agent-info',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$post ,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$resuls['access_token'].'', 'Content-Type: application/json'
      ),
    ) );

    $response = curl_exec( $curl );
    print($response );

    curl_close( $curl );
    
$final_result=json_decode( $response, true );

echo $final_result['data']['redirect'].'?secure_token='.$final_result['data']['secure_token'];

    exit;
?>