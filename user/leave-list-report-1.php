<?php
session_start();
//error_reporting(0);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
$clientid = $_SESSION['clintid'];
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];

$user_id=$_SESSION['log_id'];
$emplist = $userObj->getEmployeeAllDetailsByClientId($clientid,$comp_id,$user_id);
$leavedates = $userObj->getDates($clientid);

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Cheque Printing</title>
  <!-- Included CSS Files -->

	
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
    function changeemp(val){

        if(val=='random'){            
			$("#showemp").show();
			$("#manualchequeprint").hide();
			$("#subbtn").show();
			$("#printManual").hide();			
        }		
        else if(val=='all')
        {$("#showemp").hide();	
			$("#manualchequeprint").hide(); 
			$("#subbtn").show();
			$("#printManual").hide();
			$("#empid").val('');
        }else if(val=='manual'){
			$("#showemp").hide();	
			$("#manualchequeprint").show();
			$("#subbtn").hide();
			$("#printManual").show();
			
		}
    }
    function showTabdata(id,name){

        $.post('/display_employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;			
			//getEmp(id);
        });

    }


    function serachemp(val){
		var clientid = '<?php echo $clientid; ?>';
        $.post('/display_employee2', {
            'name': val,
			'clientid':clientid
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();			
        });
    }
	function getEmp(id){ alert(id);
		$.post('/get_cheque_emp', {
            'empid': id
        }, function (data) {          
		   $("#emplist").html(data);
        });
	}

</script>
</head>
 <body>

<!--Header starts here-->
<?php //include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php //include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Leave Detail List</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/report_leave_list_1" >

        <div class="twelve" id="margin1">

		<div class="clearFix">&nbsp;</div>
			 <div class="four padd0 columns">
			<div class="four padd0 columns pdl10p">Payment Date</div>
			        <div class="six padd0 columns"><span>
					<select class="textclass" name="payment_date" id="payment_date" >
						<option value="">--Select--</option>
						<?php while($row1=mysql_fetch_array($leavedates)){?>
							<option value="<?php echo $row1['payment_date']; ?>"><?php echo date("d-m-Y",strtotime($row1['payment_date'])); ?></option>
						<?php } ?>

					</select>
				</span></div>
                <span class="errorclass hidecontent" id="nerror"></span>
			  <div class="clearFix">&nbsp; </div>
			  <div class="three padd0 columns" ></div>
			  <div class="two padd0 columns" >
			  <input type="submit" name="submit" id="submit" value="Print" class="btnclass">

			  <!--<input type="button" value="Show" class="btnclass" onclick="showList()" id="subbtn"> <input type="button" value="Print" class="btnclass" onclick="printManual()" id="printManual" style="display:none">-->	</div>
				
			  <div class="clearFix">&nbsp;</div>
			   <div id="chlist">
			 
				</div>
</div>

</div>
</form>
</div>

<!--Slider part ends here-->
<div class="clearFix"></div>
<div id="test"></div>
<!--footer start -->
<?php //include('footer.php');?>

<script>
	 	$( function() {
            $("#checkdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });           
        } );
	</script>
<!--footer end -->
<script>


function editsingle(id,srno){
	
	var amt =$("#amt"+srno).val();
	var checkno =$("#chk"+srno).val();
	document.getElementById("chk"+srno).readOnly = false;
	$.post('/edit_checkdetails', {
            'id': id,
			'amt':amt,
			'checkno':checkno
        }, function (data) {
			//$("#emplist").load(document.URL +  ' #chkdtllst');			
           $("#chkdtlsucc"+srno).show();
		   $("#succdtl"+srno).html("Record successfully updated!");
		   
        });
}

	function printval(){
		$("#print1").val(1);
	}
	function clear(){
		$("#to_dateerror").hide();
		$("#from_dateerror").hide();
		 $("#checkdateerror1").hide();
	}
	 function showList(){
		 clear();
		var frm = $("#frdt1").val();
		var todt1 = $("#todt1").val();
		 var checkdate = $("#checkdate").val();
		 var checkn = $("#checkn").val();
		 var empid1 = $("#empid").val();
		 
		 if(frm ==""){
			 $("#from_dateerror").show();
			 $("#from_dateerror").text("Please select from date");
			 return false;
		 }else if(todt1 ==""){
			 $("#to_dateerror").show();
			 $("#to_dateerror").text("Please select from date");
			 return false;
		 }else if(checkdate ==""){
			 $("#checkdateerror1").show();
			 $("#checkdateerror1").text("Please select date");
		 }
		
		 		 
		 $.post('/leave_chklistdtl', {
			 'checkn': checkn,
			 'checkdt':checkdate,
             'empid1':empid1,
			 'from':frm,
			 'to':todt1
	 
		}, function (data) {					
		   $("#chlist").html(data);		  
		   
		});
	 }
	function printManual(){
		var nameman = $("#nameman").val();
		var amountman = $("#amountman"). val();
		var chkdt = $("#checkdate").val();
		
		window.location.href="check-print-pre.php?nameman="+nameman+"&amountman="+amountman+"&checkdate="+chkdt;
	}
</script>

</body>

</html>