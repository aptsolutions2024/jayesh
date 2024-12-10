<?php
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
 $client = $_SESSION['clintid'];
$row = $userObj->getEmployeeDetailsByClientIdAppont($client,$comp_id,$user_id);
?>
<select id="employee" name="employee" class="textclass">
<option>-- select --</option >
<?php while($res = mysql_fetch_array($row)){?>
	
	<option value="<?php echo $res['emp_id'];?>"><?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'];?></option >
	
	
<?php }
?>
</select>

<!--<input type="text" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
</div>-->