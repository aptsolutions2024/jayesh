<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
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
  <title>Report | NEFT</title>
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

        $.get('/display_employee', {
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
        $.get('/display_employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
function clear(){
		$("#to_dateerror").hide();
		$("#from_dateerror").hide();
	}
	function validation(){
		clear();
		var frm = $("#frdt1").val();
		var todt1 = $("#todt1").val();
		
		 if(frm ==""){
			 $("#from_dateerror").show();
			 $("#from_dateerror").text("Please select from date");
			 return false;
		 }else if(todt1 ==""){
			 $("#to_dateerror").show();
			 $("#to_dateerror").text("Please select from date");
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
        <div class="twelve"><h3>Emerson Transfer</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/export_leave_emerson_transfer_format" method="post">
        <div class="twelve" id="margin1">
		<div class="three padd0 columns">
            <div class="four padd0 columns">
                <span class="labelclass1">Parent :</span>
				<input type="hidden" name="pay_type" value="L">
            </div>
            <div class="eight padd0 columns">
                <input type="radio" name="emp" value="Parent"  >Yes
                <input type="radio" name="emp" value="no" checked >No
            </div>
			</div>
            <div class="four padd0 columns">
			<div class="four  columns pdl10p">From Date</div>
			<div class="eight padd0 columns"><input type="text" name="from_date" class="textclass" id="frdt1"> <span class="errorclass hidecontent" id="from_dateerror"></span></div>
               
            </div>
            <div class="four  padd0 columns">
				<div class="four  columns pdl10p">To Date</div>
				<div class="eight padd0 columns"><input type="text" name="to_date" class="textclass" id="todt1"><span class="errorclass hidecontent" id="to_dateerror"></span></div>
            </div>
            <div class="clearFix"></div>



             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
<!--                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="reportpayslip();">-->
                <input type="submit" name="submit" id="submit" value="Export" class="btnclass">
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