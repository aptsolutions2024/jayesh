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
$mon =$_POST['mon'];
$frdt =$_POST['frdt'];
$tdt =$_POST['todt'];
?>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">

<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Without ESI Employee</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/report_without_esi_summery_statement_page" >
        <div class="twelve" >
		<input type="hidden" value="<?php echo $mon;?>" name="mon">
		<input type="hidden" value="<?php echo $frdt;?>" name="frdt">
		<input type="hidden" value="<?php echo $tdt;?>" name="todt">
           
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

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