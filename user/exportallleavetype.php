<?php
session_start();
$file="all_leavetype.xls";
$comp_id = $_SESSION['comp_id'];
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$result1 = $userObj->showLeavetype($comp_id);

 header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");

?>
<table style="border:1px solid #000" cellspacing="1"cellpadding="1">
<tr>
<th>Leave Type id</th>
<th>Leave Type Name</th>
</tr>
<?php while($row=$result1->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['mast_leave_type_id'];?></td>
<td><?php echo $row['mast_leave_type_name'];?></td>


</tr>
<?php }?>
</table>
