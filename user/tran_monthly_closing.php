<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
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
  <title>Salary | Monthly Closing</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>

      function closing(){
         $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientid = '1';
          $.post('/monthly_closing',{
              'clientid':clientid
          },function(data){
              $("#display").html(data);
          });
      }
      function update_advances(){
         $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientid = '1';
          $.post('/update_advances',{
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

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Monthly Closing</h3></div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
            <div class="one padd0 columns"  id="margin1">
               <!-- <span class="labelclass">Client :</span> -->
            </div>
            <div class="four padd0 columns" id="margin1">
                <button class="btnclass" onclick="closing()">
                    Monthly Closing

                </button>
               <!-- <select id="clientid" name="clientid" class="textclass" >
                    <option value="0">--select--</option>
                    </select> -->
            </div>
           

		<div class="four padd0 columns" id="margin1">
                <button class="btnclass" onclick="update_advances()">
                    Update Advances

                </button>
               <!-- <select id="clientid" name="clientid" class="textclass" >
                    <option value="0">--select--</option>
                    </select> -->
            </div>
		   <div class="two  padd0 columns" id="margin1" align="center">
              <!--  <button class="btnclass" onclick="closing()">
                    Monthly Closing

                </button>-->
            </div>
            <div class="five  padd0 columns" id="margin1" align="center">

            </div>
        </div>
                <div class="clearFix"></div>
    <div class="twelve" id="display">
    </div>
</div>
</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<!--footer end -->
</body>
</html>