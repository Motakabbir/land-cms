<?php
        include_once("../Library/dbconnect.php");
?>

<?php
        if($_POST['FunctionName']=="retriveserverinfo")
            call_user_func("retriveserverinfo",$_POST['ServerID'],$_POST['ResellerID']);
       
?>
<?php
        function retriveserverinfo($Server,$Reseller)
        {
                //echo "selected Valu->$selectedValue";

                $query="SELECT 
							servers.server_id, 
							alias, 
							user_name, 
							reseller_id,
							reseller_objectid
						FROM 
							servers
							LEFT JOIN reseller ON servers.server_id = reseller.server_id
						WHERE
							servers.server_id='".$Server."'
							and reseller.reseller_type='".$Reseller."'
						";


                //echo $query;


                $ResultSet= mysqli_query($conn, $query) or die("Invalid query: " . mysqli_error());
				if(mysqli_num_rows($ResultSet)>0)
				{
					$str="<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
							<tr>
								<td class='top_left_curb'></td>
								<td colspan='3' class='header_cell_e' align='center'>Select Server</td>
								<td class='top_right_curb'></td>
							</tr>
							<tr>
								<td class='lb'></td>
								<td class='title_cell_e' align='center'>Server Name</td>
								<td class='title_cell_e' align='center'>User Name</td>
								<td class='title_cell_e' align='center'>Accept</td>
								<td class='rb'></td>
							</tr>
						";
					$i=0;
					while ($qry_row=mysqli_fetch_array($ResultSet))
					{
                        $Server_ID=$qry_row["server_id"];
                        $Server_Name=$qry_row["alias"];
						$User_Name=$qry_row["user_name"];
						$Reseller_ID=$qry_row["reseller_id"];
						
						if($i%2==0)
							$class='even_td_e';
						else
							$class='odd_td_e';
						
						$str.="	<tr>
									<td class='lb'></td>
									<td class='".$class."' align='center'><input type='text' value='".$Server_Name."' name='svname[".$i."]' class='input_e' readonly>
										
									<td class='".$class."' align='center'><input type='text' value='".$User_Name."' name='usrname[".$i."]' class='input_e' readonly>
										<input type='hidden' value='".$Reseller_ID."' name='txtresellerid[".$i."]'>
									</td>
									<td class='".$class."' align='center'>
										<input type='checkbox' name='accept[".$i."]'>
									</td>
									<td class='rb'></td>
								<tr>";
						$i++;
					}
					$str.="<tr>
							<td class='lb'></td>
							<td class='button_cell_e' colspan='3' align='center'>
								<input type='hidden' value='".$i."' name='temptotalrow'>
								<input type='Button' value='Add' name='btnadd' class='forms_button_e' onclick='addtogrid()'>
							</td>
							<td class='rb'></td>
							</tr>
							<tr>
							<td class='bottom_l_curb'></td>
							<td class='bottom_f_cell' colspan='3'></td>
							<td class='bottom_r_curb'></td>
							</tr>
						</table>";
					
				}
					echo $str;

        }

        
?>
<?php
        mysqli_close();
?>
