<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $userObj->showClient1($comp_id,$user_id);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Transactions </title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function clientno(val){
            var clientid= document.getElementById('client').value;
            if (clientid=="")
            {
                alert ("Please Select Client.");

            }
            else {
                $.post('/sessionclientno', {
                    'clientid': clientid
                }, function (data) {

                    alert(data);

                });
            }
        }

       function validation() {
            var errormsg ='';
            var file = document.getElementById('file').value;
            if(file ==""){
                error ="Please Select the file";
                $("#errormsg").text(error);
                $("#errormsg").show();
                return false;
            }
        }
		function emptranexport(){
			
			var clientid= document.getElementById('client').value;
			if (clientid=="")
				{alert ("Please Select Client.");
					return;
				}
						$.post('/export_emp_transactions',{
              'clientid':clientid
          },function(data){

             alert(data);
$("#a").html(data);
          });
		}
		
		
		function trandaysexport(){
			
			var clientid= document.getElementById('client').value;
			if (clientid=="")
				{alert ("Please Select Client.");
					return;
				}

		}
    </script>
</head>
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
        <div class="twelve padd0" id="margin1"> <h3>Days Details Export And Import</h3></div>
        <div class="clearFix"></div>
        <br/>
        <form method="post"  name="frm" action="/import_transactions_days_process"   enctype="multipart/form-data" onsubmit="return validation();">
        <div class="twelve " >
            <div class="one padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
            <div class="four padd0 columns"  >
                <select class="textclass" name="client" id="client" onchange="clientno(this.value);">
                    <option value=''>--Select--</option>
                    <?php while($row1=$result1->fetch_assoc()){?>
                        <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
</div>

 <div class="twelve columns" >
            <div class="seven padd0 columns">
                <!--                <a class="switch" href="../transactions.csv" download>Transactions Export to Blank CSV File </a><br/>-->
                <!--<a class="switch" href="export-emp-transactions.php">Export Data / Blank Excel Format for importing days details </a>-->
                <a class="switch"  href="/export_emp_day_transactions">1. Generate Blank file from Employee Master </a>
				
            </div>
            <div class="five columns">
<div id='a'></div>

            </div>

        </div>
       
			

 

<div  class = "twelve columns">
		    <div class="two padd0 columns"  >
             2. Import from CSV File :
            </div>
            <div class="three padd0 columns">
                <input type="file" name="file" id="file" class="textclass">
                <br/>
                <span class="errorclass hidecontent" id="errormsg"></span>
            </div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve " id="margin1">


                <input type="submit" name="submit" id="submit" value="Import" class="btnclass" >

            </div>
            <div class="clearFix"></div>

        </form>
        <div class="clearFix"></div>

        <br/>
  <!--     <div class="twelve " >
            <div class="seven padd0 columns">
             <a class="switch" onclick="emptranexport();" href="javascript:void();">Export Data / Blank Excel Format for importing days details </a>
				
            </div>
            <div class="five columns">
<div id='a'></div>

            </div>

        </div>
   -->
   <div class="clearFix"></div>




    </div>


</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>