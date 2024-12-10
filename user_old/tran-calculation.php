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
  <title>Salary | Transactions Days</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>

      function calsal(comp_id){
          $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientid= document.getElementById('clientid').value;
		  var wagediff = document.getElementById('wagediff').value;
		  var otdiff = document.getElementById('otdiff').value;
		  var allowdiff = document.getElementById('allowdiff').value;
		  var comp_id = comp_id;
		  if (comp_id ==11)
		  {
		      //Jayesh Enterises
          $.post('/sal_calc_jayesh',{
              'clientid':clientid,
			  'wagediff':wagediff,
			  'otdiff':otdiff,
			  'allowdiff':allowdiff,
			  
          },function(data){

              $("#display").html(data);

          });
		      
		  }
		  else
		  {
		 // var saldate = document.getElementById('saldate').value;
		 alert("****");
          $.post('/sal_calc',{
              'clientid':clientid,
			  'wagediff':wagediff,
			  'otdiff':otdiff,
			  'allowdiff':allowdiff,
			  
          },function(data){

              $("#display").html(data);

          });
      }

      }	  
	  
	  
	  
$(document).on('change','#clientid',function(){ 
			
			var clientid = this.value;
			
            $.post('/arrear_rate', {
                'clientid': clientid
				
            }, function (data) {
			var str_array = data.split(',');
           document.getElementById('wagediff').value = str_array[0];
				document.getElementById('allowdiff').value =str_array[1];
				document.getElementById('otdiff').value = str_array[2];
				});


//		$.ajax({
	//   type: "POST",
	//   data: {clientid:clientid},
	//   url: "arrear_rate.php",
	//   success: function(msg){
	//	   alert ("222";
	//	  $("#wagediff").value = msg;
	//   }
	//});
	});
	



	  
	  
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
        <div class="twelve padd0" id="margin1"> <h3>Transactions Calculation</h3></div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
            <div class="one padd0 columns"  id="margin1">
                <span class="labelclass">Client :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="clientid" name="clientid" class="textclass" >
                    <option value="0">--select--</option>
                    <?php
                    while($row1=$result1->fetch_assoc()){
                        ?>

                        <option value="<?php echo $row1['mast_client_id'];?>"><?php echo $row1['client_name'];?></option>
                    <?php }

                    ?>
                </select>
            </div>
			
			
            <div class="two  padd0 columns" id="margin1" align="center">
                <button class="btnclass" onclick="calsal(<?=$comp_id?>)">
                    Calculation

                </button>
            </div>
            <div class="clearFix">&nbsp;</div>
			<!-- <div class="five  padd0 columns" id="margin1" align="center">-->

			
			
			
		<div class="twelve padd0" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass1 pdl10p"> Wage Diff:</span>
				</div>
				<div class="one padd0 columns">
				<span ><input type="text" value="" name="wagediff" class="textclass" id="wagediff"><div id="errinv" class="errorclass hidecontent"></div></span>
				</div>
            </div>
			 
			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Ot Diff:</span>
				</div>
				<div class="two padd0 columns">
				<span ><input type="text" name="Otdiff" id="otdiff" class="textclass"><div id="errinvdt"class="errorclass hidecontent"></div></span>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			
			<div class="twelve padd0" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass1 pdl10p"> 
					Allow Diff :</span>
				</div>
				<div class="one padd0 columns">
				<input type="text" name="allowdiff" id="allowdiff" class="textclass" ><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<!--			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p">  For Month :</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="saldate" id="saldate" class="textclass" value="4.75"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>-->
			
			
            
			
			<!--</div> -->





        </div>


                <div class="clearFix"></div>








    <div class="twelve" id="display">


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