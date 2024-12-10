<?php
session_start();

if(!isset($_SESSION['log_id']) || $_SESSION['log_id']==''){
    header("location:../index.php");
}
include("../lib/class/admin-class.php");
$adminObj=new admin();

$id = $_POST['id'];
$showcomp = $adminObj->showCompany();
$row1 =$adminObj->showPagesById($id);
?>


                <div class="twelve padd0 columns successclass hidecontent" id="success">
                    Record Insert Successfully<br/><br/>
     </div>
        <div class="twelve" id="margin1">

            <input type="hidden" value="<?php echo $row1['pages_id']; ?>" name="pid" id="pid">
            <div class="clearFix"></div>
             <div class="two padd0 columns">
                <span class="labelclass">Company :</span>
            </div>
            <div class="four padd0 columns">
                <select class="textclass" name="company" id="company">
                    <option value="">Please select company</option>
                    <?php while($row = $showcomp->fetch_assoc()){?>
                    <option value="<?php echo $row['comp_id'];?>" <?php if($row1['comp_id'] == $row['comp_id']){echo "selected";}?>><?php echo $row['comp_name'];?></option>
                    <?php }?>
                </select>
                <span class="errorclass hidecontent" id="companyerror"></span>
            </div>
           
            <div class="two  padd0 columns">
            <span class="labelclass">&nbsp;&nbsp;&nbsp;Page Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="page_name" id="page_name" placeholder="Page Name" class="textclass" value="<?php echo $row1['page_name'];?>">
                <span class="errorclass hidecontent" id="page_nameerror"></span>
            </div>
            <div class="clearFix">&nbsp;</div>
            <div class="two padd0 columns">
                <span class="labelclass">Title :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="title" id="title" placeholder="Page Title" class="textclass" value="<?php echo $row1['title'];?>">
                <span class="errorclass hidecontent" id="nameerror"></span>
            </div>
            <div class="clearFix"></div>
            
           

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
              <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="edit();">

            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
