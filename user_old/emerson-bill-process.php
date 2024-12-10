<?php
error_reporting(0);
//print_r($_POST);
session_start();

//print_r($_SESSION);
include("../lib/class/common.php");
$common=new common();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
if($_POST['client']==12 || $_POST['client']==14){
	$id =("12,14");
}else{
	$id=$_POST['client'];
}

//$id=addslashes("12,13,14,15,16,18");

$deptid = $common->clientDesign($id);
$deptid1 = $common->clientDesign($id);

$adeptarray = array();
foreach($deptid1 as $dep1){
	$adeptarray[] = $dep1['desg_id'];
}
$comp_id = $_SESSION['comp_id'];
//print_r($adeptarray);
$tablecnt = $deptid->rowCount();
$splallow = $_POST['splallow'];
$pf = $_POST['pf'];
$bonus = $_POST['bonus'];
$esi = $_POST['esi'];
$lww = $_POST['lww'];
$lwf = $_POST['lwf'];
$safetyapp = $_POST['safetyapp'];
$other = $_POST['other'];
$trainingcharg = $_POST['trainingcharg'];
$tds = $_POST['tds'];

$cgst = $_POST['cgst'];
$sgst = $_POST['sgst'];
$igst = $_POST['igst'];

$monthlysupcharge = $_POST['monthlysupcharge'];
$fixedsercharg = $_POST['fixedsercharg'];
$clinfo = $userObj->displayClient($id);
//print_r($clinfo);
//
?>
<?php
//header('Content-type: application/excel');

//header('Content-Disposition: attachment; filename="emersion-bill.xls"');

//error_reporting(0);
?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
	
	#taxinvoivedetailstable hr{margin: 5px -5px; color:#f00 !important}
	#emer table, #emer td, #emer th {
    /* padding: 1px!important; */
    border: 1px solid black!important;
    font-size: 12px !important;
    font-family: monospace;
}
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
        .heading{
            margin: 10px 20px;
        }
        .btnprnt{
            margin: 10px 20px;
        }
        .page-bk {
            position: relative;

            /*display: block;*/
            page-break-after: always;
            z-index: 0;

        }


        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 5px!important;
            border: 1px solid black!important;
            font-size:13px !important;
            font-family: monospace;

        }
		/*.paddmarg0,.paddmarg0 table{padding:0 !important;margin:0 !important; border: 0px !important}*/
		
        @media print
        {
            .btnprnt{display:none}
            .header_bg{
                background-color:#7D1A15;
                border-radius:0px;
            }
            .heade{
                color: #fff!important;
            }
            #header, #footer {
                display:none!important;
            }
            #footer {
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 50px;
            }
			  
		
        }
			/*@page {
			  size: A4;
			  margin: 0 0 5%;
			  padding: 0 0 10%;
			}*/


			@media print {
			  h3 {
				position: absolute;
				page-break-before: always;
				page-break-after: always;
				bottom: 0;
				right: 0;
			  }
			  h3::before {
				position: relative;
				bottom: -20px;
				counter-increment: section;
				content: counter(section);
			  }
		

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }

            #header, #footer {

                display:none!important;

            }
            #footer {
                display:none!important;
            }
        }
    </style>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<div height="100px"></div>


	   <input type="hidden" name="reqpf" id="reqpf" value="<?php echo $pf; ?>">
	   <input type="hidden" name="reqsplallow" id="reqsplallow" value="<?php echo $splallow; ?>">
	   <input type="hidden" name="reqbonus" id="reqbonus" value="<?php echo $bonus; ?>">
	   <input type="hidden" name="reqesi" id="reqesi" value="<?php echo $esi; ?>">
	   <input type="hidden" name="reqlww" id="reqlww" value="<?php echo $lww; ?>">
	   <input type="hidden" name="reqlwf" id="reqlwf" value="<?php echo $lwf; ?>">
	   <input type="hidden" name="reqsafetyapp" id="reqsafetyapp" value="<?php echo $safetyapp; ?>">
	   <input type="hidden" name="reqother" id="reqother" value="<?php echo $other; ?>">
	   <input type="hidden" name="reqtrainingcharg" id="reqtrainingcharg" value="<?php echo $trainingcharg; ?>">
	   <input type="hidden" name="reqtds" id="reqtds" value="<?php echo $tds; ?>">
