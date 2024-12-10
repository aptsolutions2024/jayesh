<?php
session_start();
error_reporting(0);
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
 	$sql = "select distinct esicode,mast_client_id from mast_client where comp_id = '$comp_id' and esicode!= '.' order by esicode,mast_client_id";	}
else{
	$sql = "select distinct esicode,mast_client_id from mast_client where mast_client_id = '$clientid' and esicode!= '.' order by esicode";	
}
$res_code = mysql_query($sql);
$tcount= mysql_num_rows($res_code);










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

        .page-bk_before {
            position: relative;

            /*display: block;*/
			page-bk_before:auto;
            z-index: 0;

        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:10px !important;
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
@page {
   
				margin: 27mm 16mm 27mm 16mm;
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
 
    <div class="row body page" >



<?php 
$prev_esicode = "";
$cnt = 0;

while   ($rowcode=mysql_fetch_array($res_code))
	{
 
		if($prev_esicode == ""){$prev_esicode =$rowcode['esicode'];
		} 
 
		if ($prev_esicode !=$rowcode['esicode']){
			
			
					if ($tcount>0){
					echo    "<div class = 'page-bk'> <table width='100%'>";
					echo "<div align='centre'!important > <h5> ESI STATEMENT FOR  : ". $prev_esicode ."<BR> MONTH : ".$monthtit. "</h5></div>";
	           
					echo "			<tr>
							<th class='thheading' width='3%'>Emp. ID </th>
							<th class='thheading' width='3%'>Clnt No </th>
					<th class='thheading' width='7%'>ESI No </th>
					<th class='thheading' width='28%'>Name Of the Employee</th>
					<th class='thheading' width='9%'>Birthdate</th>
					<th class='thheading' width='9%'>Joindate</th>
					<th class='thheading' width='3%'>Atten.</th>
					<th class='thheading' width='7%'>Total Rs.</th>
					<th class='thheading' width='7%'>Empesi <br /> Contri.</th>
					<th class='thheading' width='5%'>Emyr's <br />Contri.</th>
				</tr>";?>
					<tr>
							<td class='thheading' colspan="2">No. of Employees</td>
							<td class='thheading' align="center" ><?php echo $totalempcnt; ?> </td>
							<td colspan="2"></td>
							<td align="right"  class='thheading' > Total</td>
							<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $tot_attend,2,".",","); ?> </td>
							<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $totalsamt,2,".",","); ?> </td>
							<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalamt,2,".",","); ?> </td>
							<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalco,2,".",","); ?> </td>
						</tr>


			</table></div>
				 
				 
				 
					<?php }
					$totalempcnt = 0;
					$totalamt=0;
				$totalsamt=0;
				$totalco=0;
				$tot_attend = 0;
				$prev_esicode =$rowcode['esicode'];
				
		}
		if($emp=='Parent')
		{ //$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$rowcode['esicode']."' and t1.amount>0 and  t5.mast_client_id='".$rowcode['mast_client_id']."' AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')  ";
	
	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$rowcode['esicode']."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')  ";
	
		}
		else{
			//$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$rowcode['esicode']."' and t1.amount>0 and  t5.mast_client_id='".$clientid."' AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."') ";
		
		$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$rowcode['esicode']."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."') ";
		
		}	


			if($month=='current'){
				$sql .= "   AND t1.sal_month = '$frdt' ";
					}else{
				$sql .= " AND t1.sal_month >= '$frdt' AND t1.sal_month <= '$todt' ";
					
			}
			 $sql .= "order by t5.esicode,client_id, t4.esino";
			
			$res12 = mysql_query($sql);
			$row1 = mysql_query($sql);
			$row11=mysql_fetch_array($row1);
			$tcount= mysql_num_rows($res12);



				
		
			$i=0;

		if ($tcount > 0){		 
			$tot_cl_attend = 0;
			$total_cl_amt = 0;
			$total_cl_samt=0;
			$total_cl_co = 0;
			$tot_cl_empcnt = 0;
			
			echo    " <div class = 'page-bk' ><table width='100%'>";
		
			echo "<div align='centre'!important > <h5> ESI STATEMENT FOR  : ". $rowcode['esicode']."<BR> MONTH : ".$monthtit."<br> Client : ".$row11['client_name']. "</h5></div>";
	echo "
			<tr>
				<th class='thheading' width='3%'>Emp. ID </th>
				<th class='thheading' width='3%'>Clnt No </th>
				<th class='thheading' width='7%'>ESI No </th>
				<th class='thheading' width='28%'>Name Of the Employee</th>
				<th class='thheading' width='9%'>Birthdate</th>
				<th class='thheading' width='9%'>Joindate</th>
				<th class='thheading' width='3%'>Atten.</th>
				<th class='thheading' width='7%'>Total Rs.</th>
				<th class='thheading' width='7%'>Empesi <br /> Contri.</th>
				<th class='thheading' width='5%'>Emyr's <br />Contri.</th>
			</tr>";

			
			

			while   ($row=mysql_fetch_array($res12)){$cnt++;
				?>			

				<tr>
					<td align="center" >
						<?php

						echo $row["emp_id"];
						$tot_cl_empcnt++;
						$totalempcnt ++;
						?>
					</td>
					<td align="center"  > <?php

						echo $row["client_id"];
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
						$tot_attend += $row["payabledays"];
						$tot_cl_attend += $row["payabledays"];
						?>

					</td>
					<td align="center"   >
						<?php
						echo $row['std_amt'];
						$totalsamt=$totalsamt+$row['std_amt'];
						$total_cl_samt=$total_cl_samt+$row['std_amt'];
						//$c[$i]=$row['amount'];
						?>
					</td>

					<td align="center"   >
						<?php
						echo NUMBER_FORMAT($row['amount'],0,".",",");
						$totalamt=$totalamt+$row['amount'];
						$total_cl_amt=$total_cl_amt+$row['amount'];
						//$c[$i]=$row['amount'];
						?>
					</td>
					<td align="center"  >
						<?php
						echo NUMBER_FORMAT($row['employer_contri_1'],2,".",",");
						$totalco=$totalco+$row['employer_contri_1'];
						$total_cl_co=$total_cl_co+$row['employer_contri_1'];
						?>
					</td>
				</tr>
						<?php
				$i++;
			}
		
?>
	   <tr>
			<td class='thheading' colspan="2">No. of Employees</td>
			<td class='thheading' align="center" ><?php echo $tot_cl_empcnt; ?> </td>
			<td colspan="2"></td>
			<td align="right"  class='thheading' > Client Total</td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $tot_cl_attend,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $total_cl_samt,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($total_cl_amt,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($total_cl_co,2,".",","); ?> </td>
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
		</table> </div>
	<?php }
	}
	
	
    echo    "<table width='100%'>

	<tr>
        <th class='thheading' width='3%'>Emp. ID </th>
        <th class='thheading' width='3%'>Clnt No </th>
        <th class='thheading' width='7%'>ESI No </th>
        <th class='thheading' width='28%'>Name Of the Employee</th>
        <th class='thheading' width='9%'>Birthdate</th>
        <th class='thheading' width='9%'>Joindate</th>
        <th class='thheading' width='3%'>Atten.</th>
        <th class='thheading' width='7%'>Total Rs.</th>
        <th class='thheading' width='7%'>Empesi <br /> Contri.</th>
        <th class='thheading' width='5%'>Emyr's <br />Contri.</th>
    </tr>";?>
        <tr>
                <td class='thheading' colspan="2">No. of Employees</td>
                <td class='thheading' align="center" ><?php echo $tcount; ?> </td>
                <td colspan="2"></td>
                <td align="right"  class='thheading' > Total</td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $tot_attend,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $totalsamt,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalamt,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalco,2,".",","); ?> </td>
            </tr>


</table></div>
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