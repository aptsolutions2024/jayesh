<?php
session_start();

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//print_r($_SESSION);

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}

include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
//include("../lib/connection/db-config.php");
//include("../lib/class/user-class.php");
$userObj=new user();
//include_once($_SERVER['DOCUMENT_ROOT'].'/paginate.php');
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$result1 = $userObj->showClient1($comp_id,$user_id);
//print_r($result1);
//$gtresult =$result1->fetch_array();
//print_r($gtresult);
/* pagination starts */
$per_page = 10;         // number of results to show per page
$result = $userObj->showClient1($comp_id,$user_id);
//print_r($result);
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



?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Client</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>

<script> 
$( function() {
          /*  $( "#ecm" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });*/
        } );
        </script>
    <script>
        /*$( function() {
            $("#cm").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );*/



    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_client_process', {
                'cid': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                
                $("#esuccess").html('Recourd Delete Successfully');
                $("#success").html('Recourd Delete Successfully');
                $("#esuccess").show();
                //;
                setTimeout(function(){ $("#dispaly").load(document.URL + ' #dispaly') }, 3000);
            });
        }

    }
    function clear() {
        $('#cnerror').html("");
        $('#ad1error').html("");
        $('#pererror').html("");
        $('#esierror').html("");
        $('#pferror').html("");
        $('#tanerror').html("");
        $('#panerror').html("");
        $('#gsterror').html("");
    }
  function save() {
      clear();
      $('#success1').hide();
        var name=document.getElementById("cname").value;
        var add1=document.getElementById("add1").value;
        var esicode=document.getElementById("esicode").value;
        var pfcode=document.getElementById("pfcode").value;
        var tanno=document.getElementById("tanno").value;
        var panno1=document.getElementById("panno").value;
        var gstno=document.getElementById("gstno").value;
        var cm=document.getElementById("cm").value;
        var parent=document.getElementById("parent").value;
        var sc=document.getElementById("sc").value;
        var email=document.getElementById("email").value;

      var rule = /^[a-zA-Z]*$/;

      if(name==''){
          $('#cnerror').html("Please Enter the Client Name");
          $('#cnerror').show();
          document.getElementById("cname").focus();
          $("#success").hide();
      }
      else if(!isNaN(name))
      {
          $('#cnerror').html("Please Enter the Valid Client Name");
          $('#cnerror').show();
          document.getElementById("cname").focus();
          $("#success").hide();
      }
      else if(add1=='') {
          $('#ad1error').html("Please Enter the Address");
          $('#ad1error').show();
          document.getElementById("add1").focus();
          $("#success").hide();
      }
      else if(esicode=='') {
          $('#esierror').html("Please Enter the ESI Code");
          $('#esierror').show();
          document.getElementById("esicode").focus();
          $("#success").hide();
      }
      else if(pfcode=='') {
          $('#pferror').html("Please Enter the PF Code");
          $('#pferror').show();
          document.getElementById("pfcode").focus();
          $("#success").hide();
      }
      else if(tanno=='') {
          $('#tanerror').html("Please Enter the TAN No");
          $('#tanerror').show();
          document.getElementById("tanno").focus();
          $("#success").hide();

      }
      else if(panno1=='') {
          $('#panerror').html("Please Enter the PAN No");
          $('#panerror').show();
          document.getElementById("panno").focus();
          $("#success").hide();
      }
      else if(gstno=='') {
          $('#gsterror').html("Please Enter the GST No");
          $('#gsterror').show();
          document.getElementById("gstno").focus();
          $("#success").hide();
      }
      else if(cm=='') {
          $('#cmerror').html("Please Select Current Month");
          $('#cmerror').show();
          document.getElementById("cm").focus();
          $("#success").hide();
      }
      else {
              $.post('/add_mast_client_process',{
                  'name':name,
                  'add1':add1,
                  'esicode':esicode,
                  'pfcode':pfcode,
                  'tanno':tanno,
                  'panno':panno1,
                  'gstno':gstno,
                  'cm':cm,
                  'sc':sc,
                  'email':email,
                  'parent':parent

              },function(data){

                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');


              });

      }

  }



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
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve editemplo" id="margin1"><h3>Client</h3> <a href="/exportallclient"><input type="button" name="submit"  value="Export" class="btnclass" ></a></div>



        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="cname" id="cname" placeholder="Client Name" class="textclass" onkeyup="serachcli(this.value);">
                <div id="dispaly" class="dispnamedrop"></div>
                <span class="errorclass hidecontent" id="cnerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns">
                <span class="labelclass">Address:</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="add1" name="add1"  placeholder="Address"></textarea>
                <span class="errorclass hidecontent" id="ad1error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Parent :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="parent" name="parent" class="textclass">
                    <option value="0">- Not Applicable -</option>
                    <?php
                    while ($row1=$result1->fetch_assoc()){
                        ?>

                        <option value="<?php echo $row1['mast_client_id'];?>"><?php echo $row1['client_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="pererror"></span>
            </div>
            <div class="two columns">

            </div>

            <div class="one columns" id="margin1">
                <span class="labelclass">  ESI CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="esicode" id="esicode" placeholder="ESI Code" class="textclass">
                <span class="errorclass hidecontent" id="esierror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> PFCODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pfcode" id="pfcode" placeholder="PF Code" class="textclass">
                <span class="errorclass hidecontent" id="pferror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">TAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="tanno" id="tanno" placeholder="TAN No" class="textclass">
                <span class="errorclass hidecontent" id="tanerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="panno" id="panno" placeholder="PAN No" class="textclass">
                <span class="errorclass hidecontent" id="panerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass"> GST No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="gstno" id="gstno" placeholder="GST No" class="textclass">
                <span class="errorclass hidecontent" id="gsterror"></span>
            </div>

            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Month :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="cm" id="cm" placeholder="Current Month" class="textclass" value="<?php echo date("m-d-Y", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "last day of this month" ) )?>" readonly>
                <span class="errorclass hidecontent" id="cmerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">Email Id:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="email" id="email" placeholder="Enter the Email Id" class="textclass">
            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Charges:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="sc" id="sc" placeholder="Services Charges" class="textclass">

            </div>

            <div class="two padd0 columns" id="margin1">

            </div>
            <div class="five padd0 columns" id="margin1">

            </div>

            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="save();">
            </div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
             
            <div class="clearFix"></div>

            </form>
            
        </div>
        <div id="editformdiv"></div>
        

</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script>
     function serachcli(val){
        
        $.post('/search_client', {
            'name': val
        }, function (data) {
            $('#dispaly').html(data);
            //$('#searching').show();
        });
    }
    
    function showTabdata1(id){

       $.post('/display_search_client', {
           'id': id
       }, function (data) {
           $('#dispaly').hide();
           
           $('#form').hide();
           $('#editformdiv').html(data);
           //$('#name').val(name);
           $('#editformdiv').show();
           
           $('.editemplo h3').html("Edit Client");
          // document.getElementById('empid').value=id;
//refreshconutIncome(id);
       });

    }
</script>
<script>
     


    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_mast_client_process', {
                'cid': id
            }, function (data) {
                $('#esuccess').hide();
                $('#eerror').hide();
                $("#esuccess1").html('Recourd Delete Successfully');
                $("#esuccess1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
                setTimeout(function () {
                    window.location.href = "/add_mast_client";
                }, 1000);

            });
        }
    }
  
    </script>

<!--footer end -->

</body>

</html>