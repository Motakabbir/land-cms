<table class="table table-bordered table-condensed table-striped table-hover" id="tableData">
	<thead>
		<tr>
			<th>#</th>
			<th>জন্য</th>
            <th>বর্ণনা</th>
            <th>টাইপ ব্যবহার</th>
            <th>স্ট্যাটাস</th>
			<th>সম্পাদনা করুন</th>
		</tr>
	</thead>
	<?php
	include_once '../../Library/dbconnect.php';
	
	$res = mysqli_query($conn, "SELECT
									  `id`,
									  `command`,
									  `description`,
									  IF(status=1, 'ON', 'OFF') as status,
									  IF(type=1, 'System', 'User') as type
									FROM
									  `tbl_sms_template`");
	$i = 1;
	while ($row = mysqli_fetch_array($res))
	{
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo $row['command'];?></td>
        <td><?php echo $row['description'];?></td>
        <td><?php echo $row['type'];?></td>
        <td><?php echo $row['status'];?></td>
		<td>
			<button class="btn btn-primary btn-xs" onclick="btn2(<?php echo $row['id'];?>)" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
		</td>
	</tr>
	
	<?php
	$i++;
	}
	?>	
</table>

<script type="text/javascript">
	
	
	
	$(document).ready(function() {
	    $('#tableData').DataTable({
	        "bFilter": true,
	        "bLengthChange": false,
			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Bangla.json"
			},
			 "pageLength": 50,
			  "stateSave": true
	    });
	});



</script>
<script type="text/javascript">
	function btn2(id) {
	    //alert(tid);
	    var mode = '2';
	    $.ajax({
	        type: "POST",
	        url: "sms_template_modal.php",
	        data: {
	            mode: mode,
	            id : id,
	        },
	        success: function (response)
            {   
                //alert ('edit');
                $( '.modal-content' ).html(response);
            }
	    });
	}
</script>