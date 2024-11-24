<table class="table table-bordered table-condensed table-striped table-hover" id="example">
	<thead>
		<tr>
			<th># ক্রমিক নং</th>
			<th>সার্ভিস টাইপ ট্যাগ</th>
			<th>ক্যাটাগরি</th>
			<th>সম্পাদন করুন</th>
		</tr>
	</thead>
	<?php
	include '../../Library/dbconnect.php';
	include '../../Library/Library.php';
	$res = mysql_query("SELECT
						  `id`,`name`,
						  CASE
						      WHEN service_type = 1 THEN 'অভিযোগ'
						      WHEN service_type = 2 THEN 'আবেদন'
						      WHEN service_type = 3 THEN 'তথ্য'
						      ELSE 'অন্যান্য'
						  END AS service_type
						FROM
						  `tbl_service_tag`
						  ");
	$i = 1;
	while ($row = mysql_fetch_array($res))
	{
	?>
	<tr>
		<td><?php echo $i ;?></td>
		<td><?php echo $row['name'];?></td>
		<td>
			<?php echo $row['service_type'];?>
		</td>
		<td>
			<button class="btn btn-primary btn-xs" onclick="btn2(<?php echo $row['id'];?>)" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> সম্পাদন করুন</button>
		</td>
	</tr>
	
	<?php
	$i++;
	}
	?>	
</table>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable({
	        "bFilter": true,
	        "bLengthChange": false,
			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Bangla.json"
			},
			 "pageLength": 10,
			  "stateSave": true
	    });
	});

</script>
<script type="text/javascript">
	function btn2(prob_id) {
	    //alert(tid);
	    var mode = '2';
	    $.ajax({
	        type: "POST",
	        url: "servicetypetag_modal.php",
	        data: {
	            mode: mode,
	            prob_id : prob_id,
	        },
	        success: function (response)
            {   
                //alert ('edit');
                $( '.modal-content' ).html(response);
            }
	    });
	}
</script>