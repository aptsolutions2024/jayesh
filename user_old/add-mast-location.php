<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$comp_id=$_SESSION['comp_id'];
/* pagination starts */
$per_page =10;         // number of results to show per page
$result = $userObj->showLocation($comp_id);

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>
    <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
    <title>Salary | Location</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>

    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_location_process', {
                'id': id
            }, function (data) {
                $("#displayhtml").hide();
                $("#displayhtml").load(document.URL +  ' #displayhtml');
                $('#success').hide();
                $('#error').hide();
                $("#success").html("Record Delete Successfully<br/><br/>");
                $("#success").show();
                $("#form").trigger('reset');
               $("#form").show();
               $("h3").show();
                
                //$("#displayhtml").load(document.URL);
            });
        }
    }
    function clear() {
        $('#lerror').html("");
   }
  function saveLocation() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("lname").value;
      if(name==''){
          $('#lerror').html("Please Enter the Location Name");
          $('#lerror').show();
          document.getElementById("lname").focus();
          $("#success").hide();
      }
      else if(!isNaN(name))
      {
          $('#derror').html("Please Enter the Valid Location Name");
          $('#derror').show();
          document.getElementById("lname").focus();
          $("#success").hide();
      } else {
          $.post('/add_mast_location_process',{
              'name':name
          },function(data){

              $('#error').hide();
              $("#success").html('Record Insert Successfully<br/><br/>');
              $("#success").show();
              $("#form").trigger('reset');
              $("#dispaly").load(document.URL +  ' #dispaly');
         })
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
        <div class="twelve" id="margin1"><h3>Location</h3><a href="/exportalllocation"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>
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
                <input type="text" name="lname" id="lname" placeholder="Location Name" class="textclass" onkeyup="searchLoc(this.value);" autocomplete="off">
                <div id="display" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="lerror"></span>
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
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveLocation();">
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
<!--footer end -->
<script> function searchLoc(val){
        $('#display').show();
        $.post('/search_loc', {
            'name': val
        }, function (data) {
            $('#display').html(data);
            //$('#searching').show();
        });
    }
      function showTabdata1(id){
         // alert(id);

       $.post('/edit_mast_location', {
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
</body>

</html>