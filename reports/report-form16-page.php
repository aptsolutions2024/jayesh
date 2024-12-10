<?php
session_start();
ini_set('output_buffering', true); // no limit

error_reporting(0);
$month=$_SESSION['month'];
//include('../fpdf/html_table.php');

$name=$_REQUEST['name'];
 $name_arr = explode(" ",$name);
 $name = $name_arr[0]." ".$name_arr[1]." ".$name_arr[2];
$empid=$_REQUEST['empid'];
$year=$_REQUEST['year'];

$yearex = explode(' ',$year);
$yearexy1 = $yearex[0]+1;
$yearexy2 = $yearex[2]+1;
$nextyear = $yearexy1." - ".$yearexy2;
$frdt = $yearex[0].'-04-30';
$todt=$yearex[2].'-03-31';
$frdt = date("Y-m-d",strtotime($frdt));
$todt = date('Y-m-d',strtotime($todt));


$yearbonusy1 = $yearex[0]-1;
$yearbonusy2 = $yearex[2]-1;

$bonus_fromdate=$yearbonusy1."-04-30";
$bonus_todate="20".$yearbonusy2."-03-31";






 //print_r($yearex);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include("../lib/class/admin-class.php");
$adminObj=new admin();


$rdcomp=$adminObj->displayCompany($comp_id);
$compname=$rdcomp['comp_name'];


if($year!=''){
    $reporttitle="Form 16 year- ".$year;
}

$name1=explode(" ",$name);

$_SESSION['client_name']=$name1[4].' '.$name1[5].' '.$name1[6];
$_SESSION['reporttitle']=strtoupper($reporttitle);

/*  $sqlfile ="SELECT id FROM `it_file1` WHERE `year` LIKE '".$year."' AND `emp_id` = '".$empid."'";

$resfile = mysql_query($sqlfile);
$rowfile = mysql_fetch_array($resfile);*/
$rowfile = $userObj1->getItFile1($year,$empid);

//echo  $sqlfile1 ="SELECT * FROM `it_file1` i1,itconst i2  WHERE i1.id='".$rowfile['id']."' AND `year` LIKE '".$year."'";
 /*   $sqlfile1 ="SELECT * FROM it_file1 i1 inner join itconst i2 on i1.year=i2.year AND i1.comp_id=i2.comp_id Where i1.`year`='".$year."' AND i1.emp_id='".$empid."'";

$resfile1 = mysql_query($sqlfile1);
$rowfile1 = mysql_fetch_array($resfile1);*/
$rowfile1 = $userObj1->getItFile1_1($year,$empid);

/* $sqlfileemp ="SELECT * FROM `employee` WHERE emp_id='".$empid."'";
$resfileemp = mysql_query($sqlfileemp);
$rowfileemp = mysql_fetch_array($resfileemp);*/
$rowfileemp = $userObj1->showEployeedetails($empid,$comp_id,$user_id);

/*$sqlfileitconst ="SELECT * FROM `itconst` WHERE user_id='".$empid."'";
$resfileitconst = mysql_query($sqlfileitconst);
$rowfileitconst = mysql_fetch_array($resfileitconst);*/
$rowfileitconst = $userObj1->getItConst($empid);
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
        .heading{
            margin: 20px 20px;
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
			margin-left : 12px;
			margin-lright : 10px;
            width: 98%;
        }

        table, td, th {
            padding: 3px!important;
            border: 1px dotted black!important;
            font-size:13px !important;
            font-family: monospace;
        }
		ol{ list-style: lower-roman;}
		div,li{list-style: lower-roman;font-size:14px !important;
            font-family: monospace;}
			div{padding:5px}
		.innertable{float:right;width: 80%; margin-top:5px}
		.bord0{border:0 !important;}
		.alcenter{text-align:center}
		.spanbr {border-bottom:1px dotted #000;     clear: both;}
		.bordr {border-right:1px dotted #000;}
		.paddtb5px{padding-top:5px; padding-bottom:5px}
		.diw50per{width:50%; display:inline}
		.padd0{padd0}
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
                display:block!important;
            }
            #footer {
                display:none!important;
            }
            .body { padding: 5px; }
            body{
                margin-left: 50px;
				margin-top :10px;
            }
        }
		@page {
   
				margin: 20mm 10mm 20mm 10mm;
			}


        @media all {
			 
           #watermark {
                display: none;
                float: right;
            }

            .pagebreak {
                display: none;
				margin-top :50px;
            }

            #header, #footer {
                display:none!important;
                margin-left: 50px;
				margin-top :10px;

            }
            #footer {
                display:none!important;
            }
        }
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


