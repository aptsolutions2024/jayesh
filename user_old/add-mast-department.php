<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/index");
}

//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
//include_once('../paginate.php');

$comp_id=$_SESSION['comp_id'];


$result = $userObj->showDepartment($comp_id);

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Department</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_department_process', {
                'did': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
//            $("#success1").html('Recourd Delete Successfully');
                $("#success1").html(data);
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }
    }
    function clear() {
        $('#dnerror').html("");
   }
  function saveDepartment() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("dname").value;

      if(name==''){
          $('#dnerror').html("Please Enter the Department Name");
          $('#dnerror').show();
          document.getElementById("dname").focus();
          $("#success").hide();
      }
      else if(!isNaN(name))
      {
          $('#dnerror').html("Please Enter the Valid Department Name");
          $('#dnerror').show();
          document.getElementById("dname").focus();
          $("#success").hide();
      }
          else {

              $.post('/add_mast_department_process',{
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
        <div class="twelve" id="margin1"><h3>Department</h3><a href="/exportalldepartment"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>

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
                <input type="text" name="dname" id="dname" placeholder="Department Name" class="textclass" onkeyup="searchdept(this.value);" autocomplete="off">
                <div id="dispaly" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="dnerror"></span>
                
            </div>
            <div class="two padd0 columns"></div>
            <div class="one padd0 columns"> </div>
            <div class="four padd0 columns"> </div>
            <div class="clearFix"></div>
            <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveDepartment();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispalyedithtml">
            
            </div>
</div>
</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>
<script> function searchdept(val){
        $('#dispaly').show();
        $.post('/search_dept', {
            'name': val
        }, function (data) {
            $('#dispaly').html(data);
            //$('#searching').show();
        });
    }
      function showTabdata1(id){
         // alert(id);

       $.post('/edit_mast_department', {
           'id': id
       }, function (data) {
           $('#dispaly').hide();
           
           $('#form').hide();
           $("#margin1 h3").hide();
           $('#dispalyedithtml').html(data);
           
       });

    }
    $(document).ready(function(){
        $('#dispaly').hide();
    })
    </script>
<!--footer start -->
<?php include('footer.php');?>
<!--footer end -->
</body>
</html>