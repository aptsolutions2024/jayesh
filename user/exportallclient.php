<?php
$file="all_clients.xls";


session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$result1 = $userObj->showClient1($comp_id,$user_id);

 header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");

?>
<table style="border:1px solid #000" cellspacing="1"cellpadding="1">
<tr>
<th>Client No</th>
<th>Client Name</th>
<th>Client Address</th>
<th>ESI code</th>
<th>PF Code</th>
<th>GST No</th>
<th>Service Charges</th>
</tr>
<?php while($row=$result1->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['clientno'];?></td>
<td><?php echo $row['client_name'];?></td>
<td><?php echo $row['client_add1'];?></td>
<td><?php echo $row['esicode'];?></td>
<td><?php echo $row['pfcode'];?></td>
<td><?php echo $row['gstno'];?></td>
<td><?php echo $row['ser_charges'];?></td>


</tr>
<?php }?>
</table>
