<?php
session_start();
error_reporting(E_ALL);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_POST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$left = $_POST['left'];
$noofpay = $_POST['noofpay'];

include("../lib/connection/db-config.php");

include("../lib/class/user-class.php");
$userObj=new user();
$userObj1=new user();

include('../fpdf/html_table.php');

$pdfHtml='';
include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);
$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];
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
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';
    $tab_adv='hist_advance';

	

	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));


    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];
	
	$sql = "SELECT LAST_DAY('".$todt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$todt = $res['last_day'];
	
 }


 //$sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."'  "; 
$sql = "SELECT * FROM $tab_days WHERE client_id ='".$clientid."'   AND sal_month >= '$frdt' and sal_month <= '$todt' ";

 if($emp!='all'){
    $empid=$_POST['empid'];
    $sql .= " AND emp_id=".$empid;
}
if($left!='yes'){
    $empid=$_POST['empid'];
    $sql .= " AND leftdate='0000-00-00'";
}

$res = mysql_query($sql);
$tcount= mysql_num_rows($res);

if($month!=''){
    $reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);
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
		.logo span.head11 {
			font-size: 19px !important;
		}
		
		span.head13 {
			font-size: 21px !important;
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
            .body { margin: 0 30px 10px 10px; }
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
$per=$noofpay;
while($row=mysql_fetch_array($res)){
    	$monthtit =  date('F Y',strtotime($row['sal_month']));
    $reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);

$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;
	
	$empid=$row['emp_id'];
	
	
	
    $emprows=$userObj1->showtranhiEployeedetails($tab_emp,$empid,$frdt);
    $emprows1=$userObj1->showEployeedetails($empid,$comp_id,$user_id);
	//$emprows2=$userObj1->show_tab_Eployeedetails($tab_emp,$empid,$frdt);
$desrows=$userObj1->displayDesignation($emprows['desg_id']);
$bankrows=$userObj1->displayBank($emprows['bank_id']);
$tempc=$count%$per;




?>

    <div  <?php
    if($tcount>$count && $tempc!=1){
                echo 'class="page-bk"';
                } ?>  >
				<?php if($noofpay=="2"){echo "<div style='height:100px'>&nbsp</div>";} ?>
<div class="header_bg"><?php include("printheader1.php"); ?>


</div>

<br />
<?php

    $pdfHtml.='<br /> <br /> <div ';
    if($tcount>$count ){
        $pdfHtml.='class="page-bk"';
    }

    $pdfHtml.='       >
<div class="header_bg">


</div>
<div class="row">
    <div class="twelve heading" align="center" >
    
   
      ';

    $pdfHtml.='    
    </div>

</div>
<br /> ';

?>
   <div class="row" style="padding: 0 10px;">

            <table border="1" width="100%" style="margin-bottom: 10px;">

                <tr>
                    <td height="5px" width="13%">Emp Id :</td><td height="5px" width="30%" colspan="2"><?php echo $row["emp_id"];?> <?php if($emprows1['ticket_no']!=""){ echo "(".$emprows1['ticket_no'].")";}?> </td>
                    <td height="5px" width="19%">Emp.Name :</td><td height="5px" width="38%"  colspan="3"><?php echo $emprows1["first_name"]." ".$emprows1["last_name"]; ?></td>
               </tr>
                <tr>
                    <td height="5px" width="15%">Join Date:</td><td height="5px" width="35%" colspan="2"><?php if ($emprows1["joindate"]!='0000-00-00'){echo date("d-m-Y", strtotime($emprows1["joindate"]));} ?></td>
                    <td height="5px" width="15%">Designation :</td><td height="5px" width="35%" colspan="3"><?php if( $desrows['mast_desg_name']!="N.A."){ echo $desrows['mast_desg_name'];} ?>	






                    </td>

                </tr>
                <tr>
                    <td height="5px" width="15%">UAN  / PF NO:</td>
                    <td height="5px" width="35%" colspan="2"> <?php echo $emprows1["uan"]."    /   ".$emprows1["pfno"] ; ?></td>
                    <td height="5px" width="15%">Bank A/c No :</td>
                    <td height="5px" width="35%"  colspan="3"> <?php echo $emprows["bankacno"].' - '.$bankrows['branch']; ?></td>

                </tr>




                <tr>
                    <td>ESI NO :</td>
                    <td colspan="2"> <?php echo $emprows['esino']; ?></td>
                    <td >Bank Name
                    <?php
					
					$pl=$row['plbal']-$row['pl'];
					$cl = $row['clbal']-$row['cl'];
                    $str='PL Bal : '.$pl ." CL Bal : ".$cl ;
                    $str1=$str;
                    //echo $str;

                    ?>
                    </td>
					<td colspan="3"><?php echo $bankrows['bank_name'];?></td>

                </tr>


                <?php  $pdfHtml.='<div class="row" >

            <table border="1" width="100%">

                <tr>
                    <td height="5px" width="13%">Emp Id :</td><td height="5px" width="30%" >'.$row["emp_id"].'</td> <td></td>
                    <td height="5px" width="19%">Emp.Name :</td><td height="5px" width="38%" >'.$emprows1["first_name"]." ".$emprows1["middle_name"]." ".$emprows1["last_name"].'</td> <td></td> <td></td>
               </tr>
                <tr>
                    <td height="5px" width="15%">Join Date :</td><td height="5px" width="35%" >'.date("d-m-Y", strtotime($emprows1["joindate"])).'</td>
                    <td></td><td height="5px" width="15%">DESG :</td><td height="5px" width="35%" > ';


                $pdfHtml.=$desrows['mast_desg_name'];

    $pdfHtml.='

                    </td>
 <td></td> <td></td>
                </tr>
                <tr>
                    <td height="5px" width="15%">UAN :</td>
                    <td height="5px" width="35%">'.$emprows1["uan"].'</td> <td></td>
                    <td height="5px" width="15%">Bank A/c No :</td>
                    <td height="5px" width="35%">'.$emprows["bankacno"].' - '.$bankrows['branch'].'</td> <td></td> <td></td>

                </tr>
                <tr>
                    <td>ESI NO :</td>
                    <td>'. $emprows['esino'].'</td>
   <td></td>
           <td>'.$str1.'</td>
           <td></td>
           <td></td>
           <td></td>
                </tr>





 ';
 ?>

            </table>
       <table>
    <tr>
        <td height="5px" width="16%">&nbsp;</td>
        <td height="5px" width="14%">&nbsp; </td>
        <td height="5px" width="14%">&nbsp;</td>
        <td height="5px" width="14%" align= 'center'>STD PAY</td>
        <td height="5px" width="14%" align= 'center'>EARNINGS</td>
        <td height="5px" width="14%"> &nbsp;</td>
        <td height="5px" width="14%"align= 'center' >DEDUCTIONS</td>
    </tr>


   <tr>
 <?php
    $pdfHtml.='
    <tr>

        <td height="5px" width="10%">&nbsp;</td>
        <td height="5px" width="5%">&nbsp; </td>
        <td height="5px" width="10%">&nbsp;</td>
        <td height="5px" width="15%">STD PAY</td>
        <td height="5px" width="20%">EARNINGS</td>
        <td height="5px" width="15%"> &nbsp;</td>
        <td height="5px" width="25%">DEDUCTIONS</td>
    </tr>


   <tr>';

   
   
   $i = 0;
while ($i<=10)
{
	$arr_inc_name[$i] = "";
	$arr_inc_std[$i] = "";
	$arr_inc_amt[$i] = "";
	$arr_ded_name[$i] = "";
	$arr_ded_amt[$i] = "";
	$arr_days_name[$i] = "";
    $arr_days_value[$i] = "";
	$i++;                   
}

   
       $tran_day_emp_id = $row['emp_id'];
	   

  $sql = "select ti.*,mi.income_heads_name from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join $tab_emp  te on te.emp_id =ti.emp_id and te.sal_month = ti.sal_month where mi.comp_id = '$comp_id'  and ti.emp_id = '".$tran_day_emp_id."' and  ti.sal_month = '".$row['sal_month']."'   ";


       $sql .= " order by mi.mast_income_heads_id";
$row1 = mysql_query($sql);
$i = 1;
$gr_sal = 0;
while($row_inc =mysql_fetch_assoc($row1)){
    if($row_inc['amount'] > 0){
		
			
			if($row_inc['income_heads_name']!= "OVERTIME")
				{
				$arr_inc_name[$i] = $row_inc['income_heads_name'];
				$arr_inc_std[$i] = $row_inc['std_amt'];
				$gr_sal = $gr_sal +$row_inc['std_amt'];
				}
				else
				{         
					if ($clientid != 5 && $clientid != 7){
					$arr_inc_name[$i] = $row_inc['income_heads_name'];
					$arr_inc_std[$i] =  $row_inc['std_amt'];
					$arr_inc_std[$i] = $arr_inc_std[$i];}
					else 
					{		$arr_inc_name[$i] = "OTHER EARNINGS";
							$arr_inc_std[$i] =  "";}
						
				}
		
    if($row_inc['amount'] > 0 ){
        $arr_inc_amt[$i] = $row_inc['amount'];
    }else{
        $arr_inc_amt[$i]  = ' ';
    }
		
		
		$i++;
    }else{
        $arr_inc_std[$i] = ' ';
    }

	   
}
      //$arr_inc_name[$i]='Gross Salary';
	  
	  //$arr_inc_std[$i] = number_format ( $gr_sal ,2,".",",");
	  
	  //$gr_sal;
   $arr_inc_amt[$i]=$emprows['gross_salary'];



//$sql = "select tdd.*,mi.deduct_head_name from tran_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.head_id  where md.comp_id = '$comp_id'  and tdd.emp_id = '".$tran_day_emp_id."' and tdd.sal_month = '".$resclt['current_month']."' order by md.head_id";
    $sql = "select tdd.*,md.deduct_heads_name from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id where md.comp_id = '$comp_id'  and tdd.emp_id = '".$tran_day_emp_id."' and  tdd.sal_month = '".$row['sal_month']."'    order by md.mast_deduct_heads_id";
$row1 = mysql_query($sql);
$j = 1;
while($row_ded =mysql_fetch_assoc($row1)){

    if($row_ded['amount'] > 0){
		$arr_ded_name[$j] = $row_ded['deduct_heads_name'];
		
		
		if ( $row_ded['deduct_heads_name']== "EXTRA DEDUCT-1" and strpos($resclt['client_name'] ,"MERSON")>0)
		{
			
			$arr_ded_name[$j] = "CANTEEN DED.";
			
		}
        $arr_ded_amt[$j] = $row_ded['amount'];
	   $j++;
    }else{
		
        $arr_ded_amt[$j]  = ' ';
    }

}

$sql = "select tadv.*,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id  where mad.comp_id = '$comp_id'  and tadv.emp_id = '".$tran_day_emp_id."' and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   order by mad.mast_advance_type_id";
$row1 = mysql_query($sql);
while($row_ded =mysql_fetch_assoc($row1)){
    $arr_ded_name[$j] = $row_ded['advance_type_name'];

    if($row_ded['amount'] > 0){
        $arr_ded_amt[$j] = $row_ded['amount'];
    }else{
        $arr_ded_amt[$j]  = ' ';
    }

	   $j++;
}



//  if($j>1) {
     /* $arr_ded_name[$j] = 'Total Deduction';
      $arr_ded_amt[$j] = $emprows['tot_deduct'];*/
	  
//  }
   $sql = "select `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`,`extra_inc2` from $tab_days where emp_id='$empid' and sal_month = '".$row['sal_month']."' ";
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
                   $arr_days_name[$k] = "Additional Days";
                   $arr_days_value[$k] = $row_days['additional'];
                   $k++;
               }
               if($row_days['othours'] > 0 &&  $clientid != 5 &&  $clientid != 7 ) {
                   $arr_days_name[$k] = "Ot Hours";
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
            $row_days['extra_inc2'];
              if($row_days['extra_inc2'] > 0) 
			  { $reimbursement = $row_days['extra_inc2'];}
               
			   else{
                   $reimbursement = 0;
			   }


       }


		if($i>=$j)
        {$maxrows = $i;}
        else
        {$maxrows = $j;}

		if ($maxrows>=$k)
        {}
        else
        {$maxrows = $k;}
