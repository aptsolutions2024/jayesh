<?php
session_start();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/common.php");
$userObj=new user();
$common=new common();
$result = $userObj->selectClientEmployee($comp_id);

$allclients = $userObj->showClient1($comp_id,$user_id);
$alldesign = $userObj->showDesignation($comp_id);
$id = $_POST['id'];
$editdetails = $common->getClientEmployeeById($id);

?>
<input type="hidden" value="<?php echo $id;?>" id="rid" name="rid">
<div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">
            </div>
            <div class="clearFix"></div>
            
            
			<div class="four padd0 columns">
				<div class="four padd0 columns"><span class="labelclass">Client :</span></div>
				<div class="seven padd0 columns">
				<select name="client" id="client" class="textclass" onChange="getdesignation(this.value);">
				<option value="0">Select Client</option>
				<?php while($client = mysql_fetch_array($allclients)){ ?>
				<option value="<?php echo $client['mast_client_id'];?>" <?php if($editdetails['client_id'] == $client['mast_client_id'] ){echo "selected";}?>><?php echo $client['client_name'];?></option>
				<?php } ?>
				</select>
                <span class="errorclass hidecontent" id="clienterror"></span></div>
               <div class="one padd0 columns"></div>
               
            </div>
			<div class="four padd0 columns">
				<div class="four padd0 columns"><span class="labelclass">Designtion :</span></div>
				<div class="seven padd0 columns" ><span id="designdiv"><select name="design" id="design" class="textclass">
				<option value="">Please select Designation</option>
				<?php while($design = mysql_fetch_array($alldesign)){?>
				<option value="<?php echo $design['mast_desg_id']; ?>" <?php if($editdetails['design_id']==$design['mast_desg_id']){echo "selected";} ?>><?php echo $design['mast_desg_name']; ?></option>
				<?php }?>
				</select></span> 
				
                <span class="errorclass hidecontent" id="designerror"></span></div>
               <div class="one padd0 columns"></div>
            </div>
			<div class="four padd0 columns">
				<div class="four padd0 columns"><span class="labelclass">No. Employee :</span></div>
				<div class="seven padd0 columns"> <input type="text" name="noofemployee" id="noofemployee" placeholder="Number of Employee" class="textclass" value="<?php echo $editdetails['no_of_employee'];?>">
                <span class="errorclass hidecontent" id="noofemployeeerror"></span></div>
               <div class="one padd0 columns"></div>
               
            </div>
            
            <div class="clearFix"></div>
			<div class="four padd0 columns" id="margin1">
			<div class="four padd0 columns" id="margin1">
						</div>
			<div class="eight padd0 columns" id="margin1">
				<input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateClientEmployee();">
			</div>
			</div>
             
            <div class="eight padd0 columns" id="margin1">
            </div>
            <div class="clearFix"></div>
<script>
$( document ).ready(function() {
     getdesignation1(<?php echo $editdetails['client_id'];?>,<?php echo $editdetails['design_id'];?>);
});
 </script>