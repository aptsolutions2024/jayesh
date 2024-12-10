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
$result1 = $userObj->displayDeductionhead($id);
$comp_id=$_SESSION['comp_id'];

$result = $userObj->showDeductionhead($comp_id);
?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script>
            function clear() {
                $('#iherror').html("");
            }

        function updateDeductionhead(){
            var name=document.getElementById("dname1").value;
            var id=document.getElementById("did").value;

            if(name==''){
                $('#editform #derror').html("Please Enter the Deduction Head Name");
                $('#editform #derror').show();
                document.getElementById("dname1").focus();
                $("#success").hide();
            }
            else if(!isNaN(name))
            {
                $('#editform #derror').html("Please Enter the Valid Deduction Hhead Name");
                $('#editform #derror').show();
                document.getElementById("dname1").focus();
                $("#success").hide();
            }
            else{
                $.post('/update_mast_deductionheads_process',{
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
        
        function deleteheads(id) {
            if(confirm('Are you You Sure want to delete this Field?')) {
                $.post('/delete_mast_deductionheads_process', {
                    'id': id
                }, function (data) {

                    $('#success').hide();
                    $('#error').hide();
                    $("#success1").html('Record Delete Successfully<br></br>');
                    $("#success1").show();
                    $("#dispaly").load(document.URL + ' #dispaly');
                    setTimeout(function () {
                        window.location.href = "/add_mast_deductionheads";
                    }, 1000);

                });
            }
        }

        
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Deduction Heads</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="editform">
            <input type="hidden" name="did" id="did" value="<?php echo $id; ?>">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="dname" id="dname1" placeholder="Deduction head Name" class="textclass" value="<?php echo $result1['deduct_heads_name']; ?>">
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
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateDeductionhead();">
                
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleteheads(<?php echo $id; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
</div>
</div>