//	    echo "  ** i= ".$i. "  **** j= ".$j."  ** k = ".$k."  Max= ". $maxrows. "  *********** ";

		for($l=1;$maxrows>=$l;$l++){
         echo "<tr>";
            $pdfHtml.="<tr>";
            if ($l <= $k){

               echo "<td>".$arr_days_name[$l]."</td>
				<td>".number_format( $arr_days_value[$l],1,".",",")."</td>";

                $pdfHtml.="<td>".$arr_days_name[$l]."</td>
				<td>".number_format($arr_days_value[$l],1,".",",")."</td>";

				}
            else
            {
               echo "<td> </td>
				<td> </td>";

                $pdfHtml.="<td> </td>
				<td> </td>";


				}

            if ($l <= $i){         //checking array subscript
               echo "<td>".$arr_inc_name[$l]."</td>
              <td align='center'>  ". $arr_inc_std[$l]."</td>
				<td align='center'>".number_format( $arr_inc_amt[$l],2,".",",")."</td>";

                $pdfHtml.="<td>".$arr_inc_name[$l]."</td>
              <td align='center'>  ".number_format( $arr_inc_std[$l],2,".",",") ."</td>
				<td align='center'>".number_format( $arr_inc_amt[$l],2,".",",")."</td>";
				}
            else
            {
               echo "<td></td>
				<td></td>
				<td></td>";

                $pdfHtml.="<td ></td>
				<td ></td>
				<td ></td>";
				}

            if ($l <= $j){         //checking array subscript
               echo "<td >".$arr_ded_name[$l]."</td>
				<td align='center' >".number_format( $arr_ded_amt[$l],2,".",",")."</td>";

                $pdfHtml.="<td >".$arr_ded_name[$l]."</td>
				<td align='center'>".number_format( $arr_ded_amt[$l],2,".",",")."</td>";
				}
            else
            {
               echo "<td ></td>
				<td ></td>";

                $pdfHtml.="<td></td>
				<td></td>";
				}

           echo "</tr>";
            $pdfHtml.="</tr>";
        }






