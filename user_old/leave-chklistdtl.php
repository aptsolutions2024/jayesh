<?php 
// error_reporting(0);
 $chkno = $_POST['checkn'];
 $checkdate = $_POST['checkdt'];
 session_start();
 print_r($_POST);
 include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/leave.php");
$userObj=new user();
$leave=new leave();
$month=$_SESSION['month'];
$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
$type = "L";
$empid1 = $_POST['empid1'];
$payment_date = date('Y-m-d',strtotime($_POST['payment_date']));

$tab_emp = "leave_details";
if ($empid1 >0 )

{$emplist = $leave->getLeaveChequeEmployeeByEmpId($empid1,$payment_date,$payment_date);
}
else{
	$empid1= 0;
	
$emplist = $leave->getLeaveChequeEmployeeByClientId($clientid,$tab_emp,$payment_date,$payment_date);
}
 ?>
 <form method="post"  method="post" action="/add_leave_cheque_details" id="addchkdtl" >
			  <input type="hidden" value="" id="chkdate" name="chkdate">
			  <input type="hidden" value="" name="print1" id="print1">
			  <input type="hidden" value="<?php echo $payment_date; ?>" name="payment_date" id="payment_date">
			  
			  
	<div class="row body">		
	<table width="100%" style="background-color:#fff" id="emplist">

	<tr>
	<th align="left" width="5%">Sr No</th>
	<th align="left" width="10%">Payment Date</th>
	<th align="left" width="5%">Emp Id</th>
	<th align="left" width="30%">Emp Name</th>
	<th align="left" width="10%">Amount</th>
	<th align="left" width="12%">Cheque No.</th>
	<th align="left" width="15%">Cheque Date</th>
	<th align="left" width="10%">Action</th>
	</tr>
	
	<?php $srno=1; $no=0;
	
	foreach($emplist as $emp){
	//while($emp = mysql_fetch_array($emplist)){
		$chkDtl = $leave->chkLeaveChequeDetails($emp['emp_id'],$payment_date,'L');
		//print_r($chkDtl);
		$cnt = 0;
		$cnt = $chkDtl['emp_id'];
		
		//$chk = mysql_fetch_array($chkDtl);
	$payment_date=$emp['payment_date'];	
	?>
	<tr id="chkdtl<?php echo $srno;?>">
	<td><?php echo $srno; ?></td>
	
	<td><?php echo date("d-m-Y", strtotime($emp['payment_date']));; ?></td>
	
	<td><input name="emp_id[]" type="hidden" value="<?php echo $emp['emp_id'];?>"><?php echo $emp['emp_id'];?></td>
	
	<td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	
	
	 <?php 
	 if($cnt>0){?>
	  <td><input name="amount[]" type="text" value="<?php echo $chkDtl['amount'];?>" class="textclass " id="amt<?php echo $srno;?>"></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkDtl['check_no'];?>" class="textclass " id="chk<?php echo $srno;?>" ></td>
		
		<td><input name="date[]" type="text" value="<?php echo date('d-m-Y',strtotime($chkDtl['date']));?>" class="textclass " id="date<?php echo $srno;?>"></td>
		
		
	 <?php }else {  ?>	
	  
		<td><input name="amount[]" type="text" value='<?php echo $emp['amount'];?>' class="textclass " id="amt<?php echo $srno;?>" readonly></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkno;?>" class="textclass " id="chk<?php echo $srno;?>"> </td>
		
		<td><input name="date[]" type="text" value="<?php echo $checkdate;?>" class="textclass " id="date<?php echo $srno;?>"></td>
	
	
	 <?php $chkno++;}
	$existnum = $cnt;
	?>
	<td><?php if($existnum != 0 && $existnum != ""){?><input type="button" value="Delete" class="btnclass" onclick="deletesingle('<?php echo $chkDtl['chk_detail_id'];?>','<?php echo $srno;?>')" id="delbtn<?php echo $srno;?>"><?php }?></td>
	<!--<td><input type="button" value="Edit" class="btnclass" onclick="editsingle('<?php echo $chk['chk_detail_id'];?>','<?php echo $srno;?>')"></td>-->
	</tr>
	<tr id="chkdtlsucc<?php echo $srno;?>" class="hidecontent">
	<td colspan="9" id="succdtl<?php echo $srno;?>" class="successclass"></td>
	</tr>
	<?php $srno++; $no++;} ?>
	</table>
	
      </div>       
            <div class="clearFix">&nbsp;</div>
			<div>			
<div><input type="submit" value="Save" name="submit" class="btnclass" id="addcheque" > <input type="submit" value="Print All" name="printbtn" class="btnclass"  onclick="printval()">
</div>
            </form>
        </div>
		<div id="test"></div>
		<script>
		$( function() {
            $("#frdt1").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#todt1").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );
		$(document).ready(function() {
    $('#addchkdtl').on('submit',function(){
	
	var chkdt = $("#checkdate").val(); 
	var print1 = $("#print1").val();
	var payment = $("payment_date").val();
	if(chkdt ==""){ 
		$("#checkdateerror1").show();
		$("#checkdateerror1").text("Please Select Date");
		
	}
	;
	
	if(parseInt(print1) == 1){	
		var client = $("#client").val();
		var employee = $("input[name='emp']:checked"). val();
		var empid = $("#empid").val();	
			var chkdt = $("#checkdate").val(); 
var payment = $("#payment_date").val();
		window.location.href="check-leave-print-pre.php?client="+client+"&empid1="+empid+"&checkdate="+chkdt+"&empid="+empid+"&type=L"+"&payment_date ="+payment;
		
	}else{
		$("#chkdate").val(chkdt);
        var form = $(this);
        $.ajax({
            type:'post',
            url:'/add_leave_cheque_details',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
			alert(result);	
			$("#test").text(result);
            }
        });
	}

        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});

function print_cheque(client,emp_id) {

	$.post('/check_leave_print_pre',{
		
		'client':client,
		'empid1':emp_id,
		'type':'L'
		
	},function(data){
		
		alert(data);
	});
}
function deletesingle(id,sr){ alert(id);
	$.post('/delete_print_record',{		
		'id':id		
	},function(data){		
		if(data.trim()==1){
			$("#chkdtlsucc"+sr).show();
			$("#succdtl"+sr).html("Record successfully deleted");
			$("#chk"+sr).val("");
			$("#date"+sr).val("");	
			$("#delbtn"+sr).hide();	
			$("#chkdtl"+sr).css("color","#f00");
			
		}
	});
}
function clear(){
		$("#to_dateerror").hide();
		$("#from_dateerror").hide();
	}
	function validation(){
		clear();
		
	}
		</script>