<?php

$q2 = $userObj->getHistEmpForm16($empid,$frdt,$todt);
//history records
echo '<div class= "row body page page-bk"> <table width = "100%"><tr><td colspan =2 align="center"><b>'.$name.'</b></td></tr>';
$cnt=0;
$sal = 0;
while ($q3=$q2->fetch_array())
{
	echo '<tr><td>'.date("M Y",strtotime($q3["sal_month"])).'</td><td align="right">'.number_format($q3["gross_salary"],2,".",",").'</td></tr>';
	$cnt++;
	$sal+=$q3['gross_salary'];
	$last_sal = $q3['gross_salary'];
	$last_sal_month  =$q3["sal_month"];
	
}
//current month

$q2 = $userObj->getTranEmpForm16($empid,$frdt,$todt);
while ($q3=$q2->fetch_array())
{
	echo '<tr><td>'.date("M Y",strtotime($q3["sal_month"])).'</td><td align="right">'.number_format($q3["gross_salary"],2,".",",").'</td></tr>';
	$cnt++;
	$sal+=$q3['gross_salary'];
	$last_sal = $q3['gross_salary'];
	
}

if ($last_sal_month != $todt )
{
$projected_sal= $last_sal*(12-$cnt);
echo '<tr><td> Projected Salary</td><td align="right">'.number_format($projected_sal,2,".",",").'</td></tr>';
}
else
{
$projected_sal= 0;
echo '<tr><td> Projected Salary</td><td align="right">'.number_format($projected_sal,2,".",",").'</td></tr>';
	
}
//bonus
/**/
$q2 = $userObj->getBonusForm16($empid,$bonus_fromdate,$bonus_todate);
while ($q3=$q2->fetch_array())
{
	echo '<tr><td> Bonus</td><td align="right">'.number_format($q3["amount"],2,".",",").'</td></tr>';
	$cnt++;
	$sal+=$q3['amount'];
	$last_sal = $q3['amount'];
	
}

//leave payment

$q2 = $userObj->getLeavePaymentForm16($empid,$frdt,$todt);
while ($q3=$q2->fetch_array())
{
	echo '<tr><td> Leave Encashment</td><td align="right">'.number_format($q3["amount"],2,".",",").'</td></tr>';
	$cnt++;
	$sal+=$q3['amount'];
	$last_sal = $q3['amount'];
	
}


echo '<tr><td> Total Salary</td><td align="right">'.number_format($projected_sal+$sal,2,".",",").'</td></tr>';



echo '</table></div>';
?>
<?php 


//    <div class="row body page-bk" >
//</div>

 //$header=include("printheader.php");
$tablehtml='
<div>
<div> </div>';
/* from 16 part a */
$tablehtmlparta.='
	<div class="alcenter thheading">FORM NO.16 (Annexure)</div>
	<div class="alcenter ">[See rule 31(1)(a)]</div>
	<div class="alcenter thheading">PART A</div>
	<div class="row body " >
        <table width="80%!important" border="1" style=" margin-left : 10px;
			margin-lright : 10px;"
            >';
		