<div style="padding:10px">	   
<table  border='1px solid #ccc' width="100%" cellspacing="0" cellpadding="0" id="emer" class="page-bk"> 
<tr>
	<th class="th" colspan="<?php echo $tablecnt+1;?>"><p align="left" style="display:inline; float: right;">&nbsp;</p>Emerson Bill On : <?php echo date('d/M/Y',strtotime($clinfo['current_month']));?></th>
	 
    </tr>  
    <tr>
	<th class="th">&nbsp;</th>
	<?php foreach($deptid as $dept){ ?>
	 <th class="th"><?php $ar = explode('-',$common->getDesgById($dept['desg_id']));  if($ar[1]==""){$tt ="N.A.";}else{$tt=$ar[0].$ar[1];}; echo $tt; ?></th>
	<?php }?>        
    </tr>
	<tr>
	<td>&nbsp;</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="center">Bill</td>
	<?php }?>
	</tr>
	<tr>
	<td>Basic</td>
	<?php for($i=0; $i<$tablecnt;$i++){
		$type="BASIC";
		$amt = $common->getEmployeeIncome($adeptarray[$i],$type,$comp_id);
		?>
	<td align="right" id="basic<?php echo $i;?>"><?php if($amt==""){$amt=0;} echo $amt;?></td>
	<?php }?>
	</tr>
	<tr>
	<td>Spl. Allow (<?php echo $splallow;?>)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="splallow<?php echo $i;?>">
	<?php if($splallow ==""){$splallow='0';}
	echo $splallow;
		?>
	</td>
	<?php }?>
	</tr>
	<tr>
	<td>HRA</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="hra<?php echo $i;?>">
	<?php $type="H.R.A.";
		$amt = $common->getEmployeeIncome($adeptarray[$i],$type,$comp_id);
		if($amt ==""){$amt = '0';}
		echo $amt;
		?></td>
	<?php }?>
	</tr>
	<tr>
	<td>Suppli.Serv.Allow</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="suppliservallow<?php echo $i;?>">
	<?php $amt ="";
	   $type="SUPPLEMENT ALW";
		$amt = $common->getEmployeeIncome($adeptarray[$i],$type,$comp_id);
	
		if($amt ==""){$amt = '0';}
		echo $amt;
		?>
		</td>
	<?php }?>
	</tr>
	<tr>
	<td>Super skill Allow.</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="superskillallow<?php echo $i;?>"><?php
