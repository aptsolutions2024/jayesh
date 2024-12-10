<?php
session_start();

//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$payment_date=$_REQUEST['paymentdate'];

$client_id=$_REQUEST['client'];

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();


include("../lib/class/admin-class.php");
$adminObj=new admin();
$res=$userObj->showEmployeereport($comp_id,$user_id);

$resclt=$userObj->displayClient($clientid);
$cmonth=$resclt['current_month'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
  }
// t1= tran_          t2 = employee       t3 = mast_client    t4 = tran_employee
  
/*if($emp=='Parent')
	{if ($advtype ==0)
		{
		$sql = "SELECT t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.parentId = '".$clientid."'  and t2.comp_id ='".$comp_id."'  ";
		 
	 }
	 else{
		$sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t3.parentId = '".$clientid."' and t1.head_id = '".$advtype."' and   t2.comp_id ='".$comp_id."'  ";
	}
}
else
	{if ($advtype ==0)
		{
		$sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t2.client_id = '".$clientid."'  and t2.comp_id ='".$comp_id."' and  ";
		 
	 }
	 else{
		$sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name,t1.emp_id from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id  inner join mast_client t3 on t3.mast_client_id= t2.client_id where  t2.client_id = '".$clientid."' and t1.head_id = '".$advtype."' and   t2.comp_id ='".$comp_id."'   ";
	}
}*/




/*if($month=='current'){
 $sql .= " AND t1.sal_month='".$frdt."' ";}
else{
  $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
}

$sql.=" order by t1.head_id,t2.first_name,t2.middle_name,t2.last_name ";
*/



if($month!=''){
    $reporttitle="Leave Report for the month ".$monthtit;
	$reportdate="Date: ".$payment_date;
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
            border: 1px solid
			black!important;
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

   
<?php
$totalamt=0;
$totalleave=0;
$rate=0;

/*$ttotalco2=0;
$totalco2=0;
$totalstdam=0;*/
$c[]='';
$i=1;

 $sql="SELECT leave_details.emp_id,leave_details.client_id,leave_details.payment_date,leave_details.encashed,leave_details.rate,leave_details.amount,employee.emp_id,employee.client_id,employee.first_name,employee.middle_name,employee.last_name,employee.joindate,employee.leftdate,mc.client_name FROM leave_details inner join mast_client mc on mc.mast_client_id = leave_details.client_id INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$payment_date."' ";
$res = mysql_query($sql) or die(mysql_error());

if(mysql_affected_rows()==0)
{  
?>
	<div class="message"><?php echo "Record Not Found"; ?></div><br>
<?php	
}

while($row = mysql_fetch_array($res)){
?>
<div class="page-bk page page">

<div class="header_bg">
<?php
include('printheader3.php');
$srno =0;
?>
</div>

<br><br><br>



     <div class="row body ">
	 DEBIT : <?php echo $row['client_name'];?>  
 <br> <br> <br>
    <table border="0" width="100%">

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

	</tr>
	
	<tr>
        <td align="center" >
            <?php $srno++;
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
			?>
	     </td>

</tr>	
	
	
	     
	</table><br><br><br><br><br>
	<div > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
       	   BY CHEQUE NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												
						
	       DATE:- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         
		   BANK:-
		   
		   
		   <br><br><br><br><br><br><br><br>
		   <div align="center" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		        Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:_______________________________
				<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   
		         Receivers Name&nbsp;&nbsp;:_______________________________
				 <br><br>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   
 	             Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:_______________________________			
				<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		   
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;________________________________
		   </div>
		   
    </div>
        </div></div>
	<!--	 <div class="pagebreak" ></div>-->
		
<?php } ?>
		
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