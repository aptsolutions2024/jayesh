<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$clientid= $_SESSION['clintid'];
$resclt=$userObj->displayClient($clientid);

$cmonth=$resclt['current_month'];
$type = $_GET['type'];
if($type=="B"){
$startday = $_SESSION['startbonusyear'];
$endday = $_SESSION['endbonusyear'];
}
if($type=="L"){
	$payemnt_date = $_GET['payment_date'];
}
$userObj=new user();
if(isset($_GET['nameman']) && $_GET['nameman']!=""){
	$nameman =$_GET['nameman'];
	$amountman =$_GET['amountman'];
	
}else{
  $client = $_GET['client'];
 $empid = $_GET['empid'];
}

 $checkdate1 = str_replace('-','/',$_GET['checkdate']);
 $num=0;


function convert_digit_to_words($no)  
	{   
	
	//creating array  of word for each digitASDJK
	 $words = array('0'=> 'Zero' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lac','10000000' => 'crore');
	 
	 //for decimal number taking decimal part
	 
	$cash=(int)$no;  //take number wihout decimal
	$decpart = $no - $cash; //get decimal part of number
	
	$decpart=sprintf("%01.2f",$decpart); //take only two digit after decimal
	
	$decpart1=substr($decpart,2,1); //take first digit after decimal
	$decpart2=substr($decpart,3,1);   //take second digit after decimal  
	
	$decimalstr='';
	
	//if given no. is decimal than  preparing string for decimal digit's word
	
	if($decpart>0)
	{
	 $decimalstr.="point ".$numbers[$decpart1]." ".$numbers[$decpart2];
	}
	 
	    if($no == 0)
	        return ' ';
	    else {
	    $novalue='';
	    $highno=$no;
	    $remainno=0;
	    $value=100;
	    $value1=1000;       
	            while($no>=100)    {
	                if(($value <= $no) &&($no  < $value1))    {
	                $novalue=$words["$value"];
	                $highno = (int)($no/$value);
	                $remainno = $no % $value;
	                break;
	                }
	                $value= $value1;
	                $value1 = $value * 100;
	            }       
	          if(array_key_exists("$highno",$words))  //check if $high value is in $words array
	              return $words["$highno"]." ".$novalue." ".convert_digit_to_words($remainno).$decimalstr;  //recursion
	          else {
	             $unit=$highno%10;
	             $ten =(int)($highno/10)*10;
	             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".convert_digit_to_words($remainno
	             ).$decimalstr; //recursion
	           }
	    }
	}
	
	
if(!isset($_GET['nameman'])){

	if ($type =="S"){
	    $res = $userObj->getCheckPrintTypeS($cmonth);
 /*$select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='S' and sal_month='$cmonth' ";*/}
    if ($type== "B")
	{
	/*$select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='B' and 
	from_date='$startday' and to_date = '$endday'";*/
	$res = $userObj->getCheckPrintTypeB($startday,$endday);
	}
	if ($type== "L")
	{
	/*echo $select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='L' and 
	payment_date='$payemnt_date'";*/
	$res = $userObj->getCheckPrintTypeL($payemnt_date);
	}
	
	$res = $userObj->getChecksDetails($type,$cmonth,$startday,$endday,$payemnt_date,$empid,$client);
	/*if($empid> 0){
	$select .=" and c.emp_id ='".$empid."'";	
	}else{
	$select .=" and e.client_id='".$client."' ";
	}*/
	
	//$res = mysql_query($select);
	$num = mysqli_num_rows($res);
	
}


//echo $select;
?>
<?php if($num==0 && !isset($_GET['nameman'])){?>
<div><h3>NO RECORD FOUND. PLEASE SAVE THE DATA.</h3></div>
<?php } ?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
 <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/style.css">
	<style>
	.chqbgdiv{background-image: url('../images/idbi1.jpg'); height:292px; width:100%; background-size: 100%;margin-top: -12px;}
	.chqdt{margin-left:600px; letter-spacing: 5px; padding-top:8px; font-size:18px }
	.chqname{height:23px; margin-top:38px; padding-left:60px; text-transform: uppercase;}
	.chqamtword{line-height:29px; padding-left:120px; padding-right:20px;width:525px;  position: absolute;}
	.chqamtnum{margin-left:620px; margin-top: 23px;}
	.chqacno{line-height:27px; padding-left:65px; padding-right:20px; margin-top: 12px;}
	.chqcomnm{margin-left:415px;margin-top:20px; font-size:11px}
	.acpay{position: absolute;    left: 0;    letter-spacing: 1px;top:16px; left: -14px;; transform: rotate(320deg);}
	</style>
	</head>
	
	
<body style="margin:0px">
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<div>
<div class="header_bg">

</div>


    <div >
<?php 
if(!isset($_GET['nameman'])){
while($row = $res->fetch_assoc()){
	//echo date('dmY',strtotime($row['date']);
?>

<div style="width:650px" class="page-bk"><div class="chqbgdiv">
<div class="chqdt"><?php if(isset($row['date']) && $row['date']!="0000-00-00"){echo date('d/m/Y',strtotime($row['date']));}else{$checkdate1;}?><div class="acpay">------------------------<br>A/C PAYEE ONLY<br>------------------------</div></div>
<div class="chqname">&nbsp; &nbsp; <?php echo $row['first_name']." ".$row['middle_name']." ".$row['last_name']; ?></div>
<div class="chqamtword" style="">&nbsp; &nbsp; <?php echo ucwords(convert_digit_to_words(round($row['amount'])))." Only";?></div>
<div class="chqamtnum" style=""><?php echo number_format($row['amount'],0,".",",")."/-";?><?php //echo $row['amount'];?></div>
<div class="chqacno"><?php //echo $row['bankacno'];?></div>
<div class="chqcomnm" ><?php //echo $compname; ?></div>
	</div>
</div>
<?php } } else {//echo $checkdate1;?>
<!--- for manually printing --->
<div style="width:100%" class="page-bk"><div style="" class="chqbgdiv">
<div class="chqdt"><span ><?php  if(isset($checkdate1) && $checkdate1!=""){echo $checkdate1;}else{echo "&nbsp;";}?></span><div class="acpay">-----------------------<br>A/C PAYEE ONLY<br>------------------------</div></div>
<div class="chqname">&nbsp; &nbsp;&nbsp;&nbsp; <?php echo $nameman; ?></div>
<div class="chqamtword" style=""><?php echo ucwords(convert_digit_to_words(round($amountman)))." Only";?></div>
<div class="chqamtnum" style=""><?php echo number_format($amountman,0,".",",")."/-";?></div>
<div class="chqacno"><?php //echo $row['bankacno'];?></div>
<div class="chqcomnm" ><?php //echo $compname; ?></div>
	</div>
</div>
<!--- end for manually printing --->
<?php } ?>
</div></div>
</body>
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
		</style>
<script>
    function myFunction() {
        window.print();
    }
</script>
</html>