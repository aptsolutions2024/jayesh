<?php include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
//include_once('/dbconf');

class admin extends DbConfig{
    public function __construct()
    {
        parent::__construct();
    }
    

    function showCompany(){
        $sql = "select * from mast_company ORDER BY `comp_id` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }

   function displayCompany($id){
        $sql = "select * from mast_company WHERE `comp_id`='".$id."'";
       $res = $this->connection->query($sql);//mysql_query($sql);
       $row=$res->fetch_assoc();//mysql_fetch_array($res);
     
       return $row;
    }

    function insertCompany($name,$add,$phno,$logo){
        $sql = "INSERT INTO `mast_company`(`comp_name`, `phone_no`, `address`, `logo`, `db_adddate`, `db_update`) VALUES ('".$name."','".$phno."','".$add."','".$logo."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }

    function deleteCompany($id){
        $sql = "DELETE FROM `mast_company` WHERE comp_id='".$id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    function updateCompany($comp_id,$name,$add,$phno,$logo){
        $sql = "UPDATE `mast_company` SET `comp_name`='".$name."',`phone_no`='".$phno."',`address`='".$add."',`logo`='".$logo."',`db_update`=NOW() WHERE `comp_id`='".$comp_id."'";
        $res = $this->connection->query($sql);
        return $res;
    }

    function showUser(){
        $sql = "select * from login_master WHERE login_type!='1' ORDER BY `log_id` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    function insertUser($fname,$mname,$lname,$uname,$pwd,$type,$comp_id){
        $sql = "INSERT INTO `login_master`(`fname`, `mname`, `lname`, `username`, `userpass`, `login_type`, `comp_id`,`db_adddate`, `db_update`) VALUES('".$fname."','".$mname."','".$lname."','".$uname."','".$pwd."','".$type."','".$comp_id."',NOW(),NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }

    function deleteUser($id){
        $sql = "DELETE FROM `login_master` WHERE log_id='".$id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    function updateUser($logid,$fname,$mname,$lname,$uname,$pwd,$type,$comp_id){
       $sql = "UPDATE `login_master` SET `comp_id`='".$comp_id."',`fname`='".$fname."',`mname`='".$mname."',`lname`='".$lname."',`username`='".$uname."',`userpass`='".$pwd."',`login_type`='".$type."',`db_update`=NOW() WHERE log_id='".$logid."' ";
         $res = $this->connection->query($sql);
         return $res;
    }

    function displayUser($id){
        $sql = "select * from `login_master` WHERE log_id='".$id."' ";
        $res = $this->connection->query($sql);
        $row=$res->fetch_array();
        return $row;
    }
    function getClientMonth($comp_id){
    	$sql = "select current_month from `mast_client` where comp_id='$comp_id' limit 1";
    	 $res = $this->connection->query($sql);//mysql_query($sql);
           $row=$res->fetch_assoc();
            //$res = mysql_query($sql);
            //$row=mysql_fetch_array($res);
            return $row['current_month'];
    }

    function showPages(){
        $sql = "select * from mast_pages ORDER BY `comp_id` DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    function addPages($company,$pagename,$name){
         $sql = "insert into mast_pages(comp_id,page_name,title) values('".$company."','".$pagename."','".$name."')";
        $res = $this->connection->query($sql);
        return $res;
    }
    function showCompdetailsWithpage($page){
        $sql ="select * from mast_company ORDER BY `comp_id` limit  DESC";
        $res = $this->connection->query($sql);
        return $res;
    }
    function showPagesdetailsWithpage($per_page,$show_page){
        $curpage = $show_page;
        if($curpage <=0){$curpage=1;}
        $nostrt = ($curpage*$per_page)-$per_page; 
        $noend = $curpage*$per_page;
        $sql = "SELECT * FROM mast_pages ORDER BY pages_id DESC limit $nostrt,$noend";
        $res = $this->connection->query($sql);
        return $res;
    }
    function showPagesById($id){
        $sql ="select * from mast_pages where pages_id='".$id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
    function editPages($company,$pagename,$name,$id){
        $sql = "update mast_pages set comp_id='".$company."',page_name='".$pagename."',title='".$name."' where pages_id='".$id."'";
        $res = $this->connection->query($sql);
    }
    function deletePage($id){
        $sql = "DELETE FROM mast_pages WHERE pages_id='".$id."' ";
        $res = $this->connection->query($sql);
        return $res;
    }
    function insertMenus($modelid,$parentid,$company,$user,$ord){ 
        echo $sql = "insert into mast_menues(model_id,parent_id,comp_id,user_id,order_id,status) values('".$modelid."','".$parentid."','".$company."','".$user."','".$ord."','1')";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function getAllMenus($company){
        $sql = "select * from mast_menues where comp_id ='".$company."')";
        $res = $this->connection->query($sql);
        return  $res;
    }
     function getPageTitle($id){
        $sql ="select title from mast_pages where pages_id='".$id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows['title'];
    }
     function getPageDetails($id){
        $sql ="select title,page_name from mast_pages where pages_id='".$id."'";
        $row = $this->connection->query($sql);
        $rows = $row->fetch_assoc();
        return $rows;
    }
	function getAllParentMenus($company){
       $sql = "select * from mast_menues where comp_id ='".$company."' and parent_id='0' order by menu_id asc";
        $res = $this->connection->query($sql);
        return $res;
    }
    function getAllParentMenus1($company,$user){
       $sql = "select * from mast_menues where comp_id ='".$company."' and parent_id='0' and user_id='".$user."' order by order_id,menu_id asc";
        $res = $this->connection->query($sql);
        return $res;
    }
    function getChildMenus($company,$parentid,$user){
       $sql = "select * from mast_menues where comp_id ='".$company."' and parent_id='".$parentid."' and user_id='".$user."' ";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function getRemainMenus($company,$user){
       $sql = "select pages_id,title,page_name from mast_pages where comp_id ='".$company."' and pages_id not in(select model_id from mast_menues where user_id='".$user."')";
        $res = $this->connection->query($sql);
        return  $res;
    }
    function deleteMenues($company,$user){
       echo $sql = "DELETE FROM mast_menues WHERE comp_id ='".$company."' and user_id='".$user."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    function getCompanyByUserId($userid){
        $sql = "select comp_id FROM login_master WHERE log_id ='".$userid."' ";
        $res = $this->connection->query($sql);
        $rows = $res->fetch_assoc();
        return $rows['comp_id'];
    }
   function insertJsonMenu($compid,$menujson,$user){
       echo $sql = "INSERT INTO mast_menu(comp_id, menu_json,status,user_id,created) VALUES ('".$compid."','".$menujson."',1,'".$user."',NOW())";
        $res = $this->connection->query($sql);
        return $res;
    }
   function getAllMenusJson($company){
        $sql = "select * from mast_menu where comp_id ='".$company."'";
        $res = $this->connection->query($sql);
        return $res;
    }
	 function getAllMenusJson1($company,$user){
        $sql = "select * from mast_menu where comp_id ='".$company."' and user_id='".$user."'";
        $res = $this->connection->query($sql);
        return $res;
    }
    function updateJsonMenu($company,$menues,$user){
        echo $sql = "update mast_menu set menu_json='".$menues."',status='1',user_id='".$user."', modified=NOW() where comp_id='".$company."'";
        $res = $this->connection->query($sql);
        return $res;
    }
	 function getUserByCompany($company){
         $sql = "select * from login_master  where comp_id='".$company."'";
        $res = $this->connection->query($sql);
        return $res;
    }
	
   
}


?>