<?php
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
 $client = $_SESSION['clintid'];
$row = $userObj->getEmployeeDetailsByClientId($client);
?>
<select id="employee" name="employee" class="textclass">
<option>-- select --</option >
<?php while($res = mysql_fetch_array($row)){?>	
	<option value="<?php echo $res['emp_id'];?>"><?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'];?></option >	
<?php }
?>
</select>