$amt ="0";
	$type="supplement allow";
		$amt ="";
	
		$amt = $common->getEmployeeIncome($adeptarray[$i],$type,$comp_id);
		//$amt ="";
		if($amt ==""){$amt = '0';}
		echo $amt;
		?></td>
	<?php }?>
	</tr>
	<tr>
	<td>Other Allow.</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="otherallow<?php echo $i;?>"><?php $type="OTHER ALLOW";
		$amt = $common->getEmployeeIncome($adeptarray[$i],$type,$comp_id);
		
		if($amt ==""){$amt = '0';}
		echo $amt;
		?></td>
	<?php }?>
	</tr>
	<tr>
	<td></td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right">&nbsp;</td>
	<?php }?>
	</tr>
	<tr>
	<td>Gross</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="gross<?php echo $i;?>">
	
	</td>
	<script>
	$( document ).ready(function() {
   var id = '<?php echo $i;?>';
	var basic = "basic"+id;
	var splallow = "splallow"+id;
	var hra = "hra"+id;
	var suppliservallow = "suppliservallow"+id;
	var superskillallow = "superskillallow"+id;
	var otherallow = "otherallow"+id;
	//var gross = parseFloat($("#"+basic).html());
	var gross = parseFloat($("#"+basic).html())+parseFloat($("#"+splallow).html())+parseFloat($("#"+hra).html())+parseFloat($("#"+suppliservallow).html())+parseFloat($("#"+superskillallow).html())+parseFloat($("#"+otherallow).html());
	gross = gross.toFixed(2);
	$("#gross"+id).text(parseFloat(gross));
});
	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>
	</tr>
	<!------------------ for single day ----->
	
	
	<tr>
	<td>Basic</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="basicsing<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
   var id = '<?php echo $i;?>';
	var basicsing = "basicsing"+id;
	var	basid = $("#basic"+id).html();
	var basic1 = parseFloat(basid/26);
		basic1 = basic1.toFixed(2);	
	$("#"+basicsing).text(basic1);
});
	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>Spl. Allow</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="splallowsing<?php echo $i;?>"><?php echo round($splallow/26,2);?></td>
	
	<?php }?>
	</tr>
	<tr>
	<td>HRA</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="hrasingle<?php echo $i; ?>">Bill</td>
	<script>
	$( document ).ready(function() {
		var id = '<?php echo $i;?>';
		var basicsing = "hrasingle"+id;
		var	basid = $("#hra"+id).html();
		var basic1 = parseFloat(basid/26);
		basic1 = basic1.toFixed(2);	
		$("#"+basicsing).text(basic1);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>Suppli.Serv.Allow</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="suppliservallowsingle<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
		var id = '<?php echo $i;?>';
		var basicsing = "suppliservallowsingle"+id;
		var	basid = $("#suppliservallow"+id).html();
		var basic1 = parseFloat(basid/26);
		basic1 = basic1.toFixed(2);	
		$("#"+basicsing).text(basic1);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>Super skill Allow.</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="superskillallowsingle<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
		var id = '<?php echo $i;?>';
		var basicsing = "superskillallowsingle"+id;
		var	basid = $("#superskillallow"+id).html();
		var basic1 = parseFloat(basid/26);
		basic1 = basic1.toFixed(2);	
		$("#"+basicsing).text(basic1);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>Other Allow.</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="otherallowsing<?php echo $i;?>">Bill</td>
	<script>
	$( document ).ready(function() {
		var id = '<?php echo $i;?>';
		var basicsing = "otherallowsing"+id;
		var	basid = $("#otherallow"+id).html();
		var basic1 = parseFloat(basid/26);
		basic1 = basic1.toFixed(2);	
		$("#"+basicsing).text(basic1);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td></td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right">&nbsp;</td>
	<?php }?>
	</tr>
	<tr>
	<td>Total A</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="totala<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
		var gross = parseFloat($("#gross"+id).html());
		gross = gross/26;
		gross = gross.toFixed(2);
		$("#totala"+id).text(parseFloat(gross));
	});
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>
	</tr>
	<tr>
	<td>PF (<?php echo $pf; ?> %)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="pfdt<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
		var did = 'pfdt';
	   var id =""+'<?php echo $i;?>';
	   var basicsng1 = $("#basicsing"+id).html();
	   var splallowsng1 = $("#splallowsing"+id).html();
	   var pfd = $("#reqpf").val();		
		getincomehd(id,basicsng1,splallowsng1,pfd,did);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>BONUS (<?php echo $bonus; ?> %)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="bonusdt<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
		var did = 'bonusdt';
	   var id =""+'<?php echo $i;?>';
	   var basicsng1 = $("#basicsing"+id).html();
	   var splallowsng1 = $("#splallowsing"+id).html();
	   var pfd = $("#reqbonus").val();		
		getincomehd(id,basicsng1,splallowsng1,pfd,did);
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>Total B (From1-2-16)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="tatalb<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
		var did = 'bonusdt';
	   var id =""+'<?php echo $i;?>';
	   var basicsng1 = $("#bonusdt"+id).html();
	   var splallowsng1 = $("#pfdt"+id).html();
	   var totb = parseFloat(basicsng1)+parseFloat(splallowsng1);
	   totb = totb.toFixed(2);
	  $("#tatalb"+id).text(totb);		
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>&nbsp;</td>	
		<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>Other</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right"></td>
	<?php }?>
	</tr>
	<tr>
	<td>ESI (<?php echo $esi;?>%)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="esidt<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var totala = $("#totala"+id).html();
	   var refesi = $("#reqesi").val();
	   var totb = parseFloat(totala)*parseFloat(refesi/100);
	   totb = totb.toFixed(2);
	  $("#esidt"+id).text(totb);		
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>LWW (<?php echo $lww;?> %)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="dtlww<?php echo $i; ?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var basics = $("#basicsing"+id).html();
	   var splallows = $("#splallowsing"+id).html();
	   var hras = $("#hrasingle"+id).html();
	   var suppliservallows = $("#suppliservallowsingle"+id).html();
	   var reqlww = $("#reqlww").val();
	   var otherallowsing = $("#otherallowsing"+id).html();
	    var totala = $("#totala"+id).html();
	   
	   var totb1 = parseFloat(totala)*parseFloat(reqlww)/26;
	   totb1 = totb1.toFixed(2);
	  $("#dtlww"+id).text(totb1);		
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>LWF (<?php echo $lwf;?>)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="dtlwf<?php echo $i; ?>"><?php echo $_POST['lwf'];?></td>
	
	<?php }?>
	</tr>
	<tr>
	<td>Safety Appliances ( PPE's) (<?php echo $safetyapp;?>)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="tdsafetyappliances<?php echo $i; ?>"><?php echo $_POST['safetyapp'];?></td>
	<?php }?>
	</tr>
	<tr>
	<td>Soap+Tea+Other charges (<?php echo $other; ?>)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="othercharg<?php echo $i;?>"><?php echo $_POST['other'];?></td>
	<?php }?>
	</tr>
	<tr>

	<td>Training Charges (<?php echo $trainingcharg; ?>)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="trainingcharges<?php echo $i;?>"><?php echo $_POST['trainingcharg'];?></td>
	<?php }?>
	</tr>
	<tr>
	<td>Total C</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="totalc<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var esidt = $("#esidt"+id).text();
	   var dtlww = $("#dtlww"+id).text();
	   var dtlwf = $("#dtlwf"+id).text();
	   var tdsafetyappliances = $("#tdsafetyappliances"+id).text();
	   var othercharg = $("#othercharg"+id).text();
	   var trainingcharges = $("#trainingcharges"+id).text();
	   
	   var totb1 = parseFloat(esidt)+parseFloat(dtlww)+parseFloat(dtlwf)+parseFloat(tdsafetyappliances)+parseFloat(othercharg)+parseFloat(trainingcharges);
	   totb1 = totb1.toFixed(2);
	  $("#totalc"+id).text(totb1);		
	});	
	</script>
	<?php }?>
	</tr>
	
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>Grand Total (A+B+C)</td>
	<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="grandtotabc<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var ta = $("#totala"+id).text();
	   var tb = $("#tatalb"+id).text();
	   var tc = $("#totalc"+id).text();
	      
	   var totb1 = parseFloat(ta)+parseFloat(tb)+parseFloat(tc);
	   totb1 = totb1.toFixed(2);
	  $("#grandtotabc"+id).text(totb1);		
	});	
	</script>
	<?php }?>
	</tr>
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>TDS (<?php echo $tds; ?>)</td>
<?php for($i=0; $i<$tablecnt;$i++){?>	
	<td align="right" id="tdtds<?php echo $i;?>">
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var dts ='<?php echo $tds;?>';
	   var grandtotabc = $("#grandtotabc"+id).text();
	   	      
	   var totb1 = parseFloat(grandtotabc)*dts/100;
	   totb1 = totb1.toFixed(2);
	  $("#tdtds"+id).text(totb1);		
	});	
	</script>
	</td>
