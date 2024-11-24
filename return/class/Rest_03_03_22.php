<?php
class Rest {
  private $host = 'localhost';
  private $user = 'root';
  private $password = "land@gov@2019";
  private $database = "landcms";
  private $dbConnect = false;

  public function __construct() {
    if ( !$this->dbConnect ) {
      $conn = new mysqli( $this->host, $this->user, $this->password, $this->database );
		mysqli_set_charset($conn,"utf8");
      if ( $conn->connect_error ) {
        die( "Error failed to connect to MySQL: " . $conn->connect_error );
      } else {
        $this->dbConnect = $conn;
      }
    }

  }


  public function pick( $table, $field, $cond ) {
    $tt = NULL;
    if ( $cond == NULL ) {
      $query = "Select $field from $table";
    } else {
      $query = "Select $field from $table where $cond";
    }
    $ResultSet = mysqli_query( $this->dbConnect, $query )
    or die( "Invalid query: " . mysqli_error() );

    while ( $qry_row = mysqli_fetch_array( $ResultSet ) ) {
      if ( $tt == NULL ) {
        $tt = $qry_row[ 0 ];
      } else {
        $tt = $tt . '<BR>' . $qry_row[ 0 ];
      }
    }
    return $tt;
  }

  public function saveData( $agent_id, $citizen_mobile, $citizen_name, $application_type, $subject = NULL, $description = NULL, $email = NULL, $address = NULL, $division_bbs = NULL, $district_bbs = NULL, $upozila_bbs = NULL, $application_code, $error_handeler_code ) {
    $sqlQuery = '';
    if ( $citizen_mobile == '' ) {
      $error_handeler_code[ '402' ];
      $error = array( "Error_code" => '402', "Error_msg" => $error_handeler_code[ '402' ] );
      echo json_encode( $error );
      die;
    }
    if ( $citizen_mobile ) {
      if ( $division_bbs > 0 ) {
        $division_id = Rest::pick( "tbl_division", "id", " division_bbs_code='" . $division_bbs . "'" );
      }
      if ( $district_bbs > 0 ) {
        $district = Rest::pick( "tbl_district", "id", " district_bbs_code='" . $district_bbs . "'" );
      }
      if ( $upozila_bbs > 0 ) {
        $upozila = Rest::pick( "tbl_upozila", "id", " upozila_bbs_code='" . $upozila_bbs . "'" );
      }
	  $stodate=date('Y/m');
      $txttask_no = Rest::pick( "tbl_task", "max(task_no)", "DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'" );

      if ( $txttask_no < 1 ) {
        $timestamp = date( 'y/m/d' );
        $pieces = explode( "/", $timestamp );
        $txttask_no = $division_bbs . '' . $district_bbs . '' . $pieces[ 0 ] . $pieces[ 1 ] . "0001";
      } else {
        $txttask_no = Rest::pick( "tbl_task", "max(RIGHT(task_no, 4))", "DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'" ) + 1;
        $txttask_nos = str_pad( $txttask_no, 4, '0', STR_PAD_LEFT );
        $timestamp = date( 'y/m/d' );
        $pieces = explode( "/", $timestamp );
        $txttask_no = $division_bbs . '' . $district_bbs . '' . $pieces[ 0 ] . '' . $pieces[ 1 ] . '' . $txttask_nos;
      }


      $Asql = "INSERT INTO tbl_task (
							task_no,							
							prob_type,
							contact_number,
							contact_person,
							contact_person_no,
							subject,
							description,
							open_date,
							task_status,							
							task_priority,
							down_time,
							created_by,
							entry_by,
							entry_date,
							email,
							address,
							division,
							district,
							upozila,
							service_type,							
							solv_solution,
							application_code
						) VALUES (
							'" . mysqli_real_escape_string( $this->dbConnect, $txttask_no ) . "',						
							'" . mysqli_real_escape_string( $this->dbConnect, '4' ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $citizen_mobile ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $citizen_name ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $citizen_mobile ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $subject ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $description ) . "',
							NOW(),
							'" . mysqli_real_escape_string( $this->dbConnect, '1' ) . "',							
							'" . mysqli_real_escape_string( $this->dbConnect, '1' ) . "',
							NOW(),
							'$agent_id',
							'$agent_id',
							NOW(),
							'" . mysqli_real_escape_string( $this->dbConnect, $email ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $address ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $division_id ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $district ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $upozila ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $application_type ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, 'সেবা দেয়া হয়েছে ' ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $application_code ) . "'
						)";
      //echo $Asql;
      mysqli_query( $this->dbConnect, $Asql )or die( mysql_error() );

      $rvalue = array( "Error_code" => "200", "Error_msg" => "Success" );
      return json_encode( $rvalue );
      die;

    } else {
      $error_handeler_code[ '403' ];
      $error = array( "Error_code" => '403', "Error_msg" => $error_handeler_code[ '403' ] );
      return json_encode( $error );
      die;
    }
    header( 'Content-Type: application/json' );
    return json_encode( $empResponse );
  }

  public function saveDataInternal( $agent_id, $citizen_mobile, $citizen_name, $application_type, $subject = NULL, $description = NULL, $email = NULL, $address = NULL, $division_bbs = NULL, $district_bbs = NULL, $upozila_bbs = NULL, $application_code=null, $error_handeler_code,$txtcontact_person_no= NULL, $nid= NULL, $dateOfBirth= NULL, $service_tag=NULL  ) {
    $sqlQuery = '';
    if ( $citizen_mobile == '' ) {
      $error_handeler_code[ '402' ];
      $error = array( "Error_code" => '402', "Error_msg" => $error_handeler_code[ '402' ] );
      return json_encode( $error );
      die;
    }
    if ( $citizen_mobile ) {
      if ( $division_bbs > 0 ) {
        $division_id = $division_bbs;
      }
      if ( $district_bbs > 0 ) {
        $district = $district_bbs;
      }
      if ( $upozila_bbs > 0 ) {
        $upozila = $upozila_bbs;
      }

      $div_bbs = Rest::pick( "tbl_division", "division_bbs_code", "id='$division_id'" );

      $dis_bbs = Rest::pick( "tbl_district", "district_bbs_code", "id='$district'" );
$stodate=date('Y/m');
      $txttask_no = Rest::pick( "tbl_task", "max(task_no)", "DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'" );

      if ( $txttask_no < 1 ) {
        $timestamp = date( 'y/m/d' );
        $pieces = explode( "/", $timestamp );
        $txttask_no = $div_bbs . '' . $dis_bbs . '' . $pieces[ 0 ] . $pieces[ 1 ] . "0001";
      } else {
        $txttask_no = Rest::pick( "tbl_task", "max(RIGHT(task_no, 4))", "DATE_FORMAT(`open_date`,'%Y/%m')='$stodate'" ) + 1;
        $txttask_nos = str_pad( $txttask_no, 4, '0', STR_PAD_LEFT );
        $timestamp = date( 'y/m/d' );
        $pieces = explode( "/", $timestamp );
        $txttask_no = $div_bbs . '' . $dis_bbs . '' . $pieces[ 0 ] . '' . $pieces[ 1 ] . '' . $txttask_nos;
      }
$hascitizen=Rest::pick('tbl_citizen','id',"mobile='".$citizen_mobile."'");

if($hascitizen<=0){
  $upozila_bbs=Rest::pick('tbl_upozila','upozila_bbs_code',"id='".$upozila."'");
  
    mysqli_query($this->dbConnect,"INSERT
      INTO
        `tbl_citizen`(
          `mobile`,
          `name`,
          `email`,
          `address`,
          `division_bbs`,
          `district_bbs`,
          `upozila_bbs`,
          `nid`,
          `date_of_birth`
        )
      VALUES(
        '".mysqli_real_escape_string($this->dbConnect,$citizen_mobile)."',
        '".mysqli_real_escape_string($this->dbConnect,$citizen_name)."',
        '".mysqli_real_escape_string($this->dbConnect,$email)."',
        '".mysqli_real_escape_string($this->dbConnect,$address)."',
        '".mysqli_real_escape_string($this->dbConnect,$div_bbs)."',
        '".mysqli_real_escape_string($this->dbConnect,$dis_bbs)."',
        '".mysqli_real_escape_string($this->dbConnect,$upozila_bbs)."',
        '".mysqli_real_escape_string($this->dbConnect,$nid)."',
        '".mysqli_real_escape_string($this->dbConnect,$dateOfBirth)."'
      )");
  }

      $Asql = "INSERT INTO tbl_task (
							task_no,							
							prob_type,
							contact_number,
							contact_person,
							contact_person_no,
							subject,
							description,
							open_date,
							task_status,							
							task_priority,
							down_time,
							created_by,
							entry_by,
							entry_date,
							email,
							address,
							division,
							district,
							upozila,
							service_type,							
							solv_solution,
							application_code,              
              nid,
              date_of_birth,
              service_tag
						) VALUES (
							'" . mysqli_real_escape_string( $this->dbConnect, $txttask_no ) . "',						
							'" . mysqli_real_escape_string( $this->dbConnect, '4' ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $citizen_mobile ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $citizen_name ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $txtcontact_person_no ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $subject ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $description ) . "',
							NOW(),
							'" . mysqli_real_escape_string( $this->dbConnect, '1' ) . "',							
							'" . mysqli_real_escape_string( $this->dbConnect, '1' ) . "',
							NOW(),
							'$agent_id',
							'$agent_id',
							NOW(),
							'" . mysqli_real_escape_string( $this->dbConnect, $email ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $address ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $division_id ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $district ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $upozila ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $application_type ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, 'সেবা দেয়া হয়েছে ' ) . "',
							'" . mysqli_real_escape_string( $this->dbConnect, $application_code ) . "',            
              '" . mysqli_real_escape_string( $this->dbConnect, $nid ) . "',
              '" . mysqli_real_escape_string( $this->dbConnect, $dateOfBirth ) . "',
              '" . mysqli_real_escape_string( $this->dbConnect, $service_tag ) . "'
						)";
     // echo $Asql;
      mysqli_query( $this->dbConnect, $Asql )or die( mysql_error() );

      $rvalue = array( "Error_code" => "200", "Error_msg" => "Success" );
      return json_encode( $rvalue );
      die;

    } else {
      $error_handeler_code[ '403' ];
      $error = array( "Error_code" => '403', "Error_msg" => $error_handeler_code[ '403' ] );
      return json_encode( $error );
      die;
    }
    header( 'Content-Type: application/json' );
    return json_encode( $empResponse );
  }
}
?>
