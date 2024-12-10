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
$result1 = $userObj->showClient1($comp_id,$user_id);
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
	
	/*$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];*/
	$frdt = $userObj->getLastDay($frdt);
	
  }
// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee t5= tran_days
  


if($month!=''){
    $reporttitle="L.W.F. Summary FOR ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}
//$_SESSION['client_name']=$resclt['client_name'].$p;
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

            display: block;
            page-break-after: always;
            z-index: 0;

        }

      
        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:13px !important;
            font-family: monospace;

        }
		table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}
		
		div{padding-right: 20px!important;padding-left: 20px!important;
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
					height:50px;
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 70px;
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

                display:block!important;

            }
            #footer {
			
                display:block!important;
            }

        }

		@page {
   
				margin: 27mm 16mm 27mm 16mm;
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


    <div class="row body page " >
        <table width="100%">
    <tr>
        <th class="thheading" width="7%">Sr. No.</th>
        <th class="thheading" width="10%">Client Id </th>
        <th class="thheading" >Name of the Client </th>
		<th class="thheading" >Amount Rs. </th>
        <th class="thheading" >Total Employees </th>
        <th class="thheading" width="10%">Employee's Contribution</th>
        <th class="thheading" width="10%">Employer's Contribution</th>
        <th class="thheading" width="10%">Total</th>
    </tr>

<?php
$totalco3=0;
$totalco1=0;
$totalco2=0;
$totalco4=0;
$c[]='';
$amount= 0;
$i=0;

  while($row1=$result1->fetch_assoc()){  if ($row1['mast_client_id']==21 or $row1['mast_client_id'] == 22)
	{$row1=$result1->fetch_assoc();}
?>    <tr>
        <td align="right" >           <?php  echo $i;?>        </td>
        <td align="right" >           <?php  echo $row1["mast_client_id"];?>        </td>
        <td > <?php echo $row1["client_name"];?></td>
		<td > </td> <td > </td><td > </td><td > </td><td > </td>
		</tr>
<?php 
 
$res12 =$userObj->getReportLWFSummery($tab_empded,$tab_emp,$frdt,$row1['mast_client_id'],$comp_id);	

$ctotalco3=0;
$ctotalco1=0;
$ctotalco2=0;
$ctotalco4=0;

 while ($res121= $res12->fetch_assoc()){
?>
       <tr><td > </td><td > </td><td > </td>
	   <td align="right" >           <?php  echo $res121['amount'];?>        </td>
			<td align="right" >           <?php  echo $res121['cnt'];?>        </td>
		    <td align="right" >           <?php  echo number_format($res121['amount1'],2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($res121['employer_contri_1'],2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($res121['amount1']+$res121['employer_contri_1'],2,".",",");?>        </td></tr>
 <?php
$ctotalco1+=$res121["cnt"];
$ctotalco2+=$res121["amount1"];
$ctotalco3+=$res121["employer_contri_1"];
$ctotalco4+=$res121["amount1"]+$res121["employer_contri_1"];

 }?>
       <tr> </td><td > </td><td > </td><td > </td>
	   <td align="right"  >   Total        </td>
			<td align="right" >           <?php  echo  number_format($ctotalco1,0,".",",");?>        </td>
		    <td align="right" >           <?php  echo  number_format($ctotalco2,2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($ctotalco3,2,".",",");?>        </td>
			 <td align="right" >           <?php  echo  number_format($ctotalco4,2,".",",");?>        </td></tr>
 <?php 
$totalco3+=$ctotalco3;
$totalco1+=$ctotalco1;
$totalco2+=$ctotalco2;
$totalco4+=$ctotalco4;
 }
  
 ?>
       <tr><td > </td><td > </td><td > </td>
	   <td align="right"  >  Grand Total        </td>
			<td align="right" >           <?php  echo number_format($totalco1,0,".",",");?>        </td>
		    <td align="right" >           <?php  echo number_format($totalco2,2,".",",");?>        </td>
	        <td align="right" >           <?php  echo number_format($totalco3,2,".",",");?>        </td>
			<td align="right" >           <?php  echo number_format($totalco4,2,".",",");?>        </td>
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