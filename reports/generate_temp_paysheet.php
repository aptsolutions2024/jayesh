<?php
//print_r($_REQUEST);
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting('E_ALL');
session_start();

//include("../lib/connection/db-config.php");
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$client_id=$_SESSION['clintid'];
$setExcelName = "Paysheet_".$client_id;
include_once ("../lib/class/user-class.php");

$resclt=$userObj->displayClient($client_id);
$cmonth=$resclt['current_month'];

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
	$tab_inc = 'tran_income';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$tab_inc = 'hist_income';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
  }
$tab = "`tab_".$user_id."`";
$row = $userObj->dropTable($tab);
$i = 0;
$days[]=0;
//$userObj->createUserTableForPayslip($tab,$tab_days,$client_id,$comp_id,$user_id,$frdt,$todt,$tab_inc);
$sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";

$rowdays = $userObj->sql_days ($tab_days,$client_id,$comp_id,$user_id,$frdt,$todt);
while($rowtab1 = $rowdays->fetch_assoc()){
	
	if ($rowtab1['present'] >0){$sql=$sql.",`present` float not null";$days[$i]='present';$i++;}
	if ($rowtab1['weeklyoff'] >0){$sql=$sql.",`weeklyoff` float not null";$days[$i]='weeklyoff';$i++;}
	if ($rowtab1['absent'] >0){$sql=$sql.",`absent` float not null";$days[$i]='absent';$i++;}
	if ($rowtab1['paidholiday'] >0){$sql=$sql.",`paidholiday` float not null";$days[$i]='paidholiday';$i++;}
	if ($rowtab1['pl'] >0){$sql=$sql.",`pl` float not null";$days[$i]='pl';$i++;}
	if ($rowtab1['sl'] >0){$sql=$sql.",`sl` float not null";$days[$i]='sl';$i++;}
	if ($rowtab1['cl'] >0){$sql=$sql.",`cl` float not null";$days[$i]='cl';$i++;}
	if ($rowtab1['additional'] >0){$sql=$sql.",`additional` float not null";$days[$i]='additional';$i++;}
	if ($rowtab1['othours'] >0){$sql=$sql.",`othours` float not null";$days[$i]='othours';$i++;}
	if ($rowtab1['nightshifts'] >0){$sql=$sql.",`nightshifts` float not null";$days[$i]='nightshifts';$i++;}
	if ($rowtab1['fullpay'] >0){$sql=$sql.",`fullpay` float not null";$days[$i]='fullpay';$i++;}
	if ($rowtab1['halfpay'] >0){$sql=$sql.",`halfpay` float not null";$days[$i]='halfpay';$i++;}
	if ($rowtab1['leavewop'] >0){$sql=$sql.",`leavewop` float not null";$days[$i]='leavewop';$i++;}
	if ($rowtab1['otherleave'] >0){$sql=$sql.",`otherleave` float not null";$days[$i]='otherleave';$i++;}
	break;
}
$sql=$sql.",`payabledays` float not null";
$rowinc = $userObj->sql_inc ($tab_inc,$tab_emp,$client_id,$comp_id,$user_id,$frdt,$todt);

while($rowtab1 = $rowinc->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
	$sql=$sql.",`std_".strtolower($rowtab1['income_heads_name'])."` float not null";
	
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
    $std_inhdar[$inhd] = "STD_".$rowtab1['income_heads_name'];

	$inhd++;
}
$sql=$sql.",`gross_salary` float not null";

$rowded = $userObj->sql_ded ($tab_empded,$tab_emp,$client_id,$comp_id,$user_id,$frdt,$todt);

while($rowtabd1 = $rowded->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	
	$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
}


$rowadv = $userObj->sql_adv ($tab_adv,$client_id,$comp_id,$user_id,$frdt,$todt);
while($rowtaba1 = $rowadv->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtaba1['advance_type_name'])."` float not null";
	
	$advhdar[$advhd] = $rowtaba1['advance_type_name'];
	$advhd++;
}



$sql=$sql.",`tot_deduct` float not null";
$sql=$sql.",`netsalary` float not null";

$sql=$sql.",`bankname` varchar(150) not null";

$sql=$sql.",`deptname` varchar(100) not null";
$sql=$sql.",`designation` varchar(100) not null";
$sql=$sql.",`qualification` varchar(100) not null";
$sql=$sql.",`location` varchar(100) not null";
$sql=$sql.",`cc_code` varchar(100) not null";
$sql = $sql." ) ENGINE = InnoDB";

