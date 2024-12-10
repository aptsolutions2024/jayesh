<?php
session_start();
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1=$userObj->showClient1($comp_id,$user_id);

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Edit All Employee</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
	
<script>

function showTabdata(id){
  //  var id=document.getElementById('clientid').value;
    $.post('/display_all_employee',{
        'id':id
    },function(data){
        $('#displaydata').html(data);
    })
    }

function openTab(evt, tabName) {

    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}


    </script>
</head>
 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg" >
    <div class="row">

        <div class="two columns"  id="margin1">
            <span class="labelclass">Client :</span>
        </div>
        <div class="four columns" id="margin1">
       <select id="clientid" name="clientid" class="textclass" onchange="showTabdata(this.value);" >
           <option>--select--</option>
           <?php
           while($row1=$result1->fetch_assoc()){
               ?>

               <option value="<?php echo $row1['mast_client_id'];?>"><?php echo $row1['client_name'];?></option>
           <?php }

           ?>
       </select>
        </div>
        <div class="two columns" id="margin1" >

        </div>
        <div class="four  columns"  id="margin1">

        </div>
        <div class="clearFix"></div>

<div id="displaydata">

</div>
    </div>
<br/>

</div>
<div class="clearFix"></div>

<!--Slider part ends here-->

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>