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
$period = $userObj->getdates($clientid);$tab_emp ="leave_details";

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Cheque Printing</title>
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
	function getEmp(id){ 
		$.post('/get_cheque_emp', {
            'empid': id
        }, function (data) {          
		   $("#emplist").html(data);
        });
	}
	function setcheckno(no){
		
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
        <div class="twelve"><h3>Leave Cheque Printing</h3></div>
        <div class="clearFix"></div>
        
        <div class="twelve" id="margin1">
            <div class="three padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="three padd0 columns">
                <input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked>All
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" >Random
				<input type="radio" name="emp" value="manual" onclick="changeemp(this.value);" >Manual
            </div>
            <div class="four padd0 columns">
                <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                </div>

            </div>
			
            <div class="one  padd0 columns">

            </div>
			
            <div class="clearFix">&nbsp;</div>
			 <div class="four padd0 columns">
			<div class="four padd0 columns pdl10p">Payment Date</div>
			<div class="eight padd0 columns">
					   <select name="payment_date" id = "payment_date" class="textclass"  >
		   <option value="">-- Select Date --</option>
		   <?php while($type = mysql_fetch_assoc($period)){?>
		   <option value="<?php echo $type['payment_date'];?>"><?php echo date('d-m-Y',strtotime($type['payment_date']));?></option>
		   <?php }?>
		   </select>

			
			  </div>
          
		<!--	<input type="text" name="from_date" class="textclass" id="frdt1"> <span class="errorclass hidecontent" id="from_dateerror"></span></div>
               
            <div class="four  padd0 columns">
				<div class="four  columns pdl10p">To Date</div>
				<div class="eight padd0 columns"><input type="text" name="to_date" class="textclass" id="todt1"><span class="errorclass hidecontent" id="to_dateerror"></span></div>
            </div>-->
		<div class="clearFix">&nbsp;</div>
			  <!-- for manual cheque printing -->
			  <span id="manualchequeprint" style="display:none">
				<div class="four padd0 columns">
				<div class="four padd0 columns pdl10p"> Name :	</div>
				<div class="eight padd0 columns"><input type="text" name="name" id="nameman" class="textclass">
				 <span class="errorclass hidecontent" id="namemanerror1"></span>
				</div>
				</div>
				<div class="four padd0 columns">				 
				 <div class="four columns pdl10p"> Amount :	</div>
				<div class="eight padd0 columns"><input type="text" name="amount" id="amountman" class="textclass">
				 <span class="errorclass hidecontent" id="amountmanerror1"></span>
				</div>
				
				 </div>
				 <div class="clearFix">&nbsp;</div>
				 </span>
				  
				 <!-- end for manual cheque printing --->
				 <span id="date" >
				 <div class="six padd0 columns">
			  <div class="six padd0 columns pdl10p"> Date :	</div>
				<div class="six padd0 columns"><input type="text" name="checkdate" id="checkdate" class="textclass">
				 <span class="errorclass hidecontent" id="checkdateerror1"></span>
				</div>
				
			  <div class="clearFix">&nbsp; </div>
				 
			  
			  </div>
			  </span>
			  <span id="checkno" >
			  <div class="six padd0 columns">
			  <div class="six  columns pdl10p"> Cheque no :	</div>
				<div class="six padd0 columns"><input type="text" name="checkn" id="checkn" class="textclass" onkeyup="setcheckno(this.value)">
				 <span class="errorclass hidecontent" id="checknerror1"></span>
				</div>
				 </div>
				 </span>
			  <div class="clearFix">&nbsp; </div>
			  <div class="three padd0 columns" ></div>
			  <div class="two padd0 columns" ><input type="button" value="Show" class="btnclass" onclick="showList()" id="subbtn"> <input type="button" value="Print" class="btnclass" onclick="printManual()" id="printManual" style="display:none">	</div>
				</div>
			  <div class="clearFix">&nbsp;</div>
			   <div id="chlist">
			 
				</div>
</div>
</div>
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
		var payment_date = $("#payment_date").val();
		//alert(payment_date);
		 var checkdate = $("#checkdate").val();
		 var checkn = $("#checkn").val();
		 var empid1 = $("#empid").val();
		 
		 
		
		 		 
		 $.post('/leave_chklistdtl', {
			 'checkn': checkn,
			 'checkdt':checkdate,
             'empid1':empid1,
			 'payment_date':payment_date		
		}, function (data) {					
		   $("#chlist").html(data);		  
		   
		});
	 }
	function printManual(){
		var nameman = $("#nameman").val();
		var amountman = $("#amountman"). val();
		var payment_date = $("#payment_date").val();
		alert(payment_date);
			var chkdt = $("#checkdate").val();
		window.location.href="check-leave-print-pre.php?nameman="+nameman+"&amountman="+amountman+"&checkdate="+chkdt+"&payment_date="+payment_date;
	}
</script>

</body>

</html>