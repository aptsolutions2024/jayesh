<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
 $name=strtoupper($_POST['name']);

if($name!=''){
    $comp_id=$_SESSION['comp_id'];
    $user_id=$_SESSION['log_id'];

$res =$userObj->getDeductHeadSearching($comp_id,$name);
$count = mysqli_num_rows($res); 
if($count!=0) {
    while ($rows = $res->fetch_assoc()) {
       //echo $rows['client_name'];
        
        ?>
        <li class="searchli"  onclick="showTabdata1('<?php echo $rows['mast_deduct_heads_id'];?>')"><?php echo $rows['deduct_heads_name'];
            ?> </li>
    <?php
    }
}
else{
    echo "<span class='spanclass'>You can add new name</span>";
}
}
else{
    echo "<span class='spanclass'>You can add new name</span>";
}
?>
