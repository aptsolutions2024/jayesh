<?php
error_reporting(0);
include("../lib/connection/db-config.php");
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
			//echo "hello";

            echo $resle=$userObj->displayEmpleave($id,$comp_id,$user_id);
                        $lecount=mysqli_num_rows($resle);

                        ?>

        <table width="100%"  >
            <tr>
                <th align="left" width="5%">Sr.No</th>

                <th align="left" width="20%">Leave Type</th>
                <th align="left" width="45%">Opening Balance</th>
                <th align="left" width="20%">From Date</th>
                <th align="left" width="20%">To Date</th>



                <th align="center" width="10%">Action</th>

            </tr>

            <?php $count=1;
            if($lecount!=0) {
                while ($rowle =$resle->fetch_asssoc()) {
                    ?>
                    <tr>
                        <td class="tdata"><?php echo $count; ?></td>


                        <td class="tdata"><?php
                            $lename=$userObj->displayLeavetype($rowle['leave_type_id']);
                              echo $lename['leave_type_name'];
                            ?></td>
                        <td class="tdata"><?php echo $rowle['ob']; ?></td>
                        <td class="tdata"><?php if($rowle['from_date']!='0000-00-00'){ echo date("d-m-Y", strtotime($rowle['from_date'])); }  ?></td>
                        <td class="tdata"><?php if($rowle['todate']!='0000-00-00'){ echo date("d-m-Y", strtotime($rowle['todate'])); } ?></td>

                        <td class="tdata" align="center">
                            <?php if($view!='1'){?>
                            <a href="javascrip:void()" onclick="editlerow(<?php echo $rowle['emp_leave_id']; ?>)">
                                <img src="../images/edit-icon.png"/></a>
                          <?php } ?>
                            <a href="javascrip:void()" onclick="deletelerow(<?php echo $rowle['emp_leave_id']; ?>)">
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
