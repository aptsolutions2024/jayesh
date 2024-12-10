<?php
session_start();

//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/bonus.php");
$userObj=new user();
$bonus=new bonus();

include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);


$resbnk=$userObj->showBank($comp_id);
 $tcount=mysql_num_rows($resbnk);
$resclt=$userObj->displayClient($clintid);

$cmonth=$resclt['current_month'];
$monthtit =  date('F Y',strtotime($cmonth));

$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];

$startbon = explode('-',$_SESSION['startbonusyear']);
 $startbon = $startbon[2]."-".$startbon[1]."-".$startbon[0];
$endbon = explode('-',$_SESSION['endbonusyear']);
 $endbon = $endbon[2]."-".$endbon[1]."-".$endbon[0];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='bonus';
    $frdt=$cmonth;
    $todt=$cmonth;

 }
else{
    $tab_emp='bonus';
	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
 }

if($month!=''){
    $reporttitle="SALARY BANK FOR THE MONTH ".strtoupper($monthtit);
}
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;


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
        $moneystr = getwords($lacval) . " LAC ";
    }
*/
    if($lacval > 0)
    {
        $workword = getwords($lacval);
        if ($moneystr == "")
        {
            $moneystr = $workword . " LAC ";
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
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->
<?php
$count=0;
//te = tran_employee, e = employee, 
while($row=mysql_fetch_array($resbnk)){
   $sql11 = $bonus->getNeftBonus($comp_id,$user_id,$row['mast_bank_id'],$clintid,$startbon,$endbon);
  /*$sql11 = "select te.emp_id,te.tot_bonus_amt,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$row['mast_bank_id']."'  and te.client_id = '".$clintid."' and te.from_date >= '$startbon' and te.todate <= '$endbon' and te.tot_bonus_amt > 0 and te.pay_mode = 'T' ORDER BY te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";*/
 // echo $sql11;
    $res11 =  $sql11;
	$row21=$bonus->getNeftBonusSum($comp_id,$user_id,$row['mast_bank_id'],$clintid,$startbon,$endbon);
     
   //$money=round($row21['bonus_amount']);
  $money=round($row21);
  $stringmoney=makewords($money);
    $ecount= $sql11->rowCount();
   if($ecount!='') {
       ?>

       <div <?php if ($tcount > $count){ ?>class="page-bk"<?php } ?> >
           <div class="header_bg">

               <?php
               if ($tcount > $count) {
                   include('printheader.php');
               }
               ?>
           </div>


           <div class="row">

               <div>
                   <div>
                       <br/>
                       To,
                   </div>
                   <div>
                       The Branch Manager,
                   </div>
                   <div>
                       <?php echo $row['bank_name']; ?>
                   </div>
                   <div>
                       <?php echo $row['branch']; ?>
                   </div>

                   <div><br/> <br/>
                       Dear Sir,
                   </div>
                   <div>
                       Enclosed please find Cheque No. -  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Date - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; for

                       Rs. <?php echo $money;  ?>/- ( RUPEES <?php  echo strtoupper($stringmoney); ?> ONLY )

                       for crediting salary to the individual account of the persons shown

                       below for the MONTH : <?php echo strtoupper($monthtit); ?> as per details given their in.
                   </div>

                   <div>
                       <br/>
                       <table width = "90%">
                           <tr>
                                <td class='thheading'>Sr.No</td>
                              <td class='thheading'>Emp.Id.</td>
                               <td class='thheading'>Name of the employee</td>
                               <td class='thheading'>A/c No.</td>
                               <td class='thheading'>Amount Rs.</td>
                           </tr>
                           <?php
						   $srno = 1;
						   foreach($res11 as $rowemp){                              
                               ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>
          				   
                                    <td><?php echo $rowemp['emp_id']; ?></td>
                                   <td><?php echo $rowemp['first_name'] . ' ' . $rowemp['middle_name'] . ' ' . $rowemp['last_name']; ?></td>
                                   <td><?php echo $rowemp['bankacno']; ?></td>
                                   <td><?php echo $rowemp['tot_bonus_amt']; ?></td>
                               </tr>
							   
                               <?php $srno++;
                           }
                           ?>
						   <tr> <td></td><td></td><td></td><td align = "right">TOTAL</td><td><?php echo number_format($money,2,'.',','); ?> </td></tr>
                       </table>
                   </div>


               </div>


           </div>

           <br/> <br/>

           <div class="row">

               <div>
                   Please acknowledge.
               </div>


               <div> Thanking you,</div>


               <div> Yours faithfully,</div>
               
               
               <div>
                   For  <?php
                 $co_id=$_SESSION['comp_id'];
                    $rowcomp=$adminObj->displayCompany($co_id);
					
                    echo $rowcomp['comp_name']; ?>
               </div>
			   <br><br><br><br>
               
               
			   <div> PARTNER/AUTHORISED SIGNATORY</DIV>
           </div>
           <br/>
       </div>

       <?php
   }
    $count++;
}


?>

<!-- header end -->
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>