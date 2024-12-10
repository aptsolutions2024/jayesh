<?php
session_start();
$file="all_bank.xls";
$comp_id = $_SESSION['comp_id'];
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$result1 = $userObj->showBank($comp_id);

 header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");

?>
<table style="border:1px solid #000" cellspacing="1"cellpadding="1">
<tr>
<th>Bank Id</th>
<th>Bank Name</th>
<th>Branch</th>
<th>IFSC Code</th>
</tr>
<?php while($row=$result1->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['mast_bank_id'];?></td>
<td><?php echo $row['bank_name'];?></td>
<td><?php echo $row['branch'];?></td>
<td><?php echo $row['ifsc_code'];?></td>


</tr>
<?php }?>
</table>
