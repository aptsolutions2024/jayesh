<?php 
 error_reporting(0);
 $chkno = $_POST['checkn'];
 $checkdate = $_POST['checkdt'];
 session_start();
  ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
 //include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$month=$_SESSION['month'];
$clientid = $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);
 $cmonth=$resclt['current_month'];
$type = "B";
 echo $empid1 = $_POST['empid1'];

    $tab_emp='bonus';
    if(isset($_SESSION['startbonusyear'])){
$startday = $_SESSION['startbonusyear'];
}else{
 $startday ="";   
}
if(isset($_SESSION['endbonusyear'])){
$endday = $_SESSION['endbonusyear'];
}else{
   $endday =""; 
}
if ($empid1 >0 )

{$emplist = $userObj->getBonusChequeEmployeeByEmpId($empid1,$startday,$endday);
}
else{
	$empid1= 0;
	
$emplist = $userObj->getBonusChequeEmployeeByClientId($clientid,$tab_emp,$startday,$endday);

}
 ?>
 <form method="post"  method="post" action="/add_bonus_cheque_details" id="addchkdtl" >
			  <input type="hidden" value="" id="chkdate" name="chkdate">
			  <input type="hidden" value="" name="print1" id="print1">
			  <input type="hidden" value="<?php echo $cmonth;?>" id="cmonth" name="cmonth">
			  <div id="chkdtllst">
			  
			
	<table width="100%" style="background-color:#fff" id="emplist">

	<tr>
	<th align="left" width="5%">Sr No</th>
	<th align="left" width="10%">Period</th>
	<th align="left" width="5%">Emp Id</th>
	<th align="left" width="30%">Emp Name</th>
	<th align="left" width="10%">Amount</th>
	<th align="left" width="12%">Cheque No.</th>
	<th align="left" width="15%">Cheque Date</th>
	<th align="left" width="10%">Action</th>
	</tr>
	
	<?php $srno=1; $no=0;
	while($emp = $emplist->fetch_array()){
		$chkDtl = $userObj->chkBonusDetails($emp['emp_id'],$startday,$endday,'B');
		$cnt = 0;
		$cnt = mysqli_num_rows($chkDtl);	
		 $chk = $chkDtl->fetch_array();
	?>
	<tr id="chkdtl<?php echo $srno;?>">
	<td><?php echo $srno; ?></td>
	
	<td><?php echo date("M, Y", strtotime($startday))." TO ". date("M, Y", strtotime($endday)); ?></td>
	
	<td><input name="emp_id[]" type="hidden" value="<?php echo $emp['emp_id'];?>"><?php echo $emp['emp_id'];?></td>
	
	<td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	
	
	 <?php 
	 if($cnt>0){?>
	  <td><input name="amount[]" type="text" value="<?php echo $chk['amount'];?>" class="textclass " id="amt<?php echo $srno;?>"></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chk['check_no'];?>" class="textclass " id="chk<?php echo $srno;?>" ></td>
		
		<td><input name="date[]" type="text" value="<?php echo date('d-m-Y',strtotime($chk['date']));?>" class="textclass " id="date<?php echo $srno;?>"></td>
		
		
		<td><input type="button" value="Delete" class="btnclass" onclick="deletesingle('<?php echo $chk['chk_detail_id'];?>','<?php echo $srno;?>')" id="delbtn<?php echo $srno;?>"></td>
	
		
		
	 <?php }else {  ?>	
	  
		<td><input name="amount[]" type="text" value='<?php echo $emp['amount'];?>' class="textclass " id="amt<?php echo $srno;?>" readonly></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkno;?>" class="textclass " id="chk<?php echo $srno;?>"> </td>
		
		<td><input name="date[]" type="text" value="<?php echo $checkdate;?>" class="textclass " id="date<?php echo $srno;?>"></td>
	
	
	 <?php $chkno++;}
	//$existnum = $userObj->checkExistChequeDetails($emp['emp_id'],$sal_month,$type);
	?>
	</tr>
	<tr id="chkdtlsucc<?php echo $srno;?>" class="hidecontent">
	<td colspan="9" id="succdtl<?php echo $srno;?>" class="successclass"></td>
	</tr>
	<?php $srno++; $no++;} ?>
	</table>
      </div>       
            <div class="clearFix">&nbsp;</div>
			<div>			
<div><input type="submit" value="Save" name="submit" class="btnclass" id="addcheque" >
	 <input type="submit" value="Print All" name="printbtn" class="btnclass"   onclick="printval()" >
	 <input type="submit" value="Export" name="exportbtn" class="btnclass" onclick = "export1();" >
</div>
            </form>
        </div>
		<script>
		$(document).ready(function() {
    $('#addchkdtl').on('submit',function(){
	
	var chkdt = $("#checkdate").val(); 
	var print1 = $("#print1").val();
	alert(print1);
	if(chkdt ==""){ 
		$("#checkdateerror1").show();
		$("#checkdateerror1").text("Please Select Date");
		
	}
	;
	
	if(parseInt(print1) == 1){	
		
		var client = $("#client").val();
		var employee = $("input[name='emp']:checked"). val();
		var empid = $("#empid").val();		
		window.location.href="check_print_pre?client="+client+"&empid1="+empid+"&checkdate="+chkdt+"&empid="+empid+"&type=B";
		
	}
	else if(parseInt(print1) == 2){	
		var client = $("#client").val();
		alert(client);
		var employee = $("input[name='emp']:checked"). val();
		var empid = $("#empid").val();	
			var type = 'B';
		window.location.href="export_chequelist?client="+client+"&empid1="+empid+"&checkdate="+chkdt+"&empid="+empid+"&type="+type;
		
	}else{
	
		$("#chkdate").val(chkdt);
        var form = $(this);
        /*$.ajax({
            type:'post',
            url:'/add_bonus_cheque_details',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
				
			$("#test").text(result);
            }
        });*/
	}

        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});


	function printval(){
		$("#print1").val(1);
	}

function print_cheque(client,emp_id) {

/*	$.post('/check_print_pre',{
		
		'client':client,
		'empid1':emp_id,
		'type':'B'
		
	},function(data){
		
		
	});*/
}
function deletesingle(id,sr){ 
/*	$.post('/delete_print_record',{		
		'id':id		
	},function(data){		
		if(data.trim()==1){
			$("#chkdtlsucc"+sr).show();
			$("#succdtl"+sr).html("Record Successfully deleted");
			$("#chk"+sr).val("");
			$("#date"+sr).val("");	
			$("#delbtn"+sr).hide();	
			$("#chkdtl"+sr).css("color","#f00");
			
		}
	});*/
}

		</script>