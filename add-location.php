
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Company</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="css/responsive.css">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>


    <script>



    </script>
    <style>
    .highlight {
    background-color:#333;
    cursor:pointer;
    }
    </style>
</head>
 <body>

<!--Header starts here-->

<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>

<header class="twelve header_bg">

    <div class="row" >

        <div class="twelve padd0 columns" >

            <div class="eight padd0 columns mobicenter text-left " id="container1">

                

            </div>









            <div class="four padd0 columns text-right text-center" id="container3">

                <!-- Modify top header3  Navigation start here -->


                <div class="mobicenter text-right" id="margin3" >
                    <br/>
                  <a class="btn" href="../logout.php">Logout</a>
                    <br/><br/>
                </div>



                <!-- Modify top header3 Navigation start here -->

            </div>




        </div>

</header>


<!--Header end here-->

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"><h3>Location Details</h3></div>



        <div class="twelve" id="margin1">


           
            <div class="two padd0 columns" id="margin1">
            <span class="labelclass">Location :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" placeholder="Enter Location" name="location[]" id="location" class="textclass">
            </div>
            <div class="two padd0 columns" id="margin1">
			<a href="javascript:void(0);" ><img  src="images/add-icon.png" class="mrgntop2" style="margin-left: 10px;"></a> &nbsp;	<a href="javascript:void(0);" ><img  src="images/remove-icon.png" class="mrgntop2" style="margin-left: 10px;"></a>
			</div>
			
			<div class="clearFix"></div>
			<div id="addFeatures"></div>
			<div class="clearFix"></div>
			
            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Department :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
               <input type="text" placeholder="Enter Department" name="department[]" id="department" class="textclass">
            </div>
		<div class="two padd0 columns" id="margin1">
			<a href="javascript:void(0);" ><img  src="images/add-icon.png" class="mrgntop2" style="margin-left: 10px;"></a> &nbsp;	<a href="javascript:void(0);" ><img  src="images/remove-icon.png" class="mrgntop2" style="margin-left: 10px;"></a>
			</div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Employee Name  :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
              <input type="text" placeholder="Enter Employee Name" name="empname[]" id="empname" class="textclass">
            </div>
           <div class="two padd0 columns" id="margin1">
			<a href="javascript:void(0);" ><img  src="images/add-icon.png" class="mrgntop2" style="margin-left: 10px;"></a> &nbsp;	<a href="javascript:void(0);" ><img  src="images/remove-icon.png" class="mrgntop2" style="margin-left: 10px;"></a>
			</div>
			
			 <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Description  :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
              <input type="text" placeholder="Enter Description" name="description" id="description" class="textclass">
            </div>
            <div class="two padd0 columns"></div>
			 <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Date of Issue  :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
              <input type="date" placeholder="Enter Date of Issue" name="issuedate" id="issuedate" class="textclass">
            </div>
            <div class="two padd0 columns"></div>
            <div class="clearFix"></div>
            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Tentative closing date  :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
              <input type="date" placeholder="Enter Date of Issue" name="issuedate" id="issuedate" class="textclass">
            </div>
            <div class="two padd0 columns"></div>
			
            <div class="clearFix"></div>
            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Closing date  :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
              <input type="date" placeholder="Enter closing date" name="issuedate" id="issuedate" class="textclass">
            </div>
            <div class="two padd0 columns"></div>
			
			
			
            <div class="clearFix"></div>





             <div class="two padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Save" class="btnclass" >&nbsp;&nbsp;<input type="submit" name="submit" id="submit" value="Clear" class="btnclass" >&nbsp;&nbsp;<input type="submit" name="submit" id="submit" value="Reports" class="btnclass" >
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
       
 
        


</div>
<br/>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('admin/footer.php');?>

<script>
var rowCount1 = 1;
 function addfeatures(frm) {

        rowCount1 ++;
		var recRow = '<div class="clearFix"></div><span id="rowCount'+rowCount1+'">' +
		    '<div class="two padd0 columns" id="margin1">'+
            '<span class="labelclass">Location :</span>'+
           ' </div>'+
            '<div class="four padd0 columns" id="margin1">'+
			'<input type="text" placeholder="Enter Location" name="location[]" id="location'+rowCount1+'" class="textclass">'+
            '</div>'+
            '<div class="two padd0 columns" id="margin1">'+
			'<a href="javascript:void(0);" onclick="removeRow('+rowCount1+');" ><img  src="images/remove-icon.png" class="mrgntop2" style="margin-left: 12px;"></a>'+
			'</div>';
			'<div class="clearFix"></div>';
		
        jQuery('#addFeatures').append(recRow);

}

function removeRow(removeNum) {
	 jQuery('#rowCount'+removeNum).remove();
	 //alert(rowCount1);
	 rowCount1 --;
    }
	
</script>

<!--footer end -->

</body>

</html>