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



  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">



<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Report Random Payslip</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/report_periodwise_random_payslip_page"   onsubmit ="return validation()">
        <div class="twelve" id="margin1">
            <div class="two  padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
           
            <div class="four padd0 columns">
			<input type="hidden" value="" name="eid" id="eid">
			<input type="text" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>
			
            <div class="clearFix"></div>




             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

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


<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>
<script>
 function serachemp(val){
        $.post('/display_employee3', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
function showTabdata(id,name){

   $.post('/display_employee', {
	   'id': id
   }, function (data) {
	   $('#searching').hide();
	   $('#displaydata').html(data);
	   $('#name').val(name);
	   $('#displaydata').show();
	   $("#eid").val(id);
	   document.getElementById('empid').value=id;
		//refreshconutIncome(id);
   });

}
function validation(){
	var nm = $("#name").val();
	
	if(nm ==""){
		$("#errinm").show();
		$("#errinm").text("Please select Employee ");
		return false;
	}else{
		$("#errinm").hide();
	}
}
	</script>



