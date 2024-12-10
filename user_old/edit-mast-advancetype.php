<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

if(isset($_POST['id'])&&$_POST['id']!='') {
    $id = $_POST['id'];
    $_SESSION['tempdid'] = $id;
}
else{
    $id = $_SESSION['tempdid'];
}

include("../lib/class/user-class.php");
$userObj=new user();
$result1 = $userObj->displayAdvancetype($id);
$comp_id=$_SESSION['comp_id'];

$result = $userObj->showAdvancetype($comp_id);
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script>
            function clear() {
                $('#iherror').html("");
            }

        function updateAdvancetype(){
            var name=document.getElementById("adname1").value;
            var id=document.getElementById("adid").value;

            if(name==''){
                $('#aderror1').html("Please Enter the Advance Type Name");
                $('#aderror1').show();
                document.getElementById("adname1").focus();
                $("#success1").hide();
            }
            else if(!isNaN(name))
            {
                $('#aderror1').html("Please Enter the Valid Advance Type Name");
                $('#aderror1').show();
                document.getElementById("adname1").focus();
                $("#success1").hide();
            }
            else{
                $.post('/update_mast_advancetype_process',{
                    'name':name,
                    'id':id
                },function(data){
                    $('#error').hide();
                    $("#success1").html('Record Updated Successfully<br/><br/>');
                    $("#success1").show();
                    $("#dispaly").load(document.URL +  ' #dispaly');
                    setTimeout(function () {
                            window.location.href = "/add_mast_advancetype";
                        }, 1000);
                });
            }
        }

            function deleteadvancetype(id){
                if(confirm('Are you You Sure want to delete this Field?')) {
                    $.post('/delete_mast_advancetype_process', {
                        'id': id
                    }, function (data) {

                        $('#success').hide();
                        $('#error').hide();
                        $("#success1").html('Record Delete Successfully<br/><br/>');
                        $("#success1").show();
                        $("#dispaly").load(document.URL + ' #dispaly');
                        setTimeout(function () {
                            window.location.href = "add_mast_advancetype";
                       }, 1000);
                    });
                }
            }
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Advance Type</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form">
            <input type="hidden" name="adid" id="adid" value="<?php echo $id; ?>">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>
            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="adname" id="adname1" placeholder="Advance Type Name" class="textclass" value="<?php echo $result1['advance_type_name']; ?>">
                <span class="errorclass hidecontent" id="aderror1"></span>
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
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateAdvancetype();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleteadvancetype(<?php echo $id; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
</div>
</div>