<?php }?>	
	</tr>
	<tr>
	<td>Total D</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="totald<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var grandtotabc = $("#grandtotabc"+id).text();
	   var tdtds = $("#tdtds"+id).text();
	      
	   var totb1 = parseFloat(grandtotabc)+parseFloat(tdtds);
	   totb1 = totb1.toFixed(2);
	  $("#totald"+id).text(totb1);
		$("#roundedoff"+id).text(Math.round(totb1)+".00");		  
	});	
	</script>
<?php }?>	
	</tr>
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>Rounded off to Rs</td>
<?php for($i=0; $i<$tablecnt;$i++){?>	
	<td align="right" id="roundedoff<?php echo $i;?>"></td>
<?php }?>	
	</tr>
	<tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>No of Employee in Category</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="noofemployee<?php echo $i; ?>"><?php  $deptemployee = $common->clientDesigationEmployeeById($adeptarray[$i],$id); if($deptemployee==""){$deptemployee=0;} echo $deptemployee;?></td>
<?php }?>	
	</tr>
    <tr>
	<td>&nbsp;</td>	
	<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>Bill Rate</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="billrate<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var roundedoff = $("#roundedoff"+id).text();
	   var noofemployee = $("#noofemployee"+id).text();
	      
	   var totb1 = parseInt(roundedoff)*parseInt(noofemployee);
	   if(roundedoff==0){
		  totb1 =0; 
	   }
	  $("#billrate"+id).text(totb1);		  
	});	
	</script>
<?php }?>
	
	</tr>
	<tr>
	<td>&nbsp;</td>	
		<?php if($tablecnt !=0){ ?>
	<td align="right" colspan="<?php echo $tablecnt;?>"></td>	
	<?php } ?>	
	</tr>
	<tr>
	<td>OT Rate / Hr</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="otratehr<?php echo $i;?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var basicsing = $("#basicsing"+id).text();
	   var splallowsing = $("#splallowsing"+id).text();
	   var hrasingle = $("#hrasingle"+id).text();
	   var suppliservallowsingle = $("#suppliservallowsingle"+id).text();
	   var superskillallowsingle = $("#superskillallowsingle"+id).text();  
	   var totala = $("#totala"+id).text(); 
	   
	   var totb1 = (parseFloat(totala))/8*2;
	   totb1 = totb1.toFixed(2);
	  $("#otratehr"+id).text(totb1);		  
	});	
	</script>
<?php }?>	
	</tr>
	 
	<tr>
	<td>OT Conversion  Rate</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" ><span id="otconversionrate<?php echo $i; ?>"></span>%</td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';
	   var basicsing = $("#basicsing"+id).text();
	   var splallowsing = $("#splallowsing"+id).text();
	   var hrasingle = $("#hrasingle"+id).text();
	   var suppliservallowsingle = $("#suppliservallowsingle"+id).text();
	   var superskillallowsingle = $("#superskillallowsingle"+id).text();
		var esidt = $("#esidt"+id).text();
		var roundedoff = $("#roundedoff"+id).text();
		var totala = $("#totala"+id).text();
		
	   
	   var totb1 = (parseFloat(totala)+parseFloat(esidt))/parseInt(roundedoff);
	   totb1 = totb1.toFixed(2);
	   totb1 = totb1*100;
	  $("#otconversionrate"+id).text(totb1);		  
	});	
	</script>
<?php }?>	
	</tr>
	<tr>
	<td>OT Hours</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="othours<?php echo $i; ?>"><?php $othours = $common->otHours($adeptarray[$i],$id); if($othours['othour']==""){$othours['othour']=0; } echo $othours['othour'];?></td>
	
<?php }?>	
	</tr>
	<tr>
	<td>OT Days</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td  align="right"><span id="otdays<?php echo $i; ?>" align="left"></span> </td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';	
	   var othour ="othours"+id;
	   var otdaysplcon = "otdaysplcon"+id;
	   var othourval = $("#"+othour).text();
	    var otconversionrate = $("#otconversionrate"+id).text();
	   if(othourval > 0){
	   $("#otdays"+id).text(parseFloat(othourval)/8*2);
	   
	   $("#"+otdaysplcon).text(parseFloat(otconversionrate/100)*parseFloat(parseFloat(othourval)/8*2));
	   }else{
		 $("#otdays"+id).text(0);  
	   }
	});
	   </script>

<?php }?>	
	</tr>
	<tr>
	<td>OT Days Percentage</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td  align="right"><span id="otdaysplcon<?php echo $i; ?>" align="left">0</span> </td>
	<?php }?>	
	</tr>
	<tr>
	<td>Payable Days</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="payabledays<?php echo $i; ?>"><?php $payabledays = $common->payableDays($adeptarray[$i],$id);$yayabledays =1;
	if($payabledays ==""){$payabledays=0;}; echo $payabledays;?></td>
	

