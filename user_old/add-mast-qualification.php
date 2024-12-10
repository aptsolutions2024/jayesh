<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];

/* pagination starts */
$per_page =10;         // number of results to show per page
$result = $userObj->showQualification($comp_id);

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Qualification</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_qualification_process', {
                'id': id
            }, function (data) {
                alert(data);
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#display").load(document.URL + ' #display');
            });
        }
    }
    function clear() {
        $('#qlerror').html("");
   }
  function saveQualification() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("qlname").value;
      if(name==''){
          $('#qlerror').html("Please Enter the Qualification Name");
          $('#qlerror').show();
          document.getElementById("qlname").focus();
          $("#success").hide();
      }
      else if(!isNaN(name))
      {
          $('#qlerror').html("Please Enter the Valid Qualification Name");
          $('#dnerror').show();
          document.getElementById("qlname").focus();
          $("#success").hide();
      } else {
              $.post('/add_mast_qualification_process',{
                  'name':name
              },function(data){
                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#display").load(document.URL +  ' #display');
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
        <div class="twelve" id="margin1"><h3>Qualification</h3><a href="/exportallqualification"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>
        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success"></div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="qlname" id="qlname" placeholder="Qualification Name" class="textclass" onkeyup="searchQual(this.value);" autocomplete="off">
                <div id="display" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="qlerror"></span>
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
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveQualification();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
              
            </form>
        </div>
        
    
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispalyedithtml">
            
            </div>
</div>

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script> function searchQual(val){
        $('#display').show();
        ///alert(val);
        $.post('/search_qualification', {
            'name': val
        }, function (data) {
            $('#display').html(data);
            //$('#searching').show();
        });
    }
      function showTabdata1(id){
         // alert(id);

       $.post('/edit_mast_qualification', {
           'id': id
       }, function (data) {
           $('#dispaly').hide();
           
           $('#form').hide();
           $("#margin1 h3").hide();
           $('#dispalyedithtml').html(data);
           
       });

    }
    $(document).ready(function(){
        $('#display').hide();
    })
    </script>
<!--footer end -->
</body>
</html>