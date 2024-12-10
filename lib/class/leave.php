<?php
class leave{
public $connection;

public function __construct(){	
//include("../config/conn.php");
include("../lib/connection/conn.php");

$this->connection = new PDO('mysql:host='.$config['DBHOST'].';dbname='.$config['DBNAME'],$config['DBUSER'],$config['DBPASS'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
/******************************* for opening balance start ****************************/

/// for get leave of perticular date
public function getCalculated($calculationfrm,$calculationto,$emp){
	//echo $calculationfrm."=".$calculationto."=".$emp;
	 $sql ="select sum(present) as present from hist_days where emp_id =:emp and sal_month between :calfrm and :calto";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('calfrm'=>$calculationfrm,'calto'=>$calculationto,'emp'=>$emp));
	$res = $stmt->fetch();
	return $res['present'];
}
public function getCalculated_curr($calculationfrm,$calculationto,$emp){
	//echo $calculationfrm."=".$calculationto."=".$emp;
	 $sql ="select sum(present) as present from tran_days where emp_id =:emp and sal_month between :calfrm and :calto";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('calfrm'=>$calculationfrm,'calto'=>$calculationto,'emp'=>$emp));
	$res = $stmt->fetch();
	return $res['present'];
}

public function checkLeave($clintid,$empid,$leave_type,$frdt,$todt){
	//echo $clintid."=".$empid."=".$leave_type."=".$calculationfrm."=".$calculationto;
	 $sql1 = "select * from emp_leave where client_id =$clintid and leave_type='$leave_type' and emp_id='$empid'";
	 $sql = "select * from emp_leave where client_id =:client and leave_type=:type and emp_id=:emp and 	from_date<=:frm and 	to_date>=:to";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'type'=>$leave_type,'emp'=> $empid,'frm'=>$frdt,'to'=>$todt));	
	
	return $stmt;
}
public function checkLeaveDetail($clintid,$empid,$leave_type){
	//echo $clintid."=".$empid."=".$leave_type."=".$calculationfrm."=".$calculationto;
	 
	 $sql = "select * from emp_leave where client_id =:client and leave_type=:type and emp_id=:emp";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'type'=>$leave_type,'emp'=> $empid));
	$row = $stmt->fetch();	
	return $row;
}
public function checkLeaveFrToDate($clintid,$emp,$empid,$leave_type,$frdt,$todt){
	//echo $clintid."=".$emp."=".$empid."=".$leave_type."=".$calculationfrm."=".$calculationto;
	$sql = "select * from emp_leave where client_id =:client and from_date >=:calfrm and to_date<=:calto and leave_type=:type and emp_id=:emp";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'calfrm'=>$frdt,'calto'=>$todt,'type'=>$leave_type,'emp'=> $empid));	
	return $stmt;
}
public function insertLeave($clintid,$empids,$leave_type,$frdt,$todt,$calculationfrm,$calculationto,$granted,$calculated,$carriedforword,$ob,$compid,$user){
	//echo $clintid."=".$empids."=".$leave_type."=".$frdt."=".$todt."=".$calculationfrm."=".$calculationto."=".$granted."=".$calculated."=".$carriedforword."=".$ob."=".$compid."=".$user."<br>";
	 $sql = "insert into emp_leave(comp_id,user_id,emp_id,client_id,from_date,to_date,calculated_to,calculated_from,leave_type,granted,carried_forward,calculated,ob,db_adddate) values(:comp,:user,:emp,:client,:frmdt,:todt,:calcuto,:calfrm,:type,:grant,:carfrd,:calcult,:ob,now())";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'frmdt'=>$frdt,'todt'=>$todt,'type'=>$leave_type,'emp'=> $empids,'calfrm'=>$calculationfrm,'calcuto'=>$calculationto,'grant'=>$granted,'calcult'=>$calculated,'carfrd'=>$carriedforword,'comp'=>$compid,'user'=>$user,'ob'=>$ob));	
	return $stmt;
}
public function updateLeave($clintid,$empids,$leave_type,$frdt,$todt,$calculationfrm,$calculationto,$granted,$calculated,$carriedforword,$ob,$compid,$user){
	//echo $clintid."=".$empids."=".$leave_type."=".$frdt."=".$todt."=".$calculationfrm."=".$calculationto."=".$granted."=".$calculated."=".$carriedforword."=".$ob."=".$compid."=".$user."<br>";
	$sql = "update emp_leave set comp_id=:comp,user_id=:user,calculated_to=:calcuto,calculated_from=:calfrm,leave_type=:type,granted=:grant,carried_forward=:carfrd,calculated=:calcult,ob=:ob,db_update=now() where emp_id=:emp and client_id=:client and from_date=:frmdt and to_date=:todt";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'frmdt'=>$frdt,'todt'=>$todt,'type'=>$leave_type,'emp'=> $empids,'calfrm'=>$calculationfrm,'calcuto'=>$calculationto,'grant'=>$granted,'calcult'=>$calculated,'carfrd'=>$carriedforword,'comp'=>$compid,'user'=>$user,'ob'=>$ob));	
	return $stmt;
}
/******************************* for opening balance end ****************************/
/******************************* for encashment start ****************************/
function getOpeningTypeDate($client,$leavetype){
	$sql = "select from_date,to_date from emp_leave where client_id=:client and leave_type=:type";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$client,'type'=>$leavetype));
	$row = $stmt->fetch();
	return $row;
}

