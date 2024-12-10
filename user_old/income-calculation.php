<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $userObj->showClient1($comp_id,$user_id);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Income Tax Calculation </title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>

      function calsal(){
          $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientid= document.getElementById('clientid').value;
          $.post('/sal_calc',{
              'clientid':clientid
          },function(data){

              $("#display").html(data);

          });
      }

  </script>

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
<form method="post"  action="/income_tax_calc">
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Income Tax Calculation</h3></div>
        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
            <div class="one padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked>All
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" >Random
            </div>
            <div class="five padd0 columns">
                <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                    <br/>
                    <br/>
                </div>

            </div>
            <div class="three padd0 columns">
            </div>
    </div>
    <div class="clearFix"></div>
        <div class="twelve" id="margin1">
            <div class="one padd0 columns">
             <input type="submit" name="cal" id="cal" value="Calculation" class="btnclass">
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="five padd0 columns">

            </div>
            <div class="three padd0 columns">

            </div>
        </div>
</div>
</div>
    </form>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script>
    function changeemp(val){
        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
        }
    }
    function showTabdata(id,name){

        $.post('/display_employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;

        });

    }
    function serachemp(val){
        $.post('/display_employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
</script>
<!--footer end -->
</body>
</html>