<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
$result = $userObj->showDeductionhead($comp_id);

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>

  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>

  <title>Salary | Deduction Heads</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script>
            function clear() {
                $('#iherror').html("");
            }

        function saveDeductionhead(){
            var name=document.getElementById("dname").value;

            if(name==''){
                $('#derror').html("Please Enter the Deduction Head Name");
                $('#derror').show();
                document.getElementById("dname").focus();
                $("#success").hide();
            }
            else if(!isNaN(name))
            {
                $('#derror').html("Please Enter the Valid Deduction Hhead Name");
                $('#derror').show();
                document.getElementById("dname").focus();
                $("#success").hide();
            }
            else{
                $.post('/add_mast_deductionheads_process',{
                    'name':name
                },function(data){

                    $('#error').hide();
                    $("#success").html('Record Insert Successfully<br/><br/>');

                    $("#success").show();
                    $("#form").trigger('reset');
                    $("#dispaly").load(document.URL +  ' #dispaly');
                });

            }

        }
        
        function deleteheads(id) {
            if(confirm('Are you You Sure want to delete this Field?')) {
                $.post('/delete_mast_deductionheads_process', {
                    'id': id
                }, function (data) {

                    $('#success').hide();
                    $('#error').hide();
                    $("#success1").html('Recourd Delete Successfully');
                    $("#success1").show();
                    $("#dispaly").load(document.URL + ' #dispaly');
                });
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
        <div class="twelve" id="margin1"><h3>Deduction Heads</h3><a href="/exportalldeductionhead"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>



        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="dname" id="dname" placeholder="Deduction head Name" class="textclass" onkeyup="searchDeduct(this.value);" autocomplete="off">
                <div id="display" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="derror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">

            </div>
            <div class="four padd0 columns">

            </div>
            <div class="clearFix"></div>



             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveDeductionhead();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        
        <div class="twelve" id="margin1" style="background-color: #fff;" >
            <div id="displayhtml">
            
            </div>

</div>

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>

<script> function searchDeduct(val){
    
        $('#display').show();
        $.post('/search_deduct', {
            'name': val
        }, function (data) {
            $('#display').html(data);
            //$('#searching').show();
        });
    }
      function showTabdata1(id){
         // alert(id);

       $.post('/edit_mast_deductionheads', {
           'id': id
       }, function (data) {
           $('#display').hide();
           
           $('#form').hide();
           $("#margin1 h3").hide();
           $('#displayhtml').html(data);
           
       });

    }
    $(document).ready(function(){
        $('#display').hide();
    })
    </script>

<!--footer end -->
</body>
</html>