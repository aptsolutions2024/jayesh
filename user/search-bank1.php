<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
 $ifsc=strtoupper($_POST['ifsc']);

if($ifsc!=''){
    $comp_id=$_SESSION['comp_id'];
    $user_id=$_SESSION['log_id'];

$res =$userObj->getBankSearching1($comp_id,$ifsc);
$count = mysqli_num_rows($res); 
if($count!=0) {
    while ($rows = $res->fetch_assoc()) {
       //echo $rows['client_name'];
        
        ?>
        <li class="searchli"  onclick="showTabdata1('<?php echo $rows['mast_bank_id'];?>')"><?php echo $rows['bank_name']." - ".$rows['ifsc_code'];
            ?> </li>
    <?php
    }
}
else{
    echo "<span class='spanclass'>You can add new Name</span>";
}
}
else{
    echo "<span class='spanclass'>You can add new Name</span>";
}
?>
