<div class="clr"></div>
<div class="row">


<style>
table {border-collapse:collapse; table-layout:fixed; width:310px;}
       table td { width:100px !important; word-wrap:break-word !important;}
	   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 3px;
    line-height: 1.42857143;
    vertical-align: top;
    font-size: 10px;
    border-top: 1px solid #ddd;
}
</style>
<?php 

include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
 session_start();	
$SUserID = $_SESSION['SUserID'];
$Sdivision=$_SESSION['Sdivision'];
$Sdistrict=$_SESSION['Sdistrict'];
$Supozela=$_SESSION['Supozela'];
$SType=$_SESSION['SType'];

$cond='';


$service_type=$_REQUEST['service_type'];
if($service_type>0){
	$ser=pickarray("tbl_service_type","prob_id","srv_type='".$service_type."'");
	$tag=pickarray("tbl_service_tag","id","service_type='".$service_type."'");
}

// echo '<pre>';
// 	print_r($ser);
// 	print_r($tag);
// echo '</pre>';

// exit;


$probtype= $_REQUEST['probtype'];
if( is_array($probtype)){
    $invalue="";
	while (list ($key, $val) = each ($probtype)) {
	   
		if($val=='-1'){
			$invalue=$ser;
			break;
		}else{
		    
			 if($invalue==''){
					$invalue=$val;
					 //echo "$val <br>";
				}else{
					$invalue=$invalue.','.$val;
				}
		}
	}
}else{
	if($service_type>0){
		$invalue=$ser;
	}
}

$service_tag= $_REQUEST['service_tag'];
if( is_array($service_tag)){
    $invalue_tag="";
	while (list ($key, $val) = each ($service_tag)) {
	   
		if($val=='-1'){
			$invalue_tag=$tag;
			break;
		}else{
		    
			 if($invalue_tag==''){
					$invalue_tag=$val;
					 //echo "$val <br>";
				}else{
					$invalue_tag=$invalue_tag.','.$val;
				}
		}
	}
}else{
	if($service_type>0){
		$invalue_tag=$tag;
	}
}

 $ehead='';	


 if($service_type>0){
 	if($service_type==1){
 		$ehead .="অভিযোগ <br>";
 	}elseif($service_type==2){
 		$ehead .="আবেদন <br>";
 	}elseif($service_type==3){
 		$ehead .="তথ্য <br>";
 	}
 	
 }

 if(isset($_REQUEST['division_id']) && $_REQUEST['division_id'] !='-1' ){
	 $ehead .=' বিভাগ= '.pick('tbl_division','name','id ='.$_REQUEST['division_id'].'').', ';
 	$cond .=" AND tbl_task.division='".$_REQUEST['division_id']."'";
 }

if(isset($_REQUEST['district']) && $_REQUEST['district'] !='-1'){
	$ehead .=' জেলা= '.pick('tbl_district','name','id ='.$_REQUEST['district'].'').', ';
 	$cond .=" AND tbl_task.district='".$_REQUEST['district']."'";
 }

if(isset($_REQUEST['upozila']) && $_REQUEST['upozila'] !='-1'){
	$ehead .=' উপজেলা = '.pick('tbl_upozila','name','id ='.$_REQUEST['upozila'].'').', ';
 	$cond .=" AND tbl_task.upozila='".$_REQUEST['upozila']."'";
 } 	

if($invalue!=''){
	$cond .=" and tbl_task.service_type IN ($invalue)";
	}

if($invalue_tag!=''){
	$cond .=" and tbl_task.service_tag IN ($invalue_tag)";
	}	
if(isset($_REQUEST['task_statusid']) && $_REQUEST['task_statusid'] !='-1'){
	$ehead .=' অবস্থা = '.pick('tbl_taskstatus','task_statusname','task_statusid ='.$_REQUEST['task_statusid'].'').', ';
 	$cond .=" AND tbl_task.task_status='".$_REQUEST['task_statusid']."'";
 } 	

