<?php
session_start();
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
 $name=strtoupper($_POST['name']);
if($name!=''){
$arr=explode(" ",$name);

    $comp_id=$_SESSION['comp_id'];
    $user_id=$_SESSION['log_id'];
	$clientid=$_SESSION['clientid'];
	
$res = $userObj->displayemployee2($comp_id,$user_id,$clientid,$arr);


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
