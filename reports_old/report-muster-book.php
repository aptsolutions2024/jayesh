<?php
session_start();

//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include("../lib/class/admin-class.php");
$adminObj=new admin();
$resclt=$userObj->displayClient($clintid);

$resbank = $userObj->showBank($comp_id);
$rowbank = mysqli_num_rows($resbank );
$employee = $userObj->getEmployeeAllDetailsByClientIdByLocation($clintid,$comp_id,$user_id);
$compname = $userObj->showCompdetailsById($comp_id,$comp_id,$user_id);
if($month!=''){
    $reporttitle="Muster Book of ".$resclt['client_name'];
}


$_SESSION['client_name']=$resclt['client_name'];

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
            font-size:11px !important;
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
			
			@media print {
			  h3 {
				position: absolute;
				page-break-before: always;
				page-break-after: always;
				bottom: 0;
				right: 0;
			  }
			  h3::before {
				position: relative;
				bottom: -20px;
				counter-increment: section;
				content: counter(section);
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
<?php if($_REQUEST['type']==1){?>	


    <table width="100%" cellpadding='0' cellspacing='0' style="border:0 !important">
    
	
	<tr>
	<td colspan="5" style="border:0 !important">	
	

<div >
	<div style="text-align:center">
	<div>Form II</div>
	<div>MUSTER ROOL</div>
	<div>M.W. Rules. 1963 Rule 27 (I)</div>
	<div>NAME AND ADDRESS OF ESTABLISHMENT : <?php echo $compname['comp_name'];?></div>
	<div>NAME AND ADDRESS OF PRINCIPLE EMPLOYER : <?php echo $_SESSION['client_name'];?></div>
	</div>
	
</div></td></tr></table>
	<div class="page-bk row body" >
	<table width="100%">

	<tr>
	<td width="3%">Sr No.</td>
	<td>Name Of Employee</td>
	<td ></td>
	<td width="2%">1</td>
	<td width="2%">2</td>
	<td width="2%">3</td>
	<td width="2%">4</td>
	<td width="2%">5</td>
	<td width="2%">6</td>
	<td width="2%">7</td>
	<td width="2%">8</td>
	<td width="2%">9</td>
	<td width="2%">10</td>
	<td width="2%">11</td>
	<td width="2%">12</td>
	<td width="2%">13</td>
	<td width="2%">14</td>
	<td width="2%">15</td>
	<td width="2%">16</td>
	<td width="2%">17</td>
	<td width="2%">18</td>
	<td width="2%">19</td>
	<td width="2%">20</td>
	<td width="2%">21</td>
	<td width="2%">22</td>
	<td width="2%">23</td>
	<td width="2%">24</td>
	<td width="2%">25</td>
	<td width="2%">26</td>
	<td width="2%">27</td>
	<td width="2%">28</td>
	<td width="2%">29</td>
	<td width="2%">30</td>
	<td width="2%">31</td>
	<td width="3%">Pr Days</td>
	<td width="3%">Week off</td>
	<td width="3%">Paid Leave</td>
	<td width="3%">Abs days</td>
	</tr>
	<?php $i=1; $locid=""; 
	$page = 1;
$cnt=0;

	while($res = $employee->fetch_assoc()){ 
	$cnt++;
	if ($cnt>8){
		$page++;
		$cnt = 1;
	}
	if ($page>1 & $cnt==1)
	{ echo
 '</table>
 </div><div class= "page-bk row body"  >
    
	<table width="100%" cellpadding="0" cellspacing="0" style="border:0 !important">
    
	
	<tr>
	<td colspan="5" style="border:0 !important">	
	

<div >
	<div style="text-align:center">
	<div>Form II</div>
	<div>MUSTER ROOL</div>
	<div>M.W. Rules. 1963 Rule 27 (I)</div>
	<div>NAME AND ADDRESS OF ESTABLISHMENT :';  echo $compname["comp_name"];echo '</div>
	<div>NAME AND ADDRESS OF PRINCIPLE EMPLOYER :';  echo $_SESSION["client_name"];echo '</div>
	</div>
</div></td></tr></table>
	
	<table width="100%" cellpadding="0" cellspacing="0" style="border:0 !important">
	<tr>
	<td width="3%">Sr No.</td>
	<td>Name Of Employee</td>
	<td ></td>
	<td width="2%">1</td>
	<td width="2%">2</td>
	<td width="2%">3</td>
	<td width="2%">4</td>
	<td width="2%">5</td>
	<td width="2%">6</td>
	<td width="2%">7</td>
	<td width="2%">8</td>
	<td width="2%">9</td>
	<td width="2%">10</td>
	<td width="2%">11</td>
	<td width="2%">12</td>
	<td width="2%">13</td>
	<td width="2%">14</td>
	<td width="2%">15</td>
	<td width="2%">16</td>
	<td width="2%">17</td>
	<td width="2%">18</td>
	<td width="2%">19</td>
	<td width="2%">20</td>
	<td width="2%">21</td>
	<td width="2%">22</td>
	<td width="2%">23</td>
	<td width="2%">24</td>
	<td width="2%">25</td>
	<td width="2%">26</td>
	<td width="2%">27</td>
	<td width="2%">28</td>
	<td width="2%">29</td>
	<td width="2%">30</td>
	<td width="2%">31</td>
	<td width="3%">Pr Days</td>
	<td width="3%">Week off</td>
	<td width="3%">Paid Leave</td>
	<td width="3%">Abs days</td>
	</tr>';
	}
		?>
	<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $res['first_name'].' '.$res['middle_name'].' '.$res['last_name'];?></td>
	<td rowspan =2>Sign.</td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	<td rowspan =2></td>
	</tr>
	<tr>
	<td></td>
	<td>Joining:<?php echo date('d/m/Y',strtotime($res['joindate']))?> Age:<?php $from = new DateTime($res['bdate']);
$to = new DateTime('today');
 $age = $from->diff($to)->y; if($res['bdate'] !="0000-00-00"){echo $age;}?></td>
	
	</tr>
	
	
	<?php 
	

	 $i++;} ?>
	

		
		

 </table>

 </div> 
<?php }else{?>
<!---------------------- type 2 format -------------------------------------->
<div class="page-bk row body" >
<div >
	<div style="text-align:center">
	<div>MUSTER ROLL</div>
	<div>MONTH : </div>
	</div>
	<div>&nbsp;</div>
</div>


	<table width="100%">
	<span class="page-bk">
	<tr>
	<td width="3%">Sr No.</td>
	<td>Name Of Employee</td>
	<td ></td>
	<td width="2%">1</td>
	<td width="2%">2</td>
	<td width="2%">3</td>
	<td width="2%">4</td>
	<td width="2%">5</td>
	<td width="2%">6</td>
	<td width="2%">7</td>
	<td width="2%">8</td>
	<td width="2%">9</td>
	<td width="2%">10</td>
	<td width="2%">11</td>
	<td width="2%">12</td>
	<td width="2%">13</td>
	<td width="2%">14</td>
	<td width="2%">15</td>
	<td width="2%">16</td>
	<td width="2%">17</td>
	<td width="2%">18</td>
	<td width="2%">19</td>
	<td width="2%">20</td>
	<td width="2%">21</td>
	<td width="2%">22</td>
	<td width="2%">23</td>
	<td width="2%">24</td>
	<td width="2%">25</td>
	<td width="2%">26</td>
	<td width="2%">27</td>
	<td width="2%">29</td>
	<td width="2%">30</td>
	<td width="2%">31</td>
	<td width="3%">Pr Days</td>
	<td width="3%">Week off</td>
	<td width="3%">Paid Leave</td>
	<td width="3%">Total</td>
	</tr>
	<?php $i=1;  $employee = $userObj->getEmployeeAllDetailsByClientIdByLocation($clintid,$comp_id,$user_id);
	$locid ='';
//	print_r($employee);
	while($res = $employee->fetch_assoc()){
		 IF($locid == ''){$locid = $res['loc_id'];}
		
		if($locid !=$res['loc_id']){
		echo "</table></div><div class='page-bk'>  <div >
	<div style='text-align:center'>
	<div>MUSTER ROLL</div>
	<div>MONTH : </div>
	</div>
	<div>&nbsp;</div>
</div>
 <table>";
	}?>
	<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $res['first_name'].' '.$res['middle_name'].' '.$res['last_name'];?></td>
	<td ></td>
	<td rowspan = "2"></td>
	<td  rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	<td rowspan = "2"></td>
	</tr>
	<tr>
	<td></td>
	<td>Joining:<?php echo date('d/m/Y',strtotime($res['joindate']))?> Age:<?php $from = new DateTime($res['bdate']);
$to = new DateTime('today');
 $age = $from->diff($to)->y; if($res['bdate'] !="0000-00-00"){echo $age;}?></td>
	<!--<td></td>
	<td ></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>-->
	</tr>
	
	<?php 
	

	 $i++;} ?>
	

		
		

 </table>

 </div>

<?php } ?>
</td>
</tr>
<?php /*
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
*/
?>


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