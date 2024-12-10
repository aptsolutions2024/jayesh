<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];

?>

  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
<!-- Included CSS Files -->



<script>

    $('#cal').val($('#client').val());

    function changeemp(val){

        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
        }
    }
    function showTabdata(id,name){

        $.post('/display_employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;

        });

    }
    function serachemp(val){
       var clientid=$('#client').val();
        $.post('/display_employee2', {
            'name':val,
            'clientid':clientid
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
</script>





<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Print Paysheet</h3></div>
        <form method="post"  id="form" action="/print_dpayslip1">
            <input type="hidden" name="cal" id="cal" value="all">
        <div class="twelve" >             

       <div class="three padd0 columns" id="margin1">
			 No of Employees per page
            </div>
			<div class="four padd0 columns" id="margin1">
			 <input type="text" name="noofper" class="textclass">
            </div>
            
<div class="clearFix"></div>
           

             <div class="one padd0 columns" id="margin1">
			
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        <br />
        <br />
        </div>





</div>

