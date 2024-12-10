<?php
session_start();

if(isset($_SESSION['log_id']) && $_SESSION['log_id']==''){
    header("/home");
}

if(isset($_POST['id']) && $_POST['id']!='') {
    $did = $_POST['id'];
    $_SESSION['tempdid'] = $did;
}
else{
    $did = $_SESSION['tempdid'];
}

include("../lib/class/user-class.php");
$userObj=new user();

$result1=$userObj->displayDesignation($did);
$comp_id=$_SESSION['comp_id'];
$result = $userObj->showDesignation($comp_id);
?>

  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_designation_process', {
                'id': id
            }, function (data) {

                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
                setTimeout(function () {
                    window.location.href="/add_mast_designation";
                }, 1000);
            });
        }
    }
    function clear() {
        $('#derror').html("");
   }
  function updateDesignation() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("name").value;
        var id=document.getElementById("did").value;

      if(name==''){
          $('#derror').html("Please Enter the Designation Name");
          $('#derror').show();
          document.getElementById("name").focus();
          $("#success1").hide();
      }
      else if(!isNaN(name))
      {
          $('#derror').html("Please Enter the Valid Designation Name");
          $('#derror').show();
          document.getElementById("name").focus();
          $("#success1").hide();
      }
          else {
              $.post('/update_mast_designation_process',{
                  'name':name,
                  'id':id
              },function(data){
                  $('#error').hide();
                  $("#success1").html('Record Updated Successfully<br/><br/>');
                  $("#success1").show();
                  $("#dispaly").load(document.URL +  ' #dispaly');

              });
      }

  }
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" ><h3>Edit Designation</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="editform">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">


            </div>

            <div class="clearFix"></div>
            <input type="hidden" name="did" id="did" value="<?php echo $_POST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="name" id="name" placeholder="Designation Name" class="textclass" value="<?php echo $result1['mast_desg_name'];?>">
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
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateDesignation();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $did; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
</div>
</div>