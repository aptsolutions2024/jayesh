<?php ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting('E_ALL'); 
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

//print_r($_SESSION);

if(!isset($_SESSION['log_id']) || $_SESSION['log_id']==''){
    header("/index");
}
?>
<!--Header starts here-->


<header class="twelve header_bg">

    <div class="row" >

        <div class="twelve padd0 columns" >

            <div class="six padd0 columns mobicenter text-left " id="container1">

                <!-- Modify top header1 start here -->
<br/>
<!--                <a href="index.php"><div class="logo" ><img src="../images/logo.png"></div></a>-->
<?php
//include("../lib/connection/db-config.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/admin-class.php");
$admin=new admin();
 $co_id=$_SESSION['comp_id'];
 $rowcomp=$admin->displayCompany($co_id);

 //echo $rowcomp['bankacno'];
$crmonth = $admin->getClientMonth($co_id);
echo ' <h4 class="Color2" >'.$rowcomp['comp_name'].' </h4>';
?>
                <br/>
                <!-- Modify top header1 ends here -->

            </div>
<div class="two padd0 columns cmoncl" valign="center" > Month : <b><?php echo date('M Y',strtotime($crmonth));?></b></div>








            <div class="four padd0 columns text-right text-center" id="container3">

                <!-- Modify top header3  Navigation start here -->


                <div class="mobicenter text-right" id="margin1" >
                    <br/>
                  <a class="btn" href="/logout">Logout</a>
                    <br/><br/>
                </div>



                <!-- Modify top header3 Navigation start here -->

            </div>




        </div>

</header>


<!--Header end here-->
