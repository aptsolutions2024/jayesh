<?phperror_reporting(0);session_start();include("../lib/connection/db-config.php");$setCounter = 0;$comp_id=$_SESSION['comp_id'];$user_id=$_SESSION['log_id'];$setExcelName = "employee_income";echo $setSql= "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name` as 'Last Name',emp.`gender` as Gender,emp.`email` as Email, mi.`income_heads_name` as 'Income Head Name',ei.`calc_type` as 'Calculation Type',ei.`std_amt` as 'STD Amount',ei.`remark` as Remark FROM emp_income ei,mast_income_heads mi,employee emp WHERE ei.`head_id`= mi.mast_income_heads_id AND emp.emp_id=ei.emp_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."' ";$setRec = mysql_query($setSql);$setCounter = mysql_num_fields($setRec);$setMainHeader="";$setData="";for ($i = 0; $i < $setCounter; $i++) {    $setMainHeader .= mysql_field_name($setRec, $i)."\t";}while($rec = mysql_fetch_row($setRec))  {    $rowLine = '';    $j=0;    foreach($rec as $value)       {        if(!isset($value) || $value == "")  {            $value = "\t";        }   else  {//It escape all the special charactor, quotes from the data.            $value = strip_tags(str_replace('"', '""', $value));            if($j=='6') {                if ($rec[$j] == '1') {                    $value = "Month's Days - Weeklyoff(26/27)";                }                else if ($rec[$j] == '2') {                    $value = "Month's Days - (30/31)";                }                else if ($rec[$j] == '3') {                    $value = "Consolidated";                }                else if ($rec[$j] == '4') {                    $value = "Hourly Basis";                }                else if ($rec[$j] == '5') {                    $value = "Daily Basis";                }                else if ($rec[$j] == '6') {                    $value = "Quarterly";                }                else if ($rec[$j] == '7') {                    $value = "As per Govt. Rules";                }                else {                    $value = "-";                }            }            $value = '"' . $value . '"' . "\t";        }        $rowLine .= $value;        $j++;    }    $setData .= trim($rowLine)."\n";}$setData = str_replace("\r", "", $setData);if ($setData == "") {    $setData = "\nno matching records found\n";}$setCounter = mysql_num_fields($setRec);//This Header is used to make data download instead of display the dataheader("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=".$setExcelName.".xls");header("Pragma: no-cache");header("Expires: 0");//It will print all the Table row as Excel file row with selected column name as header.echo ucwords($setMainHeader)."\n".$setData."\n";?>