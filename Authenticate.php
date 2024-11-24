<?php
include('vendor/autoload.php');
use \Firebase\JWT\JWT;
include "Library/dbconnect.php";
include 'Library/Library.php';
session_start();
if(isset($_POST['name'])&& $_POST['name']!="" || isset($_POST['pass']) && $_POST['pass']!=""){
   // $title = $_POST['name'];
  //  $pass = $_POST['pass'];
	
	$title =strip_tags(trim($_POST['name']));
    $pass = strip_tags(trim($_POST['pass']));
   $member_query="SELECT    _nisl_mas_member.`User_ID` ,
                                  _nisl_mas_user.`NAME`,
                                  _nisl_mas_user.`name_bn`,
                                  _nisl_mas_member.User_Name,
                                  _nisl_mas_user.`nid_number` AS nid,
                                  _nisl_mas_user.`phone`,
                                  _nisl_mas_user.`email`,
                                  _nisl_mas_user.`Address`,
                                  _nisl_mas_user.`permanent_address` ,
                                  tbl_user_type.type_name AS user_type,
                                  _nisl_mas_user.user_image,
                                  _nisl_mas_user.user_nid,
                                  _nisl_mas_member.suboffice_id,
                                  _nisl_mas_user.Designation,         
                                  _nisl_mas_user.division,
                                  _nisl_mas_member.Type,
                                  _nisl_mas_user.district,
                                  _nisl_mas_user.upozela,
                                  `_nisl_mas_member`.`Password`,
                                  `_nisl_mas_member`.`Data_Status`
                        FROM      _nisl_mas_member
                        LEFT JOIN _nisl_mas_user
                        ON        _nisl_mas_user.user_id = _nisl_mas_member.user_id
                        LEFT JOIN tbl_user_type
                        ON        tbl_user_type.id=_nisl_mas_member.Type
                        WHERE _nisl_mas_member.User_Name='".mysql_real_escape_string($title)."' and user_status=1";
        $rset = mysql_query($member_query) or die(mysql_error());
        $row = mysql_fetch_array($rset);

        if(!$row)
        {
            header("Location: login.php");
            exit;
        }
        else
        {
                extract($row);
                if(($title==$User_Name) && ($pass==$Password) && ($Data_Status==0))
                {
					ini_set('session.gc_maxlifetime', 72000);
                    $_SESSION['SUserID']= $User_ID;
                    $_SESSION['SUserName']= $User_Name;
                    $_SESSION['Ssuboffice_id']= $suboffice_id;
                    $_SESSION['SDesignation']= $Designation;
					$_SESSION['SType']=$Type;
					$_SESSION['reseller_id']=$reseller_id;
					$_SESSION['Sdivision']= $division;
					$_SESSION['Sdistrict']=$district;
					$_SESSION['Supozela']=$upozela;
					$_SESSION['SSO_User']=0;
                    $_SESSION['Sdata']=$row;     
					if(isset($_POST['remember']))
						{
							 setcookie('username',$title, time() + (60*60*24*30)); //30 days
							 setcookie('password',$pass, time() + (60*60*24*30)); //30 days
						}
                    $data=array('id'=>$User_ID,'user_name'=>$User_Name,'NAME'=>$NAME,'NAME_BN'=>$name_bn,'nid'=>$nid,'phone'=>$phone,'email'=>$email,'Address'=>$Address,'permanent_address'=>$permanent_address,'user_type'=>$user_type,'user_image'=>'http://hotline.land.gov.bd/upload/'.$user_image,'user_nid'=>'http://hotline.land.gov.bd/upload/'.$user_nid,'Data_Status'=>$Data_Status);
                    
                    $_SESSION['SSOdata']=$data;
                    $user_data = $data;
                    $issuedAt = time();
                    $expirationTime = $issuedAt + 1800;  // jwt valid for 60 seconds from the issued time
                    $serverName = "hotline.land.gov.bd";
                    $payload = array(
                        'user_data' => $user_data,
                        'iat' => $issuedAt,
                        'exp' => $expirationTime,
                        'serverName'=>$serverName
                    );
                    
                    $key = 'dPo1W653CNg6LiMFMLg7b9Xs6hwbe814';
                    $alg = 'HS256';
                    $jwt = JWT::encode($payload, $key, $alg);
                    $_SESSION['jwt']=$jwt;                    
                    
					$furl_main=$_SESSION['furl_main'];
					if($furl_main!=''){
						header("Location: ".$furl_main."");	
						}
					else{
                   		 header("Location: dashboard.php");
						}
							
                    		exit;
                    
                }
                else
                {
                   		header("Location: login.php");
                    exit;
                }    
        }
    }