if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
	$txtfromopen_date=$_REQUEST['txtfromopen_date'];
	if($txtfromopen_date!=null){
		$pieces1 = explode(" ", $txtfromopen_date);
		$pieces = explode("/", $pieces1[0]);
		$prate_change_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
		$txtfromopen_date=$prate_change_date." ".$pieces1[1];
	}
	$txttoopen_date=$_REQUEST['txttoopen_date'];
	if($txttoopen_date!=null){
		$pieces1 = explode(" ", $txttoopen_date);
		$pieces = explode("/", $pieces1[0]);
		$prate_change_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
		$txttoopen_date=$prate_change_date." ".$pieces1[1];
	}
		
	$ehead .=" তারিখ ".bn2enNumber ($_REQUEST['txtfromopen_date'])." থেকে ".bn2enNumber ($_REQUEST['txttoopen_date']);
		$cond .=" AND (DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d %H:%i')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d %H:%i')<='".$txttoopen_date."')";
}
if(isset($_REQUEST['service_type']) && $_REQUEST['service_type'] !='-1'){
 	if($_REQUEST['service_type']==1){
 		$ehead .='<br> ক্যাটাগরি = অভিযোগ';	
 	}elseif($_REQUEST['service_type']==2){
 		$ehead .='<br> ক্যাটাগরি = আবেদন';	
 	}
 	elseif($_REQUEST['service_type']==3){
 		$ehead .='<br> ক্যাটাগরি = তথ্য';	
 	}else{
 		$ehead .='<br> ক্যাটাগরি = সকল';	
 	}
  	
 	}


  $SeNTlist1="SELECT 
			tbl_task.task_id,
			tbl_task.task_no,			
			tbl_task.subject,
			tbl_task.description,
			DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y') as open_date1,
			DATE_FORMAT(tbl_task.close_date,'%m/%d/%Y') as close_date,
			DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y %h:%i:%s %p') as down_time,
			DATE_FORMAT(tbl_task.close_date,'%m/%d/%Y %h:%i:%s %p') as close_date_time,
			tbl_taskstatus.task_statusname as task_status,
			_nisl_mas_member.User_Name as created_by,
			tbl_task.schedule_id,
			tbl_task.que_status,
			t1.User_Name as solv_by,
			tbl_task.solv_solution,
			tbl_task.contact_person,
			tbl_task.contact_number,
			tbl_task.entry_by,
			tbl_task.entry_date,			
			tbl_service_type.prob_name,
            tbl_division.name as div_name,
            tbl_district.name AS dis_name,
            tbl_upozila.name AS upo_name,
            tbl_service_tag.name as service_tag,
			`tbl_problem`.`prob_name` as prob,
			CASE
                WHEN `tbl_service_type`.`srv_type` =1 THEN 'অভিযোগ'
                WHEN `tbl_service_type`.`srv_type` =2 THEN 'আবেদন'
                WHEN `tbl_service_type`.`srv_type` =3 THEN 'তথ্য'
                ELSE ''
            END as cat
		FROM 
			tbl_task						
			
			LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type
			LEFT JOIN tbl_taskstatus ON  tbl_taskstatus.task_statusid = tbl_task.task_status
            left join tbl_division on tbl_division.id=tbl_task.division
			left join tbl_district on tbl_district.id=tbl_task.district and tbl_district.division_id =tbl_division.id
			left join tbl_upozila on tbl_upozila.id=tbl_task.upozila and
								  `tbl_upozila`.`division_id`=tbl_division.id
			LEFT JOIN _nisl_mas_member ON  _nisl_mas_member.User_ID = tbl_task.created_by
			LEFT JOIN _nisl_mas_member as t1 ON  t1.User_ID = tbl_task.solv_by
			LEFT JOIN tbl_service_tag  ON  tbl_service_tag.id = tbl_task.service_tag
			left join tbl_problem on tbl_problem.prob_id=tbl_task.prob_type
			where 1=1							
			$cond
			Order By tbl_division.id asc,tbl_district.id asc";
		//echo $SeNTlist1;

      $rSeNTlist1=mysql_query($SeNTlist1) or die();
      $numrows=mysql_num_rows($rSeNTlist1);
      if($numrows>0)
      {
       $i=0;
	   
	   // echo "<div id='dvContainer'>";
       drawCompanyInformationDiv("কলের তথ্য ",$ehead);
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '   >
	            <thead>
	            <tr>
	    			<th style=min-width:50px>বিভাগ</th>
					<th style=min-width:50px>জেলা</th>
					<th style=min-width:50px>উপজেলা</th>
					<th style=min-width:50px>কল করার তারিখ</th>
					<th style=min-width:50px>কলের তারিখ ও সময়</th>
					<th style=min-width:50px>কলের আইডি নম্বর</th>
					<th style=min-width:50px>কলকারীর নাম</th>
					<th style=min-width:50px>মোবাইল নম্বর</th>					
					<th style=min-width:50px>ক্যাটাগরি</th>
					<th style=min-width:50px>সার্ভিস টাইপ ট্যাগ</th>
					<th style=min-width:50px>সেবার ধরণ</th>
					<th style=min-width:50px>সমস্যার ধরন</th>
					<th style=min-width:50px>বিষয়</th>
					<th style=min-width:50px>কলের বিবরণ</th>
					<th style=min-width:50px>সর্বশেষ অবস্থা</th>
					<th style=min-width:50px>এজেন্ট নাম</th>
					<th style=min-width:50px>নিষ্পন্ন কারী</th>
					<th style=min-width:50px>নিষ্পন্নের তারিখ ও সময়</th>
				</tr>
            	</thead>
        		<tbody>
            ";
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
?>
                <tr >
                	<td align='left' >
						<?php echo $div_name; ?>
					</td>
					<td align='left' >
						<?php echo $dis_name; ?>
					</td>
					<td align='left' >
						<?php echo $upo_name; ?>
					</td>
					<td align='left' >
						<?php echo $open_date1; ?>
					</td>
					<td align='left' >
						<?php echo $down_time; ?>
					</td>
					<td align='left' >
						<?php echo $task_no.'_'; ?>
					</td>
					<td align='left' >
						<?php echo $contact_person; ?>
					</td>
					<td align='left'  >
						<?php echo $contact_number; ?>
					</td>
					<td align='left'  >
						<?php echo $cat; ?>
					</td>
					<td align='left'  >
						<?php echo $service_tag; ?>
					</td>
					<td align='left'  >
						<?php echo $prob_name; ?>
					</td>
					<td align='left'  >
						<?php echo $prob; ?>
					</td>
					
					<td align='left'  >
						<?php echo $subject; ?>
					</td>
					<td align='left'  >
						<?php echo $description; ?>
					</td>
					<td align='left'  >
						<?php echo $task_status; ?>
					</td>
					<td align='left'  >
						<?php 
						if($entry_by==0){
							echo 'নাগরিক কর্নার';
						}else{
							echo $created_by;	
						}
						
						 ?>
					</td>
					<td align='left' >
						<?php echo $solv_by; ?>
					</td>
					<td align='left' >
						<?php 
						if($close_date_time!="00/00/0000 12:00:00 AM"){
							echo $close_date_time;
						}
						 ?>
					</td>
					
				</tr>
             <?php    
            }
		
      }
	


