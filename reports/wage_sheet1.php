<?php
//print_r($_REQUEST);
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

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
	$tab_inc = 'tran_income';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$tab_inc = 'hist_income';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
	
	//$todt=date("Y-m-d", strtotime('2017-06-30'));
	
  }
$tab = "`tab_".$user_id."`";




$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);
$i = 0;
$days[]=0;
 $sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";


 $sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
$rowtab= mysql_query($sql_days);
while($rowtab1 = mysql_fetch_array($rowtab)){
	
	if ($rowtab1['present'] >0){$sql=$sql.",`present` float not null";$days[$i]='present';$i++;}
	if ($rowtab1['weeklyoff'] >0){$sql=$sql.",`weeklyoff` float not null";$days[$i]='weeklyoff';$i++;}
	if ($rowtab1['absent'] >0){$sql=$sql.",`absent` float not null";$days[$i]='absent';$i++;}
	if ($rowtab1['paidholiday'] >0){$sql=$sql.",`paidholiday` float not null";$days[$i]='paidholiday';$i++;}
	if ($rowtab1['pl'] >0){$sql=$sql.",`pl` float not null";$days[$i]='pl';$i++;}
	if ($rowtab1['sl'] >0){$sql=$sql.",`sl` float not null";$days[$i]='sl';$i++;}
	if ($rowtab1['cl'] >0){$sql=$sql.",`cl` float not null";$days[$i]='cl';$i++;}
	if ($rowtab1['additional'] >0){$sql=$sql.",`additional` float not null";$days[$i]='additional';$i++;}
	if ($rowtab1['othours'] >0){$sql=$sql.",`othours` float not null";$days[$i]='othours';$i++;}
	if ($rowtab1['nightshifts'] >0){$sql=$sql.",`nightshifts` float not null";$days[$i]='nightshifts';$i++;}
	if ($rowtab1['fullpay'] >0){$sql=$sql.",`fullpay` float not null";$days[$i]='fullpay';$i++;}
	if ($rowtab1['halfpay'] >0){$sql=$sql.",`halfpay` float not null";$days[$i]='halfpay';$i++;}
	if ($rowtab1['leavewop'] >0){$sql=$sql.",`leavewop` float not null";$days[$i]='leavewop';$i++;}
	if ($rowtab1['otherleave'] >0){$sql=$sql.",`otherleave` float not null";$days[$i]='otherleave';$i++;}
	break;
}
$sql=$sql.",`payabledays` float not null";

$sql_inc = "select distinct ti.head_id,trim(mi.income_heads_name) as income_heads_name from $tab_inc  ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt'"; 
$rowtab= mysql_query($sql_inc);


while($rowtab1 = mysql_fetch_array($rowtab)){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
	$sql=$sql.",`std_".strtolower($rowtab1['income_heads_name'])."` float not null";
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
	$std_inhdar[$inhd] = "STD_".$rowtab1['income_heads_name'];
	
	$inhd++;
}
$sql=$sql.",`gross_salary` float not null";



 $sql_ded = "select distinct tdd.head_id,trim(md.deduct_heads_name) as deduct_heads_name from $tab_empded  tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt'";   
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	
	$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
}

 $sql_adv = "select distinct tadv.head_id,trim(madv.advance_type_name) as advance_type_name from $tab_adv  tadv inner join mast_advance_type madv on tadv.head_id = madv.mast_advance_type_id    where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt'";   

$rowtaba= mysql_query($sql_adv);
while($rowtaba1 = mysql_fetch_array($rowtaba)){
	$sql=$sql.",`".strtolower($rowtaba1['advance_type_name'])."` float not null";
	
	$advhdar[$advhd] = $rowtaba1['advance_type_name'];
	$advhd++;
}




$sql=$sql.",`tot_deduct` float not null";
$sql=$sql.",`netsalary` float not null";

$sql=$sql.",`bankname` varchar(150) not null";

