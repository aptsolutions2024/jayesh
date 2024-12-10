<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


  $lmt = ' 0,45';
$lt=$_POST['lt'];
$emp=$_POST['emp'];
$client=$_POST['client'];
$empid=$_POST['empid'];
$t1 = strtotime($_POST['frdate']);
$t2 = strtotime($_POST['todate']);
$total_sec = abs($t2-$t1);
$total_min = floor($total_sec/60);
$total_hour = floor($total_min/60);
$present_day = floor($total_hour/24);
$date=date("Y-m-d", strtotime($_POST['date']));
$frdate = date("Y-m-d",$t1);
$todate = date("Y-m-d",$t2);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

if($empid!=''){
    $subquey="td.emp_id= '".$empid."'";
}else{
    $subquey="td.client_id= '".$client."'";
}
  $sql11 = "SELECT td.emp_id,sum(td.present) as present,concat(e.first_name,' ',e.middle_name,' ' , e.last_name ) as name,round((sum(td.present)+10)/20,0) as earned,sum(pl) as enjoyed,lv.ob ,(lv.ob+ round((sum(td.present)+10)/20,0) - sum(pl)) as balance,e.bank_id,e.bankacno,e.pay_mode from tran_days td inner join employee e on e.emp_id =td.emp_id inner join emp_leave lv on td.emp_id = lv.emp_id  
 where  $subquey and td.sal_month >= '".$frdate."' and td.sal_month <= '".$todate."' and lv.from_date >= '".$frdate."' and 
 lv.leave_type_id ='$lt' group by td.emp_id";

$result11 = mysql_query($sql11);

$count = mysql_num_rows($result11);

	 ?>


<div style="height: 55px;width: 100%">&nbsp;</div>
<div>
<div>
    <br/>

    <div style="max-height:300px;padding-bottom: 20px; overflow-y: scroll;">

    <table width="1170px">
        <tr>
            <th width="20%">Employee Name</th>
            <th width="10%">Present days</th>
            <th width="10%">Leave Earned</th>
            <th width="10%">OB</th>
            <th width="10%">Leave Enjoyed</th>
            <th width="10%">Balance Leave</th>
            <th width="10%">Rate</th>
            <th width="10%">Amount</th>
            <th width="10%">Cheque</th>

        </tr>

    <?php

