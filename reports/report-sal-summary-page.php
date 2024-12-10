<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
error_reporting(0);
setlocale(LC_MONETARY, 'en_IN');
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
//$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
$client_name = $resclt['client_name'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
	$tab_adv='tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';
	$tab_adv='hist_advance';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
	/*$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];*/
	$frdt = $userObj->getLastDay($frdt);
	
 }



/*if($emp=='Parent')
	{if ($advtype ==0)
		{
		$sql = "SELECT t1.emp_advance_id,t1.std_amt,t1.paid_amt,sum(t1.amount) as amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.parentId = '".$clientid."'  and t2.comp_id ='".$comp_id."'  ";
		 
	 }
	 else{
	echo 	$sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,sum(t1.amount as amount ),t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.clientid = '".$clientid."' and t1.head_id = '".$advtype."'  t2.comp_id ='".$comp_id."'  ";
	}
}*/






 
$res = $userObj->getReportSalTranDays($tab_days,$comp_id,$user_id,$frdt,$todt);

/*$sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' "; 


if($month=='current'){
 // $sql .= "   AND sal_month = '$frdt' ";
}else{
	 $sql .= " AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
}







$res = mysql_query($sql);*/
$tcount= mysqli_num_rows($res);



if($month!=''){
    $reporttitle="SALARY SUMMARY FOR THE MONTH ".$monthtit;
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
            padding: 6px!important;
            border: 1px solid black!important;
            font-size:15px !important;
            font-family: monospace;

        }
		
					table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
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




<div >
<div class="header_bg">





<?php
//include('printheader.php');
?>
</div>

	   <div >
    <table width="100%" id="appletter"border="none">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style="width:50%; float:right">

	<?php
$comapnydtl = $userObj->showCompdetailsById($comp_id);
 echo $comapnydtl['comp_name'];?>
<?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?>


<tr><td align='center'><div ><?php echo "<br><b> &nbsp; &nbsp; &nbsp;" .$clintid." - ".$client_name."</b><br> &nbsp; &nbsp; &nbsp;<b>" .$_SESSION['reporttitle']."</b><br> <br></div>" 
?>
	</div></td></tr></thead>
</table></div>

	</thead>
</table></div>


    <div class="row body" >
            <table>
    <tr>
        <td class='thheading' width="12%">Details of Days</td>
        <td  class='thheading' width="8%" align='right'> Days</td>
        <td  class='thheading' width="13%">Income </td>
        <!-- <td class='thheading' width="7%">STD PAY</td> -->
        <td class='thheading' width="13%" align='right'>Earnings </td>
        <td  class='thheading' width="14%">Deduction </td>
        <td  class='thheading' class='thheading' width="9%" align='right'></td>

        <td class='thheading' width="10%" align='right'>Deductions</td>
