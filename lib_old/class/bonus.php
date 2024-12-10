<?php
class bonus{
public $connection;

public function __construct(){	
//include("../config/conn.php");
include("../lib/connection/conn.php");

$this->connection = new PDO('mysql:host='.$config['DBHOST'].';dbname='.$config['DBNAME'],$config['DBUSER'],$config['DBPASS'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

function getBonusNeftExpParantData($clintid,$desc,$startbon,$endbon){
	/* echo $sql1= "SELECT te.tot_bonus_amt,mc.bankacno as sender_bankacno,mb.ifsc_code,concat(".chr(34).chr(39).chr(34).",te.`bankacno`)as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address',$desc as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM bonus te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id where t3.parentid=$clintid and e.pay_mode = 'N' and te.from_date >= $startbon and te.todate <= $endbon and te.comp_id"; */
	
	  $sql= "SELECT te.tot_bonus_amt,mc.bankacno as sender_bankacno,mb.ifsc_code,concat(".chr(34).chr(39).chr(34).",te.`bankacno`)as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address',:desc as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM bonus te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id where t3.parentid=:client and e.pay_mode = 'N' and te.from_date >= :startd and te.todate <= :endd and te.comp_id"; 
	 $stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'desc'=>$desc,'startd'=>$startbon,'endd'=>$endbon));
	return $stmt;
	 
}function getBonusNeftExpParantDataColumn($clintid,$desc,$startbon,$endbon){
	  $sql= "SELECT te.tot_bonus_amt,mc.bankacno as sender_bankacno,mb.ifsc_code,concat(".chr(34).chr(39).chr(34).",te.`bankacno`)as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address',:desc as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM bonus te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id where t3.parentid=:client and e.pay_mode = 'N' and te.from_date = :startd and te.todate = :endd and te.comp_id"; 
	 $stmt = $this->connection->prepare($sql);
	$stmt->execute(array('client'=>$clintid,'desc'=>$desc,'startd'=>$startbon,'endd'=>$endbon));
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($result);
	return $result;
	 
}
function getBonusNeftExpData($clintid,$desc,$startdate,$enddate,$comp_id,$user_id){
	
	 $setSql= "SELECT te.tot_bonus_amt,te.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.emp_add1,:desc as descri, mc.comp_name as Originator from bonus te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id =:comp AND te.user_id=:user and te.from_date >= :start and te.todate <= :end and te.tot_bonus_amt > 0 and te.pay_mode = 'N' and e.client_id=:client ORDER BY te.bank_id, bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";  
	 $stmt = $this->connection->prepare($setSql);
	$stmt->execute(array('client'=>$clintid,'desc'=>$desc,'start'=>$startdate,'end'=>$enddate,'user'=>$user_id,'comp'=>$comp_id));
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($result);
	return $result;
	 
}
function getBonusNeftExpDataRow($clintid,$desc,$startdate,$enddate,$comp_id,$user_id){
	 $setSql= "SELECT te.tot_bonus_amt,te.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.emp_add1,:desc as descri, mc.comp_name as Originator from bonus te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id =:comp AND te.user_id=:user and te.from_date >= :start and te.todate <= :end and te.tot_bonus_amt > 0 and te.pay_mode = 'N' and e.client_id=:client ORDER BY te.bank_id, bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";  
	 $stmt = $this->connection->prepare($setSql);
	$stmt->execute(array('client'=>$clintid,'desc'=>$desc,'start'=>$startdate,'end'=>$enddate,'user'=>$user_id,'comp'=>$comp_id));	
	//print_r($result);
	return $stmt;	 
}
function getNeftBonusSum($comp_id,$user_id,$bank,$clintid,$startbon,$endbon){
	$sql11 = "select sum(tot_bonus_amt) as bonus_amount from bonus where comp_id =:comp AND user_id=:user AND bank_id=:bank and client_id = :client and from_date >= :start and todate <= :end and pay_mode = 'T'";
	$stmt = $this->connection->prepare($sql11);
	$stmt->execute(array('client'=>$clintid,'start'=>$startbon,'end'=>$endbon,'user'=>$user_id,'bank'=>$bank,'comp'=>$comp_id));
	$row = $stmt->fetch();
	//print_r($result);
	return $row['bonus_amount'];
}
function getNeftBonus($comp_id,$user_id,$bank,$clintid,$startbon,$endbon){
	
	$sql11 = "select te.emp_id,te.tot_bonus_amt,e.first_name,e.middle_name,e.last_name,te.bankacno from bonus te inner join employee e on te.emp_id = e.emp_id  where te.comp_id =:comp AND te.user_id=:user AND te.bank_id=:bank  and te.client_id = :client and te.from_date >= :start and te.todate <= :end and te.tot_bonus_amt > 0 and te.pay_mode = 'T' ORDER BY te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	$stmt = $this->connection->prepare($sql11);
	$stmt->execute(array('client'=>$clintid,'start'=>$startbon,'end'=>$endbon,'user'=>$user_id,'bank'=>$bank,'comp'=>$comp_id));	
	//print_r($result);
	return $stmt;
}
function getNeftBonusAmpuntByEmpId($clintid,$emp,$startbon,$endbon){
	
	$sql11 = "select te.emp_id,te.tot_bonus_amt,e.first_name,e.middle_name,e.last_name,te.bankacno from bonus te inner join employee e on te.emp_id = e.emp_id  where te.comp_id =:comp AND te.user_id=:user AND te.bank_id=:bank  and te.client_id = :client and te.from_date >= :start and te.todate <= :end and te.tot_bonus_amt > 0 and te.pay_mode = 'T' ORDER BY te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	$stmt = $this->connection->prepare($sql11);
	$stmt->execute(array('client'=>$clintid,'start'=>$startbon,'end'=>$endbon,'emp'=>$emp));	
	//print_r($result);
	return $stmt;
}
function createTempTable($tab){
	$sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";
	$stmt = $this->connection->prepare($sql);
	$stmt->execute();
}

}
?>