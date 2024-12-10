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


include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	$frdt =$userObj->getLastDay($frdt);
	
	
  }
// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee t5= tran_days
  $res12 =$userObj->getReportPfStatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt);
/*if($emp=='Parent')
	{
	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1 inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
	}
else{
 	$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";

	//$sql = "SELECT t1.*,t2.* FROM $tab_empded t1, employee t2 where t1.emp_id=t2.emp_id AND t2.client_id='".$clientid."' AND head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') ";
}

//if($month=='current'){
 $sql .= " AND t1.sal_month='".$frdt."' ";
//else{
//  $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
//}

 $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
$res12 = mysql_query($sql);*/
$tcount= mysqli_num_rows($res12);



if($month!=''){
    $reporttitle="PF Statement FOR THE MONTH ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}
$_SESSION['client_name']=$resclt['client_name'].$p;
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
<div>
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
    <div class="row body" >
        <table width="100%">
		<?php
			$res13 = $userObj->getPfCharge($frdt);
			$res14 = $res13->fetch_assoc();
?>
    <tr>
        <th class="thheading" width="4%">Clnt No </th>
        <th class="thheading" width="4%">EmpID  </th>
        <th class="thheading" width="5%">PF No  </th>
		<th class="thheading" width="7%">UAN No </th>
        <th class="thheading" width="7%" colspan = '3'>Name Of the Employee </th>
        <th class="thheading" width="7%">P.F. Wages</th>
        <th class="thheading" width="7%">Employee's P.F.<?php echo number_format($res14['acno1_employee'],2,".",","); ?> %</th>
        <th class="thheading" width="7%">Employer's P.F. <?php echo number_format($res14['acno1_employer'],2,".",","); ?>%</th>
        <th class="thheading" width="7%">Pension <?php echo number_format($res14['acno10'],2,".",","); ?>% </th>
		<th class="thheading" width="7%">Total 24%</th>
        
        <th class="thheading" width="7%">PFAdmin <?php echo number_format(trim($res14['acno2']),2,".",","); ?>% </th>
        <th class="thheading" width="7%">DLIS <?php echo number_format(trim($res14['acno21']),2,".",","); ?>% </th>
        <th class="thheading" width="7%">DLISAdmin <?php echo number_format($res14['acno22'],2,".",","); ?>% </th>

        <th class="thheading" width="7%">Total</th>
        <th class="thheading" width="7%">NCP Days</th>
    </tr>

<?php
$totalamt=0;
$totalco1=0;
$ttotalco1=0;


$ttotalco2=0;
$totalco2=0;
$totalstdam=0;
$tabsent = 0;
$totac2=0;
$totac21=0;
$totac22=0;
$c[]='';
$i=0;
while($row=$res12->fetch_assoc()){
    $total1=0;

    ?>
    <tr>
        <td align="center" >           <?php  echo $row["client_id"];?>        </td>
        <td align="center" >           <?php  echo $row["emp_id"];?>        </td>
        <td align="center" >           <?php  echo $row["pfno"];?>        </td>
        <td align="center" >           <?php  echo $row["uan"];?>        </td>
        <td colspan="3"> <?php echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];?></td>
        <td align="center" >  <?php echo NUMBER_FORMAT($row['std_amt'],0," ",",");
									$totalstdam=$totalstdam+$row['std_amt'];
									$c[$i]=$row['amount'];
								?>  </td>       
		<td align="center" > <?php  echo NUMBER_FORMAT($row['amount'],0," ",",");
									$totalamt=$totalamt+$row['amount'];
									$c[$i]=$row['amount'];
									$total1=$row['amount'];
								?> </td>
        <td align="center" > <?php  echo NUMBER_FORMAT($row['employer_contri_1'],0," ",",");
									$totalco1=$totalco1+$row['employer_contri_1'];
								?>  </td>

        <td align="center" > <?php echo NUMBER_FORMAT($row['employer_contri_2'],0," ",",");
								   $totalco2=$totalco2+$row['employer_contri_2'];
								?> </td>

        <td align="center" > <?php echo NUMBER_FORMAT($row['employer_contri_2']+$total1,0," ",",");
									$ttotalco2=$ttotalco2+$row['employer_contri_2']+$total1;
								?> </td>
								
        <td align="center" > <?php $ac2=round($row['std_amt']*$res14['acno2']/100,0);
									echo NUMBER_FORMAT($ac2,0," ",",");
									$totac2 = $totac2+$ac2;
								?> </td>
								
        <td align="center" > <?php $ac21=round($row['std_amt']*$res14['acno21']/100,0);
									echo NUMBER_FORMAT($ac21,0," ",",");
									$totac21 = $totac21+$ac21;
								?> </td>
        <td align="center" > <?php $ac22=round($row['std_amt']*$res14['acno22']/100,0);
									echo NUMBER_FORMAT($ac22,0," ",",");
									$totac22 = $totac22+$ac22;
								?> </td>
		<td align="center" > <?php 
									echo NUMBER_FORMAT($row['employer_contri_2']+$total1+$ac2+$ac21+$ac22,0," ",",");
							 ?> </td>
								
        <td align="center" > <?php  echo NUMBER_FORMAT($row['absent'],0," ",",");
									$tabsent=$tabsent+$row['absent'];
								?>  </td>


    </tr>
            <?php
    $i++;
}
$s=array_count_values($c);
?>

            <tr>
                <td class="thheading" colspan = 7 >  Total  </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalstdam,0," ",","); ?> </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco1,0," ",","); ?> </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($ttotalco1,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalco2,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac2,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac21,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac22,0," ",","); ?> </td>
				 
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt+$totalco1+$totalco2+$totac2+$totac21+$totac22,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($tabsent,0," ",","); ?> </td>
            </tr>
			
			<tr>
			<td   class="thheading" colspan="17" >No. of Employees :<?php echo $tcount; ?></td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</tr>
			
            <!--<tr>
                <td colspan="12"  class="thheading">Pf Admin Charges (<?php //echo "  ". $res14['acno2']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $ac=round($totalstdam*$res14['acno2']/100,0); ?></td>
            </tr>
            <tr>
                <td class="thheading" colspan="12">D.L.I.S. Contribution (<?php //echo $res14['acno21']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $dlisc=round($totalstdam*$res14['acno21']/100,0); ?></td>
            </tr>
            <tr>
                <td class="thheading" colspan="12">D.L.I.S. Admin Charges (<?php //echo $res14['acno22']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $dlisac=round($totalstdam*$res14['acno22']/100,0); ?>
            </tr> <tr>
                <td class="thheading" colspan="12"></td>
                <td class="thheading" align="center" ><?php //echo NUMBER_FORMAT( round($totalamt+$totalco1+$totalco2+$dlisac+$dlisc+$ac,2),0,".",","); ?>
            </tr>-->

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