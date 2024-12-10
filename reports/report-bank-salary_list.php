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
$userObj=new user();
include("../lib/class/admin-class.php");
$adminObj=new admin();

if($month=='current'){
	$resclt=$userObj->displayClient($clintid);
	$cmonth=$resclt['current_month'];
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
    $todt = $frdt;  	
 }

if($emp=='Parent')
   { 	 	$sql = "SELECT te.emp_id,te.netsalary,e.first_name,e.middle_name,e.last_name,mb.bank_name,mb.branch,mb.ifsc_code,te.bankacno FROM $tab_emp  te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on e.bank_id =mb.mast_bank_id inner join mast_client mc on te.client_id = mc.mast_client_id   WHERE mc. parentid = '".$clintid. "' and te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.sal_month >= '$frdt' AND te.sal_month <= '$todt'  order by e.first_name,e.middle_name,e.last_name";

   }
else{ 
		$sql = "SELECT te.emp_id,te.netsalary,e.first_name,e.middle_name,e.last_name,mb.bank_name,mb.branch,mb.ifsc_code,te.bankacno FROM $tab_emp  te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on e.bank_id =mb.mast_bank_id   inner join mast_client mc on te.client_id = mc.mast_client_id   WHERE mc.mast_client_id = '".$clintid. "' and  te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.sal_month >= '$frdt' AND te.sal_month <= '$todt'  order by e.first_name,e.middle_name,e.last_name";
}	
$res = mysql_query($sql);
$tcount= mysql_num_rows($res);



if($month!=''){
    $reporttitle="BANK LIST FOR THE MONTH ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}

$_SESSION['client_name']=$resclt['client_name'].$p;

$_SESSION['reporttitle']=strtoupper($reporttitle)
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
include('printheader.php');
?>
</div>


    <div class="row body" >







        <table width="100%">







    <tr>
        <th class="thheading" width="5%">SR.NO.      </th>
        <th class="thheading" width="32">NAME OF THE EMPLOYEE </th>
        <th class="thheading" width="33%">BANK DETAILS</th>
        <th class="thheading" width="15%">BANK ACNO </th>
        <th class="thheading" width="15%">NETSALARY Rs. </th>
    </tr>

<?php
$totnetsalary=0;
$srno=1;
while($row=mysql_fetch_array($res)){
    ?>
    <tr>
        <td align="center" >
            <?php
            echo $srno;
      ?>
        </td>

        <td >
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
       ?>
        </td>
        <td align="center" >
            <?php

                     echo $row["bank_name"].', '.$row['branch']. '  '.$row['ifsc_code'];
            ?>
        </td>

        <td align="center" >
            <?php
            echo $row['bankacno'];
            ?>
        </td>       
		<td align="center" >
            <?php
            echo $row['netsalary'];
            ?>
        </td>
    </tr>
            <?php
    $srno++;
	$totnetsalary =$totnetsalary+$row['netsalary'];

}

?>
<tr>
<td class="thheading" colspan=4 align = "right"> Total</td>
<td class="thheading" colspan=4 align = "center"> <?php echo number_format($totnetsalary,2,".",",");?></td>

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


</body></html>