$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="5" align="center" class="thheading"> Certificate under section 203 of the Income-tax Act, 1961 for tax deducted at source on salary </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="2" class="thheading" > Certificate No. </td>';
$tablehtmlparta.='<td colspan="3" class="thheading" > Last updated on </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="2" class="thheading"> &nbsp;</td>';
$tablehtmlparta.='<td colspan="3" class="thheading">  &nbsp; </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="2" class="thheading">Name and address of the Employer</td>';
$tablehtmlparta.='<td colspan="3" class="thheading">  Name and address of the Employee </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="2" >'.$compname.'</td>';
$tablehtmlparta.='<td colspan="3" > '.$name.'  </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" width="20%" align="center">PAN of the Deductor</td>';
$tablehtmlparta.='<td class="thheading" width="20%" align="center">TAN of the Deductor</td>';
$tablehtmlparta.='<td class="thheading" width="20%" align="center">PAN of the Employee</td>';
$tablehtmlparta.='<td colspan="2" class="thheading" width="40%" align="center">  Employee Reference No.provided by the Employer(If available) </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
if($comp_id==1){
$tablehtmlparta.='<td class="thheading" width="20%" align="center">AACFI1059F</td>';

$tablehtmlparta.='<td class="thheading" width="20%  align="center">PNEI03417B</td>';

}else
{$tablehtmlparta.='<td class="thheading" width="20%" align="center">AAAFI3587J</td>';

$tablehtmlparta.='<td class="thheading" width="20%  align="center">PNEI04568E</td>';

}	
$tablehtmlparta.='<td class="thheading" width="20%" align="center">'.$rowfileemp['panno'].'</td>';
$tablehtmlparta.='<td colspan="2" class="thheading" width="40%"  align="center">  &nbsp; </td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" width="40%" colspan="2">CIT (TDS) <div class="spanbr"></div><div  class="paddtb5px">Address :  1117/5A, OFF Ganeshkhind Rd,</div><div class="paddtb5px"> City: Pune</div><div class="paddtb5px"> Pin code: 411016</div></td>';
$tablehtmlparta.='<td  width="20%" valign="top" align="center"><span class="thheading">Assessment Year</span><div class="spanbr"></div><div class="paddtb5px">'.$nextyear.'</div></td>';
$tablehtmlparta.='<td colspan="2"  width="40%" valign="top" align="center"><span class="thheading"> Period with the Employer </span><div class="spanbr"></div>
<div class="diw50per alcenter bordr thheading" style="float:left" >From</div>
<div class="diw50per alcenter thheading" style="float:right" >To</div>
<div class="spanbr padd0"></div>
<div class="diw50per alcenter bordr" style="float:left; height:47px"> 1st April '.$yearex[0].' </div>
<div class="diw50per alcenter" style="float:right">31st March '.$yearexy1.' </div>

</td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" colspan="5" align="center">Summary of amount paid/credited and tax deducted at source thereon in respect of the employee
</td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top">Quarter(s)</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Receipt Numbers of original quarterly statements of TDS under sub-section (3) of section 200</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Amount paid/credited</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Amount of tax deducted (Rs. )</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Amount of tax deposited/remitted (Rs. )</td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top"><div>1</div><div>2</div><div>3</div><div>4</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"><div>'.$rowfileitconst['Q1_amt_challan'].'</div><div>'.$rowfileitconst['Q2_amt_challan'].'</div><div>'.$rowfileitconst['Q3_amt_challan'].'</div><div>'.$rowfileitconst['Q4_amt_challan'].'</div></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"><div>'.$rowfileitconst['Q1_amt_paid'].'</div><div>'.$rowfileitconst['Q2_amt_paid'].'</div><div>'.$rowfileitconst['Q3_amt_paid'].'</div><div>'.$rowfileitconst['Q4_amt_paid'].'</div></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"><div>'.$rowfileitconst['Q1_amt_deducted'].'</div><div>'.$rowfileitconst['Q2_amt_deducted'].'</div><div>'.$rowfileitconst['Q3_amt_deducted'].'</div><div>'.$rowfileitconst['Q4_amt_deducted'].'</div></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"><div>'.$rowfileitconst['Q1_amt_deposited'].'</div><div>'.$rowfileitconst['Q2_amt_deposited'].'</div><div>'.$rowfileitconst['Q3_amt_deposited'].'</div><div>'.$rowfileitconst['Q4_amt_deposited'].'</div></td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top">Total (Rs.)</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='</tr>';
	
$tablehtmlparta.='
</table></div>
';

$result1 = $userObj->getHistDedForm16($empid,$frdt,$todt);
										
