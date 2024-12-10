<?php
//print_r($_REQUEST);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);*/
//error_reporting(0);
session_start();
include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$clintid=$_SESSION['clintid'];
$user_id=$_SESSION['log_id'];
$setExcelName = "payslip";
$client_id=$_REQUEST['cal'];

$setExcelName = "Paysheet_".$client_id;
//$emp = $_REQUEST['emp'];
//$name = $_REQUEST['name'];
include("../lib/class/user-class.php");
include("../lib/class/admin-class.php");
$userObj=new user();
$adminObj=new admin();
$resclt=$userObj->displayClient($clintid);

$rowclient=$userObj->displayClient($client_id);
$cmonth=$rowclient['current_month'];
$inhdar = array();
$inhd =0;
$std_inhdar = array();
$std_inhd =0;
$advhd = 0;
$advhdar = array();

$dedhdar = array();
$dedhd =0;
$noofper = $_REQUEST['noofper'];
$maxcol=0;




$tab = "`tab_".$user_id."`";

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else
  {
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
  }
  
$row= $userObj-> genarateTempPaysheet($inhdar,$inhd,$std_inhdar,$std_inhd,$advhd,$advhdar,$dedhdar,$dedhd,$cmonth);

$inhdar = $row[0];
echo $inhd= $row[1];
$std_inhdar= $row[2];
$std_inhd= $row[3];
$advhd= $row[4];
$advhdar= $row[5];
$dedhdar= $row[6];
$dedhd= $row[7];
$rowtab=$row[8];

$rec1_tot = $row[9];
$rec_tot = $rec1_tot->fetch_assoc();

$rec1 = $row[10];
$rec_days = $rec1->fetch_assoc();
$rec11 = $row[11];
$rec_inc = $rec11->fetch_assoc();

$rec12 = $row[12];
$rec_ded = $rec12->fetch_assoc();

$rec13 = $row[13];
if (is_array($rec13)){
$rec_adv = $rec13->fetch_assoc();
}
else
{$rec_adv = 0;
}

$days = $row[14];
$dayscnt = $row[15];
 echo $maxcol = max($inhd,$dayscnt,$dedhd);
$colwidth= intval(60/$maxcol);
if($month!=''){
    $reporttitle="Paysheet for ".date('F Y',strtotime($frdt));
}

$_SESSION['client_name']=$resclt['client_name'];

$_SESSION['reporttitle']=strtoupper($reporttitle);


?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
    
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
			    padding-right: 50px;
			
        }

        table {
            border-collapse: collapse;
		    width: 100%;
			 padding: 5px!important;
            border:none;
            font-size:11px !important;
            font-family: monospace;
		
        }
		
		table2 {
            border:0px;
		
        }
		.tot{
			cellpadding:0;
			cellspacing:0;
		}
		        

		td, th {
            padding: 3px!important;
            border: 1px solid black!important;
            font-size:11px !important;
            font-family: monospace;
			 
        }
		div{font-size:11px !important;}
		
		table.padd0imp ,.padd0imp tr{border:0 !important}
		.per20inl{width:20%; display:inline-block; align:left;font-size:11px !important;
            font-family: monospace;}
			.textlower{text-transform: lowercase;}
			.textupper{text-transform: uppercase;}
			
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
            .body { padding: 10px 50px 0; }
            body{
                margin-left: 50px;
                margin-right: 30px;
            }	
			
		
        }
			
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
		@page  
{ 
    margin: 20 20 22px;  
		margin: 15mm 8mm 8mm 0mm;
	
} 
			}
		
    </style>
	
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>

<?php 

$totnetsalary= 0;
$totpayable=0;
$totgrosssal=0;
$tottotded=0;
$maxcol = max($inhd,$dayscnt,$dedhd);
 $colwidth= intval(60/$maxcol);
