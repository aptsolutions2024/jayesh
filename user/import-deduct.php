<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$resultdest = $userObj->showDeductionhead($comp_id);
$resultIncome = $userObj->showIncomehead($comp_id);


$user_id=$_SESSION['log_id'];
$result11=$userObj->showClient1($comp_id,$user_id);
$rescalde=$userObj->showCalType("caltype_deduct");
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
    <title>Salary | Import Deduct</title>
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
            var deductid = document.getElementById('deductid').value;
            var decaltype = document.getElementById('decaltype').value;

            if(deductid=="0"){
                error ="Please Select the Deduct";
                $("#errormsg1").text(error);
                $("#errormsg1").show();
                return false;
            } else if(decaltype=="0"){
                error ="Please Select the Calculation Type";
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
                a.href = "/export_emp_deduct.php?cid="+val;
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
        <div class="twelve padd0" id="margin1"> <h3>Employee Deduct Import </h3></div>
        <div class="clearFix"></div>


        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>
        <br/>



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
                    <a id="linkId" class="switch" href="">Export to Data Employee Deduct and Format </a>
                </div>
            </div>

            <div class="clearFix"></div>


        </div>
        <div class="clearFix"></div>





        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>


        <form method="post"  name="frm" action="/import_emp_deduct_process"   enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >
            <div class="two padd0 columns">
                Deduct :
            </div>
            <div class="three columns">
                <select id="deductid" name="deductid" class="textclass">
                    <option value="0">--select-</option>
                    <?php
                    while ($rowde=$resultdest->fetch_assoc()){
                        ?>

                        <option value="<?php echo $rowde['mast_deduct_heads_id'];?>" ><?php echo $rowde['deduct_heads_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg1"></span>
                  </div>
            <div class="two columns">
              &nbsp;
            </div>
            <div class="two columns">
                <span class="labelclass">Calculation Type :</span>
            </div>
            <div class="three columns">
                <select name="decaltype" id="decaltype" class="textclass">
                    <option value="0">--select-</option>
                <?php
                    while($rowcalde=$rescalde->fetch_assoc()){?>
                        <option value="<?php echo $rowcalde['id']; ?>"><?php echo $rowcalde['name']; ?></option>

                    <?php } ?>
                </select>

                <span class="errorclass hidecontent" id="errormsg2"></span>
            </div>

            <div class="clearFix"></div>
            <div class="two padd0 columns">
                Upload CSV File
            </div>
            <div class="three columns">
                <input type="file" name="file" id="file" class="textclass">
                <span class="errorclass hidecontent" id="errormsg3"></span>
            </div>
            <div class="two columns">
                &nbsp;
            </div>
            <div class="five columns">
                &nbsp;
            </div>
            <div class="clearFix"></div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve" >
                <div class="two columns">
        &nbsp;
                </div>
                <div class="four  columns">
                    <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
                </div>
                <div class="four columns">


                </div>
                <div class="one columns">

                </div>
                <div class="three columns">

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