<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
//print_r($_SESSION);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $userObj->showClient1($comp_id,$user_id);
$_SESSION['month']='current';
$curyear = date('Y');
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Letters</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
    <script>
        $( function() {
            $("#frdt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy',
				beforeShowDay: disableSpecificWeekDays
            });
            $("#todt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy',
				beforeShowDay: disableSpecificWeekDays1
            });
			
		var monthsToDisable = [0,1,2,4,5,6,7,8,9,10,11];
        var endMonth=[11];
        function disableSpecificWeekDays(date) {
            var month = date.getMonth();
            if ($.inArray(month, monthsToDisable) !== -1) {
                return [false];
            }
            return [true];
        }
		
		var monthsToDisable1 = [0,1,3,4,5,6,7,8,9,10,11];
        var endMonth1=[11];
        function disableSpecificWeekDays1(date) {
            var month = date.getMonth();
            if ($.inArray(month, monthsToDisable1) !== -1) {
                return [false];
            }
            return [true];
        }	
		
        } ); 
		
		function setdate(){ 
			var startbonusyear = $("#frdt").val();
			var endbonusyear = $("#todt").val(); //alert(startbonusyear); alert(endbonusyear);
			$.post('/update_session_for_bonus',{
			'startbonusyear':startbonusyear,
			'endbonusyear':endbonusyear
            },function(data){ alert(data);
			$("#test").text(data);
              $("#success1").html("<div class='success31'>Record updated Successfully!</div>");
              $("#success1").show();
            })			
	
     
		}
	</script>

 <body>
<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"> <h3>Bonus Year</h3></div>

        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass">From  :</span>
            </div>
            <div class="two padd0 columns"  >
			<input type="text" name="frdt" id="frdt" class="textclass" value="<?php if(isset($_SESSION['startbonusyear'])){echo $_SESSION['startbonusyear'];}?>">  
            </div>
			
			<div class="one padd0 columns"  >
                <span class="labelclass">&nbsp; &nbsp; &nbsp; To  :</span>
            </div>
            <div class="two padd0 columns"  ><input type="text" name="todt" id="todt" class="textclass" value="<?php if(isset($_SESSION['endbonusyear'])){echo $_SESSION['endbonusyear'];}?>">
            </div>

           <div class="two padd0 columns" align="center">

                <input type="button" onclick="setdate();" class="btnclass" value="Select Year">
            </div>
			<div class="clearFix"></div>
			 <div class="twelve padd0 columns">
			<div id="success1" class="hidecontent "></div>
			</div>
          
        </div>
        <div class="clearFix"></div>
       
    </div>

    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>