<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
 $comp_id=$_SESSION['comp_id'];
?>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>MUSTER ROLL</h3></div>
       
        <form method="post"  id="form" action="/report_muster_book">
        <div class="twelve" id="margin1">
		<div class="one padd0 columns" >Type</div>
		<div class="three padd0 columns" ><input type="radio" name="type" value="1"> Type 1 <input type="radio" name="type" value="2"> Type 2</div>
		<div class="clearFix">&nbsp;</div>
		<div class="one padd0 columns" ></div>
            <div class="three padd0 columns" >
			<input type="hidden" value="" name="clientid" >
                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        <div class="clearFix"></div>
        </div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>