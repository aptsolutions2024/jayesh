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
    <link rel="stylesheet" href="../css/jquery-ui.css">



<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>P.F. Summary Statement</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/report_pf_stat_summary_page" >
        <div class="twelve" id="margin1">
            <div class="one padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" checked>Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" >No
            </div>

            <div class="five padd0 columns">



            </div>

            <div class="four padd0 columns">


            </div>
            <div class="clearFix"></div>




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





