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

$rowsleave=$userObj->showEployeeleaveall($id,$comp_id,$user_id);

$result1=$userObj->displayClient($id);
$reslt = $userObj->showLeavetype($comp_id);
?><script>
    $( document ).ready(function() {
        $("#lfdate1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#ltdate1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });

    });
</script>
<form method="post"  id="form41">
    <div class="twelve padd0 columns successclass hidecontent" id="success41">


    </div>

    <div class="clearFix"></div>
    <input type="hidden" name="emp_leave_id1" id="emp_leave_id1" value="<?php echo $rowsleave['emp_leave_id']; ?>">


    <div class="two columns">
        <span class="labelclass">Leave Type :</span>
    </div>
    <div class="four  columns">
        <select id="lt1" name="lt1" class="textclass">
            <option>--select---</option>
            <?php while($rowlt=mysql_fetch_array($reslt)){?>
                <option value="<?php echo $rowlt['mast_leave_type_id']; ?>"  <?php if($rowlt['mast_leave_type_id']==$rowsleave['leave_type_id']){ echo 'selected'; }?>><?php echo $rowlt['leave_type_name']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="two columns">
        <span class="labelclass">Opening Balance  :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="ob1" id="ob1" placeholder="OB" class="textclass"   value="<?php echo $rowsleave['ob']; ?>">
        <span class="errorclass hidecontent" id="oberror"></span>
    </div>
    <div class="clearFix"></div>




    <div class="two columns">
        <span class="labelclass">From Date :</span>
    </div>
    <div class="four  columns">
        <input type="text" name="lfdate" id="lfdate1" placeholder="From Date" class="textclass" value="<?php if($rowsleave['from_date']!='' || $rowsleave['from_date']!='0000-00-00'){ echo date("d-m-Y", strtotime($rowsleave['from_date'])); } ?>">

    </div>

    <div class="two columns">
        <span class="labelclass">To Date:</span>
    </div>
    <div class="four  columns">
        <input type="text" name="ltdate" id="ltdate1" placeholder="To Date" class="textclass" value="<?php if($rowsleave['todate']!='' || $rowsleave['todate']!='0000-00-00'){ echo date("d-m-Y", strtotime($rowsleave['todate'])); } ?>" >

    </div>
    <div class="clearFix"></div>


    <div class="ten padd0 columns">
        &nbsp;&nbsp;
    </div>
    <div class="two columns text-right">
        <input type="button" name="submit" id="submit41" value="Update" class="btnclass" onclick="updateLeave();">
    </div>

    <div class="clearFix"></div>

</form>