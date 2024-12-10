<?php
$client = $_POST['client'];
$leavetype = $_POST['leavetype'];

include("../lib/class/leave.php");
$leave=new leave();
$row = $leave->getOpeningTypeDate($client,$leavetype);
?>
 <div class="four padd0 columns"  >
	
		<div class="five  columns " >
			<span class="labelclass1"> &nbsp; From Date</span>
		</div>
		<div class="seven columns">
			<input type="text" name="frdt" id="frdt" class="textclass" value="">
			<span class="errorclass hidecontent" id="frdterror"></span>
		</div> 
</div>
 <div class="four padd0 columns"  >
 <div class="five  columns pdl10p" id = "prv_to" >
			<span> To Date</span>
		</div>
		<div class="seven columns" >
			<input type="text" name="todt" id="todt" class="textclass" >
			<span class="errorclass hidecontent" id="todterror"></span>
		</div>
		
</div>