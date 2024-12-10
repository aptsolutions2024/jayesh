<?php
session_start();
//error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = $_POST['id'];
  $lmt = $_POST['lmt'];

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


  $result = $userObj->displayemployeeClientlmt($id,$lmt);
  $result2 = $userObj->displayClient($id);
  $count = mysql_num_rows($result);


  $sql ="select td_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
  $head = mysql_query($sql);
  $headrow = mysql_fetch_array($head);
  $head = $headrow['td_string'];
  $exhd = explode(',',$head);
  $j= count($exhd);
			        
 	 ?>


<div style="height: 20px;width: 100%">&nbsp;</div>

<div>
    <br/>

	 
    <div style="min-height:300px; padding-bottom: 20px; overflow-y: scroll;">

    <table width="1170px">
        <tr >
		    <th width="10%">Employee Name</th>
              <?php 
					$pos = strpos($head, "fullpay");
					if ($pos == false) {
						echo "<th style='display:none'>Full Pay</th>";
					} else {
						echo "<th>Full Pay</th>";
					}   
           
					$pos = strpos($head, "halfpay");
					if ($pos == false) {
						echo "<th style='display:none'>Half Pay</th>";
					} else {
						echo "<th>Half Pay</th>";
					}   


					$pos = strpos($head, "leavewop");
					if ($pos == false) {
						echo "<th style='display:none'>Leave WOP</th>";
					} else {
						echo "<th>Leave WOP</th>";
					}   


					$pos = strpos($head, "present");
					if ($pos == false) {
						echo "<th style='display:none'>Present Days</th>";
					} else {
						echo "<th>Present Days</th>";
					}   
					
//absent, weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`
					
					$pos = strpos($head, "weeklyoff");
					if ($pos == false) {
						echo "<th style='display:none'>WeeklyOff</th>";
					} else {
						echo "<th>Weekly Off</th>";
					}   
           
					$pos = strpos($head, "absent");
					if ($pos == false) {
						echo "<th style='display:none'>Abs. Days</th>";
					} else {
						echo "<th>Abs. Days</th>";
					}   


					$pos = strpos($head, "pl");
					if ($pos == false) {
						echo "<th style='display:none'>Paid Leave</th>";
					} else {
						echo "<th>Paid Leave</th>";
					}   


					$pos = strpos($head, "sl");
					if ($pos == false) {
						echo "<th style='display:none'>Sick Leave</th>";
					} else {
						echo "<th>Sick Leave</th>";
					}   
										
					$pos = strpos($head, "cl");
					if ($pos == false) {
						echo "<th style='display:none'>Casual Leave</th>";
					} else {
						echo "<th>Casual Leave</th>";
					}   
           
					$pos = strpos($head, "otherleave");
					if ($pos == false) {
						echo "<th style='display:none'>Oth. Leave</th>";
					} else {
						echo "<th>Oth. Leave</th>";
					}   


					$pos = strpos($head, "paidholiday");
					if ($pos == false) {
						echo "<th style='display:none'>Paid Holi.</th>";
					} else {
						echo "<th>Paid Holi.</th>";
					}   


					$pos = strpos($head, "additional");
					if ($pos == false) {
						echo "<th style='display:none'>Addl. Days</th>";
					} else {
						echo "<th>Addl. Days</th>";
					}   
 					
					$pos = strpos($head, "othours");
					if ($pos == false) {
						echo "<th style='display:none'>OT Hours</th>";
					} else {
						echo "<th>OT Hours</th>";
					}   
           
					$pos = strpos($head, "nightshifts");
					if ($pos == false) {
						echo "<th style='display:none'>Night Shift</th>";
					} else {
						echo "<th>Night Shift</th>";
					}   


					$pos = strpos($head, "extra_inc1");
					if ($pos == false) {
						echo "<th style='display:none'>Extra Inc1</th>";
					} else {
						echo "<th>Extra Inc1</th>";
					}   


					$pos = strpos($head, "extra_inc2");
					if ($pos == false) {
						echo "<th style='display:none'>Reimb.</th>";
					} else {
						echo "<th>Reimb.</th>";
					}   

					$pos = strpos($head, "extra_ded1");
					if ($pos == false) {
						echo "<th style='display:none'>Extra Ded1</th>";
					} else {
						echo "<th>Extra Ded1</th>";
					}   


					$pos = strpos($head, "extra_ded2");
					if ($pos == false) {
						echo "<th style='display:none'>Extra Ded2</th>";
					} else {
						echo "<th>Extra Ded2</th>";
					}   
										
					$pos = strpos($head, "leftdate");
					if ($pos == false) {
						echo "<th style='display:none'>LeavingDate</th>";
					} else {
						echo "<th style='display:none'>LeavingDate</th>";
					}   
           
					$pos = strpos($head, "wagediff");
					if ($pos == false) {
						
						echo "<th style='display:none'>Wage Diff</th>";
					} else {
						echo "<th>Wage Diff</th>";
					}   


					$pos = strpos($head, "Allow_arrears");
					if ($pos == false) {
						echo "<th style='display:none'>Allow. Arr.</th>";
					} else {
						echo "<th>Allow. Arr.</th>";
					}   


					$pos = strpos($head, "Ot_arrears");
					if ($pos == false) {
						echo "<th style='display:none'>OT. Arr.</th>";
					} else {
						echo "<th>OT. Arr.</th>";
					}   
                    
					echo "<th> Invalid </th>";
					?>
					


 </tr>
    <?php
