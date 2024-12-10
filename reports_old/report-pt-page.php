<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
//error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
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

$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{

    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
 }
 
 
$sql = "SELECT * FROM $tab_empded where head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id ='".$comp_id."') ";


// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee
  $res12 =$userObj->getReportPt($clintid,$comp_id,$emp,$tab_empded,$month,$frdt,$todt);

$tcount= mysqli_num_rows($res12);



if($month!=''){
    $reporttitle="Profession Tax FOR THE MONTH ".$monthtit;
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
<!-- header starts -->


<!-- header end -->

<!-- content starts -->




<div>
<div >
<?php
include('printheader3.php');
?>
</div>
    <div class="row body" >
        <table width="100%">
    <tr>

        <th  align="left" colspan="5" width="80%" class="thheading">Name Of the Employee</th>
        <th width="10%" class="thheading" >Amount</th>

    </tr>

<?php
$totalamt=0;
$totalco=0;
$c[]='';
$i=0;
while($row=$res12->fetch_assoc()){
    ?>
    <tr>
        <td colspan="5">
            <?php
            $emp=$userObj->showEployeedetails($row['emp_id'],$comp_id,$user_id);
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
            ?>
        </td>
        <td align="center" >
            <?php
            echo $row['amount'];
            $totalamt=$totalamt+$row['amount'];
            $c[$i]=$row['amount'];
            ?>
        </td>
    </tr>
            <?php
    $i++;
}
$s=array_count_values($c);
?>
            <tr>
                <td width="15%" class="thheading">No. of Employees</td>
                <td  width="5%" class="thheading"><?php echo $tcount; ?> </td>
                <td  width="50%" colspan="2"></td>
                <td  width="10%" align="right" class="thheading">Total</td>
                <td  width="10%" class="thheading" align="center"><?php echo $totalamt; ?> </td>
            </tr>

</table>
        <table width="100%">
            <tr>
                <?php
                if(is_array($s)){
                    foreach($s as $k=>$value) {
                        echo "<td width='10%' class='thheading'>Rate Rs.</td><td width='10%' class='thheading'>". $k ."</td>" ;  // $k is the key
                        echo "<td width='10%' class='thheading'>No.of Emp.</td><td width='10%' class='thheading'>". $s[$k] ."</td>" ;  // $k is the key

                    }
                }  ?>
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