/* function getOB($emp,$clintid,$leave_type,$frdt,$todt){
	$sql = "select ob from emp_leave where client_id=:client and leave_type=:type and emp_id=:emp and from_date=:frdt and to_date=:todt order by leave_id desc limit 1 ";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'type'=>$leave_type,'emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt));
	$row = $stmt->fetch();
	if($row['ob'] ==""){
	$ob = 0;
	}else{
		$ob = $row['ob'];
	}
	return $ob;
}
 */
function getOB($emp,$clintid,$leave_type,$frdt,$todt){
	 $sql = "select cb from leave_details where client_id=:client and leave_type=:type and emp_id=:emp  order by to_date desc limit 1 ";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'type'=>$leave_type,'emp'=>$emp));
	$row = $stmt->fetch();
	if($row['cb'] ==""){
	$ob = 0;
	}else{
		$ob = $row['cb'];
	}
	return $ob;
}

function getDetailsFromLDays($emp,$clintid,$leave_type,$frdt,$todt){
	//echo $emp."=".$clintid."=".$leave_type."=".$frdt."=".$todt;
	$type =$leave_type;
	$type1="";
	if($type=="4" || $type=="1"){
		$type1 = 'pl';
	}else if($type=="5" || $type=="2"){
		$type1 = 'cl';
	}else if($type=="6" || $type=="3" ){
		$type1 = 'sl';
	}else{
		$type1 = '';
	}
	if($type1 !=""){
	$sql = "select sum($type1) as sumt,sum(present) as presentsum from hist_days where client_id=:client and emp_id=:emp and sal_month between :frdt and :todt";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt));
	$row = $stmt->fetch();
	}else{
		$row =0;
	}
	return $row;
}
function getDetailsFromLDays_curr($emp,$clintid,$leave_type,$frdt,$todt){
	//echo $emp."=".$clintid."=".$leave_type."=".$frdt."=".$todt;
	$type =$leave_type;
	$type1="";
	if($type=="4" || $type=="1"){
		$type1 = 'pl';
	}else if($type=="5" || $type=="2"){
		$type1 = 'cl';
	}else if($type=="6" || $type=="3" ){
		$type1 = 'sl';
	}else{
		$type1 = '';
	}
	if($type1 !=""){
	 $sql = "select $type1 as sumt,sum(present) as presentsum from tran_days where client_id=:client and emp_id=:emp and sal_month between :frdt and :todt";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt));
	$row = $stmt->fetch();
	}else{
		$row =0;
	}
	return $row;
}
function getleaveCarriedFor($carfrfrm,$carfrto,$empids,$leave_type){//echo $carfrfrm,$carfrto,$empids,$leave_type;
	 $obcf = "SELECT ob FROM emp_leave WHERE from_date=:frdt and to_date=:todt and emp_id =:emp and leave_type=:leavet";
	$stmt = $this->connection->prepare($obcf);
	$stmt->execute(array('emp'=>$empids,'frdt'=>$carfrfrm,'todt'=>$carfrto,'leavet'=>$leave_type));
	$row = $stmt->fetch();
	return $row['ob'];
}
function getEnjoyed($carfrfrm,$carfrto,$empid,$leave_type){
	$sql = "select leave_type_name from mast_leave_type where mast_leave_type_id=:leavet";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('leavet'=>$leave_type));
	$row = $stmt->fetch();
	$leavetypname = strtoupper($row['leave_type_name']);
	if($leavetypname =="EARN LEAVE"){
		$type ="pl";
	}elseif($leavetypname =="CASUAL LEAVE"){
		$type ="cl";
	}elseif($leavetypname =="SICK LEAVE"){
		$type ="sl";
	}
	
	$enjoyed = "SELECT sum($type) as type FROM hist_days WHERE sal_month >=:frdt and sal_month<=:todt and emp_id =:emp ";
	$stmt = $this->connection->prepare($enjoyed);
	$stmt->execute(array('emp'=>$empid,'frdt'=>$carfrfrm,'todt'=>$carfrto));
	$row = $stmt->fetch();
	return $row['type'];
}
function getEncashment($carfrfrm,$carfrto,$leave_type,$emp){
	//for getting encashment
	//echo $encashed1 = "SELECT sum(balanced)-sum(`encashed`) as encashed FROM leave_details WHERE from_date >=$carfrfrm and to_date <=$carfrto and leave_type=$leave_type and emp_id=$emp";
	 $encashed = "SELECT sum(balanced)-sum(`encashed`) as encashed FROM leave_details WHERE from_date >=:frdt and to_date <=:todt and leave_type=:leavet and emp_id=:emp";
	$stmt = $this->connection->prepare($encashed);
	$stmt->execute(array('frdt'=>$carfrfrm,'todt'=>$carfrto,'leavet'=>$leave_type,'emp'=>$emp));
	$row = $stmt->fetch();
	return $row['encashed'];
}
/* function getAmountForEncashmentNoLeftEmp($empid,$salmonth,$compid,$tab,$tab_emp){
//	echo $empid."=".$salmonth."=".$compid;
	  $row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$salmonth' and hi.head_id in (select mast_income_heads_id from mast_income_heads where (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = $compid )";
	
	        $res = mysql_query($row);
			$row = mysql_fetch_assoc($res);
		//	print_r ($row);
		
        return $row;
	
	 ECHO  $row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM :tab hi inner JOIN :tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = :empid and hi.sal_month=:salmonth and hi.head_id in (select mast_income_heads_id from mast_income_heads where (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = :compid )";
	$stmt = $this->connection->prepare($row);
	$stmt->execute(array('empid'=>$empid,'salmonth'=>$salmonth,'compid'=>$compid,'tab'=>$tab,'tab_emp'=>$tab_emp));
	$row = $stmt->fetch();
	$rate = $row['amount'];
	
	return $rate;
} */


