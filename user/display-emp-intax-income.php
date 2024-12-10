<?php
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/class/user-class.php");
$userObj=new user();
$id=$_POST['id'];
?>
<div class="twelve" style="background-color: #fff;" >
    <?php
    $year=$_SESSION['yr'];
    $res=$userObj->displayintaxincome($id,$year,$comp_id,$user_id);
    $tcount=mysqli_num_rows($res);

    ?>

    <table width="100%"  >
        <tr>
            <th align="left" width="5%">Sr.No</th>

            <th align="left" width="40%">Income Desc</th>
            <th align="left" width="45%">Income Amount</th>
            <th align="center" width="10%">Action</th>

        </tr>

        <?php $count=1;
        if($tcount!=0) {
            while($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>


                    <td class="tdata"><?php echo $row['income_desc']; ?></td>
                    <td class="tdata"><?php echo $row['income_amt']; ?></td>
                    <td class="tdata" align="center">
                        <a href="javascrip:void()" onclick="editincome(<?php echo $row['id']; ?>)">
                            <img src="../images/edit-icon.png"/></a>
                        <a href="javascrip:void()" onclick="deleteincome(<?php echo $row['id']; ?>)">
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
