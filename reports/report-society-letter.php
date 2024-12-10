<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];

 $bank_id = $_REQUEST['bankid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);



$resclt=$userObj->displayClient($clintid);






$cmonth=$resclt['current_month'];
$monthtit =  date('F Y',strtotime($cmonth));

$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
	$tab_deduct = 'tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;

 }
else{
    $tab_emp='hist_employee';
	$tab_deduct = 'hist_deduct';
	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
 }


$resbnk=$userObj->showDeductBank($comp_id,$tab_deduct);
$tcount=mysql_num_rows($resbnk);


if($month!=''){
    $reporttitle='';//"SALARY BANK FOR THE MONTH ".strtoupper($monthtit);
}
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;

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
while($row=$resbnk->fetch_assoc()){
   $res11 = $userObj->getReportSocietyLetter($tab_deduct,$bank_id,$frdt);
  $res21 = $userObj->getReportSocietyLetterSumAmt($tab_deduct,$bank_id,$frdt);
   
    $row21=$res21->fetch_assoc();
   $money=round($row21['amount']);
   $stringmoney=$userObj->convertNumberTowords($money);
  //$stringmoney=makewords($money);
    $ecount=mysqli_num_rows($res11);
   if($ecount!='') {
       ?>

       <div <?php if ($tcount > $count){ ?>class="page-bk"<?php } ?> >
	   
	   <div >
    <table width="100%" id="appletter"border="none">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style="width:45%; float:right">
<?php
$comapnydtl = $userObj->showCompdetailsById($comp_id);
 echo $comapnydtl['comp_name'];?>
<?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?>
	
	</div></td></tr></thead>
    
	
	
	
</table></div>


	   
<!--           <div class="header_bg">

               /* <?php
               //if ($tcount > $count) {
               //    include('printheader.php');
             //  }
              // ?> */
           </div>-->


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
                               <td class='thheading'>Amount Rs.</td>
                           </tr>
                           <?php
						   $srno = 1;
                           while ($rowemp = mysql_fetch_array($res11)) {
                               ?>
                               <tr>
			                          <td align = "centre"><?php echo $srno; ?></td>
          				   
                                    <td><?php echo $rowemp['emp_id']; ?></td>
                                   <td><?php echo $rowemp['first_name'] . ' ' . $rowemp['middle_name'] . ' ' . $rowemp['last_name']; ?></td>
                                   <td><?php echo $rowemp['amount']; ?></td>
                               </tr>
							   
                               <?php $srno++;
                           }
                           ?>
						   <tr> <td></td><td></td><td align = "right">TOTAL</td><td><?php echo number_format($money,2,'.',','); ?> </td></tr>
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