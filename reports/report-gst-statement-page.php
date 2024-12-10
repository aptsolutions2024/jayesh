<?php
session_start();
error_reporting(0);
//print_r($_REQUEST);
$includinc =$_REQUEST['includinc'];
$inctext1 =$_REQUEST['inctext1'];
$inctext2 =$_REQUEST['inctext2'];
$dedtext1 =$_REQUEST['dedtext1'];
$dedtext2 =$_REQUEST['dedtext2'];

$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$pfper = $_REQUEST['pf'];
$esiper = $_REQUEST['esi'];
$gstper = $_REQUEST['gst'];
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
 $serchargesper=$resclt['ser_charges'];

//echo $serchargesper;
$comapnydtl = $userObj->showCompdetailsById($comp_id);
$compbankdtl = $userObj->displayBank($comapnydtl['bank_id']);
if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_empinc='tran_income';
    $esifrdt=$cmonth;
	$tab_days='tran_days';
    
 }
else{

    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_empinc='hist_income';
	$tab_days='hist_days';

 }


	/*$sqlcontlabw ="select sum(gross_salary) gsal from $tab_emp te inner join mast_company mc on te.comp_id = mc.comp_id where te.client_id='".$clientid."' and te.sal_month ='".$frdt."'";*/
	$rescontlabw =$userObj->getSumGrossSalary($tab_emp,$clientid,$frdt);
	
	/* $sqlesi ="select sum(std_amt) esi from 	
	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 		
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%E.S.I.%'";*/
	$resesi = $userObj->getREPORTSumESISalary($tab_empded,$tab_emp,$clientid,$frdt);
	
	/*$sqlpf ="select sum(std_amt) pfsum from 	
	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%P.F.%'";*/
	
	$respf = $userObj->getREPORTSumPFSalary($tab_empded,$tab_emp,$clientid,$frdt);
	 
	/*$sqlovertime ="select sum(amount) ot from 	
	$tab_empinc te inner join $tab_emp em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
	inner join mast_income_heads mih on mih.mast_income_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.income_heads_name like '%OVERTIME%'";*/
	
	$resot = $userObj->getREPORTSumOTSalary($tab_empinc,$tab_emp,$clientid,$frdt);
	
	/*$sqlcanteen ="select sum(amount) canteen from 	
	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%CANTEEN%'";*/
	
	$rescanteen = $userObj->getREPORTSumCanteen($tab_empded,$tab_emp,$clientid,$frdt);
	
	/*$sqltransport ="select sum(amount) trans from 	
	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%TRANSPORT%'";*/

	$restransport = $userObj->getREPORTSumTran($tab_empded,$tab_emp,$clientid,$frdt);
	// canteen
	//$rescanteen = mysql_query($sqlcanteen);
$rowcanteen = $rescanteen->fetch_assoc();
$canteen = round($rowcanteen['canteen']);

	// transport
	//$restransport = mysql_query($sqltransport);
$rowtransport = $restransport->fetch_assoc();
$transport = round($rowtransport['trans']);

/// for calculate wages
//$rescontlabw = mysql_query($sqlcontlabw);
$rowcontlabw = $rescontlabw->fetch_assoc();
$laborwages = round($rowcontlabw['gsal']);

/// for calculate esi
//$resesi = mysql_query($sqlesi);
$rowesi = $resesi->fetch_assoc();
$esi = round($rowesi['esi']);
if($esi ==""){ $esi=0;}

/// for calculate pf
//$respf = mysql_query($sqlpf);
$rowpf = $respf->fetch_assoc();
$pf = round($rowpf['pfsum']);
if($pf ==""){ $pf=0;}

/// for calculate overtime
//$resot = mysql_query($sqlovertime);
$rowot = $resot->fetch_assoc();
$ot = round($rowot['ot']);
if($ot ==""){ $ot=0;}

// esi amount
$esiamount = $esi*$esiper/100; //4.75
$esiamount = round($esiamount);
// pf amount
$pfamount = $pf*$pfper/100; //13.5
$pfamount = round($pfamount);


