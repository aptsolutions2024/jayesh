<?php
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/leave.php");
//session_start();
//error_reporting(0);
$userObj=new user();
$leave=new leave();
if(isset($_POST['nameman']) && $_POST['nameman']!=""){
	$nameman =$_POST['nameman'];
	$amountman =$_POST['amountman'];
	
}else{
 $client = $_POST['client'];
 $empid = $_POST['empid'];
}
$payment_date = $_POST['payment_date_'];
///$type = $_POST['type'];
 $checkdate1 = str_replace('-','',$_POST['checkdate']);
 

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
	
if(!isset($_POST['nameman'])){
	$res = $leave->selectCheckPrinting($empid,$client,$payment_date);	
}
//echo $select;
?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
 <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/style.css">
	<style>
	.chqbgdiv{background-image: url('../images/sbi_cts.jpg'); height:292px; width:650px; }
	.chqdt{margin-left:500px; letter-spacing: 8px; padding-top:18px }
	.chqname{height:23px; margin-top:24px; padding-left:60px; text-transform: uppercase;}
	.chqamtword{line-height:27px; padding-left:100px; padding-right:20px;width:525px;  position: absolute;}
	.chqamtnum{margin-left:505px; margin-top: 27px;}
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
if(!isset($_POST['nameman'])){
//while($row = mysql_fetch_array($res)){
	foreach($res as $row){
		
	//echo date('dmY',strtotime($row['date']);
?>

<div style="width:100%" class="page-bk"><div class="chqbgdiv">
<div class="chqdt"><?php if(isset($row['date']) && $row['date']!="0000-00-00"){echo date('dmY',strtotime($row['date']));}else{$checkdate1;}?><div class="acpay">============<br>A/C PAYEE ONLY<br>============</div></div>
<div class="chqname"><?php echo $row['first_name']." ".$row['middle_name']." ".$row['last_name']; ?></div>
<div class="chqamtword" style=""><?php echo ucwords(convert_digit_to_words(round($row['amount'])))." Only";?></div>
<div class="chqamtnum" style=""><?php echo $row['amount'];?></div>
<div class="chqacno"><?php echo $row['bankacno'];?></div>
<div class="chqcomnm" ><?php //echo $compname; ?></div>
	</div>
</div>
<?php } } else {?>
<!--- for manually printing --->
<div style="width:100%" class="page-bk"><div style="" class="chqbgdiv">
<div class="chqdt"><span ><?php if(isset($checkdate1) && $checkdate1!=""){echo $checkdate1;}else{echo "&nbsp;";}?></span><div class="acpay">============<br>A/C PAYEE ONLY<br>============</div></div>
<div class="chqname"><?php echo $nameman; ?></div>
<div class="chqamtword" style=""><?php echo ucwords(convert_digit_to_words(round($amountman)))." Only";?></div>
<div class="chqamtnum" style=""><?php echo $amountman;?></div>
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