$row = $userObj->creaTabPayslip($sql);


while($rowtab1 = $rowdays->fetch_assoc()){
	
	if ($rowtab1['present'] >0){$days[$i]='present';$i++;}
	if ($rowtab1['weeklyoff'] >0){$days[$i]='weeklyoff';$i++;}
	if ($rowtab1['absent'] >0){$days[$i]='absent';$i++;}
	if ($rowtab1['paidholiday'] >0){$days[$i]='paidholiday';$i++;}
	if ($rowtab1['pl'] >0){$days[$i]='pl';$i++;}
	if ($rowtab1['sl'] >0){$days[$i]='sl';$i++;}
	if ($rowtab1['cl'] >0){$days[$i]='cl';$i++;}
	if ($rowtab1['additional'] >0){$days[$i]='additional';$i++;}
	if ($rowtab1['othours'] >0){$days[$i]='othours';$i++;}
	if ($rowtab1['nightshifts'] >0){$days[$i]='nightshifts';$i++;}
	if ($rowtab1['fullpay'] >0){$days[$i]='fullpay';$i++;}
	if ($rowtab1['halfpay'] >0){$days[$i]='halfpay';$i++;}
	if ($rowtab1['leavewop'] >0){$days[$i]='leavewop';$i++;}
	if ($rowtab1['otherleave'] >0){$days[$i]='otherleave';$i++;}
	break;
}



$row = $userObj->insPayslipTable($tab,$tab_emp,$client_id,$comp_id,$user_id,$frdt,$todt);
$row = $userObj->updClientPayslip($tab);
$row = $userObj->updDesgPayslip($tab);
$row = $userObj->updDeptPayslip($tab);
$row = $userObj->updQualPayslip($tab);
$row = $userObj->updLocPayslip($tab);
$row = $userObj->updPaycodePayslip($tab);
$row = $userObj->updBankPayslip($tab);

$row = $userObj->updEmployeePayslip($tab);



//Tran/hist days $days
$sql= "update $tab t inner join $tab_days td on t.emp_id=td.emp_id and t.sal_month= td.sal_month set ";
for ($j =0;$j<$i;$j++){
	$sql = $sql. "t.`".$days[$j]."` = td.`".$days[$j]."`,";
}
$sql = $sql." t.present= td.present where td.client_id = '$client_id' and td.comp_id = '$comp_id' and td.user_id = '$user_id' and td.sal_month >= '$frdt' and td.sal_month <= '$todt'";

$row=$userObj->doAsDirected($sql);





//tran_hist income
$rowinc = $userObj->sql_inc ($tab_inc,$tab_emp,$client_id,$comp_id,$user_id,$frdt,$todt);

while($rowtab1 = $rowinc->fetch_assoc()){
    
       $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.amount,ti.std_amt,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount,t.`std_".strtolower($rowtab1['income_heads_name'])."` = inc.std_amt";
        $row = $userObj->doAsDirected($sql);
}

    
    

////tran_hist deduction updation
$rowded = $userObj->sql_ded ($tab_empded,$tab_emp,$client_id,$comp_id,$user_id,$frdt,$todt);
while($rowtab1 = $rowded->fetch_assoc()){

	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtab1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtab1['deduct_heads_name'])."` = ded.amount";
	
        $row = $userObj->doAsDirected($sql);
 
}
    
////tran_hist advance updation
$rowadv = $userObj->sql_adv ($tab_adv,$client_id,$comp_id,$user_id,$frdt,$todt);
while($rowtab1 = $rowadv->fetch_assoc()){
	
	 $sql = "update $tab t inner join (select tadv.emp_id,tadv.sal_month,tadv.head_id,tadv.amount,mah.advance_type_name  as head_name from $tab_adv  tadv inner join mast_advance_type  mah on tadv.head_id=mah.mast_advance_type_id     where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' and  mah.advance_type_name  like '%".strtolower($rowtaba1['advance_type_name'])."%'  ) adv on t.emp_id = adv.emp_id and t.sal_month = adv.sal_month set t.`".strtolower($rowtab1['advance_type_name'])."` = adv.amount";
        $row = $userObj->doAsDirected($sql);
      
}


?>