?>
		</tbody>
	</table>
</div>
<script>
	pdfMake.fonts = {
	        Kalpurush: {
	                normal: 'Kalpurush-Regular.ttf',
	                bold: 'Kalpurush-Regular.ttf',
	                italics: 'aKalpurush-Regular.ttf',
	                bolditalics: 'Kalpurush-Regular.ttf'
	        },
	       

	};
	$(document).ready(function() {
    var printCounter = 0;
 
    // Append a caption to the table before the DataTables initialisation
    $('#result_tbl').append('');
 
    $('#result_tbl').DataTable( {
        dom: 'Bfrtip',
        bFilter: true,
        pageLength: 50,
	    bLengthChange: false,
        language: {
				"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Bangla.json"
			},
        buttons: [
            
            {
                extend: 'copy',
                className: 'btn btn-primary btn-xs'
            },
            {
                extend: 'excel',
                className: 'btn btn-success btn-xs',
                messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
                filename: 'অভিযোগ_প্রতিবেদন_<?php echo date('YmdHi');?>',
	          	title: 'অভিযোগ প্রতিবেদন '
            },
            {
            	extend: 'csv',
	           	charset: 'UTF-8',
	           	messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
	           	className: 'btn btn-default btn-xs',
	           	bom: true,
	           	filename: 'অভিযোগ_প্রতিবেদন_<?php echo date('YmdHi');?>',
	          	title: 'অভিযোগ প্রতিবেদন '
            },
            
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                className: 'btn btn-danger btn-xs',
                messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
                pageSize: 'LEGAL',
                bom: true,
                charset: "utf-8",
                filename: 'অভিযোগ_প্রতিবেদন_<?php echo date('YmdHi');?>',
	          	title: 'অভিযোগ প্রতিবেদন ',            
            	customize: function (doc) {        
            		doc.defaultStyle.font = 'Kalpurush';},
        	}, 
            {
                extend: 'print',
                className: 'btn btn-warning btn-xs',
                messageTop: function () {
                    printCounter++;
 
                    if ( printCounter === 1 ) {
                        return 'কলের তথ্য, <?php echo $ehead;?>';
                    }
                    else {
                        return 'You have printed this document '+printCounter+' times';
                    }
                },
                messageBottom: null
            }
        ]
    } );
} );
</script>

