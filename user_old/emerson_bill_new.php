<?php 
//error_reporting(0);


include("../lib/class/common.php");
$common=new common();
include("../lib/connection/db-config.php");

 $clientid=$_POST['client'];

$resclt=$userObj->displayClient($clientid);
$current_month = $resclt['current_month'];
$client = $_POST['client'];
$tab_client = $client;

  if($client==12 || $client==14){
	$client = "12,14";
	$tab_client = "1214";
	$monthlysupcharge = 30000;
}
  
 //$_SESSION['emer_month'];
$frdt= $_SESSION['emer_month'];


if ($frdt==$current_month)
	{ $tab = "tran_emerson_bill".$tab_client;
		$frdt=$current_month;
}
else
	{ $tab = "hist_emerson_bill".$tab_client;}	

$sql = "select eb.* from $tab eb  where emp_name= 'STD_Annex' order by eb.desg_id";
 
 
 
$row = mysql_query($sql);
 $cnt = mysql_num_rows($row);
for ($i= 0;$i <$cnt;$i++)
{
	$arr[$i] = mysql_fetch_array($row);
}

/* $setExcelName ="emerson_bill_".$tab_client;
  header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0"); */  

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
    font-size: 10px !important;
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
			align:right!important;

        }

        table, td, th {
            padding: 3px!important;
            border: 1px solid black!important;
            font-size:10px !important;
            font-family: monospace;
			align:right!important;

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


<div style="padding:10px" class="row body " >	   
<table  border='1px solid #ccc' width="100%" cellspacing="0" cellpadding="0" id="emer" class="page-bk" style = "align:right!important";> 
<tr colspan=<?php echo $cnt+1; ?>>
	<th class="th" colspan="<?php echo $cnt+1;?>"><p align="left" style="display:inline; float: right;">&nbsp;</p>Emerson Bill On : <?php echo date('d/M/Y',strtotime($frdt)). " (".$resclt['client_name'].")";?></th>
	 
    </tr>  
     <tr>
	 <th></th>
<?php 
    $i = 0;

for ($i= 0;$i <$cnt;$i++)
{
	echo "<th >".$arr[$i]['desg_name']."</th>";
}
echo "</tr>";
echo "<tr><th> Basic </th>";

for ($i= 0;$i <$cnt;$i++)
{
//print_r($arr[$i]);
	echo "<td align=right>".number_format($arr[$i]['basic_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Spl. Allow (".$arr[0]['spl_allow_ip'].") </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['da_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> H.R.A. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['hra_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Suppli.Serv.Allow </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['supplli_allow_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Super skill Allow. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['super_skill_allow_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Other Allow. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['other_allow_sal'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";
}

echo "</tr>";
echo "<tr><th> Gross Monthly </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['gross_monthly_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";
}

echo "</tr>";
echo "<tr><th> Basic </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['basic_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Spl. Allow  </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['da_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> H.R.A. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['hra_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Suppli.Serv.Allow </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['supplli_allow_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Super skill Allow. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['super_skill_allow_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Other Allow. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['other_allow_daily_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";
}

echo "</tr>";
echo "<tr><th> Total A </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['total_a_annex'],2,".",",")."</td>";
}


echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";
}

echo "</tr>";
echo "<tr><th> Pf (".$arr[0]['pf_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['pf_annex'],2,".",",")."</td>";
}

	
echo "</tr>";
echo "<tr><th> Bonus (".$arr[0]['bonus_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['bonus_Annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Total B </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['total_b_annex'],2,".",",")."</td>";
}


echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> E.S.I. (".$arr[0]['esi_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['esi_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> L.W.W. (".$arr[0]['lww_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['lww_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> L.W.F. (".$arr[0]['lwf_percent_ip'].") </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['lwf_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Safety Appl. (".$arr[0]['safetyapp_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['safety_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Soap+Tea+Other Charges (".$arr[0]['other_charges_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['soap_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Training Charges (".$arr[0]['trainingcharg_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['training_annex'],2,".",",")."</td>";
}


echo "</tr>";
echo "<tr><th> Total C  </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['total_c_annex'],2,".",",")."</td>";
}



echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> Grand Total (A+B+C) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['total_ABC_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> T.D.S. (".$arr[0]['tds_percent_ip']."%) </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['tds_Annex'],2,".",",")."</td>";
}



echo "</tr>";
echo "<tr><th> Total D </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['total_d_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> Rounded Off to Rs. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['rounded_annex'],2,".",",")."</td>";
}


echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> No.of.Employees </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['emp_cnt_annex'],0,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> Bill Rate </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['bill_rate_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> "." "." </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>"." "."</td>";

	
}

echo "</tr>";
echo "<tr><th> O.T. Rate/Hr. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['ot_rate_annex'],2,".",",")."</td>";
}


