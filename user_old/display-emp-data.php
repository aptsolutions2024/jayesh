<?php
session_start();
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");

$userObj=new user();

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$cid = $_POST['cid'];
$fielda = $_POST['fielda'];
$fieldb = $_POST['fieldb'];
$fieldc = $_POST['fieldc'];
$fieldd = $_POST['fieldd'];

?>
<div class="twelve" id="margin1" >
	<div class="one columns bgColor1 Color3 test-upper"><b>Sr. No</b></div>
	<div class="three columns bgColor1 Color3 test-upper"><b>Emp Name</b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fielda;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldb;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldc;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldd;?></b></div>
</div>

<div style="min-height:235px;max-height:235px;  border: 1px solid gray; padding-bottom: 20px; overflow-y: scroll;">

<input type="hidden" name="fielda" value="<?php if($fielda!=''){echo $fielda;}?>">
<input type="hidden" name="fieldb" value="<?php if($fielda!=''){echo $fieldb;}?>">
<input type="hidden" name="fieldc" value="<?php if($fielda!=''){echo $fieldc;}?>">
<input type="hidden" name="fieldd" value="<?php if($fielda!=''){echo $fieldd;}?>">
<?php
$res = $userObj->displayDataByChice($fielda,$fieldb,$fieldc,$fieldd,$cid,$comp_id,$user_id);
  /* $sql = "SELECT $fielda,$fieldb,$fieldc,$fieldd,emp_id,first_name as fn,middle_name as mn,last_name as ln FROM `employee` where client_id='".$cid."' AND job_status!='L' order by emp_id"; 
  $res = mysql_query($sql);*/
$i=1;
while($row = $res->fetch_array()){
?>
<input type="hidden" name="empid[]" value="<?php echo $row['emp_id'];?>">

    <div class="twelve bgColor2">
        <div class="one columns "><span><?php echo $i;?></span></div>
        <div class="three columns"><span> <?php echo $row['ln']." ".$row['fn']." ".$row['mn'];?></span></div>
        <div class="two columns"><input class="textclass" type="text" name="texta[]" id="text1<?php echo $row['emp_id'];?>" value="<?php if($row[0]!=''){ echo $row[0]; } ?>" /></div>
        <div class="two columns"><input class="textclass" type="text" name="textb[]" id="text2<?php echo $row['emp_id'];?>" value="<?php if($row[1]!=''){ echo $row[1]; } ?>" /></div>
        <div class="two columns"><input class="textclass" type="text" name="textc[]" id="text3<?php echo $row['emp_id'];?>" value="<?php if($row[2]!=''){ echo $row[2]; } ?>" /></div>
		<div class="two columns"><input class="textclass" type="text" name="textd[]" id="text4<?php echo $row['emp_id'];?>" value="<?php if($row[3]!=''){ echo $row[3]; } ?>" />	</div>
        <div class="clearFix"></div>
	</div>

	<div class="clearfix"></div>
	
<?php

    $i++; }
if(mysqli_num_rows($res)==0) {?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if(mysqli_num_rows($res)!=0) {?>
    <div class="twelve " style="background-color: #fff;">
        <br/>
      &nbsp; &nbsp; <input type="submit" value="Update" name="submit"  class="btnclass"  >
    </div>

<?php } ?>
</div>