$tabdeposit = "<div class='row body ' >
&nbsp;&nbsp;II.DETAILS TAX DEDUCTED AND DEPOSITED INTO CENTRAL GOVERNMENT ACCOUNT THROUGH BOOK CHALLANA <br>										
        <table width='80%!important' border='1' style='margin-left : 10px;
			margin-lright : 10px;'
            >
			<tr>
			<td rowspan = 2>Sr.No</td> 
			<td rowspan= 2>Tax Deposited In Respect of the deducter (Rs)</td>
			<td colspan = 3 align ='center'>  Book Identification Number (CIN) </td>
			</tr>
			<tr><td>BRS Code of  the Bank Branch</td><td>Date on Which Tax Deposited(dd/mm/yyyy)</td><td>Challana Serial Number</td></tr>
			<tr><td>";
			
			for ($i= 1;$i<=12;$i++)
			{
				$tabdeposit .="<tr>	<td>";
				$tabdeposit .=$i;
				$result1 = mysql_fetch_array($result);
				$tabdeposit .="</td><td>";
				 if ($result1['sal_month']!=''){ $tabdeposit .= date('d-m-Y',strtotime($result1['sal_month']));}
					$tabdeposit .="</td><td>";
					if ($result1['sal_month']!=''){ $tabdeposit .= 'BBBBBB';}
					$tabdeposit .="</td><td>";
					if ($result1['sal_month']!=''){ $tabdeposit .= date('d-m-Y',strtotime($result1['deposite_date']));}
					$tabdeposit .="</td><td>";
					if ($result1['sal_month']!=''){ $tabdeposit .= $result1['challan_no'];}
					$tabdeposit .="</td></tr>";
				
			}
			
			
	$tabdeposit .="</table></div>";

/* form 16 part b */
$tablehtml.='


    <div class="row body " >
	<div class="alcenter thheading">FORM 16 PART B (Annexure)</div>
        <table width="100%" border="1">';

$tablehtmlh1 =' <tr>
                <td colspan="4" class="thheading">
                Details of Salary paid and any other income and tax deducted
               </td>
               </tr>';

$tablehtmlh2=' <tr>
                <td class="thheading">
                   Details of Salary paid and any other income and tax deducted
               </td>  <td align="center" width="10%">
                </td>
                <td width="10%">
                </td>
                <td width="10%">
                </td>
               </tr>';
$tablehtml1.='
            <tr>
                <td width="45%" >
                    1 Gross Salary
                </td>
                <td align="center" width="10%">
                   Rs.'.$rowfile1["col_1"].'
                </td>
                <td width="10%">

                </td>
                <td width="10%">

                </td>
            </tr>
            <tr>
                <td>
                    (a) Salary as per provisions contained in sec.
                    17(1)
                </td>
                <td align="center">
                    Rs.'.$rowfile1["col_1a_1"].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
           <tr>
                <td>
                    (b) Value of perquisites u/s 17(2) (as per Form
                    No.12BA, wherever applicable)
                </td>
               <td align="center">
                    Rs.'.$rowfile1['col_1b_1'].'
                </td>
                <td>

                </td>
               <td>

               </td>
            </tr>

            <tr>
                <td>
                    (c) Profits in lieu of salary under section 17(3)(as
                    per Form No.12BA, wherever applicable)
                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_1c_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    (d) Total
                </td>
                <td>

                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_1d_2'].'
                </td>
                <td>

                </td>
            </tr>


            <tr>
                <td>
                    2 Less: Allowance to the extent exempt u/s 10 <br />';
$tablehtml1.="<table class='innertable'>";
$tablehtml1.="<tr><td align='center'>Allowance</td><td align='center'>Rs.</td></tr>";
//$res=$userObj->displayintaxallow($rowfile1['emp_id'],$year);

$res= $userObj->getITFile3($rowfile1['emp_id'],$year);

$tcount=mysqli_num_rows($res);

if($tcount!=0) {
while($row = $res->fetch_array()) {

$tablehtml1.="  <tr><td>".$row['allow_name']."</td><td width='30%'>     Rs.".$row['allow_amt']."</td></tr>";
}
}
$tablehtml1.="</table>";
$tablehtml1.='    </td>
                <td align="center">
                    Rs.'.$rowfile1['col_2_1'].'
                </td>
                <td align="center">
                  Rs.'.$rowfile1['col_2_2'].'
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    3 Balance (1-2)
                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_3_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    4 Deductions :
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    (a) Standard Deduction
                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_4a_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    (b) Entertainment allowance
                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_4b_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    (c) Tax on employment
                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_4c_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    5 Aggregate of 4(a) and (b)
                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_5_1'].'
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    6 Income chargeable under the head ‘Salaries’ (3-5)
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_6_2'].'
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    7 Add: Any other income reported by the employee

                     <br />';