<!--        <td class='thheading' width="13%" align='center'>Emp CONTRI 3.67% OR 4.75% </td>
        <td class='thheading' width="13%" align='center'>Emp CONTRI 8.33%</td> -->
    </tr>


       <?php

            //Query for Income
        $row1 = $userObj->reportSalSummeryIncomeReport($tab_empinc,$clintid,$frdt,$tab_emp,$emp);    
      /* if($emp=='Parent')
       {
        $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt  from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join employee e  on e.emp_id = ti.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND ti.sal_month = '$frdt'  group by ti.head_id ";
       }
       else
       {
        $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt from $tab_empinc ti  inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join $tab_emp e  on e.emp_id = ti.emp_id  and e.sal_month=ti.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND ti.sal_month = '$frdt'  group by ti.head_id ";

       }
	   
		$row1 = mysql_query($sql);*/
		$i = 1;
       $restotalstdpay=0;
		while($row_inc =$row1->fetch_assoc()){
			$arr_inc_name[$i] = $row_inc['income_heads_name'];
			if($row_inc['std_amt'] > 0){
				$arr_inc_std[$i] = number_format($row_inc['std_amt'],2,".",",");
				$restotalstdpay = $restotalstdpay+$row_inc['std_amt'];
				}
			else{
				$arr_inc_std[$i] = ' ';
			}
			if($row_inc['amount'] > 0 ){
			//	$arr_inc_amt[$i] = number_format($row_inc['amount'],2,".",",");
			
$arr_inc_amt[$i] =  money_format('%i', $row_inc['amount']);
				}
			else{
				$arr_inc_amt[$i]  = ' ';
			}

			$i++;
		}


       //Query for Deduction
        $row1 = $userObj->reportSalSummeryDeductionReport($emp,$tab_empded,$clintid,$frdt,$tab_emp);
       /*if($emp=='Parent')
       {
	 		$sql="select tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND tdd.sal_month = '$frdt'  group by tdd.head_id ";
       }
       else
       {
			$sql="select tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join $tab_emp e  on e.emp_id = tdd.emp_id and e.sal_month = tdd.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND tdd.sal_month = '$frdt'  group by tdd.head_id ";

       }
	   $row1 = mysql_query($sql);*/
		$j = 1;
		while($row_ded =$row1->fetch_assoc()){
					if ( $row_ded['deduct_heads_name']== "EXTRA DEDUCT-1" and strpos($resclt['client_name'] ,"MERSON")>0)
		{
			
			$arr_ded_name[$j] = "CANTEEN DED.";
			
		}
			else{
			    $arr_ded_name[$j] = $row_ded['deduct_heads_name'];
			}
			if($row_ded['amount'] != 0){
				$arr_ded_amt[$j] = $row_ded['amount'];
				if ($row_ded['deduct_heads_name'] == "P.F." || $row_ded['deduct_heads_name'] == "E.S.I." ){
				$arr_ded_std_amt[$j] = number_format($row_ded['std_amt'],0,".",",");
				}
				ELSE
				{$arr_ded_std_amt[$j] = "";}
			    IF ($row_ded['employer_contri_1'] != 0){
				$arr_ded_emp_contri1_amt[$j] = number_format( $row_ded['employer_contri_1'],2,".",",");}
				ELSE 
				{
					$arr_ded_emp_contri1_amt[$j] == "";
				}
				
				IF ($row_ded['employer_contri_2']!= 0 ){
				$arr_ded_emp_contri2_amt[$j] = number_format($row_ded['employer_contri_2'],2,".",",");}
				ELSE
				{
					$arr_ded_emp_contri2_amt[$j] = "";
				}
				}
			else{
				$arr_ded_name[$j] ="";
				$arr_ded_amt[$j]  = ' ';
				$j--;
			}

			$j++;
		}


       //Query for salary advance
       $row1 = $userObj->reportSalSummeryAdvanceReport($emp,$tab_adv,$clintid,$comp_id,$frdt,$todt);
	   /*if($emp=='Parent')
       {
	    $sql = "select sum(tadv.amount) as amount ,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where mc.parentId =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.parentId,mad.mast_advance_type_id";
	   }
	   else
	   {
	 $sql = "select sum(tadv.amount) as amount,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where tadv.client_id =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.mast_client_id,mad.mast_advance_type_id";}
$row1 = mysql_query($sql);*/
while($row_ded =$row1->fetch_assoc()){
    $arr_ded_name[$j] = $row_ded['advance_type_name'];

    if($row_ded['amount'] > 0){
        $arr_ded_amt[$j] =  number_format($row_ded['amount'],2,".",",");
    }else{
        $arr_ded_amt[$j]  = ' ';
    }

	   $j++;
}

		 $row1 = $userObj->sumReportSalSummeryReport($emp,$tab_days,$clintid,$frdt);
		
      /* if($emp=='Parent')
       {
 			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.parentid  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
       }
       else
       {
			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.mast_client_id  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
       }

		$row1 = mysql_query($sql);*/

		$k = 1;


       while($row_days=$row1->fetch_assoc()){
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
                   $arr_days_name[$k] = "SL Days";
                   $arr_days_value[$k] = $row_days['sl'];
                   $k++;
               }
               if ($row_days['cl'] > 0) {
                   $arr_days_name[$k] = "Casual Leave";
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
                   $arr_days_name[$k] = "Addi. Days";
                   $arr_days_value[$k] = $row_days['additional'];
                   $k++;
               }
               if($row_days['othours'] > 0) {
                   $arr_days_name[$k] = "OT Hours";
                   $arr_days_value[$k] = $row_days['othours'];
                   $k++;
               }
               if($row_days['nightshifts'] > 0) {
                   $arr_days_name[$k] = "Night SFT.";
                   $arr_days_value[$k] = $row_days['nightshifts'];
                   $k++;
               }
        if($row_days['extra_inc2'] > 0) {

                //   $rowstemp= $row_days['extra_inc2'];
				   $rowstemp= 0;
				

             }
       }


		if($i-1>=$j)
        {$maxrows = $i-1;}
        else
        {$maxrows = $j-1;}

		if ($maxrows>=$k-1)
        {}
        else
        {$maxrows = $k-1;}
	

		for($l=1;$maxrows>=$l;$l++){
        /*    if(isset($arr_days_name[$l])&&$arr_days_name[$l]!='') {
                $arr_days_name[$l]=$arr_days_name[$l];
            }else{
                $arr_days_name[$l]='0';
            }

            if(isset($arr_days_value[$l])) {
                $arr_days_value[$l]=$arr_days_value[$l];

            }else{
                $arr_days_value[$l]='0';
            }

            if(isset($arr_inc_name[$l])) {
                $arr_inc_name[$l]=$arr_inc_name[$l];
            }else{
                $arr_inc_name[$l]='0';
            }

            if(isset($arr_inc_std[$l])) {
                $arr_inc_std[$l]= $arr_inc_std[$l];
            }else{
                $arr_inc_std[$l]='0';
            }
            if(isset($arr_inc_amt[$l])) {
             $arr_days_name[$l]=$arr_days_name[$l];
            }else{
                $arr_days_name[$l]='0';
            }*/





//<td align='center'>  ".$arr_inc_std[$l]."</td>
				

            echo "<tr>";
            if ($l < $k){
             echo "<td>". $arr_days_name[$l]."</td>
				<td  align='right'> ".$arr_days_value[$l]."</td>";
				}
            else
            {
                echo "<td width='15%'> </td>
				<td width='8%'> </td>";
				}

            if ($l < $i){         //checking array subscript
                echo "<td>".$arr_inc_name[$l]."</td>
              <td align='right'>".$arr_inc_amt[$l]."</td>";
				}
            else
            {
                echo "<td></td>
				<td></td>";
				}

            if ($l < $j){      //checking array subscript

                echo "<td>".$arr_ded_name[$l]."</td>
				<td align='right'>". $arr_ded_std_amt[$l]."</td>
				<td align='right'>". $arr_ded_amt[$l]."</td>";
				
				//<td align='center'>". $arr_ded_emp_contri1_amt[$l]."</td>
				//<td align='center'>". $arr_ded_emp_contri2_amt[$l]."</td>";
				}
            else
            {
            //	<td></td>
			//	<td></td>
			    echo "<td></td>
				<td></td>
				<td></td>";
				}

            echo "</tr>";
        }

        $rowtotal=$userObj->sumNetsalReportSalSummery($tab_emp,$clintid,$frdt,$emp);

       /*if($emp=='Parent')
       {
 		$sqltotal = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.parentid  =  '".$clintid."'  AND $tab_emp.sal_month = '$frdt' GROUP by parentid";
 	   }
	   else{
 		  $sqltotal = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.mast_client_id   =  '".$clintid."'  AND $tab_emp.sal_month = '$frdt' GROUP by client_id";
       }
	   $rowtotal= mysql_query($sqltotal);*/
       $restotal=$rowtotal->fetch_assoc();

       if($restotal['payabledays']!='') {
           echo "<tr>";
           echo "<td>Payabledays</td>
				<td align='right'>".$restotal['payabledays']."</td>";
           echo " 	<td></td><td></td>
				";
				
		//	echo "<td>Round Off </td><td></td>";
				echo "<td> </td><td></td>";
			$round1= 0;
			$round1= (round( round($restotal['netsalary'],0)-(round($restotal['gross_salary'],2)-round($restotal['tot_deduct'],2)),2)*-1);
			//echo "<td align='right'>".$round1."</td>	</tr>";
			echo "<td align='right'></td>	</tr>";
				//<td></td><td></td>
				
       }

       if($rowstemp!='') {
           echo "<tr>";

           echo "<td>Reimbursement</td>
				<td>".number_format($rowstemp,0,".",",")."</td>";
           echo " 	<td></td><td></td>
				<td></td><td></td>
				<td></td>
				</tr>";
       }
       ?>

   <tr>
           <td class='thheading'>Total No of Employee</td>
           <td class='thheading' align='right'><?php echo $restotal['totalemp'];?></td>
           <td class='thheading'>Gross Salary</td>
          <!-- <td class='thheading'><?php echo number_format( $restotalstdpay,2,".",",");?></td> --> 
           <td class='thheading'align='right' ><?php echo number_format( round($restotal['gross_salary'],2),2,".",",");?></td>
			<td></td><td>Total Dedud.</td>
           <!-- <td class='thheading'align='right'><?php echo number_format( round($restotal['tot_deduct'],2)+$round1,2,".",",");?></td>-->
		    <td class='thheading'align='right'><?php echo number_format( round($restotal['tot_deduct'],2),2,".",",");?></td>
		   
			</tr>
			<tr>
			<td></td><td></td><td></td><td></td><td></td>
           <td class='thheading'>NET SALARY</td>
           <td class='thheading'align='right'><?php echo number_format( round($restotal['netsalary'],0),2,".",",");?></td>

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