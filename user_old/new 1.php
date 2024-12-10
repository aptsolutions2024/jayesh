<?php
session_start();
//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_POST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

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

if($emp=='Parent')
	{
	$sqlcontlabw ="select sum(gross_salary) gsal from $tab_emp te inner join mast_company mc on te.comp_id = mc.comp_id inner join mast_client mcl on mcl.mast_client_id = te.client_id where mcl.parentid='".$clientid."' and te.sal_month ='".$frdt."'";
	
	$sqlesi ="select sum(std_amt) esi from 	
	$tab_empded te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
	where mcl.parentid='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%E.S.I.%'";
	 
	 $sqlpf ="select sum(std_amt) pfsum from 	
	$tab_empded te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
	where mcl.parentid='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%P.F.%'";
	
	$sqlovertime ="select sum(std_amt) ot from 	
	$tab_empinc te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_income_heads mih on mih.mast_income_heads_id = te.head_id 	
	where mcl.parentid='".$clientid."' and te.sal_month ='".$frdt."' and mih.income_heads_name like '%OVERTIME%'";
	
	}
else{
	
	$sqlcontlabw ="select sum(gross_salary) gsal from $tab_emp te inner join mast_company mc on te.comp_id = mc.comp_id where te.client_id='".$clientid."' and te.sal_month ='".$frdt."'";
	
	 $sqlesi ="select sum(std_amt) esi from 	
	$tab_empded te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 		
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%E.S.I.%'";
	
	$sqlpf ="select sum(std_amt) pfsum from 	
	$tab_empded te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%P.F.%'";
	 
	$sqlovertime ="select sum(std_amt) ot from 	
	$tab_empinc te inner join employee em on te.emp_id = em.emp_id
	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
	inner join mast_income_heads mih on mih.mast_income_heads_id = te.head_id 	
	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.income_heads_name like '%OVERTIME%'";
}
/// for calculate wages
$rescontlabw = mysql_query($sqlcontlabw);
$rowcontlabw = mysql_fetch_assoc($rescontlabw);
$laborwages = round($rowcontlabw['gsal']);

/// for calculate esi
$resesi = mysql_query($sqlesi);
$rowesi = mysql_fetch_assoc($resesi);
$esi = round($rowesi['esi']);
if($esi ==""){ $esi=0;}

/// for calculate pf
$respf = mysql_query($sqlpf);
$rowpf = mysql_fetch_assoc($respf);
$pf = round($rowpf['pfsum']);
if($pf ==""){ $pf=0;}

/// for calculate overtime
$resot = mysql_query($sqlovertime);
$rowot = mysql_fetch_assoc($resot);
$ot = round($rowot['ot']);
if($ot ==""){ $ot=0;}

// esi amount
$esiamount = $esi*4.75/100;
$esiamount = round($esiamount);
// pf amount
$pfamount = $pf*13.15/100;
$pfamount = round($pfamount);

// $service charge per
//$servicecharge = $laborwages+$esiamount+$pfamount;
//$servicecharge = round($servicecharge);
/// $service charge amount
//$servicechargeamt =  round($servicecharge*10.50/100);

// SGST/CGST per

if($clientid ==1 || $clientid ==4 || $clientid ==6){ //lokmat
	$servicecharge = ($laborwages+$pf+$esi)*10.5/100;
	$servicecharge = round($servicecharge);
}else if($clientid ==2){ // l&t
	$servicecharge = ($laborwages+$pf+$esi)*6/100;
	$servicecharge = round($servicecharge);
}else if($clientid ==3 || $clientid ==10){ // BAKER GAUGES
	$servicecharge = ($laborwages)*11.5/100;
	$servicecharge = round($servicecharge);
}else if($clientid ==5){ //WIKAS PRINTING & CARRIERS
	$servicecharge = ($laborwages)*12.5/100;
	$servicecharge = round($servicecharge);
}else if($clientid ==7 || $clientid ==8 || $clientid ==9){ //SAKAL PAPERS LTD., NASHIK
	$servicecharge = ($laborwages)*12.5/100;
	$servicecharge = round($servicecharge);
}else if($clientid ==11){ //MAHINDRA TSUBAKI 
//echo $ot."==".$laborwages;
	$servicecharge = ($laborwages-$ot)*9/100;
	$servicecharge = round($servicecharge);
}/*else if($clientid ==12 || $clientid ==13 || $clientid ==14 || $clientid ==15 || $clientid ==16 ){ //MAHINDRA TSUBAKI 
	$servicecharge = ($sqlcontlabw-$ot)*9/100;
}*/else{
	// $service charge per
$servicecharge = $laborwages+$esiamount+$pfamount;
$servicecharge = round($servicecharge);
}

/// $service charge amount
$servicechargeamt =  $servicecharge*10.50/100;
$servicechargeamt = round($servicechargeamt);

$sgst = $servicecharge+$servicechargeamt;
$sgst = round($sgst);

// SGST/CGST per
$sgstamount = $sgst *9/100;
$sgstamount = round($sgstamount);

/// total
$total =$laborwages+$esiamount+$pfamount+$servicechargeamt+$sgstamount+$sgstamount;
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

