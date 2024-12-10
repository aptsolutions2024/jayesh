<?php

session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    //header("/home");

header("/index");
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
 $user_id=$_SESSION['log_id'];
$result1=$userObj->showClient1($comp_id,$user_id);

$result2 = $userObj->showDesignation($comp_id); 
$result3 = $userObj->showDepartment($comp_id);
$result4 = $userObj->showQualification($comp_id); 
$result5 = $userObj->showBank($comp_id);
$result6 = $userObj->showLocation($comp_id);
$result7 = $userObj->showPayscalecode($comp_id);
$resultIncome = $userObj->showIncomehead($comp_id);
$resultdest = $userObj->showDeductionhead($comp_id);
 $reslt = $userObj->showLeavetype($comp_id);
 $resadv = $userObj->showAdvancetype($comp_id);
 $rescalin=$userObj->showCalType("caltype_income");
$rescalde=$userObj->showCalType("caltype_deduct"); 
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Add Employee</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
</head>
 <body>
<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->
<?php include('menu.php');?>
<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1">
            <div class="tab">
                <button id="t1" class="tablinks active" onclick="openTab(event, 'tab1')">Add Employee</button>
                <button id="t2" class="tablinks" onclick="openTab(event, 'tab2')" disabled>Employee Income</button>
                <button id="t3" class="tablinks" onclick="openTab(event, 'tab3')" disabled>Employee Deduct</button>
               <!-- <button id="t5" class="tablinks" onclick="openTab(event, 'tab5')" disabled>Employee Advances</button>-->
            </div>
            <div id="tab1" class="tabcontent">
                <h3>New Employee</h3>
                <form method="post"  id="form1">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success">
                        </div>
                        <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Employee Id :</span>
                        </div>
                        <div class="four  columns">
                           
                        </div>
						<div class="two columns">
                            <span class="labelclass">Ticket No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="ticket_no" name="ticket_no"  placeholder="Ticket No">

                        </div>
						 <div class="clearFix"></div>
						
                        <div class="two columns">
                            <span class="labelclass">First Name :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="fname" id="fname" placeholder="First Name" class="textclass">
                            <span class="errorclass hidecontent" id="fnerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Middle Name :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="mname" id="mname" placeholder="Middle Name " class="textclass">
                            <span class="errorclass hidecontent" id="mnerror"></span>
                        </div>
                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Last Name :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="lname" id="lname" placeholder="Last Name" class="textclass">
                            <span class="errorclass hidecontent" id="lnerror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Client :</span>
                        </div>
                        <div class="four  columns">


                            <select id="client" name="client" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row1=$result1->fetch_assoc()){
                                        ?>
                                    <option value="<?php echo $row1['mast_client_id'];?>" ><?php echo $row1['client_name'];?></option>
                               <?php }
                                ?>
                            </select>
							 <span class="errorclass hidecontent" id="clientrror"></span>
							
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Address :</span>
                        </div>
                        <div class="four  columns">
                            <textarea class="textclass" id="add1" name="add1"  placeholder="Address 1"></textarea>
                            <span class="errorclass hidecontent" id="ad1error"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Pin Code :</span>
                        </div>
                        <div class="four  columns">

                            <input type="text"class="textclass" id="pin_code" name="pin_code"  placeholder="Pin Code">
                                         <span class="errorclass hidecontent" id="pincerror"></span>
                        </div>
						 <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Job Status:</span>
                        </div>
                        <div class="four  columns">

                            <select name="jobstatus" id="jobstatus" class="textclass">
                                <option value="T">Trainee</option>
                                <option value="P">Probation</option>
                                <option value="C">Confirmed</option>
                                <option value="L">Left</option>
                            </select>

                        </div>
						 <div class="two columns">
                            <span class="labelclass">Joining Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="joindate" id="joindate" placeholder="Join Date" class="textclass">
                            <span class="errorclass hidecontent" id="jderror"></span>
                        </div>
						 <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Due Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="duedate" id="duedate" placeholder="Due Date" class="textclass">

                        </div>
						<div class="two columns">
                            <span class="labelclass">Increment Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="incdate" id="incdate" placeholder="Increment Date" class="textclass">
                            <span class="errorclass hidecontent" id="jderror"></span>
                        </div>
						 <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Left Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="lodate" id="lodate" placeholder="Left on Date" class="textclass">
                            <span class="errorclass hidecontent" id="loerror"></span>
                        </div>
						
                        <div class="two columns">
                            <span class="labelclass">Gender:</span>
                        </div>
                        <div class="four  columns">
                            <input type="radio" name="gentype" id="gentypem" value="M" checked> Male
                            <input type="radio" name="gentype" id="gentypef" value="F"> Female
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Marital Status :</span>
                        </div>
                        <div class="four  columns">


                            <select  id="married_status" name="married_status" class="textclass">
                                <option value="">--select--</option>
                                <option value="M" >Married</option>
                                <option value="U" selected>Unmarried</option>

                                </select>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Relation :</span>
                        </div>
                        <div class="four  columns">
                            <!--<input type="text" name="namerel" id="namerel" placeholder="Middle Name Relation" class="textclass">-->
							<select name="namerel" id="namerel" class="textclass">
							<option value="father">Father</option>
							<option value="husbund">Husbund</option>
							</select>							
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Birth Date :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="bdate" id="bdate" placeholder="Birth Date" class="textclass">
                            <span class="errorclass hidecontent" id="bderror"></span>
                        </div>
						
						<div class="two columns">
                            <span class="labelclass">Qualification :</span>
                        </div>
                        <div class="four  columns">

                            <select id="qualifi" name="qualifi" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row4=$result4->fetch_assoc()){
                                    ?>

                                    <option value="<?php echo $row4['mast_qualif_id'];?>" ><?php echo $row4['mast_qualif_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="qualifierror"></span>
							
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Department :</span>
                        </div>
                        <div class="four  columns">

                            <select id="depart" name="depart" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row3=$result3->fetch_assoc()){
                                    ?>

                                    <option value="<?php echo $row3['mast_dept_id'];?>" <?php if($row4['mast_qualif_id'] ==281){echo "selected";}?>><?php echo $row3['mast_dept_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="departerror"></span>
							

                        </div>
						<div class="two columns">
                            <span class="labelclass">Designation :</span>
                        </div>
                        <div class="four  columns">

                            <select id="design" name="design" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row2=$result2->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $row2['mast_desg_id'];?>"><?php echo $row2['mast_desg_name'];?></option>
                                <?php }
                                ?>
                            </select>
							<span class="errorclass hidecontent" id="designerror"></span>
                        </div>
						 <div class="clearFix"></div>
						  <div class="two columns">
                            <span class="labelclass">Mobile No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="phone" name="phone"  placeholder="Mobile No">
                            <span class="errorclass hidecontent" id="phoneerror"></span>
                        </div>
						      <div class="two columns">
                            <span class="labelclass">Bank :</span>
                        </div>
                        <div class="four  columns">

                            <select id="bank" name="bank" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row5=$result5->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $row5['mast_bank_id'];?>"><?php echo $row5['bank_name'].' - '.$row5['branch'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="bankeerror"></span>
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass">Bank A/C No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="bankacno" id="bankacno" placeholder="Bank Account No" class="textclass">
                            <span class="errorclass hidecontent" id="bankacnerror"></span>
                        </div>
						 <div class="two columns">
                            <span class="labelclass">Pay Mode :</span>
                        </div>
                        <div class="four  columns">
                            <select id="pay_mode" name="pay_mode" class="textclass">
                                <option value="">--select--</option>
                                <option value="T">TRANSFER</option>                               
                                <option value="N">NEFT</option>
								 <option value="C">CHEQUE</option>
                            </select>
                        </div>
						 <div class="clearFix"></div>
						<div class="two columns" style="display:none">
                            <span class="labelclass">Pay Code Id :</span>
                        </div>
                        <div class="four  columns" style="display:none">

                            <select name="paycid" id="paycid" class="textclass">
                                <option value="0">--select--</option>
                                <?php
                                while ($row7=$result7->fetch_assoc()){
                                    ?>

                                    <option value="<?php echo $row7['mast_paycode_id'];?>"><?php echo $row7['mast_paycode_name'];?></option>
                                <?php }

                                ?>
                            </select>
                            <span class="errorclass hidecontent" id="payciderror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">Aadhar No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="adhaar" id="adhaar" placeholder="Adhaar No" class="textclass">
                            <span class="errorclass hidecontent" id="adhaarerror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">PAN No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="panno" id="panno" placeholder="PAN No" class="textclass">
                            <span class="errorclass hidecontent" id="panerror"></span>
                        </div>
						 <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">ESI status :</span>
                        </div>
                        <div class="four  columns">
						<select name="esistatus" id="esistatus" class="textclass">
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                            <!--<input type="text" name="esistatus" id="esistatus" placeholder="ESI status" class="textclass">-->
                            <span class="errorclass hidecontent" id="esiserror"></span>
                        </div>
						<div class="two columns">
                            <span class="labelclass">ESI No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="esicode" id="esicode" placeholder="ESI No" class="textclass">
                            <span class="errorclass hidecontent" id="esierror"></span>
                        </div>
                        <div class="clearFix"></div>
						
						  <div class="two columns">
                            <span class="labelclass"> PF No. :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="pfcode" id="pfcode" placeholder="PF No." class="textclass">
                            <span class="errorclass hidecontent" id="pferror"></span>
                        </div>
						 
						 <div class="two columns">
                            <span class="labelclass">UAN No.:</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="uan" id="uan" placeholder="UAN" class="textclass">
                            <span class="errorclass hidecontent" id="uanerror"></span>
                        </div> 
						<div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Bonus Hold  (Y/N) :</span>
                        </div>
						
                        <div class="four  columns">
                            <input type="text" name="prnsrno" id="prnsrno" placeholder="Bonus Hold  (Y/N) " class="textclass">
                            <span class="errorclass hidecontent" id="prnerror"></span>
                        </div>
                        <div class="two columns">
                            <span class="labelclass">Votor ID :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="votid" id="votid" placeholder="Votor ID" class="textclass">
                            <span class="errorclass hidecontent" id="votiderror"></span>
                        </div>
						 <div class="clearFix"></div>
						  <div class="two columns">
                            <span class="labelclass">Driving Lic No :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="drilno" id="drilno" placeholder="Driving Lic No" class="textclass">
                            <span class="errorclass hidecontent" id="drilnoerror"></span>
                        </div>
                        <div class="two columns">
                            <span class="labelclass">Email ID:</span>
                        </div>
						
                        <div class="four  columns">

                            <input type="email" name="emailtext" id="emailtext" placeholder="Email ID" class="textclass">
                            <span class="errorclass hidecontent" id="emailerror"></span>
                        </div>
						<div class="clearFix"></div>
						<div class="two columns">
                            <span class="labelclass"> Handicap :</span>
                        </div>
                        <div class="four  columns">
                            <select id="handicap" name="handicap" class="textclass">
                                <option value="">--select--</option>
                                <option value="1">Not Applicable</option>
                                <option value="2">Locomotive</option>
                                <option value="3">Hearing</option>
                                <option value="4">Visual</option>
                            </select>
                        </div>
						
						<div class="two columns">
                            <span class="labelclass">Location :</span>
                        </div>
                        <div class="four  columns">

                            <select id="location" name="location" class="textclass">
                                <option value="">--select--</option>
                                <?php
                                while ($row6=$result6->fetch_assoc()){
                                    ?>

                                    <option value="<?php echo $row6['mast_location_id'];?>"> <?php echo $row6['mast_location_name'];?></option>
                                <?php }

                                ?>
                            </select>
							<span class="errorclass hidecontent" id="locationerror"></span>

                        </div>
						 <div class="clearFix"></div>
						 <div class="two columns">
                            <span class="labelclass">Company No. :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" class="textclass" id="comp_ticket_no" name="comp_ticket_no"  placeholder="Company No.">

                        </div>
                       
                       <div class="two columns" style="display:none">
                            <span class="labelclass">Permanent Date :</span>
                        </div>
                        <div class="four  columns"  style="display:none">
                            <input type="text" name="perdate" id="perdate" placeholder="Permanent Date" class="textclass">
                            <span class="errorclass hidecontent" id="perdatederror"></span>
                        </div>
  
                        <div class="two columns"  style="display:none">
                            <span class="labelclass">Pf Date :</span>
                        </div>
                        <div class="four  columns"  style="display:none">
                            <input type="text" name="pfdate" id="pfdate" placeholder="Pf Date" class="textclass">
                            <span class="errorclass hidecontent" id="pfdateerror"></span>
                        </div>
						
                        <div class="two columns">
                            <span class="labelclass">Nationality :</span>
                        </div>
                        <div class="four  columns">

                            <input type="text" class="textclass" id="nation" name="nation"  placeholder="Nationality" value="Indian">
                            <span class="errorclass hidecontent" id="naterror"></span>
                        </div>
                         <div class="clearFix"></div>

                        <div class="ten padd0 columns">
                            &nbsp;&nbsp;
                        </div>
                        <div class="two columns text-right">
                            <input type="button" name="submit" id="submit1" value="Save & Next" class="btnclass" onclick="saveemp();">
                        </div>

                        <div class="clearFix"></div>
                    </div>
                </form>
            </div>

            <div id="tab2" class="tabcontent">
                <h3>Income</h3>
                <form method="post"  id="form2">
                     <input type="hidden" id="empid" name="empid" value="0">

                    <div class="two columns">
                        <span class="labelclass">Income :</span>
                    </div>
                    <div class="four  columns">
                        <select id="incomeid" name="incomeid" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            while ($rowin=$resultIncome->fetch_assoc()){
                                ?>

                                <option value="<?php echo $rowin['mast_income_heads_id'];?>"><?php echo $rowin['income_heads_name'];?></option>
                            <?php }

                            ?>
                        </select>
                        <span class="errorclass hidecontent" id="incoerror"></span>
                    </div>

                    <input type="hidden" name="emp_income_id" id="emp_income_id" value="<?php echo $rowsincome['emp_income_id']; ?>">
                    <div class="two columns">
                        <span class="labelclass">Calculation Type :</span>
                    </div>
                    <div class="four  columns">
                             <select  name="caltype" id="caltype" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            while($rowcalin=$rescalin->fetch_assoc()){?>
                                <option value="<?php echo $rowcalin['id']; ?>"><?php echo $rowcalin['name']; ?></option>

                            <?php } ?>

                        </select>
                        <span class="errorclass hidecontent" id="calterror"></span>
                    </div>
                    <div class="clearFix"></div>
                    <div class="two columns">
                        <span class="labelclass"> STD Amt :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="stdamt" id="stdamt" placeholder="STD Amt" class="textclass">
                        <span class="errorclass hidecontent" id="stderror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Remark :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="inremark" id="inremark" placeholder="Remark" class="textclass" >
                        <span class="errorclass hidecontent" id="inrerror"></span>
                    </div>
                    <div class="clearFix"></div>




                    <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit2" value="Save & Next" class="btnclass" onclick="saveIncome();">
                    </div>

                    <div class="clearFix"></div>

                </form>


                <div id="detailsempIncome">

                </div>

            </div>

            <div id="tab3" class="tabcontent">
                <h3>Deduct</h3>
                <form method="post"  id="form3">
                    <div class="two columns">
                        <span class="labelclass">Deduction :</span>
                    </div>
                    <div class="four  columns">
                        <select id="destid" name="destid" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            while ($rowde=$resultdest->fetch_assoc()){
                                ?>

                                <option value="<?php echo $rowde['mast_deduct_heads_id'];?>"><?php echo $rowde['deduct_heads_name'];?></option>
                            <?php }

                            ?>
                        </select>
                        <span class="errorclass hidecontent" id="destiderror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Calculation Type :</span>
                    </div>
                    <div class="four  columns">
                          <select name="decaltype" id="decaltype" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            while($rowcalde=$rescalde->fetch_assoc()){?>
                                <option value="<?php echo $rowcalde['id']; ?>"><?php echo $rowcalde['name']; ?></option>

                            <?php } ?>
                        </select>
                        <span class="errorclass hidecontent" id="dectyerror"></span>
                    </div>
                    <div class="clearFix"></div>

                    <div class="two columns">
                        <span class="labelclass"> STD Amt :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="destdamt" id="destdamt" placeholder="STD Amt" class="textclass" >
                        <span class="errorclass hidecontent" id="destderror"></span>
                    </div>

                    <div class="two columns">
                        <span class="labelclass">Remark :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="destdremark" id="destdremark" placeholder="Remark" class="textclass">
                        <span class="errorclass hidecontent" id="destdrrerror"></span>
                    </div>
                    <div class="clearFix"></div>


                    <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit3" value="Save & Next" class="btnclass" onclick="saveDeduct();">
                    </div>

                    <div class="clearFix"></div>

                </form>
                <div id="detailsempDeduct">

                </div>
            </div>
            
               
                
            </div>
            <!--<div id="tab5" class="tabcontent">
                <h3>Advances</h3>
                <form method="post"  id="form5">
                    <div class="two columns">
                        <span class="labelclass">Advance Type :</span>
                    </div>
                    <div class="four  columns">
                        <select name="advtype" id="advtype" class="textclass">
                            <option>--select---</option>
                            <?php //while($rowadv=$resadv->fetch_assoc()){?>
                                <option value="<?php //echo $rowadv['mast_advance_type_id']; ?>"><?php //echo $rowadv['advance_type_name']; ?></option>
                            <?php //} ?>
                        </select>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Date :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advdate" id="advdate" placeholder="Advance Date" class="textclass">

                    </div>
                    <div class="clearFix"></div>

                    <div class="two columns">
                        <span class="labelclass">Advance Amount :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advamt" id="advamt" placeholder="Advance Amount" class="textclass">
                        <span class="errorclass hidecontent" id="advamterror"></span>
                    </div>
                    <div class="two columns">
                        <span class="labelclass">Advance Installment :</span>
                    </div>
                    <div class="four  columns">
                        <input type="text" name="advins" id="advins" placeholder="Advance Installment" class="textclass">
                        <span class="errorclass hidecontent" id="advinserror"></span>
                    </div>
                    <div class="clearFix"></div>

                   <div class="ten padd0 columns">
                        &nbsp;&nbsp;
                    </div>
                    <div class="two columns text-right">
                        <input type="button" name="submit" id="submit5" value="Save" class="btnclass" onclick="saveAdnavcen();">
                    </div>

                    <div class="clearFix"></div>

                </form>

                <div id="detailsempAdvances">

                </div>
                <br/>
            </div>-->


        </div>


    </div>
<br/>

</div>
<div class="clearFix"></div>

<!--Slider part ends here-->

<!--footer start -->
<?php include('footer.php');?>


    <script>
    $( document ).ready(function() {
    $('#tab1').show();
	
        $( "#bdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#joindate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#lodate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#incdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#perdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#pfdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $( "#duedate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
       $("#lfdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
 $("#ltdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#advdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
        $("#advdate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
	});
	 function openTab(evt, tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

	 function clearemp() {
        $('#fnerror').html("");
        $('#mnerror').html("");
        $('#lnerror').html("");
        $('#emailerror').html("");
        $('#bderror').html("");
        $('#jderror').html("");
         $('#adhaarerror').html("");
        $('#phoneerror').html("");
		$('#clientrror').html("");
		$('#qualifierror').html("");
		$('#departerror').html("");
		$('#designerror').html("");
		$('#locationerror').html("");
		$('#bankeError').html("");
		
		
   }

    function saveemp() {
        clearemp();

        var gentype='';
        if (document.getElementById('gentypem').checked) {
            gentype = document.getElementById('gentypem').value;
        }
        else{
            gentype= document.getElementById('gentypef').value;
        }


        $('#success1').hide();

        var fname=document.getElementById("fname").value;
        var mname=document.getElementById("mname").value;
        var lname=document.getElementById("lname").value;
        var bdate=document.getElementById("bdate").value;
        var joindate=document.getElementById("joindate").value;
        var lodate=document.getElementById("lodate").value;
        var incdate=document.getElementById("incdate").value;
        var perdate=document.getElementById("perdate").value;
        var pfdate=document.getElementById("pfdate").value;
        var client=document.getElementById("client").value;
        var design=document.getElementById("design").value;
        var depart=document.getElementById("depart").value;
        var qualifi=document.getElementById("qualifi").value;
        var bank=document.getElementById("bank").value;
        var location=document.getElementById("location").value;
        var bankacno=document.getElementById("bankacno").value;
        var paycid=document.getElementById("paycid").value;
        var esistatus=document.getElementById("esistatus").value;
        var namerel=document.getElementById("namerel").value;
        var prnsrno=document.getElementById("prnsrno").value;
        var esicode=document.getElementById("esicode").value;
        var pfcode=document.getElementById("pfcode").value;
        var adhaar=document.getElementById("adhaar").value;
        var drilno=document.getElementById("drilno").value;
        var uan=document.getElementById("uan").value;
        var votid=document.getElementById("votid").value;
        var jobstatus=document.getElementById("jobstatus").value;
        var add1=document.getElementById("add1").value;
        var panno1=document.getElementById("panno").value;
        var emailtext=document.getElementById("emailtext").value;
        var phone=document.getElementById("phone").value;
        var duedate=document.getElementById("duedate").value;
        var ticket_no=document.getElementById("ticket_no").value;
        var comp_ticket_no=document.getElementById("comp_ticket_no").value;
        var married_status=document.getElementById("married_status").value;
        var pay_mode=document.getElementById("pay_mode").value;
        var pin_code=document.getElementById("pin_code").value;
        var handicap=document.getElementById("handicap").value;
        var nation=document.getElementById("nation").value;


        var dateTime1 = new Date(bdate).getTime();
        var dateTime2 = new Date(joindate).getTime();

        var diff = dateTime1 - dateTime2;




        var rule = /^[a-zA-Z]*$/;
        if(fname=='') {
            $('#fnerror').html("Please Enter the First Name");
            $('#fnerror').show();
            document.getElementById("fname").focus();
            $("#success").hide();
        }

        else if(lname=='') {
            $('#lnerror').html("Please Enter the Last Name");

            $('#lnerror').show();
            document.getElementById("lname").focus();
            $("#success").hide();
        }
		else if(mname=='') {
            $('#mnerror').html("Please Enter the Middle Name");

            $('#mnerror').show();
            document.getElementById("mname").focus();
            $("#success").hide();
        }
        /*else if(emailtext=='') {
            $('#emailerror').html("Please Enter the Email Id");
            $('#emailerror').show();
            document.getElementById("emailname").focus();
            $("#success").hide();
        }*/
        else if(client=='') {

            $('#clientrror').html("Please Select Client");
            $('#clientrror').show();

            document.getElementById("client").focus();
            $("#success").hide();

        }else if(joindate=='') {

            $('#jderror').html("Please Enter the Join Date");
            $('#jderror').show();

            document.getElementById("joindate").focus();
            $("#success").hide();

        }else if(bdate=='') {
            $('#bderror').html("Please Enter the Birth Date");
            $('#bderror').show();

            document.getElementById("bdate").focus();
            $("#success").hide();
        }
        
        else if (diff >= 0) {
            $('#jderror').html("Please Enter the Birth Date < Join Date");
            $('#jderror').show();

            document.getElementById("joindate").focus();
            $("#success").hide();
        }
		else if(qualifi=='') {
            $('#qualifierror').html("Please Enter the Qualification ");
            $('#qualifierror').show();
            document.getElementById("qualifi").focus();
            $("#success").hide();
        }else if(depart=='') {
            $('#departerror').html("Please Enter the Department ");
            $('#departerror').show();
            document.getElementById("depart").focus();
            $("#success").hide();
        }else if(design=='') {
            $('#designerror').html("Please Enter the Designation ");
            $('#designerror').show();
            document.getElementById("design").focus();
            $("#success").hide();
        }else if(phone.length!=10) {
            $('#phoneerror').html("Please Enter the 10 digit in Mobile No");
            $('#phoneerror').show();
            document.getElementById("phone").focus();
            $("#success").hide();
        }else if(bank=='') {
            $('#bankeError').html("Please Enter the bank ");
            $('#bankerror').show();
            document.getElementById("bank").focus();
            $("#success").hide();
        }		
        else if(adhaar=='') {
            $('#adhaarerror').html("Please Enter the Adhaar No");
            $('#adhaarerror').show();
            document.getElementById("adhaar").focus();
            $("#success").hide();
        }
        else if(adhaar.length!=12) {
            $('#adhaarerror').html("Please Enter the 12 digit in Adhaar No");
            $('#adhaarerror').show();
            document.getElementById("adhaar").focus();
            $("#success").hide();
        }else if(location=='') {
            $('#locationerror').html("Please Enter the Location ");
            $('#locationerror').show();
            document.getElementById("location").focus();
            $("#success").hide();
        }
        /*else if(phone=='') {
            $('#phoneerror').html("Please Enter the Mobile No");
            $('#phoneerror').show();
            document.getElementById("phone").focus();
            $("#success").hide();
        }*/
		
		
        
        else {

            $.post('/add_employee_process',{
                'fname':fname,
                'mname':mname,
                'lname':lname,
                'lodate':lodate,
                'incdate':incdate,
                'perdate':perdate,
                'pfdate':pfdate,
                'client':client,
                'design':design,
                'depart':depart,
                'qualifi':qualifi,
                'bank':bank,
                'location':location,
                'bankacno':bankacno,
                'paycid':paycid,
                'esistatus':esistatus,
                'namerel':namerel,
                'prnsrno':prnsrno,
                'esicode':esicode,
                'pfcode':pfcode,
                'adhaar':adhaar,
                'drilno':drilno,
                'uan':uan,
                'votid':votid,
                'jobstatus':jobstatus,
                'gentype':gentype,
                'bdate':bdate,
                'joindate':joindate,
                'add1':add1,
                'emailtext':emailtext,
                'panno':panno1,
                'phone':phone,
                'duedate':duedate,
                'ticket_no':ticket_no,
                'comp_ticket_no':comp_ticket_no,
                'married_status':married_status,
                'pay_mode':pay_mode,
                'pin_code':pin_code,
                'nation':nation,
                'handicap':handicap

            },function(data){
                alert(data);
				$("#test").text(data); 
           document.getElementById("empid").value=data.trim();
                $("#tab1").hide();
                $('#tab2').show();
                $('#t2').addClass(" active");
                $('#t2').removeAttr("disabled");
                $('#t3').addClass(" active");
                $('#t3').removeAttr("disabled");
             
                $('#submit1').attr("disabled", "disabled");
                $('#t1').removeClass(" active");
                refreshIncome(document.getElementById("empid").value);
            });

        }
	}
	    function deleteeirow(id) {
				   var empid=document.getElementById("empid").value;
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_emp_income_process', {
                'id': id
            }, function (data) {
                alert('Recourd Delete Successfully');
                refreshIncome(empid);
            });
        }
    }
    function deletederow(id) {
	  var empid=document.getElementById("empid").value;
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_emp_deduct_process', {
                'id': id
            }, function (data) {
                alert('Recourd Delete Successfully');
                refreshDeduct(empid);
            });
        }
    }
	    
    function clearincome() {
        $('#calterror').html("");
        $('#stderror').html("");
        $('#incoerror').html("");
        $('#inrerror').html("");
    }
	function refreshconutIncome(id){

        $.post('/display_emp_income_totalcont',{
            'id':id
        },function(data){

            $("#insaltotal").html(data);
            $("#insaltotal").show();
        });
    }
   function saveIncome(){
       clearincome();
       var empid=document.getElementById("empid").value;
       var caltype=document.getElementById("caltype").value;
       var stdamt=document.getElementById("stdamt").value;
       var incomeid=document.getElementById("incomeid").value;
       var inremark=document.getElementById("inremark").value;
       var letters = /^[A-Za-z]+$/;
       var amt=stdamt.match(letters);

       if(incomeid=='0') {
           $('#incoerror').html("Please Select the Income");
           $('#incoerror').show();
           document.getElementById("caltype").focus();
           $("#success").hide();
       }
       else if(caltype=='0') {
           $('#calterror').html("Please Select the Calculation Type");
           $('#calterror').show();
           document.getElementById("caltype").focus();
           $("#success").hide();
       }
       else if(stdamt=='') {
           $('#stderror').html("Please Enter the STD Amount");
           $('#stderror').show();
           document.getElementById("stdamt").focus();
           $("#success").hide();

       }
       else if(amt!=null)
       {
           $('#stderror').html("Please Enter the valid characters STD Amount ");
           $('#stderror').show();
           document.getElementById("stdamt").focus();
           $("#success").hide();
       }
       else {
           $.post('/employee_income_process',{
               'empid':empid,
               'caltype':caltype,
               'incomeid':incomeid,
               'inremark':inremark,
               'stdamt':stdamt
           },function(data){
			   refreshconutIncome(empid);
               $('#form2').trigger('reset');
               $("#success2").html("Record Insert Successfully!");
               $("#success2").show();
			  // $("#tab2").hide();
            //    $('#tab3').show();
             //   $('#t3').addClass(" active");
             //   $('#t3').removeAttr("disabled");
             //   $('#t2').removeClass(" active");
              //  $('#submit2').attr("disabled", "disabled");
               refreshIncome(empid);
			    refreshDeduct(empid);
           });
       }
   }
   function refreshIncome(id){
        var view=1;
        $.post('/display_emp_income_details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempIncome").html(data);
            $("#detailsempIncome").show();
        });
    }
       
 
    function cleardeduct() {
        $('#destiderror').html("");
        $('#dectyerror').html("");
        $('#destderror').html("");
        $('#destdrrerror').html("");
    }
 function saveDeduct(){
        cleardeduct();
        var empid=document.getElementById("empid").value;
        var decaltype=document.getElementById("decaltype").value;
        var destdamt=document.getElementById("destdamt").value;
        var destid=document.getElementById("destid").value;
        var destdremark=document.getElementById("destdremark").value;
        var letters = /^[A-Za-z]+$/;
        var amt= destdamt.match(letters);
        if(destid=='0') {
            $('#destiderror').html("Please Enter Select Deduction");
            $('#destiderror').show();
            document.getElementById("destid").focus();
            $("#success").hide();
        }
        else if(decaltype=='0') {
            $('#dectyerror').html("Please Enter the Calculation Type");
            $('#dectyerror').show();
            document.getElementById("decaltype").focus();
            $("#success").hide();
        }
        else if(destdamt=='') {
            $('#destderror').html("Please Enter the STD Amt");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();
        }
        else if(amt!=null)
        {
            $('#destderror').html("Please Enter the valid characters STD Amount ");
            $('#destderror').show();
            document.getElementById("destdamt").focus();
            $("#success").hide();

        }
        else {
            $.post('/employee_deduct_process',{
                'empid':empid,
                'decaltype':decaltype,
                'destdremark':destdremark,
                'destid':destid,
                'destdamt':destdamt
            },function(data){
                $("#success3").html("Record Inserted Successfully!");
                $("#success3").show();
			//	   $("#tab3").hide();
              //  $('#tab1').show();
            //    $('#t1').addClass("active");
              //  $('#t1').removeAttr("disabled");
            //    $('#t3').removeClass("active");
             //   $('#submit3').attr("disabled", "disabled");
                refreshLeave(empid);
                refreshDeduct(empid);
            });
        }

    }
    

    function refreshDeduct(id){
        var view=1;
        $.post('/display_emp_deduct_details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempDeduct").html(data);
            $("#detailsempDeduct").show();

        });
    }

    function clearleave() {
       
        $('#oberror').html("");
    }
 function saveLeave(){
        clearleave();
        var empid=document.getElementById("empid").value;
        var ob=document.getElementById("ob").value;
        var lt=document.getElementById("lt").value;
        var lfdate=document.getElementById("lfdate").value;
        var ltdate=document.getElementById("ltdate").value;


        if(ob=='') {
            $('#oberror').html("Please Enter the OB");
            $('#oberror').show();
            document.getElementById("ob").focus();
            $("#success4").hide();
        }
          else{
            $.post('/employee_leave_process',{
                'ob':ob,
                'lfdate':lfdate,
                'lt':lt,
                'empid':empid,
                'ltdate':ltdate
            },function(data){
                refreshLeave(document.getElementById("empid").value);
                //$('#tab4').hide();
                $('#tab5').show();
                $('#t5').addClass(" active");
                $('#t5').removeAttr("disabled");
                //$('#t4').removeClass(" active");
                $('#submit4').attr("disabled", "disabled");
                refreshLeave(document.getElementById("empid").value);
                refreshAdvances(document.getElementById("empid").value);
            });
        }

    }
	
    function refreshLeave(id){
        var view=1;
        $.post('/display_emp_leave_details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempLeave").html(data);
            $("#detailsempLeave").show();

        });
    }

    function clearadnavcen() {
        $('#advamterror').html("");
        $('#advinserror').html("");
    }
    function refreshAdvances(id){
        var view=1;
        $.post('/display_emp_advances_details',{
            'id':id,
            'view':view
        },function(data){
            $("#detailsempAdvances").html(data);
            $("#detailsempAdvances").show();

        });
    }
    function deleteadrow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_emp_advances_process', {
                'id': id
            },function(data){
                refreshAdvances(document.getElementById("empid").value);
                alert('Recourd Delete Successfully');
            });
        }
    }
    function saveAdnavcen(){
        clearadnavcen();
        var advamt=document.getElementById("advamt").value;
        var empid1=document.getElementById("empid").value;
        var advins=document.getElementById("advins").value;
        var advtype=document.getElementById("advtype").value;
        var advdate=document.getElementById("advdate").value;
        if(advamt=='') {
            $('#advamterror').html("Please Enter the Advance Amount");
            $('#advamterror').show();
            document.getElementById("advamt").focus();
            $("#success").hide();
        }
        else if(advins=='') {
            $('#advinserror').html("Please Enter the Advance Installment");
            $('#advinserror').show();
            document.getElementById("advins").focus();
            $("#success").hide();
        }
        else {
            $.post('/employee_advances_process',{
                'advamt':advamt,
                'empid':empid1,
                'advdate':advdate,
                'advtype':advtype,
                'advins':advins
            },function(data){
                refreshAdvances(document.getElementById("empid").value);
                alert("finished");
                $('#submit5').attr("disabled", "disabled");

            });
        }
	}

	</script>
<!--footer end -->
<div id="test"></div>
</body>

</html>