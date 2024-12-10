<?php
session_start();

if(!isset($_SESSION['log_id']) || $_SESSION['log_id']==''){
    header("location:../index.php");
}

include("../lib/class/admin-class.php");
include_once('../paginate.php');
$adminObj=new admin();
$showcomp = $adminObj->showCompany();
$showpages =$adminObj->showPages();

/* pagination starts */
$per_page = 10;         // number of results to show per page
$result = $showpages;
$total_results = mysqli_num_rows($result);
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
        <div class="twelve" id="margin1"><h3 id="pgtit">Add Page </h3></div>



        <div class="clearFix"></div>
        <form id="form">


                <div class="twelve padd0 columns successclass hidecontent" id="success">
                    Record Insert Successfully<br/><br/>
     </div>
        <div class="twelve" id="margin1">


            <div class="clearFix"></div>
             <div class="two padd0 columns">
                <span class="labelclass">Company :</span>
            </div>
            <div class="four padd0 columns">
                <select class="textclass" name="company" id="company">
                    <option value="">Please select company</option>
                    <?php while($row = $showcomp->fetch_assoc()){?>
                    <option value="<?php echo $row['comp_id'];?>"><?php echo $row['comp_name'];?></option>
                    <?php }?>
                </select>
                <span class="errorclass hidecontent" id="companyerror"></span>
            </div>
           
            <div class="two  padd0 columns">
            <span class="labelclass">&nbsp;&nbsp;&nbsp;Page Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="page_name" id="page_name" placeholder="Page Name" class="textclass">
                <span class="errorclass hidecontent" id="page_nameerror"></span>
            </div>
            <div class="clearFix">&nbsp;</div>
            <div class="two padd0 columns">
                <span class="labelclass">Title :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="title" id="title" placeholder="Page Title" class="textclass">
                <span class="errorclass hidecontent" id="nameerror"></span>
            </div>
            <div class="clearFix"></div>
            
           

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
              <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="add();">

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
                        <th align="left" width="20%">Page name</th>
                        <th align="left" width="20%">Company</th>

                        <th align="center" width="10%">Action</th>

                    </tr>
 <?php
                $count=1;
                //for ($i = $start; $i < $end; $i++) {
                $pagewpagination = $adminObj->showPagesdetailsWithpage($per_page,$show_page);
                while($row = $pagewpagination->fetch_assoc()){
               // $cls = $i;
                // make sure that PHP doesn't try to show results that don't exist
               /* if ($i == $total_results) {
                    $count=1;
                    break;
                }*/

                ?>

                    <tr>
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?php  echo $row['title'];?></td>
                        <td class="tdata">
                           <?php echo $row['page_name'];?></td>
                          <td class="tdata"><?php  echo $row['comp_id'];?></td>
                        
                        <td class="tdata" align="center">  <a href="javascript:void(0);" onclick="disaplayedit(<?php echo $row['pages_id'];?>)">
                                <img src="../images/edit-icon.png" /></a>
                            <a href="javascrip:void(0);" onclick="deleterow(<?php echo $row['pages_id'];?>)">
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
<script>
    function clear(){
        $('#companyerror').html("");
        $('#page_nameerror').html("");
        $('#nameerror').html("");
    }
    function add() {
      clear();
      $('#success1').hide();
        var company=document.getElementById("company").value;
        var page_name=document.getElementById("page_name").value;
        var title=document.getElementById("title").value;
      if(company==''){
          $('#companyerror').html("Please Enter the company");
          $('#companyerror').show();
          document.getElementById("company").focus();
          $("#success").hide();
      }
     /*else if(page_name==''){
          $('#page_nameerror').html("Please Enter the Page Name");
          $('#page_nameerror').show();
          document.getElementById("page_name").focus();
          $("#success").hide();
      }*/
      else if(title =='')
      {
          $('#nameerror').html("Please Enter the Title");
          $('#nameerror').show();
          document.getElementById("name").focus();
          $("#success").hide();
      }
      else{
              $.post('add-page-process.php',{
                          'company':company,
                          'pagename':page_name,
                          'title':title

              },function(data){
                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');


              })

      }

  }
  function disaplayedit(id){
      $.post('edit_pages.php',{
          'id':id
      },function(data){
          $("#form").html(data);
          $("#pgtit").text("Edit Page");
          
      })
  }
      
  
  function edit() {
      clear();
      $('#success1').hide();
        var company=document.getElementById("company").value;
        var page_name=document.getElementById("page_name").value;
        var title=document.getElementById("title").value;
        var pid=document.getElementById("pid").value;
      if(company==''){
          $('#companyerror').html("Please Enter the company");
          $('#companyerror').show();
          document.getElementById("company").focus();
          $("#success").hide();
      }
    /* else if(page_name==''){
          $('#page_nameerror').html("Please Enter the Page Name");
          $('#page_nameerror').show();
          document.getElementById("page_name").focus();
          $("#success").hide();
      }*/
      else if(title =='')
      {
          $('#nameerror').html("Please Enter the Title");
          $('#nameerror').show();
          document.getElementById("name").focus();
          $("#success").hide();
      }
      else{
          $.post('edit_page_process.php',{
              'company':company,
              'pagename':page_name,
              'title':title,
              'id':pid
          },function(data){
              $('#error').hide();
              $("#success").html('Record Update Successfully<br/><br/>');
              $("#success").show();
              $("#form").trigger('reset');
              $("#dispaly").load(document.URL +  ' #dispaly');
          })
      }
  }
  function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Record?')) {
            $.get('delete-page-process.php', {
                'id': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Record Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }

    }
</script>

<!--footer end -->

</body>

</html>