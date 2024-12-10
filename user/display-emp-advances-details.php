<?php
include_once("../lib/connection/db-config.php");
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//include("../lib/connection/db-config.php");
include_once("../lib/class/user-class.php");
$userObj=new user();
$id=$_POST['id'];
$view=$_POST['view'];
?>
<div class="twelve">
        <?php


        $resad=$userObj->displayAdvances($id.$comp_id,$user_id);
        $adcount=mysqli_num_rows($resad);

                        ?>

        <table width="100%"  >
            <tr>
                <th align="left" width="5%">Sr.No</th>


                <th align="left" width="10%">Advance Type</th>
                <th align="left" width="30%">Advances Amount</th>
                <th align="left" width="25%">Advances Installment</th>
                <th align="left" width="20%">Date</th>

                <th align="center" width="10%">Action</th>

            </tr>

            <?php $count=1;
            if($adcount!=0) {
                while ($rowad = $resad->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="tdata"><?php echo $count; ?></td>



                        <td class="tdata"><?php
                                           $adname=$userObj->displayAdvancetype($rowad['advance_type_id']);
                            echo $adname['advance_type_name'];
                            ?></td>
                        <td class="tdata"><?php echo $rowad['adv_amount']; ?></td>
                        <td class="tdata"><?php echo $rowad['adv_installment']; ?></td>
                        <td class="tdata"><?php echo date("d-m-Y", strtotime($rowad['date'])); ?></td>
                        <td class="tdata" align="center">
                            <?php if($view!='1'){?>
                            <a href="javascript:void(0)" onclick="editadrow(<?php echo $rowad['emp_advnacen_id']; ?>)">
                                <img src="../images/edit-icon.png"/></a>
                        <?php } ?>
                            <a href="javascript:void(0)" onclick="deleteadrow(<?php echo $rowad['emp_advnacen_id']; ?>)">
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
