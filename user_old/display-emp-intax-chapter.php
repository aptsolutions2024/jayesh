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


    $res=$userObj->displayintaxchapter($id,$year,$comp_id,$user_id);
    $tcount=mysqli_num_rows($res);

    ?>

    <table width="100%"  >
        <tr>
            <th align="left" width="5%">Sr.No</th>
            <th align="left" width="25%">Section Name</th>
            <th align="left" width="20%">Gross Amount</th>
            <th align="left" width="20%">Qual Amount</th>
            <th align="left" width="20%">Deduct Amount</th>
            <th align="center" width="10%">Action</th>
        </tr>

        <?php $count=1;
        if($tcount!=0) {
            while($row =$res->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>


                    <td class="tdata"><?php echo $row['section_name']; ?></td>
                    <td class="tdata"><?php echo $row['gross_amt']; ?></td>
                    <td class="tdata"><?php echo $row['qual_amt']; ?></td>
                    <td class="tdata"><?php echo $row['deduct_amt']; ?></td>
                    <td class="tdata" align="center">
                        <a href="javascrip:void()" onclick="editchapter(<?php echo $row['id']; ?>)">
                            <img src="../images/edit-icon.png"/></a>
                        <a href="javascrip:void()" onclick="deletechapter(<?php echo $row['id']; ?>)">
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
