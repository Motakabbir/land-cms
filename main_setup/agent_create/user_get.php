<table class="table table-bordered table-condensed table-striped table-hover" id="example">
	<thead>
		<tr>
			<th># ক্রমিক নং</th>
			<th>নাম </th>
			<th>ইউজার নেম</th>
            <th>দল</th>
            <th>বিভাগ</th>
            <th>জেলা</th>
            <th>উপজেলা</th>
			<th>সম্পাদন করুন</th>
		</tr>
	</thead>
	<?php
	 session_start();
	$SUser_Id=$_SESSION['SUserID'];
	if($SUser_Id==1){
		$cond=' where show_status=1';
		}else{
			$cond=' Where _nisl_mas_member.Type in (16,17) and _nisl_mas_user.show_status=1';
			}
	include '../../Library/dbconnect.php';
	include '../../Library/Library.php';
	$res = mysql_query("SELECT
						 *,
						 tbl_user_type.type_name,
						 tbl_division.name as divname,
						tbl_district.name AS disname,
						tbl_upozila.name AS upozilaname
						FROM _nisl_mas_user
						LEFT JOIN _nisl_mas_member ON _nisl_mas_member.User_ID=_nisl_mas_user.User_ID
						LEFT JOIN tbl_user_type ON tbl_user_type.id=_nisl_mas_member.Type
						LEFT JOIN tbl_division ON tbl_division.id=_nisl_mas_user.division
						LEFT JOIN tbl_district ON tbl_district.id=_nisl_mas_user.district
						LEFT JOIN tbl_upozila ON tbl_upozila.id=_nisl_mas_user.upozela

						$cond
						");
	$i = 1;
	while ($row = mysql_fetch_array($res))
	{
		extract($row);
	?>
	<tr>
		<td><?php echo bn2enNumber ($i);?></td>
		<td><?php echo $Name;?></td>
		<td><?php echo $User_Name;?></td>
		<td><?php echo $type_name;?></td>
        <td><?php echo $divname;?></td>
        <td><?php echo $disname;?></td>
        <td><?php echo $upozilaname;?></td>
		<td>
			<button class="btn btn-primary btn-xs" onclick="btn2(<?php echo $User_ID;?>)" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> সম্পাদন করুন</button>
		</td>
	</tr>
	
	<?php
	$i++;
	}
	?>	
</table>

<script>
	$(document).ready(function() {
	    $('#example').DataTable({
	        "bFilter": true,
	        "bLengthChange": false,
	    });
	});
</script>
<script type="text/javascript">
	function btn2(User_ID) {
	    //alert(did);
	    var mode = '2';
	    $.ajax({
	        type: "POST",
	        url: "user_modal.php",
	        data: {
	            mode: mode,
	            User_ID : User_ID,
	        },
	        success: function (response)
            {   
                //alert ('edit');
                $( '.modal-content' ).html(response);
            }
	    });
	}
</script>