<?php
session_start();

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL); 
//include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/admin-class.php");
$admin=new admin();

//print_r($_SERVER['DOCUMENT_ROOT']);
/*$con=mysqli_connect('localhost','demo_salary','demo_salary')or die("hello not connected");




if(!$con){
    die('Could not connect: '.mysql_error());
}*/
/*$aVar = mysqli_connect('localhost','aptsolutions','mT#7qD3!FSmw','salary_demo')or die("hello1234");*/
//mysqli_select_db("demo_salary", $con);

/*$sql = "SELECT * FROM bonus";
$result = $con->query($sql);
*/

/*if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["client_id"]. "emp_id ".$row["emp_id"]."<br>";
    }
} else {
    echo "0 results";
}*/
/*echo "###";

   $sql = "select * from login_master where username ='".$_REQUEST['username']."' AND userpass='".$_REQUEST['password']."' "; 
		$res = $con->query($sql);  //echo "11   "; 
		$row = $res->fetch_assoc();//mysqli_fetch_assoc($res);
		print_r($row); exit;
		//echo "hello 123"; exit;*/
		/*$bdd = new db();
		$db = $bdd->connect();*/
	
  $userObj=new user();
  $user = addslashes($_POST['username']);
  $pass = addslashes($_POST['password']);
  $result_login = $userObj->login($user,$pass);
 $rowcomp=$admin->displayCompany($result_login['comp_id']);
 if($rowcomp['comp_name']==""){
     header("location:/home");
 }
if($result_login['login_type']==2){
    $_SESSION['log_id']=$result_login['log_id'];
    $_SESSION['log_type']=$result_login['login_type'];

    $_SESSION['comp_id']=$result_login['comp_id'];
    //print_r($_SESSION); exit
	?>
	<script>
	document.location.href="/user_home";
	</script>
	
    <?php  exit;
 }else if($result_login['login_type']==1){
    $_SESSION['log_id']=$result_login['log_id'];
    $_SESSION['log_type']=$result_login['login_type'];
    $_SESSION['comp_id']=$result_login['comp_id'];
     header("location:/admin/index.php");exit;
 }else if($result_login['login_type']==3){
    $_SESSION['log_id']=$result_login['log_id'];
    $_SESSION['log_type']=$result_login['login_type'];
    $_SESSION['comp_id']=$result_login['comp_id'];
     header("location:/report_user/index.php");exit;
 }else{
    header("location:index.php");
}
	 ?>

