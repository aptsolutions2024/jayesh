<?php
session_start();
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

$resultIncome = $userObj->showIncomehead($comp_id);
$rowsincome=$userObj->showEployeeincomeall($id,$comp_id,$user_id);
?>
<form method="post"  id="form2">
    <div class="twelve padd0 columns successclass hidecontent" id="success21">


    </div>

    <div class="clearFix"></div>

    <div id="insertIncome">

        <div class="two columns">
            <span class="labelclass">Income :</span>
        </div>
        <div class="four columns">
            <select id="incomeid1" name="incomeid1" class="textclass">
                <option value="0">--select-</option>
                <?php
                while($rowin=$resultIncome->fetch_assoc()){
                    ?>

                    <option value="<?php echo $rowin['mast_income_heads_id'];?>"  <?php if($rowin['mast_income_heads_id']==$rowsincome['head_id']){ echo "selected" ;} ?> ><?php echo $rowin['income_heads_name'];?></option>
                <?php }

                ?>
            </select>
            <span class="errorclass hidecontent" id="incoerror1"></span>
        </div>

        <input type="hidden" name="emp_income_id1" id="emp_income_id1" value="<?php echo $rowsincome['emp_income_id']; ?>">
        <div class="two columns">
            <span class="labelclass">Calculation Type :</span>
        </div>
        <div class="four  columns">
		   <?php
                        $rescalin=$userObj->showCalType('caltype_income');
                        ?>
                        <select  name="caltype1" id="caltype1" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            while($rowcalin=$rescalin->fetch_assoc()){?>
                                <option value="<?php echo $rowcalin['id']; ?>" <?php if($rowsincome['calc_type']== $rowcalin['id']){ echo "selected" ;} ?>><?php echo $rowcalin['name']; ?></option>

                            <?php } ?>

                        </select>
						
						
           
            <span class="errorclass hidecontent" id="calterror1"></span>
        </div>
        <div class="clearFix"></div>
        <div class="two columns">
            <span class="labelclass">STD Amount :</span>
        </div>
        <div class="four  columns">
            <input type="text" name="stdamt1" id="stdamt1" placeholder="STD Amount" class="textclass" value="<?php echo $rowsincome['std_amt']; ?>">
            <span class="errorclass hidecontent" id="stderror1"></span>
        </div>
        <div class="two columns">
            <span class="labelclass">Remark :</span>
        </div>
        <div class="four  columns">
            <input type="text" name="inremark1" id="inremark1" placeholder="Remark" class="textclass" value="<?php echo $rowsincome['remark']; ?>">
            <span class="errorclass hidecontent" id="inrerror1"></span>
        </div>
        <div class="clearFix"></div>




        <div class="ten padd0 columns">
            &nbsp;&nbsp;
        </div>
        <div class="two columns text-right">
            <input type="button" name="submit" id="submit2" value="Update" class="btnclass" onclick="updateIncome();">
        </div>

        <div class="clearFix"></div>

</form>