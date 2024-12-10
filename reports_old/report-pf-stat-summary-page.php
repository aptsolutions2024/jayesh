<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
 $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

if($month=='current'){
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
    $todt=$cmonth;
}
else{
   
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	
	$frdt = $userObj->getLastDay($frdt);
	$todt = $userObj->getLastDay($todt);
}
$monthtit =  date('F Y',strtotime($frdt));
$reporttitle="P.F. Summary Statement FOR THE MONTH ".$monthtit;
$p='';
if($emp=='Parent'){
    $p="(P)";
}
$_SESSION['client_name']=$resclt['client_name'].$p;
$_SESSION['reporttitle']=strtoupper($reporttitle);

$res12 =$userObj->reportPfStatSummery($emp,$tab_empded,$clientid,$frdt,$comp_id);

       
$tcount= mysqli_num_rows($res12);

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


<!-- header end -->

<!-- content starts -->




<div>
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>


    <div class="row body" >
        <table width="100%">
<?php
		
			$res13 =$userObj->getPfCharge($frdt);
			$res14 = $res13->fetch_assoc();
?>
    <tr>
        <th align="center" width="7%" class="thheading" >Client No </th>
        <th align="left" colspan="11" class="thheading">Name Of the Client </th>
    </tr>
        <tr>
        <th width="7%" align="center" class="thheading">PF-Wages   </th>
        <th width="7%" align="center"  class="thheading">P.F  <br />
            <?php echo number_format($res14['acno1_employee'],2,".",","); ?> % <br />
            (1)</th>

        <th align="center" width="7%" class="thheading">P.F  <br />
            <?php echo number_format($res14['acno1_employer'],2,".",",");?> % <br />

            (1)</th>
        <th align="center" width="7%" class="thheading">P.F Total  <br />
             <?php echo number_format($res14['acno1_employer']+$res14['acno1_employee'],2,".",",");?>% <br />

            (Ac.No.1)</th>
			
        <th align="center" width="7%" class="thheading">Pension  <br />
        <?php echo number_format($res14['acno10'],2,".",",");?>% <br />
            (Ac.No.10)</th>
        <th align="center" width="7%" class="thheading">Total.
            <br />  <?php echo number_format($res14['acno1_employer']+$res14['acno1_employee']+$res14['acno10'],2,".",",");?>% <br />
            (I+X)</th>
        <th align="center" width="7%" class="thheading">ADM Charges
            <br />  0.50% <br />
               (Ac.No.2)</th>
        <th align="center" width="7%" class="thheading">Link Insur.
            <br />  0.5% <br />
               (Ac.No.21)</th>
        <th align="center" width="7%" class="thheading">ADM Chr Ins
            <br />  0.00% <br />
               (Ac.No.22)</th>
        <th align="center" width="7%" class="thheading">Total
            <br />Payble</th>
        <th align="center" width="7%" class="thheading">Covered
            <br />Employees</th>
        <th align="center" width="7%" class="thheading">Not Covered
            <br />Employees</th>


    </tr>

<?php
$totalamt=0;
$totalco1=0;
$ttotalco1=0;


$ttotalco2=0;
$totalpf1=0;
$totalpf2=0;
$totpf2=0;
$totalpf3=0;
$totalpf4=0;
$totalpf5=0;
$totalpf6=0;
$totalpf7=0;
$totalco2 =0;
$totalstdam=0;

$c[]='';
$i=0;
while($row=$res12->fetch_assoc()){
    $total1=0;
    $totemp =$userObj->getTotalEmployeeByClient($tab_emp,$row['client_id'],$frdt);

    $totpfemp =$userObj->getTotalEmployeePfEployeeByClient($tab_empded,$row['client_id'],$frdt,$comp_id);

    ?>
    <tr>
        <td align="center">
            <?php
            echo $row["client_id"];
      ?>
        </td>

        <td colspan="10">
            <?php
			/*if ($emp = "Parent")
			{ echo $_SESSION['client_name'];}
		    else{*/
            echo $row["client_name"];
       ?>
        </td>
    </tr>
    <tr>
        <td align="center">
            <?php
            echo $row['std_amt'];
            $totalstdam=$totalstdam+$row['std_amt'];
            ?>
        </td>

        <td align="center">
            <?php


            echo $pf1=$row['amount'];
            $totalpf1=$totalpf1+$pf1;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf2=$row['employer_contri_1'];
            $totalpf2=$totalpf2+$pf2;
            ?>
        </td>
		
		<td align="center">
            <?php
            echo $totpf2=$row['employer_contri_1']+$row['amount'];
            $totpf2=$totalpf2+$pf2+$row['amount'];
            ?>
        </td>
		
        <td align="center">
            <?php
             echo $pf3=$row['employer_contri_2'];
            $totalpf3=$totalpf3+$pf3;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf4=$pf3+$pf2+$pf1;
            $totalpf4=$totalpf4+$pf4;
            ?>
        </td>

        <td align="center">
            <?php
            echo $pf5=round($row['std_amt']*0.5/100,0);
            $totalpf5=$totalpf5+$pf5;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf6=round($row['std_amt']*0.5/100,0);
            $totalpf6=$totalpf6+$pf6;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf7=round($pf4*0.0001/100,0);
            $totalpf7=$totalpf7+$pf7;
            ?>
        </td>
       <td align="center">
            <?php
            echo $pf4+$pf5+$pf6+$pf7;
            $totalco2=$totalco2+$pf4+$pf5+$pf6+$pf7;
            ?>
        </td>

            <td align="center">
            <?php
            echo $totpfemp;
            $ttotalco1=$ttotalco1+$totpfemp;
            ?>
        </td>
  <td align="center">
            <?php
            echo $totemp-$totpfemp;
            $ttotalco2=$ttotalco2+$totemp-$totpfemp;
            ?>
        </td>


    </tr>
            <?php
    $i++;

}


$s=array_count_values($c);

?>
<tr>
<td>TOTAL </td>
</tr>

            <tr>
                <td align="center" class="thheading">
                    <?php
                    echo $totalstdam;

                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php


                    echo $totalpf1;

                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf2;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf2+$totalpf1;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf3;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf2+$totalpf1+$totalpf3;
                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php
                    echo $totalpf5;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf6;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf7;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalco2;
                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php
                    echo $ttotalco1;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $ttotalco2;
                    ?>
                </td>


            </tr>

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