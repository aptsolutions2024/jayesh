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
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">


<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>GST Statement</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/report_gst_statement_page" method="post" onsubmit="return validation()">
        <div class="twelve" id="margin1">
            <div class="four padd0 columns">
				<div class="four padd0 columns">
					<span class="labelclass1 pdl10p">Parent :</span>
				</div>
				<div class="eight padd0 columns">
					<input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" checked>Yes
					<input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" >No
				</div>
			</div>
            <div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Invoice No :</span>
				</div>
				<div class="eight padd0 columns">
				<span ><input type="text" value="" name="invoice" class="textclass" id="invoice"><div id="errinv" class="errorclass hidecontent"></div></span>
				</div>
            </div>
			 
			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Date (%):</span>
				</div>
				<div class="eight padd0 columns">
				<span ><input type="text" name="invdate" id="invdate" class="textclass"><div id="errinvdt"class="errorclass hidecontent"></div></span>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> PF (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="pf" id="pf" class="textclass" value="13.15"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> ESI (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="esi" id="esi" class="textclass" value="4.75"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> GST (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="gst" id="gst" class="textclass" value="9"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Income:</span>
				</div>
				<div class="eight padd0 columns">include in service charge:<br> <input type="radio" name="includinc" value="Y" checked> Yes  <input type="radio" name="includinc" value="N" > No</div>
				</div>
            
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Text 1:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="inctext1field" id="inctext1field" class="textclass" value=""></div>
				</div>
           
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> amount:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="inctext1" id="inctext1" class="textclass" value=""></div>
				</div>
            <div class="clearFix"></div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> </span>
				</div>
				<div class="eight padd0 columns"></div>
				</div>
            
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Text 2:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="inctext2field" id="inctext2field" class="textclass" value=""></div>
				</div>
           
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> amount:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="inctext2" id="inctext2" class="textclass" value=""></div>
				</div>
            <div class="clearFix">&nbsp;</div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Deduction:</span>
				</div>
				<div class="eight padd0 columns"></div>
				</div>
            
			
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Text 1:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="dedtext1text" id="dedtext1text" class="textclass" value=""></div>
				</div>
            
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Amount:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="dedtext1" id="dedtext1" class="textclass" value=""></div>
			</div>
			<div class="clearFix">&nbsp;</div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"></span>
				</div>
				<div class="eight padd0 columns"></div>
				</div>
            
			
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Text 2:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="dedtext2text" id="dedtext2text" class="textclass" value=""></div>
				</div>
            
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Amount:</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="dedtext2" id="dedtext2" class="textclass" value=""></div>
			</div>
            
           <!--
			<div class="one padd0 columns">
               
            </div>
			<div class="two padd0 columns">
                <span class="labelclass1">Date :</span>
            </div>
            <div class="two padd0 columns">
                <input type="text" name="frdt" id="frdt" class="textclass hasDatepicker">
            </div>-->
			
			
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
$( function() {                
				
	$("#invdate").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'dd-mm-yy'
	});
	
} );
function validation(){
	var invoice = $("#invoice").val();
	var invdate = $("#invdate").val();
	if(invoice ==""){
		$("#errinv").show();
		$("#errinv").text("Please Enter Invoice No.");
		return false;
	}else{$("#errinv").hide();
	
	}
	if(invdate ==""){
		$("#errinvdt").show();
		$("#errinvdt").text("Please Enter Invoice Date.");
		return false;
	}else{
		$("#errinvdt").hide();
	}
}
</script>