$tablehtml1.="<table class='innertable'>";
$tablehtml1.="<tr><td align='center'>Income</td><td align='center'>Rs.</td></tr>";
$grosssal = $rowfile1['col_8_2'];
//$res=$userObj->displayintaxincome($rowfile1['emp_id'],$year);


$res = $userObj->getIncomeITFile3($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);
if($tcount!=0) {
    while($row = $res->fetch_array()) {

        $tablehtml1.="  <tr><td>".$row['income_desc']." </td><td width='30%'>    Rs.".$row['income_amt']."</td></tr>";
		$incamt = $row['income_amt'];
		$incimt1 += $incamt;
		
    }
	$grosssal = $rowfile1['col_8_2']; 
}
$tablehtml1.="</table>";
$tablehtml1.='  </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_7_2'].'
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    8 Gross total income (6+7)
                </td>
                <td >
                   
                </td>
                <td align="center">
						Rs.'.$grosssal.'
                </td>
                <td>
                </td>
            </tr>
           <tr>
                <td>
                    9 Deductions under Chapter VI-A
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    (A) sections 80C, 80CCC and 80CCD
                       <br />';
$tablehtml1.="<table class='innertable bord0'>";

//$res=$userObj->displayintaxc($rowfile1['emp_id'],$year);

 $res = $userObj->getIncomeITFile3_2($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);

if($tcount!=0) {$i=1;
   while($row = $res->fetch_array()) {
       //$tablehtml1.=" (".rome($i).")  ".$row['80C_desc']."     ".$row['80c_amt']."</br>";
	   $tablehtml1.="<tr><td class='bord0'> (".strtolower(rome($i)).")  ".$row['80C_desc']. "</td></tr>";
      $i++;
 }
}
$tablehtml1.="</table>";

$tablehtml1.='</td>
                <td>';
$tablehtml1.="<table class=' bord0'>";

//$res=$userObj->displayintaxc($rowfile1['emp_id'],$year);
 
 $res = $userObj->getIncomeITFile3_3($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);

if($tcount!=0) {$i=1;
   while($row = $res->fetch_array()) {
	   
	   $tablehtml1.="<tr><td class='bord0' align='center'> Rs.".$row['80c_amt']."</td></tr>";
      $i++;
 }
}
$tablehtml1.="</table>";
$tablehtml1.='</td>
                <td>
                </td>
                <td>
                </td>
            </tr>
               <tr>
                <td>
                    (a) section 80C
                </td>
                <td>

                </td>
                   <td align="center">
                    Rs.'.$rowfile1['col_9a_2'].'
                </td>
                   <td align="center">
                    Rs.'.$rowfile1['col_9a_3'].'
                </td>
            </tr>
           <tr>
                <td>
                    (b) section 80CCC
                </td>
                <td>

                </td>
                  <td align="center">
                      Rs.'.$rowfile1['col_9b_2'].'
                  </td>
                  <td >
                  </td>
            </tr>
            <tr>
                <td>
                    (c) section 80CCD<br />
                    Note : 1. Aggregate amount deductible under
                    sections 80C, 80CCC and 80CCD(1) shall not
                    exceed one lakh fifty thousand rupees.
                </td>
                <td>
                </td>
				<td align="center">
                      Rs.'.$rowfile1['col_9b_3'].'
                  </td>
                <td align="center">
                      Rs.'.$rowfile1['col_9c_3'].'
				
                </td>
            </tr>
            <tr>
                <td>
                    (B) Other sections (e.g. 80E, 80G, 80TTA, etc.)
                    under Chapter VI-A.
    </td>
                <td>
Gross
amount
                </td>
                <td>
Qualifying
amount
                </td>
                <td>
Deductible
amount
                </td> </tr>';

/*$res=$userObj->displayintaxchapter($rowfile1['emp_id']);
$tcount=mysql_num_rows($res);

if($tcount!=0) {$i=1;
    while($row = mysql_fetch_array($res)) {

        $tablehtml1.="<tr> <td style='margin-left:10%'>  (".rome($i).") section ".$row['section_name']."</td>
                <td>".$row['gross_amt']."</td> <td>".$row['qual_amt']."</td><td>".$row['deduct_amt']."</td></tr>";
        $i++;
    }

}*/
$tablehtml1.='<tr><td     style="padding-left: 13% !important;">';
//$res=$userObj->displayintaxchapter($rowfile1['emp_id'],$year);
       
