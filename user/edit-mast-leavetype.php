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
$result1 = $userObj->displayLeavetype($id);
$comp_id=$_SESSION['comp_id'];

$result = $userObj->showLeavetype($comp_id);

?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script>
            function clear() {
                $('#iherror1').html("");
            }

        function updateLeavetype(){
            var name=document.getElementById("ltname1").value;
            var id=document.getElementById("ltid").value;

            if(name==''){
                $('#lterror1').html("Please Enter the Leave Type Name");
                $('#lterror1').show();
                document.getElementById("ltname1").focus();
                $("#success1").hide();
            }
            else if(!isNaN(name))
            {
                $('#lterror1').html("Please Enter the Valid Leave Type Name");
                $('#lterror1').show();
                document.getElementById("ltname1").focus();
                $("#success1").hide();
            }
            else{
                $.post('/update_mast_leavetype_process',{
                    'name':name,
                    'id':id
                },function(data){
                    $('#error1').hide();
                    $("#success1").html('Record Updated Successfully<br/><br/>');
                    $("#success1").show();
                    $("#dispaly").load(document.URL +  ' #dispaly');
                });
            }
        }

            function deleteleavetype(id){
                if(confirm('Are you You Sure want to delete this Field?')) {
                    $.post('/delete_mast_leavetype_process', {
                        'id': id
                    }, function (data) {

                        $('#success1').hide();
                        $('#error1').hide();
                        $("#success1").html('Record Delete Successfully<br><br>');
                        $("#success1").show();
                        $("#dispaly").load(document.URL + ' #dispaly');
                        setTimeout(function () {
                            window.location.href = "/add_mast_leavetype";
                        }, 1000);
                    });
                }
            }
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Leave Type</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form">
            <input type="hidden" name="ltid" id="ltid" value="<?php echo $id; ?>">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="ltname" id="ltname1" placeholder="Leave Type Name" class="textclass" value="<?php echo $result1['leave_type_name']; ?>">
                <span class="errorclass hidecontent" id="lterror1"></span>
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
            <div class="seven padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateLeavetype();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleteleavetype(<?php echo $id; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        
</div>
</div>