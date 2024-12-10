<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/common.php");

$userObj=new user();
$common=new common();

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//$result1=$userObj->showClient1($comp_id,$user_id);
$allemclient = $common->showEmersionClient($comp_id,$user_id);
$cl = "12";
$resclt=$userObj->displayClient($cl);
$cmonth=$resclt['current_month'];




?>
<!DOCTYPE html>
 <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
 
<script>
        $( function() {
            $("#frdt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            /*$("#todt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });*/
        } );
    </script>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Report | Emerson Bill</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
	
	<script type="text/javascript" src="../js/jquery-ui.js"></script>

</head>
 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php include('menu.php');


?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg" >
 <div class="clearFix">&nbsp;</div>

    <div class="row">
	<div class="twelve" id="margin1"><h3>Emerson Bill </h3></div>
	 <form method="post"  action ="/emerson_bill_process" id="emersionbill" onsubmit="return validation();"> 
	 <input type="hidden" name="gendata" value="0" id="gendata">
	 <input type="hidden" name="gendata" value="0" id="printtype">
	 <div class="six columns">		
          <div class="three columns">Client</div>
		  <div class="nine columns"><select name="client" class="textclass" id="client"  onchange="saveclint();">
		  <option value="">Select Client</option>
		  <?php foreach($allemclient as $client){?>
		  <option value="<?php echo $client['mast_client_id']; ?>"><?php echo $client['client_name'];?></option>
		  <?php }?>
		  </select><span class="errorclass hidecontent" id="clienterror"></span></div>
        </div>
		
		 <div id="showPrevious" >
                    <div class="one paddt0 columns" align="center">
                        Date 
                    </div>
                    <div class="two paddt0 columns">
                        <input type="text" name="frdt" id="frdt" class="textclass" value = "<?php echo date('d-m-Y',strtotime($cmonth));?>" >
                        <span class="errorclass hidecontent" id="fderror"></span>
                    </div>
               </div>
		
		<div class="clearFix"></div>
        <div class="three columns padd0">		
          <div class="five columns">Spl. Allow</div>
		  <div class="seven columns"><input class="textclass" type="text" name="splallow" id="splallow" value=""><span class="errorclass hidecontent" id="splallowerror"></span></div>
        </div>
        <div class="three columns padd0">
			<div class="five columns"  >PF (%)</div>
			<div class="seven columns"  ><input class="textclass" type="text" name="pf" id="pf"  value="13.00"><span class="errorclass hidecontent" id="pferror"></span></div>
        </div>        
        <div class="three  columns padd0">
			<div class="five columns">Bonus (%)</div>
			<div class="seven columns"><input class="textclass" type="text"  name="bonus" id="bonus"  value="8.33"><span class="errorclass hidecontent" id="bonuserror"></span></div>
        </div>
		<div class="three  columns padd0">
			<div class="five columns">ESI( %)</div>
			<div class="seven columns"><input class="textclass" type="text" name="esi" id="esi" value="3.0"><span class="errorclass hidecontent" id="esierror"></span></div>
        </div>
		<div class="clearFix"></div>
		<div class="three columns padd0">		
          <div class="five columns">LWW (%)</div>
		  <div class="seven columns"><input class="textclass" type="text" name="lww" id="lww"  value="1.3"><span class="errorclass hidecontent" id="lwwerror"></span></div>
        </div>
        <div class="three columns padd0">
			<div class="five columns" >LWF</div>
			<div class="seven columns"  ><input class="textclass" type="text" name="lwf" id="lwf"  value="0.25"><span class="errorclass hidecontent" id="lwferror"></span></div>
        </div>        
        <div class="three  columns padd0" >
			<div class="five columns" >Safety Appl.</div>
			<div class="seven columns" ><input class="textclass" type="text" name="safetyapp" id="safetyapp"  value="7.60"><span class="errorclass hidecontent" id="safetyapperror"></span></div>
        </div>
		<div class="three  columns padd0">
			<div class="five columns">Other charg.</div>
			<div class="seven columns" ><input class="textclass" type="text" name="other" id="other"  value="19.15"><span class="errorclass hidecontent" id="othererror"></span></div>
        </div>
		<div class="clearFix"></div>
		<div class="three columns padd0" >		
          <div class="five columns" >Train. Charg.</div>
		  <div class="seven columns" ><input class="textclass" type="text" name="trainingcharg" id="trainingcharg"  value="0.75"><span class="errorclass hidecontent" id="trainingchargerror"></span></div>
        </div>
        <div class="three columns padd0">
			<div class="five columns">TDS (%)</div>
			<div class="seven columns"><input class="textclass" type="text" name="tds" id="tds"  value="2.25"><span class="errorclass hidecontent" id="tdserror"></span></div>
        </div> 
		<div class="clearFix"></div>
		 <div class="three columns padd0">
			<div class="five columns">Invoice No.</div>
			<div class="seven columns"><input class="textclass" type="text" name="invno" id="invno"  value=""><span class="errorclass hidecontent" id="invnoerror"></span></div>
        </div> 
		 <div class="three columns padd0">
			<div class="five columns">Date</div>
			<div class="seven columns"><input class="textclass" type="text" name="invdate" id="invdate"  value="" ><span class="errorclass hidecontent" id="invdateerror"></span></div>
        </div> 
		 <div class="three columns padd0">
			<div class="five columns">Monthly Sup. Charges</div>
			<div class="seven columns"><input class="textclass" type="text" name="monthlysupcharge" id="monthlysupcharge"  value="15000"><span class="errorclass hidecontent" id="monthlysupchargeerror"></span></div>
        </div> 
		 <div class="three columns padd0">
			<div class="five columns">Fixed Service Charge (%)</div>
			<div class="seven columns"><input class="textclass" type="text" name="fixedsercharg" id="fixedsercharg"  value="3"><span class="errorclass hidecontent" id="fixedserchargerror"></span></div>
        </div> 
		<div class="clearFix"></div>
		 <div class="three columns padd0">
			<div class="five columns">CGST (%)</div>
			<div class="seven columns"><input class="textclass" type="text" name="cgst" id="cgst"  value="9"><span class="errorclass hidecontent" id="cgsterror"></span></div>
        </div> 
		 <div class="three columns padd0">
			<div class="five columns">SGST (%)</div>
			<div class="seven columns"><input class="textclass" type="text" name="sgst" id="sgst"  value="9"><span class="errorclass hidecontent" id="sgsterror"></span></div>
        </div> 
		 <div class="three columns padd0">
			<div class="five columns">IGST (%)</div>
			<div class="seven columns"><input class="textclass" type="text" name="igst" id="igst"  value="0"><span class="errorclass hidecontent" id="igsterror"></span></div>
        </div> 
		
		

 <div class="three columns text-right">
			<div class="twelve columns">
			</div>
        </div> 		
       
        <div class="clearFix">&nbsp;</div>
		<div class="twelve padd0 columns">
			<div id="success1" class="hidecontent " ><div class="success31">Data Generated Successfully!</div></div>
			</div>
		<input type="button" name="Generate Data" value="Generate Data" onclick="genratedata()" class="btnclass" style ="display:none"> &nbsp; 
		<input type="button"  name="Print Dept Wise" value="Print Dept Wise" onclick="printData(1)" class="btnclass"> &nbsp;
		<!-- <input type="button" name="Print Desg Wise" value="Print Desg Wise" onclick="printData(2)" class="btnclass"> &nbsp;
		<input type="button" name="Print Client + Dept Wise" value="Print Client + Dept Wise" onclick="printData(3)" class="btnclass">
		 -->
		 <input type="button" width = "180px!important"name="Print Dept+Desg Wise" value="Print Dept+Desg. Wise" onclick="printData(4)" class="btnclass">
		<input type="button" width = "180px!important"name="Print AMP" value="Print AMP" onclick="printData(5)" class="btnclass">
		<input type="button" width = "180px!important" name="Print Summary" value="Print Summary" onclick="printData(6)" class="btnclass">
		<input type="button" width = "180px!important" class="btnclass" name="Submit" value="Annexture-Bill" onclick="printData(7)">
		<input type="button" width = "180px!important" class="btnclass" name="Submit" value="Annexture-Bill(Excel)" onclick="printData(8)">
			</form>

<div id="displaydata">

</div>
    </div>
<br/>

</div>
<div class="clearFix"></div>

<!--Slider part ends here-->

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
<script>


 function saveclint(){
	 
       var client = $("#client").val();
	     
		if (client==12)
		{
		$("#splallow").val('');
		$("#pf").val('13');
		$("#bonus").val('8.33');
		$("#esi").val('4.75') ;
		$("#lww").val('1.3');
		$("#lwf").val('0.25') ;
		 $("#safetyapp").val('7.44');
		$("#other").val('0.0');
		 $("#trainingcharg").val('0.75') ;
		$("#tds").val('2.00');
		 $("#monthlysupcharge").val('30000') ;
		}
		else if (client==14)
		{
			$("#splallow").val('');
		$("#pf").val('13');
		$("#bonus").val('8.33');
		$("#esi").val('4.75') ;
		$("#lww").val('1.3');
		$("#lwf").val('0.25') ;
		 $("#safetyapp").val('7.44');
		$("#other").val('0.0');
		 $("#trainingcharg").val('0.75') ;
		 $("#monthlysupcharge").val('30000') ;
		
		$("#tds").val('2.00');
		}
		else if (client==15)
		{
		$("#splallow").val('');
		$("#pf").val('13');
		$("#bonus").val('8.33');
		$("#esi").val('4.75') ;
		$("#lww").val('1.3');
		$("#lwf").val('0.25') ;
		 $("#safetyapp").val('7.6');
		$("#other").val('19.15');
		 $("#trainingcharg").val('0.75') ;
		$("#tds").val('2.25');
			 $("#monthlysupcharge").val('15000') ;
		}
		else if (client==16)
		{
		$("#splallow").val('');
		$("#pf").val('13');
		$("#bonus").val('8.33');
		$("#esi").val('4.75') ;
		$("#lww").val('1.3');
		$("#lwf").val('0.25') ;
		 $("#safetyapp").val('7.6');
		$("#other").val('19.15');
		 $("#trainingcharg").val('0.75') ;
		$("#tds").val('2.25');
		 $("#monthlysupcharge").val('15000') ;
		}
		
			
 }
function genratedata (){
	$("#gendata").val('1');
	validation();
	
}
function remgenratedata(){
	$("#gendata").val('0');
}
function printData(id){
	// 1 for deptwise
// 2 for designation wise
// 3 for dept + client wise
$("#gendata").val('1');
	$("#printtype").val(id);
	validation();
}
	function valClear(){
		$("#clienterror").text('');
		$("#splallowerror").text('');
		$("#pferror").text('');
		$("#bonuserror").text('');
		$("#esierror").text('');
		$("#lwwerror").text('');
		$("#lwferror").text('');
		$("#safetyapperror").text('');
		$("#othererror").text('');
		$("#trainingchargerror").text('');
		$("#tdserror").text('');
		$("#invnoerror").text('');
		$("#invdateerror").text('');
		$("#cgsterror").text('');
		$("#sgsterror").text('');
		$("#igsterror").text('');
	}
	function validation(){
		valClear();
		var client = $("#client").val();
		var splallow = $("#splallow").val();
		var pf = $("#pf").val();
		var bonus = $("#bonus").val();
		var esi = $("#esi").val();
		var lww = $("#lww").val();
		var lwf = $("#lwf").val();
		var safetyapp = $("#safetyapp").val();
		var other = $("#other").val();
		var trainingcharg = $("#trainingcharg").val();
		var tds = $("#tds").val();
		var invno = $("#invno").val();
		var invdate = $("#invdate").val();
		var cgst = $("#cgst").val();
		var sgst = $("#sgst").val();
		var igst = $("#igst").val();
		var gndata = $("#gendata").val();
		var printtype = $("#printtype").val();
		var fixedsercharg = $("#fixedsercharg").val();
		var monthlysupcharge = $("#monthlysupcharge").val();
		var frdt = document.getElementById('frdt').value;
             
		if(client==""){
			$("#clienterror").show();
			$("#clienterror").text("Please select Client");
			return false;
		}else if(splallow==""){
			$("#splallowerror").show();
			$("#splallowerror").text("Please enter Special Allowances");
			return false;
		}else if(isNaN(splallow)==true){
			$("#splallowerror").show();
			$("#splallowerror").text("Please enter valid Special Allowances");
			return false;
		}else if(pf==""){
			$("#pferror").show();
			$("#pferror").text("Please enter PF");
			return false;
		}else if(isNaN(pf)==true){
			$("#pferror").show();
			$("#pferror").text("Please enter valid PF");
			return false;
		}else if(bonus==""){
			$("#bonuserror").show();
			$("#bonuserror").text("Please enter Bonus");
			return false;
		}else if(isNaN(bonus)==true){
			$("#bonuserror").show();
			$("#bonuserror").text("Please enter valid Bonus");
			return false;
		}else if(esi==""){
			$("#esierror").show();
			$("#esierror").text("Please select ESI");
			return false;
		}else if(isNaN(esi)==true){
			$("#esierror").show();
			$("#esierror").text("Please select valid ESI");
			return false;
		}else if(lww==""){
			$("#lwwerror").show();
			$("#lwwerror").text("Please select LWW");
			return false;
		}else if(isNaN(lww)==true){
			$("#lwwerror").show();
			$("#lwwerror").text("Please select valid LWW");
			return false;
		}else if(lwf==""){
			$("#lwferror").show();
			$("#lwferror").text("Please select LWF");
			return false;
		}else if(isNaN(lwf)==true){
			$("#lwferror").show();
			$("#lwferror").text("Please select valid LWF");
			return false;
		}else if(safetyapp==""){
			$("#safetyapperror").show();
			$("#safetyapperror").text("Please enter Safety appliances");
			return false;
		}else if(isNaN(safetyapp)==true){
			$("#safetyapperror").show();
			$("#safetyapperror").text("Please enter valid Safety appliances");
			return false;
		}else if(other==""){
			$("#othererror").show();
			$("#othererror").text("Please enter Other");
			return false;
		}else if(isNaN(other)==true){
			$("#othererror").show();
			$("#othererror").text("Please enter valid Other");
			return false;
		}else if(trainingcharg==""){
			$("#trainingchargerror").show();
			$("#trainingchargerror").text("Please enter Training Charges");
			return false;
		}else if(isNaN(trainingcharg)==true){
			$("#trainingchargerror").show();
			$("#trainingchargerror").text("Please enter valid Training Charges");
			return false;
		}else if(tds==""){
			$("#tdserror").show();
			$("#tdserror").text("Please enter TDS");
			return false;
		}else if(isNaN(tds)==true){
			$("#tdserror").show();
			$("#tdserror").text("Please enter valid TDS");
			return false;
		}else if(isNaN(invno)==true){
			$("#invnoerror").show();
			$("#invnoerror").text("Please enter valid Invoice No");
			return false;
		}else if(cgst==""){
			$("#cgsterror").show();
			$("#cgsterror").text("Please enter CGST");
			return false;
		}else if(isNaN(cgst)==true){
			$("#cgsterror").show();
			$("#cgsterror").text("Please enter valid CGST");
			return false;
		}else if(sgst==""){
			$("#sgsterror").show();
			$("#sgsterror").text("Please enter SGST");
			return false;
		}else if(isNaN(sgst)==true){
			$("#sgsterror").show();
			$("#sgsterror").text("Please enter valid SGST");
			return false;
		}else if(igst==""){
			$("#igsterror").show();
			$("#igsterror").text("Please enter IGST");
			return false;
		}else if(isNaN(igst)==true){
			$("#igsterror").show();
			$("#igsterror").text("Please enter valid IGST");
			return false;
		}else if(frdt==''){
                 $('#fderror').html("Please enter Month.");
                 $('#fderror').show();
        }
          
		
		
		/*else{
			location.href="emerson-bill-process.php?splallow="+splallow+"&pf="+pf+"&bonus="+bonus+"&esi="+esi+"&lww="+lww+"&lwf="+lwf+"&safetyapp="+safetyapp+"&other="+other+"&trainingcharg="+trainingcharg+"&tds="+tds+"&client="+client+"&invno="+invno+"&invdate="+invdate+"&tds="+tds+"&tds="+tds;
            exit();
		}*/
		frdt = document.getElementById('frdt').value;
		if(gndata==1){
			location.href="genrate-emerson-data-process_new.php?splallow="+splallow+"&pf="+pf+"&bonus="+bonus+"&esi="+esi+"&lww="+lww+"&lwf="+lwf+"&safetyapp="+safetyapp+"&other="+other+"&trainingcharg="+trainingcharg+"&tds="+tds+"&client="+client+"&cgst="+cgst+"&sgst="+sgst+"&igst="+igst+ "&invno="+invno+"&invdate="+invdate+"&printtype="+printtype+"$&monthlysupcharge="+monthlysupcharge+"&fixedsercharg="+fixedsercharg+"&frdt="+frdt;
            exit();
		}

		
	}
</script>
   <script>
        $( function() {
			alert("hi");
            $("#invdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            
        } );
		$(document).ready(function(){
			var getdata ='<?php echo $_POST['data'];?>';
			if(getdata==1){
				//$("#success1").show();
			}
		})
		
		</script>

</body>

</html>