function getAmountForEncashmentNoLeftEmp($empid,$salmonth,$compid,$tab,$tab_emp,$clintid,$calc_month){
		
		if ($clintid !=2 && $clintid !=25  && $clintid !=11 ){ 
			$row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$calc_month' and hi.calc_type in (1,2,3,4,5,14)";
			}
		else{
	  
			$row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$salmonth' and hi.head_id in (select mast_income_heads_id from mast_income_heads where (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = $compid )";
			}
        $res = mysql_query($row);
		$row = mysql_fetch_assoc($res);
		return $row;
	
}
 



function getAmountForEncashmentLeftEmp($empid,$frdt,$todt){
 $row = "select sal_month  from hist_employee where emp_id = $empid order by sal_month desc  limit 1";
    $res = mysql_query($row);
	$row = mysql_fetch_assoc($res);
	$sal_month = $row['sal_month'];
	
	$calc_type = "gross";
    if ($calc_type =="gross"){ 
		$row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM hist_income hi inner JOIN hist_employee he on hi.emp_id =he.emp_id and hi.sal_month =  he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$sal_month' and hi.calc_type in (1,2,3,4,5,14)";
		}
	else{
		$row = "SELECT round(sum(hi.amount)/he.payabledays,2) as amount FROM $tab hi inner JOIN $tab_emp he on hi.emp_id =he.emp_id and hi.sal_month =he.sal_month WHERE hi.emp_id = $empid and hi.sal_month='$sal_month' and hi.head_id in (select mast_income_heads_id from mast_income_heads where (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = $compid )";
	  }
    $res = mysql_query($row);
	$row = mysql_fetch_assoc($res);
    return $row;

	}
	
	
	function insertEncashment($emp,$preday,$obday,$earned,$enjoyed,$balance,$encashed,$rate,$amount,$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date){
	 $slq1 ="update emp_leave el  set el.encashed=:encash where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype";
	$stmt1 = $this->connection->prepare($slq1);
	$stmt1->execute(array('encash'=>$encashed,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'emp'=>$emp));
	
	
	 $sql = "insert into  leave_details(emp_id,client_id,bank_id,bankacno,pay_mode,from_date,to_date,leave_type,present,ob,earned,enjoyed,balanced,encashed,rate,amount,db_add_date,comp_id,payment_date,cb) values(:emp,:client,:bankid,:bno,:paymode,:from,:todate,:ltype,:pres,:ob,:earn,:enjoy,:balance,:encash,:rate,:amount,now(),:comp,:payment,:cb)";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('emp'=>$emp,'pres'=>$preday,'ob'=>$obday,'earn'=>$earned,'enjoy'=>$enjoyed,'balance'=>$balance,'encash'=>$encashed,'rate'=>$rate,'amount'=>$amount,'bankid'=>$bid,'bno'=>$bankacno,'paymode'=>$paymode,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'comp'=>$compid,'payment'=>$payment_date,'cb'=>$balance-$encashed));	
	return $stmt;
}
function checkEncashment($frdt,$todt,$emp,$client,$leavetype){ //echo $frdt."=".$todt."=".$emp."=".$client."=".$leavetype;
	 $row = "SELECT * from leave_details where from_date=:frdt and to_date=:todt and emp_id=:emp and client_id=:client and leave_type=:leavetype";
	$stmt = $this->connection->prepare($row);
	$stmt->execute(array('emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt,'client'=>$client,'leavetype'=>$leavetype));
	$row =$stmt->fetch();
	return $row;
}
function checkEncashmentRow($frdt,$todt,$emp,$client,$leavetype){ //echo $frdt."=".$todt."=".$emp."=".$client."=".$leavetype;
	$row = "SELECT * from leave_details where from_date=:frdt and to_date=:todt and emp_id=:emp and client_id=:client and leave_type=:leavetype";
	$stmt = $this->connection->prepare($row);
	$stmt->execute(array('emp'=>$emp,'frdt'=>$frdt,'todt'=>$todt,'client'=>$client,'leavetype'=>$leavetype));
	$row =$stmt->fetch();
	return $row;
	//return $stmt;
}

function deleteleaverecord($id)
{
	$sql = "delete from leave_details where leave_details_id = $id;";
	mysql_query($sql);
	
}

/* 
function updateEncashment($emp,$preday,$obday,$earned,$enjoyed,$balance,$encashed,$rate,$amount,$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid){ //echo $emp."=".$preday."=".$obday."=".$earned."=".$enjoyed."=".$balance."=".$encashed."=".$rate."=".$amount."=".$bid."=".$bankacno."=".$paymode."=".$client."=".$leavetype."=".$frdt."=".$todt;

//echo $slq11 ="update emp_leave el inner join leave_details ld on el.emp_id= ld.emp_id and el.from_date = ld.from_date and el.to_date= ld.to_date and el.leave_type=ld.leave_type set el.encashed=el.encashed-ld.encashed+$encashed where el.emp_id=:emp and el.client_id=$client and el.from_date <=$frdt and el.to_date >=$todt and el.leave_type=$leavetype";
 //$sql = "update leave_details set bank_id=$bid,backacno=$bankacno,pay_mode=$paymode,leave_type=$leavetype,present=$preday,ob=$obday,earned=$earned,enjoyed=$enjoyed,balanced=$balance,encashed=$encashed,rate=$rate,amount=$amount,and db_update_date=$todt where emp_id=$emp and client_id=$client and from_date=$frdt and to_date >=$todt";
	$slq1 ="update emp_leave el inner join leave_details ld on el.emp_id= ld.emp_id and el.from_date = ld.from_date and el.to_date= ld.to_date  and el.leave_type=ld.leave_type set el.encashed=el.encashed-ld.encashed+:encash where el.emp_id=:emp and el.client_id=:client and el.from_date <=:from and el.to_date >=:todate and el.leave_type=:ltype";
	$stmt1 = $this->connection->prepare($slq1);
	$stmt1->execute(array('encash'=>$encashed,'emp'=>$emp,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt));
 
 
	 $sql = "update leave_details set bank_id=:bankid,bankacno=:bno,pay_mode=:paymode,present=:pres,ob=:ob,earned=:earn,enjoyed=:enjoy,balanced=:balance,encashed=:encash,rate=:rate,amount=:amount,comp_id=:comp,db_update_date=now() where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('emp'=>$emp,'pres'=>$preday,'ob'=>$obday,'earn'=>$earned,'enjoy'=>$enjoyed,'balance'=>$balance,'encash'=>$encashed,'rate'=>$rate,'amount'=>$amount,'bankid'=>$bid,'bno'=>$bankacno,'paymode'=>$paymode,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'comp'=>$compid));	
    
	$sql = "update leave_details set cb = balanced- encashed  where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('emp'=>$emp,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt));	
    
	
}
 */




function updateEncashment($emp,$preday,$obday,$earned,$enjoyed,$balance,$encashed,$rate,$amount,$bid,$bankacno,$paymode,$client,$leavetype,$frdt,$todt,$compid,$payment_date)
{ 

//	$slq1 ="update emp_leave el inner join leave_details ld on el.emp_id= ld.emp_id and el.from_date = ld.from_date and el.to_date= ld.to_date  and el.leave_type=ld.leave_type set el.encashed=el.encashed-ld.encashed+:encash where el.emp_id=:emp and el.client_id=:client and el.from_date <=:from and el.to_date >=:todate and el.leave_type=:ltype";
//	$stmt1 = $this->connection->prepare($slq1);
//	$stmt1->execute(array('encash'=>$encashed,'emp'=>$emp,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt));
 
 
	$sql = "update leave_details set bank_id=:bankid,bankacno=:bno,pay_mode=:paymode,present=:pres,ob=:ob,earned=:earn,enjoyed=:enjoy,balanced=:balance,encashed=:encash,rate=:rate,amount=:amount,comp_id=:comp,payment_date =:pay_date, db_update_date=now() where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype ";	
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('emp'=>$emp,'pres'=>$preday,'ob'=>$obday,'earn'=>$earned,'enjoy'=>$enjoyed,'balance'=>$balance,'encash'=>$encashed,'rate'=>$rate,'amount'=>$amount,'bankid'=>$bid,'bno'=>$bankacno,'paymode'=>$paymode,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt,'comp'=>$compid,'pay_date'=>$payment_date));	
 
	$sql = "update leave_details set cb = balanced- encashed  where emp_id=:emp and client_id=:client and from_date <=:from and to_date >=:todate and leave_type=:ltype";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute(array('emp'=>$emp,'client'=>$client,'ltype'=>$leavetype,'from'=>$frdt,'todate'=>$todt));	
    
	
}



 /******************************* for encashment end ****************************/




	/******************************* for check details start ****************************/

	public function getLeaveChequeEmployeeByClientId($clientid,$tab_emp,$frdt1,$to){
		/* $sql1 ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount 
		from $tab_emp te  inner join employee e on e.emp_id = te.emp_id where te.client_id=$clientid  and te.pay_mode = 'C' and te.amount >0 and from_date=$frdt1 and to_date=$to order by te.emp_id";
		*/
		//echo "<br>".$frdt1." ".$to."<br>";
		  $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount,te.payment_date 
		from $tab_emp te  inner join employee e on e.emp_id = te.emp_id where te.client_id=:client  and te.pay_mode = 'C' and te.amount >0 and payment_date>=:from and payment_date<=:to order by te.emp_id"; 		
		//$row= mysql_query($sql);
		//$res = mysql_fetch_assoc($row);
		//return $res;
		
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client'=>$clientid,'from'=>$frdt1,'to'=>$to));
		return $stmt;	
	}
	function insertLeaveCheckDetail($emp,$check_no,$fromdate,$amount,$date1){	
		$sql = "insert into cheque_details(emp_id,check_no,amount,payment_date,date,type,db_addate) values(:emp,:ckno,:amount,:from,:date,'L',now())";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'ckno'=>$check_no,'from'=>$fromdate,'amount'=>$amount,'date'=>$date1));
		return $stmt;
		
	}
	function updateLeaveCheckDetail($emp,$check_no,$payment_date,$amount,$date1){	
		$sql = "update cheque_details set check_no=:ckno,amount=:amount,date=:date,db_update=now() where type='L' and payment_date=:payment_date and emp_id =:emp";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'ckno'=>$check_no,'payment_date'=>$payment_date,'amount'=>$amount,'date'=>$date1));
		return $stmt;		
	}
	
	/*public function checkExistChequeDetails($empid,$salmonth,$type){
		$sql ="select count(*) cnt from cheque_details where emp_id='".$empid."' and sal_month='".$salmonth."' and type='".$type."'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		return $row[0]['cnt'];
	}*/
	public function chkLeaveChequeDetails($emp,$payment_date,$type){		
		$sql="select * from cheque_details where emp_id =:emp and payment_date = :payment_date and type = :type";
	    
		//$row = mysql_fetch_assoc($res);
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'payment_date'=>$payment_date,'type'=>$type));
		$row =$stmt->fetch();
		return $row;	
		
	}
	public function chkLeaveChequeRowDetails($emp,$payment_date,$type){		
		$sql="select * from cheque_details where emp_id =:emp and payment_date = :payment_date  and type = :type";
	    
		//$row = mysql_fetch_assoc($res);
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$emp,'payment_date'=>$payment_date,'type'=>$type));
		return $stmt;	
		
	}
	public function selectCheckPrinting($empid,$client,$payment_date){
		$select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='L' and c.payment_date = '".date('Y-m-d',strtotime($payment_date))."'"; 
		if($empid> 0){
		$select .=" and c.emp_id =:emp";	
		}else{
		$select .=" and e.client_id=:client ";
		}
		
		$stmt = $this->connection->prepare($select);
		if($empid> 0){
		$stmt->bindParam(':emp', $empid);	
		}else{
		$stmt->bindParam(':client', $client);
		}
		
		$stmt->execute();
		return $stmt;	
	}
	public function getLeaveChequeEmployeeByEmpId($empid1,$frdt1,$to){
		$sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount ,te.payment_date 
		from leave_details te inner join employee e on e.emp_id = te.emp_id where te.emp_id = :emp and te.pay_mode = 'C' and te.amount >0 and from_date = :frm and to_date=:to order by te.emp_id"; 
		
		$stmt = $this->connection->prepare($sql);
		$stmt->execute(array('emp'=>$empid1,'frm'=>$frdt1,'to'=>$to));
		return $stmt;
	}
	public function getCheckLeaveListDetailsByPar($fromdate,$todate,$clintid){
		$sql ="select * ,cd.date,cd.check_no
	 from leave_details te inner join employee e on te.emp_id = e.emp_id
	 inner join mast_client mc on te.client_id = mc.mast_client_id 
	 inner join cheque_details cd on cd.emp_id = te.emp_id 
	 where mc.parentid = :client and te.from_date <= :frm and te.to_date >= :to and te.pay_mode = 'C' order by e.pay_mode,te.bankacno";
	 $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client'=>$clintid,'frm'=>$fromdate,'to'=>$todate));
		return $stmt;
	}
	public function getCheckLeaveListDetailsByParentClient($fromdate,$todate,$clintid){
		$sql ="select * ,cd.date,cd.check_no
	 from leave_details te inner join employee e on te.emp_id = e.emp_id
	 inner join mast_client mc on te.client_id = mc.mast_client_id 
	 inner join cheque_details cd on cd.emp_id = te.emp_id 
	 where mc.parentid = :client and te.from_date <= :frm and te.to_date >= :to and te.pay_mode = 'C' order by e.pay_mode,te.bankacno";
	 $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client'=>$clintid,'frm'=>$fromdate,'to'=>$todate));
		return $stmt;
	}
	public function getCheckLeaveListDetailsByClient($fromdate,$todate,$clintid){
		$sql ="select * ,cd.date,cd.check_no
	 from leave_details te inner join employee e on te.emp_id = e.emp_id
	 inner join cheque_details cd on cd.emp_id = te.emp_id
	 where te.client_id = :client and te.from_date <= :frm and te.to_date >= :to and te.pay_mode = 'C'  order by e.pay_mode ,te.bankacno";
	 $stmt = $this->connection->prepare($sql);
		$stmt->execute(array('client'=>$clintid,'frm'=>$fromdate,'to'=>$todate));
		return $stmt;
	}
}