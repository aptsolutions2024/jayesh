<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
  $id = $_POST['id'];

  $result2 = $userObj->displayClient($id);
  $dt=$result2['current_month'];

echo "<b>".date("M Y", strtotime($dt))."</b>";

	 ?><input type="hidden" id="cm" name="cm" value="<?php echo $dt; ?>">