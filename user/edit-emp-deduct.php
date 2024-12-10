<?php
session_start();
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
if(isset($_POST['id'])&&$_POST['id']!='') {
    $id = $_POST['id'];
    $_SESSION['tempcid'] = $id;
}
else{
    $id = $_SESSION['tempcid'];
}
include_once('../paginate.php');
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$result1=$userObj->displayClient($id);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$resultdeduct = $userObj->showDeductionhead($comp_id);
$rowsdeduct=$userObj->showEployeedeductall($id,$comp_id,$user_id);
//print_r($rowsdeduct);
$result511 = $userObj->showBank($comp_id);
//print_r(mysql_fetch_array($result51));
?>
<form method="post"  id="form31">
    <div class="twelve padd0 columns successclass hidecontent" id="success31">
    </div>

    <div class="clearFix"></div>
    <input type="hidden" name="emp_deduct_id1" id="emp_deduct_id1" value="<?php echo $rowsdeduct['emp_deduct_id']; ?>">
    <div class="two columns">
        <span class="labelclass">Deduction :</span>
    </div>
    <div class="four  columns">
        <select id="destid1" name="destid1" class="textclass">
            <option value="0">--select-</option>
            <?php
            while ($rowde=$resultdeduct->fetch_assoc()){
                ?>

                <option value="<?php echo $rowde['mast_deduct_heads_id'];?>" <?php if($rowde['mast_deduct_heads_id']==$rowsdeduct['head_id']){ echo "selected" ;} ?> ><?php echo $rowde['deduct_heads_name'];?></option>
            <?php }

            ?>
        </select>
        <span class="errorclass hidecontent" id="destiderror1"></span>
    </div>
    <div class="two columns">
        <span class="labelclass">Calculation Type :</span>
    </div>
    <div class="four  columns">
        <select name="decaltype1" id="decaltype1" class="textclass">
            <option value="0">--select-</option>
            <option value="1" <?php if($rowsdeduct['calc_type']=='1'){ echo "selected" ;} ?>>Month's Days - Weeklyoff(26/27)</option>
            <option value="2" <?php if($rowsdeduct['calc_type']=='2'){ echo "selected" ;} ?>>Month's Days - (30/31)</option>
            <option value="3" <?php if($rowsdeduct['calc_type']=='3'){ echo "selected" ;} ?>>Consolidated</option>
            <option value="4" <?php if($rowsdeduct['calc_type']=='4'){ echo "selected" ;} ?>>Hourly Basis</option>
            <option value="5" <?php if($rowsdeduct['calc_type']=='5'){ echo "selected" ;} ?>>Daily Basis</option>
            <option value="6" <?php if($rowsdeduct['calc_type']=='6'){ echo "selected" ;} ?>>Quarterly</option>
            <option value="7" <?php if($rowsdeduct['calc_type']=='7'){ echo "selected" ;} ?>>As per Govt. Rules</option>
        </select>

        <span class="errorclass hidecontent" id="dectyerror1"></span>
    </div>
    <div class="clearFix"></div>

    <div class="two columns">
        <span class="labelclass"> STD Amount :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="destdamt1" id="destdamt1" placeholder="STD Amount" class="textclass" value="<?php echo $rowsdeduct['std_amt']; ?>">
        <span class="errorclass hidecontent" id="destderror1"></span>
    </div>

    <div class="two columns">
        <span class="labelclass">Remark :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="destdremark1" id="destdremark1" placeholder="Remark" class="textclass" value="<?php echo $rowsdeduct['remark']; ?>">
        <span class="errorclass hidecontent" id="destdrrerror1"></span>
    </div>
    <div class="clearFix"></div>


    <div class="two columns" >
        <!--                                <input type="hidden" name="selbank" id="selbank" value="0">-->
        <div class="bankon">
            <span class="labelclass"> Bank :</span>
        </div>
    </div>
    <div class="four  columns">
        <div class="bankon">
            <select id="mybank1" name="mybank" class="textclass"  >
                <option>--select--</option>
                <?php
				
                while ($row51=$result511->fetch_assoc()){
                    ?>
                    <option value="<?php echo $row51['mast_bank_id'];?>" <?php if($row51['mast_bank_id']==$rowsdeduct['bank_id']){?> selected<?php }?>><?php echo $row51['bank_name'].' - '.$row51['branch'];?></option>
                <?php }

                ?>
            </select>

        </div>
    </div>
    <div class="four  columns">&nbsp;

    </div>
    <div class="two columns text-right">
        <input type="button" name="submit" id="submit3" value="Update" class="btnclass" onclick="updateDeduct();">
    </div>

    <div class="clearFix"></div>

</form>
