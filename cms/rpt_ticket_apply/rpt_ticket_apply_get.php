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
$probtype= $_REQUEST['probtype'];
if( is_array($probtype)){
    $invalue="";
	while (list ($key, $val) = each ($probtype)) {
	   
		if($val=='-1'){
			$invalue='';
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
}

 $ehead='';	
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
	$cond .="and tbl_task.service_type IN ($invalue)";
	}
if(isset($_REQUEST['task_statusid']) && $_REQUEST['task_statusid'] !='-1'){
	$ehead .=' অবস্থা = '.pick('tbl_taskstatus','task_statusname','task_statusid ='.$_REQUEST['task_statusid'].'').', ';
 	$cond .=" AND tbl_task.task_status='".$_REQUEST['task_statusid']."'";
 } 	

 if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
	$ehead .=" তারিখ ".bn2enNumber ($_REQUEST['txtfromopen_date'])." থেকে ".bn2enNumber ($_REQUEST['txttoopen_date']);
 	$cond .=" AND (DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task.open_date,'%Y-%m-%d')<='".$txttoopen_date."')";
 }
$sql="SELECT
  `id`,
  `group_id`,
  `service_id`
FROM
  `tbl_group_service`
WHERE `group_id`  =".$SType."";
$res = mysql_query($sql);
$typearray=array();
while ($row = mysql_fetch_array($res))
	{
		array_push($typearray,$row['service_id']);
	}

//print_r($typearray);

if($SType==1){
	
}elseif($SType>=2 && $SType<=6){
	
	if(!empty($typearray)){
	$cond .=" AND `service_type` in (".implode(',',$typearray).")";
	}
}elseif($SType==7 || $SType==8){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and division='$Sdivision'";
}elseif($SType==9 || $SType==10){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and district='$Sdistrict'";
	
}elseif($SType==11 || $SType==12){
	
	if(!empty($typearray)){
		$cond .=" AND `service_type` in (".implode(',',$typearray).") ";
	}
		$cond .=" and  upozila='$Supozela'";
	
}	



				$SeNTlist1="SELECT
							tbl_task.task_id,
							tbl_task.task_no,
							tbl_problem.prob_name as prob_type,
							tbl_task.subject,
							tbl_task.description,
							DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y') as open_date1,
							DATE_FORMAT(tbl_task.close_date,'%m/%d/%Y') as close_date,
							DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y %h:%i:%s %p') as down_time,
							DATE_FORMAT(tbl_task.close_date,'%b %d %Y %h:%i') as close_date_time,
							tbl_taskstatus.task_statusname as task_status,
							mas_department.department as task_department,
							tbl_taskpriority.task_priorityname as task_priority,
							_nisl_mas_member.User_Name as created_by,
							tbl_task.schedule_id,
							tbl_task.que_status,
							t1.User_Name as solv_by,
							tbl_task.solv_solution,
							tbl_task.contact_person,
							tbl_task.contact_number,
							tbl_task.entry_by,
							tbl_task.entry_date,
							tbl_task.update_by,
							tbl_task.update_date,
							tbl_service_type.prob_name,
                            tbl_division.name as div_name,
                            tbl_district.name AS dis_name,
                            tbl_upozila.name AS upo_name,
                            tbl_task.nid
						FROM 
							tbl_task						
							LEFT JOIN tbl_problem ON  tbl_problem.prob_id = tbl_task.prob_type
							LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type
							LEFT JOIN tbl_taskstatus ON  tbl_taskstatus.task_statusid = tbl_task.task_status
							LEFT JOIN mas_department ON  mas_department.depart_id = tbl_task.task_department
							LEFT JOIN tbl_taskpriority ON  tbl_taskpriority.task_priorityid = tbl_task.task_priority
                            LEFT JOIN tbl_division ON tbl_division.id=tbl_task.division
                            LEFT JOIN tbl_district ON tbl_district.id=tbl_task.district
                            LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_task.upozila
							LEFT JOIN _nisl_mas_member ON  _nisl_mas_member.User_ID = tbl_task.created_by
							LEFT JOIN _nisl_mas_member as t1 ON  t1.User_ID = tbl_task.solv_by
							where 1=1
							AND tbl_service_type.`srv_type` in (2)
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
	            	<td style=min-width:50px>বিভাগ</td>
					<td style=min-width:50px>জেলা</td>
					<td style=min-width:50px>উপজেলা</td>
					<td style=min-width:50px>আবেদনের তারিখ ও সময়</td>
					<td style=min-width:50px>আবেদনকারীর নাম</td>
					<td style=min-width:50px>জাতীয় পরিচয়পত্র</td>
					<td style=min-width:50px>মোবাইল নম্বর</td>
					<td style=min-width:50px>আবেদনের নাম</td>
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
						<?php echo bn2enNumber ($div_name); ?>
					</td>
					<td align='left' >
						<?php echo bn2enNumber ($dis_name); ?>
					</td>
					<td align='left' >
						<?php echo bn2enNumber ($upo_name); ?>
					</td>
					
					<td align='left' >
						<?php echo bn2enNumber ($down_time); ?>
					</td>
					
					<td align='left' >
						<?php echo $contact_person; ?>
					</td>
					<td> <?php echo $nid; ?></td>
					<td align='left'  >
						<?php echo bn2enNumber ($contact_number); ?>
					</td>
					<td align='left'  >
						<?php echo $prob_name; ?>
					</td>
					
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
        bFilter: false,
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
                	filename: 'আবেদন প্রতিবেদন ',
	          	title: 'আবেদন প্রতিবেদন '
            },
            {
            	extend: 'csv',
	           	charset: 'UTF-8',
	           	messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
	           	className: 'btn btn-default btn-xs',
	           	bom: true,
	           	filename: 'আবেদন প্রতিবেদন ',
	          	title: 'আবেদন প্রতিবেদন '
            },
            
            {
                extend: 'pdfHtml5',
                //orientation: 'landscape',
                className: 'btn btn-danger btn-xs',
                messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
                //pageSize: 'LEGAL',
                bom: true,
                charset: "utf-8",
                filename: 'আবেদন প্রতিবেদন ',
	          	title: 'আবেদন প্রতিবেদন ',           
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