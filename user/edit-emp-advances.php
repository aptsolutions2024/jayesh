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
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$rowsadnavcen=$userObj->showEployeeadnavcenall($id,$comp_id,$user_id);

$result1=$userObj->displayClient($id);
$resadv = $userObj->showAdvancetype($comp_id);
?>
<script>
    $( document ).ready(function() {
        $("#advdate1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });

    });
</script>
<form method="post"  id="form51">
    <div class="twelve padd0 columns successclass hidecontent" id="success51">


    </div>

    <div class="two columns">
        <span class="labelclass">Advance Type :</span>
    </div>
    <div class="four  columns">
        <select name="advtype1" id="advtype1" class="textclass">
            <option value="">--select---</option>
            <?php while($rowadv=mysql_fetch_array($resadv)){?>
                <option value="<?php echo $rowadv['mast_advance_type_id']; ?>"  <?php if($rowadv['mast_advance_type_id']==$rowsadnavcen['advance_type_id']){echo 'selected';}?>><?php echo $rowadv['advance_type_name']; ?></option>
            <?php } ?>
        </select>
        <span class="errorclass hidecontent" id="advtypeerror1"></span>
    </div>
    <div class="two columns">
        <span class="labelclass">Date :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="advdate1" id="advdate1" placeholder="Advance Date" class="textclass"  value="<?php echo date("d-m-Y", strtotime($rowsadnavcen['date'])); ?>">
        <span class="errorclass hidecontent" id="advdateerror1"></span>
    </div>
    <div class="clearFix"></div>

    <div class="two columns">
        <span class="labelclass">Advance Amount :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="advamt1" id="advamt1" placeholder="Advance Amount" class="textclass"  value="<?php echo $rowsadnavcen['adv_amount']; ?>">
        <span class="errorclass hidecontent" id="advamterror1"></span>
    </div>
    <div class="two columns">
        <span class="labelclass">Advance Installment :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="advins1" id="advins1" placeholder="Advance Installment" class="textclass" value="<?php echo $rowsadnavcen['adv_installment']; ?>">
        <span class="errorclass hidecontent" id="advinserror1"></span>
    </div>
    <div class="clearFix"></div>

    <div class="clearFix"></div>
    <input type="hidden" name="emp_adnavcen_id1" id="emp_adnavcen_id1" value="<?php echo $rowsadnavcen['emp_advnacen_id']; ?>">
    <div class="ten padd0 columns">
        &nbsp;&nbsp;
    </div>
    <div class="two columns text-right">
        <input type="button" name="submit" id="submit51" value="Update" class="btnclass" onclick="updateAdnavcen();">
    </div>
    <div class="clearFix"></div>
</form>