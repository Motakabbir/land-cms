<?php 
header("Access-Control-Allow-Origin: *");
?>
	<form action="" method="get">
		<div class="form-group">
			<label for="name">http://localhost/mcnbd/api/emp/read/(empid)</label>
			<input type="text" name="url" value="http://localhost/mcnbd/api/emp/read/" class="form-control" required/>
			
		</div>
		<button type="submit" name="submit" class="btn btn-default">Make API Request</button>
	</form>
	<p>&nbsp;</p>
	<?php
	if(isset($_POST['submit']))	{
		$url = $_POST['url'];				
		$client = curl_init($url);
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($client);		
		$result = json_decode($response);	
		print_r($result);		
	}
	?>	
</div>
