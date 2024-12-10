<?php
session_start();
//echo '<pre>';print_r($_SESSION);exit;
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    session_destroy();
    header("/index");
}
//include("../lib/connection/db-config.php");
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
  <title>Salary | Transactions Days</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>
      function clstr(){
          $('#clerror').html("");
          $('#lmterror').html("");
      }
        function displaydata(){ //alert("hello");
            $(".successclass").hide();
            clstr();
            var val=document.getElementById('client').value;
            var lmt=document.getElementById('lmt').value;
            if(val=='0'){
                $('#clerror').html("Please Select the Client Name");
                $('#clerror').show();
                document.getElementById("client").focus();
                $("#display").hide();

            }
            else if(lmt=='0'){
                $('#lmterror').html("Please Select the Limit");
                $('#lmterror').show();
                document.getElementById("lmt").focus();
                $("#display").hide();
            }
            else {
             $.post('/display_tran_days',{
                'id':val,
                'lmt':lmt
            },function(data){
                $("#display").html(data);
                $("#display").show();
            });
            monthdisplay(val);

            }
        }

      function monthdisplay(val){
          $.post('/display_monthval',{
              'id':val
          },function(data){
              $("#sm").html(data);
              $("#sm").show();
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

<form method="post"  id="form" action="/tran_day_process" >
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Transactions Days</h3></div>
        <div class="clearFix"></div>
                <?php
                if(isset($_POST['msg']) && $_POST['msg']=='update'){
                    ?>
                <div class="twelve padd0 columns successclass">
                    <br />Transactions Updated successfully!<br />
                </div>
                <?php
                }
                ?>
                <div class="clearFix"></div>
            <div class="twelve" id="margin1">
                <div class="one padd0 columns"  >
                    <span class="labelclass">Client :</span>
                </div>
                <div class="four padd0 columns"  >
                    <select class="textclass" name="client" id="client" onchange="displaydata();">
                        <option value="0">--Select--</option>
                        <?php //while($row1=mysql_fetch_array($result1)){
                        while($row1= $result1->fetch_assoc()){
                        ?>
                            <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>
                        <?php } ?>
                    </select>
                    <span class="errorclass hidecontent" id="clerror"></span>
                </div>


                <div class="two padd0 columns"  align="center">
                    <span class="labelclass">Record Range :</span>
                </div>
                <div class="two padd0 columns">
                    <select class="textclass" name="lmt" id="lmt" onchange="displaydata();">
                         <option value="0">--Select--</option>
                        <option value="0, 30">0 to 30</option>
                        <option value="30, 30">31 to 60</option>
                        <option value="60, 30">61 to 90</option>
                       
                        <!--option value="0">--Select--</option>
                        <option value="0, 40">0 to 40</option>
                        <option value="40, 40">41 to 80</option>
                        <option value="80, 40">81 to 120</option>
                        <option value="120, 40">121 to 160</option>
                        <option value="160, 40">161 to 200</option>
                        <option value="200, 40">201 to 240</option>
                        <option value="240, 40">241 to 280</option>
                        <option value="280, 40">281 to 320</option>
                        <option value="320, 40">321 to 360</option>
                        <option value="360, 40">361 to 400</option>
                        <option value="400, 40">401 to 440</option>
                        <option value="440, 40">441 to 480</option-->
                    </select>
                    <span class="errorclass hidecontent" id="lmterror"></span>
                </div>
                <div class="three columns">
                    <span class="labelclass">Month :</span> <span class="labelclass" id="sm">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span>&nbsp;

                    <input type="button" onclick="displaydata();" class="btnclass" value="Show" >
                </div>
                </div>
                <div class="clearFix"></div>
</div>
    <div class="twelve" id="display" align="center">
    </div>
	</div>
</form>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>

<!--<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>-->

<!--footer end -->

</body>

</html>