if($count>0) {
    $i=1;

    while($row = mysql_fetch_array($result)) {
        $result1 = $userObj->showEployeedetails($row['emp_id'],$comp_id,$user_id);
        $result2 = $userObj->displayTranday($row['emp_id']);

        ?>
        <input type="hidden" id="emp_id<?php echo $i;?>" name="emp_id[]" value="<?php echo $row['emp_id']; ?>">

        <input type="hidden" id="tr_id<?php echo $i;?>" name="tr_id[]" value="<?php echo $result2['trd_id']; ?>">
        <tr>
	
            <td width="10%"><?php
                echo $result1['first_name'].' '. $result1['middle_name'].' '.$result1['last_name'].'-'.$result1['emp_id'];
            ?></td>
			
			
			<?php
					$pos = strpos($head, "fullpay");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='fp[]' id='fp".$i."'  class='textclass' value='". $result2['fullpay']."' title='Please enter the Full Pay'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='fp[]' id='fp".$i."'  class='textclass' value='". $result2['fullpay']."' title='Please enter the Full Pay'>
								</td>";
					}   

					$pos = strpos($head, "halfpay");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='hp[]' id='hp".$i."'  class='textclass' value='". $result2['halfpay']."' title='Please enter the Half Pay'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='hp[]' id='hp".$i."'  class='textclass' value='". $result2['halfpay']."' title='Please enter the Half Pay'>
								</td>";
					}   
			

					$pos = strpos($head, "leavewop");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='lw[]' id='lw".$i."'  class='textclass' value='". $result2['leavewop']."' title='Please enter the  Leave WOP'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='lw[]' id='lw".$i."'  class='textclass' value='". $result2['leavewop']."' title='Please enter the Leave WOP'>
								</td>";
					}   
					
					$pos = strpos($head, "present");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='pr[]' id='pr".$i."'  class='textclass' value='". $result2['present']."' title='Please enter the  Present Days'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='pr[]' id='pr".$i."'  class='textclass' value='". $result2['present']."' title='Please enter the Present Days'>
								</td>";
					}   
					
					$pos = strpos($head, "weeklyoff");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='wo[]' id='wo".$i."'  class='textclass' value='". $result2['weeklyoff']."' title='Please enter the WeeklyOff'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='wo[]' id='wo".$i."'  class='textclass' value='". $result2['weeklyoff']."' title='Please enter the WeeklyOff'>
								</td>";
					}   
					
					$pos = strpos($head, "absent");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ab[]' id='ab".$i."'  class='textclass' value='". $result2['absent']."' title='Please enter the  Absent Days'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='ab[]' id='ab".$i."'  class='textclass' value='". $result2['absent']."' title='Please enter the Absent Days'>
								</td>";
					}   


					$pos = strpos($head, "pl");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='pl[]' id='pl".$i."'  class='textclass' value='". $result2['pl']."' title='Please enter the  Paid Leave'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='pl[]' id='pl".$i."'  class='textclass' value='". $result2['pl']."' title='Please enter the  Paid Leave'>
								</td>";
					}   
					
					
					$pos = strpos($head, "sl");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='sl[]' id='sl".$i."'  class='textclass' value='". $result2['sl']."' title='Please enter the  Sick Leave'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='sl[]' id='sl".$i."'  class='textclass' value='". $result2['sl']."' title='Please enter the  Sick Leave'>
								</td>";
					}   

					$pos = strpos($head, "cl");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='cl[]' id='cl".$i."'  class='textclass' value='". $result2['cl']."' title='Please enter the  Casual Leave'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='cl[]' id='cl".$i."'  class='textclass' value='". $result2['cl']."' title='Please enter the  Casual Leave'>
								</td>";
					}   

					$pos = strpos($head, "otherleave");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ol[]' id='ol".$i."'  class='textclass' value='". $result2['otherleave']."' title='Please enter the  Other Leave'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='ol[]' id='ol".$i."'  class='textclass' value='". $result2['otherleave']."' title='Please enter the  Other Leave'>
								</td>";
					}   

					$pos = strpos($head, "paidholiday");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ph[]' id='ph".$i."'  class='textclass' value='". $result2['paidholiday']."' title='Please enter the Paid Holiday'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='ph[]' id='ph".$i."'  class='textclass' value='". $result2['paidholiday']."' title='Please enter the   Paid Holiday'>
								</td>";
					}   

					$pos = strpos($head, "additional");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='add[]' id='add".$i."'  class='textclass' value='". $result2['additional']."' title='Please enter the  Additional Days'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='add[]' id='add".$i."'  class='textclass' value='". $result2['additional']."' title='Please enter the Additional Days'>
								</td>";
					}   


					$pos = strpos($head, "othours");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='oh[]' id='oh".$i."'  class='textclass' value='". $result2['othours']."' title='Please enter the  Overtime Hours'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='oh[]' id='oh".$i."'  class='textclass' value='". $result2['othours']."' title='Please enter the Overtime Hours'>
								</td>";
					}   
										
					$pos = strpos($head, "nightshifts");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ns[]' id='ns".$i."'  class='textclass' value='". $result2['nightshifts']."' title='Please enter the  Night Shifts'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='ns[]' id='ns".$i."'  class='textclass' value='". $result2['nightshifts']."' title='Please enter the Night Shifts'>
								</td>";
					}   
					
					$pos = strpos($head, "extra_inc1");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_inc1[]' id='extra_inc1".$i."'  class='textclass' value='". $result2['extra_inc1']."' title='Please enter the  Extra Income1'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='extra_inc1[]' id='extra_inc1".$i."'  class='textclass' value='". $result2['extra_inc1']."' title='Please enter the Extra Income1 '>
								</td>";
					}   
					$pos = strpos($head, "extra_inc2");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_inc2[]' id='extra_inc2".$i."'  class='textclass' value='". $result2['extra_inc2']."' title='Please enter the   Extra Income2 '>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='extra_inc2[]' id='extra_inc2".$i."'  class='textclass' value='". $result2['extra_inc2']."' title='Please enter the  Extra Income2 '>
								</td>";
					}   
					$pos = strpos($head, "extra_ded1");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_ded1[]' id='extra_ded1".$i."'  class='textclass' value='". $result2['extra_ded1']."' title='Please enter the  Extra Deduction1'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='extra_ded1[]' id='extra_ded1".$i."'  class='textclass' value='". $result2['extra_ded1']."' title='Please enter the Extra Deduction 1'>
								</td>";
					}   
					$pos = strpos($head, "extra_ded2");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_ded2[]' id='extra_ded2".$i."'  class='textclass' value='". $result2['extra_ded2']."' title='Please enter the   Extra Deduction 2'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='extra_ded2[]' id='extra_ded2".$i."'  class='textclass' value='". $result2['extra_ded2']."' title='Please enter the  Extra Deduction 2'>
								</td>";
					}   
					$pos = strpos($head, "leftdate");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='leftdate[]' id='leftdate".$i."'  class='textclass' value='". $result2['leftdate']."' title='Please enter the  Left Date'>
								</td>";
					} else {
						
						echo "    <td style='display:none'>
								<input type='text' name='leftdate[]' id='leftdate".$i."'  class='textclass' value='". $result2['leftdate']."' title='Please enter the Left Date'>
								</td>";
					}   


					$pos = strpos($head, "wagediff");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='wagediff[]' id='wagediff".$i."'  class='textclass' value='". $result2['wagediff']."' title='Please enter the  Basic+DA Diff'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='wagediff[]' id='wagediff".$i."'  class='textclass' value='". $result2['wagediff']."' title='Please enter the Basic+DA Diff'>
								</td>";
					}   
					
					$pos = strpos($head, "Allow_arrears");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='Allow_arrears[]' id='Allow_arrears".$i."'  class='textclass' value='". $result2['Allow_arrears']."' title='Please enter the  Allow_arrears'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='Allow_arrears[]' id='Allow_arrears".$i."'  class='textclass' value='". $result2['Allow_arrears']."' title='Please enter the Allow_arrears'>
								</td>";
					}   

					$pos = strpos($head, "Ot_arrears");
					if ($pos == false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='Ot_arrears[]' id='Ot_arrears".$i."'  class='textclass' value='". $result2['Ot_arrears']."' title='Please enter the  Ot_arrears'>
								</td>";
					} else {
						
						echo "    <td >
								<input type='text' name='Ot_arrears[]' id='Ot_arrears".$i."'  class='textclass' value='". $result2['Ot_arrears']."' title='Please enter the Ot_arrears'>
								</td>";
					}   
			
					
						echo "    <td >
								<input type='text' name='invalid[]' id='invalid".$i."'  class='textclass' value='". $result2['invalid']."' title='Please enter the Invalid Days'>
								</td>
								</tr>";

        $i++;
    }
}
else{
    ?>
    <tr class="bgColor3">
        <td colspan="21" class="errorclass" align="center">No Result Fond!</td>

    </tr>
    <?php
}
?>

</table>
</div>
</div>
<?php
if($count>0) { ?>
<div ><br/>
<input type="submit" value="Save" class="btnclass" >
</div>
<?php } ?>
    <br/>


<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('.textclass').tooltip({
            track: true
        });
    });
</script>
<style type="text/css">

    .ui-tooltip {
        padding: 8px;
        position: absolute;
        z-index: 9999;
        max-width: 300px;
        -webkit-box-shadow: 0 0 5px #aaa;
        box-shadow: 0 0 5px #aaa;
        background-color: #fff;
        font-size:10pt;
        border-width: 2px;
    }




</style>