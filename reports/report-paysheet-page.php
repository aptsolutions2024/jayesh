<?php
session_start();

error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
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
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
 }


  $sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
if($emp!='all'){
    $empid=$_REQUEST['empid'];
    $sql .= " AND emp_id=".$empid;
}

$res = mysql_query($sql);
$tcount= mysql_num_rows($res);
if($month!=''){
$reporttitle="PAYSHEET FOR THE MONTH ".$monthtit;
}
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;

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

<?php
$count=1;
$per=2;
while($row=mysql_fetch_array($res)){
    $empid=$row['emp_id'];
    $emprows=$userObj1->showtranhiEployeedetails($tab_emp,$empid);
    $emprows1=$userObj1->showEployeedetails($empid,$comp_id,$user_id);
    $desrows=$userObj1->displayDesignation($emprows1['desg_id']);
    $bankrows=$userObj1->displayBank($emprows1['bank_id']);

  $tempc=$count%$per;
    ?>


<div <?php
     if($tcount>$count && $tempc!=1 ){

         ?>class="page-bk"<?php } ?>>
<div class="header_bg">

<?php
if($tcount>$count && $tempc!=0 ) {
    include('printheader.php');
}
?>
</div>


    <div class="row body"  >

            <table style="margin-bottom: 10px;" width="100%" >

                <tr>
                    <td width="15%">Emp Id :</td> <td colspan="2"><?php echo $row['emp_id']; ?></td>
                    <td width="15%" colspan="2">Emp.Name :</td> <td colspan="5"> <?php echo $emprows1['first_name'].' '.$emprows1['middle_name'].' '.$emprows1['last_name']; ?></td>

                </tr>
                <tr>
                    <td>PF.NO :</td>
                    <td colspan="2"><?php echo $emprows1['pfno']; ?></td>
                    <td colspan="2">DESG :</td>
                    <td colspan="5"> <?php

                        echo $desrows['name'];
                        ?>
                    </td>

                </tr>
                <tr>
                    <td>UAN :</td>
                    <td colspan="2"><?php echo $emprows1['uan']; ?></td>
                    <td colspan="2">Bank A/c No :</td>
                    <td colspan="5"> <?php echo  $emprows["bankacno"].' - '.$bankrows['branch']; ?></td>

                </tr>
                <tr>
                    <td>ESI NO :</td>
                    <td colspan="2"><?php echo $emprows['esino']; ?></td>
                    <td colspan="2"> </td>
                    <td colspan="5"> </td>
                </tr>


                </table>            <table width="100%" >


    <tr>

        <td width="7%"></td>
        <td width="5%"> </td>
        <td width="20%"></td>
        <td width="7%">STD PAY</td>
        <td width="5%">EARNINGS</td>
        <td width="10%"> </td>
        <td width="5%">Salary</td>

        <td width="4%">Amount</td>
        <td width="10%">Emp Confi 1</td>
        <td width="10%">Emp Confi 2</td>
    </tr>


   <tr>

       <?php

       $tran_day_emp_id = $row['emp_id'];

 // $sql = "select ti.*,mi.income_heads_name from tran_income ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  where mi.comp_id = '$comp_id'  and ti.emp_id = '".$tran_day_emp_id."' and ti.sal_month = '".$resclt['current_month']."' order by mi.mast_income_heads_id";
 $sql = "select ti.*,mi.income_heads_name from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  where mi.comp_id = '$comp_id'  and ti.emp_id = '".$tran_day_emp_id."' and  ti.sal_month >= '$frdt' AND ti.sal_month <= '$todt'  ";


       $sql .= " order by mi.mast_income_heads_id";
$row1 = mysql_query($sql);
$i = 1;
$gr_sal = 0;
while($row_inc =mysql_fetch_assoc($row1)){
    $arr_inc_name[$i] = $row_inc['income_heads_name'];
    if($row_inc['std_amt'] > 0){
        $arr_inc_std[$i] = $row_inc['std_amt'];
		if($row_inc['income_heads_name']!= "OVERTIME")
		{
		$gr_sal = $gr_sal +$row_inc['std_amt'];
		}
    }else{
        $arr_inc_std[$i] = ' ';
    }
    if($row_inc['amount'] > 0 ){
        $arr_inc_amt[$i] = $row_inc['amount'];
    }else{
        $arr_inc_amt[$i]  = ' ';
    }

	   $i++;
}
      $arr_inc_name[$i]='Gross Salary';

       $arr_inc_std[$i] = $gr_sal;
      $arr_inc_amt[$i]=$emprows['gross_salary'];


//$sql = "select tdd.*,mi.deduct_head_name from tran_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.head_id  where md.comp_id = '$comp_id'  and tdd.emp_id = '".$tran_day_emp_id."' and tdd.sal_month = '".$resclt['current_month']."' order by md.head_id";
 $sql = "select tdd.*,md.deduct_heads_name from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id where md.comp_id = '$comp_id'  and tdd.emp_id = '".$tran_day_emp_id."' and  tdd.sal_month >= '$frdt' AND tdd.sal_month <= '$todt'   order by md.mast_deduct_heads_id";
$row1 = mysql_query($sql);
$j = 1;
while($row_ded =mysql_fetch_assoc($row1)){
    $arr_ded_name[$j] = $row_ded['deduct_heads_name'];

    if($row_ded['amount'] > 0){
        $arr_ded_amt[$j] = $row_ded['amount'];
        $arr_ded_std_amt[$j] = $row_ded['std_amt'];
        $arr_ded_emp_contri1_amt[$j] = $row_ded['employer_contri_1'];
        $arr_ded_emp_contri2_amt[$j] = $row_ded['employer_contri_2'];
    }else{
        $arr_ded_amt[$j]  = ' ';
    }

	   $j++;
}
    
//  if($j>1) {
      $arr_ded_name[$j] = 'Total Deduct.';
      $arr_ded_amt[$j] = $emprows['tot_deduct'];
//  }
 $sql = "select `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts` from tran_days where emp_id='$empid'";
$row1 = $row= mysql_query($sql);

$k = 1;


       while($row_days=mysql_fetch_assoc($row1)){
               if($row_days['present'] > 0) {
                   $arr_days_name[$k] = "Present Days";
                   $arr_days_value[$k] = $row_days['present'];
                   $k++;
               }
               if($row_days['absent'] > 0) {
                   $arr_days_name[$k] = "Absent Days";
                   $arr_days_value[$k] = $row_days['absent'];
                   $k++;
               }
               if($row_days['weeklyoff'] > 0) {
                   $arr_days_name[$k] = "Weekly Off";
                   $arr_days_value[$k] = $row_days['weeklyoff'];
                   $k++;
               }
               if($row_days['pl'] > 0) {
                   $arr_days_name[$k] = "Paid Leave";
                   $arr_days_value[$k] = $row_days['pl'];
                   $k++;
               }
               if($row_days['sl'] > 0) {
                   $arr_days_name[$k] = "Sick Leave Days";
                   $arr_days_value[$k] = $row_days['sl'];
                   $k++;
               }
               if ($row_days['cl'] > 0) {
                   $arr_days_name[$k] = "Cacual Leave";
                   $arr_days_value[$k] = $row_days['cl'];
                   $k++;
               }
               if($row_days['otherleave'] > 0) {
                   $arr_days_name[$k] = "Other Leave";
                   $arr_days_value[$k] = $row_days['otherleave'];
                   $k++;
               }
               if($row_days['paidholiday'] > 0) {
                   $arr_days_name[$k] = "Paid Holiday";
                   $arr_days_value[$k] = $row_days['paidholiday'];
                   $k++;
               }
               if($row_days['additional'] > 0) {
                   $arr_days_name[$k] = "Additional Days";
                   $arr_days_value[$k] = $row_days['additional'];
                   $k++;
               }
               if($row_days['othours'] > 0) {
                   $arr_days_name[$k] = "Overtime Hours";
                   $arr_days_value[$k] = $row_days['othours'];
                   $k++;
               }
               if($row_days['nightshifts'] > 0) {
                   $arr_days_name[$k] = "Night Shifts";
                   $arr_days_value[$k] = $row_days['nightshifts'];
                   $k++;
               }
//           if($emprows['payabledays'] > 0) {
                   $arr_days_name[$k] = "Payable Days";
                   $arr_days_value[$k] = $emprows['payabledays'];

//               }
       }


		if($i>=$j)
        {$maxrows = $i;}
        else
        {$maxrows = $j;}

		if ($maxrows>=$k)
        {}
        else
        {$maxrows = $k;}

		for($l=1;$maxrows>=$l;$l++){
            echo "<tr>";
            if ($l <= $k){
             echo "<td>". $arr_days_name[$l]."</td>
				<td>".$arr_days_value[$l]."</td>";
				}
            else
            {
                echo "<td> </td>
				<td> </td>";
				}

            if ($l <= $i){         //checking array subscript
                echo "<td>".$arr_inc_name[$l]."</td>
              <td>  ".$arr_inc_std[$l]."</td>
				<td>".$arr_inc_amt[$l]."</td>";
				}
            else
            {
                echo "<td></td>
				<td></td>
				<td></td>";
				}

            if ($l <= $k){         //checking array subscript

                echo "<td>".$arr_ded_name[$l]."</td>
				<td>". $arr_ded_std_amt[$l]."</td>
				<td>". $arr_ded_amt[$l]."</td>
				<td>". $arr_ded_emp_contri1_amt[$l]."</td>
				<td>". $arr_ded_emp_contri2_amt[$l]."</td>";
				}
            else
            {
                echo "<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>";
				}

            echo "</tr>";
        }






       ?>
    </tr>
       <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>

           <td  class='thheading' colspan="2">NET SALARY Rs.</td>
           <td class='thheading'><?php echo $emprows['netsalary']; ?></td>

       </tr>

</table>


        </div>

    </div>
<?php
    $count++;
} ?>
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>