$res = $userObj->getIncomeITFile3_4($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);

if($tcount!=0) {$i=1;
    while($row = $res->fetch_array()) {
		if($row['section_name'] !=""){
			$gamt = $row['section_name'];
		}else{
			$gamt =0;
		}
        $tablehtml1.="<div>(".strtolower(rome($i)).") section ".$row['section_name']."</div>";
        $i++;
    }

}
$tablehtml1.='</td><td>';
//$res=$userObj->displayintaxchapter($rowfile1['emp_id'],$year);
       
$res = $userObj->getIncomeITFile3_5($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);
if($tcount!=0) {$i=1;
    while($row = $res->fetch_array()) {
		if($row['gross_amt'] !=""){
			$gamt = $row['gross_amt'];
		}else{
			$gamt =0;
		}

        $tablehtml1.="<div>Rs.".$gamt."</div>";
        $i++;
    }

}
$tablehtml1.='</td><td>';
//$res=$userObj->displayintaxchapter($rowfile1['emp_id'],$year);
/*$sql = "SELECT * FROM it_file3 WHERE emp_id='".$rowfile1['emp_id']."' AND year='".$year."' AND  (section_name!='' OR gross_amt!='0'  OR qual_amt!='0' OR deduct_amt!='0' )  ORDER BY id DESC";
$res = mysql_query($sql);*/
$res = $userObj->getIncomeITFile3_5($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);
if($tcount!=0) {$i=1;
    while($row = mysql_fetch_array($res)) {
		if($row['qual_amt'] !=""){
			$qual_amt = $row['qual_amt'];
		}else{
			$qual_amt =0;
		}
        $tablehtml1.="<div>Rs.".$qual_amt."</div>";
        $i++;
    }

}
$tablehtml1.='</td><td>';
//$res=$userObj->displayintaxchapter($rowfile1['emp_id'],$year);
/*$sql = "SELECT * FROM it_file3 WHERE emp_id='".$rowfile1['emp_id']."' AND year='".$year."' AND  (section_name!='' OR gross_amt!='0'  OR qual_amt!='0' OR deduct_amt!='0' )  ORDER BY id DESC";
$res = mysql_query($sql);
*/
$res = $userObj->getIncomeITFile3_5($rowfile1['emp_id'],$year);
$tcount=mysqli_num_rows($res);
if($tcount!=0) {$i=1;
    while($row = $res->fetch_array()) {
		if($row['deduct_amt'] !=""){
			$deduct_amt = $row['deduct_amt'];
		}else{
			$deduct_amt =0;
		}
        $tablehtml1.="<div>Rs.".$deduct_amt."</div>";
        $i++;
    }

}
$tablehtml1.='</td></tr>';

$tablehtml1.='
            <tr>
                <td>
                    10 Aggregate of deductible amount under Chapter
                    VI-A
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_10_2'].'
                </td>
                <td>

                </td>
            </tr>

            <tr>
                <td>
                    11 Total Income (8-10)
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_11_2'].'
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    12 Tax on total income
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_12_2'].'
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    13 Rebate under 87A
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_121_2'].'
                </td>
                <td>
                </td>
            </tr>
			 <tr>
                <td>
                    14. Tax Payable on total income (12-13)
                </td>
                <td>

                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_122_2'].'
                </td>
                <td>
                </td>
            </tr>
			
			
            <tr>
                <td>
                    15 Education cess @ 4% (on tax computed at S. No.
                    12)
                </td>
                <td>
                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_13_2'].'
                </td>
                <td>
                </td>
            </tr>
              <tr>
                <td>
                    16 Tax Payable (12+13)
                </td>
                <td>
                </td>
            <td align="center">
                    Rs.'.$rowfile1['col_14_2'].'
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td align="left">
                    17 Less: Relief under section 89 (attach details)
                </td>
                <td>
                </td>
                <td align="center">
                   Rs.'.$rowfile1['col_15_2'].'
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    18 Tax payable (14-15)
                </td>
                <td>
                </td>
                <td align="center">
                    Rs.'.$rowfile1['col_16_2'].'
                </td>
                <td>
                </td>
            </tr>';
$varification='
 <tr>
                <td class="thheading" colspan="4" align="center">
Verification
                </td>
            </tr>
             <tr>
                <td class="thheading" colspan="4" align="center">

