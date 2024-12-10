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
$client=$_POST['client'];
$period = $userObj->getdates($client);
$period1 = $userObj->getdates($client);


?>



<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Statement</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
<script>
$( function() {
            $("#frdt1").datepicker({
				'client':client,
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
		
		if(document.getElementById("frdt1").value=="")
		{
			     document.getElementById("frdt1").innerHTML="Please enter date";
                 //alert("Please enter payment date");
		         document.form.frdt1.focus();
		return false;	
        }
		return true;
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
        <div class="twelve"><h3>Leave Statement</h3></div>
        <div class="clearFix"></div>
        <form method="post"  name="form" id="form" action="/report-leave-statement.php?client=<?php echo $client ?>" method="post" onsubmit="return validation()">
        <div class="twelve" id="margin1">
		<!-- <div class="three padd0 columns">
            <div class="four padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="eight padd0 columns">
				<input type="hidden" name="pay_type" value="L">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" checked>No
            </div>
			</div>
         -->




<div class="four padd0 columns"  >
			 <div class="five  columns "  id = "prv_to" >
                        <span> Period From </span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="frdt1" id="frdt" class="textclass" value="01-01-2017">
                        <span class="errorclass hidecontent" id="calculationfrmerror"></span>
                    </div>
					
			</div>
			<div class="four padd0 columns"  >
			 <div class="five  columns pdl10p"  id = "prv_to" >
                        <span> Period To</span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="todt1" id="todt" class="textclass" value="31-12-2017">
                        <span class="errorclass hidecontent" id="calculationtoerror"></span>
                    </div>
					
			</div>
		
	
			
			 <!--<input type="" name="frdt1" class="textclass" id="frdt1" placeholder="dd-mm-yyyy"> <span class="errorclass hidecontent" id="from_dateerror"></span></div>
               <div  class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                </div>-->

            </div>
			  <div class="clearFix"></div>
			  
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