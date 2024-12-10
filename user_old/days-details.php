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
/*	$( function() {
            $("#frdt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#todt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );*/
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
function validatation(){
	var frdt = $("#frdt").val();
	var todt = $("#todt").val();
	 var radio = $("input[name='gender']:checked").val();
	if(frdt ==""){
		$("#fderror").text("Please select From Date");
		$("#fderror").show();
	}
	if(todt ==""){
		$("#tderror").text("Please select To Date");
		$("#tderror").show();
	}
	
}
</script>
<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Export Paysheet</h3></div>
        <div class="clearFix"></div>
        <form method="post"  id="form" action="/export_days_details"  onsubmit="return validatation();">
            <input type="hidden" name="cal" id="cal" value="all">
        <div class="twelve" id="margin1">
<div class="twelve ">
            <div class="one padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two padd0 columns"> 
                <input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked>All
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" >Random
            </div>
            <div class="five padd0 columns">
                <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                    <br/>
                    <br/>
                </div>
            </div>
           <div class="three padd0 columns">
   </div>  </div> 
  
	<!--<div class="twelve">
	<div class="four padd0 columns">
	<div class="four padd0 columns"> From Date
	</div>
	<div class="eight padd0 columns">
	<input type="text" name="frdt" id="frdt" class="textclass">
	</div>
	</div>

	<div class="four padd0 columns">
	<div class="four padd0 columns">&nbsp; To Date
	</div>
	<div class="eight padd0 columns">
	<input type="text" name="frdt" id="frdt" class="textclass">
	</div>
	</div>
	</div> -->  
        <div class="clearFix"></div>
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="submit" name="submit" id="submit" value="Export" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
            
        
        </div>
		</form>
</div>