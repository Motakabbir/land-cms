
<?php 
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';

session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SDesignation = $_SESSION['SDesignation'];

$cond=' ';
if(isset ($_REQUEST['scheduled_to']) != NULL && $_REQUEST['scheduled_to'] >= 1){
	$scheduled_to=$_REQUEST['scheduled_to'];
	
		$cond.=" And tbl_task_log.update_by = '".$scheduled_to."'";
	}

 if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$cond.=" AND (DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_task_log.update_date,'%Y-%m-%d')<='".$txttoopen_date."')";
 				
 }

 /*if ($cond!=NULL) {
 	$cond.=" AND tbl_task.scheduled_to = $SUserID";
 }
 else {
 	$cond = "WHERE tbl_task.scheduled_to = $SUserID";
 }*/
	
	$SeNTlist1="SELECT
				
				tbl_task_log.prob_type_old,
				tbl_task_log.service_type_old,
				tbl_task_log.service_tag_old,
				tbl_task_log.service_tag_new,
				tbl_task_log.subject_old,
				tbl_task_log.subject_new,
				tbl_task_log.description_old,
				tbl_task_log.description_new,
				tbl_task_log.address_old,
				tbl_task_log.address_new,
				tbl_task_log.task_status_old,
				tbl_task_log.task_status_new,
				tbl_task_log.update_by,
				tbl_task_log.update_date as update_date,
				tbl_task.task_id as task_id,
				tbl_task.task_no as task_no,
				tbl_task.contact_person as contact_person,
				tbl_task.down_time as down_time,
				tbl_service_tag.name as tag_name,
				tbl_problem.prob_name as prob_name ,
				tbl_division.name as division,
				tbl_district.name as district,
				tbl_upozila.name as upozila,
				t2.User_Name as entry_by,
				t1.User_Name as gmt_by_name,
				t3.User_Name as solve_by_name,
				tbl_service_type.prob_name as service_name,
				tbl_task.description as description,
				tbl_task.contact_number as contact_number,
				tbl_task.close_date,
				tbl_taskstatus.task_statusname as task_status,
				tbl_user_type.type_name as end_user_office
				
					FROM 
							tbl_task_log
							LEFT JOIN tbl_task ON  tbl_task.task_id = tbl_task_log.task_no
							LEFT JOIN _nisl_mas_member ON _nisl_mas_member.User_ID = tbl_task_log.update_by
							LEFT JOIN tbl_service_type ON  tbl_service_type.prob_id = tbl_task.service_type
							LEFT JOIN tbl_taskstatus ON  tbl_taskstatus.task_statusid = tbl_task.task_status
							LEFT JOIN _nisl_mas_member as t1 ON  t1.User_ID = tbl_task_log.update_by
							LEFT JOIN _nisl_mas_member as t2 ON  t2.User_ID = tbl_task.entry_by
							LEFT JOIN tbl_division ON tbl_division.id=tbl_task.division
                            LEFT JOIN tbl_district ON tbl_district.id=tbl_task.district
                            LEFT JOIN tbl_upozila ON tbl_upozila.id=tbl_task.upozila
							LEFT JOIN _nisl_mas_member as t3 ON  t3.User_ID = tbl_task.solv_by
							LEFT JOIN tbl_problem ON  tbl_problem.prob_id = tbl_task.prob_type
							LEFT JOIN tbl_service_tag ON  tbl_service_tag.id = tbl_task.service_tag
							LEFT JOIN tbl_user_type ON  tbl_user_type.id = tbl_service_type.end_user
							
							
								where 1=1 and _nisl_mas_member.Type='36' 
							$cond ";
							
							/*
							
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
							*/
					
					
	
	
	/*
				$SeNTlist1="SELECT
							tbl_task.task_id,
							tbl_task.task_no,
							tbl_problem.prob_name as prob_type,
							tbl_task.subject,
							tbl_task.description,
							DATE_FORMAT(tbl_task.open_date,'%d/%m/%Y') as open_date1,
							DATE_FORMAT(tbl_task.close_date,'%d/%m/%Y') as close_date,
							DATE_FORMAT(tbl_task.open_date,'%d/%m/%Y %h:%i') as down_time,
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
                            tbl_upozila.name AS upo_name
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
							where 1=1 and `_nisl_mas_member`.`Type`=16 
							$cond
							Order By tbl_division.id asc,tbl_district.id asc";
							
			*/
	//	echo $SeNTlist1;
		
		
		
      $rSeNTlist1=mysql_query($SeNTlist1) or die();
      $numrows=mysql_num_rows($rSeNTlist1);
      if($numrows>0)
      {

	   
	   echo "<div id='dvContainer'>";
       drawCompanyInformationDiv("জিএমটি  প্রতিবেদন ",$ehead);
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '   >
            <tr>
						<th align='center'   > কলের আইডি নম্বর</th>
						<th align='center'   > কলের তারিখ </th>
						<th align='center'   > নাম</th>
						<th align='center'   > মোবাইল নম্বর</th>
						<th align='center'   > বিভাগ</th>
						<th align='center'   > জেলা</th>
						<th align='center'   > উপজেলা</th>
						<th align='center'   > সেবার ধরণ</th>
						<th align='center'   > সার্ভিস টাইপ ট্যাগ</th>
						<th align='center'   > সমস্যার ধরন</th>
						<th align='center'   > বিবরণ</th>
						<th align='center'   > জমাদানকারী </th>
						<th align='center'   > জিএমটি আপডেট</th>
						<th align='center'   > জিএমটি জমাদানকারী</th>
						
						<th align='center'   > অফিস</th>
		
						<th align='center'   > বর্তমান অবস্থা</th>
						<th align='center'   > অফিস আপডেট</th>
						<th align='center'   > নিষ্পন্ন কারীা</th>
						
            </tr>
            ";
            while($rows=mysql_fetch_array($rSeNTlist1))
            {
            extract($rows);
			
			       $i=0;
//	   $task_history_id="";
//	   $office_update_dat="";
//	   $office_update_by="";
//	   $office_update_name="";
	   
//	   $task_history_id=pick("tbl_task_history","task_history_id","task_id=".$task_id." and short_dsc='গৃহীত কার্যক্রম' order by update_date desc limit 1");
//	   $office_update_date=pick("tbl_task_history","update_date","task_history_id='".$task_history_id."'");
//	   $office_update_by=pick("tbl_task_history LEFT JOIN _nisl_mas_member ON  _nisl_mas_member.User_ID = tbl_task_history.update_by","_nisl_mas_member.User_Name","task_history_id='".$task_history_id."'");
//	   $office_update_name=pick("tbl_task_history LEFT JOIN _nisl_mas_user ON  _nisl_mas_user.User_ID = tbl_task_history.update_by","_nisl_mas_user.Address","task_history_id='".$task_history_id."'");
           
                ?>
                      <TR >
						<td align='left' >
							<?php echo bn2enNumber ($task_no); ?>
						</td>
						<td align='left'  >
							<?php echo bn2enNumber ($down_time); ?>
						</td>
						<td align='left' >
							<?php echo $contact_person; ?>
						</td>
							<td align='left'  >
							<?php echo bn2enNumber ($contact_number); ?>
						</td>
							<td align='left'  >
							<?php echo bn2enNumber ($division); ?>
						</td>
							<td align='left'  >
							<?php echo bn2enNumber ($district); ?>
						</td>
							<td align='left'  >
							<?php echo bn2enNumber ($upozila); ?>
						</td>
						<td align='left'  >
							<?php echo $service_name; ?>
						</td>
						<td align='left'  >
							<?php echo $tag_name; ?>
						</td>
						<td align='left'  >
							<?php echo $prob_name; ?>
						</td>
						<td align='left'  >
							<?php echo $description; ?>
						</td>

							<td align='left'  >
							<?php echo bn2enNumber ($entry_by); ?>
						</td>
						
						<td align='left'  >
							<?php echo bn2enNumber ($update_date); ?>
						</td>

						<td align='left'  >
						<?php echo bn2enNumber ($gmt_by_name); ?>
						</td>
						
		
						<td align='left'  >
						<?php echo $end_user_office; ?>
						</td>
		
						<td align='left' >
							<?php echo $task_status; ?>
						</td>
						<td align='left'  >
							<?php echo bn2enNumber ($close_date); ?>
						</td>
							<td align='left' >
							<?php echo $solve_by_name; ?>
						</td>
						</TR>
                   <?php
				
					  $i++;
            }
			
			if(isset ($_REQUEST['scheduled_to']) != NULL && $_REQUEST['scheduled_to'] >= 1){
				?>
				<tr>
                	<td colspan="6">Total</td>
                	<td> <?php echo $numrows;?></td>
                </tr>
				<?php 
				}
			
			echo"</table> </div>";
      }
	  else{
	  echo "<center><b> তথ্য পাওয়া যায়নি.....</b>";
	  }
?>
<span style="color:red"></span>