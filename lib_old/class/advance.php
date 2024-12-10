<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
class advance {
public $connection;

public function __construct(){	
//include("../config/conn.php");
include("../lib/connection/conn.php");

$this->connection = new PDO('mysql:host='.$config['DBHOST'].';dbname='.$config['DBNAME'],$config['DBUSER'],$config['DBPASS'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// get setting for site
	public function getAdvanceType($comp_id){
        $sql = "SELECT * FROM mast_advance_type where comp_id=:cid";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array('cid' => $comp_id));
		return $stmt;
    }  
	public function getAdvanceDetailsByEmpId($empid,$advdate){		
		$sql = "SELECT adv_amount,adv_installment,closed_on,emp_advnacen_id,received_amt from emp_advnacen where emp_id =:empid and date=:date";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('empid' => $empid,'date' =>$advdate));
		$row = $stmt->fetch();
		return $row;
	}
	public function checkAdvances($empid,$advtype,$advdate){
		//echo $empid."=".$advtype."=".$advdate."<br>";
		 $sql = "SELECT count(*) as cnt from emp_advnacen where emp_id =:empid and advance_type_id=:type and date=:date";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('empid' => $empid,'type' =>$advtype,'date' =>$advdate));
		$row = $stmt->fetch();
		return $row['cnt'];
	}
	public function insertAdvances($advtype,$advdate,$user,$comp,$empid,$advamt,$advinstall,$closeon){
		$sql = "insert into emp_advnacen (comp_id,emp_id,user_id,date,adv_amount,adv_installment,advance_type_id,closed_on,db_addate) values(:comp,:empid,:user,:date,:advamt,:advinstall,:type,:closeon,now())";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('empid' => $empid,'type' =>$advtype,'date' =>$advdate,'user'=>$user,'comp'=>$comp,'advamt'=>$advamt,'advinstall'=>$advinstall,'closeon'=>$closeon));
		
	}
	public function updateAdvances($advtype,$advdate,$user,$comp,$empid,$advamt,$advinstall,$closeon){
	    echo 'adv:'.$advtype."-advdat-".$advdate."-user:".$user."-comp-".$comp."-emp-".$empid."-emp-".$advamt."-adinst-".$advinstall."closeon".$closeon;
	echo $sql = "update emp_advnacen set comp_id=:comp,user_id=:user,adv_amount=:advamt,adv_installment=:advinstall,closed_on=:closeon,db_addate=now() where emp_id=:empid and date=:date and advance_type_id=:type";
		$stmt = $this->connection->prepare($sql);
        $stmt->execute(array('empid' => $empid,'type' =>$advtype,'date' =>$advdate,'user'=>$user,'comp'=>$comp,'advamt'=>$advamt,'advinstall'=>$advinstall,'closeon'=>$closeon));
	}
}
?>