function convert_number_to_words($number){
		//$number = 190908100.25;
       $hyphen      = ' ';
    $conjunction = '  ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
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
            font-weight: bold;
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
            border: 1px dotted black!important;
            font-size:12px !important;
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
				<td><?php echo $_POST['invoice'];?></td>
				<td><?php echo date('d/m/Y',strtotime($_POST['invdate']));?></td>
			</tr>
			</table>
			
</td>
</tr>
<tr>
		<td colspan="2" class="bordpadd0" >
		<div>
		<div>Being Service Rendered for <?php echo date('F-Y',strtotime($cmonth));?></div>
		<div>&nbsp;</div>
		<table >
			<tr>
			<td class="thheading" align="center">Sr No.</td>
			<td class="thheading" align="center">Particulars</td>
			<td class="thheading" align="center">HSN/SAC</td>
			<td class="thheading" align="center">Per</td>
			<td class="thheading" align="center">Rate</td>
			<td class="thheading" align="center">Amount</td>
			</tr>
			
			<tr>
			<td>1</td>
			<td>Contract Labour Wages</td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"><?php echo $laborwages; ?></td>
			</tr>
			<tr>
			<td>2</td>
			<td>E.S.I</td>
			<td align="center">9985</td>
			<td align="right"><?php echo $esi; ?></td>
			<td align="right">4.75%</td>
			<td align="right"><?php echo $esiamount;?></td>
			</tr>
			<tr>
			<td>3</td>
			<td>P.F.</td>
			<td align="center">9985</td>
			<td align="right"><?php echo $pf;?></td>
			<td align="right">13.15%</td>
			<td align="right"><?php echo $pfamount; ?></td>
			</tr>
			<tr>
			<td>4</td>
			<td>Service Charges</td>
			<td align="center">9985</td>
			<td align="right"><?php echo $servicecharge; ?></td>
			<td align="right">9%</td>
			<td align="right"><?php echo $servicechargeamt;?></td>
			</tr>
			<tr>
			<td>5</td>
			<td>SGST</td>
			<td align="center">9985</td>
			<td align="right"><?php echo $sgst;?></td>
			<td align="right">9%</td>
			<td align="right"><?php echo $sgstamount;?></td>
			</tr>
			<tr>
			<td>6</td>
			<td>CGST</td>
			<td align="center"> 9985</td>
			<td align="right"><?php echo $sgst;?></td>
			<td align="right">9%</td>
			<td align="right"><?php echo $sgstamount;?></td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="right"><?php echo $total;?> </td>
			</tr>
			
			
			<tr>
			<td  class="thheading" colspan="6">Amount Chargeable (in words) <br> (Indian Rupees  <?php echo convert_number_to_words($total); ?> Only ) </td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	<tr><td colspan="2" class="bordpadd0">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<td class="thheading" width="30%" align="center"> HSN/SAC</td>
			<td class="thheading" align="center" width="20%">Taxable value</td>
			<td class="thheading" colspan="2" align="center" width="25%">Central Tax</td>
			<td class="thheading" colspan="2" align="center" width="25%">State Tax</td>
			</tr>
			<tr>
			<td > </td>
			<td ></td>
			<td width="12.5%">Rate</td>
			<td width="12.5%">Amount</td>
			<td width="12.5%">Rate</td>
			<td width="12.5%">Amount</td>
			</tr>
			<tr>
			<td > 9985</td>
			<td  align="right"> <?php echo $sgst;?></td>
			<td align="center">9%</td>
			<td  align="right"> <?php echo $sgstamount;?> </td>
			<td align="center">9%</td>
			<td  align="right"> <?php echo $sgstamount;?> </td>
			</tr>
			<tr>
			<td > &nbsp; Total</td>
			<td > </td>
			<td align="center"></td>
			<td  align="right"> <?php echo $sgstamount;?> </td>
			<td align="center"></td>
			<td  align="right"> <?php echo $sgstamount;?> </td>
			</tr>	
			<tr>
			<td  class="thheading" colspan="6">Tax Amount (in words)  : <br> (Indian Rupees <?php echo convert_number_to_words($sgstamount*2); ?> ) </td>
			</tr>
			<tr>
			<td  class="thheading" colspan="5">Total Bill Amount </td><td align="right"><?php echo $total;?>
</td>
			</tr>
			<tr>
			<td colspan="2">
			<div>Bank Details</div>
				<div style="width:25%; float:left">Bank </div><div>:-  <?php echo $compbankdtl['bank_name']; ?>,<?php echo $compbankdtl['branch']; ?></div>
				<div style="width:25%;  float:left">Bank A/c </div><div>:-  <?php echo $comapnydtl['bankacno']; ?></div>
				<div style="width:25%;  float:left">Bank IFSC </div><div>:-  <?php echo $compbankdtl['ifsc_code']; ?></div>
				<div style="clear:both">&nbsp; </div>
			
			</td>
			<td ></td>
			<td colspan="3" align="center">For  <?php echo $comapnydtl['comp_name'];?> <br><br><br><br> Authorised Signatory</td>
			
			
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