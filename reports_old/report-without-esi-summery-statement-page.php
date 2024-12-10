<?php
session_start();
error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
//$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();

//include("../lib/class/common.php");
//$common=new common();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$mon = $_REQUEST['mon'];
$frdt = $_REQUEST['frdt'];
$todt = $_REQUEST['todt'];
if($mon =='current'){
 $cmonth=$resclt['current_month'];
 $frdt =$resclt['current_month'];
 
 //$tab_days='tran_days';
    $tab_emp='tran_employee';
    //$tab_empinc='tran_income';
    $tab_empded='tran_deduct';
	//$tab_adv='tran_advance';
}else{
    $monthtit =  date('F Y',strtotime($frdt));
    //$tab_days='hist_days';
    $tab_emp='hist_employee';
    //$tab_empinc='hist_income';
    $tab_empded='hist_deduct';
	//$tab_adv='hist_advance';

	
 }
$frdt = date('Y-m-d',strtotime($frdt));
$todt = date('Y-m-d',strtotime($todt));
//print_r($_REQUEST);

//$getclient = $userObj->showClient1($comp_id,$user_id);
//t1 = tran_deduct   t2= employee      t3= tran_days    t4 = tran_emp      t5=mast_client)
$res =$userObj->getEsiWithoutEsiSummeryStatement($tab_emp,$comp_id,$tab_empded,$frdt);
  /*$sql = "select td.sal_month,c.client_name,c.mast_client_id,c.client_name,td.emp_id,  e.first_name,e.middle_name,e.last_name,td.gross_salary from $tab_emp td inner join employee e on td.emp_id = e.emp_id inner join mast_client c on td.client_id = c.mast_client_id where  td.sal_month = '$frdt' and td.netsalary >0 and  td.comp_id= '$comp_id'   and td.emp_id not in (select emp_id from $tab_empded where sal_month = '$frdt' and amount>0 and head_id in (select md.mast_deduct_heads_id from mast_deduct_heads md where md.deduct_heads_name like '%E.S.I.%'and  comp_id= '$comp_id'  ) ) order by td.sal_month,td.client_id,td.emp_id";
		 $res = mysql_query($sql);*/
//$getdetails1 = $common->getAllEmployeeForESI($comp_id,$mon,$frdt,$todt);
 //print_r($getdetails);

if($month!=''){
    $reporttitle="Without ESI Summery Statement FOR THE MONTH ".$monthtit;
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

<div>
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
 
    <div class="row body" >

<table width='90%'>

 <tr>	<th class='thheading' width='7%'>Sr. No.</th>
        <th class='thheading' width='5%'>Salary Month</th>
        <th class='thheading' width='5%'>Client Id </th>
        <th class='thheading' width='7%'>Emp Id </th>
        <th class='thheading' width='25%'>Name of The Employee</th>
        <th class='thheading' width='5%'>Gross Salary</th>
		 <th class='thheading' width='18%'>Client</th>
		
        
    </tr>

<?php 
//foreach($getdetails1 as $client){
	$sr=1;
while($client = $res->fetch_assoc()){ 
  ?>
 <tr><td><?php echo $sr;?></td>
        <td ><?php echo date('M Y',strtotime($client['sal_month']));?> </td>
        <td ><?php echo $client['mast_client_id'];?>  </td>
        <td ><?php echo $client['emp_id'];?>  </td>
        <td ><?php echo $client['first_name']." ".$client['middle_name']." ".$client['last_name'];?> </td>
        <td ><?php echo $client['gross_salary'];?> </td>
        <td ><?php echo $client['client_name'];?> </td>
    </tr>
<?php $sr++;} ?> 
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