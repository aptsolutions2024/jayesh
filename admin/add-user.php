<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}

include("../lib/connection/db-config.php");
include("../lib/class/admin-class.php");
$adminObj=new admin();
include_once('../paginate.php');
$result1 = $adminObj->showCompany();
/* pagination starts */
$per_page = 5;         // number of results to show per page
$result = $adminObj->showUser();
$total_results = mysql_num_rows($result);
$total_pages = ceil($total_results / $per_page);//total pages we going to have
$show_page="";
//-------------if page is setcheck------------------//
if($show_page ==""){
    $show_page =1;
}
if (isset($_GET['page'])) {

    $show_page = $_GET['page'];             //it will telles the current page
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



  <title>Salary | Company</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>


    <script>



    function deleterow(id) {
        $.get('delete-user-process.php',{
            'id':id
        },function(data){

            $('#success').hide();
            $('#error').hide();
            $("#success1").html('Recourd Delete Successfully');
            $("#success1").show();
            $("#dispaly").load(document.URL +  ' #dispaly');
        })
    }
    function clear() {
        $('#fnerror').html("");
        $('#mnerror').html("");
        $('#lnerror').html("");
        $('#unerror').html("");
        $('#pwderror').html("");
        $('#terror').html("");
        $('#coerror').html("");
    }
  function update() {
      clear();
      $('#success1').hide();
        var fname=document.getElementById("fname").value;
        var mname=document.getElementById("mname").value;
        var lname=document.getElementById("lname").value;
        var uname=document.getElementById("uname").value;
        var pwd=document.getElementById("password").value;
        var type=document.getElementById("type").value;
        var comp_id=document.getElementById("comp_id").value;

      if(fname==''){
          $('#fnerror').html("Please Enter the First Name");
          $('#fnerror').show();
          document.getElementById("fname").focus();
          $("#success").hide();
      }
      else if(!isNaN(fname))
      {
          $('#fnerror').html("Please Enter the Valid First Name");
          $('#fnerror').show();
          document.getElementById("fname").focus();
          $("#success").hide();
      }
     else if(mname==''){
          $('#mnerror').html("Please Enter the Middle Name");
          $('#mnerror').show();
          document.getElementById("mname").focus();
          $("#success").hide();
      }
      else if(!isNaN(mname))
      {
          $('#mnerror').html("Please Enter the Valid Middle Name");
          $('#mnerror').show();
          document.getElementById("mname").focus();
          $("#success").hide();
      }
      else  if(lname==''){
          $('#lnerror').html("Please Enter the Last Name");
          $('#lnerror').show();
          document.getElementById("lname").focus();
          $("#success").hide();
      }
      else if(!isNaN(lname))
      {
          $('#lnerror').html("Please Enter the Valid Last Name");
          $('#lnerror').show();
          document.getElementById("lname").focus();
          $("#success").hide();
      }else if(type=='0'){
          $('#terror').html("Please Select the type");
          $('#terror').show();
          document.getElementById("type").focus();
          $("#success").hide();
      }
      else if(uname==''){
          $('#unerror').html("Please Enter the User Name");
          $('#unerror').show();
          document.getElementById("uname").focus();
          $("#success").hide();
      } else if(pwd==''){
          $('#pwderror').html("Please Enter the Password");
          $('#pwderror').show();
          document.getElementById("password").focus();
          $("#success").hide();
      }else if(comp_id==''){
          $('#coerror').html("Please Select the Company");
          $('#coerror').show();
          document.getElementById("comp_id").focus();
          $("#success").hide();
      }
      else{
              $.get('add-user-process.php',{
                          'fname':fname,
                          'mname':mname,
                          'lname':lname,
                          'uname':uname,
                          'pwd':pwd,
                  'comp_id':comp_id,
                          'type':type

              },function(data){

                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');


              })

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
        <div class="twelve" id="margin1"><h3>User </h3></div>



        <div class="clearFix"></div>
        <form id="form">


                <div class="twelve padd0 columns successclass hidecontent" id="success">
                    Record Insert Successfully<br/><br/>
     </div>
        <div class="twelve" id="margin1">


            <div class="clearFix"></div>
            <div class="two  padd0 columns">
            <span class="labelclass">First Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="fname" id="fname" placeholder="First Name" class="textclass">
                <span class="errorclass hidecontent" id="fnerror"></span>
            </div>

            <div class="two padd0 columns">
                <span class="labelclass">&nbsp;&nbsp;&nbsp;Middle  Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="mname" id="mname" placeholder="Middle Name" class="textclass">
                <span class="errorclass hidecontent" id="mnerror"></span>
            </div>
            <div class="clearFix"></div>
            <div class="twelve" id="margin1">
            <div class="two padd0 columns">
                <span class="labelclass">Last Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="lname" id="lname" placeholder="Last Name" class="textclass">
                <span class="errorclass hidecontent" id="lnerror"></span>
            </div>

            <div class="two padd0 columns">
                <span class="labelclass">&nbsp;&nbsp;&nbsp;Type:</span>
            </div>
            <div class="four padd0 columns">
                <select id="type" name="type" class="textclass">
                    <option value="0">---Select---</option>
                    <option value="3">User</option>
                    <option value="2">Hr Head</option>
                </select>
                <span class="errorclass hidecontent" id="terror"></span>
            </div>
                </div>
            <div class="clearFix"></div>
            <div class="twelve" id="margin1">
            <div class="two padd0 columns">
                <span class="labelclass">User Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="uname" id="uname" placeholder="User Name" class="textclass">
                <span class="errorclass hidecontent" id="unerror"></span>
            </div>

            <div class="two padd0 columns">
                <span class="labelclass">&nbsp;&nbsp;&nbsp;Password :</span>
            </div>
            <div class="four padd0 columns">
                <input type="password" name="password" id="password" placeholder="Password" class="textclass">
                <span class="errorclass hidecontent" id="pwderror"></span>
            </div>
                </div>
            <div class="clearFix"></div>

            <div class="twelve" id="margin1">
                <div class="two padd0 columns">
                    <span class="labelclass">Compnay :</span>
                </div>
                <div class="four padd0 columns">
                    <select id="comp_id" name="comp_id" class="textclass">
                        <option value="">--select--</option>
                        <?php
                        while ($row4=mysql_fetch_array($result1)){
                            ?>
                            <option value="<?php echo $row4['comp_id'];?>"><?php echo $row4['comp_name'];?></option>
                        <?php }

                        ?>
                    </select>
                    <span class="errorclass hidecontent" id="coerror"></span>
                </div>

                <div class="two padd0 columns">

                </div>
                <div class="four padd0 columns">

                </div>
            </div>
            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
              <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="update();">

            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        <div class="twelve" id="margin1">
            <h3>Display User </h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispaly">
            <table width="100%"  >
                    <tr>
                        <th align="left" width="10%">Sr.No</th>
                        <th align="left" width="20%">Name</th>
                        <th align="left" width="20%">Type</th>
                        <th align="left" width="20%">User name</th>
                        <th align="left" width="20%">Password</th>

                        <th align="center" width="10%">Action</th>

                    </tr>

                <?php
                $count=1;
                for ($i = $start; $i < $end; $i++) {
                $cls = $i;
                // make sure that PHP doesn't try to show results that don't exist
                if ($i == $total_results) {
                    $count=1;
                    break;
                }

                ?>

                    <tr>
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?php  echo mysql_result($result, $i, 'lname').' '.mysql_result($result, $i, 'fname').' '.mysql_result($result, $i, 'mname');//echo $row['name'];?></td>
                        <td class="tdata"><?php
                            $typ=mysql_result($result, $i, 'login_type');
                            if($typ=='3'){
                                echo 'User';
                            } else if($typ=='2'){
                                echo 'Hr Head';
                            }
                            else{
                                echo 'Admin';
                            }   ?></td>
                          <td class="tdata"><?php echo mysql_result($result, $i, 'username');?></td>
                        <td class="tdata"><?php echo mysql_result($result, $i, 'userpass'); ?></td>
                        <td class="tdata" align="center">  <a href="edit-user.php?id=<?php  echo mysql_result($result, $i, 'log_id');?>">
                                <img src="../images/edit-icon.png" /></a>
                            <a href="javascrip:void()" onclick="deleterow(<?php echo  mysql_result($result, $i, 'log_id');?>)">
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
<br/>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>