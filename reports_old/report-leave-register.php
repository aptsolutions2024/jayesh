<?php
session_start();
error_reporting(0);
$month=$_SESSION['month'];
$client_id=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);

$sql="SELECT leave_details.from_date,leave_details.to_date  FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$_REQUEST['frdt1']."' order by employee.emp_id ";
	$res = mysql_query($sql) ;
	$row = mysql_fetch_array($res);

   $monthtit =  date('d-m-Y',strtotime($row['from_date'])) ." TO ".date('d-m-Y',strtotime($row['to_date']));
	$frdt=date("Y-m-d", strtotime($_REQUEST['frdt1']));
    $todt=date("Y-m-d", strtotime($_REQUEST['todt1']));


/*if($month=='current'){
 $sql .= " AND t1.sal_month='".$frdt."' ";}
else{
  $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
}

$sql.=" order by t1.head_id,t2.first_name,t2.middle_name,t2.last_name ";
*/



if($month!=''){
    $reporttitle="LEAVE PAYMENT PERIOD : ".$monthtit;
	//$reportdate="Date: ".$payment_date;
}
$p='';

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
	    .message {
              color: #FF0000;
              text-align: center;
              width: 100%;
            }

	  
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
            border: 1px solid black!important;
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
            .body { padding: 10px;
			}
            body{
                margin-left: 50px;
            }
			
			@page {
   
				margin: 27mm 16mm 27mm 16mm;
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




<div class="page">
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>

<br><br><br>
    <div class="row body" >
 
	<table width="100%">
	<?php 
echo "<tr rowspan = 2> <td colspan ='13' align ='center'> <b>Payment Date : ".date('d-m-Y',strtotime($frdt))."</b></td></tr>"; ?> 
    <tr>
	    <th class="thheading" >SR. No.</th>
	    <th class="thheading" >EMP. ID</th>
        <th class="thheading" colspan="3">NAME OF THE EMPLOYEE
        </th>
        <th class="thheading" colspan="2">JN.DATE</th>
		<th class="thheading" colspan="2">LEFT DATE</th>
        <th class="thheading" >LEAVE</th>
        <th class="thheading" >RATE Rs.</th>
        <th class="thheading" >AMOUNT Rs.</th>
     	<th class="thheading" >CHEQUE NO.</th>
    </tr>

<?php
$totalamt=0;
$totalleave=0;
$rate=0;

/*$ttotalco2=0;
$totalco2=0;
$totalstdam=0;*/
$c[]='';
$i=1;
 
      /* echo $payment_date;
       echo $client_id;
	   */

 $sql="SELECT distinct payment_date from leave_details WHERE client_id= '".$client_id."' AND leave_details.payment_date>='".$frdt."' and  payment_date<='".$todt."'";
$resdate = mysql_query($sql);
if(mysql_affected_rows()==0)
	{echo '<div class="message">Record Not Found</div><br>';
		exit;
	}
	$totamt = 0;
	$totcnt = 0;
	
	
while ($row1= mysql_fetch_array($resdate)){
	   
	$sql="SELECT leave_details.emp_id,leave_details.client_id,leave_details.payment_date,leave_details.encashed,leave_details.rate,leave_details.amount,employee.emp_id,employee.client_id,employee.first_name,employee.middle_name,employee.last_name,employee.joindate,employee.leftdate FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$row1['payment_date']."' order by employee.emp_id ";
	$res = mysql_query($sql) or die(mysql_error());

	if(mysql_affected_rows()==0)
		{  echo '<div class="message">Record Not Found</div><br>';
		}
	$dateamt =0;
	$srno =0;
	while($row = mysql_fetch_array($res)){
	
?>
	
	
    <tr>
	
        <td align="center" >
            <?php $srno++;
			$totcnt++;
            echo $srno;
            ?>
        </td>
        <td align="center" >
            <?php
            echo $row['emp_id'];
            ?>
        </td>

        <td colspan="3" align="left">
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
       ?>
        </td>
        <td colspan="2" align="center">
            <?php
                echo date("d-m-Y",strtotime($row['joindate']));
            ?>
        </td>
        <td colspan="2" align="center">
            <?php
			    if ($row['leftdate']!='0000-00-00' && $row['leftdate']!='1970-01-01')
					{echo date('d-m-Y',strtotime($row['leftdate']));}
				else
					{echo "-";}	
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['encashed'];
            ?>
        </td>       
		<td align="right" >
            <?php
            echo number_format($row['rate'],2,".",",");
            ?>
        </td>
        <td align="right" >
            <?php
            echo number_format($row['amount'],2,".",",");
			$dateamt+=$row['amount'];
			$totalamt+=$row['amount'];
			?>
	     </td>
<!--		<td align="center" >
            <?php
            echo $row['payment_date'];
            ?>
        </td> -->
		<td align="center" >
            
        </td>

	</tr>
             <?php
               }
			  

?>
<!--<tr rowspan = 2><td colspan=11 align='right'>Date Total </td><td align="right"> <?php echo number_format($dateamt,2,".",",");?> </td><td></td></tr> -->
<?php }?>
<td colspan=11  align='right'>Grand Total</td><td align="right"> <?php echo number_format($totalamt,2,".",",");?> </td><td></td></tr>
 
 
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