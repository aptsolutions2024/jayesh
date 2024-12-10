<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$name=strtoupper($_POST['name']);
if($name!=''){
$arr=explode(" ",$name);


    $comp_id=$_SESSION['comp_id'];
    $user_id=$_SESSION['log_id'];
	$clientid=$_SESSION['clientid'];
	


//$sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND user_id='".$user_id."' and month(joindate)= month(CURDATE()) and year(joindate)= year(CURDATE())";
$res = $userObj->displayemployee2($comp_id,$user_id,$clientid,$arr);
/*$sql = "select DISTINCT * from employee WHERE comp_id='".$comp_id."' AND user_id='".$user_id."'";
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
$sql .= " AND client_id ='".$clientid."' ";
$sql .= " limit 10";
$res = mysql_query($sql);*/
$count = mysqli_num_rows($res);
if($count!=0) {
    while ($rows = $res->fetch_assoc()) {
        $rest=$userObj->displayClient($rows['client_id']);
        if($rest['client_name']!='') {
            $cname = $rest['client_name'];
        }
        else {
            $cname = '-';
        }
        ?>
        <li class="searchli"  onclick="showTabdata('<?php echo $rows['emp_id'];?>','<?php echo $rows['first_name'] . ' ' . $rows['middle_name'] . ' ' . $rows['last_name'].' ['. $rows['emp_id'] .'] ('.$cname.')'; ?>')"><?php echo $rows['first_name'] . ' ' . $rows['middle_name'] . ' ' . $rows['last_name'].' ['. $rows['emp_id'] .'] ('.$cname.')';
            ?> </li>
    <?php
    }
}
else{
    echo "<span class='spanclass'>Please Enter the Valid Name</span>";
}
}
else{
    echo "<span class='spanclass'>Please Enter the Name</span>";
}
?>
