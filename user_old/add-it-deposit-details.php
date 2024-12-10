<?php
session_start();
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

/* pagination starts */
$per_page = 10;         // number of results to show per page


$result = $userObj->displayitdeposit($comp_id,$user_id);
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

$result1 = $userObj->displayitdepositWithPage($comp_id,$user_id,$per_page,$show_page);

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | IT Deposit Details</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>


    <script>
        $( function() {
            $("#salmonth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#deposite_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );



    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_it_deposit_details_`process', {
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
        $('#salerror').html("");
        $('#chnoerror').html("");
        $('#dderror').html("");
        $('#oserror').html("");

    }
  function save() {
      clear();
      $('#success1').hide();
        var salmonth=document.getElementById("salmonth").value;
        var chno=document.getElementById("chno").value;
        var deposite_date=document.getElementById("deposite_date").value;
        var status=document.getElementById("status").value;



      if(salmonth==''){
          $('#salerror').html("Please Enter the Sal Month");
          $('#salerror').show();
          document.getElementById("cname").focus();
          $("#success").hide();
      }
     else if(chno=='') {
          $('#chnoerror').html("Please Enter the Challan No");
          $('#chnoerror').show();
          document.getElementById("add1").focus();
          $("#success").hide();
      }
      else if(deposite_date=='') {
          $('#dderror').html("Please Enter the Deposit Date");
          $('#dderror').show();
          document.getElementById("esicode").focus();
          $("#success").hide();
      }
      else if(status=='') {
          $('#oserror').html("Please Enter the Oltas Status");
          $('#oserror').show();
          document.getElementById("pfcode").focus();
          $("#success").hide();
      }
     else {
              $.post('/add-it_deposit_details_process',{
                  'salmonth':salmonth,
                  'chno':chno,
                  'deposite_date':deposite_date,
                  'status':status

              },function(data){

                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');

                  clear();
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
        <div class="twelve" id="margin1"><h3>IT Deposit Details</h3></div>



        <div class="clearFix"></div>
        <form method="post"  id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>

            <div class="clearFix"></div>
            <div class="two padd0 columns">
            <span class="labelclass">Sal Month :</span>
            </div>
            <div class="three padd0 columns">
                <input type="text" name="salmonth" id="salmonth" placeholder="Sal Month" class="textclass">
                <span class="errorclass hidecontent" id="salerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns">
                <span class="labelclass">Challan No :</span>
            </div>
            <div class="three padd0 columns">
                <input type="text" name="chno" id="chno" placeholder="Challan No" class="textclass">
                <span class="errorclass hidecontent" id="chnoerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
                <span class="labelclass">Deposit Date :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="deposite_date" id="deposite_date" placeholder="Deposit Date" class="textclass">
                <span class="errorclass hidecontent" id="dderror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="two columns" id="margin1">
                <span class="labelclass">Oltas Status :</span>
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="text" name="status" id="status" placeholder="Oltas Status" class="textclass">
                <span class="errorclass hidecontent" id="oserror"></span>
            </div>

            <div class="clearFix"></div>

            <div class="two padd0 columns" id="margin1">
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

        <div class="twelve" id="margin1">
            <h3>Display IT Deposit Details</h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispaly">
            <table width="100%"  >
                    <tr>
                        <th align="left" width="10%">Sr.No</th>
                        <th align="left" width="20%">Sal Month</th>
                        <th align="left" width="20%">Challan No</th>
                        <th align="left" width="20%">Deposit Date</th>
                        <th align="left" width="20%">Oltas Status</th>

                        <th align="center" width="10%">Action</th>

                    </tr>

                <?php
                $count=1;
                while($rows = $result1->fetch_assoc()){
               // for ($i = $start; $i < $end; $i++) {
                $cls = $i;
                // make sure that PHP doesn't try to show results that don't exist
                

                ?>

                    <tr>
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?php  echo $rows['sal_month'];?></td>
                        <td class="tdata"><?php echo $rows['challan_no'];?></td>
                          <td class="tdata"><?php echo $rows['deposite_date'];?></td>
                        <td class="tdata"><?php echo $rows['oltas_status']; ?></td>
                        <td class="tdata" align="center">  <a href="/edit_it_deposit_details?id=<?php  echo $rows['id'];?>">
                                <img src="../images/edit-icon.png" /></a>
                            <a href="javascrip:void()" onclick="deleterow(<?php echo $rows['id'];?>)">
                                <img src="../images/delete-icon.png" /></a></td>

                    </tr>
                <?php
                    $count++;
                } ?>
                <?php if($total_results == 0){?>
                <tr align="center">
                    <td colspan="6" class="tdata errorclass">
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


</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>