I, '.$rowfile1['auth_person'].', '.$rowfile1['auth_mname'].' working in
the capacity of '.$rowfile1['auth_desg'].' (designation) do hereby certify that the information
given above is true, complete and correct and is based on the books of account, documents, TDS
statements, and other available records.
                </td>
            </tr>
             <tr>
                <td class="thheading" >
Place : Pune<br><br>
               </td>
               <td class="thheading" colspan="3">
               </td>
            </tr>
             <tr>
                <td class="thheading">
Date : 
               </td>
               <td class="thheading" colspan="3">
(Signature of person responsible for deduction of tax)
               </td>
            </tr>
             <tr>
                <td class="thheading">
Designation : '.$rowfile1['auth_desg'].'
               </td>
               <td class="thheading" colspan="3">
Full Name : '.$rowfile1['auth_person'].'
               </td>
            </tr>
            ';
$varification1='
 <tr>
                <td class="thheading" align="center">
Verification
                </td>
                <td>
               </td>     <td>
               </td>     <td>
               </td>
            </tr>
             <tr>
                <td class="thheading" colspan="4" align="center">
I, '.$rowfile1['auth_person'].', wife of '.$rowfile1['auth_mname'].' working in
the capacity of '.$rowfile1['auth_desg'].' (designation) do hereby certify that the information
given above is true, complete and correct and is based on the books of account, documents, TDS
statements, and other available records.
                </td>
                  <td>
               </td>
                    <td>
               </td>
                    <td>
               </td>
            </tr>
             <tr>
                <td class="thheading" >Place : Pune
               </td>
                   <td>
               </td>
                 <td>
               </td>
               <td>
               </td>' .
    '' .
    '</tr>
             <tr>
                <td class="thheading">
Date1 : 
               </td>
               <td class="thheading" colspan="3">
(Signature----- of person responsible for deduction of tax)
               </td></td>
                    <td>
               </td>
                    <td>
               </td>
            </tr>
             <tr>
                <td class="thheading">
Designation : '.$rowfile1['auth_desg'].'
               </td>
               <td class="thheading" colspan="3">
Full Name : '.$rowfile1['auth_person'].'
               </td>
                     </td>
                    <td>
               </td>
                    <td>

               </td>
            </tr>
            ';
$tablehtml3 .=$varification1.'</table>
    </div>
<br/><br/>
    </div>
        ';
$tablehtml2 .='</table>
                </div><br/><br/>
    </div>
        ';
echo $allhtml = $tablehtmlparta.$tabdeposit."<br><br><br><br><br><br>".$tablehtml.$tablehtmlh1.$tablehtml1.$varification.$tablehtml2;




$compname='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:30px;">'.strtoupper($rowcomp['comp_name']).'</span>  -  '. $reporttitle;
$compname1='<img src="http://localhost/images/JSM-logo1.jpg" align="absmiddle"> <span style="font-size:30px;">'.strtoupper($rowcomp['comp_name']).'</span>  -  '. $reporttitle;

?>
<script>
    function myFunction() {
        window.print();
    }
</script>
<?php
function rome($N){
    $c='IVXLCDM';
    for($a=5,$b=$s='';$N;$b++,$a^=7)
        for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s);
    return $s;
}

/*
$pdf=new PDF_HTML_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->Image('http://localhost/images/JSM-logo.jpg',10,10,15);

$pdf->WriteHTML("<br><br>$compname<br>$tablehtml$tablehtmlh2.$tablehtml1.$tablehtml3<br><br>");
$temp=$name1[0]."-".$name1[1]."-".$name1[2];
$name='../pdffiles/Form16/'.$temp.'.pdf';
$pdf->Output($name,'F');
$docfilename='../docfiles/Form16/'.$temp.'.doc';
$myfile = fopen($docfilename, "w") or die("Unable to open file!");
fwrite($myfile, "$compname1<br>$tablehtml.$tablehtmlh1.$tablehtml1.$varification.$tablehtml2<br><br>");
fclose($myfile);*/

require_once '../dompdf/autoload.inc.php';
$html = file_get_contents($_SERVER['HTTP_REFERER']);
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codex",array("Attachment"=>0)); 
//$stuff = ob_get_clean(); //ending

?>


<!-- content end -->


</body>
</html>