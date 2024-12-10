<?php
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/class/user-class.php");
$userObj=new user();
$id=$_POST['id'];
$view=$_POST['view'];
?>
<div class="twelve" style="background-color: #fff;" >
    <?php


    $resde=$userObj->displayDedincome($id,$comp_id,$user_id);
    $decount=mysqli_num_rows($resde);

    ?>

    <table width="100%"  >
        <tr>
            <th align="left" width="5%">Sr.No</th>

            <th align="left" width="20%">Deduction Heads</th>
            <th align="left" width="25%">Calculation Type</th>
            <th align="left" width="20%">STD Amount</th>
            <th align="left" width="20%">Remark </th>

            <th align="center" width="10%">Action</th>

        </tr>

        <?php $count=1;
        if($decount!=0) {
            while ($rowde = $resde->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>

                    <td class="tdata"><?php
                        $rs1 = $userObj->displayDeductionhead($rowde['head_id']);
                        echo $rs1['deduct_heads_name'];
                        ?></td>
                    <td class="tdata"><?php



                        if ($rowde['calc_type'] == '1') {
                            echo "Month's Days - Weeklyoff(26/27)";
                        } else if ($rowde['calc_type'] == '2') {
                            echo "Month's Days - (30/31)";
                        } else if ($rowde['calc_type'] == '3') {
                            echo "Consolidated";
                        } else if ($rowde['calc_type'] == '4') {
                            echo "Hourly Basis";
                        } else if ($rowde['calc_type'] == '5') {
                            echo "Daily Basis";
                        } else if ($rowde['calc_type'] == '6') {
                            echo "Quarterly";
                        }else if ($rowde['calc_type'] == '7') {
                            echo "As per Govt. Rules";
                        } else {
                            echo '-';
                        }


                        ?></td>
                    <td class="tdata"><?php echo $rowde['std_amt']; ?></td>
                    <td class="tdata"><?php echo $rowde['remark']; ?></td>
                    <td class="tdata" align="center">
                <?php if($view!='1'){?>
                        <a href="javascrip:void()" onclick="editderow(<?php echo $rowde['emp_deduct_id']; ?>)">
                            <img src="../images/edit-icon.png"/></a>
                <?php } ?>
                        <a href="javascrip:void()" onclick="deletederow(<?php echo $rowde['emp_deduct_id']; ?>)">
                            <img src="../images/delete-icon.png"/></a>
                    </td>

                </tr>
                <?php
                $count++;
            }
        }
        else{
        ?>
        <tr align="center">
            <td colspan="6" class="tdata errorclass">
                <span class="norec">No Record found</span>
            </td>
        <tr>
            <?php
            }
            ?>

    </table>
</div>