$sql=$sql.",`deptname` varchar(100) not null";
$sql=$sql.",`designation` varchar(100) not null";
$sql=$sql.",`qualification` varchar(100) not null";
$sql=$sql.",`location` varchar(100) not null";
$sql=$sql.",`cc_code` varchar(100) not null";
$sql = $sql." ) ENGINE = InnoDB";


$row= mysql_query($sql);



//tran/hist employee

 $sql = "insert into $tab ( `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`, payabledays,`gross_salary`,`tot_deduct`, `netsalary`)  select `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`,payabledays, `gross_salary`,`tot_deduct`, `netsalary`  from $tab_emp where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt'";
$row= mysql_query($sql);

 $sql= "update $tab t inner join mast_client mc on mc.mast_client_id = t.client_id set t.client_name = mc.client_name";
$row= mysql_query($sql);
 
$sql= "update $tab t inner join mast_desg md on md.mast_desg_id = t.desg_id set  t.designation = md.mast_desg_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_dept md on md.mast_dept_id = t.dept_id set  t.deptname = md.mast_dept_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_qualif mq on mq.mast_qualif_id = t.qualif_id set  t.qualification = mq.mast_qualif_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_location ml on ml.mast_location_id = t.loc_id set  t.location = ml.mast_location_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join paycode mp on mp.mast_paycode_id = t.paycode_id set  t.cc_code = mp.mast_paycode_name";
$row= mysql_query($sql);

 $sql= "update $tab t inner join mast_bank mb on mb.mast_bank_id = t.bank_id set  t.bankname = concat(mb.bank_name,' ',mb.branch,' ',mb.ifsc_code)";

$row= mysql_query($sql);
$sql= "update $tab t inner join employee e on e.emp_id = t.emp_id set  t.emp_name =concat( e.first_name,' ',e.middle_name,' ' , e.last_name) ";
$row= mysql_query($sql);

//Tran/hist days
$sql= "update $tab t inner join $tab_days td on t.emp_id=td.emp_id and t.sal_month= td.sal_month set ";
for ($j =0;$j<$i;$j++){
	$sql = $sql. "t.`".$days[$j]."` = td.`".$days[$j]."`,";
}
$sql = $sql." t.present= td.present where td.client_id = '$client_id' and td.comp_id = '$comp_id' and td.user_id = '$user_id' and td.sal_month >= '$frdt' and td.sal_month <= '$todt'";

//echo $sql;

$row= mysql_query($sql);


//tran_hist income
$rowtab= mysql_query($sql_inc);
while($rowtab1 = mysql_fetch_array($rowtab)){
	
	 $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.std_amt,ti.amount,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount,t.`std_".strtolower($rowtab1['income_heads_name'])."` = inc.std_amt";
	
	$row= mysql_query($sql);
}
////tran_hist income deduction updation
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	$row= mysql_query($sql);
}



////tran_hist income deduction updation
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	$row= mysql_query($sql);
}


////tran_hist advance updation
$rowtaba= mysql_query($sql_adv);
while($rowtaba1 = mysql_fetch_array($rowtaba)){
	
	 $sql = "update $tab t inner join (select tadv.emp_id,tadv.sal_month,tadv.head_id,tadv.amount,mah.advance_type_name  as head_name from $tab_adv  tadv inner join mast_advance_type  mah on tadv.head_id=mah.mast_advance_type_id     where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' and  mah.advance_type_name  like '%".strtolower($rowtaba1['advance_type_name'])."%'  ) adv on t.emp_id = adv.emp_id and t.sal_month = adv.sal_month set t.`".strtolower($rowtaba1['advance_type_name'])."` = adv.amount";
	$row= mysql_query($sql);
}




  $setSql1= "select * from $tab order by emp_id,sal_month ";

$setRec = mysql_query($setSql1);

if($month!=''){
    $reporttitle="Paysheet for ".date('F Y',strtotime($frdt));
}

$p='';
/* if($emp=='Parent'){
    $p="(P)";
}
 */