$sr=0; 
$incarray = array();
while($rec=$rowtab->fetch_assoc()) { 
 if (($sr%$noofper==0 && $sr>0)||($sr==0))
 {
 
 ?>
<div class="header_bg">
<?php include('printheader3.php'); ?>

</div>
<div class="row body page-bk textupper" cellspacing="0" cellpadding="0">
	<br>
<table width="" >
<tr> 
<td width="2%" rowspan = "5" align="center"><b>srno</b> </td>
<td width="3%"rowspan = "5" align="center"><b>EmpId</b></td>

<td width="20%" rowspan = "5" align="center"><b>Name</b></td>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$inhdar[$j].'</td>';
	}?>
<td  width="6%" align="center" ><b>STD PAY</b></td>
<td  width="6%" align="center" rowspan = "5"><b>Netsal</b></td>
</tr>
<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center" text-transform= "uppercase">'.$days[$j].'</td>';
	}?>
	<td>PAYABLEDAYS</td></tr>

<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;>'.$inhdar[$j].'</td>';
	}?><td>GR. SALARY</td></tr>
	
<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$dedhdar[$j].'</td>';
	}?><td>TOT DED.</td></tr>

<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$advhdar[$j].'</td>';
	}?><td>-</td></tr>

<?php
}
//header ends

	?>
  
<tr> 
<td width="2%" rowspan = "5" align="center"><b><?php $sr++;echo $sr;?> </b> </td>
<td width="3%"rowspan = "5" align="center"><b><?php echo $rec['emp_id'];?></b></td>

<td width="20%" rowspan = "5" align="left"><b><?php echo $rec['emp_name'];?></b></td>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	
if ($rec[strtolower("std_".$inhdar[$j])]>0){
echo '<td  width="'. $colwidth.'%" align="right">'.$rec[strtolower("std_".$inhdar[$j])].'</td>';
}
else
{
echo '<td  width="'. $colwidth.'%" align="right">-</td>';
	
}}?>
<td  width="6%" align="center" ><b>STD PAY</b></td>
<td  width="6%" align="right" rowspan = "5"><b><?php echo number_format($rec["netsalary"],2,".",","); ?></b></td>
</tr>
<tr>
    
<?php

for ($j= 0 ;$j <$maxcol;$j++)
	
	{   
if ($rec[strtolower($days[$j])]>0){
	echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec[strtolower($days[$j])],2,".",",").'</td>';
	}
	
else
{echo '<td  width="'. $colwidth.'%" align="right">-</td>';
	
}}
	?>
	<td align="right"><?php echo number_format($rec["payabledays"],2,".",","); ?></td></tr>

<tr>
<?php for ($j= 0 ;$j<$maxcol;$j++)
	{   if ($rec[strtolower($inhdar[$j])]>0)
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec[strtolower($inhdar[$j])],2,".",",").'</td>';
	    }
	    else
	    {	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	    }
	}?><td align="right"><?php echo $rec["gross_salary"]; ?></td></tr>
	
<tr>
<?php 

for ($j= 0 ;$j<$maxcol;$j++)
	{
	    if($rec[strtolower($dedhdar[$j])]>0)
	    {
	    echo '<td  width="'. $colwidth.'%" align="right">'.number_format($rec[strtolower($dedhdar[$j])],2,".",",").'</td>';
	    }
	    else
	    {
	    echo '<td  width="'. $colwidth.'%" align="right">-</td>';
	    }
	}?><td align="right"><?php echo $rec["tot_deduct"]; ?></td></tr>
	
	<tr>
<?php for ($j= 0 ;$j<$maxcol;$j++)
	{	if(is_array($advhdar) ){ if ($j<sizeof($advhdar)){
	    if($rec[strtolower($advhdar[$j])]>0)
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec[strtolower($advhdar[$j])],2,".",",").'</td>';
	    }}}
	    else
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	    }
	    
	}?><td align="right">-</td></tr>
		<tr><td colspan = "<?php echo $maxcol+5;?>"></td></tr>

 <?php 
 
 
 //$sr++;
 
  if($sr%$noofper==0 && $sr>0)

  {
echo ' </table></div>';
	  
  }
} 
 
 //data loop ends
 







