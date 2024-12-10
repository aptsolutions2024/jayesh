<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Bank</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
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

        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
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

        });

    }
    function serachemp(val){
        $.post('/display_employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
	function validation(){
		var frm = $("#frdt1").val();
		var todt1 = $("#todt1").val();
		var pay_type = $("pay_type").val();
		var payment_date = $("payment_date").val();
		 if(payment_date ==""){
			 $("#from_dateerror").show();
			 $("#from_dateerror").text("Please select Payment date");
			 return false;
		 }
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
        <div class="twelve"><h3>Leave Salary Bank</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/report_leave_bank_salary" onsubmit="return validation()">
        <div class="twelve" id="margin1">
		<div class="three padd0 columns">
            <div class="four padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="eight padd0 columns">
				<input type="hidden" name="pay_type" value="L">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" checked>No
            </div>
			</div>
			<div class="clearFix"></div>
            <!-- <div class="four padd0 columns">-->
			<div class="three  columns pdl10p">Payment Date</div>
			<div class="two padd0 columns"><input type="text" name="payment_date" class="textclass" id="frdt1"> <span class="errorclass hidecontent" id="from_dateerror"></span></div>
                <!--<div  class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                </div>-->

           <!-- </div>-->
		   
            <div class="four  padd0 columns" style= "display:none;"  >
				<div class="four  columns pdl10p">To Date</div>
				<div class="eight padd0 columns"><input type="text" name="to_date" class="textclass" id="todt1"><span class="errorclass hidecontent" id="to_dateerror"></span></div>
            </div>
            <div class="clearFix"></div>
<div class="clearFix"><br></div>
           
 <div class="three padd0 columns"> Date :	</div>
				<div class="two padd0 columns"><input type="text" name="checkdate" id="checkdate" class="textclass">
				 <span class="errorclass hidecontent" id="checkdateerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
				 
			  <div class="clearFix">&nbsp;</div>
			  </span>
			  <span id="checkno" >
			  <div class="three padd0 columns"> Cheque no :	</div>
				<div class="two padd0 columns"><input type="text" name="checkn" id="checkn" class="textclass" onkeyup="setcheckno(this.value)">
				 <span class="errorclass hidecontent" id="checknerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
				 </span>
			  <div class="clearFix">&nbsp; </div>
			  <div class="three padd0 columns" ></div>
			 

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
<!--                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="reportpayslip();">-->
                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>






        <div class="clearFix"></div>






        </div>





</div>

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php //include('footer.php');?>


<!--footer end -->

</body>

</html>