<?php }?>	
	</tr>
		<tr>
	<td>Total Days</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="totalday<?php echo $i; ?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';	
	   var otdaysplcon ="otdaysplcon"+id;
	   var payabledays ="payabledays"+id;
	   var otdaysplcon = $("#"+otdaysplcon).text();
	    var payabledays = $("#"+payabledays).text();
		var totaldays = parseFloat(payabledays)+parseFloat(otdaysplcon);
	   
	   $("#totalday"+id).text(totaldays.toFixed(2));
	});
	   </script>

<?php }?>	
	</tr>
	<tr>
	<td>No Of Units</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="noofunits<?php echo $i; ?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';	
	   var totalday ="totalday"+id;
	   var noofemployee ="noofemployee"+id;
	   var totalday = $("#"+totalday).text();
	   var noofemployee = $("#"+noofemployee).text();
	   if(totalday <=0){
		   totalday =0;		
	   }
	   
	   if(noofemployee!=0){
		   var noofunits = parseFloat(totalday)/parseInt(noofemployee);
	   }else{
		  noofunits =0;	 
	   }
	   
	   
	   $("#noofunits"+id).text(noofunits.toFixed(2));
	});
	   </script>

<?php }?>	
	</tr>
	<tr>
	<td>Amount</td>
<?php for($i=0; $i<$tablecnt;$i++){?>
	<td align="right" id="amount<?php echo $i; ?>"></td>
	<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';	
	   var billrate ="billrate"+id;
	   var noofunits ="noofunits"+id;
	   var billrate = $("#"+billrate).text();
	   var noofunits = $("#"+noofunits).text();
	   

	   if(noofunits >0){
		var amount = parseFloat(billrate)*parseFloat(noofunits);
	   }else{
		 var amount =0;  
	   }
	   $("#amount"+id).text(amount.toFixed(2));
	});
	   </script>

<?php }?>	
	</tr>
</table>
<br>
<!-------------------------------------------------------tax invoice ------------------------------------>
<?php $comapnydtl = $userObj->showCompdetailsById($comp_id);
$compbankdtl = $userObj->displayBank($comapnydtl['bank_id']);
$resclt=$userObj->displayClient($id);
//print_r($resclt);
?>

<!-------------------------------------------------------tax invoice ------------------------------------>
 <div id="taxinvoivedetailstable">   <div >
	<div  class="thheading" style="text-align:center">Tax Invoice</div>
	<div>&nbsp;</div>
        </div>
		 <table width="100%" cellspacing="0" cellpadding="0">
		
<tr>
<td width="50%" class="paddmarg0">
<div class="spanclass"><span class="thheading">
<?php echo $comapnydtl['comp_name'];?>
</span><?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Tel. <?php echo $comapnydtl['tel']; if($comapnydtl['email'] !=""){?>, email: <?php echo $comapnydtl['email']; }?><br>State : Maharashtra,    State Code : 27 </div>

</td>
<td width="50%" valign="top" class="bordpadd0 paddmarg0">
<div align="right"><h5 class="thheading" >GSTIN : 27AAAFI3587J1Z3</h5>
				<span  >Original / Duplicate/ Triplicate </span></div><hr>
				
			
				<span class="thheading">Serial No.of Invoice : ICS/<?php echo $_POST['invno'];?></span><hr>
				<span class="thheading">Date of Invoice : <?php if($_POST['invdate']!=""){echo date('d/M/y',strtotime($_POST['invdate']));}?></span>
		
			
</td>
</tr>
<tr>
	<td class="thheading" colspan="2" align="center">Tax Invoice</td>	
</tr>
<tr>
<td class="thheading">
Details of Receiver (Billed To)
</td>
<td class="thheading">Details of Consignee (Shipped To)</td>
</tr>
<tr>
<td width="20%">Name : <?php echo $resclt['client_name'];?></td>
<td>Name :</td>
</tr>
<tr>
<td width="20%">Address : <?php echo $resclt['client_add1']; ?></td>
<td>Address :</td>
</tr>

<tr>
<td width="20%">State : Maharastra</td>
<td>State :</td>
</tr>
<tr>
<td width="20%">State Code : 27</td>
<td>State Code :</td>
</tr>
<tr>
<td width="20%">GSTIN :<?php echo $resclt['gstno'];?></td>
<td>GSTIN : </td>
</tr>

