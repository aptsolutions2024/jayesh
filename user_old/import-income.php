<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
$resultIncome = $userObj->showIncomehead($comp_id);


$user_id=$_SESSION['log_id'];
$result11=$userObj->showClient1($comp_id,$user_id);
$rescalin=$userObj->showCalType("caltype_income");
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
    <title>Salary | Import Income</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script>

function clearer()
{
    $("#errormsg1").text('');
    $("#errormsg2").text('');
    $("#errormsg3").text('');
}
        function validation() {
            clearer();
            var error ='';

            var file = document.getElementById('file').value;
            var incomeid = document.getElementById('incomeid').value;
            var caltype = document.getElementById('caltype').value;

            if(incomeid=="0"){
                error ="Please Select the Income";
                $("#errormsg1").text(error);
                $("#errormsg1").show();
                return false;
            } else if(caltype=="0"){
                error ="Please Select the Calculation Typee";
                $("#errormsg2").text(error);
                $("#errormsg2").show();
                return false;
            } else if(file ==""){

                error ="Please Select the file";
                $("#errormsg3").text(error);
                $("#errormsg3").show();
                return false;
            }
        }
        function expton(val){
            if(val!='0'){
                $('#expid').show();
                var a = document.getElementById('linkId'); //or grab it by tagname etc
                a.href = "/export_emp_income/"+val;
            }else{
                $('#expid').hide();

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
        <div class="twelve padd0" id="margin1"> <h3>Employee Income Import</h3></div>
        <div class="clearFix"></div>



        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>

        <div class="twelve" >

            <div class="two padd0 columns"  id="margin1">
                <span class="labelclass">Client :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="clientid" name="clientid" class="textclass" onclick="expton(this.value);">
                    <option value="0">--select--</option>
                    <?php
                    while($row1=$result11->fetch_assoc()){
                        ?>

                        <option value="<?php echo $row1['mast_client_id'];?>"><?php echo $row1['client_name'];?></option>
                    <?php }

                    ?>
                </select>
            </div>
            <div class="six columns" id="margin1" align="center" >
                <div class=" hidecontent " id="expid">
                    <a id="linkId" class="switch" href="">Export to Data Employee Income and Format </a>
                </div>
            </div>

            <div class="clearFix"></div>


        </div>
        <div class="clearFix"></div>
        <br/>

        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>
        <form method="post"  name="frm" action="/import_emp_income_process"  enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >
            <div class="two padd0 columns">
                Income :
            </div>
            <div class="four columns">
                <select id="incomeid" name="incomeid" class="textclass" >
                    <option value="0">--select-</option>
                    <?php
                    while ($rowin=$resultIncome->fetch_assoc()){
                        ?>

                        <option value="<?php echo $rowin['mast_income_heads_id'];?>"><?php echo $rowin['income_heads_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg1"></span>
                  </div>
            <div class="two columns">
                <span class="labelclass">Calculation Type :</span>
            </div>
            <div class="four  columns">
                <select  name="caltype" id="caltype" class="textclass">
                    <option value="0">--select-</option>
                   <?php
                    while($rowcalin=$rescalin->fetch_assoc()){?>
                        <option value="<?php echo $rowcalin['id']; ?>"><?php echo $rowcalin['name']; ?></option>

                    <?php } ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg2"></span>
            </div>

            <div class="clearFix"></div>
            <div class="two padd0 columns">
                Upload CSV File
            </div>
            <div class="four  columns">
                <input type="file" name="file" id="file" class="textclass">
                <span class="errorclass hidecontent" id="errormsg3"></span>
            </div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve" >
                <div class="two columns">
                   &nbsp;
                </div>
                <div class="four  columns">
                    <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
                </div>
                <div class="six columns">


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