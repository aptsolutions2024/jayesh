<?php
session_start();
$file="all_deduction_heads.xls";
$comp_id = $_SESSION['comp_id'];
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$result1 = $userObj->showDeductionhead($comp_id);

 header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");

?>
<table style="border:1px solid #000" cellspacing="1"cellpadding="1">
<tr>
<th>Deduction Head id</th>
<th>Deduction Head Name</th>
</tr>
<?php while($row=$result1->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['mast_deduct_heads_id'];?></td>
<td><?php echo $row['deduct_heads_name'];?></td>


</tr>
<?php }?>
</table>
