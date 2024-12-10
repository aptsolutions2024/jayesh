<?php
session_start();
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
    $frdt=$cmonth;
    $todt=$cmonth;
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    $esifrdt=$cmonth;
	$tab_days='tran_days';
    
 }
else{

    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days='hist_days';

 }

//t1 = tran_deduct   t2= employee      t3= tran_days    t4 = tran_emp      t5=mast_client
 
 

//$sql = "SELECT t1.*,t2.*,t3.present FROM $tab_empded t1, employee t2 ,tran_days t3 where t1.emp_id=t2.emp_id  AND t3.sal_month='".$esifrdt."' AND t1.emp_id=t3.emp_id AND t2.client_id='".$clientid."' AND head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."') ";


if($emp=='Parent')
	{
	$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t1.amount>0 and  t5.parentid='".$clientid."' AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')  ";
	}
else{
$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where  t2.client_id='".$clientid."' and t1.amount>0 AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')    ";
}



if($month=='current'){
   $sql .= "   AND t1.sal_month = '$frdt' ";
}else{
	  $sql .= " AND t1.sal_month >= '$frdt' AND t1.sal_month <= '$todt' ";
	 
}

$sql .= "order by t5.esicode, t4.esino";

$res12 = mysql_query($sql);
$tcount= mysql_num_rows($res12);





if($month!=''){
    $reporttitle="ESI Statement FOR THE MONTH ".$monthtit;
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
    
		.tdtext{
            text-transform: uppercase;
			 align-content: center;
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
include('printheader.php');
?>
</div>
 
    <div class="row body" >



<?php 
$prev_esicode = "";
$cnt = 0;
while   ($row=mysql_fetch_array($res12))


{

?>

        






<?php
	if ($row['esicode'] !=$prev_esicode)
{
	  if($prev_esicode != ""){
?>		  
		              <tr>
                <td class='thheading' colspan="2">No. of Employees</td>
                <td class='thheading' align="center" ><?php //echo $tcount; 
				echo $cnt ;
				$cnt = 0;?> </td>
                <td colspan="3"></td>
                <td align="right"  class='thheading' > Total</td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $totalsamt,0," ",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalco,0," ",","); ?> </td>
            </tr>

            <tr>
                <td class='thheading' colspan="2">Total Wages :</td>
                <td class='thheading'align="center" ><?php echo $totalsamt; ?> </td>
                <td colspan="9"></td>
            </tr>
  <tr>

      <td class='thheading' colspan="2">Employees' Contri.:</td>

                <td  class='thheading'align="center"  ><?php echo $totalamt; ?> </td>
      <td class='thheading' colspan="9"></td>
            </tr>

  <tr>



      <td  class='thheading' colspan="2">Employer's Contri.:</td>
      <td class='thheading' align="center" ><?php echo $totalco; ?> </td>


      <td colspan="9"></td>

            </tr>
  <tr>

                <td class='thheading' colspan="2">Total Contri.:</td>
      <td class='thheading' align="center" ><?php echo $totalco+$totalamt; ?> </td>


      <td colspan="9"></td>

            </tr>

		  
	<?php 	  echo '<\table>';}
				
	
	$prev_esicode = $row['esicode'];
	echo "<div> <h4> ESI CODE : ". $row['esicode']."</h4></div>";
	$totalamt=0;
	$totalsamt=0;
	$totalco=0;
	$c[]='';
	$i=0;
 






	echo    "<table width='100%'>

 <tr>
        <th class='thheading' width='7%'>Employee No </th>
        <th class='thheading' width='7%'>Client No </th>
        <th class='thheading' width='7%'>ESI No </th>
        <th class='thheading' width='24%'>Name Of the Employee</th>
        <th class='thheading' width='10%'>Birthdate</th>
        <th class='thheading' width='10%'>Joindate</th>
        <th class='thheading' width='5%'>Atten.</th>
        <th class='thheading' width='10%'>Total Rs.</th>
        <th class='thheading' width='10%'>Empesi <br /> Contri.</th>
        <th class='thheading' width='10%'>Empyr's <br />Contri.</th>
    </tr>";

}	
$cnt++;
?>

    <tr>
        <td align="center" >
            <?php

            echo $row["emp_id"];
            ?>
        </td>
        <td align="center"  > <?php

            echo $row["client_name"];
            ?>

        </td>
        <td align="center" > <?php

            echo $row["esino"];
            ?>

        </td>
        <td >
            <?php

            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
            ?>
        </td>


        <td align="center"  >
            <?php
            if($row["bdate"]!='0000-00-00') {
                echo date("d-m-Y", strtotime($row["bdate"]));
            }
            ?>
        </td>
        <td align="center"  > <?php
if($row["joindate"]!='0000-00-00') {
    echo date("d-m-Y", strtotime($row["joindate"]));
}
            ?>

        </td align="center" >
        <td align="center" > <?php
            echo $row["payabledays"];
            ?>

        </td>
        <td align="center"   >
            <?php
            echo $row['std_amt'];
            $totalsamt=$totalsamt+$row['std_amt'];
            $c[$i]=$row['amount'];
            ?>
        </td>

        <td align="center"   >
            <?php
            echo NUMBER_FORMAT($row['amount'],0," ",",");
            $totalamt=$totalamt+$row['amount'];
            $c[$i]=$row['amount'];
            ?>
        </td>
        <td align="center"  >
            <?php
            echo NUMBER_FORMAT($row['employer_contri_1'],0," ",",");
            $totalco=$totalco+$row['employer_contri_1'];
            ?>
        </td>
    </tr>
            <?php
    $i++;

}


$s=array_count_values($c);

?>

            <tr>
                <td class='thheading' colspan="2">No. of Employees</td>
                <td class='thheading' align="center" ><?php echo $tcount; ?> </td>
                <td colspan="3"></td>
                <td align="right"  class='thheading' > Total</td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $totalsamt,0," ",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalco,0," ",","); ?> </td>
            </tr>

            <tr>
                <td class='thheading' colspan="2">Total Wages :</td>
                <td class='thheading'align="center" ><?php echo $totalsamt; ?> </td>
                <td colspan="9"></td>
            </tr>
  <tr>

      <td class='thheading' colspan="2">Employees' Contri.:</td>

                <td  class='thheading'align="center"  ><?php echo $totalamt; ?> </td>
      <td class='thheading' colspan="9"></td>
            </tr>

  <tr>



      <td  class='thheading' colspan="2">Employer's Contri.:</td>
      <td class='thheading' align="center" ><?php echo $totalco; ?> </td>


      <td colspan="9"></td>

            </tr>
  <tr>

                <td class='thheading' colspan="2">Total Contri.:</td>
      <td class='thheading' align="center" ><?php echo $totalco+$totalamt; ?> </td>


      <td colspan="9"></td>

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