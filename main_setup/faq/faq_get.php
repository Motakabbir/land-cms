<table class="table table-bordered table-condensed table-striped table-hover" id="tableData">
	<thead>
		<tr>
			<th>#ক্রমিক</th>
			<th>প্রশ্ন</th>
			<th>উত্তর</th>
			<th>অবস্থা</th>
			<th>সম্পাদন করা</th>
		</tr>
	</thead>
	<?php
	include_once '../../Library/dbconnect.php';
	
	$res = mysql_query("SELECT `id`, `faq_question`, `faq_answer`, `active_status`, tbl_status.stat_desc FROM `tbl_faq` left join tbl_status ON tbl_faq.active_status=tbl_status.stat_id");
	$i = 1;
	while ($row = mysql_fetch_array($res))
	{
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo $row['faq_question'];?></td>
		<td><?php echo $row['faq_answer'];?></td>
		<td><?php echo $row['stat_desc'];?></td>
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
	var t = $('#tableData').DataTable({
	        "bFilter": true,
	        "bLengthChange": true,
			 "orderable": false,
			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Bangla.json"
			},
			 "pageLength": 50,
			  "stateSave": true,
	    });
		
	});


	function btn2(id) {
	    //alert(tid);
	    var mode = '2';
	    $.ajax({
	        type: "POST",
	        url: "faq_modal.php",
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