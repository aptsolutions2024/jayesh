<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$user_id=$_SESSION['log_id'];
$comp_id=$_SESSION['comp_id'];
$result11=$userObj->showClient1($comp_id,$user_id);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Employee</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <link rel="stylesheet" href="../css/style.css">
<script>
    function validation() {
        var errormsg ='';
        var file = document.getElementById('file').value;
       if(file ==""){
            error ="Please Select the file";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }
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

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Employee Import </h3></div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>
        <br/>


        <div class="twelve " >
            <div class="seven padd0 columns">
                <a class="switch" href="/export_emp_data">Export to Data Employee and Format </a>
            </div>
            <div class="five columns">


            </div>

        </div>
        <div class="clearFix"></div>



        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>
        <form method="post"  name="frm" action="/import_emp_process"  enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >

            <div class="one padd0 columns" >
                <span class="labelclass">Client :</span>
            </div>
            <div class="four  columns">
                <select id="clientid" name="clientid" class="textclass">
                    <option value="0">--select--</option>
                    <?php
                    while($row1=$result11->fetch_assoc()){
                        ?>

                        <option value="<?php echo $row1['mast_client_id'];?>"><?php echo $row1['client_name'];?></option>
                    <?php }

                    ?>
                </select>
            </div>
            <div class="two  columns" align="center">
              Upload CSV File :
            </div>
            <div class="four columns">

                <input type="file" name="file" id="file" class="textclass"><br/>
                <span class="errorclass hidecontent" id="errormsg"></span>
                  </div>
            <div class="one columns">
                <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
            </div>

        </div>
        </form>
        <div class="clearFix"></div>









    </div>


</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>