<?php

session_start();
include("../lib/class/user-class.php");
$userObj=new user();
$id=$_POST['id'];
?>
<div class="twelve" style="background-color: #fff;" >
    <?php

 $year=$_SESSION['yr'];
   $comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

    $res=$userObj->displayintaxc($id,$year,$comp_id,$user_id);
    $tcount=mysqli_num_rows($res);

    ?>

    <table width="100%"  >
        <tr>
            <th align="left" width="5%">Sr.No</th>
            <th align="left" width="40%">80C Desc</th>
            <th align="left" width="45%">80c Amount</th>
            <th align="center" width="10%">Action</th>
        </tr>

        <?php $count=1;
        if($tcount!=0) {
            while($row =$res->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>


                    <td class="tdata"><?php echo $row['80C_desc']; ?></td>
                    <td class="tdata"><?php echo $row['80c_amt']; ?></td>
                    <td class="tdata" align="center">
                        <a href="javascrip:void()" onclick="editc(<?php echo $row['id']; ?>)">
                            <img src="../images/edit-icon.png"/></a>
                        <a href="javascrip:void()" onclick="deletec(<?php echo $row['id']; ?>)">
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
