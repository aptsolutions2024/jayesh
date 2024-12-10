<?php
session_start();

if(!isset($_SESSION['log_id']) || $_SESSION['log_id']==''){
    header("location:../index.php");
}

include("../lib/class/admin-class.php");
//include_once('../paginate.php');
$adminObj=new admin();
$showcomp = $adminObj->showCompany();
$showpages =$adminObj->showPages();

$firstpage = $showpages;
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
    <style>
   /* .highlight {
    background-color:#333;
    cursor:pointer;
    }*/
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
        <div class="twelve" id="margin1"><h3 >Add Manues </h3></div>
        <div class="clearFix"></div>
             <div class="twelve padd0 columns successclass hidecontent" id="success">
                    Record Insert Successfully<br/><br/>
			 </div>
			 <div class="six padd0 columns">
				
				 <div class="three padd0 columns"><b>Select Company :</b></div>
				 <div class="nine padd0 columns"><select name="company" id="company"  class="textclass" onchange="getclient(this.value)">
					 <option value="0">Please Select Company</option>
				   <?php while($row=$showcomp->fetch_assoc()){ ?>
					 <option value="<?php echo $row['comp_id']; ?>"><?php echo $row['comp_name']; ?></option>
					 <?php } ?>
					 </select>
					 </div>
			 </div>

 <div class="six padd0 columns" id="userdiv">
        
		</div>
 
			 
    <div class="cf nestable-lists" id="display"></div>    
<form id="savemenu">
    <input type="hidden" id="nestable-output">
    <input type="hidden" id="nestable2-output">
    <a href="javascript:void(0);" onclick="add()"><input type="button" name="submit" value="Submit" class="btnclass"></a>
</form>
<script src="jquery.nestable.js"></script>
<script>
$(document).ready(function()
{
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();

});
function setjson(){
     var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

}
</script>
<script>
    function add() {
    var menues = $('#nestable-output').val();
    var remmenues = $('#nestable2-output').val();
    var company = $('#company').val();
	var user = $('#user').val();
	//alert(user); exit;
    if(company ==0){
        $("#success").html("<div style='color:#f00'>Please select Company</div>");
        return false;
    }
      $.post('add_menu_process.php',{
                  'menues':menues,
                  'remmenues':remmenues,
                  'company': company,
				  'user':user
              },function(data){
                  $('#error').hide();
                 // $("#success").html(data);
                  $("#success").html('Record Insert Successfully<br/><br/>');
                 $("#success").show();
                  //$("#form").trigger('reset');
                 // $("#dispaly").load(document.URL +  ' #dispaly');


              })

     
  }
  function getmenues(){
      var company = $('#company').val();
	  var user = $('#user').val();
      //alert(company);
     $.post('get_menu_process.php',{
              'company': company,
			  'user': user
          },function(data){
             // $('#error').hide();
             $("#display").html(data);
              //$("#success").html('Record Insert Successfully<br/><br/>');
              //$("#success").show();
              //$("#nestable").trigger('reset');
             // $("#dispaly").load(document.URL +  ' #dispaly');
            //document.getElementById('nestable').focus();
            setjson();
          })
  }
  
  function getclient(id){
	  var company = id;
      //alert(company);
     $.post('get_client.php',{
              'company': company
          },function(data){
             // $('#error').hide();
             $("#userdiv").html(data);
              //$("#success").html('Record Insert Successfully<br/><br/>');
              //$("#success").show();
              //$("#nestable").trigger('reset');
             // $("#dispaly").load(document.URL +  ' #dispaly');
            //document.getElementById('nestable').focus();
            setjson();
          })
	  
  }
</script>
        </div>
        
</div>
<br/>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php //include('footer.php');?>

<!--footer end -->

</body>

</html>