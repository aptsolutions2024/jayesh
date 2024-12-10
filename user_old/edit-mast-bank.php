<?php
session_start();
//print_r($_POST);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
if(isset($_POST['id'])&&$_POST['id']!='') {
    $bid = $_POST['id'];
    $_SESSION['tempdid'] = $bid;
}
else{
    $bid = $_SESSION['tempdid'];
}

include("../lib/class/user-class.php");
$userObj=new user();
$result1=$userObj->displayBank($bid);
$comp_id=$_SESSION['comp_id'];

// number of results to show per page
$result = $userObj->showBank($comp_id);

?>

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
        $('#berror1').html("");
        $('#aderror1').html("");
        $('#brerror1').html("");
        $('#cterror1').html("");
        $('#pnerror1').html("");
        $('#ifscerror1').html("");

    }
  function updateBank(){
      clear();
      $('#success1').hide();
        var name=document.getElementById("bname1").value;
        var add=document.getElementById("add1").value;
        var branch=document.getElementById("branch1").value;
        var ifsccode=document.getElementById("ifsccode1").value;
        var city=document.getElementById("city1").value;
        var pincode=document.getElementById("pincode1").value;
        var bid=document.getElementById("bid").value;


      if(name==''){
          $('#berror1').html("Please Enter the Bank Name");
          $('#berror1').show();
          document.getElementById("bname").focus();
          $("#success1").hide();
      }
      else if(!isNaN(name))
      {
          $('#berror1').html("Please Enter the Valid Bank Name");
          $('#berror1').show();
          document.getElementById("bname").focus();
          $("#success1").hide();
      }
      else if(add=='') {
          $('#aderror1').html("Please Enter the address");
          $('#aderror1').show();
          document.getElementById("add").focus();
          $("#success1").hide();
      }
      else if(branch=='') {
          $('#brerror1').html("Please Enter the branch");
          $('#brerror1').show();
          document.getElementById("branch").focus();
          $("#success1").hide();

      }
      else if(ifsccode=='') {
          $('#ifscerror1').html("Please Enter the IFSC Code");
          $('#ifscerror1').show();
          document.getElementById("ifsccode").focus();
          $("#success1").hide();
      }

      else if(city=='') {
          $('#cterror1').html("Please Enter the City Name");
          $('#cterror1').show();
          document.getElementById("city").focus();
          $("#success1").hide();
      }
      else if(pincode=='') {
          $('#pnerror1').html("Please Enter the PIN Code");
          $('#pnerror1').show();
          document.getElementById("pincode").focus();
          $("#success1").hide();
      }
      else {

              $.post('/update_mast_bank-process',{
                  'bid':bid,
                  'name':name,
                  'add':add,
                  'branch':branch,
                  'pincode':pincode,
                  'city':city,
                  'ifsccode':ifsccode

              },function(data){

                  $('#error1').hide();
                  $("#success1").html('Record Updated Successfully<br/><br/>');
                  $("#success1").show();
                  $("#dispaly").load(document.URL +  ' #dispaly');
                  setTimeout(function () {
                      window.location.href = "/add_mast_bank";
                  }, 1000);
              });

      }

  }
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Bank</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>

            <div class="clearFix"></div>
            <input type="hidden" name="bid" id="bid" value="<?php echo $_POST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="bname" id="bname1" placeholder="Bank Name" class="textclass" value="<?php  echo $result1['bank_name']; ?>" >
                <span class="errorclass hidecontent" id="berror1"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">
                <span class="labelclass">Address :</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="add1" name="add"  placeholder="Address 1"><?php  echo $result1['add1']; ?></textarea>
                <span class="errorclass hidecontent" id="aderror1"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Branch :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <textarea class="textclass"  id="branch1" name="branch" placeholder="Address 2"><?php  echo $result1['branch']; ?></textarea>
                <span class="errorclass hidecontent" id="brerror1"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> IFSC CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="ifsccode" id="ifsccode1" placeholder="IFSC Code" class="textclass"  value="<?php  echo $result1['ifsc_code']; ?>" >
                <span class="errorclass hidecontent" id="ifscerror1"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> City :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="city" id="city1" placeholder="City" class="textclass"  value="<?php  echo $result1['city']; ?>" >
                <span class="errorclass hidecontent" id="cterror1"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PIN Code :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pincode" id="pincode1" placeholder="PIN Code" class="textclass"  value="<?php  echo $result1['pin_code']; ?>" >
                <span class="errorclass hidecontent" id="pnerror1"></span>
            </div>
            <div class="clearFix"></div>


             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateBank();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $bid; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        
</div>
 </div>