<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$id = $_POST['id'];

include_once($_SERVER['DOCUMENT_ROOT']."/lib/connection/db-config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/class/user-class.php");
$userObj=new user();
$row = $userObj->displayClient($id);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $userObj->showClient1($comp_id,$user_id);
//print_r($row);

?>
   <!--<link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>-->
    <script>
      $( function() {
           /* $( "#ecm" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });*/
        } );
        
        function update() {
        //$('#esuccess1').hide();
        var name=document.getElementById("ecname").value;
        var add1=document.getElementById("eadd1").value;
        var esicode=document.getElementById("eesicode").value;
        var pfcode=document.getElementById("epfcode").value;
        var tanno=document.getElementById("etanno").value;
        var panno1=document.getElementById("epanno").value;
        var gstno=document.getElementById("egstno").value;
        var cid=document.getElementById("cid").value;
        var cm=document.getElementById("ecm").value;
        var parent=document.getElementById("eparent").value;
        var sc=document.getElementById("esc").value;
        var email=document.getElementById("eemail").value;
        var rule = /^[a-zA-Z]*$/;

     if(name==''){
          $('#eerror').html("Please Enter the Client Name");
          $('#eerror').show();
          document.getElementById("ecname").focus();
          $("#esuccess").hide();
      }
      else if(!isNaN(name))
      {
          $('#eerror').html("Please Enter the Valid Client Name");
          $('#eerror').show();
          document.getElementById("ecname").focus();
          $("#esuccess").hide();
      }
      else if(add1=='') {
          $('#eerror').html("Please Enter the address 1");
          $('#eerror').show();
          document.getElementById("eadd1").focus();
          $("#esuccess").hide();
      }

      else if(esicode=='') {
          $('#eerror').html("Please Enter the ESI Code");
          $('#eerror').show();
          document.getElementById("esicode").focus();
          $("#esuccess").hide();
      }
      else if(pfcode=='') {
          $('#eerror').html("Please Enter the PF Code");
          $('#eerror').show();
          document.getElementById("epfcode").focus();
          $("#esuccess").hide();
      }
      else if(tanno=='') {
          $('#eerror').html("Please Enter the TAN No");
          $('#eerror').show();
          document.getElementById("etanno").focus();
          $("#esuccess").hide();

      }
      else if(panno1=='') {
          $('#eerror').html("Please Enter the PAN No");
          $('#eerror').show();
          document.getElementById("epanno").focus();
          $("#esuccess").hide();
      }
      else if(gstno=='') {
          $('#eerror').html("Please Enter the GST No");
          $('#eerror').show();
          document.getElementById("egstno").focus();
          $("#esuccess").hide();
      }
      else if(cm=='') {
          $('#ecmerror').html("Please Select Current Month");
          $('#ecmerror').show();
          document.getElementById("ecm").focus();
          $("#esuccess").hide();
      }
      else {

              $.post('/edit_mast_client_process',{
                  'name':name,
                  'cid':cid,
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
                  $('#eerror').hide();
                  $("#esuccess").html('Record Updated Successfully');
                  $("#esuccess").show();
                  $("#dispaly").load(document.URL +  ' #dispaly');
              });

      }

  }
        </script>
<div class="clearFix"></div>
<div class="twelve padd0 columns successclass hidecontent" id="esuccess"></div>
        <form method="post"  id="editform">
        <div class="twelve" id="margin1">
            


            

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="cname" id="ecname" placeholder="Client Name" class="textclass"  value="<?php echo $row['client_name'];?>" onkeyup="serachcli(this.value);">
               
                   
                    <input type="hidden" id="cid" name="cid" value="<?php echo $id;?>">
                <div id="dispaly">
                </div>
                <span class="errorclass hidecontent" id="ecnerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns">
                <span class="labelclass">Address:</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="eadd1" name="add1"  placeholder="Address"><?php echo $row['client_add1'];?></textarea>
                <span class="errorclass hidecontent" id="ead1error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Parent :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="eparent" name="parent" class="textclass">
                    <option value="0">- Not Applicable -</option>
                    <?php
                    while ($row1=$result1->fetch_assoc()){
                        ?>

                        <option value="<?php echo $row1['mast_client_id'];?>"<?php if($row1['mast_client_id']==$row['parentId']){echo "selected";}?>><?php echo $row1['client_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="epererror"></span>
            </div>
            <div class="two columns">

            </div>

            <div class="one columns" id="margin1">
                <span class="labelclass">  ESI CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="esicode" id="eesicode" placeholder="ESI Code" class="textclass" value="<?php echo $row['esicode'];?>">
                <span class="errorclass hidecontent" id="eesierror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> PFCODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pfcode" id="epfcode" placeholder="PF Code" class="textclass" value="<?php echo $row['pfcode'];?>">
                <span class="errorclass hidecontent" id="epferror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">TAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="tanno" id="etanno" placeholder="TAN No" class="textclass" value="<?php echo $row['tanno'];?>">
                <span class="errorclass hidecontent" id="etanerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="panno" id="epanno" placeholder="PAN No" class="textclass" value="<?php echo $row['panno'];?>">
                <span class="errorclass hidecontent" id="epanerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass"> GST No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="gstno" id="egstno" placeholder="GST No" class="textclass" value="<?php echo $row['gstno'];?>">
                <span class="errorclass hidecontent" id="egsterror"></span>
            </div>

            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Month :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="cm" id="ecm" placeholder="Current Month" class="textclass" value="<?php echo $row['current_month'];?>" readonly>
                <span class="errorclass hidecontent" id="ecmerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">Email Id:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="email" id="eemail" placeholder="Enter the Email Id" class="textclass"  value="<?php echo $row['email'];?>">
            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Charges:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="sc" id="esc" placeholder="Services Charges" class="textclass"  value="<?php echo $row['ser_charges'];?>">

            </div>

            <div class="two padd0 columns" id="margin1">

            </div>
            <div class="five padd0 columns" id="margin1">

            </div>

            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="update();"> <input type="button" name="submit" id="submit" value="Delete" class="btnclass" onclick="deleterow(<?php echo $id;?>);"> <input type="button" name="reset" id="reset" value="Add new / Clear" class="btnclass" onclick="javascript:location.reload();">
            </div> 
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
             
            <div class="clearFix"></div>
            </form>
           