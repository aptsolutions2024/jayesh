<?php
session_start();
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
include("../lib/class/advance.php");
$userObj=new user();
$advance =new advance();
$id=$_POST['id'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$rowsemp=$userObj->showEployeedetails($id,$comp_id,$user_id);
$rowsincome=$userObj->showEployeeincome($id,$comp_id,$user_id);
$rowsdeduct=$userObj->showEployeededuct($id,$comp_id,$user_id);
$rowsleave=$userObj->showEployeeleave($id ,$comp_id,$user_id);
$rowsadnavcen=$userObj->showEployeeadnavcen($id,$comp_id,$user_id);
$result1 = $userObj->showClient1($comp_id,$user_id);
$result2 = $userObj->showDesignation($comp_id);
$result3 = $userObj->showDepartment($comp_id);
$result4 = $userObj->showQualification($comp_id);
$result5 = $userObj->showBank($comp_id);

$result6 = $userObj->showLocation($comp_id);
$result7= $userObj->showPayscalecode($comp_id);
$resultIncome = $userObj->showIncomehead($comp_id);
$resultdest = $userObj->showDeductionhead($comp_id);
$advancetype = $advance->getAdvanceType($comp_id);
?>

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script type="text/javascript" src="../js/jquery-ui.js"></script>

<script>
    $( document ).ready(function() {

    $('#tab1').show();
	
	$( "#date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
		
		$( ".advdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
    });

    function displayDataDeduct(){
        var destid=document.getElementById('destid').value;
        var clientid=document.getElementById('clientid').value;
        if(destid=='0'){
            alert('Select The Deduction');
        }
        else{
            $.post('/display_emp_deduct_data',{
                'destid':destid,
                'clientid':clientid
            },function(data){
                $('#showdeductdata').html(data);
            });

        }
    }
    function displayDataIncome(){
        var incomeid=document.getElementById('incomeid').value;
        var clientid=document.getElementById('clientid').value;
        if(incomeid=='0'){
            alert('Select The Income');
        } else{
            $.post('/display_emp_income_data',{
                'incomeid':incomeid,
                'clientid':clientid
            },function(data){

                $('#showincomedata').html(data);
            });

        }
    }

    function displayData(){
        var cid=document.getElementById('clientid').value;
        var checkboxes = document.getElementsByName('check[]');
        var vals = "";
        var j=0;
        var fielda ="";
        var fieldb ="";
        var fieldc ="";
        var fieldd ="";
        for (var i=0, n=checkboxes.length;i<n;i++)
        {
            if (checkboxes[i].checked)
            {
                vals += ","+checkboxes[i].value;

                if(j==0){
                    fielda=checkboxes[i].value;
                }else if(j==1){
                    fieldb=checkboxes[i].value;
                }else if(j==2){
                    fieldc=checkboxes[i].value;
                }else if(j==3){
                    fieldd=checkboxes[i].value;
                }
                j++;
            }
        }



       if(j==4){
            $.post('/display_emp_data',{
                'cid':cid,
                'fielda':fielda,
                'fieldb':fieldb,
                'fieldc':fieldc,
                'fieldd':fieldd
            },function(data){

                $('#showdata').html(data);
            });


        }else{

            alert("Minimum 4 fields are Checked");
        }


    }
function displayAdvance(){
        var advid=document.getElementById('advid').value;
        var clientid=document.getElementById('clientid').value;
		 var date=document.getElementById('date').value;
		
        if(advid=='0'){
            alert('Select The Advance');
			return false;
        }
		
            $.post('/display_emp_advance_data',{
                'advid':advid,
                'clientid':clientid,
				'date':date
            },function(data){
                $('#showadvancedata').html(data);
            });

        
    }
	function displayOtherData(){
		var otherid = document.getElementById('otherid').value;
		var clientid=document.getElementById('clientid').value;
		if(otherid=='0'){
            alert('Select The Other Fields');
			return false;
        }else{
		 $.post('/display_other_fields_data',{
                'otherid':otherid,
				'clientid':clientid
            },function(data){
                //alert(data);
                $('#showotherdata').html(data);
            });
		}
	}
		
		$('#advance').on('submit',function(){   
	var advid = $("#advid").val();  
	var date = $("#date").val(); 
	$("#advtype").val(advid);
	$("#advdate").val(date);
	

        var form = $(this);
        $.ajax({
            type:'post',
            url:'/display_emp_advance_data_process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
                //alert(result);
                console.log(result);
			   $("#succsmg").show();
            }
        });
		})
	
    </script>



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">



        <div class="twelve" id="margin1">
            <div class="tab">
                <button id="t1" class="tablinks active" onclick="openTab(event, 'tab1')">View Employee</button>
                <button id="t2" class="tablinks" onclick="openTab(event, 'tab2')" >Employee Income</button>
                <button id="t3" class="tablinks" onclick="openTab(event, 'tab3')">Employee Deduct</button>
				<button id="t4" class="tablinks" onclick="openTab(event, 'tab4')">Advance</button>
				<button id="t5" class="tablinks" onclick="openTab(event, 'tab5')">Other Fields</button>

            </div>

            <div id="tab1" class="tabcontent ">
                <form method="post"  action="/update_all_emp_process"  name="inempfr">
                <h3>View Employee</h3>
                <div style="min-height:200px;max-height:200px; padding-left: 10px; border: 1px solid gray; padding-bottom: 20px; overflow-y: scroll;">
                    <div class="studentreport" >


                        <?php
						
                        $result = $userObj->selectempstrdet();

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = $result->fetch_assoc()) {

                                if ($row['Field'] != 'emp_id' && $row['Field'] != 'db_update' && $row['Field'] != 'db_adddate' && $row['Field'] !='client_id' && $row['Field'] !='desg_id' && $row['Field'] !='dept_id' && $row['Field'] !='qualif_id' && $row['Field'] !='bank_id' && $row['Field'] !='loc_id' && $row['Field'] !='paycode_id' && $row['Field'] !='comp_id'&& $row['Field'] !='user_id') {
                                    ?>
                                    <div class="three padd0 columns">
                                        <input type="checkbox" id="grno" name="check[]"
                                               value="<?php echo $row['Field']; ?>" class="boxcheck valign "> <span
                                                class="test-upper"><?php echo $row['Field']; ?></span>
                                    </div>

                                <?php }
                            }
                        }
                      ?>


                    </div>
                </div>
                <div>
                      <input type="button" onclick="displayData();" value="show" class="btnclass" id="margin1">
                 </div>

                <div id="showdata" style="height: 100%;background: #fff;">

                </div>


                </form>
            </div>
        </div>

            <div id="tab2" class="tabcontent">
                <h3>Income</h3>
                <div>
                    <form method="post"  action="/update_all_emp_income_process"  name="empfr">
                           <div id="margin1">
                               <div class="two columns">
                                   <span class="labelclass">Income :</span>
                               </div>
                               <div class="four  columns">
                                   <select id="incomeid" name="incomeid" class="textclass">
                                       <option value="0">--select-</option>
                                       <?php
                                       while ($rowin=$resultIncome->fetch_assoc()){
                                           ?>

                                           <option value="<?php echo $rowin['mast_income_heads_id'];?>"><?php echo $rowin['income_heads_name'];?></option>
                                       <?php }

                                       ?>
                                   </select>
                               </div>


                               <div class="two columns">

                                       <input type="button" onclick="displayDataIncome();" value="show" class="btnclass" >

                               </div>
                               <div class="four  columns">


                               </div>
                               <div class="clearFix"></div>


                            <div id="showincomedata">

                            </div>
						</div>
					</form>
				</div>
			</div>


            <div id="tab3" class="tabcontent">
                <h3>Deduct</h3>
                <div>


                        <form method="post"  action="/update_all_emp_deduct_process"  name="empfr">
                            <div id="margin1">
                                <div class="two columns">
                                    <span class="labelclass">Deduction :</span>
                                </div>
                                <div class="four  columns">
                                    <select id="destid" name="destid" class="textclass">
                                        <option value="0">--select-</option>
                                        <?php
                                        while ($rowde=$resultdest->fetch_assoc()){
                                            ?>

                                            <option value="<?php echo $rowde['mast_deduct_heads_id'];?>" ><?php echo $rowde['deduct_heads_name'];?></option>
                                        <?php }

                                        ?>
                                    </select>
                                </div>


                                <div class="two columns">

                                    <input type="button" onclick="displayDataDeduct();" value="show" class="btnclass" >

                                </div>
                                <div class="four  columns">


                                </div>
                                <div class="clearFix"></div>


                                <div id="showdeductdata">

                                </div>
                            </div>
                        </form>
                </div>
            </div>
			<!---- tab 4----->
			<div id="tab4" class="tabcontent">
                <h3>Advance</h3>
                <div>


                        
                            <div id="margin4">
                                <div class="two columns">
                                    <span class="labelclass">Advance :</span>
                                </div>
                                <div class="four  columns">
                                    <select id="advid" name="advid" class="textclass">
                                        <option value="0">--select-</option>
                                        <?php
										foreach($advancetype as $advance){
                                        //while ($rowde=mysql_fetch_array($resultdest)){
                                            ?>

                                            <option value="<?php echo $advance['mast_advance_type_id'];?>" ><?php echo $advance['advance_type_name'];?></option>
                                        <?php }

                                        ?>
                                    </select>
                                </div>

								<div class="four  columns"><input type="text" name="date" id="date" placeholder="Date" class="textclass">

                                </div>
                                <div class="two columns">

                                    <input type="button" onclick="displayAdvance();" value="show" class="btnclass" >

                                </div>
                                
                                <div class="clearFix"></div>


                                <div id="showadvancedata">

                                </div>
                            </div>
                       
                </div>
            </div>
			<!----- tab 4 end -----> 
			<!----- tab 5 start ----------->
			<div id="tab5" class="tabcontent">
			
			<?php $getallid = array(
			array('desg_id','mast_desg','Designation','mast_desg_id','mast_desg_name'),
			array('dept_id','mast_dept','Department','mast_dept_id','mast_dept_name'),
			array('qualif_id','mast_qualif','Qalification','mast_qualif_id','mast_qualif_name'),
			array('bank_id','mast_bank','Bank','mast_bank_id','bank_name|add1'),
			array('loc_id','mast_location','Location','mast_location_id','mast_location_name'),
			array('paycode_id','mast_paycode','Paycode','mast_paycode_id','mast_paycode_name'));
			//print_r($getallid);
			?>
                <h3>Other Fields</h3>
                <div>
                    <form method="post"  action="/update_all_emp_other_field_process" name="empfr" id="otherfieldsdata">
                           <div id="margin1">
                               <div class="two columns">
                                   <span class="labelclass">Other Fields :</span>
                               </div>
                               <div class="four  columns">
                                   <select id="otherid" name="otherid" class="textclass">
                                       <option value="0">--select-</option>
                                       <?php
                                       //while ($rowin=mysql_fetch_array($getallid)){
										   foreach($getallid as $rowin){
                                           ?>

                                           <option value="<?php echo $rowin[0]."#".$rowin[1]."#".$rowin[3]."#".$rowin[4];?>"><?php echo $rowin[2];?></option>
                                       <?php }

                                       ?>
                                   </select>
                               </div>


                               <div class="two columns">

                                       <input type="button" onclick="displayOtherData();" value="show" class="btnclass" >

                               </div>
                               <div class="four  columns">


                               </div>
                               <div class="clearFix"></div>


                            <div id="showotherdata">

                            </div>
						</div>
					</form>
				</div>
			</div>
			<!----- tab 5 end ------------->




        </div>


    </div>
<br/>

<div class="clearFix"></div>

<!--Slider part ends here-->