//Fields on the screen 
//$inc_amt1 = 0;
//$inc_amt2 =0;
	$inc_amt1= $inctext1;
	$inc_amt2 = $inctext2;
	
	
if ($includinc == 'Y')
	
{	$inc_amt1= $inctext1;
	$inc_amt2 = $inctext2;
$seramt = $inc_amt1+$inc_amt2;}
else
	{$seramt = 0;
 
}


//$perrate =$serchargesper/100; //10.5

if($clientid ==1 || $clientid ==6  )
	{ //lokmat
	$seramt= $seramt+$laborwages+$pfamount+$esiamount;
	
	
	
	}
else if($clientid ==2 || $clientid ==25 || $clientid ==26) { // l&t group 
		$seramt= $seramt+$laborwages+$pfamount+$esiamount;
}
	
else if($clientid ==3 || $clientid ==10 || $clientid ==5 || $clientid ==17 ||$clientid ==7 || $clientid ==8 || 			$clientid ==9||  $clientid ==23   || $clientid ==24  || $clientid ==4){
	// BAKER GAUGES, WIKAS PRINTING & CARRIERS,//SAKAL PAPERS LTD., NASHIK

		$seramt= $seramt+$laborwages;
	}
else if($clientid ==11){ //MAHINDRA TSUBAKI 
	$seramt = $seramt+$laborwages-$ot;
	
	}
else{
	$seramt= $seramt+$laborwages+$pf+$esi;
	// $service charge per
}

if ($_REQUEST['inctext2field']=="PF" || $_REQUEST['inctext2field']=="P.F." ||$_REQUEST['inctext2field']=="ESI" || $_REQUEST['inctext2field']=="E.S.I.")
		{
		 	$seramt = $seramt-$inc_amt2 ;
		}
$servicecharge = ($seramt)*$serchargesper/100;
$servicecharge = round($servicecharge);



$gstamt = $laborwages+$pfamount+$esiamount+$inc_amt1+$inc_amt2+$servicecharge;

/// $service charge amount
$servicechargeamt =  $servicecharge*10.50/100;
$servicechargeamt = round($servicechargeamt);

$sgst = $servicecharge+$servicechargeamt+$inc_amt1+$inc_amt2;
$sgst = round($sgst);

// SGST/CGST per
$sgstamount = $gstamt *$gstper/100; //9
$sgstamount = round($sgstamount);

