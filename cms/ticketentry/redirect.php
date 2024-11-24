<?php 
//print_r($_POST);
include( 'support_function.php' );
header( 'Content-Type: text/html; charset=utf-8' );
extract($_POST);
//echo $suserid;
call_success( $suserid, $txtcontact_number, $txtcontact_person, $service_type, $subject, $description, '', '', $division_id, $district, $upozila, "",  $no, $nid, $dateOfBirth,$service_tag);
header("location:".$href."");
?>