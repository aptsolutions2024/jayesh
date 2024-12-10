<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/index");
}
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$id=$_POST['id'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result11 = $userObj->displayCompdetails($id,$comp_id,$user_id);

/* pagination starts */
$per_page = 3;         // number of results to show per page
$result = $userObj->showCompdetails($comp_id,$user_id);
$total_results = mysqli_num_rows($result);
$total_pages = ceil($total_results / $per_page);//total pages we going to have
$show_page="";
//-------------if page is setcheck------------------//
if($show_page ==""){
    $show_page =1;
}
if (isset($_POST['page'])) {

    $show_page = $_POST['page'];             //it will telles the current page
    if ($show_page > 0 && $show_page <= $total_pages) {
        $start = ($show_page - 1) * $per_page;
        $end = $start + $per_page;
    } else {
        // error - show first set of results
        $start = 0;
        $end = $per_page;
    }
} else {
    // if page isn't set, show first set of results
    $start = 0;
    $end = $per_page;
}
// display pagination

$tpages=$total_pages;
if (isset($page) && $page <= 0)
    $page = 1;

$result = $userObj->showCompdetailsWithpage($comp_id,$user_id,$per_page,$_POST['page']);

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Company Details</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>


    <script>
        $( function() {
            $("#prdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#fdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#tdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );



    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_comp_details_process', {
                'id': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }

    }
   function clear() {

       $('#fdateerror').html("");
       $('#tdateerror').html("");
       $('#assyrerror').html("");
       $('#tdscerror').html("");
       $('#authperror').html("");
       $('#authderror').html("");
       $('#authmnerror').html("");
       $('#bcrcerror').html("");
       $('#qcn1error').html("");
       $('#qap1error').html("");
       $('#qade1error').html("");
       $('#qadp1error').html("");
       $('#qcn2error').html("");
       $('#qap2error').html("");
       $('#qade2error').html("");
       $('#qadp2error').html("");
       $('#qcn3error').html("");
       $('#qap3error').html("");
       $('#qade3error').html("");
       $('#qadp3error').html("");
       $('#qcn4error').html("");
       $('#qap4error').html("");
       $('#qade4error').html("");
       $('#qadp4error').html("");
       $('#prdateerror').html("");
    }
  function Update(){
      clear();
      $('#success1').hide();



      var fdate=document.getElementById("fdate").value;
      var tdate=document.getElementById("tdate").value;
      var assyr=document.getElementById("assyr").value;
      var tdsc=document.getElementById("tdsc").value;
      var authp=document.getElementById("authp").value;
      var authd=document.getElementById("authd").value;
      var authmn=document.getElementById("authmn").value;
      var bcrc=document.getElementById("bcrc").value;
      var qcn1=document.getElementById("qcn1").value;
      var qap1=document.getElementById("qap1").value;
      var qade1=document.getElementById("qade1").value;
      var qadp1=document.getElementById("qadp1").value;
      var qcn2=document.getElementById("qcn2").value;
      var qap2=document.getElementById("qap2").value;
      var qade2=document.getElementById("qade2").value;
      var qadp2=document.getElementById("qadp2").value;
      var qcn3=document.getElementById("qcn3").value;
      var qap3=document.getElementById("qap3").value;
      var qade3=document.getElementById("qade3").value;
      var qadp3=document.getElementById("qadp3").value;
      var qcn4=document.getElementById("qcn4").value;
      var qap4=document.getElementById("qap4").value;
      var qade4=document.getElementById("qade4").value;
      var qadp4=document.getElementById("qadp4").value;
      var prdate=document.getElementById("prdate").value;
      var id=document.getElementById("id").value;

         if(fdate==''){
              $('#fdateerror').html("Please Enter the Form Date");
              $('#fdateerror').show();
              document.getElementById("fdate").focus();
              $("#success").hide();
          }else if(tdate==''){
              $('#tdateerror').html("Please Enter the To Date");
              $('#tdateerror').show();
              document.getElementById("tdate").focus();
              $("#success").hide();
          }else if(assyr==''){
              $('#assyrerror').html("Please Enter the Assessment Year");
              $('#assyrerror').show();
              document.getElementById("assyr").focus();
              $("#success").hide();
          }
		  
//		  else if(tdsc==''){
//              $('#tdscerror').html("Please Enter the TDS Circle ");
//              $('#tdscerror').show();
//              document.getElementById("tdsc").focus();
//              $("#success").hide();
//          }else if(authp==''){
///              $('#authperror').html("Please Enter the Authorised Person :");
//              $('#authperror').show();
//              document.getElementById("authp").focus();
//              $("#success").hide();
//          }else if(authd==''){
//              $('#authderror').html("Please Enter the Authorised Designation");
//              $('#authderror').show();
//              document.getElementById("authd").focus();
//              $("#success").hide();
//          }else if(authmn==''){
//              $('#authmnerror').html("Please Enter the Auth.Middle Name");
//              $('#authmnerror').show();
//              document.getElementById("authmn").focus();
//              $("#success").hide();
//          }else if(bcrc==''){
//              $('#bcrcerror').html("Please Enter the BCR Code");
//              $('#bcrcerror').show();
//              document.getElementById("bcrc").focus();
//              $("#success").hide();
//          }else if(qcn1==''){
//              $('#qcn1error').html("Please Enter the Q1 Challan No");
//              $('#qcn1error').show();
//              document.getElementById("qcn1").focus();
//              $("#success").hide();
//          }else if(qap1==''){
//              $('#qap1error').html("Please Enter the Q1 Amount Paid ");
//              $('#qap1error').show();
//              document.getElementById("qap1").focus();
//              $("#success").hide();
//          }else if(qade1==''){
//              $('#qade1error').html("Please Enter the Q1 Amount Deducted");
//              $('#qade1error').show();
//              document.getElementById("qade1").focus();
//              $("#success").hide();
//          }else if(qadp1==''){
//              $('#qadp1error').html("Please Enter the Q1 Amount Deposited");
//              $('#qadp1error').show();
//              document.getElementById("qadp1").focus();
//              $("#success").hide();
//          }else if(qcn2==''){
//              $('#qcn2error').html("Please Enter the Q2 Challan No");
//              $('#qcn4error').show();
//              document.getElementById("qcn2").focus();
//              $("#success").hide();
//          }else if(qap2==''){
//              $('#qap2error').html("Please Enter the Q2 Amount Paid ");
//              $('#qap2error').show();
//              document.getElementById("qap2").focus();
//              $("#success").hide();
//          }else if(qade2==''){
//              $('#qade2error').html("Please Enter the Q2 Amount Deducted");
//              $('#qade2error').show();
//              document.getElementById("qade2").focus();
//              $("#success").hide();
//          }else if(qadp2==''){
//              $('#qadp2error').html("Please Enter the Q4 Amount Deposited");
//              $('#qadp2error').show();
//              document.getElementById("qadp2").focus();
//              $("#success").hide();
//          }else if(qcn3==''){
//              $('#qcn3error').html("Please Enter the Q3 Challan No");
//              $('#qcn3error').show();
//              document.getElementById("qcn3").focus();
//              $("#success").hide();
//          }else if(qap3==''){
//              $('#qap3error').html("Please Enter the Q3 Amount Paid ");
//              $('#qap3error').show();
//              document.getElementById("qap3").focus();
//              $("#success").hide();
//          }else if(qade3==''){
//              $('#qade3error').html("Please Enter the Q3 Amount Deducted");
//              $('#qade3error').show();
//              document.getElementById("qade3").focus();
//              $("#success").hide();
//          }else if(qadp3==''){
//              $('#qadp3error').html("Please Enter the Q3 Amount Deposited");
//              $('#qadp3error').show();
//              document.getElementById("qadp3").focus();
//              $("#success").hide();
//          }else if(qcn4==''){
//              $('#qcn4error').html("Please Enter the Q4 Challan No");
//              $('#qcn4error').show();
//              document.getElementById("qcn4").focus();
//              $("#success").hide();
//          }else if(qap4==''){
//              $('#qap4error').html("Please Enter the Q4 Amount Paid ");
//              $('#qap4error').show();
//              document.getElementById("qap4").focus();
//              $("#success").hide();
////          }else if(qade4==''){
//              $('#qade4error').html("Please Enter the Q4 Amount Deducted");
//              $('#qade4error').show();
//              document.getElementById("qade4").focus();
//              $("#success").hide();
//          }else if(qadp4==''){
//              $('#qadp4error').html("Please Enter the Q4 Amount Deposited");
//              $('#qadp4error').show();
//              document.getElementById("qadp4").focus();
//              $("#success").hide();
//          }
//          else if(prdate==''){
//              $('#prdateerror').html("Please Enter the Printing Date ");
//              $('#prdateerror').show();
//              document.getElementById("prdate").focus();
//              $("#success").hide();
//          }
 else {
              $.post('/update_comp_details_process',{
                  'id':id,
                  'fdate':fdate,
                  'tdate':tdate,
                  'assyr':assyr,
                  'tdsc':tdsc,
                  'authp':authp,
                  'authd':authd,
                  'authmn':authmn,
                  'bcrc':bcrc,
                  'qcn1':qcn1,
                  'qap1':qap1,
                  'qade1':qade1,
                  'qadp1':qadp1,
                  'qcn2':qcn2,
                  'qap2':qap2,
                  'qade2':qade2,
                  'qadp2':qadp2,
                  'qcn3':qcn3,
                  'qap3':qap3,
                  'qade3':qade3,
                  'qadp3':qadp3,
                  'qcn4':qcn4,
                  'qap4':qap4,
                  'qade4':qade4,
                  'qadp4':qadp4,
                  'prdate':prdate
              },function(data){
                  clear();

                  $("#success").html(data);
                 if(data<=0){
                   $("#success").html('Record Already exits<br/>');
                    $("#success").show();
                }
                else{
                   $("#success").html('Record Updated Successfully<br/>');
                     $("#success").show();
                     $("#dispaly").load(document.URL + ' #dispaly');
                }

              });

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
        <div class="twelve" id="margin1"><h3>Edit Company Details</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>


            <div class="clearFix"></div>
<input type="hidden" id="id" value="<?php echo $result11['id'];?>">
            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Form Date :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="fdate" id="fdate" placeholder="Form Date" class="textclass" value="<?php echo date("d-m-Y", strtotime($result11['from_date']));?>">
                <span class="errorclass hidecontent" id="fdateerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">To Date :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="tdate" id="tdate" placeholder="To Date" class="textclass" value="<?php echo date("d-m-Y", strtotime($result11['to_date']));?>">
                <span class="errorclass hidecontent" id="tdateerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Assessment Year :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="assyr" id="assyr" placeholder="Assessment Year" class="textclass" value="<?php echo $result11['Assment_year'];?>">
                <span class="errorclass hidecontent" id="assyrerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">TDS Circle :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="tdsc" id="tdsc" placeholder="TDS Circle" class="textclass" value="<?php echo $result11['tds_circle'];?>">
                <span class="errorclass hidecontent" id="tdscerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Authorised Person :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="authp" id="authp" placeholder="Authorised Person" class="textclass" value="<?php echo $result11['auth_person'];?>">
                <span class="errorclass hidecontent" id="authperror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Authorised Designation :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="authd" id="authd" placeholder="Authorised Designation" class="textclass" value="<?php echo $result11['auth_desg'];?>">
                <span class="errorclass hidecontent" id="authderror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Auth.Middle Name :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="authmn" id="authmn" placeholder="Auth.Middle Name " class="textclass" value="<?php echo $result11['auth_mname'];?>">
                <span class="errorclass hidecontent" id="authmnerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">BCR Code :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="bcrc" id="bcrc" placeholder="BCR Code" class="textclass" value="<?php echo $result11['bsrcode'];?>">
                <span class="errorclass hidecontent" id="bcrcerror"></span>
            </div>
            <div class="clearFix"></div>


            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q1 Challan No:</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qcn1" id="qcn1" placeholder="Q1 Challan No" class="textclass" value="<?php echo $result11['Q1_challan'];?>">
                <span class="errorclass hidecontent" id="qcn1error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q1 Amount Paid :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qap1" id="qap1" placeholder="Q1 Amount Paid" class="textclass" value="<?php echo $result11['Q1_amt_paid'];?>">
                <span class="errorclass hidecontent" id="qap1error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q1 Amount Deducted :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qade1" id="qade1" placeholder="Q1 Amount Deducted" class="textclass" value="<?php echo $result11['Q1_amt_deducted'];?>">
                <span class="errorclass hidecontent" id="qade1error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q1 Amount Deposited :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qadp1" id="qadp1" placeholder="Q1 Amount Deposited" class="textclass" value="<?php echo $result11['Q1_amt_deposited'];?>">
                <span class="errorclass hidecontent" id="qadp1error"></span>
            </div>
            <div class="clearFix"></div>


            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q2 Challan No:</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qcn2" id="qcn2" placeholder="Q2 Challan No" class="textclass" value="<?php echo $result11['Q2_challan'];?>">
                <span class="errorclass hidecontent" id="pferror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q2 Amount Paid :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qap2" id="qap2" placeholder="Q2 Amount Paid" class="textclass"  value="<?php echo $result11['Q2_amt_paid'];?>">
                <span class="errorclass hidecontent" id="qap2error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q2 Amount Deducted :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qade2" id="qade2" placeholder="Q2 Amount Deducted" class="textclass" value="<?php echo $result11['Q2_amt_deducted'];?>">
                <span class="errorclass hidecontent" id="qade2error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q2 Amount Deposited :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qadp2" id="qadp2" placeholder="Q2 Amount Deposited" class="textclass" value="<?php echo $result11['Q2_amt_deposited'];?>">
                <span class="errorclass hidecontent" id="qadp2error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q3 Challan No:</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qcn3" id="qcn3" placeholder="Q3 Challan No" class="textclass" value="<?php echo $result11['Q3_challan'];?>">
                <span class="errorclass hidecontent" id="qcn3error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q3 Amount Paid :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qap3" id="qap3" placeholder="Q3 Amount Paid" class="textclass" value="<?php echo $result11['Q3_amt_paid'];?>">
                <span class="errorclass hidecontent" id="qap3error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q3 Amount Deducted :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qade3" id="qade3" placeholder="Q3 Amount Deducted" class="textclass"  value="<?php echo $result11['Q3_amt_deducted'];?>">
                <span class="errorclass hidecontent" id="qade3error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q3 Amount Deposited :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qadp3" id="qadp3" placeholder="Q3 Amount Deposited" class="textclass" value="<?php echo $result11['Q3_amt_deposited'];?>">
                <span class="errorclass hidecontent" id="qadp3error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q4 Challan No:</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qcn4" id="qcn4" placeholder="Q4 Challan No" class="textclass" value="<?php echo $result11['Q4_challan'];?>">
                <span class="errorclass hidecontent" id="qcn4error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q4 Amount Paid :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qap4" id="qap4" placeholder="Q4 Amount Paid" class="textclass" value="<?php echo $result11['Q4_amt_paid'];?>">
                <span class="errorclass hidecontent" id="qap4error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Q4 Amount Deducted :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qade4" id="qade4" placeholder="Q4 Amount Deducted" class="textclass" value="<?php echo $result11['Q4_amt_deducted'];?>">
                <span class="errorclass hidecontent" id="qade4error"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Q4 Amount Deposited :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="qadp4" id="qadp4" placeholder="Q4 Amount Deposited" class="textclass" value="<?php echo $result11['Q4_amt_deposited'];?>">
                <span class="errorclass hidecontent" id="qadp4error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass"> Printing Date :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="prdate" id="prdate" placeholder="Printing Date" class="textclass"  value="<?php echo date("d-m-Y", strtotime($result11['Printed_on']));?>">
                <span class="errorclass hidecontent" id="prdateerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">

            </div>
            <div class="three padd0 columns" id="margin1">

            </div>
            <div class="clearFix"></div>


            <div class="two padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="Update();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        <div class="twelve" id="margin1">
            <h3>Display Company Details</h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispaly">
            <table width="100%"  >
                    <tr>
                        <th align="left" width="10%">Sr.No</th>
                        <th align="left" width="10%">Form Date</th>
                        <th align="left" width="10%">To Date</th>
                        <th align="left" width="10%">Assessment Year </th>
                        <th align="left" width="10%">TDS Circle</th>
                        <th align="left" width="10%">Authorised Person</th>
                        <th align="left" width="10%">Authorised Designation </th>
                        <th align="left" width="10%">Auth.Middle Name </th>
                        <th align="left" width="10%">BCR Code </th>

                        <th align="center" width="10%">Action</th>

                    </tr>

                <?php
                $count=1;
                //for ($i = $start; $i < $end; $i++) {
                 while($rows = $result->fetch_assoc()){
                $cls = $i;
                // make sure that PHP doesn't try to show results that don't exist
                if ($i == $total_results) {
                    $count=1;
                    break;
                }
                ?>
                    <tr>
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?php  echo $rows['from_date']; // mysqli_result($result, $i, 'from_date');?></td>
                        <td class="tdata"><?php echo $rows['to_date'];//mysqli_result($result, $i, 'to_date');?></td>
                          <td class="tdata"><?php echo $rows['Assment_year']; //mysql_result($result, $i, 'Assment_year'); ?></td>
                        <td class="tdata"><?php echo $rows['tds_circle']; // mysql_result($result, $i, 'tds_circle'); ?></td>
                        <td class="tdata"><?php echo $rows['auth_person']; // mysql_result($result, $i, 'auth_person'); ?></td>
                        <td class="tdata"><?php echo $rows['auth_desg'];// mysql_result($result, $i, 'auth_desg');?></td>
                          <td class="tdata"><?php echo $rows['auth_mname']; // mysql_result($result, $i, 'auth_mname'); ?></td>
                        <td class="tdata"><?php echo $rows['bsrcode']; // mysql_result($result, $i, 'bsrcode'); ?></td>
                        <td class="tdata" align="center">  <a href="/edit_comp_details?id=<?php  echo $rows['id']; //echo mysql_result($result, $i, 'id');?>">
                                <img src="../images/edit-icon.png" /></a>
                            <a href="javascrip:void()" onclick="deleterow(<?php echo $rows['id']; //echo  mysql_result($result, $i, 'id');?>)">
                                <img src="../images/delete-icon.png" /></a></td>

                    </tr>
                <?php
                    $count++;
                } ?>
                <?php if($total_results == 0){?>
                <tr align="center">
                    <td colspan="10" class="tdata errorclass">
                        <span class="norec">No Record found</span>
                    </td>
                <tr>
                    <?php }?>
            </table>
                <div class="pagination" align="right">
                    <?php
                    $reload=$page."?pages=". $tpages;
                    if ($total_pages > 1) {
                        echo paginate($reload, $show_page, $total_pages);
                    }?>
                </div>
            </div>







</div>


</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>