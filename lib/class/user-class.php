<?php
error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
class user extends DbConfig{
   //$bdd = new db();
// Create connection
//$con = new mysqli($servername, $username, $password, $dbname);
    public function __construct()
    {
        parent::__construct();
    }

     /*  use for login Starts  */
    function login($user,$pass){ 
	      $sql = "select * from login_master where username ='".$user."' AND userpass='".$pass."' "; 
		$res = $this->connection->query($sql);
		 $row = $res->fetch_assoc();
	        return $row;
     
	}
    /*  use for login end  */


	  /* use for display Cal type Starts  */
    function showCalType($dbname){
        $sql = "select * from $dbname";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display Cal type end  */
	
	
    /*  use for show all clients Starts  
	function showClient(){
       $sql = "select * from mast_client ORDER BY `mast_client_id` DESC";
		$res = $this->connection->query($sql);
        return $res;
	}
      use for show all clients end  */

    /*  use for show all clients as comp and user wise Starts  */
    function showClient1($comp_id,$user_id){
        $sql = "select * from mast_client where comp_id ='".$comp_id."' AND user_id='".$user_id."'  ORDER BY `mast_client_id` DESC";
       $res = $this->connection->query($sql);
		//$row = $res->fetch_assoc();
		//$res = $this->connection->query($sql);
        return $res;
	}
    /*  use for show all clients as comp and user wise end  */

    /*  use for display all clients Starts  */
	function displayClient($cid){
       $sql = "select * from mast_client WHERE mast_client_id='".$cid."'";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        return $row;
      
	}
    /*  use for display all clients end  */

    /* use for display client as client Id  Starts  */
    function displayemployeeClient($cid){
     $sql = "select * from employee WHERE client_id='".$cid."' AND job_status!='L'";
     $res = $this->connection->query($sql);
     return $res;
    }
    /* use for display client as client Id  end  */

    /* use for display client as client Id  Starts  */
    function displayemployeeClientlmt($cid,$lmt){
      $sql = "select * from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id, first_name,middle_name,last_name limit $lmt";
     $res = $this->connection->query($sql);
     return $res;
    }
    /* use for display client as client Id  end  */

    /* use for update client as client Id Starts  */
    function updateClient($cid,$name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$sc,$email,$comp_id,$user_id){
        $sql = "UPDATE `mast_client` SET `comp_id`='".$comp_id."',`user_id`='".$user_id."',`email`='".$email."',`ser_charges`='".$sc."',`client_name`='".$name."',`client_add1`='".$add1."',`esicode`='".$esicode."',`pfcode`='".$pfcode."',`tanno`='".$tanno."',`panno`='".$panno."',`gstno`='".$gstno."',`current_month`='".$mont."',`parentId`='".$parent."',`db_update`=NOW()  WHERE mast_client_id='".$cid."' and user_id = '".$user_id."' and comp_id = '".$comp_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update client as client Id Starts  */

    /* use for insert client Starts  */
	function insertClient($name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$comp_id,$user_id,$sc,$email){
              $sql = "INSERT INTO `mast_client`(`client_name`, `client_add1`,`esicode`, `pfcode`, `tanno`, `panno`, `gstno`, `current_month`,`parentId`, `user_id`,`comp_id`,`email`, `ser_charges`,`db_adddate`, `db_update`) VALUES('".$name."','".$add1."','".$esicode."','".$pfcode."','".$tanno."','".$panno."','".$gstno."','".$mont."','".$parent."','".$user_id."','".$comp_id."','".$email."','".$sc."',NOW(),NOW())";
	          $res = $this->connection->query($sql);
            return $res;
	}
    /* use for insert client end  */

    /* use for delete client Starts  */
	function deleteClient($cid){
            //$sql = "DELETE FROM `mast_client` WHERE mast_client_id='".$cid."' ";
            $sql ='';
		    $res = $this->connection->query($sql);
            return $res;
    }
    /* use for delete client end */

    /* use for insert emp Starts  */
    function insertEmployee($fname,$mname,$lname,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$email,$phoneno,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id){
          $sql = "INSERT INTO `employee`(`first_name`, `middle_name`, `last_name`, `gender`, `bdate`, `joindate`, `leftdate`,`incrementdate`, `permanentdate`, `pfdate`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`,  `paycode_id`, `bankacno`, `middlename_relation`, `prnsrno`, `esino`, `pfno`, `esistatus`, `adharno`, `panno`,`driving_lic_no`, `uan`, `voter_id`, `job_status`, `email`,`emp_add1`,`mobile_no`,  `due_date`, `ticket_no`, `comp_ticket_no`, `married_status`, `pay_mode`, `nationality`, `handicap`,`pin_code`,`comp_id`,`user_id`,`db_adddate`, `db_update`) VALUES ('".$fname."','".$mname."','".$lname."','".$gentype."','".$bdate."','".$joindate."','".$lodate."','".$incdate."','".$perdate."','".$pfdate."','".$client."','".$design."','".$depart."','".$qualifi."','".$bank."','".$location."','".$paycid."','".$bankacno."','".$namerel."','".$prnsrno."','".$esicode."','".$pfcode."','".$esistatus."','".$adhaar."','".$panno."','".$drilno."','".$uan."','".$votid."','".$jobstatus."','".$email."','".$add1."','".$phoneno."','".$duedate."','".$ticket_no."','".$comp_ticket_no."','".$married_status."','".$pay_mode."','".$nation."','".$handicap."','".$pin_code."','".$comp_id."','".$user_id."',NOW(),NOW())"; 
         $res = $this->connection->query($sql);
         $count = mysqli_insert_id($this->connection);
        return $count;
    }
    /* use for insert emp end  */

    /*   Starts  
    function insertEmployeebk($techstype,$gentype,$bdate,$joindate,$add1,$add2,$prnsrno,$esicode,$pfcode,$tanno,$panno,$gstno){
         $sql = "INSERT INTO `employee`( `teaching_staff`, `gender`, `bdate`, `joindate`, `emp_add1`, `emp_add2`, `prnsrno`, `esicode`, `pfcode`, `tanno`, `panno`, `gstno`, `db_adddate`, `db_update`) VALUES ('".$techstype."','".$gentype."','".$bdate."','".$joindate."','".$add1."','".$add2."','".$prnsrno."','".$esicode."','".$pfcode."','".$tanno."','".$panno."','".$gstno."',Now(),Now())";
        $res = $this->connection->query($sql);
       $count = mysql_insert_id();
        return $count;
    }*/

    /* use for insert emp income Starts  */
    function insertEmployeeincome($empid,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id){
         $sql1 = "select * from `emp_income` WHERE emp_id='".$empid."' AND head_id='".$incomeid."' ";
         $res1 = $this->connection->query($sql1);
         $rows = $res1->fetch_assoc();
         $rowsdata=mysqli_num_rows($res1);
       if($rowsdata=='0') {
            $sql = "INSERT INTO `emp_income`(`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`,`comp_id`,`user_id`, `db_addate`, `db_update`) VALUES ('".$empid."','".$incomeid."','".$caltype."','".$stdamt."','".$inremark."','".$comp_id."','".$user_id."',Now(),Now())";
            $res = $this->connection->query($sql);
       }else{
            $sql = "UPDATE `emp_income` SET calc_type='".$caltype."',std_amt='".$stdamt."',remark='".$inremark."',db_update=NOW() WHERE emp_income_id='".$rows['emp_income_id']."'";
            $res = $this->connection->query($sql);
       }
        return $res;
    }

    /* use for insert emp income end  */

    /* use for insert emp Duduct Starts  */
    function insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank){
        $sql1 = "select * from `emp_deduct` WHERE emp_id='".$empid."' AND head_id='".$destid."' ";
        $res1 = $this->connection->query($sql1);
        $rows = $res1->fetch_assoc();
        $rowsdata=mysqli_num_rows($res1);
        if($rowsdata=='0') {
    		  $sql = "INSERT INTO `emp_deduct`(`emp_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `comp_id`,`user_id`,bank_id, `db_addate`, `db_update`) VALUES ('".$empid."','".$destid."','".$decaltype."','".$destdamt."','".$destdremark."','".$comp_id."','".$user_id."','".$selbank."',Now(),Now())";
                    $res = $this->connection->query($sql);
        }else{
             $sql = "UPDATE `emp_deduct` SET calc_type='".$decaltype."',std_amt='".$destdamt."',bank_id='".$selbank."',remark='".$destdremark."',db_update=NOW() WHERE  emp_deduct_id='".$rows['emp_deduct_id']."'";
            $res = $this->connection->query($sql);
        }
        return $res;
    }
    /* use for insert emp Duduct end */

    /* use for insert emp leave Starts  */
   function insertEmployeeleave($empid,$ob,$leayear,$comp_id,$user_id,$ason,$lt){
       $sql1 = "select * from `emp_leave` WHERE emp_id='".$empid."' AND leave_type_id='".$lt."' AND as_on='".$ason."' ";
       $res1 = $this->connection->query($sql1);
       $rows = $res1->fetch_assoc();
       $rowsdata=mysqli_num_rows($res1);
       if($rowsdata=='0') {
           $sql = "INSERT INTO `emp_leave`(`emp_id`, `year`, `ob`, `comp_id`,`user_id`,`leave_type_id`, `as_on`, `db_adddate`, `db_update`) VALUES  ('" . $empid . "','" . $leayear . "','" . $ob . "','".$comp_id."','".$user_id."','".$lt."','".$ason."',Now(),Now())";
           $res = $this->connection->query($sql);
       }
       else{
           $sql = "UPDATE `emp_leave` SET `year`='".$leayear."', `ob`='".$ob."',db_update=NOW() WHERE emp_leave_id='".$rows['emp_leave_id']."'";
           $res = $this->connection->query($sql);
       }
        return $res;
    }
    /* use for insert emp leave end  */

    /* use for insert emp advances Starts  */
    function insertEmployeeadvances($empid,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype){
      $sql1 = "select * from `emp_advnacen` WHERE emp_id='".$empid."' AND advance_type_id='".$advtype."' AND date='".$advdate."' ";
        $res1 = $this->connection->query($sql1);
        $rows = $res1->fetch_assoc();
        $rowsdata=mysqli_num_rows($res1);
        if($rowsdata=='0') {
          $sql = "INSERT INTO `emp_advnacen`(`emp_id`,`date`,`advance_type_id`,`adv_amount`,`adv_installment`,`comp_id`,`user_id`, `db_addate`, `db_update`) VALUES ('".$empid."','".$advdate."','".$advtype."','".$advamt."','".$advins."','".$comp_id."','".$user_id."',Now(),Now())";
             $res = $this->connection->query($sql);
      }
        else{
            $sql = "UPDATE emp_advnacen SET adv_amount='".$advamt."', adv_installment='".$advins."',db_update=NOW() WHERE emp_advnacen_id='".$rows['emp_advnacen_id']."'";
            $res = $this->connection->query($sql);
        }
        return $res;
    }
    /* use for insert emp advances end */

    /* use for display emp with compid and userid Starts  */
    function showEmployee($comp_id,$user_id){
        $sql = "select * from employee where comp_id ='".$comp_id."' AND user_id='".$user_id."'   ORDER BY `emp_id` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp with compid and userid end  */

    /* use for display emp with empid Starts  */
    function showEployeedetails($id,$comp_id,$user_id){
       $sql = "select * from employee WHERE emp_id='".$id."' and comp_id ='".$comp_id."' and user_id = '".$user_id."'";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        //$row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp with empid end  */

    /* function show_tab_Eployeedetails($tab,$id,$sal_month,$comp_id,$user_id){
       $sql = "select * from $tab WHERE emp_id='".$id."' and sal_month = '".$sal_month."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }*/


    /* use for display emp income with empid Starts  */
   function showEployeeincome($id,$comp_id,$user_id ){
        $sql = "select * from `emp_income` WHERE emp_id='".$id."' and comp_id ='".$comp_id."' and user_id = '".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp income with empid end */

    /* use for display emp deduct with empid Starts  */
    function showEployeededuct($id,$comp_id,$user_id){
        $sql = "select * from `emp_deduct` WHERE emp_id='".$id."' and comp_id ='".$comp_id."' and user_id = '".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp deduct with empid end  */

    /* use for display emp leave with empid Starts  */
    function showEployeeleave($id,$comp_id,$user_id){
      $sql = "select * from `emp_leave` WHERE emp_id='".$id."' and comp_id ='".$comp_id."' and user_id = '".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp leave with empid end  */

    /* use for display emp adnavce with empid Starts  */
    function showEployeeadnavcen($id,$comp_id,$user_id){
      $sql = "select * from `emp_advnacen` WHERE emp_id='".$id."' and comp_id ='".$comp_id."' and user_id = '".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp adnavce with empid end */

    /* use for update emp with empid Starts  */
    function updateEmployee($id,$fname,$mname,$lname,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$emailtext,$phone,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id){
     $sql = "UPDATE `employee` SET email='".$emailtext."',`first_name`='".$fname."',`middle_name`='".$mname."',`last_name`='".$lname."',`gender`='".$gentype."',`bdate`='".$bdate."',`joindate`='".$joindate."',`leftdate`='".$lodate."',`incrementdate`='".$incdate."',`permanentdate`='".$perdate."',`pfdate`='".$pfdate."',`client_id`='".$client."',`desg_id`='".$design."',`dept_id`='".$depart."',`qualif_id`='".$qualifi."',`bank_id`='".$bank."',`loc_id`='".$location."',`paycode_id`='".$paycid."',`bankacno`='".$bankacno."',`middlename_relation`='".$namerel."',`prnsrno`='".$prnsrno."',`esino`='".$esicode."',`pfno`='".$pfcode."',`esistatus`='".$esistatus."',`adharno`='".$adhaar."',`panno`='".$panno."',`driving_lic_no`='".$drilno."',`uan`='".$uan."',`voter_id`='".$votid."',`job_status`='".$jobstatus."',`emp_add1`='".$add1."',`mobile_no`='".$phone."', `due_date`='".$duedate."', `ticket_no`='".$ticket_no."', `comp_ticket_no`='".$comp_ticket_no."', `married_status`='".$married_status."', `pay_mode`='".$pay_mode."', `nationality`='".$nation."', `handicap`='".$handicap."',`pin_code`='".$pin_code."',db_update=NOW() WHERE emp_id='".$id."' and `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update emp with empid end  */

    /* use for update emp income with empincomeid Starts  */
    function updateEmployeeincome($id,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id){
        $sql = "UPDATE `emp_income` SET  head_id='".$incomeid."',remark='".$inremark."',calc_type='".$caltype."',std_amt='".$stdamt."',db_update=NOW() WHERE emp_income_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
   /* use for update emp income with empincomeid end */

    /* use for update emp deduct with empdeductid Starts  */
    function updateEmployeeeduct($id,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank){
       $sql = "UPDATE `emp_deduct` SET head_id='".$destid."',remark='".$destdremark."',calc_type='".$decaltype."',std_amt='".$destdamt."',bank_id='".$selbank."',db_update=NOW() WHERE emp_deduct_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
	  
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update emp deduct with empdeductid end  */

    /* use for update emp leave with empleaveid Starts  */
    function updateEmployeeleave($id,$ob,$leayear,$comp_id,$user_id,$ason,$lt){
       $sql = "UPDATE `emp_leave` SET `leave_type_id`='".$lt."', `as_on`='".$ason."',`year`='".$leayear."', `ob`='".$ob."',db_update=NOW() WHERE emp_leave_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update emp leave with empleaveid Starts  */

    /* use for update emp advance with empadvanceid Starts  */
    function updateEmployeeadvances($id,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype){
       $sql = "UPDATE emp_advnacen SET `date`='".$advdate."',`advance_type_id`='".$advtype."', adv_amount='".$advamt."', adv_installment='".$advins."',db_update=NOW() WHERE emp_advnacen_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update emp advance with empadvanceid end */

    /* use for insert department Starts  */
    function insertDepartment($name,$comp_id,$user_id){
          $sql = "INSERT INTO `mast_dept`(mast_dept_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
          $res = $this->connection->query($sql);
          return $res;
    }
    /* use for insert department end */

    /* use for display department with compid Starts  */
    function showDepartment($comp_id){
        $sql = "select * from mast_dept where comp_id ='".$comp_id."' ORDER BY `mast_dept_name` ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display department with compid end */

    /* use for delete department with deptid Starts  */
    function deleteDepartment($did){
       $sql = "DELETE FROM `mast_dept` WHERE mast_dept_id='".$did."' ";
	   $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete department with deptid end  */

    /* use for update department with deptid Starts */
   function updateDepartment($did,$name,$comp_id,$user_id){
      $sql = "UPDATE `mast_dept` SET  `comp_id`='".$comp_id."',`user_id`='".$user_id."',`mast_dept_name`='".$name."' ,db_update=NOW() WHERE mast_dept_id='".$did."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update department with deptid end */

    /* use for display department with deptid Starts */
    function displayDepartment($did){
             $sql = "SELECT * FROM `mast_dept`  WHERE mast_dept_id='".$did."' ";
             $res = $this->connection->query($sql);
             $row=$res->fetch_assoc();
             return $row;
    }
    /* use for display department with deptid end */

    /* use for insert qualification Starts */
    function insertQualification($name,$comp_id,$user_id){
            $sql = "INSERT INTO `mast_qualif`(mast_qualif_name,comp_id,user_id,`db_adddate`, `db_update`) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
            $res = $this->connection->query($sql);
            return $res;
    }
    /* use for insert qualification end */

    /* use for display qualification with compid Starts */
    function showQualification($comp_id){
            $sql = "select * from mast_qualif where comp_id ='".$comp_id."' ORDER BY `mast_qualif_name` ASC";
           $res = $this->connection->query($sql);
           return $res;
    }
    /* use for display qualification with compid end */

    /* use for display qualification with qualifid Starts */
    function displayQualification($qid){
        $sql = "SELECT * FROM `mast_qualif` WHERE mast_qualif_id='".$qid."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display qualification with qualifid end */

    /* use for delete qualification with qualifid Starts */
    function deleteQualification($id){
     //$sql = "DELETE FROM  `mast_qualif`  WHERE mast_qualif_id='".$id."' ";
        $sql ="";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete qualification with qualifid end */

    /* use for update qualification with qualifid Starts */
    function updateQualification($id,$name,$comp_id,$user_id){
      $sql = "UPDATE `mast_qualif` SET   mast_qualif_name='".$name."' ,db_update=NOW() WHERE mast_qualif_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update qualification with qualifid end */


    /* use for insert designation Starts */
    function insertDesignation($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_desg`(mast_desg_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for insert designation end */

    /* use for display designation with compid Starts */
    function showDesignation($comp_id){
      $sql = "select * from mast_desg where comp_id ='".$comp_id."' ORDER BY `mast_desg_name` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display designation with compid end*/

    /* use for delete designation with desgid Starts */
    function deleteDesignation($id){
        //$sql = "DELETE FROM mast_desg  WHERE mast_desg_id='".$id."' ";
        $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete designation with desgid end */

    /* use for display designation with desgid  Starts */
    function displayDesignation($did){
         $sql = "SELECT * FROM mast_desg  WHERE mast_desg_id='".$did."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display designation with desgid  end */

    /* use for update designation with desgid  Starts */
    function updateDesignation($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_desg SET  mast_desg_name='".$name."' ,db_update=NOW() WHERE mast_desg_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update designation with desgid  end */

    /* use for insert location Starts */
    function insertLocation($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_location`(mast_location_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for insert location end */

    /* use for display location with compid Starts */
    function showLocation($comp_id){
        $sql = "select * from mast_location where comp_id ='".$comp_id."' ORDER BY `mast_location_name` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display location with compid end */

    /* use for display location Starts */
    function displayLocation($lid){
        $sql = "SELECT * FROM mast_location WHERE mast_location_id='".$lid."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display location end*/

    /* use for delete location Starts */
    function deleteLocation($id){
        //$sql = "DELETE FROM mast_location WHERE mast_location_id='".$id."' ";
        $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete location end*/

    /* use for update location Starts */
    function updateLocation($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_location SET  mast_location_name='".$name."' ,db_update=NOW() WHERE mast_location_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update location end */

    /* use for display bank with compid Starts */
    function showBank($comp_id){
          $sql = "select * from mast_bank where comp_id ='".$comp_id."' ORDER BY `bank_name` ASC";
	   
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display bank with compid end */
      /* use for display deduct head with compid Starts */
    function showDeductionhead($comp_id){
        $sql = "select * from mast_deduct_heads where comp_id ='".$comp_id."' ORDER BY `mast_deduct_heads_id` ASC";
         $res = $this->connection->query($sql);
        return $res;
    }

    /* use for insert payscalecode Starts */
    function insertPayscalecode($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_paycode`(mast_paycode_name,comp_id,user_id,db_adddate,db_update) VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for insert payscalecode end */

    /* use for display payscalecode with compid Starts */
    function showPayscalecode($comp_id){
        $sql = "select * from mast_paycode where comp_id ='".$comp_id."' ORDER BY `mast_paycode_id` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display payscalecode with compid end */

    /* use for display payscalecode Starts */
    function displayPayscalecode($pscid){
         $sql = "select * from mast_paycode  WHERE `mast_paycode_id`='".$pscid."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display payscalecode end*/

    /* use for delete payscalecode Starts */
    function deletePayscalecode($id){
      //$sql = "DELETE FROM mast_paycode WHERE `mast_paycode_id`='".$id."' ";
      $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete payscalecode end */

    /* use for update payscalecode Starts */
    function updatePayscalecode($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_paycode SET  `user_id`='".$user_id."',mast_paycode_name='".$name."' ,db_update=NOW() WHERE `mast_paycode_id`='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;

    }
    /* use for update payscalecode end */

    /* use for insert bank Starts */
    function insertBank($name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_bank`( `bank_name`, `ifsc_code`, `add1`, `branch`, `city`, `pin_code`,`comp_id`, `user_id`, `db_adddate`, `db_update`) VALUES('".$name."','".$ifsccode."','".$add."','".$branch."','".$city."','".$pincode."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for insert bank end */

    /* use for delete bank Starts */
    function deleteBank($id){
        //$sql = "DELETE FROM mast_bank WHERE `mast_bank_id`='".$id."' ";
        $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete bank end */

    /* use for display bank Starts */
    function displayBank($bid){
        $sql = "select * from mast_bank WHERE `mast_bank_id`='".$bid."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display bank end*/

    /* use for update bank Starts */
    function updateBank($bid,$name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id){
         $sql = "UPDATE mast_bank SET bank_name='".$name."',`ifsc_code`='".$ifsccode."',`add1`='".$add."',`branch`='".$branch."',`city`='".$city."',`pin_code`='".$pincode."',db_update=NOW() WHERE `mast_bank_id`='".$bid."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update bank end*/

    /* use for insert Income head Starts */
    function insertIncomehead($name,$comp_id,$user_id){
       $sql = "INSERT INTO `mast_income_heads`(income_heads_name,comp_id,user_id,db_addate,db_update)  VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for insert Income head end */

    /* use for display Income head with compid Starts */
    function showIncomehead($comp_id){
       $sql = "select * from mast_income_heads where comp_id ='".$comp_id."' ORDER BY mast_income_heads_id ASC ";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display Income head with compid end*/

    /* use for display Income head Starts */
    function displayIncomehead($id){
       $sql = "select * from mast_income_heads WHERE `mast_income_heads_id`='".$id."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display Income head end */

    /* use for delete Income head Starts */
    function deleteIncomeheads($id){
        //$sql = "DELETE FROM mast_income_heads WHERE `mast_income_heads_id`='".$id."' ";
        $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete Income head end */

    /* use for update Income head Starts */
    function updateIncomehead($id,$name,$comp_id,$user_id){
        $sql = "UPDATE mast_income_heads  SET  income_heads_name='".$name."',db_update=NOW() WHERE `mast_income_heads_id`='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for update Income head end  */

    /* use for display deduct head Starts */
    function insertDeductionhead($name,$comp_id,$user_id){
        $sql = "INSERT INTO `mast_deduct_heads`(deduct_heads_name,comp_id,user_id,db_adddate,db_update)  VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display deduct head end */

    /* use for delete deduct head Starts */
   function deleteDeductionheads($id){
        //$sql =  "DELETE FROM mast_deduct_heads WHERE `mast_deduct_heads_id`='".$id."' ";
        $sql = "";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete deduct head end */

    /* use for update deduct head Starts */
  function updateDeductionhead($id,$name,$comp_id,$user_id){
      $sql = "UPDATE mast_deduct_heads SET  deduct_heads_name='".$name."',db_update=NOW() WHERE `mast_deduct_heads_id`='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
      $res = $this->connection->query($sql);
       return $res;
    }
    /* use for update deduct head end */

    /* use for display deduct head Starts */
   function displayDeductionhead($id){
       $sql = "select * from mast_deduct_heads WHERE  `mast_deduct_heads_id`='".$id."' ";
       $res = $this->connection->query($sql);
       $row=$res->fetch_assoc();
       return $row;
   }
    /* use for display deduct head end */

    /* use for display Leave Type with compid  Starts */
   function showLeavetype($comp_id){
       $sql = "select * from mast_leave_type where comp_id ='".$comp_id."' ORDER BY `mast_leave_type_name` DESC";
       $res = $this->connection->query($sql);
       return $res;
   }
    /* use for display Leave Type with compid end */

    /* use for display Advance Type with compid Starts */
   function showAdvancetype($comp_id){
      $sql = "select * from mast_advance_type where comp_id ='".$comp_id."' ORDER BY `advance_type_name` DESC";
       $res = $this->connection->query($sql);
       return $res;
   }
    /* use for display Advance Type with compid end */

    /* use for insert Leave Type Starts */
   function insertLeavetype($name,$comp_id,$user_id){
       $sql = "INSERT INTO `mast_leave_type`(leave_type_name,comp_id,user_id,db_adddate,db_update)  VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
       $res = $this->connection->query($sql);
       return $res;
   }
    /* use for insert Leave Type end */

    /* use for insert Advance Type Starts */
   function insertAdvancetype($name,$comp_id,$user_id){
       $sql = "INSERT INTO `mast_advance_type`(advance_type_name,comp_id,user_id,db_adddate,db_update)  VALUES('".$name."','".$comp_id."','".$user_id."',NOW(),NOW())";
       $res = $this->connection->query($sql);
       return $res;
   }
    /* use for insert Advance Type end */

    /* use for delete Leave Type Starts */
   function deleteLeavetype($id){
       //$sql = "DELETE FROM mast_leave_type WHERE mast_leave_type_id='".$id."'";
       $sql ="";
       $res = $this->connection->query($sql);
       return $res;
   }
    /* use for delete Leave Type end */

    /* use for delete Advance Type Starts */
    function deleteAdvancetype($id){
        //$sql = "DELETE FROM mast_advance_type WHERE mast_advance_type_id='".$id."' ";
        $sql ="";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete Advance Type end */

    /* use for display Leave Type Starts */
   function displayLeavetype($id){
       $sql = "select * from mast_leave_type WHERE mast_leave_type_id='".$id."' ";
       $res = $this->connection->query($sql);
       $row=$res->fetch_assoc();
       return $row;
   }
    /* use for display Leave Type end */

    /* use for display Advance Type Starts */
   function displayAdvancetype($id){
       $sql = "select * from mast_advance_type WHERE mast_advance_type_id='".$id."' ";
       $res = $this->connection->query($sql);
       $row=$res->fetch_assoc();
       return $row;
   }
    /* use for display Advance Type Starts */

    /* use for update Leave Type Starts */
   function updateLeavetype($id,$name,$comp_id,$user_id){
       $sql = "UPDATE mast_leave_type SET  leave_type_name='".$name."',db_update=NOW() WHERE mast_leave_type_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
       $res = $this->connection->query($sql);

   }
    /* use for update Leave Type end */

    /* use for update Advance Type Starts */
   function updateAdvancetype($id,$name,$comp_id,$user_id){
       $sql = "UPDATE mast_advance_type SET  advance_type_name='".$name."',db_update=NOW() WHERE mast_advance_type_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
       $res = $this->connection->query($sql);;
      
   }
    /* use for update Advance Type end */

    /* use for display tran days Starts */
    function displayTranday($id){
        $sql = "SELECT * FROM `tran_days` WHERE emp_id='".$id."'";
        $res = $this->connection->query($sql);
        //$row=$res->fetch_assoc();
        $row= $res->fetch_assoc();
        return $row;
    }
    /* use for display tran days end */

    /* use for insert tran days Starts */
    function insertTranday($client,$tr_id,$emp,$smonth,$fp,$hp,$lw,$wo,$pr,$ab,$pl,$sl,$cl,$ol,$ph,$add,$oh,$ns,$extra_inc1,$extra_inc2,$extra_ded1,$extra_ded2,$leftdate,$invalid,$comp_id,$user_id,$wagediff,$Allow_arrears,$Ot_arrears,$income_tax,$society,$canteen,$remarks){
        $i=0;
       
        foreach($emp as $e) {
            
          if($tr_id[$i]!=''){
	          $sql = "UPDATE `tran_days` SET extra_inc1='" . $extra_inc1[$i] . "',extra_inc2='" . $extra_inc2[$i] . "',extra_ded1='" . $extra_ded1[$i] . "',extra_ded2='" . $extra_ded2[$i] . "',leftdate='" . $leftdate[$i] . "',invalid='" . $invalid[$i] . "', `comp_id`='".$comp_id."',`user_id`='".$user_id."',`emp_id`='".$emp[$i]."',`client_id`='".$client."',`sal_month`='".$smonth."',`fullpay`='".$fp[$i]."',`halfpay`='".$hp[$i]."',`leavewop`='".$lw[$i]."',`present`='".$pr[$i]."',`absent`='".$ab[$i]."',`weeklyoff`='".$wo[$i]."',`pl`='".$pl[$i]."',`sl`='".$sl[$i]."',`cl`='".$cl[$i]."',`otherleave`='".$ol[$i]."',`paidholiday`='".$ph[$i]."',`additional`='".$add[$i]."',`othours`='".$oh[$i]."',`nightshifts`='".$ns[$i]."',`db_update`=NOW(),`updated_by`='".$user_id."',`wagediff`='".$wagediff[$i]."',`Allow_arrears`='".$Allow_arrears[$i]."',`Ot_arrears` ='".$Ot_arrears[$i]."',`incometax` ='".$income_tax[$i]."',`society` ='".$society[$i]."',`canteen` ='".$canteen[$i]."',`remarks` ='".$remarks[$i]."' WHERE `trd_id`='".$tr_id[$i]."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";


             $res = $this->connection->query($sql);
            }
            else {
      $sql = "INSERT INTO `tran_days`(`user_id`,`client_id`, `comp_id`, `emp_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`,`present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`,`nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `invalid`,`db_adddate`, `db_update`,`updated_by`,`wagediff`, `Allow_arrears`, `Ot_arrears`,incometax,society,canteen,remarks) VALUES('" . $user_id . "','" . $client . "','" .$comp_id  . "','" . $emp[$i]. "','" . $smonth . "','" . $fp[$i] . "','" . $hp[$i] . "','" . $lw[$i] . "','" . $pr[$i] . "','" . $ab[$i] . "','" . $wo[$i] . "','" . $pl[$i] . "','" . $sl[$i] . "','" . $cl[$i] . "','" . $ol[$i] . "','" . $ph[$i] . "','" . $add[$i] . "','" . $oh[$i] . "','" . $ns[$i] . "','" . $extra_inc1[$i] . "','" . $extra_inc2[$i] . "','" . $extra_ded1[$i] . "','" . $extra_ded2[$i] . "','" . $leftdate[$i] . "','" . $invalid[$i] . "',NOW(),NOW(),'".$user_id."','".$wagediff[$i]."','".$Allow_arrears[$i]."','".$ot_arrears[$i]."','".$income_tax[$i]."','".$society[$i]."','".$canteen[$i]."','".$remarks[$i]."')";
              $res = $this->connection->query($sql);
            }
            $i++;
        }
      return $i;
    }
    /* use for insert tran days end */

    /* use for display COLUMNS name in employee table Starts */
    public function selectempstrdet(){
      $sql = "SHOW COLUMNS FROM employee";
        $executequery = $this->connection->query($sql);
           return $executequery;
    }
    /* use for display COLUMNS name in employee table end */

    /* use for update dynamic COLUMNS in employee table Starts */
    function updateAllemp($empid,$fielda,$fieldb,$fieldc,$fieldd,$texta,$textb,$textc,$textd,$comp_id,$user_id){
        $i = 0;

        foreach($empid as $id1) :

          //  if ($texta[$i]!='' && $textb[$i]!='' && $textc[$i]!='' && //$textd[$i]!='') {

            $sql = "UPDATE employee SET $fielda='$texta[$i]',$fieldb='$textb[$i]',$fieldc='$textc[$i]',$fieldd='$textd[$i]',db_update=NOW() WHERE emp_id='" . $empid[$i] . "'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
       
                $this->connection->query($sql);
            //}

            $i++;

        endforeach;

        return $i;

    }
    /* use for update dynamic COLUMNS in employee table end*/

    /* use for update dynamic COLUMNS in employee income table Starts */
    function updateAllempincome($emp_ic_id,$texta,$caltype,$textc,$comp_id,$user_id){
        $i = 0;

        foreach ($emp_ic_id as $id1) :

            $sql = "UPDATE `emp_income` SET std_amt='$texta[$i]',calc_type='$caltype[$i]',remark='$textc[$i]',db_update=NOW()  WHERE emp_income_id='" . $emp_ic_id[$i] . "'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
                $this->connection->query($sql);
            $i++;

        endforeach;

        return $i;

    }
    /* use for update dynamic COLUMNS in employee income table end */

    /* use for update dynamic COLUMNS in employee deduct table Starts */
   function updateAllempeduct($emp_de_id,$texta,$caltype,$textc,$comp_id,$user_id){
       $i = 0;

        foreach ($emp_de_id as $id1) :


             $sql = "UPDATE `emp_deduct` SET std_amt='$texta[$i]',calc_type='$caltype[$i]',remark='$textc[$i]',db_update=NOW()  WHERE emp_deduct_id='" . $emp_de_id[$i] . "'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
                $this->connection->query($sql);
            $i++;

        endforeach;

        return $i;

    }
    /* use for update dynamic COLUMNS in employee deduct table end */


    /* use for display client Starts */
   /* function getClientId($c){
       $sql = "select mast_client_id from mast_client WHERE client_name Like '%".$c."%' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_client_id'];
        }
    }*/
    /* use for display client end */

    /* use for display designation Starts */
   /* function getDesgId($desg){
       $sql = "select mast_desg_id from mast_desg WHERE mast_desg_name Like '%".$desg."%' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(a()== 0){
            return 0;
        } else{
            return $row['mast_desg_id'];
        }
    }*/
    /* use for display designation end */

    /* use for display department Starts */
    /*function getDeptId($dept){
        $sql = "select mast_dept_id from mast_dept WHERE mast_dept_name Like '%".$dept."%' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_dept_id'];
        }
    }*/
    /* use for display department end */
	
	/* use for display department Starts WHILE IMPORTING MASTER INFO TO EMPLOYEE FILE*/
    function getDeptIdemp($dept,$comp_id){
         $sql = "select mast_dept_id from mast_dept WHERE (mast_dept_name Like '%".$dept."%'  or dept Like '%".$dept."%') and comp_id = '".$comp_id."'";
	   
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_dept_id'];
        }
    }
    /* use for display department end */
	
	

    /* use for display qualification Starts */
    function getQualifId($qualif,$comp_id){
        $sql = "select mast_qualif_id from mast_qualif WHERE mast_qualif_name Like '%".$qualif."%' and comp_id = '".$comp_id."'" ;
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_qualif_id'];
        }
    }
    /* use for display qualification end */
function getDesgIdNew($desg_name,$comp_id){
        $sql = "select mast_desg_id from mast_desg WHERE mast_desg_name Like '%".$desg_name."%' and comp_id = '".$comp_id."'" ;
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_desg_id'];
        }
    }
    /* use for display designation end */

    /* use for display bank Starts */
    function getBankId($bank,$comp_id){
         $sql = "select mast_bank_id from mast_bank WHERE bank_name Like '%".$bank."%' and comp_id = '".$comp_id."'";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_bank_id'];
        }
    }
    /* use for display bank end */

    /* use for display location Starts */
    /*function getLocId($loc){
        $sql = "select mast_location_id from mast_location WHERE mast_location_name Like '%".$loc."%' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_location_id'];
        }
    }*/
    /* use for display location end */

    /* use for display paycode Starts */
/*    function getPayCId($payc){
        $sql = "select mast_paycode_id from mast_paycode WHERE mast_paycode_name Like '%".$payc."%' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row['mast_paycode_id'];
        }
    }*/
    /* use for display paycode end */

    /* use for delete emp income Starts */
    function deleteEmpincome($id,$comp_id,$user_id){
        $sql = "DELETE FROM emp_income WHERE `emp_income_id`='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete emp income end */

    /* use for delete emp deduct Starts */
   function deleteEmpdeduct($id,$comp_id,$user_id){
        $sql = "DELETE FROM emp_deduct WHERE `emp_deduct_id`='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete emp deduct end */

    /* use for delete emp leave Starts */
    function deleteEmpleave($id,$comp_id,$user_id){
        $sql = "DELETE FROM emp_leave WHERE `emp_leave_id`='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete emp leave end */

    /* use for delete emp advnace Starts */
   function deleteEmpadvances($id,$comp_id,$user_id){
        $sql = "DELETE FROM emp_advnacen WHERE `emp_advnacen_id`='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete emp advnace end */

    /* use for display emp income Starts */
    function displayEmpincome($id,$comp_id,$user_id){
       $sql = "SELECT * FROM `emp_income` WHERE emp_id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'  ORDER BY `emp_income_id` ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income end */

    /* use for display emp income Starts */
    function displayDedincome($id,$comp_id,$user_id){
       $sql = "SELECT * FROM `emp_deduct` WHERE emp_id='".$id."'   and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ORDER BY `emp_deduct_id` ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */

    /* use for display emp leave Starts */
    function displayEmpleave($id,$comp_id,$user_id){
        $sql = "SELECT * FROM `emp_leave` WHERE emp_id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ORDER BY `emp_leave_id` ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp leave end */

    /* use for display emp advnace Starts */
    function displayAdvances($id,$comp_id,$user_id){
        $sql = "SELECT * FROM `emp_advnacen` WHERE emp_id='".$id."' `emp_advnacen_id`='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ORDER BY `emp_advnacen_id` ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp advnace end */

    /* use for display emp income Starts */
    function showEployeeincomeall($id,$comp_id,$user_id){
        $sql = "select * from `emp_income` WHERE emp_income_id='".$id."'and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp income end */

    /* use for display emp deduct Starts */
    function showEployeedeductall($id,$comp_id,$user_id){
        $sql = "select * from emp_deduct WHERE `emp_deduct_id`='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp deduct end */

    /* use for display emp leave Starts */
    function showEployeeleaveall($id,$comp_id,$user_id){
        $sql = "select * from `emp_leave` WHERE emp_leave_id='".$id."'and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp leave end */

    /* use for display emp advnace Starts */
    function showEployeeadnavcenall($id,$comp_id,$user_id){
        $sql = "select * from `emp_advnacen` WHERE emp_advnacen_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display emp advnace end */

    /* use for display emp report with compid and userid Starts  */
    function showEmployeereport($comp_id,$user_id){
         $sql = "select * from employee where comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY Client_id,last_name,first_name,middle_name,Joindate ASC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp report with compid and userid end  */

    /* use for display tran emp with empid Starts  */
    function showtranhiEployeedetails($tab_emp,$id,$sal_month){
         $sql = "select * from $tab_emp WHERE emp_id='".$id."' and sal_month ='".$sal_month."'";
        $res = $this->connection->query($sql);
        $row=$res->fetch_assoc();
        return $row;
    }
    /* use for display tran emp with empid end  */

	
	
	
	/* Income tax functions */
	 function updateintaxincome($id,$income_desc,$income_amt,$comp_id,$user_id){
        $sqlup=" UPDATE it_file2 SET  income_desc='".$income_desc."',income_amt='".$income_amt."' WHERE id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
         $this->connection->query($sqlup);
        return 1;
    }
    function insertintaxincome($empid,$income_desc,$income_amt,$comp_id,$user_id,$yr){
           $sql = "INSERT INTO it_file2 (user_id,comp_id,emp_id,income_desc,income_amt,year)VALUES('".$user_id."','".$comp_id."','" . $empid . "','" . $income_desc. "','" . $income_amt. "','" . $yr. "')";
        $res = $this->connection->query($sql);
        return $res;
    }

    function updateintaxallow($id,$allow_name,$allow_amt,$comp_id,$user_id){
         $sqlup=" UPDATE it_file2 SET allow_name='".$allow_name."',allow_amt='".$allow_amt."' WHERE id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
       
        $this->connection->query($sqlup);
        return 1;
    }
    function insertintaxallow($empid,$allow_name,$allow_amt,$comp_id,$user_id,$yr){
           $sql = "INSERT INTO it_file2 (user_id,comp_id,emp_id,allow_name,allow_amt,year)VALUES('".$user_id."','".$comp_id."','" . $empid . "','" . $allow_name. "','" . $allow_amt. "','" . $yr. "')";
        $res = $this->connection->query($sql);
        return $res;
    }
   function updateintaxc($id,$c_desc,$c_amt,$comp_id,$user_id){
        $sqlup=" UPDATE it_file2 SET 80C_desc='".$c_desc."',80c_amt='".$c_amt."' WHERE id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
       $this->connection->query($sqlup);
        return 1;
    }
    function insertintaxc($empid,$c_desc,$c_amt,$comp_id,$user_id,$yr){
        $sql = "INSERT INTO it_file2 (user_id,comp_id,emp_id,80C_desc,80c_amt,year)VALUES('".$user_id."','".$comp_id."','" . $empid . "','" . $c_desc. "','" . $c_amt. "','" . $yr. "')";
        $res = $this->connection->query($sql);
        return $res;
    }
    function updateintaxchapter($id,$section_name,$gross_amt,$qual_amt,$deduct_amt,$comp_id,$user_id){
        $sqlup=" UPDATE it_file2 SET  section_name='" . $section_name. "',gross_amt='".$gross_amt."',qual_amt='".$qual_amt."',deduct_amt='".$deduct_amt."' WHERE id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
         $this->connection->query($sqlup);
        return 1;
    }
    function insertintaxchapter($empid,$section_name,$gross_amt,$qual_amt,$deduct_amt,$comp_id,$user_id,$yr){
        $sql = "INSERT INTO it_file2 (user_id,comp_id,emp_id,section_name,gross_amt,qual_amt,deduct_amt,year) VALUES ('".$user_id."','".$comp_id."','" . $empid . "','" . $section_name. "','" . $gross_amt. "','" . $qual_amt. "','" . $deduct_amt. "','" . $yr. "')";
        $res = $this->connection->query($sql);
        return $res;
    }

    function showintaxincome($empid,$comp_id,$user_id){
       $sql = "select * from it_file2 where emp_id='" . $empid . "' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row;
        }
    }

    function showintax($id){
        $sql = "select * from it_file2 where id='" . $id . "' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row;
        }
    }


    /* use for display emp income Starts */
  /*  function displayintax($id,$comp_id,$user_id){
        $sql = "SELECT * FROM it_file2 WHERE emp_id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'  ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }*/
    /* use for display emp income Starts */


    /* use for display emp income Starts */
    function displayintaxincome($id,$year,$comp_id,$user_id){
        $sql = "SELECT * FROM it_file2 WHERE year = '".$year."' and emp_id='".$id."' AND (income_desc!='' OR income_amt!=0)   and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */

    /* use for display emp income Starts */
    function displayintaxallow($id,$year,$comp_id,$user_id){
        $sql = "SELECT * FROM it_file2 WHERE year = '".$year."' and emp_id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' AND (allow_name!='' OR allow_amt!=0) ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */

    /* use for display emp income Starts */
    function displayintaxc($id,$year ,$comp_id,$user_id){
        $sql = "SELECT * FROM it_file2 WHERE year = '".$year."' and  emp_id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' AND (80C_desc!='' OR 80c_amt!=0) ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */

      /* use for display emp income Starts */
    function displayintaxchapter($id,$year,$comp_id,$user_id){
        $sql = "SELECT * FROM it_file2 WHERE year = '".$year."' and  emp_id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'  AND  (section_name!='' OR gross_amt!='0'  OR qual_amt!='0' OR deduct_amt!='0' )  ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */



    /* use for delete emp income Starts */
    function deleteintax($id,$comp_id,$user_id){
        $sql = "DELETE FROM it_file2  WHERE id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete emp income end */




















    function insertitdeposit($chno,$status,$deposite_date,$salmonth,$comp_id,$user_id){
        $sql1 = "SELECT * FROM it_deposited WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' AND sal_month='".$salmonth."' ";
        $res1 = $this->connection->query($sql1);
        $row1 = $res1->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            $sql = "INSERT INTO it_deposited(sal_month, comp_id, user_id, challan_no, deposite_date, oltas_status)VALUES('".$salmonth."','".$comp_id."','".$user_id."','" . $chno . "','" . $deposite_date. "','" . $status. "')";
            $res = $this->connection->query($sql);
            return $res;
        } else{
            return $row1;
        }


    }

    function updateitdeposit($id,$chno,$status,$deposite_date,$salmonth,$comp_id,$user_id){
         $sqlup=" UPDATE it_deposited SET  sal_month='".$salmonth."',challan_no='".$chno."',deposite_date='".$deposite_date."',oltas_status='".$status."' WHERE id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ";
       $this->connection->query($sqlup);
        return 1;

    }

    /* use for display emp income Starts */
    function displayitdeposit($comp_id,$user_id){
        $sql = "SELECT * FROM it_deposited WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */
    /* use for display emp income Starts */
    function showCompdetails($comp_id,$user_id){
        $sql = "SELECT * FROM itconst WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
       function showCompdetailsWithpage($comp_id,$user_id,$per_page,$curpage){
           if($curpage <=0){$curpage=1;}
        $nostrt = ($curpage*$per_page)-$per_page+1; 
        $noend = $curpage*$per_page;
        $sql = "SELECT * FROM itconst WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY id DESC limit $nostrt,$noend";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */


     /* use for display emp income Starts */
    function displayCompdetails($id,$comp_id,$user_id){
        $sql = "SELECT * FROM itconst WHERE id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."'";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        return $row;
    }
    /* use for display emp income Starts */

    /* use for delete client Starts  */
    function deleteitdeposit($id,$comp_id,$user_id){
       $sql = "DELETE FROM it_deposited WHERE id='".$id."'  and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete client end */


     /* use for delete client Starts  */
    function deleteitCompanydetails($id,$comp_id,$user_id){
       $sql = "DELETE FROM itconst WHERE id='".$id."' and  `comp_id`='".$comp_id."' and `user_id`='".$user_id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for delete client end */


     /* use for insert Company details Starts  */
    function insertCompanydetails($fdate,$tdate,$assyr,$tdsc,$authp,$authd,$authmn,$bcrc,$qcn1,$qap1,$qade1,$qadp1,$qcn2,$qap2,$qade2,$qadp2,$qcn3,$qap3,$qade3,$qadp3,$qcn4,$qap4,$qade4,$qadp4,$prdate,$comp_id,$user_id){

      $sql1 = "SELECT * FROM itconst WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' AND from_date='".$fdate."'";
        $res1 = $this->connection->query($sql1);
        $row1 = $res1->fetch_assoc();
       //  mysqli_affected_rows($this->connection);
        if(mysqli_affected_rows($this->connection)== 0){
        $sql = "INSERT INTO itconst(from_date, to_date, comp_id, user_id, tds_circle, Assment_year, auth_person, auth_desg, auth_mname, bsrcode,Q1_challan, Q1_amt_paid, Q1_amt_deducted, Q1_amt_deposited, Q2_challan, Q2_amt_paid, Q2_amt_deposited, Q2_amt_deducted, Q3_challan, Q3_amt_paid, Q3_amt_deposited,Q3_amt_deducted, Q4_challan, Q4_amt_paid, Q4_amt_deposited, Q4_amt_deducted, Printed_on) VALUES ('" . $fdate . "','" . $tdate . "','" . $comp_id . "','" . $user_id . "','" . $tdsc . "','" . $assyr . "','" . $authp . "','" . $authd . "','" . $authmn . "','" . $bcrc . "' ,'" . $qcn1 . "','" . $qap1. "','" . $qade1 . "','" . $qadp1 . "' ,'" . $qcn2 . "','" . $qap2. "','" . $qade2 . "','" . $qadp2 . "','" . $qcn3 . "','" . $qap3. "','" . $qade3. "','" . $qadp3 . "','" . $qcn4 . "','" . $qap4. "','" . $qade4 . "','" . $qadp4 . "' ,'" . $prdate . "' )";
         $res = $this->connection->query($sql);
            return $res;
        } else{

            return $row1;
        }

    }
    /* use for insert Company details end */

     /* use for insert Company details Starts  */
    function updateCompanydetails($id,$fdate,$tdate,$assyr,$tdsc,$authp,$authd,$authmn,$bcrc,$qcn1,$qap1,$qade1,$qadp1,$qcn2,$qap2,$qade2,$qadp2,$qcn3,$qap3,$qade3,$qadp3,$qcn4,$qap4,$qade4,$qadp4,$prdate,$comp_id,$user_id,$year){
        $sql1 = "SELECT * FROM itconst WHERE id!='".$id."' AND from_date='".$fdate."' and comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
        $res1 = $this->connection->query($sql1);
        $row1 = $res1->fetch_assoc();
         mysqli_affected_rows($this->connection);
        if(mysqli_affected_rows($this->connection)!= 0){
           $sql="UPDATE itconst SET from_date='".$fdate."',to_date='".$tdate."',tds_circle='".$tdsc."',Assment_year='".$assyr."',auth_person='".$authp."',auth_desg='".$authd."',auth_mname='".$authmn."',bsrcode='".$bcrc."',Q1_challan='".$qcn1."',Q1_amt_paid='".$qap1."',Q1_amt_deducted='".$qade1."',Q1_amt_deposited='".$qadp1."',Q2_challan='".$qcn2."',Q2_amt_paid='".$qap2."',Q2_amt_deducted='".$qade2."',Q2_amt_deposited='".$qadp2."',Q3_challan='".$qcn3."',Q3_amt_paid='".$qap3."',Q3_amt_deducted='".$qade3."',Q3_amt_deposited='".$qadp3."',Q4_challan='".$qcn4."',Q4_amt_paid='".$qap4."',Q4_amt_deducted='".$qade4."',Q4_amt_deposited='".$qadp4."',Printed_on='".$prdate."',year = '".$year."'  WHERE id='".$id."' and comp_id ='".$comp_id."' AND user_id='".$user_id."'  ";
            $res = $this->connection->query($sql);
            return $res;
        } else{

            return $row1;
        }

    }
    /* use for insert Company details end */

    function displayitdepositdetails($id,$comp_id,$user_id){
        $sql = "select * from it_deposited where id='" . $id . "' and comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
        $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        if(mysqli_affected_rows($this->connection)== 0){
            return 0;
        } else{
            return $row;
        }
    }
   function insertotherinfo($empid,$year,$hsg_intrest,$ccc,$ccd,$ccf,$taxbenefit_87,$relief_89,$comp_id,$user_id)
   {
       $res1=$this->checkoutotherinfo($empid,$comp_id,$user_id);
       $row1 = $res1->fetch_assoc();
       if(mysqli_affected_rows($this->connection)== 0) {
        $sql = "INSERT INTO it_file2(year, comp_id, user_id,emp_id,hsg_intrest,80ccc,80ccd,80ccf,relief_89,taxbenefit_87) VALUES ('" . $year . "','" . $comp_id . "','" . $user_id . "','" . $empid . "','" . $hsg_intrest . "' ,'" . $ccc . "','" . $ccd . "','" . $ccf . "','" . $relief_89 . "','" . $taxbenefit_87 . "')";
           $res = $this->connection->query($sql);
           return $res;
       }
       else{
        $sql = "update it_file2 set year='$year',hsg_intrest='$hsg_intrest',80ccc='$ccc',80ccd='$ccd',80ccf='$ccf',relief_89='$relief_89',taxbenefit_87='$taxbenefit_87' where id='".$row1['id']."' and comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
           $res = $this->connection->query($sql);
           return $res;
       }


   }

   public function checkoutotherinfo($empid,$comp_id,$user_id)
    {
        $sql1 = "SELECT * FROM it_file2 WHERE comp_id='" . $comp_id . "' AND emp_id='" . $empid . "' AND user_id='" . $user_id . "' AND (hsg_intrest>0 || 80ccc>0 || 80ccd>0 || 80ccf>0 || relief_89>0 || taxbenefit_87>0)";
        $res1 = $this->connection->query($sql1);
        return $res1;
    }
	
	
		/// vilas
	//get appoint employee details by client id for get printing purpose
/*	public function getEmployeeDetailsByClientIdAppont($clientid,$cmonth,$comp_id,$user_id){
		$sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.esistatus,emp.emp_add1,emp.pin_code,emp.emp_id,emp.joindate,md.mast_desg_name ,emp.due_date
		from employee emp	 inner join mast_desg md on md.mast_desg_id = emp.desg_id 
		where emp.client_id='$clientid' and year(emp.joindate) = year('$cmonth') and month(emp.joindate) = month('$cmonth')  and comp_id ='".$comp_id."' AND user_id='".$user_id."' 
		";
		$res1 = $this->connection->query($sql);
		return $res1;
	}*/
	//get employee income
	public function getEmployeeIncome($empid,$comp_id,$user_id){		
		$sql ="select eimc.std_amt,eimc.calc_type, eimc.head_id,inchd.income_heads_name
		from emp_income eimc 
		inner join mast_income_heads inchd on eimc.head_id = inchd.mast_income_heads_id
		where emp_id ='".$empid."' and eimc.comp_id ='".$comp_id."' AND eimc.user_id='".$user_id."' ";
		$res1 = $this->connection->query($sql);
		return $res1;
	}
	//get employee deducts
	public function getEmployeeDeduction($empid,$comp_id,$user_id){		
		 $sql2 ="select eded.std_amt, eded.head_id,dedhd.deduct_heads_name
		from emp_deduct eded 
		inner join mast_deduct_heads dedhd on eded.head_id = dedhd.mast_deduct_heads_id
		where eded.emp_id ='".$empid."' and comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
		$res2 =$this->connection->query($sql2);
		return $res2;
	}
	 /* use for display emp with empid Starts  */
    function showEployeedetailsQ($id,$comp_id,$user_id){
        $sql = "select emp.*,md.mast_desg_name from employee emp inner join mast_desg md on emp.desg_id = md.mast_desg_id WHERE emp.emp_id='".$id."' and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."' ";
        $res = $this->connection->query($sql);
		return $res;
    }
    /* use for display emp with empid end  */
		//use for convert number to words
	function convertNumberTowords($number){
		//$number = 190908100.25;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
$points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
 return  $result . " " . $points;
	}


	//get releave employee details by client id of current month 
	public function getEmployeeDetailsByClientId($clientid){
		$sel1 ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.emp_add1,emp.pin_code,emp.emp_id,emp.joindate,emp.leftdate
		from employee emp	
		where emp.client_id='$clientid' 
		";
		$res1 = $this->connection->query($sql);
		return $res1;
	}
/*	function getDesigantion($designid){
		$sel1 ="select mast_desg_name from mast_desg where mast_desg_id='".$designid."'";
		$res1 = $this->connection->query($sql);
		$row = $res1->fetch_assoc();
		return $row['mast_desg_name'];
	}*/
	//to get da
	   
	   
	   
	   
	    //To be done afterwards functions for appoinment letter* * * * * * * * * * * * * * * * * * * * * * * * 


/*	function pfDed($empId,$comp_id,$user_id ){
	    
	    
	//	$sel1 ="select std_amt,head_id from emp_income   where emp_id='".$empId."' and head_id in(5,6)  and comp_id ='".$comp_id."' AND user_id='".$user_id."'  group by head_id";
		$sel1 ="select std_amt,head_id from emp_income   where emp_id='".$empId."' 	 and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  or `income_heads_name` LIKE '%wage%'  ) and comp_id = '".$comp_id."'  ) and  comp_id = '".$comp_id."' and user_id = '".$user_id."' group by head_id";
		$res1 = $this->connection->query($sql);
		$basic="";
		$orda="";
		//$row['std_amt'];
		while($row = mysql_fetch_array($res1)){			
				//$da += $row['std_amt'];	
				if($row['head_id']==5){
					$basic = $row['std_amt'];
				} if($row['head_id']==6){
					$orda = $row['std_amt'];
				}				
		}
		if($orda !=""){
			//$basic =5800;
			//$orda =3256;
			$da = round(($basic + $orda)*12/100);
		}else{
			$da=0;
		}
		
		return $da;
		
	}
	function ptDed($emp){
	    
	    		$sel1 ="select ed.head_id from emp_deduct inner join mast_deduct_heads md on md.mast_deduct_heads_id = ed.head_id  where emp_id ='".$emp."' and md.`deduct_heads_name` LIKE '%Prof.Tax%'  and md.comp_id = '".$comp_id."'";

		//$sel1 ="select head_id from emp_deduct where emp_id ='".$emp."' and head_id='3'";
		$res1 = $this->connection->query($sql);
	$row = $res1->fetch_assoc();
	return $row['head_id'];
	}
	function pfComp($emp){
		$sel1 ="select std_amt,head_id from emp_income where emp_id='".$emp."' and head_id in(5,6) group by head_id";
		$res1 = $this->connection->query($sql);
		$basic="";
		$orda="";
		//$row['std_amt'];
		while($row = mysql_fetch_array($res1)){			
				//$da += $row['std_amt'];	
				if($row['head_id']==5){
					$basic = $row['std_amt'];
				} if($row['head_id']==6){
					$orda = $row['std_amt'];
				}				
		}
		if($orda !=""){
			//$basic =5800;
			//$orda =3256;
			$da = round(($basic + $orda)*12/100);
		}else{
			$da = round($basic*13.15/100);
		}
		
		return $da;
	}*/
		    //End of  functions for appoinment letter* * * * * * * * * 
	
	
	
/* use for display company details */
    function showCompdetailsById($comp_id){
        $sql = "SELECT * FROM mast_company WHERE comp_id ='".$comp_id."'";
        $res = $this->connection->query($sql);
		$row = $res->fetch_assoc();
        return $row;
    }
	function getBonusType(){
		$sql = "SELECT * FROM caltype_bonus";
        $res = $this->connection->query($sql);
        return $res;
	}
	//for get bonus employee
	function getemployeeBonusById($emp,$startyear,$endyear,$comp_id,$user_id){
		$sql = "select * from bonus 	 
		 where emp_id = '".$emp."' and from_date='".$startyear."' and todate='".$endyear."'  and comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
		$row = $this->connection->query($sql);
		return $row;
	}
	//get releave employee details by client id for attendance 
	public function getEmployeeAllDetailsByClientId($clientid,$comp_id,$user_id){
		$sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.gender,emp.bdate,mde.mast_desg_name, emp.joindate
		from employee emp inner join mast_desg mde on mde.mast_desg_id= emp.desg_id	
		where emp.client_id='$clientid' and  emp.job_status!='L'   and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."' 
		";
		$res1 = $this->connection->query($sql);
		return $res1;
	}

	

	public function getIncomeCalculationTypeByid($id){
		$sql = "select name from caltype_income 	 
		 where id = '".$id."'";
		$row = $this->connection->query($sql);
		$res = $row->fetch_assoc();
		return $res['name'];
	}
	
	
// functions for cheque 	
	public function chkDetails($empid,$cmonth,$type){
		 $sql="select * from cheque_details where emp_id ='".$empid."' and sal_month = '".date("Y-m-d", strtotime($cmonth))."'
		and type = '".$type."'";
		
	    $res = $this->connection->query($sql);
		//$row = $res->fetch_assoc();
		
		return $res;
	}
	
	public function getChequeEmployeeByClientId($clientid,$tab_emp,$month){
		   $sel1 ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.netsalary 
		from $tab_emp te  inner join employee e on e.emp_id = te.emp_id where te.client_id='$clientid'  and te.pay_mode = 'C' and te.netsalary >0 and sal_month='$month' order by te.emp_id"; 
		
		$res1 = $this->connection->query($sel1);
	    //print_r($res1);
		return $res1;
	}
	public function getChequeEmployeeByEmpId($emp_id,$tab_emp,$month,$type){
		$sel1 ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.netsalary 
		from $tab_emp te inner join employee e on e.emp_id = te.emp_id where te.emp_id = '$emp_id' and te.pay_mode = 'C' and te.netsalary >0 and sal_month='$month' order by te.emp_id"; 
		
		$res1 = $this->connection->query($sel1);
	    //print_r($res1);
		return $res1;
	}
	public function delCheckDetails($id){
		$sql ="delete from cheque_details where chk_detail_id='".$id."'";
		$this->connection->query($sql);
		return 1;
	}
	public function checkExistChequeDetails($empid,$salmonth,$type){
		$sql ="select count(*) cnt from cheque_details where emp_id='".$empid."' and sal_month='".$salmonth."' and type='".$type."'";
		$res = $this->connection->query($sql);
		$row = $res->fetch_assoc();
		return $row['cnt'];
	}
	function selectClientEmployee(){
        $sql = "select *,mc.client_name,md.mast_desg_name from client_employee ce inner join mast_client mc on ce.client_id=mc.mast_client_id
		inner join mast_desg md on ce.design_id=md.mast_desg_id ORDER BY client_id ASC ";
        $res = $this->connection->query($sql);
        return $res;
    }
	//get releave employee details by client id for attendance 
	public function getEmployeeAllDetailsByClientIdByLocation($clientid ,$comp_id,$user_id){
	
	 $sql1 ="select emp.first_name,emp.middle_name,emp.last_name,emp.gender,emp.gender,emp.bdate,mde.mast_desg_name, emp.joindate,emp.loc_id
		from employee emp inner join mast_desg mde on mde.mast_desg_id= emp.desg_id	
		where emp.client_id = $clientid  and (emp.job_status != 'L')   and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."' order by emp_id;
		";
			
		
		$res1 = $this->connection->query($sql1);
		return $res1;
	}
	
	
	
	function selectedBanks($comp_id,$client_id,$field,$frdt,$tab_emp){
	$sql = "select distinct bank_id, mb.* from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id where te.comp_id = '$comp_id' and  te.client_id in ($client_id) and $field = '$frdt' order by mb.bank_name ";  

        $res = $this->connection->query($sql);
        return $res;
	}

	
	
function selectedBanks_deduct($comp_id,$client_id,$field,$frdt,$tab_emp,$tab_deduct){
		  $sql = "select distinct tdd.bank_id, mb.* from $tab_deduct tdd inner join $tab_emp te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month inner join mast_bank mb on tdd.bank_id = mb.mast_bank_id where te.comp_id = '$comp_id' and  te.client_id = '$client_id' and tdd.bank_id>0 and  tdd.$field = '$frdt' order by mb.bank_name ";  
		
        $res = $this->connection->query($sql);
        return $res;
	}
	
	
function getdates($client_id){
	 $sql = "select distinct  payment_date from leave_details where client_id='$client_id' order by payment_date desc  ";  
		$res = $this->connection->query($sql);
        return $res;
	}
	

	public function getemployeeBonusByClient($client,$startyear,$endyear,$days,$comp_id,$user_id){
		
		 $sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.emp_id,emp.joindate,emp.leftdate
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and emp.prnsrno !='Y'  and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."' ";  

		$res1 = $this->connection->query($sql);
		return $res1;
	}
	
	
	public function getTotBonusByClient($client,$startyear,$endyear,$days){
		
		 $sql ="select sum(te.tot_bonus_amt +te.tot_exgratia_amt ) as amount 
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and emp.prnsrno !='Y'";  

		$res1 = $this->connection->query($sql);
		return $res1;
	}
		
	public function getemployeeBonusByClientHold($client,$startyear,$endyear,$days,$comp_id,$user_id){
		
	 $sel1 ="select emp.first_name,emp.middle_name,emp.last_name,emp.emp_id,emp.joindate,emp.leftdate
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and  emp.prnsrno ='Y'  and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."' ";  
				
		$res1 = $this->connection->query($sql);
		return $res1;
	}
		
	public function getemployeeBonusByClientlessdays($client,$startyear,$endyear,$days,$comp_id,$user_id){
		
		 $sql ="select emp.first_name,emp.middle_name,emp.last_name,emp.emp_id,emp.joindate,emp.leftdate
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) <$days  and emp.comp_id ='".$comp_id."' AND emp.user_id='".$user_id."'  ";  
		$res1 = $this->connection->query($sql);
		return $res1;
	}
		
	
			
function getadvdates($emp_id){
		$sql = "select distinct  date from emp_advnacen where emp_id='$emp_id' order by date desc  ";  
		
		$res = $this->connection->query($sql);
        return $res;
	}
	
	
	
		public function getBonusChequeEmployeeByEmpId($empid1,$frdt1,$to){
		    /*	 $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.amount ,te.payment_date 
		from bonus te inner join employee e on e.emp_id = te.emp_id where te.pay_mode = 'C' and te.tot_bonus_amt+tot_exgratia_amt >0 and from_date = $frdt1 and todate=$to and te.emp_id = $empid1  order by te.emp_id"; 
		*/
		 $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.tot_bonus_amt+te.tot_exgratia_amt as  amount ,te.payment_date 
		from bonus te inner join employee e on e.emp_id = e.emp_id where te.pay_mode = 'C' and te.tot_bonus_amt+tot_exgratia_amt >0 and from_date = $frdt1 and todate=$to and te.emp_id = $empid1  order by te.emp_id"; 
		$res1 = $this->connection->query($sql);
		//$res2 = mysql_fetch_array($res1);
		//print_r($res1);
		return $res1;
		}
		
		public function getBonusChequeEmployeeByClientId($clientid,$tab_emp,$frdt1,$to){
			
		 $sql ="select e.first_name,e.middle_name,e.last_name ,te.emp_id,te.tot_bonus_amt+te.tot_exgratia_amt as   amount from bonus te inner join employee e on e.emp_id = te.emp_id where te.pay_mode = 'C' and  te.client_id = $clientid and te.tot_bonus_amt+te.tot_exgratia_amt >0 and from_date = '$frdt1' and todate='$to' and e.prnsrno !='Y' and te.tot_payable_days >= '".$_SESSION['days']."' order by te.emp_id"; 

		$res1 = $this->connection->query($sql);
	    //print_r($res1);
		return $res1;
		}
		
		public function chkBonusChequeDetails($emp,$frdt1,$to,$type){		
		$sel1="select * from cheque_details where emp_id =$emp and from_date = '$frdt1' and todate='$to' and type = '$type'";
		$res1 = $this->connection->query($sql);
		return $res1;	
		
	}
	
		public function chkBonusDetails($empid,$frdt1,$to,$type){
		$sql="select * from cheque_details where emp_id ='".$empid."' and  from_date = '$frdt1' and to_date='$to'  and type = '".$type."'";
	    $res = $this->connection->query($sql);
		//$row = $res->fetch_assoc();
		
		return $res;
	}
	public function searchclient($comp_id,$user_id,$name){
	    $sql = "select DISTINCT * from mast_client WHERE comp_id='".$comp_id."' AND user_id='".$user_id."' AND client_name Like '%" . $name . "%' limit 250";
            $res =  $this->connection->query($sql);
            return $res;
	}
// vilas
	public function getmastcomptdstring(){
	      $sql ="select td_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
              $head = $this->connection->query($sql);
              $headrow = $head->fetch_assoc();
              $head = $headrow['td_string'];
              return $head;
	}
	
	public function getmastcompreadonlystring(){
	    $sql ="select readonly_string from mast_company where comp_id = '".$_SESSION['comp_id']."'";
              $head = $this->connection->query($sql);
              $headrow = $head->fetch_assoc();
              $readonly = $headrow['readonly_string'];
              return $readonly;
	}
	public function getLastDay($cmonth){
	    $sql = "SELECT LAST_DAY('".$cmonth."') AS last_day";
        $row= $this->connection->query($sql);
        $res = $row->fetch_assoc();
       return $res['last_day'];
	}
	public function getMonthLastDay($cmonth){
	    $sql = "SELECT day(LAST_DAY('".$cmonth."')) AS monthdays";
       $row= $this->connection->query($sql);
        $res = $row->fetch_assoc();
        $monthdays = $res['monthdays'];
        return $monthdays;
	}
	public function getMonthFirstDay($cmonth){
	    $sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
            $row= $this->connection->query($sql);
            $res = $row->fetch_assoc();
            $startmth = $res['first_day'];
            return $startmth;
	    
	}
	public function setInvalidClient($client_id,$comp_id,$user_id){
	    $sql = "update tran_days set invalid = '' where client_id ='".$client_id."' and  comp_id='".$comp_id."' AND user_id='".$user_id."'";
        $row=  $this->connection->query($sql);
        return $row;
	}
	public function getLeftEmployee($client_id,$comp_id,$user_id){
	    $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days where  comp_id='".$comp_id."' AND user_id='".$user_id."') and  emp.comp_id='".$comp_id."' AND emp.user_id='".$user_id."'" ;
            $row=  $this->connection->query($sql);
            return $row;
	}
	public function deleteTranDay($emp,$comp_id,$user_id){
	    $sql2  = "delete from  tran_days  where emp_id ='".$emp."' and  comp_id='".$comp_id."' AND user_id='".$user_id."'";
        $this->connection->query($sql2);
	}
	public function getemployeeNotInTranDay($client_id,$comp_id,$user_id){
	    $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client_id."' and emp.job_status !='L' and emp.emp_id not in (SELECT emp_id FROM tran_days  where comp_id='".$comp_id."' AND user_id='".$user_id."' ) and  emp.comp_id='".$comp_id."' AND emp.user_id='".$user_id."'" ;

            $row=$this->connection->query($sql);
            return $row;
	}
	public function insertTranDays($emp_id,$endmth,$comp_id,$user_id,$client_id){
	     $sql2  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updated_by) values ('".$emp_id."','".$endmth."','".$client_id."','".$comp_id."','".$user_id."','".$user_id."')";
       
        $this->connection->query($sql2);
	    
	}
	public function getabsentDay($client_id ,$comp_id,$user_id){
	    $sql = "SELECT trd_id from tran_days WHERE  client_id = '".$client_id."' and present = 0 and othours >0 and  comp_id='".$comp_id."' AND user_id='".$user_id."'" ;
        $row= $this->connection->query($sql);
        return $row;
	}
	public function updateSetInvalid($trd_id,$comp_id,$user_id){
	    $sql2  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$trd_id."' and  comp_id='".$comp_id."' AND user_id='".$user_id."'";
        
        $row=$this->connection->query($sql2);
       
	}
	public function checkInvalidTotalDayRegularEmployee($monthdays,$client_id,$startmth,$comp_id,$user_id){
	    $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."' and emp.joindate< '".$startmth."' and td.comp_id='".$comp_id."' AND td.user_id='".$user_id."'" ;
        
        $row=$this->connection->query($sql);
        return $row;
	}
	
	
	public function updateSetInvalid1($trd_id,$comp_id,$user_id){
	    $sql2  = "update tran_days set invalid = concat(invalid,'Days Total(R)-') where trd_id ='".$trd_id."' and comp_id='".$comp_id."' AND user_id='".$user_id."'";
        
        $row=$this->connection->query($sql2);
	}
	public function getCalculateNewEmployee($monthdays,$client_id,$startmth,$comp_id,$user_id){
	    $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."'and  emp.joindate> '".$startmth."' and td.comp_id='".$comp_id."' AND td.user_id='".$user_id."'";
        
        $row=$this->connection->query($sql);
        return $row;
	}
	public function updateSetInvalid2($trd_id,$comp_id,$user_id){
	    $sql2  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$trd_id."' and comp_id='".$comp_id."' AND user_id='".$user_id."'";
        $row=$this->connection->query($sql2);
	}
	public function getCalculateLeftEmployee($client_id,$startmth,$comp_id,$user_id){
	    $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client_id."' and  emp.joindate< '".$startmth."' and td.comp_id='".$comp_id."' AND td.user_id='".$user_id."'" ;
            $row= $this->connection->query($sql);
            return $row;
	}
	public function updateSetInvalid3($trd_id,$comp_id,$user_id){
	    $sql2  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$trd_id."' and  comp_id='".$comp_id."' AND user_id='".$user_id."'";
        $this->connection->query($sql2);
	}
	public function getSearchEmployee($comp_id,$user_id,$arr){
	     $sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND user_id='".$user_id."' ";
        if(sizeof($arr)>=1) {
                if ($arr[0] != '' && isset($arr[0])) {
                    $sql .= " AND first_name Like '%" . $arr[0] . "%' ";
                }
            }
        if(sizeof($arr)>=2) {
            if ($arr[1] != '' && isset($arr[2])) {
                $sql .= " AND middle_name Like '%" . $arr[1] . "%' ";
            }
        }
        if(sizeof($arr)==3) {
            if ($arr[2] != '' && isset($arr[3])) {
                $sql .= " AND last_name Like '%" . $arr[2] . "%' ";
            }
        }
         $sql .= " limit 250";
        $res =  $this->connection->query($sql);
        return $res;
	}
	public function getsumTotalCont($id){
	      $sql = "SELECT SUM(`std_amt`) as total FROM emp_income where emp_id='".$id."'  and ((calc_type <=5  or calc_type = 14)  and calc_type !=3)";
         $res = $this->connection->query($sql);
        $row = $res->fetch_assoc();
        return $row['total'];
	}
	public function displayDataByChice($fielda,$fieldb,$fieldc,$fieldd,$cid,$comp_id,$user_id){
        $sql = "SELECT $fielda,$fieldb,$fieldc,$fieldd,emp_id,first_name as fn,middle_name as mn,last_name as ln FROM `employee` where client_id='".$cid."' AND job_status!='L'   and  comp_id='".$comp_id."' AND user_id='".$user_id."'order by emp_id"; 
        $res = $this->connection->query($sql);
        return $res;
	}
	









	
	
	
	
	
	public function displayOtherFieldsData($selname,$table,$prid,$tableprid,$client_id,$comp_id,$user_id){
	     $sql = "SELECT emp_id,first_name as fn,middle_name as mn,last_name as ln,".$selname.",".$prid." FROM employee e inner join $table on
e.".$prid."=".$table.".".$tableprid."
   where client_id='".$client_id."' AND job_status!='L'  and  comp_id='".$comp_id."' AND user_id='".$user_id."'  order by emp_id"; 
    $res1 = $this->connection->query($sql);
		return $res1;
   
  
	}
	public function gettabdataOther($table,$comp_id,$user_id){
	     $sqldataall = "select * from ".$table." where    comp_id='".$comp_id."' AND user_id='".$user_id."' ";
		$res1 = $this->connection->query($sqldataall);
		return $res1;
	}
	public function updateEmpOtherData($fld,$fldid,$emp_id,$comp_id,$user_id){
	      $sqldataall = "update employee set $fld='".$fldid."' where emp_id='".$emp_id."'  and  comp_id='".$comp_id."' AND user_id='".$user_id."' ";
		$res1 = $this->connection->query($sqldataall);
		return $res1;
	}
	
	public function updateBankEmpOtherData($fld,$fldid,$bank_no,$emp_id,$comp_id,$user_id){
	      echo $sqldataall = "update employee set $fld='".$fldid."', bankacno='".$bank_no."' where emp_id='".$emp_id."'  and  comp_id='".$comp_id."' AND user_id='".$user_id."' ";
		$res1 = $this->connection->query($sqldataall);
		return $res1;
	}
	
	public function exportAllEmployee($comp_id,$cal){
        $setSql = "select e.*,mb.ifsc_code,mb.branch from employee  e  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  where e.comp_id = '".$comp_id."'";
        
        if($cal!='all' && $cal!='0'){
        $setSql .= " AND e.client_id='".$cal."'";
        }
        $setSql .= " order by e.client_id,e.emp_id,e.client_id,e.first_name,e.middle_name,e.last_name ";
       
        $res1 = $this->connection->query($setSql);
    
        return $res1;
	}
	public function getExportIncome($comp_id,$user_id,$client,$left){
        $setSql1= "SELECT mast_income_heads_id,income_heads_name FROM `mast_income_heads` WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' AND mast_income_heads_id in (select DISTINCT head_id from emp_income ei inner JOIN employee e on e.emp_id=ei.emp_id";
        
        if($client!='all' && $client!='0'){
            $setSql1 .= " where e.client_id='".$client."'";
        }
        
        if($left=='no'){
            $setSql1 .= " AND e.job_status!='L'";
        }
           $setSql1 .= ")";
        $res1 = $this->connection->query($setSql1);
        return $res1;
	}
	public function getExportIncome1($comp_id,$user_id,$client,$left){
        $setSql= "SELECT emp_id, concat(first_name,' ',middle_name,' ',last_name) as name,joindate FROM employee WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
        if($client!='all' && $client!='0'){
        $setSql .= " AND client_id='".$client."'";
        }
        if($left=='no'){
        $setSql .= " AND job_status!='L'";
        }
        
        $setSql .= " order by emp_id,client_id,first_name,middle_name,last_name ";
        $res1 = $this->connection->query($setSql);
        return $res1;
	}
	public function getExportIncome2($temp,$emp_id,$comp_id,$user_id){
	    $setSql22 = "SELECT std_amt FROM emp_income WHERE `head_id`= '" . $temp . "'  AND emp_id='" . $emp_id . "'  AND `comp_id`='" . $comp_id . "' AND `user_id`='" . $user_id . "' ";
	    $res1 = $this->connection->query($setSql22);
        return $res1;
	}
	public function exportEmpDeduct($comp_id,$user_id,$clint_id){
	    $setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
	    $res1 = $this->connection->query($setSql);
        return $res1;
	}
	public function exportEmpDeduct1($comp_id,$user_id,$client,$left){
	     $setSql1= "SELECT mast_deduct_heads_id,deduct_heads_name FROM `mast_deduct_heads` WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."'AND mast_deduct_heads_id in (select DISTINCT head_id from emp_deduct ed inner JOIN employee e on e.emp_id=ed.emp_id";

            if($client!='all' && $client!='0'){
                $setSql1 .= " where e.client_id='".$client."'";
            }
            
            if($left=='no'){
                $setSql1 .= " AND e.job_status!='L'";
            }
            
            $setSql1 .= ")";
            $setRec1 = $this->connection->query($setSql1);
            return $setRec1;
	}
	public function exportEmpDeduct2($comp_id,$user_id,$client){
	    $setSql= "SELECT emp_id, concat(first_name,' ',middle_name,' ',last_name) as name FROM employee WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
        if($client!='all' && $client!='0'){
            $setSql .= " AND client_id='".$client."'";
        }
        $setSql .= " order by client_id,first_name,middle_name,last_name ";
        
         $setRec1 = $this->connection->query($setSql);
       return $setRec1;
	}
	public function exportEmpDeduct3($head_id,$emp_id,$comp_id,$user_id){
	    $setSql22 = "SELECT std_amt FROM emp_deduct WHERE `head_id`= '" . $head_id . "'  AND emp_id='" . $emp_id . "'  AND `comp_id`='" . $comp_id . "' AND `user_id`='" . $user_id . "' ";
        
        $setRec1 = $this->connection->query($setSql22);
        return $setRec1;
	}
    
    public function exportLeave($comp_id,$user_id){
         $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email,el.ob as OB FROM `employee` emp ,emp_leave el WHERE emp.emp_id=el.emp_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";
        
        $setRec1 = $this->connection->query($setSql);
        return $setRec1;
    }
	
	public function exportAdvance($comp_id,$user_id){
	    $setSql= "SELECT emp.`first_name` as 'First Name', emp.`middle_name` as 'Middle Name', emp.`last_name`  as 'Last Name', emp.`gender` as Gender ,emp.`email` as Email, ea.`date` as 'Date', ea.`adv_amount` as 'Advance Amount', ea.`adv_installment` as Installment FROM `employee` emp ,emp_advnacen ea WHERE emp.emp_id=ea.user_id  AND ea.`comp_id`='".$comp_id."' AND ea.`user_id`='".$user_id."'";
        
        $setRec1 = $this->connection->query($setSql);
        return $setRec1;
	}
	public function exportActiveEmployee($clientid,$comp_id,$user_id,$emp){
	    if ($emp >0 ){
    
          $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,mdsg.mast_desg_name,e.dept_id,mdpt.mast_dept_name,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  inner join mast_dept mdpt on e.dept_id = mdpt.mast_dept_id inner join mast_desg mdsg on e.desg_id =mdsg.mast_desg_id  WHERE e.client_id= $clientid AND e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
        }
        else
        
         {
        	 
          $setSql= "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.desg_id,e.dept_id,mcl.client_name as 'Client',e.client_id,e.gender,e.bdate,e.joindate,e.due_date,e.bankacno,mb.bank_name,mb.ifsc_code,mb.branch ,e.middlename_relation,e.esino,e.pfno,e.esistatus,e.adharno,e.panno,e.driving_lic_no,e.uan,e.job_status,e.email,e.emp_add1,e.pin_code,e.mobile_no,e.ticket_no,e.married_status,e.totgrsal,e.qualif from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id  inner join mast_bank mb on e.bank_id = mb.mast_bank_id  WHERE e.comp_id=$comp_id AND e.user_id=$user_id and job_status !='L'";
        	 
         }	 
    
    $setRec1 = $this->connection->query($setSql);
        return $setRec1;
	}
	
	
	
	
	
	//88888888888888888888888888888888888888888
	
	
	
	function exportEmpData($comp_id,$user_id){
	
	    $setSql= "SELECT emp.`first_name` as 'First Name',emp.`middle_name` as 'Middle Name',emp.`last_name`  as 'Last Name',emp.`gender` as Gender,emp.`bdate` as 'Birth Date',emp.`joindate` as 'Join Date',emp.`due_date` as 'Due Date',emp.`leftdate` as 'Left Date',emp.`pfdate` as 'PF Date',emp.`pfno` as 'PF No','Y' as 'ESI Status' ,`esino` as  'ESI No', mde.mast_dept_name as 'Department',mq.mast_qualif_name as 'Qualification', emp.`mobile_no` as 'Phone No',emp.`pay_mode`  as 'Pay Mode' ,emp.`bank_id`as 'Bank Name',emp.`bankacno`  as 'Bank Ac no',emp.`comp_ticket_no`  as 'Comp Ticket No',emp.`panno`  as 'PAN no',emp.`adharno`  as 'Adhar No',emp.`uan`  as 'UAN',emp.`married_status` as 'Married Status' ,emp_add1 as 'Employee Address',emp.desg_id as 'Designation' FROM `employee` emp,mast_client mc,mast_desg md,`mast_dept` mde,mast_bank mb,mast_paycode mp,mast_qualif mq,mast_location ml WHERE emp.client_id=mc.mast_client_id AND emp.desg_id=md.mast_desg_id AND mde.mast_dept_id=emp.dept_id AND emp.`qualif_id`=mq.mast_qualif_id AND emp.`bank_id`=mb.mast_bank_id AND emp.`loc_id`=ml.mast_location_id  AND emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'";
	    $setRec1 = $this->connection->query($setSql);
        return $setRec1;
	}
	
	function emportEmpProcess($comp_id){
	      $setSql = "select mast_deduct_heads_id from mast_deduct_heads where (deduct_heads_name LIKE 'P.F.' OR deduct_heads_name LIKE 'E.S.I.' OR deduct_heads_name LIKE 'PROF. TAX' OR deduct_heads_name LIKE 'L.W.F.') and comp_id ='".$comp_id."' GROUP by deduct_heads_name"; 
            $setRec1 = $this->connection->query($setSql);
        return $setRec1;
	}
	function getImportInsertEmployee($comp_id,$user_id,$emapData0,$emapData1,$emapData2,$emapData3,$empdata4,$empdata5,$empdata6,$empdata7,$empdata8,$emapData9,$empData10,$emapData11,$dept_id,$qualif_id,$emapData14,$emapData15,$bank_id,$emapData17,$emapData18,$emapData19,$emapData20,$emapData21,$emapData22,$emapData23,$desg_id,$clientid){
	      $setSql = "INSERT INTO  `employee`(`comp_id`, `user_id`,`first_name`,`middle_name`,`last_name`,`gender`,`bdate`,`joindate`,`due_date`,`leftdate`,`pfdate`,`pfno`,`esistatus`,`esino`,`dept_id`,`qualif_id`,`mobile_no`,`pay_mode`,`bank_id`,`bankacno`,`comp_ticket_no`,`panno`,`adharno`,`uan`,`married_status`,emp_add1,desg_id,client_id) VALUES ('" .$comp_id  . "','" . $user_id . "','".addslashes($emapData0)."','".addslashes($emapData1)."','".addslashes($emapData2)."',
'".addslashes($emapData3)."','".$empdata4."','".$empdata5."','".$empdata6."',
'".$empdata7."','".$empdata8."','".addslashes($emapData9)."','".$empData10."','".addslashes($emapData11)."','".$dept_id."','".$qualif_id."','".addslashes($emapData14)."','".addslashes($emapData15)."','".$bank_id."','".addslashes($emapData17)."',
'".addslashes($emapData18)."','".addslashes($emapData19)."','".addslashes($emapData20)."','".addslashes($emapData21)."','".addslashes($emapData22)."','".addslashes($emapData23)."','".$desg_id."' ,'".$clientid."')";

$setRec1 = $this->connection->query($setSql);
$empid = mysqli_insert_id($this->connection);
        return $empid;
	}
	
	
	////66666666666666666
	
	
	
		function getImportEmployeeDeduct($comp_id,$empid,$user_id,$pfid){
	     $sqlpf = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$pfid."',7,0) ";
        $setRec1 = $this->connection->query($sqlpf);
       // return $setRec1;
	}
	function getImportEmployeeDeduct1($comp_id,$empid,$user_id,$esiid){
	    $sqlesi = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$esiid."',7,0) ";
    $setRec1 = $this->connection->query($sqlesi);
        //return $setRec1;
	}
	function getImportEmployeeDeduct2($comp_id,$empid,$user_id,$proftaxid){
	     $sqlpt = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$proftaxid."',7,0) ";

        $setRec1 = $this->connection->query($sqlpt);
        //return $setRec1;
	}
	function getImportEmployeeDeduct3($comp_id,$empid,$user_id,$lwfid){
	     $sqlpt = "insert into emp_deduct(comp_id,emp_id,user_id,head_id,calc_type,std_amt) values('".$comp_id."','".$empid."','".$user_id."','".$lwfid."',7,0) ";
	     
	     $setRec1 = $this->connection->query($sqlpt);
       // return $setRec1;
 
	}

	
	
	
	/////////77777777777777777777777
	
	
		function exportEmpIncome($comp_id,$user_id,$clint_id){
	    $setSql= " SELECT distinct emp_id as 'Employee ID',`last_name` as 'Last Name',`first_name` as 'First Name',`middle_name` as 'Middle Name' FROM `employee` WHERE  `comp_id`='".$comp_id."' AND`user_id`='".$user_id."' AND employee.client_id='".$clint_id."' and employee.job_status != 'L' ";
    $setRec1 = $this->connection->query($setSql);
        return $setRec1;

	}
	function impoEmpIncomeProcess($empid,$incomeid,$comp_id,$user_id){
	    $chk="SELECT * FROM `emp_income` WHERE `emp_id`='".addslashes($empid)."' AND `head_id`='".$incomeid."' ";	
        $setRec1 = $this->connection->query($chk);
        return $setRec1;
	}
	function updateImpoEmpIncomeProcess($stdamt,$ct,$remark,$empid,$incomeid,$comp_id,$user_id){
	    $sql = "update emp_income set std_amt = '".addslashes($stdamt)."',`calc_type`='".$ct."',remark='".addslashes($remark)."' where `emp_id`='".addslashes($empid)."' AND `head_id`='".$incomeid."' ";
	    $setRec1 = $this->connection->query($sql);
        
	}
	

	
	
		function insertImpoEmpIncomeProcess($comp_id,$user_id,$empid,$incomeid,$ct,$std_amt,$rem){
	    $sql = "INSERT INTO `emp_income`(`comp_id`, `user_id`,`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`) VALUES ('" .$comp_id  . "','" . $user_id . "','".addslashes($empid)."','".$incomeid."','".$ct."','".addslashes($std_amt)."','".addslashes($rem)."',Now(),Now())";
	    $setRec1 = $this->connection->query($sql);
	}
	function impoEmpDeductProcess($empid,$deductid,$comp_id,$user_id){
	    $chk="SELECT * FROM `emp_deduct` WHERE `emp_id`='".addslashes($empid)."' AND `head_id`='".$deductid."' and `comp_id`='".$comp_id."' AND`user_id`='".$user_id."'";	
        $setRec1 = $this->connection->query($chk);
	}
	function impoUpdateEmpDeductProcess($std_amt,$ct,$remark,$empid,$deductid){
	    $sql = "update emp_deduct set std_amt = '".addslashes($std_amt)."',`calc_type`='".$ct."',remark='".addslashes($remark)."' where `emp_id`='".addslashes($empid)."' AND `head_id`='".$deductid."' and `comp_id`='".$comp_id."' AND`user_id`='".$user_id."'";
	    $this->connection->query($sql);
	}
	function impoInsertEmpDeductProcess($comp_id,$user_id,$empid,$deductid,$ct,$std_amt,$remark){
	    $sql = "INSERT INTO `emp_deduct`(`comp_id`, `user_id`,`emp_id`,`head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`) VALUES ('" .$comp_id  . "','" . $user_id . "','".addslashes($empid)."','".$deductid."','".$ct."','".addslashes($std_amt)."','".addslashes($remark)."',Now(),Now())";
	    $this->connection->query($sql);
	}
	
	
	////////////444444444444444444444
		function exportEmpTransaction($exhd,$client_id,$j,$comp_id,$user_id){
	    $setSql = "SELECT mc.mast_client_id , mc.client_name,date_format(mc.current_month,'%Y-%c-%d') as 'Sal_month',emp.`emp_id` as 'Emp_ID',concat(emp.first_name,' ',emp.middle_name,' ',emp.last_name) AS 'Employee_NAME' ";
            for($i=0; $i<$j; $i++ ){
            	$setSql =$setSql .", '' as ".$exhd[$i];
            }
 
          $setSql .= ",emp.ticket_no,md.mast_dept_name as 'CC_Code' FROM `employee` emp inner join mast_client mc  on emp.client_id = mc.mast_client_id  inner join mast_dept md on emp.dept_id= md.mast_Dept_id where emp.client_id = '".$client_id."' and emp.job_status != 'L' and emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'  order by emp.emp_id";	
       $resu = $this->connection->query($setSql);
       return $resu;
	}
	
	

	
	
	////////////////////////999999999999
	
	
	function exportTrandayTransaction($client_id,$exhd,$j){
	    $setSql = "SELECT mc.mast_client_id as 'client_id',mc.client_name 'client_name',date_format(mc.current_month,'%Y-%c-%d') as 'Sal_month',emp.`emp_id` as 'Emp ID',concat(emp.first_name,' ',emp.last_name) AS 'Employee_Name'";
       for($i=0; $i<$j; $i++ ){
	$setSql .=", '' as ".$exhd[$i];
       }             
	 $setSql .= ",emp.ticket_no,md.mast_dept_name as 'CC_Code' FROM `employee` emp inner join mast_client mc  on emp.client_id = mc.mast_client_id  inner join mast_dept md on emp.dept_id= md.mast_Dept_id where emp.client_id = '".$client_id."' and emp.job_status != 'L' and emp.`comp_id`='".$comp_id."' AND emp.`user_id`='".$user_id."'  order by emp.emp_id";
	
	$resu = $this->connection->query($setSql);
       return $resu;
	}
	

	
	

	
		//////////////////5555555555555555	


	
		function importTransactionProcess($client_id,$comp_id,$user_id){
	    $sql = "select current_month from mast_client where mast_client_id = '".$client_id."' and `comp_id`='".$comp_id."' AND `user_id`='".$user_id."'";
        $resu = $this->connection->query($sql);
       return $resu;
	}
	function getEmployeeFromTrandays($empid,$comp_id,$user_id){
	      $imp_sql = "select count(emp_id) as cnt  from tran_days where emp_id = '".addslashes($empid)."' and `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' "; 
		$imp_sql2 = $this->connection->query($imp_sql);
		$imp_sql3 = $imp_sql2->fetch_assoc();
		return $imp_sql3['cnt'];
	}
	
	
	

	
	//88888888888888888
	
	
	
	
	
	
	
	
	
	
	function updateTrandaySalMonth($client_date1,$exhd,$emapData,$j,$comp_id,$user_id){
	    $sql1 = "update tran_days set sal_month = '".$client_date1."', ";
        for($i=0; $i<$j; $i++ ){
				$sql1 =$sql1.$exhd[$i]." = '".addslashes($emapData[$i+5])."',";
			}
        $sql1= $sql1."`db_update` =now() where emp_id = '".addslashes($emapData[3])."' and `comp_id`='".$comp_id."' AND `user_id`='".$user_id."'";
        echo $sql1;
        $resu = $this->connection->query($sql1);
       return $resu;
	}
	public function updateTrandays($client_date1,$empid,$comp_id,$user_id){
	     $sql2 = "update tran_days td inner join employee emp on emp.emp_id = td.emp_id set td.sal_month = '".$client_date1."',td.`client_id` =  emp.`client_id`,td.`user_id` = emp.`user_id`,td.`comp_id` = emp.`comp_id` ,td.`sal_month` = td.`sal_month`  where td.emp_id =  '".addslashes($empid)."' and `comp_id`='".$comp_id."' AND `user_id`='".$user_id."'";
	
		$resu = $this->connection->query($sql2);
       return $resu;
	}
	public function insertTrandaysImport($tempdate,$emapData,$comp_id,$user_id,$client_id){
	       $sql = "INSERT INTO `tran_days`(sal_month,`emp_id`, `fullpay`, `halfpay`,`leavewop`, `otherleave`,`othours`, `nightshifts`,`present`, `absent`, weeklyoff,`pl`, `sl`, `cl`, `paidholiday`, `additional`, `extra_inc1`,`extra_inc2`,   `extra_ded1`,`extra_ded2`,`db_adddate`, `db_update`,`comp_id`,`user_id`,`client_id`) VALUES ('".$tempdate."','".addslashes($emapData[3])."','0','0','0','0', 
	     '".addslashes($emapData[13])."','0','".addslashes($emapData[5])."','".addslashes($emapData[7])."','".addslashes($emapData[6])."','".addslashes($emapData[8])."','".addslashes($emapData[10])."','".addslashes($emapData[9])."','".addslashes($emapData[15])."','".addslashes($emapData[14])."','".addslashes($emapData[11])."','0','".addslashes($emapData[12])."','0', NOW(),NOW(),'$comp_id','$user_id','".addslashes($emapData[0])."')";
		
			$resu = $this->connection->query($sql);
       return $resu;
	}
	public function updateTrandays1($empid,$comp_id,$user_id){
	    $sql = "update tran_days td inner join employee emp on emp.emp_id = td.emp_id set td.`client_id` =  emp.`client_id`,td.`user_id` = emp.`user_id`,td.`comp_id` = emp.`comp_id` ,td.`sal_month` = td.`sal_month`  where td.emp_id =  '".addslashes($empid)."' and `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
		$resu = $this->connection->query($sql);
       return $resu;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function selectReportPayslip($tab_days,$tab_emp,$clientid,$frdt,$todt,$empid,$emp,$zerosal){
	    $sql = "SELECT td.* FROM $tab_days td inner join $tab_emp te on td.emp_id = te.emp_id and te.sal_month = td.sal_month  WHERE td.client_id ='".$clientid."'   AND td.sal_month >= '$frdt' and td.sal_month <= '$todt' ";

         if($emp!='all'){
            $sql .= " AND td.emp_id=".$empid;
        }
        if($zerosal=='no'){
            $sql .= " AND te.gross_salary >0";
        }
        $sql .= " order by td.emp_id ";
        $resu = $this->connection->query($sql);
       return $resu;
	}
	public function getIncomeHeadForpayslip($tab_empinc,$tab_emp,$comp_id,$tran_day_emp_id,$sal_month){
    	$sql = "select ti.*,mi.income_heads_name from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join $tab_emp  te on te.emp_id =ti.emp_id and te.sal_month = ti.sal_month where mi.comp_id = '$comp_id'  and ti.emp_id = '".$tran_day_emp_id."' and  ti.sal_month = '".$sal_month."'   ";
        $sql .= " order by mi.mast_income_heads_id";
    	$resu = $this->connection->query($sql);
       return $resu;
	    
	}
	public function getDeductunHeadForPayslip($tab_empded,$comp_id,$tran_day_emp_id,$sal_month){
	    $sql = "select tdd.*,md.deduct_heads_name from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id where md.comp_id = '$comp_id'  and tdd.emp_id = '".$tran_day_emp_id."' and  tdd.sal_month = '".$sal_month."'    order by md.mast_deduct_heads_id";
		$resu = $this->connection->query($sql);
       return $resu;
	}
	public function getAdvanceHeadForPayslip($tab_adv,$tab_empded,$comp_id,$tran_day_emp_id,$sal_month){
	    $sql = "select tadv.*,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id  where mad.comp_id = '$comp_id'  and tadv.emp_id = '".$tran_day_emp_id."' and  tadv.sal_month = '".$sal_month."' and tadv.amount >0  order by mad.mast_advance_type_id";
        	$resu = $this->connection->query($sql);
       return $resu;
	}
    public function getHeadForPayslip($tab_days,$empid,$sal_month){
        $sql = "select `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`,`extra_inc2` from $tab_days where emp_id='$empid' and sal_month = '".$sal_month."' ";
	$resu = $this->connection->query($sql);
       return $resu;
    }
    
    
	
	
	
	
	
	
    public function getPayDays($tab_days,$client_id,$comp_id,$user_id,$frdt,$todt){
        $sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
       
        $row= $this->connection->query($sql_days);
        return $row;
    }
    //**********/
    public function getReportSalTranDays($tab_days,$comp_id,$user_id,$frdt,$todt){
         $sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' "; 

        if($month=='current'){
         // $sql .= "   AND sal_month = '$frdt' ";
        }else{
        	 $sql .= " AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
        }
        $row= $this->connection->query($sql);
        return $row;
    }
    function reportSalSummeryIncomeReport($tab_empinc,$clintid,$frdt,$tab_emp,$emp){
         if($emp=='Parent')
       {
        $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt  from $tab_empinc ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join employee e  on e.emp_id = ti.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND ti.sal_month = '$frdt'  group by ti.head_id ";
       }
       else
       {
        $sql="select ti.head_id ,mi.income_heads_name,sum(ti.amount) as amount,sum(ti.std_amt) as std_amt from $tab_empinc ti  inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id inner join $tab_emp e  on e.emp_id = ti.emp_id  and e.sal_month=ti.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND ti.sal_month = '$frdt'  group by ti.head_id ";
       }
		$row= $this->connection->query($sql);
        return $row;
    }
    public function reportSalSummeryDeductionReport($emp,$tab_empded,$clintid,$frdt,$tab_emp){
        if($emp=='Parent')
       {
	 	 	$sql="select tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clintid."'   AND tdd.sal_month = '$frdt'  group by tdd.head_id ";
       }
       else
       {
			$sql="select tdd.head_id ,md.deduct_heads_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join $tab_emp e  on e.emp_id = tdd.emp_id and e.sal_month = tdd.sal_month inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clintid."'  AND tdd.sal_month = '$frdt'  group by tdd.head_id ";

       }
	   $row= $this->connection->query($sql);
        return $row;
    }
    public function reportSalSummeryAdvanceReport($emp,$tab_adv,$clintid,$comp_id,$frdt,$todt){
        if($emp=='Parent')
       {
	    $sql = "select sum(tadv.amount) as amount ,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where mc.parentId =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.parentId,mad.mast_advance_type_id";
	   }
	   else
	   {
	 $sql = "select sum(tadv.amount) as amount,mad.advance_type_name from $tab_adv tadv inner join mast_advance_type mad on tadv.head_id = mad.mast_advance_type_id inner join mast_client mc on mc.mast_client_id = tadv.client_id where tadv.client_id =  '".$clintid."' and  mad.comp_id = '$comp_id'   and  tadv.sal_month >= '$frdt' AND tadv.sal_month <= '$todt'   group by mc.mast_client_id,mad.mast_advance_type_id";}
    
    $row= $this->connection->query($sql);
        return $row;
    }
    function sumReportSalSummeryReport($emp,$tab_days,$clintid,$frdt){
         if($emp=='Parent')
       {
 			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.parentid  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
       }
       else
       {
			$sql = "select sum(extra_inc2) as extra_inc2,sum(halfpay) as halfpay,sum(leavewop) as leavewop,sum(present) as present,sum(absent)as absent,sum(weeklyoff) as weeklyoff,sum(pl) as pl,sum(sl) as sl,sum(cl) as cl,sum(otherleave) as otherleave,sum(paidholiday) as paidholiday,sum(additional) as additional,sum(othours) as othours,sum(nightshifts) as nightshifts from $tab_days inner join mast_client on mast_client.mast_client_id = $tab_days. client_id  where mast_client.mast_client_id  =  '".$clintid."'  AND $tab_days.sal_month = '$frdt' GROUP by parentid";
       }
       $row= $this->connection->query($sql);
        return $row;
    }
    function sumNetsalReportSalSummery($tab_emp,$clintid,$frdt,$emp){
        if($emp=='Parent')
       {
 		$sqltotal = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.parentid  =  '".$clintid."'  AND $tab_emp.sal_month = '$frdt' GROUP by parentid";
 	   }
	   else{
 		  $sqltotal = "select count(emp_id) as totalemp,sum(netsalary) as netsalary,sum(payabledays) as payabledays,sum(tot_deduct) as tot_deduct,sum(gross_salary) as gross_salary from $tab_emp inner join mast_client  on mast_client.mast_client_id = $tab_emp. client_id  where mast_client.mast_client_id   =  '".$clintid."'  AND $tab_emp.sal_month = '$frdt' GROUP by client_id";
       }
	   $row= $this->connection->query($sqltotal);
        return $row;
    }
    function reportPayslipSendMail($tab_days,$clintid,$frdt,$todt,$emp,$empid){
        $sql = "SELECT * FROM $tab_days WHERE client_id ='".$clintid."' AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
        if($emp!='all'){
            
            $sql .= " AND emp_id=".$empid;
        }
        $row= $this->connection->query($sql);
        return $row;
    }
    function addcheckDetails($emp,$check_no,$cmonth,$amount,$date1){
        $sql="insert into cheque_details(emp_id,check_no,sal_month,amount,date,type,db_addate) values('".$emp."','".$check_no."','$cmonth','".$amount."','".date('Y-m-d',strtotime($date1))."','S',now())";
         $row= $this->connection->query($sql);
        return $row;
    }
    function updatecheckDetails($date1,$check_no,$cmonth,$amount,$emp){
        $sql="update cheque_details set date='".date('Y-m-d',strtotime($date1))."',check_no='".$check_no."',amount='".$amount."',sal_month='".$cmonth."', db_update=now() where emp_id='".$emp."' and sal_month='".$cmonth."' and type = 'S'";
        $row= $this->connection->query($sql);
        return $row;
    }
    function getCheckPrintTypeS($cmonth){
        $sql ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='S' and sal_month='$cmonth' ";
        $row= $this->connection->query($sql);
        return $row;
    }
    function getCheckPrintTypeB($startday,$endday){
        $select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='B' and 
	from_date='$startday' and to_date = '$endday'";
	$row= $this->connection->query($select);
        return $row;
    }
    function getCheckPrintTypeL($payemnt_date){
        $select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='L' and 
	        payment_date='$payemnt_date'";
	$row= $this->connection->query($select);
        return $row;
    }/**/
    function getChecksDetails($type,$cmonth,$startday,$endday,$payemnt_date,$empid,$client){
        	if ($type =="S"){
	    
 $select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='S' and sal_month='$cmonth' ";}
    if ($type== "B")
	{
	$select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='B' and 
	from_date='$startday' and to_date = '$endday'";

	}
	if ($type== "L")
	{
	 $select ="select c.*,e.first_name,e.first_name,e.middle_name,e.last_name,e.bankacno,mc.comp_name from cheque_details c inner join employee e on c.emp_id = e.emp_id  inner join mast_company mc on e.comp_id = mc.comp_id where c.type ='L' and 
	payment_date='$payemnt_date'";
	
	}
	if($empid> 0){
	$select .=" and c.emp_id ='".$empid."'";	
	}else{
	$select .=" and e.client_id='".$client."' ";
	}
	$row= $this->connection->query($select);
        return $row;
    }
    function displayemployee2($comp_id,$user_id,$clientid,$arr){
         $sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND user_id='".$user_id."' AND client_id='".$clientid."' ";
            if(sizeof($arr)>=1) {
                if ($arr[0] != '' && isset($arr[0])) {
                    $sql .= " AND first_name Like '%" . $arr[0] . "%' ";
                }
            }
        if(sizeof($arr)>=2) {
            if ($arr[1] != '' && isset($arr[2])) {
                $sql .= " AND middle_name Like '%" . $arr[1] . "%' ";
            }
        }
        if(sizeof($arr)==3) {
            if ($arr[2] != '' && isset($arr[3])) {
                $sql .= " AND last_name Like '%" . $arr[2] . "%' ";
            }
        }
         $sql .= " limit 10";
         	$row= $this->connection->query($sql);
        return $row;
        
    }
    function getCheckPrintTypeSFroPrint($client,$comp_id,$user_id,$sal_month){
        $setSql= "SELECT e.emp_id,concat(e.first_name,' ' ,e.middle_name,' ' ,e.last_name) as name ,mcl.client_name as 'Client',cd.check_no,cd.date,cd.amount,cd.type from employee e inner join mast_client mcl on e.client_id = mcl.mast_client_id inner join cheque_details cd on cd.emp_id = e.emp_id WHERE e.client_id= $client AND e.comp_id=$comp_id AND e.user_id=$user_id and cd.sal_month = '".$sal_month."'"; 
        $row= $this->connection->query($setSql);
        return $row;
    }
    function getChecklistTypeS($emp,$tab_emp,$clintid,$frdt){
        if($emp=='Parent'){
	    
	 $selgtemp ="select * 
	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
	 inner join mast_client mc on te.client_id = mc.mast_client_id 
	 where mc.parentid = '$clintid' and te.sal_month = '$frdt' and te.pay_mode = 'C' order by e.pay_mode,te.emp_id";
	}else {
	    $selgtemp ="select  te.*,e.first_name,e.middle_name,e.last_name, cd.check_no,cd.date from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.sal_month = te.sal_month and cd.type = 'S'
	 where te.client_id = '$clintid' and te.sal_month = '$frdt' and te.pay_mode = 'C' and te.netsalary>0  order by e.pay_mode ,te.emp_id";
	}

	
	$row= $this->connection->query($selgtemp);
        return $row;
    }
    
	
	
	
	
	
	
	
	
	
	
	
	
    function getChecklistTypeB($clintid,$endday,$startday){
        $selgtemp ="select   te.tot_bonus_amt+te.tot_exgratia_amt  as netsalary,te.*,e.first_name,e.middle_name,e.last_name, cd.check_no,cd.date from bonus te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id
	 where te.client_id = '$clintid' and cd.type = 'B' and te.from_date = '$startday' and todate = '$endday' and te.pay_mode = 'C' and te.tot_bonus_amt+te.tot_exgratia_amt >0  order by e.pay_mode ,te.emp_id";
	
	    $row= $this->connection->query($selgtemp);
        return $row;
    }
    function getChecklistTypeBBlankRec($clintid,$endday,$startday){
        $sql ="select  cd.date from bonus te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.from_date = te.from_date and  cd.to_date = te.todate and cd.type = 'B'
	 where te.client_id = '$clintid' and te.from_date = '$startday' and todate = '$endday' and te.pay_mode = 'C' and te.tot_bonus_amt+te.tot_exgratia_amt >0  limit 1 ";
	 $row= $this->connection->query($sql);
        return $row;
    }
    function getChecklistTypeSBlankRec($clintid,$frdt,$tab_emp){
        $sql ="select  cd.date from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join cheque_details cd on cd.emp_id = te.emp_id and cd.sal_month = te.sal_month and cd.type = 'S'
	 where te.client_id = '$clintid' and cd.sal_month = '$frdt'  and te.pay_mode = 'C' and te.netsalary>0  limit 1";
	 $row= $this->connection->query($sql);
        return $row;
    }
    function getReportLeaveNeft($desc,$comp,$tab_emp,$comp_id,$clintid,$frdt){
        $sql= "SELECT te.netsalary as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id  in (".$comp_id.")  AND  te.client_id  in (".$clintid.") and te.sal_month = '$frdt' and te.netsalary > 0 and te.pay_mode = 'N' ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  
				 
				
        

        $row= $this->connection->query($sql);
        return $row;
    }
    function getSumReportLeavPaymenteNeft($desc,$comp,$comp_id,$clintid,$payment_date){
        $sql11= "SELECT te.amount as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from leave_details te  inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id ='".$comp_id."' AND   te.client_id in  (".$clintid.") and te.payment_date = '$payment_date' and te.amount > 0 and te.pay_mode = 'N'  ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  
    
    $row= $this->connection->query($sql11);
        return $row;
    }
    function getSumReportLeavPaymenteNeft1($comp_id,$clintid,$payment_date){
       
	$sql21 = "select sum(te.amount) as totamount from leave_details te  where comp_id ='".$comp_id."'   and client_id in  (".$clintid.")   and payment_date = '$payment_date' and te.pay_mode = 'N' ";
    $row= $this->connection->query($sql21);
        return $row;
    }
    function getbonueReportLeaveAmt($desc,$comp,$tab_emp,$comp_id,$clintid,$frdt,$todt,$days,$client_name,$reporttitle){
        $sql11= "SELECT round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount,mc.bankacno as bankacno,mc.comp_name,mb.ifsc_code,te.bankacno as beneficiary_acno ,'10' as type,concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS name, e.pin_code,'".$desc ."' as descri, '".$comp."' as Originator from $tab_emp te inner join employee e on te.emp_id = e.emp_id inner join mast_bank mb on mb.mast_bank_id = te.bank_id inner join mast_company mc on mc.comp_id = te.comp_id where te.comp_id ='".$comp_id."'   and te.client_id in  (".$clintid.") and te.from_date = '$frdt' and  te.todate = '$todt' and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'N'  and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ORDER BY te.bank_id, te.Client_id,te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
  
	$reporttitle2 = $reporttitle;
	$reporttitle3 = " Client : ".$client_name;

	$row= $this->connection->query($sql11);
        return $row;
        
    }
    function getSumLeaveNeftLetter($comp_id,$user_id,$clintid,$frdt,$todt,$days,$tab_emp){
        $sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0) ) as totamount from $tab_emp te inner join employee e on te.emp_id = e.emp_id where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."'   and te.client_id in  (".$clintid.")   and te.from_date = '$frdt' and  te.todate = '$todt'  and te.pay_mode = 'N'  and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days  and e.prnsrno !='Y'";
        $row= $this->connection->query($sql21);
        return $row;
    }
    function getSumReportLeaveNeft($tab_emp,$comp_id,$user_id,$clintid,$frdt){
        $sql21 = "select sum(te.netsalary) as totamount from $tab_emp te  where comp_id ='".$comp_id."' AND user_id='".$user_id."'  and client_id in  (".$clintid.")   and te.sal_month = '$frdt'  and te.pay_mode = 'N' ";
        $row= $this->connection->query($sql21);
        return $row;
    }
    function getExportLeaveBankNeftFormt($desc,$tab_emp,$clintid,$frdt){
        $setSql= "SELECT te.netsalary,mc.bankacno as sender_bankacno,mb.ifsc_code,te.`bankacno` as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address','".$desc ."' as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id  inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$clintid.") and e.pay_mode = 'N' and sal_month = '$frdt' ";
        $row= $this->connection->query($setSql);
        return $row;
    }
    function getExportLeaveBankNeftFormtPayB($desc,$tab_emp,$clintid,$frdt,$todt,$days){
        $setSql= "SELECT  round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount ,mc.bankacno as sender_bankacno,mb.ifsc_code,te.`bankacno` as beneficiary_acno ,'10' as 'Account Type',concat(e.first_name,' ',e.middle_name,' ',e.last_name) AS 'Beneficiary Customer Name', e.pin_code as 'Beneficiary Customer Address','".$desc ."' as 'Sender to Receiver Information', mc.comp_name as 'Originator Of Remittance' FROM $tab_emp te inner join employee e on e.emp_id = te.emp_id inner join mast_company mc on te.comp_id = mc.comp_id  inner JOIN mast_bank mb on te.bank_id = mb.mast_bank_id where te.client_id in (".$clintid.") and te.pay_mode = 'N' and te.from_date = '$frdt' and  te.todate = '$todt' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  ";
        $row= $this->connection->query($setSql);
        return $row;
    }
    function reportLeaveBankSalay($tab_emp,$comp_id,$clintid,$frdt,$todt){
        $sql = "select distinct bank_id, mb.* from $tab_emp te inner join mast_bank mb on te.bank_id = mb.mast_bank_id where te.comp_id = '$comp_id' and  te.client_id in ($clintid) and te.from_date = '$frdt' and  te.todate = '$todt'  order by mb.bank_name ";  

        $row= $this->connection->query($sql);
        return $row;
    }
	
	function reportLeaveBankSalaryPayT($tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt){
	    $sql = "select te.emp_id,te.netsalary as amount ,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$mast_bank_id."'  and te.client_id in (' ".$clintid."') and te.sal_month = '$frdt' and te.netsalary > 0 and te.pay_mode = 'T' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function reportLeaveBankSalaryPayT2($tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt){
	    $sql21 = "select sum(te.netsalary) as amount from $tab_emp te  where comp_id ='".$comp_id."' AND user_id='".$user_id."' AND bank_id='".$mast_bank_id."' and client_id in ('".$clintid."')   and te.sal_month = '$frdt' and te.pay_mode = 'T'";
	    $row= $this->connection->query($sql21);
        return $row;
	}
	function reportLeaveBankSalaryPayL($tab_emp,$comp_id,$mast_bank_id,$clintid,$frdt){
	    $sql11 = "select te.emp_id,te.amount,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND  te.bank_id='".$mast_bank_id."'  and te.client_id = '".$clintid."' and te.payment_date = '$frdt' and te.amount > 0 and te.pay_mode = 'T' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	    $row= $this->connection->query($sql11);
        return $row;
	    
	}
	function reportLeaveBankSalaryPayL2($tab_emp,$comp_id,$mast_bank_id,$clintid,$frdt){
	    $sql21 = "select sum(te.amount) as amount from $tab_emp te  where comp_id ='".$comp_id."'  AND bank_id='".$mast_bank_id."' and client_id = '".$clintid."'   and te.payment_date = '$frdt' and te.pay_mode = 'T'";
	    $row= $this->connection->query($sql21);
        return $row;
	}
	function reportLeaveBankSalaryPayB($tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt,$todt,$days){
	    
	     $sql11 = "select te.emp_id,round(te.tot_bonus_amt +te.tot_exgratia_amt,0) as amount ,e.first_name,e.middle_name,e.last_name,te.bankacno from $tab_emp te inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$mast_bank_id."'  and te.client_id = '".$clintid."' and te.from_date = '$frdt' and  te.todate = '$todt'  and round(te.tot_bonus_amt +te.tot_exgratia_amt,0) > 0 and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y' ORDER BY te.bankacno,e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	     $row= $this->connection->query($sql11);
         return $row;
	}
	function reportLeaveBankSalaryPayB2($tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt,$todt,$days){
	    $sql21 = "select sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)) as amount from $tab_emp te   inner join employee e on te.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND te.bank_id='".$mast_bank_id."' and te.client_id = '".$clintid."'   and te.from_date = '$frdt' and  te.todate = '$todt'  and te.pay_mode = 'T' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'";
	    $row= $this->connection->query($sql21);
        return $row;
	}
	function createUserTempExportleaveBankTransfer($tab){
	    $sql = "create table $tab (  `bankacno` varchar(30) not null,`curr_code` varchar(30) not null, `outlet` varchar(30) not null, `tran_type` varchar(30) not null,`tran_amt` varchar(30) not null,`perticulars` varchar(50) not null,`refno`  INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`refno`),`ref_amt` varchar(30) not null,`r_cur_code` varchar(30) not null  ) ENGINE = InnoDB";;
        	$row= $this->connection->query($sql);
        return $row;
	}
	function insertUserTempExportleaveBankTransfer($tab,$desc,$tab_emp,$clintid,$frdt){
	    	$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',te.netsalary,'$desc',te.netsalary,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id  
	where  te.client_id in ($clintid) and te.sal_month = '$frdt' and e.pay_mode = 'T' and mb.bank_name like '%IDBI%'";

	$row= $this->connection->query($sql);
        return $row;
	}
	function insertUserTempExportleaveBankTransfer2($tab,$desc,$tab_emp,$clintid,$frdt){
	    $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.netsalary),'$desc',sum(te.netsalary),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  te.sal_month >= '$frdt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%'";
	$row= $this->connection->query($sql);
        return $row;
	}
	function insertUserTempExportleaveBankTransferL($tab,$desc,$tab_emp,$clintid,$frdt){
	    $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',te.amount,'$desc',te.amount,'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id  
	where  te.client_id   in ($clintid) and te.payment_date = '$frdt' and e.pay_mode = 'T' and mb.bank_name like '%IDBI%' ";
	$row= $this->connection->query($sql);
        return $row;
	    
	}
	function insertUserTempExportleaveBankTransferL2($tab,$desc,$tab_emp,$clintid,$frdt){
	     $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(te.amount),'$desc',sum(te.amount),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where  te.payment_date >= '$frdt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%'";
	$row= $this->connection->query($sql);
        return $row;
	    
	}
	function insertUserTempExportleaveBankTransferB($tab,$desc,$tab_emp,$clintid,$frdt,$todt,$days){
	    $sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select te.`bankacno`,'INR','459','C',round(te.tot_bonus_amt +te.tot_exgratia_amt,0),'$desc',round(te.tot_bonus_amt +te.tot_exgratia_amt,0),'INR' from $tab_emp te  inner join employee e on e.emp_id = te.emp_id  inner join mast_client t3 on te.client_id= t3.mast_client_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id  
	where  te.client_id in ($clintid) and te.from_date = '$frdt' and  te.todate = '$todt' and te.pay_mode = 'T' and mb.bank_name like '%IDBI%' and  (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  ";
	$row= $this->connection->query($sql);
        return $row;
	}
	function insertUserTempExportleaveBankTransferB2($tab,$desc,$tab_emp,$clintid,$frdt,$todt,$days){
    	$sql = "insert into $tab (  `bankacno` ,`curr_code` , `outlet` , `tran_type` ,`tran_amt` ,`perticulars`  ,`ref_amt` ,`r_cur_code`) select mc.`bankacno`,'INR','459','D',sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)),'$desc',sum(round(te.tot_bonus_amt +te.tot_exgratia_amt,0)),'INR' from mast_company mc  inner join $tab_emp te on te.comp_id = mc.comp_id inner join mast_bank mb on te.bank_id = mb.mast_bank_id   where te.from_date = '$frdt' and  te.todate = '$todt' and te.client_id  in ($clintid)  and te.pay_mode = 'T' and mb.bank_name like '%IDBI%' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=$days and e.prnsrno !='Y'  ";
	$row= $this->connection->query($sql);
        return $row;
	}
	function selectTab($tab){
	    $sql = "select * from $tab";
        $row= $this->connection->query($sql);
        return $row;
	    
	}
	function getEmployeeReportBankStatemant($emp,$tab_emp,$clintid,$bid,$frdt){
	    if($emp=='Parent'){
    	 $selgtemp ="select * 
    	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
    	 inner join mast_client mc on te.client_id = mc.mast_client_id 
    	 where mc.parentid = '$clintid' and te.bank_id = '$bid' and te.sal_month = '$frdt' order by e.pay_mode,te.bankacno";
    	}else {
    	 $selgtemp ="select * 
    	 from $tab_emp te inner join employee e on te.emp_id = e.emp_id
    	 where te.client_id = '$clintid' and te.bank_id = '$bid' and te.sal_month = '$frdt' order by e.pay_mode ,te.bankacno";
    	}
    	$row= $this->connection->query($selgtemp);
        return $row;
	}
	function getReportBankDeductionLetter($tab_deduct,$tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt){
	    $sql11 = "select tdd.emp_id,tdd.amount as amount ,e.first_name,e.middle_name,e.last_name,ed.remark from $tab_deduct tdd  inner join emp_deduct ed on ed.emp_id = tdd.emp_id and tdd.bank_id =ed.bank_id inner join $tab_emp te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month inner join employee e on tdd.emp_id = e.emp_id  where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND tdd.bank_id='".$mast_bank_id."'  and te.client_id = '".$clintid."' and tdd.sal_month = '$frdt' and tdd.amount>0  ORDER BY e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	    $row= $this->connection->query($sql11);
        return $row;
	}
	function getReportBankDeductionLetter2($tab_deduct,$tab_emp,$comp_id,$user_id,$mast_bank_id,$clintid,$frdt){
	    $sql21 = "select sum(tdd.amount) as amount from $tab_deduct tdd inner join $tab_emp te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month where te.comp_id ='".$comp_id."' AND te.user_id='".$user_id."' AND tdd.bank_id='".$mast_bank_id."' and client_id = '".$clintid."'   and tdd.sal_month = '$frdt' ";
	    
	    $row= $this->connection->query($sql21);
        return $row;
	}
	function getDistinctEsiCode($comp_id,$clientid,$emp){
	    if($emp=='Parent')
    	{
      	$sql = "select distinct esicode from mast_client where comp_id = '$comp_id' and esicode!= '.' order by esicode";	}
        else{
        	$sql = "select distinct esicode from mast_client where mast_client_id = '$clientid' and esicode!= '.' order by esicode";	
        }
         $row= $this->connection->query($sql);
        return $row;
        
	}
	function getReportEsiStatement($emp,$tab_empded,$tab_days,$tab_emp,$esicode,$comp_id,$clientid,$month,$frdt,$todt){
	    if($emp=='Parent')
		{ 
	
	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$esicode."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."')  ";
		}
		else{
		$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t4.payabledays,t2.bdate,t4.client_id,t4.esino,t2.joindate,t5.esicode,t5.client_name FROM $tab_empded t1 inner join  employee t2 on t2.emp_id = t1.emp_id inner join $tab_days t3 on t3.emp_id= t1.emp_id and t1.sal_month = t3.sal_month  inner join $tab_emp t4 on t4.emp_id= t1.emp_id and t4.sal_month = t1.sal_month  inner join mast_client t5 on t4.client_id = t5.mast_client_id where t5.esicode = '".$esicode."' and  t5.mast_client_id='".$clientid."' and t1.amount>0  AND t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%E.S.I.%'  and comp_id ='".$comp_id."') ";
		
		}
			if($month=='current'){
				$sql .= "   AND t1.sal_month = '$frdt' ";
					}else{
				$sql .= " AND t1.sal_month >= '$frdt' AND t1.sal_month <= '$todt' ";
			}
			 $sql .= "order by t5.esicode,client_id, t4.esino";
			
			$row= $this->connection->query($sql);
        return $row;
	}
	function getReportEsiSummery($tab_empded,$tab_emp,$comp_id,$frdt){
	    $sql = "SELECT te.client_id,d.client_name,sum(t.std_amt) as std_amt,sum(t.amount) as amount,sum(te.gross_salary) as gross_salary ,sum(t.employer_contri_1) as employer,count(t.emp_id) as cnt  FROM $tab_empded t  inner join $tab_emp te on te.emp_id = t.emp_id  and t.sal_month = te.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id inner join mast_client d on te.client_id = d.mast_client_id WHERE md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id ";
		
        $sql .=" and t.sal_month ='$frdt' and t.amount >0 ";		
        $sql .=" group by te.client_id";
        
        $row= $this->connection->query($sql);
        return $row;
	}
	function getReportEsiSummery2($tab_empded,$tab_emp,$comp_id,$frdt){
	    $sql = "SELECT te.client_id,d.client_name,sum(t.std_amt) as std_amt,sum(t.amount) as amount,sum(te.gross_salary) as gross_salary ,sum(t.employer_contri_1) as employer,count(t.emp_id) as cnt  FROM $tab_empded t  inner join $tab_emp te on te.emp_id = t.emp_id  and t.sal_month = te.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id inner join mast_client d on te.client_id = d.mast_client_id WHERE md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id ";
		
        $sql .=" and t.sal_month ='$frdt' and t.amount >0 ";		
        $sql .=" group by te.comp_id";
        $row= $this->connection->query($sql);
        return $row;
	}
	function getEsiWithoutEsiSummeryStatement($tab_emp,$comp_id,$tab_empded,$frdt){
	    $sql = "select td.sal_month,c.client_name,c.mast_client_id,c.client_name,td.emp_id,  e.first_name,e.middle_name,e.last_name,td.gross_salary from $tab_emp td inner join employee e on td.emp_id = e.emp_id inner join mast_client c on td.client_id = c.mast_client_id where  td.sal_month = '$frdt' and td.netsalary >0 and  td.comp_id= '$comp_id'   and td.emp_id not in (select emp_id from $tab_empded where sal_month = '$frdt' and amount>0 and head_id in (select md.mast_deduct_heads_id from mast_deduct_heads md where md.deduct_heads_name like '%E.S.I.%'and  comp_id= '$comp_id'  ) ) order by td.sal_month,td.client_id,td.emp_id";
		 $row= $this->connection->query($sql);
        return $row;
	    
	}
	function getReportContributionEsiStatement($tab_empded,$tab_emp,$frdt,$todt,$clientid,$comp_id){
 	    $sql = "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.esino,sum(te.payabledays) as payabledays, sum(tdd.std_amt) as wages,round(sum(tdd.amount),0) as employee_contri , round(sum(tdd.std_amt)/sum(te.payabledays),2) as daiily_wages,e.leftdate,e.joindate  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id   WHERE tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and te.client_id = $clientid and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id group by tdd.emp_id";
		$row= $this->connection->query($sql);
        return $row;
	}
	function getReportContributionEsiTotal($tab_empded,$tab_emp,$frdt,$todt,$clientid,$comp_id){
	     $sql = "SELECT e.emp_id,e.first_name,e.middle_name,e.last_name,e.esino,sum(te.payabledays) as payabledays, sum(tdd.std_amt) as wages,round(sum(tdd.amount),0) as employee_contri , round(sum(tdd.std_amt)/sum(te.payabledays),2) as daiily_wages,e.leftdate,e.joindate  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id   WHERE tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and te.client_id = $clientid and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id group by te.client_id";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function exportEsi($tab_empded,$tab_emp,$frdt,$comp_id){
	     $sql = "SELECT mc.esicode,te.esino,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name,te.payabledays, tdd.std_amt as wages,tdd.amount as employee_contribution, tdd.employer_contri_1 as employer_contri, '' as reason,e.leftdate as last_working_day  FROM $tab_empded tdd inner join employee e on e.emp_id = tdd.emp_id inner join $tab_emp te on te.sal_month = tdd.sal_month and te.emp_id=tdd.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id inner join mast_client mc on te.client_id=mc.mast_client_id  WHERE tdd.sal_month = '$frdt' and md.`deduct_heads_name` LIKE '%E.S.I.%'  and md.comp_id =$comp_id  and tdd.amount >0 order by mc.esicode,te.esino";
        $row= $this->connection->query($sql);
        return $row;
	}
	function getReportPt($clintid,$comp_id,$emp,$tab_empded,$month,$frdt,$todt){
	    if($emp=='Parent')
        {
        	$sql = "SELECT t1.amount,t2.first_name,t2.middle_name,t2.last_name FROM $tab_empded t1 inner join employee t2 on t2.emp_id = t1.emp_id  inner join  mast_client t3 on t3.mast_client_id = t2.client_id where t3.parentid = '".$clintid."' and  head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id ='".$comp_id."') ";
        }
        else{
        	$sql = "SELECT t1.amount,t2.first_name,t2.middle_name,t2.last_name FROM $tab_empded t1 inner join employee t2 on t2.emp_id = t1.emp_id  where t2.client_id = '". $clintid."' and  head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id ='".$comp_id."') ";
        }
        
        if($month=='current'){
         $sql .= " AND t1.sal_month='".$frdt."' ";}
        else{
          $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
        }
        $sql .="order by t2.last_name,t2.first_name,t2.middle_name";
       $row= $this->connection->query($sql);
        return $row; 
	}
	function reportPtSummery($comp_id,$sal_month){
	     $sql = "SELECT mc.client_name, sum(te.gross_salary) as ssalary ,sum(tdd.amount) as amount,tdd.amount as slab ,count(tdd.amount) as count,e.gender FROM tran_deduct tdd inner join employee e on tdd.emp_id = e.emp_id inner join tran_employee te on tdd.sal_month = te.sal_month and tdd.emp_id = te.emp_id  inner join mast_client mc on mc.mast_client_id = te.client_id where head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%Prof. Tax%'  and comp_id =$comp_id) and tdd.sal_month = '".$sal_month."' group by te.client_id ,e.gender,tdd.amount ";
        $row= $this->connection->query($sql);
        return $row; 
	}
	function getReportPfStatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt){
	    if($emp=='Parent')
        	{
        	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1 inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        	}
        else{
         	$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        }
         $sql .= " AND t1.sal_month='".$frdt."' ";
        
         $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
        $row= $this->connection->query($sql);
        return $row; 
	}
	function getPfCharge($frdt){
	    $sql = "select * from pf_charges where '".$frdt."' >=from_date and '".$frdt."' <= to_date";
			$row= $this->connection->query($sql);
        return $row;
	}
	function reportPfStatSummery($emp,$tab_empded,$clientid,$frdt,$comp_id){
	    if($emp=='Parent')
       {
	  		 $sql="select e.client_id,tdd.head_id ,mc.client_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.parentId  = '".$clientid."'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') group by mc.mast_client_id  ";
			
       }
       else
       {
			$sql="select  e.client_id,tdd.head_id ,mc.client_name,sum(tdd.amount) as amount,sum(tdd.std_amt) as std_amt,sum(tdd.employer_contri_1) as employer_contri_1,sum(tdd.employer_contri_2) as employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id  = '".$clientid."'  AND tdd.sal_month = '$frdt'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') group by mc.mast_client_id ";
       }
        $row= $this->connection->query($sql);
        return $row;
	}
	function getTotalEmployeeByClient($tab_emp,$client_id,$frdt){
	    $sqlemp = "SELECT count(*) as totemp FROM $tab_emp t inner join mast_client mc on t.client_id = mc.mast_client_id  where mc.mast_client_id = '".$client_id."' and  t.sal_month ='".$frdt."' group by mc.mast_client_id ";
	    $totemp = $this->connection->query($sqlemp);
        $totemp1=$totemp->fetch_assoc();
        $totemp=$totemp1['totemp'];
        return $totemp;
	}
	function getTotalEmployeePfEployeeByClient($tab_empded,$client_id,$frdt,$comp_id){
	    $sqlpfemp = "SELECT count(*) as totpfemp FROM $tab_empded t inner join employee e on e.emp_id = t.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id  where mc.mast_client_id = '".$client_id."' and  t.sal_month ='".$frdt."'  AND t.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%P.F.%'  and comp_id ='".$comp_id."') and amount >0  group by mc.mast_client_id";
	    $totemp = $this->connection->query($sqlpfemp);
        $totemp1=$totemp->fetch_assoc();
        $totemp=$totemp1['totpfemp'];
	    return $totemp;
	}
	function deleteTable($table){
	     $sql = "delete from `".$table."`";
        $row= $this->connection->query($sql);
	}
	function reportPfUANEcr($emp,$tab_empded,$tab_days,$tab_emp,$clintid,$frdt,$comp_id){
	    if($emp=='Parent')
        	{
        	   $sql = "select e.client_id,tdd.head_id ,mc.client_name,t4.gross_salary,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name,round(t5.absent,0) as absent from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id inner join $tab_days t5  on tdd.emp_id = t5.emp_id and tdd.sal_month = t5.sal_month  inner join  $tab_emp t4 on t4.emp_id = tdd.emp_id  and t4.sal_month = tdd.sal_month where tdd.amount>0 and mc.parentId = '$clintid' AND tdd.sal_month = '$frdt' and  tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='$comp_id') AND tdd.sal_month='$frdt'" ;
        	
        	}
        else{
        	   $sql = "select e.client_id,tdd.head_id ,mc.client_name,t4.gross_salary,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name,round(t5.absent,0) as absent from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id inner join $tab_days t5  on tdd.emp_id = t5.emp_id and tdd.sal_month = t5.sal_month  inner join  $tab_emp t4 on t4.emp_id = tdd.emp_id  and t4.sal_month = tdd.sal_month where tdd.amount>0 and mc.mast_client_id = '$clintid' AND tdd.sal_month = '$frdt' and  tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='$comp_id') AND tdd.sal_month='$frdt'" ;
        }
        
        $row= $this->connection->query($sql);
        return $row; 
	}
	function insertReportPfUANEcr($chr3439,$uan,$first_name,$middle_name,$last_name,$gross_salary,$std_amt,$amount,$employer_contri_2,$employer_contri_1,$absent){
	    	$sql1= "insert into uan_ecr (uan ,memname ,gross_wages ,epf_wages,eps_wages ,edli_wages,epf_contribution,eps_contribution,epf_eps_d ,ncp_days,refund) values (";
	
	//$sql1= $sql1."concat(".$chr3439.",'".$uan."'),concat('".$first_name." "."', '".$middle_name." "."', '".$last_name."'),'".$gross_salary."','".$std_amt;
$sql1= $sql1.$uan.",concat('".$first_name." "."', '".$middle_name." "."', '".$last_name."'),'".$gross_salary."','".$std_amt;

	if ($std_amt>15000)
	{
		 $sql1=$sql1."','15000','15000','";
		}
	 else{
		 $sql1=$sql1."','".$std_amt."','".$std_amt."','";
	 }
	 $sql1=$sql1.$amount."','".$employer_contri_2."','".$employer_contri_1."','".$absent."','0')";

	$row= $this->connection->query($sql1);
        return $row; 
	}
	function selectuanecr($uan){
	    $setSql = "select * from ".$uan;
	    $row= $this->connection->query($setSql);
        return $row;
	}
	function parentAllEmpCountPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(emp_id) cnt from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentAllEmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id where t3.parentId = '".$clientid."' and sal_month ='".$frdt."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentAllEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join  mast_client t3 on te.client_id= t3.mast_client_id inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  where t3.parentId = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentLeftEmpCountPfSalReport($tab_emp,$tab_days,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."' and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentLeftEmpTotalPfSalReport($tab_emp,$tab_days,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."'  and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentLeftEmpPfSalReport($tab_empded,$tab_emp,$tab_days,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join  mast_client t3 on te.client_id= t3.mast_client_id inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where t3.parentId = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentNewEmpCountPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."' and month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentNewEmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	     $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."'  and  month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	     $row= $this->connection->query($sql);
        return $row;
	}
	function parentNewEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join  mast_client t3 on te.client_id= t3.mast_client_id inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentage58EmpPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."' and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58  ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentAge58EmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."'  and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58 ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function parentAge58EmpPfSalReport1($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join  mast_client t3 on te.client_id= t3.mast_client_id inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function allEmpCountPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(emp_id) cnt from $tab_emp  where client_id = '".$clientid."' and sal_month ='".$frdt."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function allEmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp  where client_id = '".$clientid."' and sal_month ='".$frdt."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function allEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	$sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  where te.client_id = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'";
	$row= $this->connection->query($sql);
        return $row;
	}
	function leftEmpCountPfSalReport($tab_emp,$tab_days,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te  inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where te.client_id = '".$clientid."' and te.sal_month ='".$frdt."' and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function leftEmpTotalPfSalReport($tab_emp,$tab_days,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where te.client_id  = '".$clientid."' and te.sal_month ='".$frdt."'  and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function leftEmpPfSalReport($tab_empded,$tab_emp,$tab_days,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  inner join $tab_days td on td.emp_id = te.emp_id and td.sal_month = te.sal_month where te.client_id  = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and td.leftdate != '0000-00-00' and td.leftdate is not null ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function newEmpCountPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te 
	inner join employee e on e.emp_id = te.emp_id  
	where te.client_id  = '".$clientid."' and te.sal_month ='".$frdt."' and month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	$row= $this->connection->query($sql);
        return $row;
	}
	function newEmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select sum(gross_salary) gross_salary from $tab_emp te
	 inner join employee e on e.emp_id = te.emp_id  
	 where te.client_id  = '".$clientid."' and te.sal_month ='".$frdt."'  and  month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	 $row= $this->connection->query($sql);
        return $row;
	}
	function newEmpPfSalReport($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    	$sql="select sum(std_amt) std_amt  from $tab_empded tdd
	inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month
	inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id
	inner join employee e on e.emp_id = te.emp_id  
	where te.client_id  = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and month(e.joindate) = month('$frdt') and year(e.joindate) = year('$frdt') ";
	
	$row= $this->connection->query($sql);
        return $row;
	}
	function age58EmpPfSalReport($tab_emp,$clientid,$frdt){
	    $sql ="select count(te.emp_id) cnt from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."' and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58  ";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function age58EmpTotalPfSalReport($tab_emp,$clientid,$frdt){
	     $sql ="select sum(gross_salary) gross_salary from $tab_emp te inner join mast_client t3 on te.client_id= t3.mast_client_id inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and te.sal_month ='".$frdt."'  and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58 ";
	     $row= $this->connection->query($sql);
        return $row;
	}
	function age58EmpPfSalReport1($tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    $sql="select sum(std_amt) std_amt  from $tab_empded tdd inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month = tdd.sal_month inner join  mast_client t3 on te.client_id= t3.mast_client_id inner join mast_deduct_heads md on tdd.head_id =md.mast_deduct_heads_id  inner join employee e on e.emp_id = te.emp_id  where t3.parentId = '".$clientid."' and tdd.sal_month ='".$frdt."' and md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'  and TIMESTAMPDIFF(YEAR,e.bdate,'$frdt') > 58";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function getExportPfNewJoined($emp,$frdt,$clintid,$comp_id){
	    if($emp=='Parent')
	{
        $sql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate,e.esino,e.adharno from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(joindate)= month('$frdt')  and  year(joindate)= year('$frdt') and mc.parentid = $clintid   and e.comp_id = '$comp_id' order by joindate"; 
        	
        	}
        else{
    	  $sql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(joindate)= month('$frdt')  and  year(joindate)= year('$frdt') and e.client_id = $clintid   and e.comp_id = '$comp_id' order by joindate";
        }
        $row= $this->connection->query($sql);
        return $row;
	}
	function exportPfLeft($emp,$frdt,$clintid,$comp_id){
	     if($emp=='Parent')
    	{
            $sql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate,e.leftdate from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(leftdate)= month('$frdt')  and  year(leftdate)= year('$frdt') and mc.parentid = $clintid  and e.comp_id = '$comp_id' order by leftdate";
        }else{ 
            $sql= "SELECT mc.client_name,e.emp_id,e.first_name,e.middle_name,e.last_name,e.pfno,e.uan,e.joindate,e.leftdate from employee e inner join mast_client mc on mc.mast_client_id = e.client_id  where month(leftdate)= month('$frdt')  and  year(leftdate)= year('$frdt') and e.client_id = $clintid  and e.comp_id = '$comp_id' order by leftdate"; 
        }
         $row= $this->connection->query($sql);
        return $row;
	}
	function getReportPfForm9($start_pfno,$end_pfno,$comp_id){
	    $sql = "select pfno,first_name,middle_name,last_name,joindate,leftdate,gender,bdate from employee where convert(pfno,unsigned integer)  >= '$start_pfno' and convert(pfno,unsigned integer)  <= '$end_pfno'  and comp_id = '$comp_id'  and comp_id = '$comp_id' order by pfno ";
        $row= $this->connection->query($sql);
        return $row;
	}
	function getReportPfCodeSummery($emp,$tab_empded,$clientid,$frdt,$comp_id){
	    if($emp=='Parent')
    	{
    	 $sql = "select e.client_id,tdd.head_id ,mc.client_name,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name,0 as gross_salary,0 as absent from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id where tdd.amount>0 and mc.parentId = '".$clientid."' AND tdd.sal_month = '$frdt'  AND tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='".$comp_id."')" ;
    	}
    else{
    	$sql = "select e.client_id,tdd.head_id ,mc.client_name,tdd.amount as amount,tdd.std_amt as std_amt,tdd.employer_contri_1 as employer_contri_1,tdd.employer_contri_2 as employer_contri_2,e.uan,e.first_name,e.middle_name,e.last_name,0 as gross_salary,0 as absent from tdd.amount>0 and  tran_deduct tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id inner join employee e on e.emp_id = tdd.emp_id inner join mast_client mc on e.client_id = mc.mast_client_id where mc.client_id = '".$clientid."' AND tdd.sal_month = '$frdt'  AND tdd.head_id in (select mast_deduct_heads_id from mast_deduct_heads where deduct_heads_name like '%P.F.%' and comp_id ='".$comp_id."')" ;
    }
     $sql;
    $row= $this->connection->query($sql);
        return $row;
	}
	function getPfChargesReport($frdt){
	    $sql = "select * from pf_charges where '".$frdt."' >=from_date and '".$frdt."' <= to_date";
		$row= $this->connection->query($sql);
        return $row;
	}
	function insertUanEcrReportPfCodeSummery($chr3439,$uan,$first_name,$middle_name,$last_name,$gross_salary,$std_amt,$amount,$employer_contri_2,$employer_contri_1,$absent,$client_id){
	    $sql1= "insert into uan_ecr_calc (uan ,memname ,gross_wages ,epf_wages,eps_wages ,edli_wages,epf_contribution,eps_contribution,epf_eps_d ,ncp_days,refund,client_id) values (";
	
    	$sql1= $sql1."concat(".$chr3439.",'".$uan."'),concat('".$first_name."','".$middle_name."','".$last_name."'),'".round($gross_salary,0)."','".round($std_amt,0);
    	if ($std_amt>15000)
    	{
    		$sql1=$sql1."','15000','15000','";
    		}
    	 else{
    		 $sql1=$sql1."','".round($std_amt,0)."','".round($std_amt,0)."','";
    	 }
    	 $sql1=$sql1.$amount."','".$employer_contri_2."','".$employer_contri_1."','".$absent."','0',".$client_id.")";
    	$sql1;
    	$row= $this->connection->query($sql1);
        return $row;
	}
	function selectUanEcrReportPfCodeSummery($acno2){
	    $sql1= "SELECT count(*) as cnt,sum(`epf_wages`) as epf_wages, sum(`eps_wages`) as eps_wages, sum(`edli_wages`) as edli_wages, sum(`epf_contribution`) as epf_contribution , sum(`eps_contribution`) as eps_contribution, sum(`epf_eps_d`)as epf_eps_d , sum(`ncp_days`) as ncp_days  ,sum(round(".$acno2."*epf_wages,0)) as acno2 FROM `uan_ecr_calc`";
	    $row= $this->connection->query($sql1);
        return $row;
	}
	function selectSumUanEcrReportPfCodeSummery(){
	     $sql2= "SELECT sum(round(`epf_wages`*0.500/100,0)) as acno2,sum(round(`epf_wages`*0.500/100,0)) as acno21 from uan_ecr_calc";
        $row= $this->connection->query($sql2);
        return $row;
	}
	function getreportLwfStatement($emp,$tab_empded,$tab_days,$tab_emp,$clientid,$comp_id,$frdt){
	    if($emp=='Parent')
    	{
    	 $sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1 inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month= t1.sal_month  inner join mast_client t3 on t4.client_id= t3.mast_client_id  where  t3.parentid='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%L.W.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
    	} else{
        	$sql = "SELECT t1.*,t2.first_name,t2.middle_name,t2.last_name,t2.uan,t4.pfno,t5.absent,t4.client_id FROM $tab_empded t1  inner join $tab_days t5 on t5.emp_id = t1.emp_id and t5.sal_month = t1.sal_month  inner join employee t2  on  t1.emp_id=t2.emp_id  inner join  $tab_emp t4 on t4.emp_id = t1.emp_id  and t4.sal_month = t1.sal_month where  t4.client_id='".$clientid."' AND  t1.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where  deduct_heads_name like '%L.W.F.%'  and mast_deduct_heads.comp_id ='".$comp_id."')  ";
        
        }
        $sql .= " AND t1.sal_month='".$frdt."' ";

         $sql .="order by t4.emp_id,t2.first_name,t2.middle_name,t2.last_name";
        
        $row= $this->connection->query($sql);
        return $row;
	}
	function getReportLWFSummery($tab_empded,$tab_emp,$frdt,$mast_client_id,$comp_id){
//	     $sql1 = "SELECT hdd.amount,count(hdd.emp_id)as cnt,sum(hdd.amount) as amount1,sum(employer_contri_1) as employer_contri_1 FROM $tab_empded hdd inner join $tab_emp he on  he.emp_id = hdd.emp_id and he.sal_month = hdd.sal_month   WHERE (hdd.`head_id` = 4 or hdd.head_id = 23 )and hdd.sal_month = '$frdt' and he.client_id = '".$mast_client_id."' group by hdd.amount";
      	     $sql1 = "SELECT hdd.amount,count(hdd.emp_id)as cnt,sum(hdd.amount) as amount1,sum(employer_contri_1) as employer_contri_1 FROM $tab_empded hdd inner join $tab_emp he on  he.emp_id = hdd.emp_id and he.sal_month = hdd.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = hdd.head_id  WHERE  hdd.sal_month = '$frdt' and he.client_id = '".$mast_client_id."'  and md.`deduct_heads_name` LIKE '%Prof.%' and md.comp_id = '$comp_id'  group by hdd.amount";
      
      
        $row= $this->connection->query($sql1);
        return $row;
	}
	function getReportAdvlist($emp,$advtype,$tab_adv,$clientid,$comp_id,$frdt,$todt,$month){
	    if($emp=='Parent')
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
        		$sql = "SELECT  t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id inner join mast_client t3 on t3.mast_client_id= t2.client_id where t2.client_id = '".$clientid."'  and t2.comp_id ='".$comp_id."'  ";
        		 
        	 }
        	 else{
        		$sql = "SELECT  t1.emp_id,t1.emp_advance_id,t1.std_amt,t1.paid_amt,t1.amount,t2.first_name,t2.middle_name,t2.last_name,t1.emp_id from $tab_adv t1 inner join employee t2 on t2.emp_id= t1.emp_id  inner join mast_client t3 on t3.mast_client_id= t2.client_id where  t2.client_id = '".$clientid."' and t1.head_id = '".$advtype."' and   t2.comp_id ='".$comp_id."'   ";
        	}
        }
        if($month=='current'){
         $sql .= " AND t1.sal_month='".$frdt."' ";}
        else{
          $sql .= " AND t1.sal_month>='".$frdt."' AND t1.sal_month<='".$todt."'";
        }
         $sql.=" order by t1.head_id,t2.emp_id,t2.first_name,t2.middle_name,t2.last_name ";
        $row= $this->connection->query($sql);
        return $row;
	    
	}
	function getAdvanceTypeName($advtype){
	    $sql = "select advance_type_name from mast_advance_type where mast_advance_type_id = '$advtype'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function getReportEmpAdvanceRec($emp_advance_id){
	    $sql = "select t1.*,t2.advance_type_name from emp_advnacen t1 inner join mast_advance_type t2 on t1.advance_type_id = t2.mast_advance_type_id where t1.emp_advnacen_id = '".$emp_advance_id."'";
	    $row= $this->connection->query($sql);
        return $row;
	}
	function getReportEmpAdvanceRecByEmp($emp_id,$frdt,$emp_advance_id){
	    
	     $sql = "select sal_month,amount  from hist_advance t1 inner join emp_advnacen ea on ea.emp_advnacen_id = t1.emp_advance_id where t1.emp_id = '".$emp_id."' and t1.sal_month<= '$frdt' and  t1.emp_advance_id = '".$emp_advance_id."' order by sal_month";
	$row= $this->connection->query($sql);
        return $row;
	}
	function getReportAdvanceEmployee($emp,$advdate1){
 	    $sql = "select t1.*,t2.first_name,t2.middle_name,t2.last_name,t1.emp_id from emp_advnacen t1 inner join employee t2 on t2.emp_id= t1.emp_id  inner join mast_client t3 on t3.mast_client_id= t2.client_id where t1.date ='$advdate1' and t1.emp_id = $emp  ";
    $row= $this->connection->query($sql);
        return $row;
	}
	function getHistAdvance($emp_advnacen_id){
	     $sql  = "SELECT * FROM `hist_advance` WHERE emp_advance_id = ".$emp_advnacen_id." order by sal_month ";
        $row= $this->connection->query($sql);
        return $row;
	}
	function getTranAdvance($emp_advnacen_id){
	    $sql  = "SELECT * FROM `tran_advance` WHERE emp_advance_id = ".$emp_advnacen_id." order by sal_month ";
    $row= $this->connection->query($sql);
        return $row;
	}
	function getReportSocietyLetter($tab_deduct,$bank_id,$frdt){
	    $sql = "select tdd.emp_id,tdd.amount,e.first_name,e.middle_name,e.last_name from $tab_deduct tdd inner join employee e on tdd.emp_id = e.emp_id  where tdd.bank_id='".$bank_id."'  and tdd.sal_month = '$frdt' and tdd.amount > 0  ORDER BY e.last_name,e.first_name,e.middle_name,e.Joindate ASC";
	
    $row= $this->connection->query($sql);
        return $row;
	}
	function getReportSocietyLetterSumAmt($tab_deduct,$bank_id,$frdt){
	    $sql21 = "select sum(tdd.amount) as amount from $tab_deduct tdd  where  bank_id='".$bank_id."'   and tdd.sal_month = '$frdt' ";
        $row= $this->connection->query($sql21);
        return $row;
	}
	function getREportMisPf($emp,$tab_empded,$tab_emp,$clientid,$frdt,$comp_id){
	    if($emp=='Parent')
       {
 	  		$sql="select te.client_id,e.first_name,e.last_name,te.pfno,te.esino,te.payabledays,te.gross_salary,te.tot_deduct,te.netsalary, tdd.head_id ,tdd.amount,tdd.std_amt,tdd.employer_contri_1,tdd.employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month =tdd.sal_month   where mc.parentId  = '".$clientid."'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where ( deduct_heads_name like '%P.F.%' or  deduct_heads_name like '%E.S.I.%')  and comp_id ='".$comp_id."') order by e.first_name ,e.last_name ,tdd.head_id  ";
       }
       else
       {
  	  		$sql="select te.client_id,e.first_name,e.last_name,te.pfno,te.esino,te.payabledays,te.gross_salary,te.tot_deduct,te.netsalary, tdd.head_id ,tdd.amount,tdd.std_amt,tdd.employer_contri_1,tdd.employer_contri_2 from $tab_empded tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join employee e  on e.emp_id = tdd.emp_id  inner join mast_client mc on e.client_id = mc.mast_client_id inner join $tab_emp te on te.emp_id=tdd.emp_id and te.sal_month =tdd.sal_month   where mc.mast_client_id = '".$clientid."'   AND tdd.sal_month = '$frdt' AND tdd.head_id  in (select  mast_deduct_heads_id from mast_deduct_heads  where ( deduct_heads_name like '%P.F.%' or  deduct_heads_name like '%E.S.I.%')  and comp_id ='".$comp_id."') order by e.first_name ,e.last_name ,tdd.head_id ";
       }
       $row= $this->connection->query($sql);
        return $row;
	}
	function getReportMisPfCharges($frdt){
	    $sql = "select * from pf_charges where '".$frdt."' >=from_date and '".$frdt."' <= to_date";
		$row= $this->connection->query($sql);
        return $row;
	}
	function getReportRandomPeriodWisePayslip($tab_days,$eid,$frdt,$todt){
	     $sql = "SELECT * FROM $tab_days WHERE emp_id ='".$eid."' AND sal_month >= '$frdt' and sal_month <= '$todt' ";
	     $row= $this->connection->query($sql);
        return $row;
	}
	function getReportForm3A($comp_id,$frdt,$todt,$eid){
	     $sql = "select tdd.`emp_id`, last_day(DATE_ADD( tdd.`sal_month`, INTERVAL 1 month )) as sal_month, tdd.`head_id`, tdd.`calc_type`, tdd.`std_amt`, tdd.`amount`, tdd.`employer_contri_1`, tdd.`employer_contri_2`,td.absent from hist_deduct tdd inner join hist_days td  on td.emp_id = tdd.emp_id and tdd.sal_month =td.sal_month inner join mast_deduct_heads md on md.mast_deduct_heads_id = tdd.head_id  WHERE (md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."' )and  tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt'  and tdd.emp_id = '$eid' order by tdd.sal_month";
        $row= $this->connection->query($sql);
        return $row;
	}
	function getReportGraduaty($emp_id){
	     $sql11 = "select e.emp_id,concat(e.first_name,' ',e.middle_name,' ',e.last_name) as name,e.joindate,e.leftdate,CONCAT(TIMESTAMPDIFF( YEAR, e.joindate, e.leftdate ),' Years,',
        TIMESTAMPDIFF( MONTH, e.joindate, e.leftdate ) % 12,' Months,',
        FLOOR( TIMESTAMPDIFF( DAY, e.joindate, e.leftdate ) % 30.4375 ),' Days')
        as service,TIMESTAMPDIFF( YEAR, e.joindate, e.leftdate )as years,TIMESTAMPDIFF( MONTH, e.joindate, e.leftdate ) % 12 as months, round(TIMESTAMPDIFF( DAY, e.joindate, e.leftdate ) % 30.4375,0)  as days,mc.client_name 
         from employee e inner join mast_client mc on e.client_id = mc.mast_client_id  where emp_id ='$emp_id' and leftdate!= '0000-00-00' and leftdate >'2000-01-01'";
        $row= $this->connection->query($sql11);
        return $row;
	}
	function getReportGraduatySum($comp_id,$emp_id){
	     $sql1= "SELECT sum(std_amt) as amount FROM emp_income WHERE   emp_id = '".$emp_id."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  ) and comp_id = '".$comp_id."'  )";

        $row= $this->connection->query($sql1);
        return $row;
	}
	function getSumGrossSalary($tab_emp,$clientid,$frdt){
	    $sqlcontlabw ="select sum(gross_salary) gsal from $tab_emp te inner join mast_company mc on te.comp_id = mc.comp_id where te.client_id='".$clientid."' and te.sal_month ='".$frdt."'";
	    $row= $this->connection->query($sqlcontlabw);
        return $row;
	}
	
	function getREPORTSumESISalary($tab_empded,$tab_emp,$clientid,$frdt){
	    $sqlesi ="select sum(std_amt) esi from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
    	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 		
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%E.S.I.%'";
    	$row= $this->connection->query($sqlesi);
        return $row;
	}
	function getREPORTSumPFSalary($tab_empded,$tab_emp,$clientid,$frdt){
	    $sqlpf ="select sum(std_amt) pfsum from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
    	inner join mast_deduct_heads mdh on mdh.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mdh.deduct_heads_name like '%P.F.%'";
    	$row= $this->connection->query($sqlpf);
        return $row;
	}
	function getREPORTSumOTSalary($tab_empinc,$tab_emp,$clientid,$frdt){
	    $sqlovertime ="select sum(amount) ot from 	
    	$tab_empinc te inner join $tab_emp em on te.emp_id = em.emp_id
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id and te.sal_month=em.sal_month
    	inner join mast_income_heads mih on mih.mast_income_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.income_heads_name like '%OVERTIME%'";
    	$row= $this->connection->query($sqlovertime);
        return $row;
	}
	function getREPORTSumCanteen($tab_empded,$tab_emp,$clientid,$frdt){
	    $sqlcanteen ="select sum(amount) canteen from 	
        $tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
        inner join mast_client mcl on mcl.mast_client_id = em.client_id 
        inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
        where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%CANTEEN%'";
        $row= $this->connection->query($sqlcanteen);
        return $row;
	}
	function getREPORTSumTran($tab_empded,$tab_emp,$clientid,$frdt){
	    $sqltransport ="select sum(amount) trans from 	
    	$tab_empded te inner join $tab_emp em on te.emp_id = em.emp_id and te.sal_month=em.sal_month
    	inner join mast_client mcl on mcl.mast_client_id = em.client_id 
    	inner join mast_deduct_heads mih on mih.mast_deduct_heads_id = te.head_id 	
    	where mcl.mast_client_id='".$clientid."' and te.sal_month ='".$frdt."' and mih.deduct_heads_name like '%TRANSPORT%'";
    	 $row= $this->connection->query($sqltransport);
        return $row;
	}
	function getDeptSearvching($compid,$val){
	    $sql ="select mast_dept_name,mast_dept_id from mast_dept where comp_id='".$compid."' and mast_dept_name like '%".$val."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getQualiSearching($compid,$val){
	     $sql ="select mast_qualif_id,mast_qualif_name from mast_qualif where comp_id='".$compid."' and mast_qualif_name like '%".$val."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	    
	}
	function getDesgSearching($compid,$name){
	    $sql ="select mast_desg_id,mast_desg_name from mast_desg where comp_id='".$compid."' and mast_desg_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getLocSearching($compid,$name){
	    $sql ="select mast_location_id,mast_location_name from mast_location where comp_id='".$compid."' and mast_location_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getPaySearching($comp_id,$name){
	    $sql ="select mast_paycode_id,mast_paycode_name from mast_paycode where comp_id='".$comp_id."' and mast_paycode_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getBankSearching($comp_id,$name){
	   $sql ="select mast_bank_id,bank_name,branch from mast_bank where comp_id='".$comp_id."' and bank_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getBankSearching1($comp_id,$ifsc){
	   $sql ="select mast_bank_id,bank_name,branch,ifsc_code from mast_bank where comp_id='".$comp_id."' and ifsc_code like '%".$ifsc."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getIncomeHeadSearching($comp_id,$name){
	     $sql ="select mast_income_heads_id,income_heads_name from mast_income_heads where comp_id='".$comp_id."' and income_heads_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	    
	}
	function getDeductHeadSearching($comp_id,$name){
	    $sql ="select mast_deduct_heads_id,deduct_heads_name from mast_deduct_heads where comp_id='".$comp_id."' and deduct_heads_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getLeaveTypeSearching($comp_id,$name){
	    $sql ="select mast_leave_type_id,leave_type_name from mast_leave_type where comp_id='".$comp_id."' and leave_type_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	function getAdvanceTypeSearching($comp_id,$name){
	    $sql ="select mast_advance_type_id,advance_type_name from mast_advance_type where comp_id='".$comp_id."' and advance_type_name like '%".$name."%'";
    	 $row= $this->connection->query($sql);
        return $row;
	}
	
	
	
	
// Addition By Aparna 	
//* * * * * * * *******      * * * * * **  ** * * * * * * * * * * * * * * 

function exportexceldata()
{
    $user_id=$_SESSION['log_id'];
    $tab = "`tab_".$user_id."`";
  $sql= "select * from $tab order by emp_id,sal_month ";
    $rowtab= $this->connection->query($sql);
   return $rowtab;
}

function genarateTempPaysheet( $inhdar,$inhd,$std_inhdar,$std_inhd,$advhd,$advhdar,$dedhdar,$dedhd,$cmonth){


$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$client_id=$_SESSION['clintid'];
$setExcelName = "Paysheet_".$client_id;

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

$sql ="DROP TABLE IF EXISTS $tab";
$row= $this->connection->query($sql);
        

$i = 0;
$days[]=0;
$sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";
//days
$sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
$rowdays= $this->connection->query($sql_days);
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
	$dayscnt=$i;

$sql=$sql.",`payabledays` float not null";
$sql_inctot ="select ";
//income
 $sql_inc = "select distinct ti.head_id,trim(mi.income_heads_name) as income_heads_name from $tab_inc  ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month = '$frdt' and ti.sal_month = '$todt'"; 
$rowinc= $this->connection->query($sql_inc);
while($rowtab1 = $rowinc->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
	$sql=$sql.",`std_".strtolower($rowtab1['income_heads_name'])."` float not null";
	
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
    $std_inhdar[$inhd] = "STD_".$rowtab1['income_heads_name'];
	$inhd++;
	
	if (strlen($sql_inctot) >7  ){$sql_inctot.=", ";}
    $sql_inctot .= " sum(`".$rowtab1['income_heads_name']."`) as `".strtolower($rowtab1['income_heads_name'])."`";
}
$sql=$sql.",`gross_salary` float not null";

$sql_dedtot ="select ";

$sql_ded = "select distinct tdd.head_id,trim(md.deduct_heads_name) as deduct_heads_name from $tab_empded  tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt'"; 
$rowded= $this->connection->query($sql_ded);
 

while($rowtabd1 = $rowded->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	if (strlen($sql_dedtot) >7  ){ $sql_dedtot.=", ";}
    $sql_dedtot .= " sum(`".$rowtabd1['deduct_heads_name']."`) as `".strtolower($rowtabd1['deduct_heads_name'])."`";
	
	
	
		$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
	

}

//ADVANCE

$sql_advtot ="select ";

$sql_adv = "select distinct tadv.head_id,trim(madv.advance_type_name) as advance_type_name from $tab_adv  tadv inner join mast_advance_type madv on tadv.head_id = madv.mast_advance_type_id    where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt'";   
$rowadv= $this->connection->query($sql_adv);
while($rowtaba1 = $rowadv->fetch_assoc()){
	$sql=$sql.",`".strtolower($rowtaba1['advance_type_name'])."` float not null";
	
	$advhdar[$advhd] = $rowtaba1['advance_type_name'];
	$advhd++;
	
		if (strlen($sql_advtot) >7 ){$sql_advtot.=", ";}
    $sql_advtot .= " sum(`".$rowtaba1['advance_type_name']."`) as `".strtolower($rowtaba1['advance_type_name'])."`";
	
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

$row= $this->connection->query($sql);


$rowdays= $this->connection->query($sql_days);
$dayscnt= 0;
	$dayscnt=$i;
/*while($rowtab1 = $rowdays->fetch_assoc()){
	
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
}*/

//insert data
    $sql = "insert into $tab ( `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`, payabledays,`gross_salary`,`tot_deduct`, `netsalary`)  select `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`,payabledays, `gross_salary`,`tot_deduct`, `netsalary`  from $tab_emp where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt'";
    $row= $this->connection->query($sql);

//update client
         $sql= "update $tab t inner join mast_client mc on mc.mast_client_id = t.client_id set t.client_name = mc.client_name";
    	 $row= $this->connection->query($sql);

//update designation
         $sql= "update $tab t inner join mast_desg md on md.mast_desg_id = t.desg_id set  t.designation = md.mast_desg_name";
    	 $row= $this->connection->query($sql);

//update Dept
         $sql= "update $tab t inner join mast_dept md on md.mast_dept_id = t.dept_id set  t.deptname = md.mast_dept_name";
    	 $row= $this->connection->query($sql);

//update Qualification
         $sql= "update $tab t inner join mast_qualif mq on mq.mast_qualif_id = t.qualif_id set  t.qualification = mq.mast_qualif_name";
    	 $row= $this->connection->query($sql);


//update location
         $sql= "update $tab t inner join mast_location ml on ml.mast_location_id = t.loc_id set  t.location = ml.mast_location_name";
    	 $row= $this->connection->query($sql);

//update paycode
       $sql= "update $tab t inner join paycode mp on mp.mast_paycode_id = t.paycode_id set  t.cc_code = mp.mast_paycode_name";   
    	 $row= $this->connection->query($sql);
    	 
//update bank    	 
         $sql= "update $tab t inner join mast_bank mb on mb.mast_bank_id = t.bank_id set  t.bankname = concat(mb.bank_name,' ',mb.branch,' ',mb.ifsc_code)";
    	 $row= $this->connection->query($sql);
  
//update employee
         $sql= "update $tab t inner join employee e on e.emp_id = t.emp_id set  t.emp_name =concat( e.first_name,' ',e.middle_name,' ' , e.last_name) ";
    	 $row= $this->connection->query($sql);



//Tran/hist days $days
    $sql= "update $tab t inner join $tab_days td on t.emp_id=td.emp_id and t.sal_month= td.sal_month set ";
    for ($j =0;$j<$i;$j++){
	    $sql = $sql. "t.`".$days[$j]."` = td.`".$days[$j]."`,";
    }
    $sql = $sql." t.present= td.present where td.client_id = '$client_id' and td.comp_id = '$comp_id' and td.user_id = '$user_id' and td.sal_month >= '$frdt' and td.sal_month <= '$todt'";

        	 $row= $this->connection->query($sql);



//tran_hist income

    $rowinc= $this->connection->query($sql_inc);
    while($rowtab1 = $rowinc->fetch_assoc())
    {
    
       $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.amount,ti.std_amt,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount,t.`std_".strtolower($rowtab1['income_heads_name'])."` = inc.std_amt";
        	 $row= $this->connection->query($sql);
    }

    
    

////tran_hist deduction updation
    $rowded= $this->connection->query($sql_ded);
    while($rowtab1 = $rowded->fetch_assoc()){

	     $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtab1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtab1['deduct_heads_name'])."` = ded.amount";
        	 $row= $this->connection->query($sql);
    }
    
////tran_hist advance updation
    $rowadv = $this->connection->query($sql_adv);
    while($rowtab1 = $rowadv->fetch_assoc()){
	     $sql = "update $tab t inner join (select tadv.emp_id,tadv.sal_month,tadv.head_id,tadv.amount,mah.advance_type_name  as head_name from $tab_adv  tadv inner join mast_advance_type  mah on tadv.head_id=mah.mast_advance_type_id     where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' and  mah.advance_type_name  like '%".strtolower($rowtaba1['advance_type_name'])."%'  ) adv on t.emp_id = adv.emp_id and t.sal_month = adv.sal_month set t.`".strtolower($rowtab1['advance_type_name'])."` = adv.amount";
        	 $row= $this->connection->query($sql);
        }


     $sql= "select * from $tab order by emp_id,sal_month ";
    $rowtab= $this->connection->query($sql);
    
    //total
    $sql_tot = "select sum(payabledays) as payabledays,sum(gross_salary) as gross_salary,sum(tot_deduct) as tot_deduct ,sum(netsalary) as netsalary from $tab t ";
     $sql_inctot .=" from $tab t "; 
     $sql_dedtot .=" from $tab t "; 
     $sql_advtot .=" from $tab t "; 



    $rec_tot = $this->connection->query($sql_tot);
    $rec_days =$this->connection->query($sql_days);
    $rec_inc =$this->connection->query($sql_inctot);
    $rec_ded =$this->connection->query($sql_dedtot);
    $rec_adv =$this->connection->query($sql_advtot);
    
   return array ($inhdar,$inhd,$std_inhdar,$std_inhd,$advhd,$advhdar,$dedhdar,$dedhd,$rowtab,$rec_tot,$rec_days,$rec_inc,$rec_ded,$rec_adv,$days,$dayscnt);

}

//* * * * * * * *******      * * * * * **  ** * * * * * * * * * * * * * * 




















    //* * * * * * * * * * * * * * * * * 
    
  function getLastDay1($cmonth){
        $sql = "SELECT LAST_DAY('".$cmonth."'-INTERVAL 1 MONTH) AS last_day";
    	$row= $this->connection->query($sql);
    	$row1 = $row->fetch_assoc();
        return $row1['last_day'];
    }
    
    function getMonthDay($cmonth){
        $sql = "SELECT day(LAST_DAY('".$cmonth."'- INTERVAL 1 MONTH)) AS monthdays";
    	$row= $this->connection->query($sql);
    	$row1 = $row->fetch_assoc();
        return $row1['monthdays'];
    }
     function getMonthDay1($cmonth){
        $sql = "SELECT day(LAST_DAY('".$cmonth."')) AS monthdays";
    	$row= $this->connection->query($sql);
    	$row1 = $row->fetch_assoc();
        return $row1['monthdays'];
    }
    function getFirstDay($cmonth){
        $sql = "SELECT date_add(date_add(LAST_DAY('".$cmonth."'),interval 1 DAY),interval -1 MONTH) AS first_day";
        $row= $this->connection->query($sql);
    	$row1 = $row->fetch_assoc();
        return $row1['first_day'];
        
    }
    function updateSalCalTranEmployee(){
         $sql = "update tran_EMPLOYEE te INNER JOIN EMPLOYEE e ON  e.emp_id = te.emp_id set te.client_id = e.client_id where e.client_id !=te.client_id";
         $this->connection->query($sql);
        return 1;
    }
    function updateSalCalTranAdvance(){
        $sql = "update tran_advance tadv INNER JOIN EMPLOYEE e ON  e.emp_id = tadv.emp_id set tadv.client_id = e.client_id where e.client_id !=te.client_id";

        $this->connection->query($sql);
        return 1;
    }
    function updateSalCalTranDays(){
        $sql = "update tran_DAYS td INNER JOIN EMPLOYEE e ON  e.emp_id = td.emp_id set td.client_id = e.client_id where e.client_id !=td.client_id";
        $this->connection->query($sql);
        return 1;
    }
    
    function deleteSalCalTranDays($client_id){
        $sql = "DELETE FROM TRAN_days td INNER JOIN EMPLOYEE e ON  e.emp_id = td.emp_id where td.client_id = '".$client_id."' and e.job_status = 'L'" ;
        $this->connection->query($sql);
        return 1;
    }
    function updateSalCalInvalidTranDays($client_id){
        $sql = "update tran_days set invalid = '' where client_id ='".$client_id."'";
		 $this->connection->query($sql);
        return 1;
    }
    function getSalCalLeftEmployee($client_id){
        $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days)" ;
	    $row = $this->connection->query($sql);
        return $row;
    }
   function delSalCalTranDaysByEmployee($emp_id){
        $sql  = "delete from  tran_days  where emp_id ='".$emp_id."'";
        $this->connection->query($sql);
    }
    function getSalCalNotLeftEmployee($client_id){
        $sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client_id."' and emp.job_status !='L' and emp.emp_id not in (SELECT emp_id FROM tran_days)" ;
    	$row = $this->connection->query($sql);
    	 return $row;
    }
    function getSalCalInsertTranDay($emp_id,$endmth,$client_id,$comp_id,$user_id){
        $sql  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updatedby values ('".$emp_id."','".$endmth."','".$client_id."','".$comp_id."','".$user_id."','".$user_id."')"; 
		$this->connection->query($sql);
    	 return 1;
    }
    function getSalCalTranDayPres0NotOther0($client_id){
        $sql = "SELECT trd_id from tran_days WHERE  client_id = '".$client_id."' and present = 0 and othours >0" ;
	    $row= $this->connection->query($sql);
    	 return $row;
    }
    function updateSalCalTranDayInvalidOt($trd_id){
        $sql  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$trd_id."'"; 
		$row= $this->connection->query($sql);
    }
    function getAllDaysCalculation($monthdays,$client_id,$startmth){
        $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."' and emp.joindate< '".$startmth."'" ;
    	$row= $this->connection->query($sql);
    	return $row;
    }
    function updateSalCalTranDayInvalidTotalDay($trd_id){
        $sql  = "update tran_days set invalid = concat(invalid,'Days Total(R)-') where trd_id ='".$trd_id."'";
        $this->connection->query($sql);
    }
     function getAllDaysCalculationNewEmployee($monthdays,$client_id,$startmth){
         $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."'and  emp.joindate> '".$startmth."'"; 
	    $row =$this->connection->query($sql);
	    return $row;
    }
    function updateSalCalTranDayInvalidTotalDayNewEmp($trd_id){
        $sql  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$trd_id."'"; 
		$this->connection->query($sql);
    }
    function getAllDaysCalculationLeftEmployee($client_id,$startmth){
        $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client_id."' and  emp.joindate< '".$startmth."'" ;
    	$row = $this->connection->query($sql);
    	return $row;
    }
    function updateAllDaysCalculationLeftEmployee($trd_id){
        $sql2  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$trd_id."'";
        $this->connection->query($sql);
    }
    function getsalCalAllDaysCalculationInvalid($client_id){
        $sql = "select trd_id from tran_days where client_id = '".$client_id."' and invalid != ''";
		$row = $this->connection->query($sql);
    	return $row;
    }
    function creatSalCalTabIncUser($user_id){
        $sqltab = "DROP TABLE IF EXISTS tab_inc".$user_id ;
        $this->connection->query($sqltab);
        
        $sqltab = "create table tab_inc".$user_id ." as (select * from  tran_income where 1=2)";
        $this->connection->query($sqltab);
    }
    function creatSalCalTabDedUser($user_id){
        $sqltab = "DROP TABLE IF EXISTS tab_ded".$user_id ;
        $this->connection->query($sqltab);
        
        $sqltab = "create table tab_ded".$user_id ." as (select * from  tran_deduct where 1=2)";
        $this->connection->query($sqltab);
    }
    function creatSalCalTabEmpUser($user_id){
        $sqltab = "DROP TABLE IF EXISTS tab_emp".$user_id ;
        $this->connection->query($sqltab);
        
        $sqltab = "create table tab_emp".$user_id ." as (select * from  tran_employee where 1=2)";
        $this->connection->query($sqltab);
    }
    function updateSalCalTranDays1(){
        $sqltab = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.plbal = el.ob-el.enjoyed  where el.leave_type_id = 5";
        $this->connection->query($sqltab);
        return 1;
 }
     function updateSalCalTranDays2(){
         $sqltab = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.clbal = el.ob-el.enjoyed  where el.leave_type_id = 4";
        $this->connection->query($sqltab);
        return 1;
     }
     function updateSalCalTabInc($user_id,$cmonth,$client_id){
    echo      $sqltab = "insert into tab_inc".$user_id ." (`emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0' from emp_income where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
        $this->connection->query($sqltab);
        return 1;
     }
     function updateSalCalTabDed($user_id,$cmonth,$client_id){
         $sqltab = "insert into tab_ded".$user_id ." ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`,bank_id)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0',bank_id from emp_deduct where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
        $this->connection->query($sqltab);
        return 1;
     }
     function updateSalCalTabEmp($user_id,$cmonth,$comp_id,$client_id){
         $sqltab = "INSERT INTO tab_emp".$user_id ." (`emp_id`,`sal_month`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status`, `comp_id`, `user_id`,`pfno`,`pay_mode`) select `emp_id`, '".$cmonth."', `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status` ,'".$comp_id."','".$user_id."',`pfno`,`pay_mode` from employee where emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";
        $this->connection->query($sqltab);
        return 1;
     }
     function updateSalCalPayableDay($user_id,$comp_id,$client_id){
     echo    $sql= "update tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.PRESENT+td.paidholiday+td.pl+td.cl+td.sl+td.additional+td.otherleave+td.weeklyoff where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where mast_income_heads.`income_heads_name` LIKE '%BASIC%'  and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 2,4))  and te.client_id = '".$client_id."'" ;
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalPayableDay1($user_id,$comp_id,$client_id){
    echo     $sql= "update  tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.pl+td.cl+td.sl+td.additional+td.otherleave+td.PRESENT+td.paidholiday where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where mast_income_heads. `income_heads_name` LIKE '%BASIC%' and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 1,3,5,14) )  and te.client_id = '".$client_id."'" ;
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType1_26_27($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType1_26_27_1($user_id,$endmth,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where ti.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType1_26_27_2($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  ";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType2_30_31($user_id,$endmth,$client_id){
        $sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/day('".$endmth."')*te.payabledays,2) where ti.calc_type= 2 and te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType2_14_26($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2)  where ti.calc_type=14  and client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType3Consilidated($user_id,$client_id){
         $sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  set ti.amount = ti.std_amt where ti.calc_type= 3 and  te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     
         function updateSalCalIncomeCalType4HourlyBasis($user_id,$client_id){
     echo     $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.othours,2)  where ti.calc_type=4  and td.client_id = '".$client_id ."'";
     
     echo "*********";
        $this->connection->query($sql);
        return 1;
     }
 
     function updateSalCalIncomeCalType16PerPresentDay($user_id,$client_id){
          $sql = "update tab_inc".$user_id."  ti  inner join tran_days te on te.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt*te.present,2)  where ti.calc_type= 16 and te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalIncomeCalType14_26dayPerMonth($user_id,$client_id){
          $sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,2) where ti.calc_type= 14 and te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalGrossSalOvertime($user_id,$comp_id,$client_id){
         $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%PAP. ALW%' or `income_heads_name` LIKE '%WASHING ALW%' or `income_heads_name` LIKE '%PETROL ALW%') and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalType15PerHour($user_id,$client_id){
          $sql = "update tab_inc".$user_id."  ti  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.othours,2)  where ti.calc_type= 15 and td.client_id = '".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalType7PerHour($user_id,$comp_id){
         $sql = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 7"; 
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalType12PerHour($user_id,$comp_id){
         $sql = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id set std_amt = round((te.gross_salary)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 12"; 
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalGrossalOvrTCal11($user_id,$comp_id,$client_id){
         $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%CONVEYANCE%' ) and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalGrossalOvrTCal11_1($user_id,$comp_id){
         $sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 11"; 
            $this->connection->query($sql2);
        return 1;
     }
     function updateSalCalGrossalOvrTCal13($user_id,$comp_id,$client_id){
         $sql = "update tab_emp".$user_id ." te inner join (SELECT sum(amount) as amt,emp_id FROM tab_inc".$user_id." WHERE   head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."') GROUP BY EMP_ID  ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalGrossalOvrTCal13_1($user_id,$comp_id){
         $sql = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set std_amt = round((te.gross_salary*2)/(te.payabledays*8),2 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),2 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 13"; 
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalNightShift20($user_id,$client_id){
          $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(20*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts <= 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";

        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalNightShift27($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(27*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts > 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";
        $this->connection->query($sql);
        return 1;
     }
     function updateSalCalNightShift25($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(25*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts <= 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
        $this->connection->query($sql);
        return 1;
     }
    function updateSalCalNightShift34($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(34.5*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts > 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
        $this->connection->query($sql);
        return 1;
     }
    function updateSalCalNightShift($user_id,$client_id){
         $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.nightshifts,2)  where ti.calc_type= 10 and td.nightshifts > 0  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
        $this->connection->query($sql);
        return 1;
     }
     function getSalCalExtraIncome($comp_id){
         $sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%extra_inc1%' and  comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        return $row;
     }
     function getSalCalExtraIncome1($client_id){
        $sql = "select emp_id,extra_inc1 from tran_days where client_id = '".$client_id ."' and extra_inc1 >0 ";
        $row = $this->connection->query($sql);
        return $row;
     }
     function insertSalCalTabInc($user_id,$emp_id,$head_id,$extra_inc1,$cmonth){
         $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','0','".$extra_inc1."','".$cmonth."','0')";
	    $row = $this->connection->query($sql);
        return 1;
     }
     function getSalCalIncHeadIncome2($comp_id){
        $sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%extra_inc2%' and  comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        return $row;
     }
     function getSalCalExtraIncome2($client_id){
         $sql = "select emp_id,extra_inc2 from tran_days where client_id = '".$client_id ."' and extra_inc2 >0 ";
        $row = $this->connection->query($sql);
        return $row;
     }
     function insertSalCalTabInc2($user_id,$emp_id,$head_id,$extra_inc2,$cmonth){
         $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','0','".$extra_inc2."','".$cmonth."','0')";
    	$row = $this->connection->query($sql);
        return $row;
     }
      function getSalCalPrevMonth($cmonth){
		$sql = "SELECT last_day(date_Add('".$cmonth."',interval -1 month)) AS prev_month";
		$row = $this->connection->query($sql);
        return $row;
     }
     function getSalCalWageDiffIncomeHead($comp_id){
        $sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Wage Diff' and  comp_id = '".$comp_id."'";
		$row = $this->connection->query($sql);
        return $row;
     }
     function getSalCalPayableDay($client_id,$prev_month){
         $sql = "select td.emp_id,he.payabledays  from tran_days td inner join hist_employee he on he.emp_id = td.emp_id where td.client_id = '".$client_id ."' and he.sal_month = '".$prev_month." '";
		$row = $this->connection->query($sql);
        return $row;
     }
    function insertSalCalPayableDay($user_id,$emp_id,$head_id,$wagediffrate,$payabledays,$cmonth){
         $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','$wagediffrate','".round($payabledays*$wagediffrate,2)."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
     }
     function getSalCalWageDiffByClient($client_id){
        $sql = "select emp_id,wagediff from tran_days where client_id = '".$client_id ."' and wagediff >0 ";
		$row = $this->connection->query($sql);
		return $row;
    }
    function insertSalCalTabIncUser($user_id,$emp_id,$head_id,$wagediff,$cmonth){
        $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','0','".$wagediff."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
    }
    function getSalCalALWArrears($comp_id){
        $sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%ALW ARREARS' and  comp_id = '".$comp_id."'";
		$row = $this->connection->query($sql);
		return $row;
    }
    function getSalCalPayableDays($client_id,$prev_month){
         $sql = "select td.emp_id,he.payabledays  from tran_days td inner join hist_employee he on he.emp_id = td.emp_id where td.client_id = '".$client_id ."' and he.sal_month = '".$prev_month." '";
		$row = $this->connection->query($sql);
		return $row;
    }
    function getSalCalTabIncUserAllOwDiff($user_id,$emp_id,$head_id,$allowdiffrate,$payabledays,$cmonth){
        $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','$allowdiffrate','".round($payabledays*$allowdiffrate,2)."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
    }
    
    function insertSalCalALWArrearsTabIncUser($user_id,$emp_id,$head_id,$Allow_arrears,$cmonth){
    	$sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','0','".$Allow_arrears."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
		return $row;
    }
    function getSalCalIncomeHeadOT($comp_id){
    	$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%OT. Aarrears' and  comp_id = '".$comp_id."'";
		$row = $this->connection->query($sql);
		return $row;
    }
    function getSalCalOTTranHistDay($client_id,$prev_month){
        $sql = "select td.emp_id,hd.othours  from tran_days td inner join hist_days hd on hd.emp_id = td.emp_id where td.client_id = '".$client_id ."' and hd.sal_month = '".$prev_month." '";
		$row = $this->connection->query($sql);
		return $row;
    }
    function insertSalCalOTTabIncUser($user_id,$emp_id,$head_id,$otdiffrate,$othours,$cmonth){
        $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','$otdiffrate','".round($othours*$otdiffrate,2)."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
    }
   function getSalCalOtApprearsTranDay($comp_id){
        $sql = "select emp_id,Ot_arrears from tran_days where client_id = '".$client_id ."' and Ot_arrears >0 ";
		$row = $this->connection->query($sql);
		return $row;
    }
     function getSalCalOtApprearsTranDay22($client_id){
       $sql = "select emp_id,Ot_arrears from tran_days where client_id = '".$client_id ."' and Ot_arrears >0 ";
	    $row =$this->connection->query($sql);
		return $row;
    }
    function insertSalCalOTTabIncUser1($user_id,$emp_id,$head_id,$Ot_arrears,$cmonth){
        $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp_id."' ,'".$head_id."','0','".$Ot_arrears."','".$cmonth."','0')";
		$row = $this->connection->query($sql);
	
    }
  function updateSalCalTabIncUserGross($user_id,$client_id){
        $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
        $row = $this->connection->query($sql);
		return $row;
    }
    function updateSalCalTabEsiUserESIY($user_id,$client_id){
        $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(std_amt) as amt from tab_esi".$user_id ." group by emp_id ) tesi on te.emp_id = tesi.emp_id  set te.esistatus = 'Y' where te.client_id ='".$client_id ."' and tesi.amt <=21000  ";
        $this->connection->query($sql);
        
    }
    function updateSalCalTabDedProfTax($user_id,$client_id,$comp_id){
        $sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id  where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 175  where te.gross_salary >=7501 and te.gross_salary < 10000 and te.gender = 'M' and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')";
        $this->connection->query($sql);
    }
    function updateSalCalTabDedProfTax1($user_id,$client_id,$cmonth,$comp_id){
         $sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 200  where te.gross_salary >=10000 and month('".$cmonth."')!=2  and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%' and comp_id = '".$comp_id."')";
        $this->connection->query($sql);
    }
    function updateSalCalTabDedProfTax2($user_id,$client_id,$cmonth,$comp_id){
           $sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 300  where te.gross_salary >=10000 and month('".$cmonth."')=2 and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."') ";
        $this->connection->query($sql);
        
        
    }
    function updateSalCalTabUserLabourFund($user_id,$client_id,$cmonth,$comp_id){
        $sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id ='".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 25,employer_contri_1 = 75  where te.gross_salary <=3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
        $this->connection->query($sql);
    }
    function updateSalCalTabUserLabourFund36($user_id,$client_id,$cmonth,$comp_id){
        $sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 25,employer_contri_1 = 75  where te.gross_salary >3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
        $this->connection->query($sql);
    }
    function updateSalCalTabUserTDS10P($user_id,$client_id,$comp_id){
        $sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = round(te.gross_salary*0.1,0),std_amt =te.gross_salary  where te.gross_salary >0 and  head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%TDS (10%)%' and comp_id = '".$comp_id."') ";
        $this->connection->query($sql);
    }
    function updateSalCalTabUserConsolidate($user_id,$client_id){
         $sql = "update tab_ded".$user_id."  tdd  inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = tdd.std_amt where tdd.calc_type= 3 and  te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
    }
    function updateSalCalTabUserDailyWages($user_id,$client_id){
        $sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt*te.payabledays,2)  where tdd.calc_type= 5 and te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
    }
    function getSalCalDeductHead($comp_id){
        $sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Extra_ded1%' and comp_id = '".$comp_id."'";
        $row21 = $this->connection->query($sql);
        $row31 = $row21->fetch_assoc();
        return $row31;
    }
    function getSalCalExtraDeduct1($client_id){
        $sql = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and extra_ded1 >0 ";
        $row21 = $this->connection->query($sql);
        return $row21;
    }
    function insertSalCalExtraDeduct1($user_id,$emp,$head_id,$extra_ded1,$cmonth){
         $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$head_id."','0','".$extra_ded1."','".$cmonth."','0')";
	    $row21 = $this->connection->query($sql);
        return $row21;
    }
    function getSalCalDeductHeadDed2($comp_id){
        $sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Deduct-2%' and comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
    function getSalCalDeductHeadDed2Grt0($client_id){
        $sql = "select emp_id,extra_ded2 from tran_days where client_id = '".$client_id ."' and extra_ded2 >0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function insertSalCalExtraDeduct2($user_id,$emp_id,$head_id,$extra_ded2,$cmonth){
         	$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $emp_id."' ,'".$head_id."','0','".$extra_ded2."','".$cmonth."','0')";
	    $row = $this->connection->query($sql);
        return $row;
    }
    function insertSalCalTaxDed($comp_id){
        $sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%INCOMETAX%' and comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
    function getSalCalTaxDedTranDay($client_id){
        $sql = "select emp_id,incometax from tran_days where client_id = '".$client_id ."' and incometax >0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function insertSalCalTaxDedUser($user_id,$emp_id,$head_id,$incometax,$cmonth){
        $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $emp_id."' ,'".$head_id."','0','".$incometax."','".$cmonth."','0')";
	   $row = $this->connection->query($sql);
        return $row;
    }
    function getSalCalDedCanteen($comp_id){
        $sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%CANTEEN%' and comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
    function insertSalCalCanteenDedUser($user_id,$emp_id,$head_id,$canteen,$cmonth){
        $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $emp_id."' ,'".$head_id."','0','".round($canteen,0)."','".$cmonth."','0')";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalDedType1_26_27($user_id,$client_id){
        $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = round(tdd.std_amt/26*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff <4 and client_id = '".$client_id ."' and te.payabledays >0  ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalDedType1_26_27_1($user_id,$endmth,$client_id){
        $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id  set tdd.amount = round(tdd.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalDedType2_30_31($user_id,$endmth,$client_id){
        $sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt/day('".$endmth."')*te.payabledays,0) where tdd.calc_type= 2 and te.client_id = '".$client_id ."'";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalDedType2_30_31_1($user_id,$client_id){
        $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary = 0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function createSalCalAdvanceTable($user_id){
        $sql = "DROP TABLE IF EXISTS tab_adv".$user_id ;
        $row = $this->connection->query($sql);
        
        $sql = "create table   tab_adv".$user_id ." as (select * from  tran_advance where 1=2)";
        $row = $this->connection->query($sql);
    }
    function insertSalCalAdvanceTable($user_id,$comp_id,$client_id,$cmonth){
        $sql = "INSERT INTO tab_adv".$user_id ." (`emp_id`, `comp_id`,`client_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id` ) select `emp_id`, '".$comp_id."', '".$client_id."',  '".$cmonth."',`advance_type_id`,'0',adv_amount,`adv_installment`,'0',`emp_advnacen_id` from emp_advnacen where adv_installment > 0 and adv_amount-received_amt >0 and closed_on < '2001-01-01' and emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalAdvanceTable($user_id){
        $sql = "update tab_adv".$user_id ." tadv inner join (select emp_id,sum(amount) as amt,emp_advance_id  from hist_advance group by emp_id,emp_advance_id ) hadv on tadv.emp_id = hadv.emp_id and  tadv.emp_advance_id = hadv.emp_advance_id  set tadv.paid_amt = hadv.amt ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalAdvanceTableStdAmt($user_id){
         $sql = "update tab_adv".$user_id ." tadv inner join tran_employee te on te.emp_id = tadv.emp_id  set tadv.amount = 0 where te.netsalary < tadv.amount";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalAdvanceTableTAdvAmt($user_id){
         $sql = "update tab_adv".$user_id ." tadv inner join tran_employee te on te.emp_id = tadv.emp_id  set tadv.amount = 0 where te.netsalary < tadv.amount";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalTotDedNetSalPayDay($user_id,$client_id){
         $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalTotAdvNetSalPayDay($user_id,$client_id){
         $sql = "update  tab_adv".$user_id." tadv inner join tab_emp".$user_id ." te on te.emp_id = tadv.emp_id  set tadv.amount = 0  where client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalTotDedTabEmp($user_id,$client_id){
        $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_ded".$user_id ." group by emp_id ) tdd on te.emp_id = tdd.emp_id  set te.tot_deduct = tdd.amt where te.client_id ='".$client_id ."'";
        $row = $this->connection->query($sql);
        return $row;
    }
    function updateSalCalTabAdv($user_id,$client_id){
        $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_adv".$user_id ." group by emp_id ) tadv on te.emp_id = tadv.emp_id  set te.tot_deduct = te.tot_deduct+tadv.amt where te.client_id ='".$client_id ."'";
        $row = $this->connection->query($sql);
        return $row;
    }
    function getSalCalTabAdvTranDay($user_id,$client_id){
        $sql = "update tab_emp".$user_id ." te  inner join tran_days td on te.emp_id = td.emp_id set te.netsalary = round(te.gross_salary - te.tot_deduct,0) where  te.client_id ='".$client_id ."'";
        $row = $this->connection->query($sql);
        return $row;
    }
    function getSalCalTabMastDedHeadRoff($comp_id){
        $sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%R.OFF%' and comp_id = '".$comp_id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
    function getSalCalNetSal($user_id,$client_id){
        $sql = "select emp_id, (( netsalary - (gross_salary-tot_deduct))*-1) as roundoff  from tab_emp".$user_id ." te  where client_id = '".$client_id ."' and netsalary - (gross_salary-tot_deduct) != 0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function insertSalCalTabDedUserRoundOff($user_id,$emp_id,$head_id,$roundoff,$cmonth){
        $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $emp_id."' ,'".$head_id."','0','".$roundoff."','".$cmonth."','0')";
    	$row = $this->connection->query($sql);
    }
    function updateSalCalTotDed($user_id,$roundoff,$emp_id){
        $sql = "update tab_emp".$user_id ." te set te.tot_deduct = te.tot_deduct + ".$roundoff."  where  te.emp_id ='".$emp_id."'";
	    $row = $this->connection->query($sql);
    }
    function getSalCalEmpCanteenTran($client_id){
        $sql = "select emp_id,canteen from tran_days where client_id = '".$client_id ."' and canteen >0 ";
        $row = $this->connection->query($sql);
        return $row;
    }
    function deleteAllTranTable($client_id){
        $sql = "DELETE FROM tran_employee WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_advance WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
        $row = $this->connection->query($sql);
        
        
        
        $sql = "DELETE FROM tran_employee WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_deduct WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_income WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_advance WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
        //"')";
        $row = $this->connection->query($sql);
    }
    function insertTranTable($user_id){
        $sql = "insert into tran_employee select * from tab_emp".$user_id ;
        $row = $this->connection->query($sql);
        
        $sql = "insert into tran_income select * from tab_inc".$user_id ;
        $row = $this->connection->query($sql);
        
        $sql = "insert into tran_deduct select * from tab_ded".$user_id;
        $row = $this->connection->query($sql);
        
        $sql = "insert into tran_advance select * from tab_adv".$user_id;
        $row = $this->connection->query($sql);
    }
    
    function updateSalCalIncomeCalType5DailyWages($user_id,$client_id){
         $sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te  on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.payabledays,2)  where ti.calc_type= 5 and te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
    }
    function getSalCalWithoutWageDiffIncomeHead($comp_id){
        $sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Wage Diff' and  comp_id = '".$comp_id."'";
		$row21= $this->connection->query($sql);
		
		return $row21;
    }
    function getSalCalALWArrearsTranDay($client_id){
        $sql ="select emp_id,Allow_arrears from tran_days where client_id = '".$client_id ."' and Allow_arrears >0 ";
        $row21= $this->connection->query($sql);
        return $row21;
    }
    /* use for display emp income Starts */
    function displayitdepositWithPage($comp_id,$user_id,$per_page,$show_page){
        $curpage = $show_page;
        if($curpage <=0){$curpage=1;}
        $nostrt = ($curpage*$per_page)-$per_page+1; 
        $noend = $curpage*$per_page;
        $sql = "SELECT * FROM it_deposited WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ORDER BY id DESC limit $nostrt,$noend";
        $res = $this->connection->query($sql);
        return $res;
    }
    /* use for display emp income Starts */
    /* for form 16 */
    function getItFile1($year,$empid){
        $sqlfile ="SELECT id FROM `it_file1` WHERE `year` LIKE '".$year."' AND `emp_id` = '".$empid."'";
        $res = $this->connection->query($sqlfile);
        $rowfile = $res->fetch_array();
        return $rowfile;
    }
    function getItFile1_1($year,$empid){
        $sqlfile ="SELECT * FROM it_file1 i1 inner join itconst i2 on i1.year=i2.year AND i1.comp_id=i2.comp_id Where i1.`year`='".$year."' AND i1.emp_id='".$empid."'";
        $res = $this->connection->query($sqlfile);
        $rowfile = $res->fetch_array();
        return $rowfile;
    }
    function getItConst($empid){
        $sqlfile ="SELECT * FROM `itconst` WHERE user_id='".$empid."'";
        $res = $this->connection->query($sqlfile);
        $rowfile = $res->fetch_array();
        return $rowfile;
    }
    function getHistEmpForm16($empid,$frdt,$todt){
        $q1 = "select sal_month,gross_salary from hist_employee where emp_id = '$empid'  and sal_month >= '$frdt' and sal_month <= '$todt' order by sal_month";
        $res = $this->connection->query($q1);
        return $res;
    }
    function getTranEmpForm16($empid,$frdt,$todt){
        $q1 = "select sal_month,gross_salary from tran_employee where emp_id = '$empid'  and sal_month >= '$frdt' and sal_month <= '$todt' order by sal_month";
        $res = $this->connection->query($q1);
        return $res;
    }
    function getBonusForm16($empid,$bonus_fromdate,$bonus_todate){
        $q1 = "select  (tot_bonus_amt+tot_exgratia_amt) as amount from bonus where emp_id = '$empid'  and from_date='$bonus_fromdate' AND todate='$bonus_todate'";
        $res = $this->connection->query($q1);
        return $res;
    }
    function getLeavePaymentForm16($empid,$frdt,$todt){
        $q1 = "select  amount from leave_details where emp_id = '$empid'  and payment_date >=  '$frdt' and payment_date <= '$todt' ";
        $res = $this->connection->query($q1);
        return $res;
    }
    function getHistDedForm16($empid,$frdt,$todt){
        $sql = "select hd.amount,id.challan_no,id.deposite_date from hist_deduct hd inner join it_deposited id on hd.sal_month = id.sal_month where emp_id = '$empid'  and hd.sal_month >= '$frdt' and hd.sal_month <= '$todt' order by hd.sal_month";
        $res = $this->connection->query($sql);
        $rowfile = $res->fetch_array();
        return $rowfile;
    }
    function getITFile3($emp_id,$year){
        $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."' AND year='".$year."' AND (allow_name!='' OR allow_amt!=0) ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return  $res;
        
    }
    function getIncomeITFile3($emp_id,$year){
        $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."'  AND year='".$year."' AND (income_desc!='' OR income_amt!=0) ORDER BY id DESC";
         $res = $this->connection->query($sql);
        return  $res;
    }
    function getIncomeITFile3_2($emp_id,$year){
         $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."' AND year='".$year."' AND (80C_desc!='' and 80c_amt!=0) ORDER BY id DESC";
         $res = $this->connection->query($sql);
        return  $res;
    }
    function getIncomeITFile3_3($emp_id,$year){
        $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."' AND year='".$year."' AND (80C_desc!='' and 80c_amt>0) ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return  $res;
    }
     function getIncomeITFile3_4($emp_id,$year){
         $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."' AND year='".$year."' AND  (section_name!='' OR gross_amt!='0'  OR qual_amt!='0' OR deduct_amt!='0' )  ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function getIncomeITFile3_5($emp_id,$year){
         $sql = "SELECT * FROM it_file3 WHERE emp_id='".$emp_id."' AND year='".$year."' AND  (section_name!='' OR gross_amt!='0'  OR qual_amt!='0' OR deduct_amt!='0' )  ORDER BY id DESC";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function insertAuthkey($email,$authkey){
         $sql = "update login_master set authpasskey='".$authkey."' where emailaddress = '".$email."'"; 
		
		$res = $this->connection->query($sql);
    }
    function updatePass($username,$password,$id){
        $rand = base64_encode(rand(0,10000));
         $sql ="update login_master set userpass='".$password."', authpasskey='".$rand."' where authpasskey='".$id."' and username='".$username."'";
        $res = $this->connection->query($sql);
        
    }
    function getBonusDetails($client,$startyear,$endyear){
        $setSql ="select emp.first_name,emp.middle_name,emp.last_name,emp.emp_id,emp.joindate,emp.leftdate,te.*
		from employee emp	inner join bonus te on te.emp_id = emp.emp_Id
		where te.client_id='$client' and te.from_date ='$startyear' and te.todate='$endyear' and (te.apr_payable_days + te.may_payable_days+te.jun_payable_days+te.jul_payable_days+te.aug_payable_days+te.sep_payable_days+te.oct_payable_days+te.nov_payable_days+te.dec_payable_days+te.jan_payable_days+te.feb_payable_days+te.mar_payable_days) >=0 and emp.prnsrno !='Y'";  
	   $res = $this->connection->query($setSql);
        return  $res;
    }
    function insertCheckBonusDetails($emp,$check_no,$startday,$endday,$amount,$date1){
        $sql="insert into cheque_details(emp_id,check_no,from_date,to_date,amount,date,type,db_addate) values('".$emp."','".$check_no."','$startday','$endday','".$amount."','".date('Y-m-d',strtotime($date1))."','B',now())";	
		$res = $this->connection->query($sql);
        return  $res;
    }
    function updateCheckBonusDetails($date1,$check_no,$amount,$startday,$endday,$emp){
        $sql="update cheque_details set date='".date('Y-m-d',strtotime($date1))."',check_no='".$check_no."',amount='".$amount."',from_date='".$startday."',to_date='".$endday."', db_update=now() where emp_id='".$emp."' and from_date='".$startday."'and to_date='".$endday."' and type = 'B'";
    	$res = $this->connection->query($sql);
        return  $res;
    }
    function updateChkDetails($checkno,$amt,$id){
        $sql = "update cheque_details set check_no='".$checkno."',amount='".$amt."' where chk_detail_id='".$id."'";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function selectLasrDay($frdt){
        $sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
    	$row = $this->connection->query($sql);
    	$res = $row->fetch_assoc();
    	return $res['last_day'];
    }
    function selectcurrent_month($comp_id){
        echo $sql = "select current_month from mast_client where comp_id = '$comp_id'";
        echo"<br>";
        $row = $this->connection->query($sql);
    	$res = $row->fetch_assoc();
    	$cmonth = $res['current_month'];
    	return $cmonth;
    }
    function insertHistEmployee($comp_id){
        echo $sql = "insert into  hist_employee select * from tran_employee where comp_id = '$comp_id'";
        echo"<br>";
        $row = $this->connection->query($sql);
    }
    function insertHistDay($comp_id){
        echo $sql = "insert into  hist_days  ( `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`,`society`,`canteen`,`incometax`,`remarks`) select  `emp_id`, `client_id`, `sal_month`, `fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`, `othours`, `nightshifts`, `extra_inc1`, `extra_inc2`, `extra_ded1`, `extra_ded2`, `leftdate`, `wagediff`, `Allow_arrears`, `Ot_arrears`, `invalid`, `comp_id`, `user_id`,`society`,`canteen`,`incometax`,`remarks`  from tran_days where comp_id = '".$comp_id."'" ;
        echo"<br>";
        $row = $this->connection->query($sql);
    }
    function insertHistDeduct($comp_id){
        echo  $sql = "insert into hist_deduct  ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `employer_contri_1`, `employer_contri_2`, `bank_id`,`db_adddate`)select t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.employer_contri_1, t1.employer_contri_2, t1.bank_id,now() from tran_deduct t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'" ;
         echo"<br>";
        $row = $this->connection->query($sql);
    }
    function insertHistIncome($comp_id){
        echo $sql = "insert into hist_income ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`,`db_adddate`,`comp_id`,`user_id`) select  t1.emp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount,now(),'11','11' from tran_income t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id' ";
        echo"<br>";
        $row = $this->connection->query($sql);
    }
    function insertHistAdvance($comp_id){
        echo $sql = "insert into hist_advance ( `emp_id`, `client_id`, `comp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id`,`db_adddate`)select  t1.emp_id, t1.client_id, t1.comp_id, t1.sal_month, t1.head_id, t1.calc_type, t1.std_amt, t1.amount, t1.paid_amt, t1.emp_advance_id,now() from tran_advance t1 inner join tran_employee t2 on t1.emp_id = t2.emp_id and t1.sal_month = t2.sal_month where t2.comp_id  =  '$comp_id'" ;
        echo"<br>";
        $row = $this->connection->query($sql);
    }
    function updateEmployeeMonthlyClosing($comp_id){
   echo     $sql = "update employee e inner join tran_employee te on te.emp_id = e.emp_id set e.esistatus = te.esistatus where  e.comp_id = '$comp_id'  ";
   echo"<br>";
        $row = $this->connection->query($sql);
    }
    function deleteTranTableMonthlyclosing($comp_id){
        $sql = "DELETE FROM tran_employee  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_advance  WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE comp_id = '".$comp_id. "')";
        $row = $this->connection->query($sql);
        
        $sql = "DELETE FROM tran_days WHERE comp_id = '".$comp_id. "'";
        $row = $this->connection->query($sql);
    }
    function updateMastClientMonthlyClosing($comp_id){
     echo    $sql = "update mast_client set current_month =last_day(DATE_ADD( current_month, INTERVAL 1 month )) WHERE comp_id = '".$comp_id. "'";
         $row = $this->connection->query($sql);
    }
    function updateempAdvnacen($comp_id){
        $sql = "update emp_advnacen ea inner join ( select `emp_advance_id`,emp_id,sum(amount) as amt from hist_advance group by emp_id,emp_advance_id) hadv on hadv.emp_advance_id = ea.emp_advnacen_id set ea.received_amt = hadv.amt where comp_id = '$comp_id' ";
        $row = $this->connection->query($sql);
    }
    function getEmpAdvnacen($comp_id){
        $sql = "select * from emp_advnacen where adv_amount<=received_amt and comp_id ='$comp_id'";
        $row = $this->connection->query($sql);
        return $row;
    }
    function getHistAdvance1($emp_advnacen_id){
        $sql = "select * from hist_advance where  emp_advance_id = '".$emp_advnacen_id."' order by `tradv_id` desc limit 1";
		$row = $this->connection->query($sql);
		$row3 =$row->fetch_array();
		return $row3;
    }
    function updateEmpAdvance($sal_month,$emp_advnacen_id){
        $sql = "update emp_advnacen set closed_on = '".date('Y-m-d',strtotime($sal_month))."' where `emp_advnacen_id` = '".$emp_advnacen_id."'";
		$row = $this->connection->query($sql);
    }
     /* use for display emp with clientid Starts  */
    function showEployeedetailsWlDate($id,$clmonth){
        $date = date('d-m-Y',strtotime($clmonth)); 
      // $sql = "select emp_id,CONCAT(first_name,' ',middle_name,' ',last_name),$id as cl,'$date' as cmonth from employee WHERE client_id='".$id."' and (leftdate > $clmonth or leftdate ='0000-00-00') ";
       $sql = "select e.emp_id,mc.client_name as cl,'$date' as cmonth,CONCAT(e.first_name,' ',e.middle_name,' ',e.last_name) from employee e inner join mast_client mc on e.client_id=mc.mast_client_id WHERE e.client_id='".$id."' and (e.leftdate > $clmonth or e.leftdate ='0000-00-00') and job_status != 'L' ";
      
        $res = $this->connection->query($sql);
        
        return $res;
    }
    /* use for display emp with empid end  */
    
    function checkEmpDaysTran($client_id,$emp,$month){
        $sql = "select count(*) as cnt from tran_days where emp_id = '".$emp."' and sal_month ='".$month."' and client_id='".$client_id."'";
		$row = $this->connection->query($sql);
		$row3 =$row->fetch_assoc();
		return $row3['cnt'];
    }
    function getEmpDaysTran($client_id,$emp,$month){
          $sql = "select trd_id from tran_days where emp_id = '".$emp."' and sal_month ='".$month."' and client_id='".$client_id."'";
		$row = $this->connection->query($sql);
		$row3 =$row->fetch_assoc();
		return $row3['trd_id'];
        
    }
    function insertEmpDaysTran($client_id,$empid,$month,$pp,$ph,$aa,$ww,$hd,$pl,$sl,$cl,$extrainc1,$extraded1,$othour,$additional,$day1,$day2,$day3,$day4,$day5,$day6,$day7,$day8,$day9,$day10,$day11,$day12,$day13,$day14,$day15,$day16,$day17,$day18,$day19,$day20,$day21,$day22,$day23,$day24,$day25,$day26,$day27,$day28,$day29,$day30,$day31,$comp_id,$user_id){ $phd =($hd/2);
         $sql = "insert into tran_days (client_id,emp_id, sal_month,present,paidholiday, absent, weeklyoff, pl, sl, cl,day_1, day_2, day_3,  day_4, day_5,day_6 , day_7, day_8, day_9, day_10, day_11, day_12, day_13, day_14, day_15, day_16, day_17, day_18, day_19, day_20,day_21,day_22,day_23,day_24,day_25,day_26,day_27,day_28,day_29,day_30,day_31,extra_inc1,extra_ded1,othours,additional,comp_id,user_id) 
        values('".$client_id."','".$empid."','".$month."','".($pp)."','".$ph."','".($aa)."','".$ww."','".$pl."','".$sl."','".$cl."','".$day1."','".$day2."','".$day3."','".$day4."','".$day5."','".$day6."','".$day7."','".$day8."','".$day9."','".$day10."','".$day11."','".$day12."','".$day13."','".$day14."','".$day15."','".$day16."','".$day17."','".$day18."','".$day19."','".$day20."','".$day21."','".$day22."','".$day23."','".$day24."','".$day25."','".$day26."','".$day27."','".$day28."','".$day29."','".$day30."','".$day31."','".$extrainc1."','".$extraded1."','".$othour."','".$additional."','".$comp_id."','".$user_id."')" ;
        $row = $this->connection->query($sql);
    }
    function updateEmpDaysTran($client_id,$empid,$month,$pp,$ph,$aa,$ww,$hd,$pl,$sl,$cl,$extrainc1,$extraded1,$othour,$additional,$day1,$day2,$day3,$day4,$day5,$day6,$day7,$day8,$day9,$day10,$day11,$day12,$day13,$day14,$day15,$day16,$day17,$day18,$day19,$day20,$day21,$day22,$day23,$day24,$day25,$day26,$day27,$day28,$day29,$day30,$day31,$trid,$comp_id,$user_id){
        
         $sql = "update tran_days set client_id='".$client_id."',emp_id='".$empid."', sal_month='".$month."',present='".($pp)."',paidholiday='".$ph."', absent='".($aa)."', weeklyoff='".$ww."', pl='".$pl."', sl='".$sl."', cl='".$cl."',day_1='".$day1."', day_2='".$day2."', day_3='".$day3."',  day_4='".$day4."', day_5='".$day5."',day_6='".$day6."' , day_7='".$day7."', day_8='".$day8."', day_9='".$day9."', day_10='".$day10."', day_11='".$day11."', day_12='".$day12."', day_13='".$day13."', day_14='".$day14."', day_15='".$day15."', day_16='".$day16."', day_17='".$day17."', day_18='".$day18."', day_19='".$day19."', day_20='".$day20."',day_21='".$day21."',day_22='".$day22."',day_23='".$day23."',day_24='".$day25."',day_25='".$day25."',day_26='".$day26."',day_27='".$day27."',day_28='".$day28."',day_29='".$day29."',day_30='".$day30."',day_31='".$day31."',extra_inc1='".$extrainc1."',extra_ded1='".$extraded1."',othours='".$othour."',additional='".$additional."', db_update=now() where trd_id='".$trid."'" ;
        $row = $this->connection->query($sql);
        
    }  
    
    
  
  
  
  function pf_calc($comp_id,$user_id,$endmth){

//PF Calculation
 $sql = "SELECT e.bdate,t.*  FROM tab_ded".$user_id." t inner join employee e on e.emp_id = t.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id  WHERE md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."'";
      $row = $this->connection->query($sql);
  

while ($row1 = $row->fetch_assoc()) 
{ 

    $sql1= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select head_id  from emp_income  where emp_id = '".$row1["emp_id"]."' and  
  head_id  not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%HRA%' or `income_heads_name` LIKE '%Overtime Allow.%'  ) and comp_id = '".$comp_id."'  )
  
  
  and calc_type in (1,2,5,14)  and comp_id = '".$comp_id."'               )";


 
	$row2 =  $this->connection->query($sql1);
	$row3 = $row2->fetch_assoc();
	//print_r($row3);
	$std_amt = '0';
	$employer_contri_2 = '0';
	$employer_contri_1 = '0';

	 if(intval($row3["amount"]) > '15000' )
	{
		$std_amt = 15000;
		
	}
	else
	 {
		 $std_amt = round($row3["amount"],0);
	}

	 	$sql2= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  ( `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."'  )";
	
	
	$amount = ROUND(($std_amt)*(12/100),0);
	$employer_contri_2 = ROUND(($std_amt)*0.0833,0);
    if($employer_contri_2 > 1250)
	{
		$employer_contri_2='1250';
	}
	
	
	
	$datediff =0;
	/*$datediff = $endmth - $row1['bdate'];
	 
	 
	 
		$todt1 = date('Y-m-d', strtotime($row1['bdate']. '-1 days'));
		$date1 = new DateTime($endmth);
		$date2 = $date1->diff(new DateTime($todt1));
		$date2->d.' days'."\n";
		  $year = $date2->y;
		
    if ($year >=58 ){
	{
			$employer_contri_2 = 0;
			}
	
	}*/
	$employer_contri_1 = $amount - $employer_contri_2;
  $sql2 = "update tab_ded".$user_id." set std_amt = '".$std_amt."',amount = '".$amount."',employer_contri_1 ='".$employer_contri_1."',employer_contri_2 ='".$employer_contri_2."' where emp_id = '".$row1["emp_id"]."'and head_id = '".$row1["head_id"]."'"; 
	$row4=  $this->connection->query($sql2);
	
	
	
}

// end of pf calculation

  
  } 
  
  
  
  
  function esi_calc($month,$client_id,$user_id,$comp_id)
  {
  
  
  
  
//ESI Calculation
if( $month == '04' or  $month == '10')
{
        $sql = "DROP TABLE IF EXISTS tab_esi2".$user_id ;
        $row = $this->connection->query($sql);

      $sql = "DROP TABLE IF EXISTS tab_esi".$user_id ;
        $row = $this->connection->query($sql);
        
        $sql = "create table   tab_esi".$user_id ." as (select * from  emp_income where 1=2)";
        $row = $this->connection->query($sql);
  
//to find std income
       $sql = "insert into tab_esi".$user_id." select ei.* from emp_income ei inner join employee e on e.emp_id =ei.emp_id inner join mast_income_heads mi on ei.head_id = mi.mast_income_heads_id where e.client_id = '".$client_id ."' and e.job_status != 'L' and mi.deduct_esi is null";
        $row = $this->connection->query($sql);
 
 
 
       $sql = "update 	tab_esi".$user_id." set std_amt = std_amt*26 where calc_type = 4";
        $row = $this->connection->query($sql);


        $sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(std_amt) as amt from tab_esi".$user_id ." group by emp_id ) tesi on te.emp_id = tesi.emp_id  set te.esistatus = 'N' where te.client_id ='".$client_id ."' and tesi.amt >21000  ";
        $this->connection->query($sql);
    
}	

      $sql = "update tab_emp".$user_id ."  te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." where head_id  in(select mast_income_heads_id from mast_income_heads  where deduct_esi is null   and comp_id = '".$comp_id."'   ) group by emp_id) ti on ti.emp_id = te.emp_id  set te.tot_deduct = ti.amt where te.client_id = '".$client_id ."'";
        $this->connection->query($sql);
  echo        $sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,tot_deduct,client_id  from tab_emp".$user_id ." where client_id =  '".$client_id ."' and  esistatus = 'Y' ) te on te.emp_id = tdd.emp_id  set tdd.std_amt =round(te.tot_deduct,0), tdd.amount = round((te.tot_deduct*0.0075)+0.49,0),tdd.employer_contri_1 = round((te.tot_deduct*0.0325),2) where te.client_id = '".$client_id ."' and  tdd.head_id  in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%' and comp_id = '".$comp_id." ' )";
        $this->connection->query($sql);
    
?>
</br>
</br>
<?php

///////End of esino`********************


  
  
  
  }
  
  
  
      function droptable($tab){
        $sqltab = "DROP TABLE IF EXISTS $tab" ;
        $this->connection->query($sqltab);
}
    /* use for display client as client Id  Starts  */
    function displayemployeeClientbyID($cid){
      $sql = "select * from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id, first_name,middle_name,last_name";
     $res = $this->connection->query($sql);
     return $res;
    }
    
    function checkIfUserExistbySalmonthEmpid($emp_id,$sal_month){ 
	    $sql = "select emp_id from tran_days_details where emp_id ='".$emp_id."' AND sal_month='".$sal_month."' "; 
		$res = $this->connection->query($sql);
		$row = $res->fetch_assoc();
	    return $row;
     
	}
   function exportTDDEmpData($emp_id,$sal_month){
	
	    $sql = "select * from tran_days_details where emp_id ='".$emp_id."' AND sal_month='".$sal_month."' "; 
	    $setRec1 = $this->connection->query($sql);
        return $setRec1;
	}
	 function insertUpdateNewEmpTranDaysDetails($sql){ 
	    $res = $this->connection->query($sql);
       return $res;
     
	}
	  function displayClientEmployeebyID($cid){
      $sql = "select emp_id from employee WHERE client_id='".$cid."' AND job_status!='L' order by emp_id";
      $res = $this->connection->query($sql);
      return $res;
    }
}
?>