if (($sr%$noofper==0 && $sr>0)||($sr==0))
 {
 
 ?>
<div class="header_bg">
<?php include('printheader3.php'); ?>

</div>
<div class="row body page-bk textupper" cellspacing="0" cellpadding="0">
	<br>
<table width="" >
<tr> 
<td width="2%" rowspan = "5" align="center"><b>srno</b> </td>
<td width="3%"rowspan = "5" align="center"><b>EmpId</b></td>

<td width="20%" rowspan = "5" align="center"><b>Name</b></td>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$inhdar[$j].'</td>';
	}?>
<td  width="6%" align="center" ><b>STD PAY</b></td>
<td  width="6%" align="center" rowspan = "5"><b>Netsal</b></td>
</tr>
<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center" text-transform= "uppercase">'.$days[$j].'</td>';
	}?>
	<td>PAYABLEDAYS</td></tr>

<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;>'.$inhdar[$j].'</td>';
	}?><td>GR. SALARY</td></tr>
	
<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$dedhdar[$j].'</td>';
	}?><td>TOT DED.</td></tr>

<tr>
<?php for ($j= 0 ;$j <$maxcol;$j++)
	{	echo '<td  width="'. $colwidth.'%" align="center">'.$advhdar[$j].'</td>';
	}?><td>-</td></tr>

<?php
}
//header ends

	?>
 




<tr> 
<td width="2%" rowspan = "4" align="center"><b> </b> </td>
<td width="3%"rowspan = "4" align="center"><b></b></td>

<td width="20%" rowspan = "4" align="right"><b>Total</b></td>





<?php

 for ($j= 0 ;$j <$maxcol;$j++)
	{	if ($j<sizeof($days)){
	    if($rec_days[strtolower($days[$j])]>0)
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec_days[strtolower($days[$j])],2,".",",").'</td>';}}
	    else
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	        
	    }
	    
	}?>
	<td align="right"><?php echo number_format($rec_tot["payabledays"],2,".",","); ?></td>
<td  width="6%" align="right" rowspan = "4"><b><?php echo number_format($rec_tot["netsalary"],2,".",","); ?></b></td></tr>

<tr>
<?php
for ($j= 0 ;$j <$maxcol;$j++)
	{		if ($j<sizeof($rec_inc)){
	    if($rec_inc[strtolower($inhdar[$j])]>0)
	    {echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec_inc[strtolower($inhdar[$j])],2,".",",").'</td>';}}
		    else
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	        
	    }

	}
?>
	
<td align="right"><?php echo number_format($rec_tot["gross_salary"],2,".",","); ?></td>
</tr>

<tr>
<?php
for ($j= 0 ;$j <$maxcol;$j++)
	{	if ($j<sizeof($rec_ded)){
	    if($rec_ded[strtolower($dedhdar[$j])]>0)
	
	    {echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec_ded[strtolower($dedhdar[$j])],2,".",",").'</td>';
	    }}
	    	    else
	    {
	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	        
	    }

	}
?>
	
<td align="right"><?php echo number_format($rec_tot["tot_deduct"],2,".",","); ?></td>
</tr>


<tr>
<?php
for ($j= 0 ;$j <$maxcol;$j++)
	{   if (is_array($rec_adv)){
	    if ($j<sizeof($rec_adv)){
	    if($rec_adv[strtolower($advhdar[$j])]>0)
	{
	    echo '<td  width="'. $colwidth.'%" align="right" >'.number_format($rec_adv[strtolower($advhdar[$j])],2,".",",").'</td>';
	}}}
	else
	   {
	    echo '<td  width="'. $colwidth.'%" align="right" >-</td>';
	        
	    }

	}
?>
	
<td align="right">-</td>
</tr>



 
 
</table>
</div>
<br>
<script>
    function myFunction() {
        window.print();
    }
	
</script>



</body>
</html>
