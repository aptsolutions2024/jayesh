<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];

error_reporting(E_ALL);
/* pagination starts */
$per_page = 10;         // number of results to show per page
$result = $userObj->showBank($comp_id);

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Bank</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_bank_process', {
                'bid': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }
    }
    function clear() {
        $('#berror').html("");
        $('#ad1error').html("");
        $('#ad2error').html("");
        $('#cterror').html("");
        $('#pnerror').html("");
        $('#ifscerror').html("");

    }
  function saveBank() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("bname").value;
        var add=document.getElementById("add").value;
        var branch=document.getElementById("branch").value;
        var ifsccode=document.getElementById("ifsccode").value;
        var city=document.getElementById("city").value;
        var pincode=document.getElementById("pincode").value;




      if(name==''){
          $('#berror').html("Please Enter the Bank Name 1");
          $('#berror').show();
          document.getElementById("bname").focus();
          $("#success").hide();
      }
      else if(!isNaN(name))
      {
          $('#berror').html("Please Enter the Valid Bank Name");
          $('#berror').show();
          document.getElementById("bname").focus();
          $("#success").hide();
      }
      else if(add=='') {
          $('#aderror').html("Please Enter the address 1");
          $('#aderror').show();
          document.getElementById("add1").focus();
          $("#success").hide();
      }
      else if(branch=='') {
          $('#brerror').html("Please Enter the address 2");
          $('#brerror').show();
          document.getElementById("branch").focus();
          $("#success").hide();

      }
      else if(ifsccode=='') {
          $('#ifscerror').html("Please Enter the IFSC Code");
          $('#ifscerror').show();
          document.getElementById("ifsccode").focus();
          $("#success").hide();
      }

      else if(city=='') {
          $('#cterror').html("Please Enter the City Name");
          $('#cterror').show();
          document.getElementById("city").focus();
          $("#success").hide();
      }
      else if(pincode=='') {
          $('#pnerror').html("Please Enter the PIN Code");
          $('#pnerror').show();
          document.getElementById("pincode").focus();
          $("#success").hide();
      }
      else {

              $.post('/add_mast_bank_process',{
                  'name':name,
                  'add':add,
                  'branch':branch,
                  'pincode':pincode,
                  'city':city,
                  'ifsccode':ifsccode

              },function(data){

                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").html(data);
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');


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
        <div class="twelve" id="margin1"><h3>Bank</h3><a href="/exportallbank"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>



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
                <!--<input type="text" name="bname" id="bname" placeholder="Bank Name" class="textclass" onkeyup="searchBank(this.value);" autocomplete="off">-->
                <input type="text" name="bname" id="bname" placeholder="Bank Name" class="textclass"  autocomplete="off">
                <!--<div id="display" class="dispnamedrop"></div>-->
                <span class="errorclass hidecontent" id="berror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">
                <span class="labelclass">Address :</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="add" name="add"  placeholder="Address"></textarea>
                <span class="errorclass hidecontent" id="ad1error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Branch :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" class="textclass"  id="branch" name="branch" placeholder="Branch ">
                <span class="errorclass hidecontent" id="brerror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> IFSC CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="ifsccode" id="ifsccode" placeholder="IFSC Code" class="textclass" onkeyup="searchBank1(this.value);">
                <div id="display" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="ifscerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> City :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="city" id="city" placeholder="City" class="textclass">
                <span class="errorclass hidecontent" id="cterror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PIN Code :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pincode" id="pincode" placeholder="PIN Code" class="textclass">
                <span class="errorclass hidecontent" id="pnerror"></span>
            </div>
            <div class="clearFix"></div>


             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveBank();">
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
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script> function searchBank(val){ 
        $('#display').show();
        $.post('/search_bank', {
            'name': val
        }, function (data) {
            $('#display').html(data);
            //$('#searching').show();
        });
    }
    
    function searchBank1(val){ 
        $('#display').show();
        $.post('/search_bank1', {
            'ifsc': val
        }, function (data) {
            $('#display').html(data);
            //$('#searching').show();
        });
    }
    
      function showTabdata1(id){
         // alert(id);

       $.post('/edit_mast_bank', {
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