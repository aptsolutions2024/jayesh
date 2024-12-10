<?php
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
$incomeid = $_POST['incomeid'];
$clientid = $_POST['clientid'];
include("../lib/class/common.php");
$common = new common;
$caltype = $common->incomeCalculationType();
//print_r($caltype);
?>
<div class="twelve" id="margin1">
	<div class="one columns bgColor1 Color3"><b>Sr. No</b></div>
    <div class="three columns bgColor1 Color3"><b>Employee Name</b></div>
    <div class="two columns bgColor1 Color3"><b>STD Amount</b></div>
	<div class="three columns bgColor1 Color3"><b>Calculation Type</b></div>
	<div class="three columns bgColor1 Color3"><b>Remark</b></div>

</div>



<?php
 $res = $common->selectEmpIncomeData($incomeid,$clientid);
 //echo mysqli_num_rows($res);
//print_r($res);

$i=1;
while($row = $res->fetch()){
?>
<input type="hidden" name="emp_ic_id[]" value="<?php echo $row['emp_income_id'];?>">

	<div class="twelve bgColor2">
        <div class="one columns"  class="centered"><?php echo $i;?></div>
        <div class="three columns"> <?php echo $row['ln']." ".$row['fn']." ".$row['mn'];?></div>
        <div class="two columns">
            <input class="textclass" type="text" name="texta[]" id="text1<?php echo $row['emp_income_id'];?>" value="<?php echo $row[0];?>" style="width: 100%;">
        </div>
        <div class="three columns">
            <select name="caltype[]" id="caltype" class="textclass">
                <option value="0">--select-</option>
				<?php foreach($caltype as $type){?>
				<option value="<?php echo $type['id'];?>" <?php if($row[1]==$type['id']){ echo "selected" ;} ?>><?php echo $type['name'];?></option>
<?php }?>
                <!--<option value="1" <?php if($row[1]=='1'){ echo "selected" ;} ?>>Month's Days - Weeklyoff(26/27)</option>
                <option value="2" <?php if($row[1]=='2'){ echo "selected" ;} ?>>Month's Days - (30/31)</option>
                <option value="3" <?php if($row[1]=='3'){ echo "selected" ;} ?>>Consolidated</option>
                <option value="4" <?php if($row[1]=='4'){ echo "selected" ;} ?>>Hourly Basis</option>
                <option value="5" <?php if($row[1]=='5'){ echo "selected" ;} ?>>Daily Basis</option>
                <option value="6" <?php if($row[1]=='6'){ echo "selected" ;} ?>>Quarterly</option>-->
            </select>
        </div>
        <div class="three columns">
            <input class="textclass" type="text" name="textc[]" id="text3<?php echo $row['emp_income_id'];?>" value="<?php echo $row[2];?>">
        </div>

        <div class="clearFix"></div>
	</div>

    <div class="clearFix"></div>
	
<?php

    $i++; }
if($i==1) {?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if($i!=1) {?>
    <div class="twelve " >
        <br/>
       <input type="submit" value="Update" name="submit"  class="btnclass"  >
    </div>

<?php } ?>