if($count>0) {

    $i=1;

    while($row = mysql_fetch_array($result11)) {


        $sqlch = "SELECT * FROM `tran_leave` WHERE  emp_id = '".$row['emp_id']."'";
        $resultch = mysql_query($sqlch);
        $counts = mysql_num_rows($resultch);

        $result1 = $userObj->showEployeedetails($row['emp_id'],$comp_id,$user_id);
        if($counts>0) {
            $row11 = mysql_fetch_array($resultch);

            ?>
            <input type="hidden" id="bank_id<?php echo $i;?>" name="bank_id[]" value="<?php echo $row['bank_id']; ?>">
            <input type="hidden" id="bankac<?php echo $i;?>" name="bankac[]" value="<?php echo $row['bankacno']; ?>">
            <input type="hidden" id="paymode<?php echo $i;?>" name="paymode[]" value="<?php echo $row['pay_mode']; ?>">

            <input type="hidden" id="emp_id<?php echo $i;?>" name="emp_id[]" value="<?php echo $row11['emp_id']; ?>">

            <input type="hidden" id="trl_id<?php echo $i;?>" name="trl_id[]" value="<?php echo $row11['trl_id']; ?>">

            <tr>
            <td><?php

                echo $result1['first_name'].' '. $result1['middle_name'].' '.$result1['last_name'];

                ?></td>
            <td>
                <input type="text" name="pr[]" id="pr<?php echo $i;?>" class="textclass" value="<?php echo $row11['present_days']; ?>" title="Please enter the Presen">
            </td>
            <td>
                <input type="text" name="lea[]" id="lea<?php echo $i;?>" class="textclass" value="<?php echo $row11['leave_earned']; ?>" title="Please enter the Leave Earned">
            </td>
            <td>
                <input type="text" name="ob[]" id="ob<?php echo $i;?>" class="textclass" value="<?php echo $row11['ob']; ?>" title="Please enter the OB">
            </td>
            <td>
                <input type="text" name="lej[]" id="lej<?php echo $i;?>" class="textclass" value="<?php echo $row11['leave_enjoyed']; ?>" title="Please enter the Leave Enjoyed">
            </td>
            <td>
                <input type="text" name="bl[]" id="bl<?php echo $i;?>" class="textclass" value="<?php echo $row11['leave_balance'];?>" title="Please enter the Balance Leave">
            </td>
            <td>
                <input type="text" name="rate[]" id="rate<?php echo $i;?>" class="textclass" value="<?php echo $row11['rate']; ?>" title="Please enter the Rate">
            </td>
            <td>
                <input type="text" name="amt[]" id="amt<?php echo $i;?>" class="textclass" value="<?php echo $row11['amount']; ?>"  title="Please enter the Amount">
            </td>
            <td>
                <input type="text" name="chq[]" id="chq<?php echo $i;?>" class="textclass" value="<?php echo $row11['chequeno']; ?>" title="Please enter the Cheque">
            </td>




            <?php
        }
        else {
            ?>
            <input type="hidden" id="bank_id<?php echo $i;?>" name="bank_id[]" value="<?php echo $row['bank_id']; ?>">
            <input type="hidden" id="bankac<?php echo $i;?>" name="bankac[]" value="<?php echo $row['bankacno']; ?>">
            <input type="hidden" id="paymode<?php echo $i;?>" name="paymode[]" value="<?php echo $row['pay_mode']; ?>">
            <input type="hidden" id="emp_id<?php echo $i; ?>" name="emp_id[]" value="<?php echo $row['emp_id']; ?>">

            <input type="hidden" id="trl_id<?php echo $i; ?>" name="trl_id[]" value="<?php echo $row['trl_id']; ?>">

            <tr>
                <td>
                    <?php
                    echo $row['name'];
                    ?>
                </td>
                <td>
                    <input type="text" name="pr[]" id="pr<?php echo $i; ?>" class="textclass"
                           value="<?php echo $row['present']; ?>" title="Please enter the Presen">
                </td>
                <td>
                    <input type="text" name="lea[]" id="lea<?php echo $i; ?>" class="textclass"
                           value="<?php echo $row['earned']; ?>" title="Please enter the Leave Earned">
                </td>
                <td>
                    <input type="text" name="ob[]" id="ob<?php echo $i; ?>" class="textclass"
                           value="<?php echo $row['ob']; ?>" title="Please enter the OB">
                </td>
                <td>
                    <input type="text" name="lej[]" id="lej<?php echo $i; ?>" class="textclass"
                           value="<?php echo $row['enjoyed']; ?>" title="Please enter the Leave Enjoyed">
                </td>
                <td>
                    <input type="text" name="bl[]" id="bl<?php echo $i; ?>" class="textclass"
                           value="<?php echo $row['balance']; ?>" title="Please enter the Balance Leave">
                </td>
                <td>
                    <input type="text" name="rate[]" id="rate<?php echo $i; ?>" class="textclass" value=""
                           title="Please enter the Rate">
                </td>
                <td>
                    <input type="text" name="amt[]" id="amt<?php echo $i; ?>" class="textclass" value=""
                           title="Please enter the Amount">
                </td>
                <td>
                    <input type="text" name="chq[]" id="chq<?php echo $i; ?>" class="textclass" value=""
                           title="Please enter the Cheque">
                </td>


            </tr>
            <?php

        }
        $i++;
    }
}
else{
    ?>
    <tr class="bgColor3">
        <td colspan="21" class="errorclass" align="center">No Result Fond!</td>

    </tr>
    <?php
}
?>

</table>
</div>
</div>
<?php
if($count>0) { ?>
<div ><br/>
<input type="submit" value="Save & Calculation" class="btnclass" >
</div>
<?php } ?>
    <br/>
</div>

<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<script type="text/javascript">
    $(function() {
        $('.textclass').tooltip({
            track: true
        });
    });
</script>
<style type="text/css">

    .ui-tooltip {
        padding: 8px;
        position: absolute;
        z-index: 9999;
        max-width: 300px;
        -webkit-box-shadow: 0 0 5px #aaa;
        box-shadow: 0 0 5px #aaa;
    }
    /* Fades and background-images don't work well together in IE6, drop the image */
    * html .ui-tooltip {
        background-image: none;
    }
    body .ui-tooltip { border-width: 2px; }

    .ui-tooltip
    {
        font-size:10pt;
        font-family:Calibri;

    }

</style>