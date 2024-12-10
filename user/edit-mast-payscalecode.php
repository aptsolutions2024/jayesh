<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
if(isset($_POST['id'])&&$_POST['id']!='') {
    $pscid = $_POST['id'];
    $_SESSION['tempdid'] =  $pscid ;
}
else{
    $pscid  = $_SESSION['tempdid'];
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();

$result1=$userObj->displayPayscalecode($pscid);
$comp_id=$_SESSION['comp_id'];

$result = $userObj->showPayscalecode($comp_id);

?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_payscalecode_process', {
                'id': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
                setTimeout(function () {
                    window.location.href = "/add_mast_payscalecode";
                }, 1000);
            });
        }
    }
    function clear() {
        $('#dnerror').html("");
   }
  function updateQualification() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("spname11").value;
        var id=document.getElementById("pscid").value;

      if(name==''){
          $('#sperror').html("Please Enter the Pay Scale Code Name");
          $('#sprror').show();
          document.getElementById("spname11").focus();
          $("#success1").hide();
      }
      else if(!isNaN(name))
      {
          $('#sprror').html("Please Enter the Valid Pay Scale Code Name");
          $('#sprror').show();
          document.getElementById("spname11").focus();
          $("#success1").hide();
      }
          else {

              $.post('/update_mast_payscalecode_process',{
                  'name':name,
                  'id':id
              },function(data){
                  $('#error').hide();
                 $("#success1").html('Record Updated Successfully<br/><br/>');
                  $("#success1").show();
                $("#dispaly").load(document.URL +  ' #dispaly');
              })

      }

  }
    </script>


<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Pay Scale Code</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="editform">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">


            </div>

            <div class="clearFix"></div>
            <input type="hidden" name="pscid" id="pscid" value="<?php echo $_POST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="spname" id="spname11" placeholder="Pay Scale Code Name"  class="textclass" value="<?php echo $result1['mast_paycode_name'];?>">
                <span class="errorclass hidecontent" id="sperror1"></span>
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
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateQualification();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $pscid; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        
</div>
</div>