<tr>
<td colspan="2">Bill For <?php echo $resclt['client_name'];?> for providing services as details in agreement dated 6th may 2009, for the period from</td>
</tr>
<tr>
		<td colspan="2" class="bordpadd0 paddmarg0" >
		
		<table width="100%">
			<tr>
			<td class="thheading" align="center">Sr No.</td>
			<td class="thheading" align="center">Particulars</td>
			<td class="thheading" align="center">HSN/SAC</td>
			<td class="thheading" align="center">Qty</td>
			<td class="thheading" align="center">Unit</td>
			<td class="thheading" align="center">Rate</td>
			<td class="thheading" align="center">Total</td>
			<td class="thheading" align="center">Discount</td>
			<td class="thheading" align="center">Taxable Value</td>
			<td class="thheading paddmarg0" align="center " colspan="2" width="11%">
			CGST<hr>Rate | Amount
				
			</td>
			
			<td class="thheading paddmarg0" align="center" colspan="2" width="11%">
			SGST<hr>Rate | Amount
				</td>
				<td class="thheading paddmarg0" align="center" colspan="2" width="11%">
			IGST<hr>Rate | Amount
				</td>
			<td class="thheading" align="center">Amount</td>
			</tr>
			<?php $i=0; $j=1; foreach($adeptarray as $dept){ ?>
			<tr>
			<td><?php echo $j;?></td>
			<td><?php $ar = explode('-',$common->getDesgById($dept));
			if($ar[1] ==""){$tad ="N.A.";}else{$tad = $ar[1];}
			echo $tad; ?></td>
			<td align="center">9985</td>
			<td align="right" id="taxqty<?php echo $i;?>"></td>
			<td align="right" id="taxunit<?php echo $i;?>">1</td>
			<td align="right" id="taxrate<?php echo $i;?>"></td>
			<td align="right" id="taxtot<?php echo $i;?>" class="taxtotcl"></td>
			<td align="right" id="taxdesc<?php echo $i;?>">0</td>
			<td align="right" id="taxtaxablval<?php echo $i;?>" class="taxtaxablvalcl">0</td>
			<td align="right" id="<?php echo $i;?>" class="paddmarg0" width="5%"><?php echo $cgst;?> </td>
			<td id="cgstamt<?php echo $i;?>" class="cgstamtcl" width="6%" align="right">Amt.</td>
			<td align="right"  class="paddmarg0" width="5%"><?php echo $sgst;?></td>
			<td id="sgstamt<?php echo $i;?>" class="sgstamtcl" width="6%" align="right"></td>
			<td align="right" class="paddmarg0" width="5%"><?php echo $igst;?></td>
			<td id="igstamt<?php echo $i;?>" class="igstamtcl" width="6%" align="right">0</td>			
			<td align="right" id="taxtotamt<?php echo $i;?>" class="taxtotamtcl">0</td>
			</tr>
			
			<script>
	$( document ).ready(function() {
	   var id ='<?php echo $i;?>';	
	   var noofunits = $("#noofunits"+id).text();
	   var billrate = $("#billrate"+id).text();
	   var taxdesc = $("#taxdesc"+id).text();
	   var cgst ='<?php echo $cgst;?>';
	   var sgst ='<?php echo $sgst;?>';
	   var igst ='<?php echo $igst;?>';
	   
	   var taxtot = parseFloat(noofunits*billrate);
	   
	   var cgstamt = parseFloat(cgst)*taxtot/100;
	   var sgstamt = parseFloat(sgst)*taxtot/100;
	   var igstamt = parseFloat(igst)*taxtot/100;
	   var taxdesc = parseFloat(taxtot)-parseFloat(taxdesc)
	   
	   $("#taxqty"+id).text(noofunits);
	   $("#taxrate"+id).text(billrate);
	   $("#taxtot"+id).text(taxtot.toFixed(2));
	   $("#taxtaxablval"+id).text(taxtot.toFixed(2));
	   
	   
	   $("#cgstamt"+id).text(cgstamt.toFixed(2));
	   $("#sgstamt"+id).text(sgstamt.toFixed(2));	
	   $("#igstamt"+id).text(igstamt.toFixed(2));
	   
	   
	   
	   
	   
	   var totgst = parseFloat(cgstamt)+parseFloat(sgstamt)+parseFloat(igstamt);
	   var totamt = totgst+taxtot;	   
	   $("#taxtotamt"+id).text(totamt.toFixed(2));
	   
	   
	   
	   
	   //$("#tottxaamtgst").text(totgst);
	});
	   </script>
			<?php $i++; $j++;}?>
			<tr>
			<td><?php echo $j;?></td>
			<td>Monthly Supervision Charges</td>
			<td align="center">9985</td>
			<td align="right" id="taxqty<?php echo $i;?>">2</td>
			<td align="right" id="taxunit<?php echo $i;?>">0</td>
			<td align="right" id="taxrate<?php echo $i;?>">7500.00</td>
			<td align="right" id="taxtot<?php echo $i;?>" class="taxtotcl"><?php echo $monthlysupcharge;?></td>
			<td align="right" id="taxdesc<?php echo $i;?>">0</td>
			<td align="right" id="taxtaxablval<?php echo $i;?>" class="taxtaxablvalcl"><?php echo $monthlysupcharge;?></td>
			<td align="right" id="<?php echo $i;?>" class="paddmarg0" width="5%"><?php echo $cgst;?> </td>
			<td id="cgstamt<?php echo $i;?>" class="cgstamtcl" width="6%" align="right">0</td>
			<td align="right"  class="paddmarg0" width="5%"><?php echo $sgst;?></td>
			<td id="sgstamt<?php echo $i;?>" class="sgstamtcl" width="6%" align="right">0</td>
			<td align="right" class="paddmarg0" width="5%"><?php echo $igst;?></td>
			<td id="igstamt<?php echo $i;?>" class="igstamtcl" width="6%" align="right">0</td>			
			<td align="right" id="taxtotamt<?php echo $i;?>" class="taxtotamtcl">0</td>
			</tr>
			<tr>
			<td><?php echo $j+1;?></td>
			<td>Fixed Service Charge</td>
			<td align="center">9985</td>
			<td align="right" id="fixedserchrate">2</td>
			<td align="right" >0</td>
			<td align="right" id="fxtrate"><?php echo $fixedsercharg;?></td>
			<td align="right" id="fxttot" ></td>
			<td align="right" id="taxdesc<?php echo $i+1;?>" class="ftextdesc">0</td>
			<td align="right" id="taxtaxablval<?php echo $i+1;?>" class="taxtaxablvalcl fttaxablval">0</td>
			<td align="right" id="fcgstrt" class="paddmarg0 " width="5%"><?php echo $cgst;?> </td>
			<td id="fcgstamt" class="cgstamtcl" width="6%" align="right">0</td>
			<td align="right"  class="paddmarg0" width="5%"><?php echo $sgst;?></td>
			<td id="fsgstamt" class="sgstamtcl" width="6%" align="right">0</td>
			<td align="right" class="paddmarg0" width="5%"><?php echo $igst;?></td>
			<td id="figstamt" class="igstamtcl" width="6%" align="right">0</td>			
			<td align="right" id="ftaxtotamt" class="taxtotamtcl">0</td>
			</tr>
			<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="right"></td>
			<td align="right" id="grandtot"></td>
			<td align="right"></td>
			<td align="right" id="grandtaxaxabl"></td>
			<td align="right"></td>
			<td align="right" id="grandcgst"></td>
			<td align="right"></td>
			<td align="right" id="grandsgst"></td>
			<td align="right"></td>
			<td align="right" id="grandigst"></td>
			
			<td align="right" id="finalsingtotamt"><?php //echo $total;?> </td>
			</tr>
			
			
			<tr>
			<td  class="" colspan="9">Total Invoice amount in words <span id="numtoword"></span><?php //echo convert_number_to_words($total); ?> Only. </td>
			
			<td colspan="5" class="paddmarg0">Total Amount Before Tax : <hr> Add CGST</td> 
			<td colspan="2" class="paddmarg0" align="right"><span id="beforetaxamount"></span><hr><span id="addcgst"></span></td>
			
			</tr>
			<tr>
			<td  class="thheading" colspan="9">
				<div style="width:25%; float:left">Bank Details </div><div>:-  <?php echo $compbankdtl['bank_name']; ?>,<?php echo $compbankdtl['add1']; //echo $compbankdtl['branch']; ?></div>
				<div style="width:25%;  float:left">Bank A/c </div><div>:-  <?php echo $comapnydtl['bankacno']; ?></div>
				<div style="width:25%;  float:left">Bank IFSC </div><div>:-  <?php echo $compbankdtl['ifsc_code']; ?></div>
				 </td>
		
			<td colspan="5" class="paddmarg0">Add SGST <hr>Add IGST<hr>Total Tax amount GST</td> 
			<td colspan="2" class="paddmarg0" align="right"><span id="addsgst"></span><hr><span id="addigst"></span><hr><span id="tottxaamtgst"></span></td>
			</tr>
			
			<tr>
			<td  class="thheading" colspan="9" valign="top">Declaration </td>
		
			<td colspan="5" class="paddmarg0">Total Amount after tax <hr>GST Payable under RCM<hr><div style="height:100px; "><?php echo "For ". $comapnydtl['comp_name'];?></div><br><br><br><br><br>Authorised Signatory</td> 
			<td colspan="2" class="paddmarg0" valign="top" align="right"><span id="totamtaftertax"></span><hr><span >0</span><hr> <div style="height:100px; "></div></td>
			</tr>
		</table>
		
		</td>
	</tr>
	
