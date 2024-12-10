<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
if(isset($_POST['id'])&&$_POST['id']!='') {
    $lid = $_POST['id'];
    $_SESSION['tempdid'] = $lid;
}
else{
    $lid = $_SESSION['tempdid'];
}

include("../lib/class/user-class.php");
$userObj=new user();

$result1=$userObj->displayLocation($lid);
$comp_id=$_SESSION['comp_id'];
?>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    
    function clear() {
        $('#lerror').html("");
   }
  function updateLocation() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("lname1").value;
        var id=document.getElementById("lid").value;

      if(name==''){
          $('#lerror').html("Please Enter the Location Name");
          $('#lerror').show();
          document.getElementById("lname").focus();
          $("#success1").hide();
      }
      else if(!isNaN(name))
      {
          $('#lerror').html("Please Enter the Valid Location Name");
          $('#lerror').show();
          document.getElementById("lname").focus();
          $("#success1").hide();
      }
          else {

              $.post('/update_mast_location_process',{
                  'name':name,
                  'id':id
              },function(data){
                  $('#error').hide();
                 $("#success1").html("Record Updated Successfully<br/><br/>");
                  $("#success1").show();
                $("#display").load(document.URL +  ' #display');
              });

      }

  }
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Location</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="formedit">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>

            <div class="clearFix" ></div>
            
            <input type="hidden" name="lid" id="lid" value="<?php echo $_POST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="lname" id="lname1" placeholder="Designation Name" class="textclass" value="<?php echo $result1['mast_location_name'];?>">
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
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateLocation();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $lid; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear " class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
       
</div>
</div>