else{

$service_secret_key='5da2fc858c427';
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = parse_url($actual_link, PHP_URL_PATH);
$pathFragments = explode('/', $path);
$token = end($pathFragments);
if($token==''){
	die;
	}
function objectToArray($d) 
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

$nearray = (array)JWT::decode($token, $service_secret_key, array('HS256'));
$user=objectToArray($nearray);


$success=$user['success'];
if($success == 'true'){
$id=$user['id'];
$name_en=$user['name_en'];
$user['name_bn'];
$user['username'];
$user['office_id'];
$user['designation_id'];
$user['user_group_id'];
$user['photo'];
$user['signature'];
$user['mobile'];
$user['email'];
$user['jomi_designations']['name_bn'];
$user['jomi_designations']['id'];
$user['jomi_offices']['title_bn'];
$user['jomi_offices']['parent'];
$user['jomi_offices']['id'];
$user['jomi_upazilas']['name_bd'];
$user['jomi_upazilas']['id'];
$user['jomi_districts']['name_bn'];
$user['jomi_districts']['id'];
$user['jomi_divisions']['name_bn'];
$user['jomi_divisions']['id'];
$user['msg'];
$user['success'];
$user['token']['token'];
$user['country_code'];
$user['office_name']['title_bn'];
$user['designation_name']['name_bn'];

$user['jomi_designations']['name_bn'];
$Type= pick('tbl_user_type','id',"type_name='".$user['jomi_designations']['name_bn']."'");
$suboffice_id= pick('tbl_suboffice','suboffice_id',"name='".$user['jomi_offices']['title_bn']."'");
if(($Type!='' && $Type > 1 ) && $id != 1 ){
	
	////Get Ip Address Function Start//

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
////Get Ip Address Function end//
//Log Save Start/////
$ipaddress=getUserIpAddr();
$data=serialize($user);
$insert_query_log="INSERT INTO `tbl_access_log`
								(`user_name`,
								`ipaddress`,
								`time`, 
								`return_data`,
								`status`,
								`division`,
								`district`,
								`upojila`,
								`emp_name`,
								`emp_id`,
								`email`,
								`mobile`,
								`designation`,
								`emp_name_bn`)
							 VALUES (
							 			'".mysqli_real_escape_string($conn,$user['username'])."' ,
										'".mysqli_real_escape_string($conn,$ipaddress)."' ,
										NOW(),
										'".mysqli_real_escape_string($conn,$data)."',
										'Success',
										'".mysqli_real_escape_string($conn,$user['jomi_divisions']['id'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_districts']['id'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_upazilas']['id'])."',
										'".mysqli_real_escape_string($conn,$user['name_en'])."',
										'".mysqli_real_escape_string($conn,$user['username'])."',
										'".mysqli_real_escape_string($conn,$user['email'])."',
										'".mysqli_real_escape_string($conn,$user['mobile'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_designations']['name_bn'])."',
										'".mysqli_real_escape_string($conn,$user['name_bn'])."')";
mysqli_query($conn, $insert_query_log) or die(mysqli_error($conn));

//Log Save End/////
	
	
	
	$has_user= pick('_nisl_mas_user','COUNT(User_ID)',"User_ID='".$id."'");
	
	if($has_user<=0){
		
		
		
	$insert_query2 = "insert into _nisl_mas_user
		(
			User_ID,
		    Name,
		    Designation,
		    Address,
		    Email,
		    Phone,
			user_status,
			division,
			district,
			upozela
		)
		values
		(
			'".$user['id']."',
		    '".$user['name_bn']."',
		    '".$user['jomi_designations']['id']."',
		    '".$user['office_name']['title_bn']."',
		    '".$user['email']."',
		    '".$user['mobile']."',
			'1',
			'".$user['jomi_divisions']['id']."',
			'".$user['jomi_districts']['id']."',
			'".$user['jomi_upazilas']['id']."'
		)
        ";
		mysqli_query($conn, $insert_query2) or die(mysqli_error());
		$insert_query1 = "insert into _nisl_mas_member
		                  (
		                        User_Name,
		                        User_ID,
		                        Password,
		                        Type,
		                        suboffice_id,
								reseller_id
		                  )
		                  values
		                  (
		                       '".$user['username']."',
		                       '".$user['id']."',
		                       'accessdenied',
		                       '".$Type."',
		                       '".$user['jomi_offices']['id']."',
								'0'
		                  )
		                  ";
		$res2 = mysqli_query($conn, $insert_query1) or die(mysqli_error());				  
	}
	else{
		$res1 = mysqli_query($conn,"UPDATE _nisl_mas_user 
								SET 
								Name = '".$user['name_bn']."',
								Designation = '".$Type."',
								Address =  '".$user['office_name']['title_bn']."',
								Email = '".$user['email']."',
								Phone = '".$user['mobile']."',
								division='".$user['jomi_divisions']['id']."',
								district='".$user['jomi_districts']['id']."',
								upozela='".$user['jomi_upazilas']['id']."'
								WHERE User_ID = '".$user['id']."'
							");
		$res2 = mysqli_query($conn,"  UPDATE _nisl_mas_member 
								SET 
								User_Name = '".$user['username']."',
								Type =  '".$Type."',
								suboffice_id =  '".$user['jomi_offices']['id']."'
								WHERE User_ID = '".$user['id']."'
							");				
		}
ini_set('session.gc_maxlifetime', 72000);
$_SESSION['SUserID']=$id;
$_SESSION['SUserName']= $user['name_bn'];
$_SESSION['Ssuboffice_id']= $suboffice_id;
$_SESSION['SDesignation']=$Type;
$_SESSION['SType']=$Type;
$_SESSION['reseller_id']=$reseller_id;
$_SESSION['Sdivision']= $user['jomi_divisions']['id'];
$_SESSION['Sdistrict']=$user['jomi_districts']['id'];
$_SESSION['Supozela']=$user['jomi_upazilas']['id'];
$_SESSION['SSO_User']='1';
$_SESSION['SURL']="https://office.land.gov.bd/";
 header("Location: ../dashboard.php");
}
else{
		////Get Ip Address Function Start//

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
////Get Ip Address Function end//
//Log Save Start/////
$ipaddress=getUserIpAddr();
$data=serialize($user);
$insert_query_log="INSERT INTO `tbl_access_log`
								(`user_name`,
								`ipaddress`,
								`time`, 
								`return_data`,
								`status`,
								`division`,
								`district`,
								`upojila`,
								`emp_name`,
								`emp_id`,
								`email`,
								`mobile`,
								`designation`,
								`emp_name_bn`)
							 VALUES (
							 			'".mysqli_real_escape_string($conn,$user['username'])."' ,
										'".mysqli_real_escape_string($conn,$ipaddress)."' ,
										NOW(),
										'".mysqli_real_escape_string($conn,$data)."',
										'Fail',
										'".mysqli_real_escape_string($conn,$user['jomi_divisions']['id'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_districts']['id'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_upazilas']['id'])."',
										'".mysqli_real_escape_string($conn,$user['name_en'])."',
										'".mysqli_real_escape_string($conn,$user['username'])."',
										'".mysqli_real_escape_string($conn,$user['email'])."',
										'".mysqli_real_escape_string($conn,$user['mobile'])."',
										'".mysqli_real_escape_string($conn,$user['jomi_designations']['name_bn'])."',
										'".mysqli_real_escape_string($conn,$user['name_bn'])."')";
mysqli_query($conn, $insert_query_log) or die(mysqli_error($conn));

//Log Save End/////
	echo 'Permission denied ';
	
	}
}
	}
	
?>