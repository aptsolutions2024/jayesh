<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $userObj->showClient1($comp_id,$user_id);

$_SESSION['month']='current';
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
        <div class="twelve" id="margin1"> <h3>Bonus Export</h3></div>

        <div class="clearFix"></div>
		<form method="post"  method ="post" action="/export_bonus_calculation" onsubmit="return validation()">
        <div class="twelve" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
            <div class="three padd0 columns"  >
                <select class="textclass" name="client" id="client" >
                    <option value="">--Select--</option>
                    <?php while($row1=$result1->fetch_array()){?>
                        <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>
                    <?php } ?>

                </select>
                <span class="errorclass hidecontent" id="nerror"></span>
            </div>           
			<div class="two padd0 columns" align="center">
                <input type="submit"  class="btnclass" value="Export">
            </div>  
			<div class="clearFix"></div>
			<div class="twelve padd0 columns" id="success1"></div>			
          
        </div>	
</form>		
        <div class="clearFix"></div>
		<div id="display"></div>
        
    </div>   
    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

<script>
function validation(){
	var client = $("#client").val();
	var sessionstartdate = '<?php  if(isset($_SESSION['startbonusyear'])){echo $_SESSION['startbonusyear'];};?>';
	var sessionenddate = '<?php  if(isset($_SESSION['endbonusyear'])){echo $_SESSION['endbonusyear'];};?>';
	if(sessionstartdate =="" || sessionenddate==""){		
		$("#display").html('<div class="error31">Please select bonus Year</div>');
		return false;
	}
	if(client ==""){
		$("#nerror").show();
		$("#nerror").text("Please select client");
		return false;
	}else{
		$("#nerror").hide();
	}
	$("#success1").html('<div class="success31">&nbsp; &nbsp; Report Exporting Successfully!</div>');
}
</script>
</body>

</html>