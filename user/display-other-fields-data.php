<?php
//print_r($_REQUEST);exit;
$getiddata = explode('#',$_POST['otherid']);
include("../lib/class/common.php");
$common = new common;
$prid = $getiddata[0];
$table = $getiddata[1];
$tableprid = $getiddata[2];
 $namefld = $getiddata[3];
if($table =="mast_bank"){
	$expfld = explode('|',$namefld);	
	$selname = $table.".".$expfld[0].",".$table.".".$expfld[1];
}else{
	 $selname = $table.".".$namefld;
}


$cl_id = $_POST['clientid'];
?>
<?php
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
session_start();
$userObj=new user();


$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
/*$alldept = $userObj->showDepartment($comp_id);
$alldept = $userObj->showDesignation($comp_id);
$allqua = $userObj->showQualification($comp_id);
$allbank = $userObj->showBank($comp_id);
*/
?>

<input type="hidden" name="fielda" value="<?php if($fielda!=''){echo $fielda;}?>">
<?php
   /*$sql = "SELECT emp_id,first_name as fn,middle_name as mn,last_name as ln,".$selname.",".$prid." FROM employee e inner join $table on
e.".$prid."=".$table.".".$tableprid."
   where client_id='".$comp_id."' AND job_status!='L' order by emp_id"; 
   //echo $sql;
  $res = mysql_query($sql);*/
  
  $res = $common->displayOtherFieldsData($selname,$table,$prid,$tableprid,$cl_id,$comp_id,$user_id);
  $tcount = $common->displayOtherFieldsDataCount($selname,$table,$prid,$tableprid,$cl_id,$comp_id,$user_id);
  //echo $tcount=mysqli_num_rows($res);
  
$i=1;
while($row = $res->fetch()){
    //print_r($row);
?>
<input type="hidden" name="empid[]" value="<?php echo $row['emp_id'];?>">
<div class="twelve bgColor2">
        <div class="one columns "><span><?php echo $i;?></span></div>
        <div class="three columns"><span> <?php echo $row['ln']." ".$row['fn']." ".$row['mn'];?></span></div>
		<?php if($table !="mast_bank"){?>
		<div class="eight columns">
		<select name="<?php echo $table;?>[]" class="textclass">
		<option value=""> Please select <?php echo $namefld;?></option>
		<?php
		$res1 = $userObj->gettabdataOther($table,$comp_id,$user_id);
		
		while($row1 = $res1->fetch_assoc()){
		?>

		<option value="<?php echo $row1[$tableprid]; ?>" <?php if( $row[$prid]==$row1[$tableprid]){echo "selected";} ?>><?php echo $row1[$namefld]; ?></option>
		
	
		<?php }?>
		</select>
		</div>
		<?php }else{?>
		<div class="four columns">
		<select name="<?php echo $table;?>[]" class="textclass">
		<option value=""> Please select <?php echo $expfld[0];?></option>
		<?php		
		 
		$res12 = $userObj->gettabdataOther($table,$comp_id,$user_id);
		while($row12 = $res12->fetch_assoc()){
			
		?>
		<option value="<?php echo $row12[$tableprid]; ?>" <?php if($row[$prid]==$row12[$tableprid]){echo "selected";}?>><?php echo $row12['ifsc_code']." - ".$row12[$expfld[0]]." - ".$row12['branch']?></option>
		<?php }?>
		</select>
		
		
		</div>
		<div class="four columns">
		<input type="text" name="bank_no[]" id="bank_no" class="textclass" placeholder="Please Enter Bank Account Number." value="<?=$row['bankacno']?>">
		</div>
		<?php  } ?>
        
        <div class="clearFix"></div>
	</div>

	<div class="clearfix"></div>
	
<?php

    $i++; }
//if(mysqli_num_rows($res)==0) {
 if($tcount==0) {
?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if($tcount!=0) {
   
    ?>
    <div class="twelve " style="background-color: #fff;">
        <br/>
      &nbsp; &nbsp; <input type="button" value="Update" name="submit"  class="btnclass"  onclick="saveotherdetails()">
	  <div id="showdata"></div>
    </div>

<?php } ?>
</div>

<script>
function saveotherdetails(){
 /*   var otherid = $("#otherid").val();
    alert(otherid);
    */
    
    //$( document ).ready(function() {
    //$('#otherfieldsdata').on('submit',function(){   
//	var advid = $("#advid").val();  
//	var date = $("#date").val(); 
//	$("#advtype").val(advid);
//	$("#advdate").val(date);
	

        var form = $('#otherfieldsdata');
        $.ajax({
            type:'post',
            url:'/display_emp_other_data_process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
                alert("Records Updated Successfuly!");
                 $("#showdata").html(result);
                console.log(result);
			  
			   $("#succsmg").show();
            }
        });
    /*$.post('display-emp-advance-data.php',{
                'advid':advid,
                'clientid':clientid,
				'date':date
            },function(data){
                $('#showadvancedata').html(data);
            });*/

//});
//});
}
</script>