echo "</tr><tr>
<td></td>
<td></td>
<td>Gross Salary</td>
<td align='center'>".number_format ( $gr_sal ,2,".",",")."</td>
<td align='center'></td>
<td>Total Deduction</td>
<td align='center'>".$emprows['tot_deduct']."</td>";
   echo "</tr>
       <tr>
           <td class='thheading'>";
		   if ($reimbursement > 0)
			 {echo "REIMBURSEMENT";}
		
		    echo "</td> <td class='thheading'>";
			if ($reimbursement > 0)
			 {echo $reimbursement;} 
		   
		   echo '</td>
           <td></td>
           <td></td>
           <td></td>
           <td class="thheading">NET SALARY Rs.</td>
           <td align="center" class="thheading">'.number_format($emprows['netsalary'],2,".",",").'
           </td>
       </tr>

</table>
<div>This is a computer generated report hence doesn\'t require any signature.</div>


        </div>
<br/><br/>


    </div>';
    $pdfHtml.='</tr>
       <tr>
           <td>';
		      if ($reimbursement > 0)
			 { $pdfHtml.= "REIMBURSEMENT";} 
		    $pdfHtml.='</td>
           <td>';
		   		     if ($reimbursement > 0)
			 { $pdfHtml.=$reimbursement;}
		  $pdfHtml.='</td>
           <td></td>
           <td></td>
           <td></td>
           <td>NET SALARY Rs.</td>
           <td>'.round($emprows['netsalary'],0).'
           </td>
       </tr>

</table>
 <div>This is a computer generated report hence doesn\'t require any signature.</div>
        </div>
        <div> 
 
        </div>
<br/><br/>

    </div>';
 $compname='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:30px;">'.strtoupper($rowcomp['comp_name']).'</span>  -  '. $reporttitle;

    $pdf=new PDF_HTML_Table();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',8);
    $pdf->Image('../images/JSM-logo.jpg',10,10,25);


    $pdf->WriteHTML("<br><br>$compname<br>$pdfHtml<br><br>");
    $temp=$emprows1["first_name"]."-".$emprows1["middle_name"]."-".$emprows1["last_name"].'_'.$monthtit;
    $name='../pdffiles/payslip/'.$temp.'.pdf';

    $pdf->Output($name,'F');
 $docfilename='../docfiles/payslip/'.$temp.'.doc';
 $myfile = fopen($docfilename, "w") or die("Unable to open file!");

 fwrite($myfile, "<br><img src='../images/JSM-logo.jpg'> <br>$compname<br>$pdfHtml<br><br>");

 fclose($myfile);
    $pdfHtml='';
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