$_SESSION['client_name']=$resclt['client_name'].$p;

$_SESSION['reporttitle']=strtoupper($reporttitle);
//print_r($inhdar);
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
		margin: 15mm 0mm 8mm 0mm;
	
} 
			}
		
    </style>
	
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<div class="header_bg">
<?php
include('printheader3.php');

?>
</div>

<?php //echo count($inhdar);
//echo count($dedhdar);
//echo count($days);


$totnetsalary= 0;
$totpayable=0;
$totgrosssal=0;
$tottotded=0;

 ?>
<div class="row body page-bk" cellspacing="0" cellpadding="0">
	
<table width="" >
<tr> 
<td width="2%"><b>srno</b> </td>
<td width="3%"><b>EmpId</b></td>
<td width="12%"><b>Name</b></td>
<td colspan="12" width="66%">&nbsp;</td>
<td  width="6%" align="center"><b>Total</b></td>
<td  width="6%" align="center"><b>Netsal</b></td>
</tr>
<?php
$incarray = array();

 $sr=1; while($rec = mysql_fetch_array($setRec)) { 
 
 if($sr%$noofper==0)
 {
	 echo "</table></div><div class=' row body page-bk'><table class='padd0imp' cellspacing='0' cellpadding='0' border='none'> ";
	 echo '<tr> 
<td width="2%"><b>srno</b> </td>
<td width="3%"><b>EmpId</b></td>
<td width="12%"><b>Name</b></td>
<td colspan="12" width="66%">&nbsp;</td>
<td  width="6%" align="center"><b>Total</b></td>
<td  width="6%" align="center"><b>Netsal</b></td>
</tr>';
 }
 ?>
<tr style="border:1px!important">
<td><?php echo $sr;?></td>
<td  ><?php echo $rec['emp_id'];?></td>
<td ><?php echo $rec['emp_name'];?></td>
<td colspan="12" class="padd0" style="border: 0px solid black!important;">
<table cellspacing='0' cellpadding='0'  style="border: 0px solid black!important;">
<tr >
<th width="8%" align="left">Days </th>
<td >
<?php foreach($days as $day ){$day1 = clean($day);if ($rec[$day]> 0){echo "<div class='per20inl' style='padding-right:25px'>"; 


if (substr(strtoupper($day),0,5) == 'PRESE'){
	 echo "PR.DAY";
}elseif (substr(strtoupper($day),0,5) == 'WEEKL'){
	 echo "W.OFF.";
}elseif ( substr(strtoupper($day),0,5) == 'OTHOU'){
	 echo "O.T.";
}else {echo substr(strtoupper($day),0,5);}
	 
	 


echo "<span class='".$day1." ' style='float:right'>".number_format($rec[$day],2,'.',',').'</span></div>'; }}?>
</td>
</tr>



<tr>

<th width="8%" align="left">Std Inc.  </th>
<td>
<?php 
//print_r($std_inhdar);
foreach($std_inhdar as $std_inc){$std_inc1 = clean($std_inc); if($rec[strtolower($std_inc)]>0) {  echo "<div class='per20inl' style='padding-right:25px'>";

IF (substr($std_inc,0,5)=='OVERT')
{ echo "O.T.";}

ELSE
{echo substr($std_inc,4,5);}

echo "<span class='".strtolower($std_inc1)."' style='float:right'>".number_format($rec[strtolower($std_inc)],2,".",",").'</span>&nbsp;</div>' ;} }?>
</td>
</tr>



<tr>

<th width="8%" align="left">Inc.  </th>
<td>
<?php foreach($inhdar as $inc){$inc1 = clean($inc); if($rec[strtolower($inc)]>0) {  echo "<div class='per20inl' style='padding-right:25px'>";

IF (substr($inc,0,5)=='OVERT')
{ echo "O.T.";}

ELSE
{echo substr($inc,0,5);}

echo "<span class='".strtolower($inc1)."' style='float:right'>".number_format($rec[strtolower($inc)],2,".",",").'</span>&nbsp;</div>' ;} }?>
</td>
</tr>
<tr>
<th width="8%" align="left">Ded. </th>
<td><?php foreach($dedhdar as $ded){$ded1 = clean($ded);if ($rec[strtolower($ded)]>0){ echo "<div class='per20inl' style='padding-right:25px'>";


if (substr($ded,0,5)=='PROF.')
{ echo "P.TAX";}
ELSE{
ECHO substr($ded,0,5);}

echo "<span  style='float:right'  >".number_format($rec[strtolower($ded)],2,'.',',') .'</span><input type="hidden" value="'.$rec[strtolower($ded)].'" class="'.strtolower($ded1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php if ($advhd >0){?>
<tr>


<th width="8%" align="left">Adv. </th>
<td><?php foreach($advhdar as $adv){$adv1 = clean($adv);if ($rec[strtolower($adv)]>0){ echo "<div class='per20inl' style='padding-right:25px'>"; 
if (substr($adv,0,5)=='FESTI')
{ echo "F.ADV";}
else if (substr($adv,0,5)=='SALAR')
{ echo "S.ADV";}
else
{echo substr($adv,0,5); }

echo "<span  style='float:right'  >".number_format($rec[strtolower($adv)],2,".",",") .'</span><input type="hidden" value="'.$rec[strtolower($adv)].'" class="'.strtolower($adv1).'">&nbsp;</div>';} }?>
</td>
</tr>
<?php }?>

</table>

</td>
<td width="6%" align='right' class="padd0" style="border: 0px solid black!important;" >
<table cellspacing='6' cellpadding='0'  >
<tbody>
<tr style="border:  1px solid black!important;">
<td  style="padding: 3px!important;">
<span class="payabledays" ><?php echo number_format($rec['payabledays'],2); $totpayable +=$rec['payabledays']; ?> </span> </td></tr>

<tr style="border:  1px solid black!important;">
<td  style="padding: 3px!important;">
<span class="payabledays" ><?php echo "-"; ?> </span> </td></tr>
<tr><td style="padding: 3px!important;">

<span class="grosssalary" ><?php echo number_format($rec['gross_salary'],2); $totgrosssal +=$rec['gross_salary']; ?></span> </td></tr>
<tr style="border:  1px solid black!important;"><td  style="padding: 3px!important;"><span class="totdeduct" ><?php echo number_format($rec['tot_deduct'],2); $tottotded +=$rec['tot_deduct'];?></span></td>
</tr>
<tr style="border:  1px solid black!important;">
<td  style="border: 0px solid black!important;padding: 3px!important;">
<span class="payabledays" ><?php echo "-"; ?> </span> </td></tr>
</tbody>
</table>

</td>
<td width="6%"><?php echo "<br><br><br><br>".number_format($rec['netsalary'],2); $totnetsalary +=$rec['netsalary'];?> </td>
</tr>



   
<?php $sr++; }?>
<!--- for total ----->
<tr>
<td> &nbsp; </td>
<td></td>
<td>Total</td>
<td colspan="12" class="padd0" style="border: 0px solid black!important;">
<table class="padd0imp">
<tr>
<th width="8%" align="left">Days </th>
<td>
<?php foreach($days as $day ){ echo "<div class='per20inl' style='padding-right:25px'> ";




if (substr(strtoupper($day),0,5) == 'PRESE'){
	 echo "PR.DAY";
}elseif (substr(strtoupper($day),0,5) == 'WEEKL'){
	 echo "W.OFF.";
}elseif (substr(strtoupper($day),0,5) == 'OTHOU'){
	 echo "O.T.";
}else 	 {echo substr(strtoupper($day),0,5);}
?>
	<span id="<?php echo strtolower($day); ?>" style='float:right'></span>
	

	<script>
	$( document ).ready(function() {
	var sumd = 0;
	var tt =0
	$('.<?php echo $day;?>').each(function(){
		tt = $(this).text();
		tt.replace(/[^a-zA-Z ]/g, "");
		if(tt==""){tt=0;}
		sumd += parseFloat(tt);  
		$("#<?php echo strtolower($day); ?>").text(sumd.toFixed(2));
	});
	});
	</script>
<?php echo "</div>";}?>
</td>
</tr>
<tr>
<th width="8%" align="left">Inc.  </th>
<td>
<?php foreach($inhdar as $inc){ $inc1 = clean($inc); echo "<div class='per20inl' style='padding-right:25px' >";
IF (substr($inc,0,5)=='OVERT')
{ echo "O.T.";}
ELSE
{echo substr($inc,0,5);}

?>
	<span id="tot<?php echo strtolower($inc1); ?>" style='float:right'> </span>
	<script>
	
	$( document ).ready(function() {
	var sumin = 0;
	var tt =0
	$('.<?php echo strtolower($inc1);?>').each(function(){
		tt = $(this).text();
		tt=tt.replace(/\,/g,'')
		tt.replace(/[^a-zA-Z ]/g, "");
		if(tt==""){tt=0;}
		sumin += parseFloat(tt); 
		$("#tot<?php echo strtolower($inc1); ?>").text(sumin.toFixed(2));
	});
	});
	</script>
<?php echo "</div>";}?>
</td>
</tr>
<tr>
<th width="8%" align="left">Ded. </th>

<td>
<?php foreach($dedhdar as $ded){ $ded1 = clean($ded); echo "<div class='per20inl' style='padding-right:25px' >";
IF (substr($ded,0,5)=='PROF.')
{ echo "P.TAX";}
ELSE
{echo substr($ded,0,5);}

?>
	



	<span id="tot<?php echo strtolower($ded1); ?>" style='float:right'></span>
	<script>
	$( document ).ready(function() {
	var sumded = 0;
	var tt1 =0;
		$('.<?php echo strtolower($ded1);?>').each(function(){
			tt1 = $(this).val();
			tt1=tt1.replace(/\,/g,'')
	
		if(tt1==""){tt1=0;}
			sumded += parseFloat(tt1);  
			$("#tot<?php echo strtolower($ded1); ?>").text(sumded.toFixed(2));
		});
	});
	</script>
<?php echo "</div>";}?>
</td>
</tr>


<tr>
<th width="8%" align="left">Adv. </th>
<td>

<?php foreach($advhdar as $adv){ $adv1 = clean($adv); echo "<div class='per20inl' style='padding-right:25px' >";
IF (substr($adv,0,5)=='FESTI')
{ echo "F.ADV";}
ELSE if (substr($adv,0,5)=='SALAR')
	{echo "S.ADV";}
else
{echo substr($adv,0,5);}

?>
		<span id="tot<?php echo strtolower($adv1); ?>" style='float:right'></span>
	<script>
	$( document ).ready(function() {
	var sumadv = 0;
	var tt1 =0;
		$('.<?php echo strtolower($adv1);?>').each(function(){
			tt1 = $(this).val();
			tt1=tt1.replace(/\,/g,'')
	
		if(tt1==""){tt1=0;}
			sumadv += parseFloat(tt1);  
			$("#tot<?php echo strtolower($adv1); ?>").text(sumadv.toFixed(2));
		});
	});
	</script>
<?php echo "</div>";}?>
</td>
</tr>


















</table>

</td>
<td width="6%" align='right' >
<span ><?php echo number_format($totpayable,2); ?></span> <br><br>
<span ><?php echo number_format($totgrosssal,2);?></span> <br><br>
<span ><?php echo number_format($tottotded,2);?></span><br>

</td>
<td width="6%"><?php echo "<br><br><br><br>".number_format($totnetsalary,2);?> </td>
</tr>
</table>
</div>
<div></div>
<script>
    function myFunction() {
        window.print();
    }
	
</script>



<?php function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}?>
</body>
</html>
