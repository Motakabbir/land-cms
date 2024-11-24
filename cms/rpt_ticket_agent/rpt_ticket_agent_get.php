<div class="clr"></div>
<div class="">


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
if(isset ($_REQUEST['scheduled_to']) != NULL && $_REQUEST['scheduled_to'] >= 1){
	$scheduled_to=$_REQUEST['scheduled_to'];
	
		$cond.=" And tbl_task.created_by = '".$scheduled_to."'";
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
							COUNT(`task_id`) as total_ticket,
						  	SUM(IF(`task_status`=1,1,0)) AS close_task,
						  	SUM(IF(`task_status`=2,1,0)) AS open_task,
						 	SUM(IF(`task_status`=3,1,0)) AS new_task,
							DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y') as open_date1,
							tbl_service_type.prob_name,
                            tbl_division.name as div_name,
                            tbl_district.name AS dis_name,
                            tbl_upozila.name AS upo_name,
                            tbl_task.nid,
                            _nisl_mas_member.User_Name as created_by,
                            tbl_service_tag.name as service_tag,
                            CASE
				                WHEN `tbl_service_type`.`srv_type` =1 THEN 'অভিযোগ'
				                WHEN `tbl_service_type`.`srv_type` =2 THEN 'আবেদন'
				                WHEN `tbl_service_type`.`srv_type` =3 THEN 'তথ্য'
				                ELSE ''
				            END as cat
						FROM 
							tbl_task						
							LEFT JOIN tbl_problem ON  tbl_problem.prob_id = tbl_task.prob_type
							LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type							
                            LEFT JOIN tbl_division ON tbl_division.id=tbl_task.division
                            LEFT JOIN tbl_district ON tbl_district.id=tbl_task.district
                            LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_task.upozila
                            LEFT JOIN _nisl_mas_member ON  _nisl_mas_member.User_ID = tbl_task.created_by
                            LEFT JOIN tbl_service_tag  ON  tbl_service_tag.id = tbl_task.service_tag
							where 1=1							
							$cond
							group by DATE_FORMAT(tbl_task.open_date,'%m/%d/%Y'),tbl_task.created_by,tbl_service_type.prob_id
							Order By tbl_task.created_by asc";
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
	            	<th>নিষ্পন্নের তারিখ</th>
					<th>এজেন্টের নাম</th>
					<th>এজেন্টের আইডি</th>
					<th >ক্যাটাগরি</th>
					<th style=min-width:50px>সার্ভিস টাইপ ট্যাগ</th>
					<th>সেবার ধরণ</td>
					<th style=min-width:50px>নতুন সংখ্যা </th>
					<th style=min-width:50px>চলমান সংখ্যা</th>
					<th style=min-width:50px>নিষ্পন্ন সংখ্যা</th>
					<th style=min-width:50px>অনিষ্পন্ন সংখ্যা</th>
					<th >সমগ্র</th>
				</tr>
            	</thead>
        		<tbody>
            ";
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
		           if($created_by==null){
		           		$created_by='নাগরিক কর্নার';
		           }
            	
			?>				
				
                <tr >
                	<td align='left' >
						<?php echo $open_date1; ?>
					</td>
					<td align='left'  >
						<?php echo $created_by;?>
					</td>
					<td align='left'  >
						<?php echo $created_by;?>
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
						<?php echo $new_task; ?>
					</td>
					<td align='left'  >
						<?php echo $open_task; ?>
					</td>
					<td align='left'  >
						<?php echo $close_task; ?>
					</td>
					<td align='left'  >
						<?php echo $new_task+$open_task; ?>
					</td>
					<td align='right'>
						<?php echo $total_ticket; ?>
					</td>
					</td>
				</tr>
             <?php  
             $ncreated_by=$created_by;
            
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
    	pageLength: 50,
        dom: 'Bfrtip',
        bFilter: true,
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
                filename: 'এজেন্ট সারসংক্ষেপ',
	          	title: 'এজেন্ট সারসংক্ষেপ'
            },
            {
            	extend: 'csv',
	           	charset: 'UTF-8',
	           	messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
	           	className: 'btn btn-default btn-xs',
	           	bom: true,
	           	filename: 'এজেন্ট সারসংক্ষেপ',
	          	title: 'এজেন্ট সারসংক্ষেপ'
            },            
            {
                extend: 'pdfHtml5',
                //orientation: 'landscape',
                className: 'btn btn-danger btn-xs',
                messageTop: 'কলের তথ্য, <?php echo $ehead;?>',
                //pageSize: 'LEGAL',
                bom: true,
                charset: "utf-8",
                filename: 'এজেন্ট সারসংক্ষেপ',
	          	title: 'এজেন্ট সারসংক্ষেপ',           
            	customize: function (doc) {        
            		doc.defaultStyle.font = 'Kalpurush';
            		
            	},
        		 
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