<?phpsession_start();if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){    header("location:../index.php");}include("../lib/connection/db-config.php");include("../lib/class/user-class.php");$userObj=new user();$comp_id=$_SESSION['comp_id'];$user_id=$_SESSION['log_id'];$result1 = $userObj->showClient1($comp_id,$user_id);$_SESSION['month']='current';$leavetypes = $userObj->showLeavetype($comp_id);?><!DOCTYPE html><head>  <meta charset="utf-8"/>  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width"/>  <title>Leave | Reports</title>  <!-- Included CSS Files -->  <link rel="stylesheet" href="../css/responsive.css">  <link rel="stylesheet" href="../css/style.css">    <link rel="stylesheet" href="../css/jquery-ui.css">    <script type="text/javascript" src="../js/jquery.min.js"></script>    <script type="text/javascript" src="../js/jquery-ui.js"></script>		 <body><!--Header starts here--><?php include('header.php');?><!--Header end here--><div class="clearFix"></div><!--Menu starts here--><?php include('menu.php');?><!--Menu ends here--><div class="clearFix"></div><!--Slider part starts here--><div class="twelve mobicenter innerbg">    <div class="row">        <div class="twelve" id="margin1"> <h3>Opening balance</h3></div>        <div class="clearFix"></div>        <div class="twelve" id="margin1">                        <div class="six padd0 columns"  >			<div class="three   columns"  >                <span class="labelclass1">Client :</span>            </div>			<div class="eight padd0  columns" >                <select class="textclass" name="client" id="client" onclick="changeclient()">                    <option value="">--Select--</option>                    <?php while($row1=mysql_fetch_array($result1)){?>                        <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>                    <?php } ?>                </select>                <span class="errorclass hidecontent" id="clinterror"></span>			</div>			<div class="one padd0 columns" ></div>            </div>            <div class="six padd0 columns"  >				<div class="three  columns "  >										<input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked id="all">All                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" id="Random">Random				</div>				<div class="nine padd0  columns"  >					 <div id="showemp" class="hidecontent">                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">                    </div>                    <input type="hidden" name="empid" id="empid" value="">					<span class="errorclass hidecontent" id="empiderror"></span>					</div>				</div>				<div class="one padd0  columns"  >				</div>			</div>			<div class="clearFix">&nbsp;</div>			<div class="four padd0 columns">					<div class="five  columns " >                        <span class="labelclass1">Leave Type </span>                    </div>					<div class="seven columns" >                      <select name="leavetype" class="textclass" id="leavetype">					  						<option value=""> -- select type --</option>						<?php while($ltyp = mysql_fetch_array($leavetypes)){?>						<option value="<?php echo $ltyp['mast_leave_type_id'];?>"> <?php echo $ltyp['leave_type_name'];?></option>						<?php }?>					  </select>					  <span class="errorclass hidecontent" id="leavetypeerror"></span>                    </div>								</div>           <div class="four padd0 columns"  >                                    <div class="five  columns " >                        <span class="labelclass1"> &nbsp; From Date</span>                    </div>                    <div class="seven columns">                        <input type="text" name="frdt" id="frdt" class="textclass" value="01-01-2017">                        <span class="errorclass hidecontent" id="frdterror"></span>                    </div>             </div>			 <div class="four padd0 columns"  >			 <div class="five  columns pdl10p">                        <span> To Date</span>                    </div>                    <div class="seven columns" >                        <input type="text" name="todt" id="todt" class="textclass" value="31-12-2017">                        <span class="errorclass hidecontent" id="todterror"></span>                    </div>								</div>			<div class="clearFix"></div>						<div class="four padd0 columns"  >			 <div class="five  columns " >                        <span> Calculation from (Presentee Basis) </span>                    </div>                    <div class="seven columns" >                        <input type="text" name="calculationfrm" id="calculationfrm" class="textclass" value="01-01-2017">                        <span class="errorclass hidecontent" id="calculationfrmerror"></span>                    </div>								</div>			<div class="four padd0 columns"  >			 <div class="five  columns pdl10p"  >                        <span> Calculation To</span>                    </div>                    <div class="seven columns" >                        <input type="text" name="calculationto" id="calculationto" class="textclass" value="31-12-2017">                        <span class="errorclass hidecontent" id="calculationtoerror"></span>                    </div>								</div>			 <div class="four padd0 columns"  >			 <div class="five   columns pdl10p" >                        <span> One levae Per Present Days</span>                    </div>                    <div class="seven  columns" >                        <input type="text" name="presentday" id="presentday" class="textclass" >                        <span class="errorclass hidecontent" id="presentdayerror"></span>                    </div>			</div>						<div class="clearFix"></div>			<div class="four padd0 columns" >				 <div class="five columns "><span class="labelclass1">Carry For. From </span>				</div>				<div class="seven columns" >				   <input type="text" name="carfrfrm" class="textclass " id="carfrfrm">					<span class="errorclass hidecontent" id="carfrfrmerror"></span>				</div>							 </div>			 <div class="four padd0 columns" >				 <div class="five pdl10p columns " ><span class="labelclass1">Carry For. To </span>				</div>				<div class="seven columns" >				   <input type="text" name="carfrto" class="textclass " id="carfrto">					<span class="errorclass hidecontent" id="carfrtoerror"></span>				</div>							 </div>			 			  <div class="four padd0 columns" align="right">			  <div class="twelve  columns ">			  <button  class="btnclass" onclick="showList1();">Show</button>			  </div>				  				  			 </div>						<div class="clearFix"></div>			        </div>		<div class="clearFix">&nbsp;</div>		<div id="showlist" class="hidecontent">		<div class="twelve">		<div class="four padd0 columns" >				 <div class="five  columns " ><span class="labelclass1">Granted </span>				</div>				<div class="four columns" >				   <input type="text" name="granteddefault" class="textclass " id="granteddefault">					<span class="errorclass hidecontent" id="grantederror"></span>				</div>				<div class="three columns" align="right">				  <input type="button" value="Default" name="Granted" class="btnclass" onclick="defaultGranted();">				</div>							 </div>			 <div class="four padd0 columns" >				 <div class="five pdl10p columns "  ><span class="labelclass1">Calculated </span>				</div>				<div class="four columns" >				   <input type="text" name="calcutodefault" class="textclass " id="calcutodefault">				</div>				<div class="three columns" align="right">				  <input type="button" value="Default" name="calculatedefault" class="btnclass" onclick="defaultCalculated();">				</div>							 </div>			 <div class="four padd0 columns" >				 <div class="five pdl10p columns " ><span class="labelclass1">Carry For. To </span>				</div>				<div class="four columns" >				   <input type="text" name="carfrtodefault" class="textclass " id="carfrtodefault">									</div>				<div class="three columns" align="right"><input type="button" value="Default" name="Granted" class="btnclass"onclick="defaultarryfordto();"></div>							 </div>		</div>		<div class="clearFix">&nbsp;</div>		<div class="rows" >		 <h3>Display Employee</h3>		 </div>		 <hr>		 <div id="displaydetails"></div>		</div>       <div class="clearFix">&nbsp;</div>         <div class="clearFix"></div>		<div id="contenlist234"></div>            <div class="clearFix"></div>            <br/>        </div>    </div>    </div></div><!--Slider part ends here--><div class="clearFix"></div><div id="test"></div><!--footer start --><?php include('footer.php');?><!--footer end -->    <script>        $( function() {            $("#frdt").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });            $("#todt").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#calculationfrm").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#calculationto").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#carfrfrm").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#carfrto").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			        } );</script>		<script>     function changeemp(val){		 var client = $("#client").val();		 if(val=='random'){            						//$("#printManual").hide();			if(client==""){				$("#clinterror").show();				$("#clinterror").text("Please Select Client");				$("#all").prop("checked", true);				return false;			}else{				$("#clinterror").hide();			}				$("#showemp").show();			//$("#manualchequeprint").hide();			$("#subbtn").show();			        }		        else if(val=='all')        {$("#showemp").hide();				//$("#manualchequeprint").hide(); 			$("#subbtn").show();			//$("#printManual").hide();			$("#empid").val('');        }    }	function serachemp(val){		var clientid = $("#client").val();		        $.get('/display_employee2', {            'name': val,			'clientid':clientid        }, function (data) {            $('#searching').html(data);            $('#searching').show();			        });    }	function showTabdata(id,name){        $.get('/display_employee', {            'id': id        }, function (data) {            $('#searching').hide();            $('#displaydata').html(data);            $('#name').val(name);            $('#displaydata').show();            document.getElementById('empid').value=id;						//getEmp(id);        });    }	function clearError(){		 $("#clinterror").text('');		//$('input:radio[name=emp]:checked').val();		 $("#leavetypeerror").text('');		 $("#frdterror").text('');		 $("#todterror").text('');		 $("#calculationfrmerror").text('');		 $("#calculationtoerror").text('');		 $("#presentdayerror").text('');		 $("#carfrfrmerror").text('');		 $("#carfrtoerror").text('');	}	function showList1(){		clearError();		 var client = $("#client").val();		 var emp = $('input:radio[name=emp]:checked').val();		 var empid = $("#empid").val();		 var leavetype = $("#leavetype").val();		 var frdt = $("#frdt").val();		 var todt = $("#todt").val();		 var calculationfrm = $("#calculationfrm").val();		 var calculationto = $("#calculationto").val();		 var presentday = $("#presentday").val();		 var carfrfrm = $("#carfrfrm").val();		 var carfrto = $("#carfrto").val();		 var name = $("#name").val();		 //alert(empid1);		 if(calculationfrm =="" && calculationto ==""){			$("#presentday").val('');			 		 }		 if(client ==""){			 $("#clinterror").show();			 $("#clinterror").text("Please select Client");			 return false;		 }else if(emp =="random" && name ==""){			 $("#empiderror").show();			 $("#empiderror").text("Please select employee");			  return false;		 }else if(leavetype ==""){			 $("#leavetypeerror").show();			 $("#leavetypeerror").text("Please select leave type");			  return false;		 }else if(frdt ==""){			 $("#frdterror").show();			 $("#frdterror").text("Please select from date");			  return false;		 }else if(todt ==""){			 $("#todterror").show();			 $("#todterror").text("Please select To date");			  return false;		 }else if((calculationfrm =="" && calculationto !="") || (calculationfrm !="" && calculationto =="")){			 			 $("#calculationfrmerror").show();			 $("#calculationfrmerror").text("Please select Calculation dates");			  return false;		 }else if((carfrfrm !="" && carfrto =="") || (carfrfrm =="" && carfrto !="")){			 $("#carfrfrmerror").show();			 $("#carfrfrmerror").text("Please select Carry forward dates");			  return false;		 }/*else if(calculationfrm ==""){			 $("#calculationfrmerror").show();			 $("#calculationfrmerror").text("Please select Calculation from date");			  return false;		 }else if(calculationto ==""){			 $("#calculationtoerror").show();			 $("#calculationtoerror").text("Please select Calculation To date");			  return false;		 }else if(presentday ==""){			 $("#presentdayerror").show();			 $("#presentdayerror").text("Please enter calculation day");			  return false;		 }else if(carfrfrm ==""){			 $("#carfrfrmerror").show();			 $("#carfrfrmerror").text("Please select Carry For. From date");		 }else if(carfrto ==""){			 $("#carfrtoerror").show();			 $("#carfrtoerror").text("Please select Carry For. To date");		 }*/else{						 $.get('/opening_balancelist', {			 'client': client,			 'emp':emp,             'empid':empid,			 'leavetype':leavetype,			 'frdt':frdt,			 'todt':todt,			 'calculationfrm':calculationfrm,			 'calculationto':calculationto,			 'presentday':presentday,			 'carfrfrm':carfrfrm,			 'carfrto':carfrto		}, function (data) {				$("#showlist").show();				   $("#displaydetails").html(data);		   		});		 }	 }	 function defaultGranted(){		 var granted1 = $("#granteddefault").val();		 			 var granted = $("input[name='granted[]']");			//var calculated = $("input[name='calculated[]']");				//var carriedforword = $("input[name='carriedforword[]']");						var ob =0;			var sr =1;			for (var i = 0; i <granted.length; i++) {				ob =0;			var inp=granted[i];				if(inp.value ==0){					inp.value=granted1;				}				//ob = parseFloat(calculated[i].value)+parseFloat(carriedforword[i].value)+parseFloat(inp.value);					//$("#ob"+i).text(ob);					calculateob(sr);				sr++;							}			//obcalCal();			 }		 function defaultCalculated(){		 var granted1 = $("#calcutodefault").val();		 			 var granted = $("input[name='calculated[]']");				 var sr =1;			for (var i = 0; i <granted.length; i++) {			var inp=granted[i];				if(inp.value ==0){					inp.value=granted1;				}			//inp.value+ParseFloat()+ParseFloat()			calculateob(sr);				sr++;					}	 }	 function defaultarryfordto(){		 var granted1 = $("#carfrtodefault").val();		 			var granted = $("input[name='carriedforword[]']");				var sr =1;			 			for (var i = 0; i <granted.length; i++) {			var inp=granted[i];				if(inp.value ==0){					inp.value=granted1;				}			calculateob(sr);				sr++;						}	 }	 	 function checkAll(val){		 if(document.getElementById('allcheck').checked){						 $(".selectchk" ).prop( "checked", true );		 }else{			 $(".selectchk" ).prop( "checked", false );		 }			 }	function changeclient(){		$("#name").val('');		$("#empid").val('');			}	function calculateob(id){ //alert(id);		var grand = $("#grnd"+id).val();		var calculv = $("#calculv"+id).val();		var carfrd = $("#carfrd"+id).val();		var ob = parseFloat(grand)+parseFloat(calculv)+parseFloat(carfrd);		$("#ob"+id).text(ob);		$("#obin"+id).val(ob);			}</script></body></html>