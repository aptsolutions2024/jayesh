<?php
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$advdate = $userObj->getadvdates( $_POST['emp_id'] );
?>
 <select name="advdate" class="textclass" id="advdate" >
		   <option value="">-- Select Date --</option>
		   <?php while($advdate1 = $advdate->fetch_assoc()){?>
		   <option value="<?php echo $advdate1['date'];?>"><?php echo date('d-m-Y',strtotime($advdate1['date']));?></option>
		   <?php }?>
		   </select>
	
