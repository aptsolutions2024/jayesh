<?php 
//$result = $userObj->showDepartment($comp_id);
include("../lib/class/user-class.php");
$userObj=new user();
session_start();
$comp_id=$_SESSION['comp_id'];
$did = $_POST['id'];
$result1=$userObj->displayDepartment($did);
//print_r($_POST);
//print_r($_SESSION);
//print_r($result1);

?>
<script>
    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_department_process', {
                'did': id
            }, function (data) {
				//alert(data);
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
                setTimeout(function () {
                    window.location.href = "/add_mast_department";
                }, 2000);
            });
        }
    }
  
    function clear() {
        $('#dnerror').html("");
   }
  function updateDepartment() {
      clear();
      $('#success').hide();
      
        var name= $("#editform #dname").val();
        var did=$("#editform #did").val();
        alert(name);
        alert(did);
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
      }else {

              $.post('/update_mast_department_process',{
                  'name':name,
                  'did':did
              },function(data){
                  $('#error').hide();
                 $("#success").html('Record Updated Successfully<br/><br/>');
                  $("#success").show();
                   $("#success1").hide();
                  //$("#test").html(data);
               // $("#dispaly").load(document.URL +  ' #dispaly');
              });
      }
  }
    </script>
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" ><h3>Edit Department</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="editform">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">
            </div>
            <div class="clearFix"></div>
            <input type="hidden" name="did" id="did" value="<?php echo $_POST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="dname" id="dname" placeholder="Department Name" class="textclass" value="<?php echo $result1['mast_dept_name'];?>" onkeyup="searchdept(this.value);" autocomplete="off">
                <span class="errorclass hidecontent" id="dnerror"></span>
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
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateDepartment();"> <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $did; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix" >&nbsp;</div>
            <div><span class="successclass hidecontent" id="success2"></span></div>
            </form>
            
        </div>
       
    
        