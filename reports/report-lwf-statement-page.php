<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
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
	$frdt =$userObj->getLastDay($cmonth);
	
  }
// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee t5= tran_days
  $res12 = $userObj->getreportLwfStatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt);



$tcount= mysqli_num_rows($res12);



if($month!=''){
    $reporttitle="L.W.F. Statement FOR ".$monthtit;
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
include('printheader.php');
?>
</div>


    <div class="row body page " >
        <table width="100%">
    <tr>
        <th class="thheading" width="7%">SR. NO.</th>
        <th class="thheading" width="10%">Emp. ID </th>
        <th class="thheading" colspan="3">Name Of the Employee </th>
        <th class="thheading" width="10%">Employee's Contribution</th>
        <th class="thheading" width="10%">Employer's Contribution</th>
        <th class="thheading" width="10%">Total</th>
    </tr>

<?php
$totalamt=0;
$totalco1=0;
$totalco2=0;

$ttotalco1=0;


$ttotalco2=0;
$totalco2=0;
$totalstdam=0;
$tabsent = 0;
$c[]='';
$amount= 0;
$i=0;
while($row=$res12->fetch_assoc()){
    $total1=0;
	$i++;
    ?>
    <tr>
        <td align="center" >           <?php  echo $i;?>        </td>
        <td align="center" >           <?php  echo $row["emp_id"];?>        </td>
        <td colspan="3"> <?php echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];?></td>
		<td align="center" > <?php  echo NUMBER_FORMAT($row['amount'],0," ",",");
									$totalamt=$totalamt+$row['amount'];
								?> </td>
        <td align="center" > <?php  echo NUMBER_FORMAT($row['employer_contri_1'],0," ",",");
									$totalco1=$totalco1+$row['employer_contri_1'];
								?>  </td>
        <td align="center" > <?php  echo NUMBER_FORMAT($row['employer_contri_1']+$row['amount'],0," ",",");
									$totalco2=$totalco2+$row['employer_contri_1']+$row['amount'];
								?>  </td>
 </tr>
            <?php
}
?>

            <tr>
                
				<td></td>
				<td></td>
                <td class="thheading"  colspan="3" >  Total  </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco1,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco2,0," ",","); ?> </td>
            </tr>
			
			<tr>
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