</table>
</div>
<?php 

for($k=$i; $k<=$i+2; $k++){?>
<script>
var id ='<?php echo $k;?>';
var cgst ='<?php echo $cgst;?>';
	   var sgst ='<?php echo $sgst;?>';
	   var igst ='<?php echo $igst;?>';
	   
	   var taxtot = $("#taxtaxablval"+id).text();
	   var taxdesc = $("#taxdesc"+id).text();
	   var cgstamt = parseFloat(cgst)*taxtot/100;
	   var sgstamt = parseFloat(sgst)*taxtot/100;
	   var igstamt = parseFloat(igst)*taxtot/100;
	   var taxdesc = parseFloat(taxtot)-parseFloat(taxdesc);
	   
	   
	   //$("#taxtaxablval"+id).text(taxtot.toFixed(2));
	  
	   
	   $("#cgstamt"+id).text(cgstamt.toFixed(2));
	   $("#sgstamt"+id).text(sgstamt.toFixed(2));	
	   $("#igstamt"+id).text(igstamt.toFixed(2));
	   
	   var totgst = parseFloat(cgstamt)+parseFloat(sgstamt)+parseFloat(igstamt);
	   var totamt = parseFloat(totgst)+parseFloat(taxtot);	   
	   $("#taxtotamt"+id).text(totamt);
	   </script>
<?php }
?>
<script> 



