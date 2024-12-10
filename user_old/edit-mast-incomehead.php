<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/index");
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

$result1=$userObj->displayIncomehead($id);
$comp_id=$_SESSION['comp_id'];


$result = $userObj->showIncomehead($comp_id);

?>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script>
            function clear() {
                $('#iherror').html("");
            }

        function updateIncomehead(){
            var name=document.getElementById("ihname1").value;
            var ihid=document.getElementById("ihid").value;

            if(name==''){
                $('#iherror').html("Please Enter the Income Head Name");
                $('#iherror').show();
                document.getElementById("ihname").focus();
                $("#success1").hide();
            }
            else if(!isNaN(name))
            {
                $('#iherror').html("Please Enter the Valid Income Hhead Name");
                $('#iherror').show();
                document.getElementById("ihname").focus();
                $("#success1").hide();
            }
            else{
                $.post('/update_mast_incomehead_process',{
                    'name':name,
                    'id':ihid
                },function(data){
                    $('#error').hide();
                    $('#form').hide();
                    $("#success1").html('Record Updated Successfully<br/><br/>');
                    $("#success1").show();
                    $("#dispaly").load(document.URL +  ' #dispaly');
                })

            }

        }
        
        function deleteheads(id){
            if(confirm('Are you You Sure want to delete this Field?')) {
                $.post('/delete_mast_incomehead_process', {
                    'id': id
                }, function (data) {
                    $('#success').hide();
                    $('#error').hide();
                    $("#success1").html('Record Delete Successfully<br/><br/>');
                    $("#success1").show();
                    $("#dispaly").load(document.URL + ' #dispaly');
                    setTimeout(function () {
                        window.location.href = "/add_mast_incomehead";
                    }, 1000);
                });
            }
        }

        
    </script>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id=""><h3>Edit Income Heads</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success1">
            </div>

            <div class="clearFix"></div>
            <input type="hidden" value="<?php echo $result1['mast_income_heads_id']; ?>" name="ihid" id="ihid">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="ihname" id="ihname1" placeholder="Income Head Name" class="textclass" value="<?php echo $result1['income_heads_name']; ?>">
                <span class="errorclass hidecontent" id="iherror1"></span>
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
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateIncomehead();">
                <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleteheads(<?php echo $id; ?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear " class="btnclass" onclick="javascript:location.reload();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
       
</div>
</div>