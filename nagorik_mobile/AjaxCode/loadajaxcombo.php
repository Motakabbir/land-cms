<?php
require_once "../library/dbconnect.php";
if($_REQUEST)
{
	$category_id='';
	$subcategory_id='';
	$department_id 	= '';
	if(isset($_REQUEST['dpt_id']))
		$department_id 	= $_REQUEST['dpt_id'];
	if(isset($_REQUEST['cat_id']))
		$category_id = $_REQUEST['cat_id'];
	if(isset($_REQUEST['subcat_id']))
		$subcategory_id = $_REQUEST['subcat_id'];
	if($_REQUEST['options'])
	{echo "SELECT ".$_REQUEST['valueColumns']." FROM ".$_REQUEST['table']. " ". (empty($_REQUEST['conditions'])? " ": $_REQUEST['conditions']);
		 $queryString=stripslashes("SELECT ".$_REQUEST['valueColumns']." FROM ".$_REQUEST['table']. " ". (empty($_REQUEST['conditions'])? " ": $_REQUEST['conditions']));
		//exit;
		$rsCombo=mysqli_query($conn, $queryString);
		echo '<option value="-1">'.addslashes($_REQUEST['firstText']).'</option>';
		if(mysqli_num_rows($rsCombo)>0)
		{
			while($rowCombo=mysqli_fetch_array($rsCombo))
			{
				echo '<option value="'.$rowCombo[0].'" '.(($_REQUEST['selectedValue']==$rowCombo[0])?'selected':'').'  >'.addslashes($rowCombo[1]).'</option>';
			}
		}
	}
	else if(isset($_REQUEST['common']))
	{
		$query="select ".$_REQUEST['valuecolumn']." as id,".$_REQUEST['descriptioncolumn']." as description from ".$_REQUEST['tablename']." where ".$_REQUEST['condition']."";
		$results = mysqli_query($conn,  $query);
		?>
		<select name="<?php echo $_REQUEST['comboname']; ?>"  id="<?php echo $_REQUEST['comboname']; ?>" onchange="<?php echo $_REQUEST['functionname']; ?>; return false;">
		<option value="" >Select Category</option>
		<?php
		while ($rows = mysqli_fetch_assoc(@$results))
		{
		?>
			<option value="<?php echo $rows['id'];?>"><?php echo $rows['description'];?></option>
		<?php
		}
		?>
		</select>	
		<?php
	}
	else
	{
		if(!empty($department_id) && empty($category_id) && empty($subcategory_id))
		{
		$query = "SELECT DISTINCT class.class_id as id, class.class_name as description FROM `class` LEFT JOIN `combos` ON combos.class_id = class.class_id WHERE combos.department_id ='".$department_id."' order by class_name";
		$results = mysqli_query($conn,  $query);
	?>
	 
		<select name="iCategory"  id="iCategory" onchange="loadSubCategory(); return false;">
		<option value="" >Select Category</option>
		<?php
		while ($rows = mysqli_fetch_assoc(@$results))
		{
		?>
			<option value="<?php echo $rows['id'];?>"><?php echo $rows['description'];?></option>
		<?php
		}
		?>
		</select>	
	 
	<?php	
		}
		else if(!empty($department_id) && !empty($category_id) && empty($subcategory_id))
		{
			$query = "SELECT DISTINCT subclass.subclass_id as id, subclass.subclass_name as description FROM `subclass` LEFT JOIN `combos` ON combos.subclass_id = subclass.subclass_id WHERE combos.department_id='".$department_id."' AND combos.class_id ='".$category_id."' order by subclass_name";
			$results = mysqli_query($conn,  $query);
		
	?>
	<select name="iSubCategory"  id="iSubCategory" onchange="loadStage(); return false;">
	<option value="" >Select Sub-Category</option>
		<?php
		while ($rows = mysqli_fetch_assoc(@$results))
		{
		?>
			<option value="<?php echo $rows['id'];?>"><?php echo $rows['description'];?></option>
		<?php
		}
		?>
		</select>	
		<?php
		}
		else if(!empty($department_id) && !empty($category_id) && !empty($subcategory_id))
		{
			$query = "SELECT DISTINCT stage.stage_id as id, stage.stage_name as description FROM stage LEFT JOIN `combos` ON combos.stage_id = stage.stage_id WHERE combos.department_id='".$department_id."' AND combos.class_id ='".$category_id."' AND combos.subclass_id='".$subcategory_id."' order by stage_name ";
			$results = mysqli_query($conn, $query);
		
	?>
		<select name="iStage"  id="iStage">
		<option value="" >Select Stage</option>
		<?php
		while ($rows = mysqli_fetch_assoc(@$results))
		{
		?>
			<option value="<?php echo $rows['id'];?>"><?php echo $rows['description'];?></option>
		<?php
		}
		?>
		</select>	
<?php
		}
	}
}

?>