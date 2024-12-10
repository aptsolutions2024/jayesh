<?php $company = $_POST['company']; 
include("../lib/class/admin-class.php");
$adminObj=new admin();
$getUserDetails =$adminObj->getUserByCompany($company);
?>
<div class="three padd0 columns"> &nbsp; <b>Select User</b></div>
        <div class="nine padd0 columns">
		<select name="user" class="textclass" id="user" onchange="getmenues()">
		<option value='0'>Please select</option>
		<?php $usertype=""; 
		foreach($getUserDetails as $user){
			if($user['login_type'] ==1){
				$usertype ="Admin";
			}elseif($user['login_type'] ==2){
				$usertype ="Hr Head";
			}elseif($user['login_type'] ==3){
				$usertype ="User";
			}
			?>
		<option value="<?php echo $user['log_id']; ?>"><?php echo $user['fname']." ".$user['mname']." ".$user['lname']." (".$usertype.")";?></option>
		<?php }?>
		</select>
		</div>