echo "</tr>";
echo "<tr><th> O.T. Conv. Rate</th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['ot_conv_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> O.T. Horurs </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['ot_hours_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> O.T. Days </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['ot_days_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> O.T. Days Percent </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['ot_days_percent_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Payable Days </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['payable_days_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Total Days </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['tot_payable_days_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> No. of. Units </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['no_of_units_annex'],2,".",",")."</td>";
}

echo "</tr>";
echo "<tr><th> Amount Rs. </th>";
for ($i= 0;$i <$cnt;$i++)
{
	echo "<td align=right>".number_format($arr[$i]['amount_annex'],2,".",",")."</td>";
}
?>
</tr></table><br><br></div>


<!-------------------------------------------------------tax invoice ------------------------------------>
<?php $comapnydtl = $userObj->showCompdetailsById($comp_id);
$compbankdtl = $userObj->displayBank($comapnydtl['bank_id']);
//$resclt=$userObj->displayClient($id);
//print_r($resclt);
?>



<!-------------------------------------------------------tax invoice ------------------------------------>
 <div  style = "padding:20px;"id="taxinvoivedetailstable" class = "row body">   <div >
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
			<td class="thheading" align="center"width="2%">Sr No.</td>
			<td class="thheading" align="center">Particulars</td>
			<td class="thheading" align="center">HSN/<br>SAC</td>
			<td class="thheading" align="center">Qty</td>
			<td class="thheading" align="center">Unit</td>
			<td class="thheading" align="center">Rate</td>
			<td class="thheading" align="center">Total</td>
			<td class="thheading" align="center">Disc.</td>
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
			<?php $i=0; $sup_cnt=0; $j=1;
			for($i= 0 ;$i<$cnt;$i++){ ?>
			<tr>
			<td><?php echo $j++;?></td>
			<td><?php //echo substr($arr[$i]['desg_name'], strpos(substr($arr[$i]['desg_name'],0), "-")+2,99);
			echo $arr[$i]['desg_name'];
			?></td>
			<td align="center"width = "3%">9985</td>
			<td align="right" ><?php
			if($arr[$i]['no_of_units_annex']==0)
				{echo '-';}
			else
			{echo number_format($arr[$i]['no_of_units_annex'],2,'.',',');}
			      if ($arr[$i]['no_of_units_annex']>0){$sup_cnt++;}?></td>
			<td align="right" >1</td>
			<td align="right" ><?php echo number_format($arr[$i]['bill_rate_annex'],0,".",",");?></td>
			<td align="right" ><?php if ($arr[$i]['amount_annex']==0){echo '-';}else {echo number_format($arr[$i]['amount_annex'],0,".",",");}?></td>
			<td align="right" id="taxdesc<?php echo $i;?>">0</td>
			<td align="right" ><?php if ($arr[$i]['amount_annex']==0){echo '-';}else {echo number_format($arr[$i]['amount_annex'],0,".",",");}?></td>
			<td align="right" id="<?php echo $i;?>" class="paddmarg0" width="5%"><?php if ($arr[$i]['cgst_annex']==0) {echo "-";} else {echo number_format($arr[$i]['cgst_percent_ip'],0,".",",")."%";}?> </td>
			<td  width="6%" align="right"><?php if ($arr[$i]['cgst_annex']==0) {echo "-";} else {echo number_format($arr[$i]['cgst_annex'],0,".",",");}?>  </td>
			<td align="right"   width="5%"> <?php if ($arr[$i]['sgst_annex']==0) {echo "-";} else {echo number_format($arr[$i]['sgst_percent_ip'],0,".",",")."%";}?> </td>
			<td  width="6%" align="right"><?php  if ($arr[$i]['sgst_annex']==0) {echo "-";} else {echo number_format($arr[$i]['sgst_annex'],0,".",",");}?> </td>
			<td align="right"  width="5%"><?php  if ($arr[$i]['igst_annex']==0) {echo "-";} else {echo number_format($arr[$i]['igst_percent_ip'],0,".",",")."%";}?></td>
			<td width="6%" align="right">  <?php if ($arr[$i]['igst_annex']==0) {echo "-";} else { echo  number_format($arr[$i]['igst_annex'],0,".",",");}?></td>			
			<td align="right" ><?php echo number_format($arr[$i]['tot_amount_annex'],0,".",",");?></td>
			</tr>
			
			<?php }?>
			<tr>
			<td><?php echo $j++;?></td>
			<td>Monthly Supervision Charges</td>
			<td align="center">9985</td>
			<td align="right" id="taxqty<?php echo $i;?>"><?php echo $sup_cnt;?> </td>
			<td align="right" id="taxunit<?php echo $i;?>">0</td>
			<td align="right" id="taxrate<?php echo $i;?>"><?php echo number_format($monthlysupcharge/$sup_cnt,0,".",",");?></td>
			<td align="right" id="taxtot<?php echo $i;?>" ><?php echo number_format($monthlysupcharge,0,".",",");?></td>
			<td align="right" id="taxdesc<?php echo $i;?>">0</td>
			<td align="right" id="taxtaxablval<?php echo $i;?>" class="taxtaxablvalcl"><?php echo number_format($monthlysupcharge,0,".",",");?></td>
			<td align="right" id="<?php echo $i;?>" width="5%"><?php echo number_format($arr[0]['cgst_percent_ip'],0,".",",")."%";?> </td>
			<td id="cgstamt<?php echo $i;?>"  width="6%" align="right">
			<?php 
			 $cgst_sup = round($monthlysupcharge*$arr[0]['cgst_percent_ip']/100,2);
			//echo $cgst_sup;
			echo number_format($cgst_sup,0,".",",");?> </td>
			<td align="right"  class="paddmarg0" width="5%"><?php echo  number_format($arr[0]['sgst_percent_ip'],0,".",",")."%";?></td>
			<td id="sgstamt<?php echo $i;?>" width="6%" align="right">
			<?php 
			$sgst_sup = round($monthlysupcharge*$arr[0]['sgst_percent_ip']/100,2);
			echo number_format($sgst_sup,0,".",",");?>
			</td>
			<td align="right" class="paddmarg0" width="5%"><?php echo number_format($arr[0]['sgst_percent_ip'],0,".",",")."%";?></td>
			<td id="igstamt<?php echo $i;?>"  width="6%" align="right">0</td>			
			<td align="right" >
			<?php 
			$sup_tot_amount = round($monthlysupcharge+$cgst_sup+$sgst_sup,2);
			echo number_format($sup_tot_amount,0,".",",");?>
			
			</td>
			</tr>
			<tr>
			<td><?php echo $j;?></td>
			<td>Fixed Service Charge</td>
			<td align="center">9985</td>
			<td align="right" id="fixedserchrate">
				<?php
				$amount = 0;
				for($i=0;$i<$cnt;$i++)
				{
					$amount+=$arr[$i]['amount_annex'];
				}
				$amount+=$monthlysupcharge;
				echo number_format($amount,0,".",",");?>
			</td>
			<td align="right" ></td>
			<td align="right" id="fxtrate"><?php echo number_format($fixedsercharg,0,".",",")."%";?></td>
			<td align="right" id="fxttot" > 
					<?php 
					$fixed =  round($amount*$fixedsercharg/100,2);
					echo number_format($fixed,0,".",",");?>
			</td>
			<td align="right" >0</td>
			<td align="right" ><?php echo number_format($fixed,0,".",",");?></td>
			<td align="right"  width="5%"><?php echo number_format($arr[0]['cgst_percent_ip'],0,".",",")."%";?> </td>
			<td  width="6%" align="right">
			<?php 
			 $cgst_fixed = round($fixed*$arr[0]['cgst_percent_ip']/100,2);
			echo number_format($cgst_fixed,0,".",",");?> 
			</td>
			<td align="right"   width="5%"><?php echo number_format($arr[0]['sgst_percent_ip'],0,".",",")."%";?></td>
			<td id="fsgstamt"  width="6%" align="right">
			<?php 
			 $sgst_fixed = round($fixed*$arr[0]['sgst_percent_ip']/100,2);
			echo number_format($sgst_fixed,0,".",",");?> 
			</td>
			<td align="right"  width="5%"><?php echo number_format($arr[0]['igst_percent_ip'],0,".",",")."%";?></td>
			<td id="figstamt"  width="6%" align="right"><?php echo number_format(0,0,".",",")."%";?></td>			
			<td align="right" >
			<?php 
			$fixed_tot_amount = round($fixed+$cgst_fixed+$sgst_fixed,2);
			echo number_format($fixed_tot_amount,0,".",",");?>
			
			
			</td>
			</tr>
			<?php $amt_before_tax = 0;
			$final_amount = 0;
			$cgst_total=0;
			$sgst_total= 0;
			$igst_total=0;
			for ($i=0;$i<$cnt;$i++){
				
				$final_amount=$final_amount+$arr[$i]['tot_amount_annex'];
				$cgst_total = $cgst_total+$arr[$i]['cgst_annex'];
				$sgst_total = $sgst_total+$arr[$i]['sgst_annex'];
				$isgt_total = $igst_total+$arr[$i]['igst_annex'];
				$amt_before_tax=$amt_before_tax+$arr[$i]['amount_annex'];
			}
			$final_amount=$final_amount+$sup_tot_amount+$fixed_tot_amount;
			$cgst_total = $cgst_total+$cgst_sup+$cgst_fixed;
			$sgst_total = $sgst_total+$sgst_sup+$sgst_fixed;
			$amt_before_tax=$amt_before_tax+$monthlysupcharge+$fixed;
			
			?>
			
			<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td>
			
			</td>
			<td align="right"></td>
			<td align="right" >
			<?php 
			echo number_format($amt_before_tax,0,".",",");?>
			 
			</td>
			<td align="right"></td>
			<td align="right" ><?php 
			echo number_format($amt_before_tax,0,".",",");?>
			 
			</td>
			</td>
			<td align="right"></td>
			<td align="right" >
			<?php 
			echo number_format($cgst_total,0,".",",");?>
			
			</td>
			<td align="right"></td>
			<td align="right" >			<?php 
			echo number_format($sgst_total,0,".",",");?>
			</td>
			<td align="right"></td>
			<td align="right"></td>
			
			<td align="right" ><?php
			echo number_format($final_amount,0,".",",");
			//echo $total;?> </td>
			</tr>
			
			
			<tr>
			<td  class="" colspan="9">Total Invoice amount in words <span id="numtoword"></span><?php echo $userObj->convertNumberTowords($final_amount); ?> Only. </td>
			
			<td colspan="5" class="paddmarg0">Total Amount Before Tax : <hr> Add CGST</td> 
			<td colspan="2" class="paddmarg0" align="right"><span id="beforetaxamount"><?php echo number_format($amt_before_tax,0,".",",");?></span><hr><span id="addcgst"> <?php echo number_format($cgst_total,0,".",",");?> </span></td>
			
			</tr>
			<tr>
			<td  class="thheading" colspan="9">
				<div style="width:25%; float:left">Bank Details </div><div>:-  <?php echo $compbankdtl['bank_name']; ?>,<?php echo $compbankdtl['add1']; //echo $compbankdtl['branch']; ?></div>
				<div style="width:25%;  float:left">Bank A/c </div><div>:-  <?php echo $comapnydtl['bankacno']; ?></div>
				<div style="width:25%;  float:left">Bank IFSC </div><div>:-  <?php echo $compbankdtl['ifsc_code']; ?></div>
				 </td>
		
			<td colspan="5" class="paddmarg0">Add SGST <hr>Add IGST<hr>Total Tax amount GST</td> 
			<td colspan="2" class="paddmarg0" align="right"><span id="addsgst">
 			<?php 
			echo number_format($sgst_total,0,".",",");?></span>
			<hr>
			<span >0.00</span><hr><span >
			<?php 		echo number_format($cgst_total+$sgst_total,0,".",",");?>
			</span></td>
			</tr>
			
			<tr>
			<td  class="thheading" colspan="9" valign="top">Declaration </td>
		
			<td colspan="5" class="paddmarg0">Total Amount after tax <hr>GST Payable under RCM<hr><div style="height:50px!important; "><?php echo "For ". $comapnydtl['comp_name'];?></div><br><br><br><br>Authorised Signatory</td> 
			<td colspan="2" class="paddmarg0" valign="top" align="right"><span ><?php
			echo number_format($final_amount,0,".",",");
			//echo $total;?>
			</span><hr><span >0</span><hr> <div style="height:50px!important; "></div></td>
			</tr>
		</table>
		
		</td>
	</tr>
	
</table>
</div>






        <script>
    function myFunction() {
        window.print();
    }
</script>
<style>
	.btnprnt{margin: 10px 0px 0px 20px; }
	.page-bk {
		position: relative;

		/*display: block;*/
		page-break-after: always;
		z-index: 0;

	}
    @media print
    {
      .btnprnt{display:none}
      #watermark {
        display: block;
        position: fixed;
        z-index: 100;
        opacity: 0.2;
		top:-500px;
		left:30%;
        font-size:70px;
        transform:rotate(300deg);
        -webkit-transform:rotate(300deg);
      }
       
    }
    table {
        border-collapse: collapse;
    }

	
	@media print
{


		#header, #footer {

			display:none!important;

		}
		#footer {
				display:none!important;
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

     media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}

</style>

