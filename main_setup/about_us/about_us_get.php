<table class="table table-bordered table-condensed table-striped table-hover" id="tableData">
	<thead>
		<tr>
			<th>#ক্রমিক</th>
			<th>সংক্ষিপ্ত বিবরণ</th>
			<th>বিবরণ</th>
			<th>চিত্র</th>
			<th>সম্পাদন করা</th>
		</tr>
	</thead>
	<?php
	include_once '../../Library/dbconnect.php';
	
	$res = mysqli_query($conn,"SELECT * FROM tbl_about_us");
	$i = 1;
	while ($row = mysqli_fetch_array($res))
	{
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo $row['short_description'];?></td>
		<td><?php echo substr($row['au_description'], 0, 200);?></td>
		<td><?php if($row['au_image']!=''){ ?><img width="100px" src="../../upload/<?php echo $row['au_image'];?>" alt="about Us"><?php }?></td>
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
	        url: "about_us_modal.php",
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