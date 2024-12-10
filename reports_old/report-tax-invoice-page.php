<?php
session_start();

error_reporting(0);
$month=$_SESSION['month'];
include('../fpdf/html_table.php');

 $name=$_REQUEST['name'];
 $empid=$_REQUEST['empid'];
 $year=$_REQUEST['year'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();

if($year!=''){
    $reporttitle="Form 16 year- ".$year;
}

$name1=explode(" ",$name);

$_SESSION['client_name']=$name1[4].' '.$name1[5].' '.$name1[6];
$_SESSION['reporttitle']=strtoupper($reporttitle);


$sqlfile ="SELECT id FROM `it_file1` WHERE `year` LIKE '".$year."' AND `emp_id` = '".$empid."'";

$resfile = mysql_query($sqlfile);
$rowfile = mysql_fetch_array($resfile);

 $sqlfile1 ="SELECT * FROM `it_file1` i1,itconst i2  WHERE i1.id='".$rowfile['id']."' AND i1.`from_date`=i2.`from_date` AND i1.`to_date`= i2.`to_date`";

$resfile1 = mysql_query($sqlfile1);
$rowfile1 = mysql_fetch_array($resfile1);



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
			/*border:0 !important*/
			border-color:#000;

        }

        .table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:12px !important;
            font-family: monospace;

        }
		.nobord table{
			border: 0!important;
			padding:0 !important
		}
		.nobord td{
			border: 1px!important;
		}
		.bordpadd0{padding:0 !important; border:0 !important}
		.disinl{display:inline-block}
		table.maintab td {
				padding: 0 !important;
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
 $header=include("printheader.php");


?>
<!-- content starts -->

    <div class="row body" >
     <!--   <table width="100%" style="border:0 !important" class="maintab">    
	 <tr>
        <td width="40%"  style="border:0 !important"><div>
		<table>
		<tr><td>
		<span class="thheading">Industrial & Consultancy Services</span><br>
		1117/5A Unique House<br>
		Lakaki Road,Model Colony,<br>Pune 411 016. <br>Maharashtra,    Code : 27<br>Tel. 25655978 /25652095<br>Email: shaconpvt@gmail.com<br>GSTIN :    27AAAFI3587J1Z3</td></tr>
		<tr><td>
		<span class="thheading">Buyer</span><br>
		<span class="thheading">Lokmat Media Pvt.Ltd.,</span><br>
		Veeyaa Vantage Cts No. 55/2<br>Law Collage Road, Erandwane <br>Maharashtra,    Code : 27<br>GSTIN  :  27AAACL1888J1Z6</td></tr>
		</table></div>
		</td>
        <td  colspan="60%"  valign="top" style="border:0 !important">
			<table >
			<tr>
				<td class="thheading">Invoice No.</td>
				<td class="thheading">Date</td>
			</tr>
			<tr>
				<td>ICS/ 49</td>
				<td>04/10/2017</td>
			</tr>
			</table>
		</td>
    </tr>

	<tr>
		<td colspan="2" style="border:0 !important;" >
		<div>
		<table >
			<tr>
			<td class="thheading">Sr No.</td>
			<td class="thheading">Particulars</td>
			<td class="thheading">HSN/SAC</td>
			<td class="thheading">Per</td>
			<td class="thheading">Rate</td>
			<td class="thheading">Amount</td>
			</tr>
			
			<tr>
			<td>1</td>
			<td>Contract Labour Wages</td>
			<td>9985</td>
			<td></td>
			<td></td>
			<td>168539</td>
			</tr>
			<tr>
			<td>2</td>
			<td>E.S.I</td>
			<td>9985</td>
			<td>168,539</td>
			<td>4.75%</td>
			<td>8,006.00</td>
			</tr>
			<tr>
			<td>3</td>
			<td>P.F.</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>4</td>
			<td>Service Charges</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>5</td>
			<td>SGST</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>6</td>
			<td>CGST</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>238,239.00 </td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>238,239.00 </td>
			</tr>
			
			<tr>
			<td  class="thheading" colspan="6">Amount Chargeable (in words) <br> (Indian Rupees Two Lacs Thirty Eight Thousand Two Hundred Thirty Nine Only ) </td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	
	<tr><td colspan="2" style="border:0 !important;">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<td class="thheading" width="30%"> HSN/SAC</td>
			<td class="thheading">Taxable value</td>
			<td class="thheading" colspan="2">Central Tax</td>
			<td class="thheading" colspan="2">State Tax</td>
			</tr>
			<tr>
			<td > </td>
			<td ></td>
			<td >Rate</td>
			<td >Amount</td>
			<td >Rate</td>
			<td >Amount</td>
			</tr>
			<tr>
			<td > 9985</td>
			<td > 201,897</td>
			<td >9%</td>
			<td > 18,171 </td>
			<td >9%</td>
			<td > 18,171 </td>
			</tr>
			<tr>
			<td > &nbsp; Total</td>
			<td > </td>
			<td ></td>
			<td > 18,171 </td>
			<td ></td>
			<td > 18,171 </td>
			</tr>	
			<tr>
			<td  class="thheading" colspan="6">Tax Amount (in words)  : <br> (Indian Rupees Thirty Six Thousand Three Hundred Forty Two only ) </td>
			</tr>
			<tr>
			<td  class="thheading" colspan="5">Total Bill Amount </td><td>238,239.00
</td>
			</tr>
			<tr>
			<td >
			<table>
			
			</table>
			</td>
			</tr>
			
	</table>
	
	</td></tr>
	
	 
</table>-->
<table>
<tr>
<td width="40%" >
<div style="border-bottom:1px solid #000; margin-bottom:5px; padding-bottom:5px"><span class="thheading">Industrial & Consultancy Services</span><br><?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Maharashtra,    Code : 27<br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?><br>GSTIN :    <?php echo $comapnydtl['gstin']; ?></div>
		<div><span class="thheading">Buyer</span><br>
		<span class="thheading">Lokmat Media Pvt.Ltd.,</span><br>
		Veeyaa Vantage Cts No. 55/2<br>Law Collage Road, Erandwane <br>Maharashtra,    Code : 27<br>GSTIN  :  27AAACL1888J1Z6</div>
</td>
<td width="60%" valign="top" class="bordpadd0">
<table style="border:0">
			<tr>
				<td class="thheading">Invoice No.</td>
				<td class="thheading">Date</td>
			</tr>
			<tr>
				<td>ICS/ 49</td>
				<td>04/10/2017</td>
			</tr>
			</table>
			
</td>
</tr>
<tr>
		<td colspan="2" class="bordpadd0" >
		<div>
		<table >
			<tr>
			<td class="thheading">Sr No.</td>
			<td class="thheading">Particulars</td>
			<td class="thheading">HSN/SAC</td>
			<td class="thheading">Per</td>
			<td class="thheading">Rate</td>
			<td class="thheading">Amount</td>
			</tr>
			
			<tr>
			<td>1</td>
			<td>Contract Labour Wages</td>
			<td>9985</td>
			<td></td>
			<td></td>
			<td>168539</td>
			</tr>
			<tr>
			<td>2</td>
			<td>E.S.I</td>
			<td>9985</td>
			<td>168,539</td>
			<td>4.75%</td>
			<td>8,006.00</td>
			</tr>
			<tr>
			<td>3</td>
			<td>P.F.</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>4</td>
			<td>Service Charges</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>5</td>
			<td>SGST</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td>6</td>
			<td>CGST</td>
			<td>9985</td>
			<td>Per</td>
			<td>Rate</td>
			<td>Amount</td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>238,239.00 </td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>238,239.00 </td>
			</tr>
			
			<tr>
			<td  class="thheading" colspan="6">Amount Chargeable (in words) <br> (Indian Rupees Two Lacs Thirty Eight Thousand Two Hundred Thirty Nine Only ) </td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	<tr><td colspan="2" class="bordpadd0">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<td class="thheading" width="30%"> HSN/SAC</td>
			<td class="thheading">Taxable value</td>
			<td class="thheading" colspan="2">Central Tax</td>
			<td class="thheading" colspan="2">State Tax</td>
			</tr>
			<tr>
			<td > </td>
			<td ></td>
			<td >Rate</td>
			<td >Amount</td>
			<td >Rate</td>
			<td >Amount</td>
			</tr>
			<tr>
			<td > 9985</td>
			<td > 201,897</td>
			<td >9%</td>
			<td > 18,171 </td>
			<td >9%</td>
			<td > 18,171 </td>
			</tr>
			<tr>
			<td > &nbsp; Total</td>
			<td > </td>
			<td ></td>
			<td > 18,171 </td>
			<td ></td>
			<td > 18,171 </td>
			</tr>	
			<tr>
			<td  class="thheading" colspan="6">Tax Amount (in words)  : <br> (Indian Rupees Thirty Six Thousand Three Hundred Forty Two only ) </td>
			</tr>
			<tr>
			<td  class="thheading" colspan="5">Total Bill Amount </td><td>238,239.00
</td>
			</tr>
			<tr>
			<td colspan="3">
			<div>Bank Details</div>
				<div style="width:30%; float:left">Bank  </div><div>:-  IDBI BANK, Laxmi Road Branch</div>
				<div style="width:30%;  float:left">Bank A/c  </div><div>:-  4591201002098</div>
				<div style="width:30%;  float:left">Bank IFSC    </div><div>:-  IBKL0000459</div>
				<div style="clear:both">&nbsp; </div>
			
			</td>
			<td></td>
			<td colspan="2">For  Industrial & consultancy Services</td>
			
			
			</tr>
			
	</table>
	
	</td></tr>
</table>





        </div>
<br/><br/>
    </div>
<!-- content end -->

<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>