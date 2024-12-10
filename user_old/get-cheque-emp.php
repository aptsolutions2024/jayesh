<?php
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$userObj=new user();


$empid = $_POST['empid'];
$sql = "select * from cheque_details where emp_id ='".$empid."'";
$row = mysql_query($sql);
$reschkdtl = mysql_fetch_assoc($row);

$employee = $userObj->showEployeedetailsQ($empid,$comp_id,$user_id);
$resemployee = mysql_fetch_assoc($employee);
$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
$type = "S";
$chkDtl= $userObj->chkDetails($empid,$cmonth,$type );
		$chkDtl = $userObj->chkDetails($emp['emp_id'],$cmonth,$type);
		$cnt = 0;
		$cnt = mysql_num_rows($chkDtl);	
		$chk = mysql_fetch_array($chkDtl);
		
			?>
	<form method="post"  method="post" action="/add_cheque_details" id="addchkdtl">
			  <input type="hidden" value="" id="chkdate" name="chkdate">
			  <input type="hidden" value="<?php echo $cmonth;?>" id="cmonth" name="cmonth">
			  
			  <div id="chkdtllst">

	<table width="100%" style="background-color:#fff" id="emplist">

	<tr>
	<th align="left" width="5%">Sr No</th>
	<th align="left" width="10%">Salary Month</th>
	<th align="left" width="5%">Emp Id</th>
	<th align="left" width="30%">Emp Name</th>
	<th align="left" width="10%">Amount</th>
	<th align="left" width="12%">Cheque No.</th>
	<th align="left" width="15%">Cheque Date</th>
	<th align="left" width="10%">Action</th>
	</tr>
	
	<tr id="chkdtl<?php echo $srno;?>">
	<td><?php echo $srno; ?></td>
	
	<td><?php echo date("M, Y", strtotime($cmonth));; ?></td>
	
	<td><input name="emp_id[]" type="hidden" value="<?php echo $emp['emp_id'];?>"><?php echo $emp['emp_id'];?></td>
	
	<td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	
	
	 <?php 
	 if($cnt>0){?>
	  <td><input name="amount[]" type="text" value="<?php echo $chk['amount'];?>" class="textclass " id="amt<?php echo $srno;?>"></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chk['check_no'];?>" class="textclass " id="chk<?php echo $srno;?>" ></td>
		
		<td><input name="date[]" type="text" value="<?php echo date('d-m-Y',strtotime($chk['date']));?>" class="textclass " id="date<?php echo $srno;?>"></td>
		
		
	 <?php }else {  ?>	
	  
		<td><input name="amount[]" type="text" value='<?php echo $emp['netsalary'];?>' class="textclass " id="amt<?php echo $srno;?>" readonly></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkno;?>" class="textclass " id="chk<?php echo $srno;?>"> </td>
		
		<td><input name="date[]" type="text" value="<?php echo $checkdate;?>" class="textclass " id="date<?php echo $srno;?>"></td>
	
	
	 <?php $chkno++;}
	?>
	<!--<td><input type="button" value="Edit" class="btnclass" onclick="editsingle('<?php echo $chkdtl['chk_detail_id'];?>','<?php echo $srno;?>')"></td>-->
	</tr>
	<!--<tr id="chkdtlsucc<?php echo $srno;?>" class="hidecontent">
	<td colspan="7" id="succdtl<?php echo $srno;?>" class="successclass"></td>
	</tr>-->
	<?php //$srno++; $no++;} ?>
	<input type="hidden" value="" name="print" id="print">
	</table>
      </div>       
            <div class="clearFix">&nbsp;</div>
<div><input type="submit" value="Save" name="submit" class="btnclass" id="addcheque" > <input type="submit" value="Print All" name="printbtn" class="btnclass"  onclick="printval()"></div>
            </form>