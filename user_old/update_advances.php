<?php
session_start();

$comp_id=$_SESSION['comp_id'];
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

/*echo "hello";
echo $sql = "update emp_advnacen ea inner join ( select `emp_advance_id`,emp_id,sum(amount) as amt from hist_advance group by emp_id,emp_advance_id) hadv on hadv.emp_advance_id = ea.emp_advnacen_id set ea.received_amt = hadv.amt where comp_id = '$comp_id' ";
$row= mysql_query($sql);*/
$userObj->updateempAdvnacen($comp_id);

/*echo $sql = "select * from emp_advnacen where adv_amount<=received_amt and comp_id ='$comp_id'";
$row= mysql_query($sql);*/
$row = $userObj->getEmpAdvnacen($comp_id);
while($row1 =$row->fetch_array())
	{
		/*echo "<br> ".$row1['emp_advnacen_id'];
		echo $sql = "select * from hist_advance where  emp_advance_id = '".$row1['emp_advnacen_id']."' order by `tradv_id` desc limit 1";
		$row2= mysql_query($sql);
		$row3 =mysql_fetch_array($row2);*/
		$userObj->getHistAdvance1($row1['emp_advnacen_id']);
		/*$sql = "update emp_advnacen set closed_on = '".date('Y-m-d',strtotime($row3['sal_month']))."' where `emp_advnacen_id` = '".$row1['emp_advnacen_id']."'";
		 mysql_query($sql);*/
		 $userObj->updateEmpAdvance($row3['sal_month'],$row1['emp_advnacen_id']);
	}

?>