/// total
$total =$gstamt+$sgstamount+$sgstamount;
$total = round($total);
if($month!=''){
    $reporttitle="GST Statement FOR THE MONTH ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}
$_SESSION['client_name']=$resclt['client_name'].$p;
$_SESSION['reporttitle']=strtoupper($reporttitle);

function makewords($numval)
{
    $moneystr = "";	
// handle the millions
    $milval = (integer)($numval / 10000000);
    if($milval > 0)
    {
        $moneystr = getwords($milval) . " CRORE ";
    }
	  $numval = $numval - ($milval * 10000000); // get rid of millions

	// handle the lakh
    $lacval = (integer)($numval / 100000);
/*    if($lacval > 0)
    {
        $moneystr = getwords($lacval) . " Lac ";
    }
*/
    if($lacval > 0)
    {
        $workword = getwords($lacval);
        if ($moneystr == "")
        {
            $moneystr = $workword . " Lac ";
        }
        else
        {
            $moneystr .= " " . $workword . " LAC ";
        }
    }
    $workval = $numval - ($lacval * 100000); // get rid of millions

// handle the thousands
    //$workval = $numval - ($milval * 100000); // get rid of millions
    $thouval = (integer)($workval / 1000);
    if($thouval > 0)
    {
        $workword = getwords($thouval);
        if ($moneystr == "")
        {
            $moneystr = $workword . " Thousand";
        }
        else
        {
            $moneystr .= " " . $workword . " Thousand";
        }
    }

// handle all the rest of the dollars
    $workval = $workval - ($thouval * 1000); // get rid of thousands
    $tensval = (integer)($workval);
    if ($moneystr == "")
    {
        if ($tensval > 0)
        {
            $moneystr = getwords($tensval);
        }
        else
        {
            $moneystr = "Zero";
        }
    }
    else // non zero values in hundreds and up
    {
        $workword = getwords($tensval);
        $moneystr .= " " . $workword;
    }

// done - let's get out of here!
    return $moneystr;
}
//*************************************************************
// this function creates word phrases in the range of 1 to 999.
// pass it an integer value
//*************************************************************
function getwords($workval)
{
    $numwords = array(
        1 => "One",
        2 => "Two",
        3 => "Three",
        4 => "Four",
        5 => "Five",
        6 => "Six",
        7 => "Seven",
        8 => "Eight",
        9 => "Nine",
        10 => "Ten",
        11 => "Eleven",
        12 => "Twelve",
        13 => "Thirteen",
        14 => "Fourteen",
        15 => "Fifteen",
        16 => "Sixteen",
        17 => "Seventeen",
        18 => "Eightteen",
        19 => "Nineteen",
        20 => "Twenty",
        30 => "Thirty",
        40 => "Forty",
        50 => "Fifty",
        60 => "Sixty",
        70 => "Seventy",
        80 => "Eighty",
        90 => "Ninety");

// handle the 100's
    $retstr = "";
    $hundval = (integer)($workval / 100);
    if ($hundval > 0)
    {
        $retstr = $numwords[$hundval] . " Hundred";
    }

// handle units and teens
    $workstr = "";
    $tensval = $workval - ($hundval * 100); // dump the 100's
    if (($tensval < 20) && ($tensval > 0))// do the teens
    {
        $workstr = $numwords[$tensval];
    }
    else // got to break out the units and tens
    {
        $tempval = ((integer)($tensval / 10)) * 10; // dump the units
        $workstr = $numwords[$tempval]; // get the tens
        $unitval = $tensval - $tempval; // get the unit value
        if ($unitval > 0)
        {
            $workstr .= " " . $numwords[$unitval];
        }
    }

// join all the parts together and leave
    if ($workstr != "")
    {
        if ($retstr != "")
        {
            $retstr .= " " . $workstr;
        }
        else
        {
            $retstr = $workstr;
        }
    }
    return $retstr;
}
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
        .thheading{
            text-transform: uppercase;
            background-color: #fff;
        }
    
		.tdtext{
            text-transform: uppercase;
			 align-content: center;
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
            font-size:16px !important;
            font-family: monospace;

        }


		
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
.logo .head1{font-size:27px !important}

    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->
<!-- header end -->
<!-- content starts -->
<div>
<!--<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>-->
    <div class="row body" >
	<div  class="thheading" style="text-align:center">Tax Invoice</div>
	<div>&nbsp;</div>
        <table>
		
<tr>
<td width="50%" >
<div style="border-bottom:1px solid #000; margin-bottom:5px; padding-bottom:5px"><span class="thheading">
<?php echo $comapnydtl['comp_name'];?>
</span><?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Maharashtra,    Code : 27<br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?><br>GSTIN :    <?php echo $comapnydtl['gstin']; ?></div>
		<div><span class="thheading">Buyer</span><br>
		<span class="thheading"><?php echo $resclt['client_name'];?></span><br>
		<?php echo $resclt['client_add1']; ?><br>
		Maharashtra, Code : 27<br>
		GSTIN : <?php echo $resclt['gstno']; ?><br></div>
</td>
<td width="50%" valign="top" class="bordpadd0">
<table style="border:0">
			<tr>
				<td class="thheading">Invoice No.</td>
				<td class="thheading">Date</td>
			</tr>
			<tr>
				<td><?php echo $_REQUEST['invoice'];?></td>
				<td><?php echo date('d/m/Y',strtotime($_REQUEST['invdate']));?></td>
			</tr>
			</table>
			<?php if($clientid ==11){echo "<br>"."Original for Receipient";}?>
			
</td>
</tr>
<tr>
		<td colspan="2" class="bordpadd0" >
		<div>
		
		<div> <?php  if ( date('Y',strtotime($monthtit)) >=2017){ echo "Being Service Rendered for ". date('F-Y',strtotime($monthtit)); }?></div>
		<div>&nbsp;</div>
		<table >
			<tr>
			<td class="thheading" align="center">SrNo</td>
			<td class="thheading" align="center">Particulars</td>
			<td class="thheading" align="center">HSN/SAC</td>
			<td class="thheading" align="center">Per</td>
			<td class="thheading" align="center">Rate</td>
			<td class="thheading" align="center">Amount</td>
			</tr>
			<?php  $srno=0; if ($laborwages >0 ) {$srno++; ?>
			<tr>
			<td align="center"><?php  echo $srno; ?></td>
			<td>Contract Labour Wages</td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"><?php echo number_format($laborwages,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			<?php  if ($esi >0 ) { $srno++;?>
			<tr>
			<td align="center"><?php echo $srno; ?></td>
			<td>E.S.I</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($esi,2,'.',',');?></td>
			<td align="right"><?php echo $esiper; //4.75?>%</td>
			<td align="right"><?php echo number_format($esiamount,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			<?php  if ($pf >0 ) { $srno++; ?>
			
			<tr>
			<td align="center"><?php echo $srno; ?></td>
			<td>P.F.</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($pf,2,'.',',');?></td>
			<td align="right"><?php echo $pfper; //13.15?>%</td>
			<td align="right"><?php echo number_format($pfamount,2,'.',',');?></td>
			</tr>
				<?php } ?> 
			<!----- income and deduction rows start-->
			<?php  if($_REQUEST['inctext1field'] !=""){ $srno++;?>
			<tr>
			<td align="center"><?php echo $srno;?></td>
			<td><?php echo $_REQUEST['inctext1field']; ?></td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"><?php //echo $pfper; //13.15?></td>
			<td align="right"><?php echo number_format($inctext1,2,'.',',');?></td>
			</tr>
			<?php } ?>
			<?php if($_REQUEST['inctext2field'] !=""){ $srno++;?>
			<tr>
			<td align="center"><?php echo $srno;?></td>
			<td><?php echo $_REQUEST['inctext2field'];?></td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"><?php //echo $pfper; //13.15?></td>
			<td align="right"><?php echo number_format($inctext2,2,'.',',');?></td>
			</tr>
			<?php } ?>
			
			<!----- income and deduction rows end-->
			
			
			
			<tr>
			<td align="center"><?php $srno++; echo $srno;  ?></td>
			<td>Service Charges</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($seramt,2,'.',',');//$servicecharge; ?></td>
			<td align="right"><?php echo $serchargesper;?>%</td>
			<td align="right"><?php echo number_format($servicecharge,2,'.',',');// $servicechargeamt;?></td>
			</tr>
			<tr>
			<td align="center"><?php $srno++; echo $srno;  ?></td>
			<td>SGST</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?php echo $gstper; //9?>%</td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="center"><?php  $srno++; echo $srno; ?></td>
			<td>CGST</td>
			<td align="center"> 9985</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?php echo $gstper; //9?>%</td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="right"><?php $total=$laborwages+$esiamount+$pfamount+$servicecharge+($sgstamount*2)+$inc_amt1+$inc_amt2;
			echo number_format($total,2,'.',',')?> </td>
			</tr>
			
			
			<!-- <tr>
			<td  class="thheading" colspan="6">Amount Chargeable (in words) <br> (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only ) </td>
			</tr> -->
		</table>
		Amount Chargeable (in words) <br> (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only )
		</div>
		</td>
	</tr>
	<tr><td colspan="2" class="bordpadd0" >
	<table cellpadding="0" cellspacing="0" style = "border:none;">
	<tr>
			<td class="thheading" width="30%" align="center"> HSN/SAC</td>
			<td class="thheading" align="center" width="20%">Taxable value</td>
			<td class="thheading" colspan="2" align="center" width="25%">Central Tax</td>
			<td class="thheading" colspan="2" align="center" width="25%">State Tax</td>
			<td class="thheading" align="center" width="25%">Total Tax</td>
			
			</tr>
			<tr>
			<td > </td>
			<td ></td>
			<td width="12.5%" align="center">Rate</td>
			<td width="12.5%" align="right">Amount</td>
			<td width="12.5%" align="center">Rate</td>
			<td width="12.5%" align="right">Amount</td>
			<td width="12.5%" align="right">Amount</td>
			</tr>
			<tr>
			<td > 9985</td>
			<td  align="right"> <?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="center"><?php echo $gstper; //9?>%</td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td align="center"><?php echo $gstper; //9?>%</td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td  align="right"> </td>
			</tr>
			<tr>
			<td > &nbsp; Total</td>
			<td  align="right"> <?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="center"></td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td align="center"></td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td  align="right"> <?php echo number_format($sgstamount+$sgstamount,2,'.',',');?> </td>
			
			</tr>	
			<tr>
			<td  class="thheading" colspan="7">Tax Amount (in words)  : <br> (Indian Rupees <?php echo makewords($sgstamount*2); ?> ) </td>
			</tr>
			<tr>
			<td  class="thheading" colspan="6">Total Bill Amount </td><td align="right"><?php echo number_format($total,2,'.',',');?>
</td>
			</tr>
			<tr>
			<td  class="thheading" >Less </td>
			<td  class="thheading" colspan="5" align="right"> CANTEEN &nbsp; <?php //echo $canteen;?> </td>
			<td align="right"><?php echo number_format($canteen,2,'.',',');?>
			</td>
			</tr>
			<tr>
			<td  class="thheading" > </td>
			<td  class="thheading" colspan="5" align="right"> TRANSPORT &nbsp; <?php //echo $transport;  ?></td>
			<td align="right"><?php echo number_format($transport,2,'.',',');?>
			</td>
			</tr>
			
			
			<?php if($_REQUEST['dedtext1text'] !=""){?>
			<tr>			
			<td></td>			
			<td align="right" colspan="5" class="thheading"><?php echo $_REQUEST['dedtext1text'];?> </td>
			<td align="right"><?php //echo $pfper; //13.15?> <?php echo number_format($dedtext1,2,'.',',');?></td>
			</tr>
			<?php } ?>
			<?php if($_REQUEST['dedtext2text'] !=""){?>
			<tr>
			
			<td></td>
			<td align="right" colspan="5" class="thheading"> <?php echo $_REQUEST['dedtext2text'];?> </td>
			<td align="right"><?php  echo number_format($dedtext2,2,'.',',');?></td>
			</tr>
			<?php } ?>
			
			
			<tr>
			<td  class="thheading" > </td>
			<td  class="thheading" colspan="5" align="right">  <?php $ammn =$canteen+$transport+$dedtext1+$dedtext2; //echo number_format($ammn,2,'.',',');?></td>
			<td align="right"><?php  $tt =$total-$ammn; echo number_format($tt,2,'.',',');?>
			</td>
			</tr>
			<tr>
			
			
			<td colspan="2">
			<div>Bank Details</div>
				<div style="width:25%; float:left">Bank </div><div>:-  <?php echo $compbankdtl['bank_name']; ?></div>
				<div style="width:25%; float:left">Branch </div><div>:-  <?php echo $compbankdtl['branch']; ?></div>
				<div style="width:25%;  float:left">A/c No</div><div>:-  <?php echo $comapnydtl['bankacno']; ?></div>
				<div style="width:25%;  float:left">IFSC </div><div>:-  <?php echo $compbankdtl['ifsc_code']; ?></div>
				<div style="clear:both">&nbsp; </div>
			
			</td>
			<td colspan="2"></td>
			<td colspan="3" align="center" style="font-size:12px!important;" >For  <?php echo $comapnydtl['comp_name'];?> <br><br><br><br> Authorised Signatory</td>			
			</tr>
			<tr>
			<td colspan="7">			
			PAN NO.: <?php echo $comapnydtl['pan_no']; ?>
			</td>			
			</tr>
	</table>	
	</td></tr>
</table>
        </div>
<br/><br/>
    </div>
<!-- content end -->
<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>