</script>
<script>
    function myFunction() {
        window.print();
    }
</script>
<script>
function getincomehd(id,basicsng1,splallowsng1,pfd,did){
	var tpf = (parseFloat(basicsng1)+parseFloat(splallowsng1));
		tpf = tpf*pfd/100;
		tpf = tpf.toFixed(2);
		$("#"+did+id).text(tpf);
}

</script>
<script>
var sum = 0;
var sum1 = 0;
var sum2 = 0;
var sum3 = 0;
var sum4 = 0;
var sum5 = 0;
$( document ).ready(function() {
$('.taxtotcl').each(function(){
    sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});
$('.taxtaxablvalcl').each(function(){
    sum1 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});
$('.cgstamtcl').each(function(){
    sum2 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});
$('.sgstamtcl').each(function(){
    sum3 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});
$('.igstamtcl').each(function(){
    sum4 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});
$('.taxtotamtcl').each(function(){
    sum5 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});

var totgst = sum2+sum3+sum4;
var fxtrate = $("#fxtrate").text();
var fixedtot = parseFloat(sum)*parseFloat(fxtrate/100);
$("#fxttot").text(fixedtot.toFixed(2));
var taxinvgarndstot = parseFloat(sum)+parseFloat(fixedtot);
$("#fixedserchrate").text(sum.toFixed(2));
sum1 = sum1+fixedtot;
$("#grandtot").text(taxinvgarndstot.toFixed(2));
$("#grandtaxaxabl").text(sum1.toFixed(2));


$("#grandcgst").text(sum2.toFixed(2));
$("#grandsgst").text(sum3.toFixed(2));
$("#grandigst").text(sum4.toFixed(2));
$("#finalsingtotamt").text(sum5.toFixed(2));
$("#beforetaxamount").text(sum1.toFixed(2));
$("#addcgst").text(sum2.toFixed(2));
$("#addsgst").text(sum3.toFixed(2));
$("#addigst").text(sum4.toFixed(2));
$("#tottxaamtgst").text(totgst.toFixed(2))

$("#totamtaftertax").text(sum5.toFixed(2));
/// manualy

var fxttot = $("#fxttot").text();
var ftextdesc = $(".ftextdesc").text();
var fxtvaltot = parseFloat(fxttot)-parseFloat(ftextdesc);
$(".fttaxablval").text(fxtvaltot);
$("#fcgstamt").text();


var fcgst ='<?php echo $cgst;?>';
var fsgst ='<?php echo $sgst;?>';
var figst ='<?php echo $igst;?>';
var fcgstamt = parseFloat(fxtvaltot)* parseFloat(fcgst)/100;
var fsgstamt = parseFloat(fxtvaltot)* parseFloat(fsgst)/100;
var figstamt = parseFloat(fxtvaltot)* parseFloat(figst)/100;
$("#fcgstamt").text(fcgstamt.toFixed(2));
$("#fsgstamt").text(fsgstamt.toFixed(2));
$("#figstamt").text(figstamt.toFixed(2));
 var ftotgst = parseFloat(fcgstamt)+parseFloat(fsgstamt)+parseFloat(figstamt);
	   var ftotamt = parseFloat(totgst)+parseFloat(fxtvaltot);	
	

 sum2=sum2+fcgstamt;
 sum3=sum3+fsgstamt;
 sum4=sum4+figstamt;
 sum5=sum5+ftotamt;
 
 //$("#ftaxtotamt").text(ftotgst.toFixed(2));
 $("#tottxaamtgst").text(totgst.toFixed(2))
$("#grandcgst").text(sum2.toFixed(2));
$("#grandsgst").text(sum3.toFixed(2));
$("#grandigst").text(sum4.toFixed(2));

$("#addcgst").text(sum2.toFixed(2));
$("#addsgst").text(sum3.toFixed(2));
$("#addigst").text(sum4.toFixed(2));
var vartotlgst = fcgstamt+fsgstamt+figstamt;
var fxtvaltotgg = parseFloat(fxtvaltot)+parseFloat(vartotlgst);
 $("#ftaxtotamt").text(fxtvaltotgg.toFixed(2));
var allgsttot = sum2+sum3+sum4;
$("#tottxaamtgst").text(allgsttot.toFixed(2));
sum5 =0;
$('.taxtotamtcl').each(function(){
    sum5 += parseFloat($(this).text());  // Or this.innerHTML, this.innerText	
});


$("#finalsingtotamt").text(sum5.toFixed(2));
$("#totamtaftertax").text(sum5.toFixed(2));
var numword = convertNumberToWords(sum5.toFixed(2));
$("#numtoword").text(numword);
});



</script>
<script>function convertNumberToWords(amount) {
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    return words_string;
}</script>

</body></html>
