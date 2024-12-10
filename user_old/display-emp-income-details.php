<?php

session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$id=$_POST['id'];
$view=$_POST['view'];
?>
<div class="twelve">
        <?php


        $resei=$userObj->displayEmpincome($id,$comp_id,$user_id);
                        $eicount=mysqli_num_rows($resei);

                        ?>

        <table width="100%"  >
            <tr>
                <th align="left" width="5%">Sr.No</th>

                <th align="left" width="20%">Income Heads</th>
                <th align="left" width="25%">Calculation Type</th>
                <th align="left" width="20%">STD Amount </th>
                <th align="left" width="20%">Remark </th>

                <th align="center" width="10%">Action</th>

            </tr>

            <?php $count=1;
            if($eicount!=0) {
                while ($rowei = $resei->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="tdata"><?php echo $count; ?></td>
                        <!--   <td class="tdata"><?php
                        /*                    $rs=$userObj->showEployeedetails($rowei['emp_id']);

                                            echo $rs['first_name'].' '.$rs['last_name'];*/
                        ?></td>-->
                        <td class="tdata"><?php
                            $rs1 = $userObj->displayIncomehead($rowei['head_id']);
                            echo $rs1['income_heads_name'];
                            ?></td>
                        <td class="tdata"><?php echo $userObj->getIncomeCalculationTypeByid($rowei['calc_type']);

                            /*if ($rowei['calc_type'] == '1') {
                                echo "Month's Days - Weeklyoff(26/27)";
                            } else if ($rowei['calc_type'] == '2') {
                                echo "Month's Days - (30/31)";
                            } else if ($rowei['calc_type'] == '3') {
                                echo "Consolidated";
                            } else if ($rowei['calc_type'] == '4') {
                                echo "Hourly Basis";
                            } else if ($rowei['calc_type'] == '5') {
                                echo "Daily Basis";
                            } else if ($rowei['calc_type'] == '6') {
                                echo "Quarterly";
                            }else if ($rowei['calc_type'] == '7') {
                                echo "Gross Salary/8 *2";
                            }else if ($rowei['calc_type'] == '8') {
                                echo "Per Shift Rs.20 if <= 15 else Rs.27 if >15";
                            }else if ($rowei['calc_type'] == '9') {
                                echo "Per Shift Rs.25 if <= 15 else Rs.34.5 if >15";
                            }else if ($rowei['calc_type'] == '10') {
                                echo "Per Shift";
                            }else if ($rowei['calc_type'] == '11') {
                                echo "(GROSS-CONVEYANCE)/8*2";
                            }else if ($rowei['calc_type'] == '12') {
                                echo "GORSS SALARY /8";
                            }else if ($rowei['calc_type'] == '13') {
                                echo "(BASIC+DA)/8*2";
                            } else {
                                echo '-';
                            }*/


                            ?></td>
                        <td class="tdata"><?php echo $rowei['std_amt']; ?></td>
                        <td class="tdata"><?php echo $rowei['remark']; ?></td>
                        <td class="tdata" align="center">
                            <?php if($view!='1'){?>
                            <a href="javascrip:void()" onclick="editeirow(<?php echo $rowei['emp_income_id']; ?>)">
                                <img src="../images/edit-icon.png"/></a>
                          <?php } ?>
                            <a href="javascrip:void()" onclick="deleteeirow(<?php echo $rowei['emp_income_id']; ?>)">
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
