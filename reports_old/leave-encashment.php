<?phpsession_start();if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){    header("location:../index.php");}include("../lib/connection/db-config.php");include("../lib/class/user-class.php");$userObj=new user();$comp_id=$_SESSION['comp_id'];$user_id=$_SESSION['log_id'];$result1 = $userObj->showClient1($comp_id,$user_id);$_SESSION['month']='current';$leavetypes = $userObj->showLeavetype($comp_id);?><!DOCTYPE html><head>  <meta charset="utf-8"/>  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width"/>  <title>Leave | Encashment</title>  <!-- Included CSS Files -->  <link rel="stylesheet" href="../css/responsive.css">  <link rel="stylesheet" href="../css/style.css">    <link rel="stylesheet" href="../css/jquery-ui.css">    <script type="text/javascript" src="../js/jquery.min.js"></script>    <script type="text/javascript" src="../js/jquery-ui.js"></script>		 <body><!--Header starts here--><?php include('header.php');?><!--Header end here--><div class="clearFix"></div><!--Menu starts here--><?php include('menu.php');?><!--Menu ends here--><div class="clearFix"></div><!--Slider part starts here--><div class="twelve mobicenter innerbg">    <div class="row">        <div class="twelve" id="margin1"> <h3>Encashment</h3></div>        <div class="clearFix"></div>        <div class="twelve" id="margin1">                        <div class="six padd0 columns"  >			<div class="three   columns"  >                <span class="labelclass1">Client :</span>            </div>			<div class="eight padd0  columns" >                <select class="textclass" name="client" id="client" >                    <option value="">--Select--</option>                    <?php while($row1=mysql_fetch_array($result1)){?>                        <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>                    <?php } ?>                </select>                <span class="errorclass hidecontent" id="clinterror"></span>			</div>			<div class="one padd0 columns" ></div>            </div>            <div class="six padd0 columns"  >				<div class="three  columns "  >										<input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked id="all">All                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" id="Random">Random				</div>				<div class="nine padd0  columns"  >					 <div id="showemp" class="hidecontent">                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">                    </div>                    <input type="hidden" name="empid" id="empid" value="">					</div>				</div>				<div class="one padd0  columns"  >				</div>			</div>			<div class="clearFix">&nbsp;</div>			<div class="four padd0 columns">					<div class="five  columns " >                        <span class="labelclass1">Leave Type </span>                    </div>					<div class="seven columns" >                      <select name="leavetype" class="textclass" id="leavetype" onchange="changeField()">					  						<option value=""> -- select type --</option>						<?php while($ltyp = mysql_fetch_array($leavetypes)){?>						<option value="<?php echo $ltyp['mast_leave_type_id'];?>"> <?php echo $ltyp['leave_type_name'];?></option>						<?php }?>					  </select>					  <span class="errorclass hidecontent" id="leavetypeerror"></span>                    </div>								</div>			<span id="dates">           <div class="four padd0 columns"  >                                    <div class="five  columns " >                        <span class="labelclass1"> &nbsp; From Date</span>                    </div>                    <div class="seven columns">                        <input type="text" name="frdt" id="frdt" class="textclass" value="01-01-2017">                        <span class="errorclass hidecontent" id="frdterror"></span>                    </div>             </div>			 <div class="four padd0 columns"  >			 <div class="five  columns pdl10p" id = "prv_to" >                        <span> To Date</span>                    </div>                    <div class="seven columns" >                        <input type="text" name="todt" id="todt" class="textclass" value="31-12-2017" >                        <span class="errorclass hidecontent" id="todterror"></span>                    </div>								</div>			</span>			<div class="clearFix"></div>						<div class="four padd0 columns"  >			 <div class="five  columns "  id = "prv_to" >                        <span> Calculation From </span>                    </div>                    <div class="seven columns" >                        <input type="text" name="calculationfrm" id="calculationfrm" class="textclass" value="01-01-2017">                        <span class="errorclass hidecontent" id="calculationfrmerror"></span>                    </div>								</div>			<div class="four padd0 columns"  >			 <div class="five  columns pdl10p"  id = "prv_to" >                        <span> Calculation To</span>                    </div>                    <div class="seven columns" >                        <input type="text" name="calculationto" id="calculationto" class="textclass" value="31-12-2017">                        <span class="errorclass hidecontent" id="calculationtoerror"></span>                    </div>								</div>			 <div class="four padd0 columns"  >			 <div class="five   columns pdl10p" id = "prv_to" >                        <span>One levae Per Present Days</span>                    </div>                    <div class="seven  columns" >                        <input type="text" name="presentday" id="presentday" class="textclass" >                        <span class="errorclass hidecontent" id="presentdayerror"></span>                    </div>			</div>						<div class="clearFix"></div>						  <div class="padd0 row" align="right">			  <div class="twelve  columns ">			  <button  class="btnclass" onclick="showList1();">Show</button>			  </div>				  				  			 </div>						<div class="clearFix"></div>			        </div>		<div class="clearFix">&nbsp;</div>		<div id="showlist" class="hidecontent">				<div class="clearFix">&nbsp;</div>		<div class="rows" >		 <h3>Display Employee</h3>		 </div>		 <hr>		 <div id="displaydetails"></div>		</div>       <div class="clearFix">&nbsp;</div>             <div class="clearFix"></div>		<div id="contenlist234"></div>            <div class="clearFix"></div>            <br/>        </div>    </div>    </div></div><!--Slider part ends here--><div class="clearFix"></div><!--footer start --><?php include('footer.php');?><!--footer end -->    <script>        $( function() {            $("#frdt").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });            $("#todt").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#calculationfrm").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });			 $("#calculationto").datepicker({                changeMonth: true,                changeYear: true,                dateFormat:'dd-mm-yy'            });						        } );</script>		<script>     function changeemp(val){		 var client = $("#client").val();		 if(val=='random'){            						//$("#printManual").hide();			if(client==""){				$("#clinterror").show();				$("#clinterror").text("Please Select Client");				$("#all").prop("checked", true);				return false;			}else{				$("#clinterror").hide();			}				$("#showemp").show();			//$("#manualchequeprint").hide();			$("#subbtn").show();			        }		        else if(val=='all')        {$("#showemp").hide();				//$("#manualchequeprint").hide(); 			$("#subbtn").show();			//$("#printManual").hide();			$("#empid").val('');        }    }	function serachemp(val){		var clientid = $("#client").val();		        $.get('display-employee2.php', {            'name': val,			'clientid':clientid        }, function (data) {            $('#searching').html(data);            $('#searching').show();			        });    }	function showTabdata(id,name){        $.get('display-employee.php', {            'id': id        }, function (data) {            $('#searching').hide();            $('#displaydata').html(data);            $('#name').val(name);            $('#displaydata').show();            document.getElementById('empid').value=id;						//getEmp(id);        });    }	function clearError(){		 $("#clinterror").text('');		//$('input:radio[name=emp]:checked').val();		 $("#leavetypeerror").text('');		 $("#frdterror").text('');		 $("#todterror").text('');		 $("#calculationfrmerror").text('');		 $("#calculationtoerror").text('');		 $("#presentdayerror").text('');		 $("#carfrfrmerror").text('');		 $("#carfrtoerror").text('');	}	function showList1(){		clearError();		 var client = $("#client").val();		 var emp = $('input:radio[name=emp]:checked').val();		 var empid = $("#empid").val();		 var leavetype = $("#leavetype").val();		 var frdt = $("#frdt").val();		 var todt = $("#todt").val();		 var calculationfrm = $("#calculationfrm").val();		 var calculationto = $("#calculationto").val();		 var presentday = $("#presentday").val();		 		 //alert(empid1);		 if(client ==""){			 $("#clinterror").show();			 $("#clinterror").text("Please select Client");		 }else if(leavetype ==""){			 $("#leavetypeerror").show();			 $("#leavetypeerror").text("Please select leave type");		 }else if(frdt ==""){			 $("#frdterror").show();			 $("#frdterror").text("Please select from date");		 }else if(todt ==""){			 $("#todterror").show();			 $("#todterror").text("Please select To date");		 }/*else if(calculationfrm ==""){			 $("#calculationfrmerror").show();			 $("#calculationfrmerror").text("Please select Calculation from date");		 }else if(calculationto ==""){			 $("#calculationtoerror").show();			 $("#calculationtoerror").text("Please select Calculation To date");		 }else if(presentday ==""){			 $("#presentdayerror").show();			 $("#presentdayerror").text("Please enter calculation day");		 }*/else{			  $('#displaydetails').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');						 $.get('leave-encashment-details.php', {			 'client': client,			 'emp':emp,             'empid':empid,			 'leavetype':leavetype,			 'frdt':frdt,			 'todt':todt,			 'calculationfrm':calculationfrm,			 'calculationto':calculationto,			 'presentday':presentday	 		}, function (data) {				$("#showlist").show();				   $("#displaydetails").html(data);			   		});		 }	 		/* */			 }	 function changeField(){ 	 var client = $("#client").val();	 var leavetype = $("#leavetype").val();	 		 $.get('get-lattest-opening-date.php', {			 'client': client,			 'leavetype':leavetype	 		}, function (data) {				//$("#showlist").show();				   //$("#displaydetails").html(data);		  		   		});	 }	 function rateCal(id){		 var enc = $("#encash"+id).val();		 var rate = $("#rate"+id).val();		 var amount =0;		if(enc=="" || rate==""){			amount=0;		}else{			var amount = parseFloat(enc) * parseFloat(rate);		}		 		 		 var amounttxt = $("#amounttxt"+id).text(amount.toFixed(2));		  var amountinp = $("#amountinp"+id).val(amount.toFixed(2));		 		 	 }	 function checkAll(val){		 if(document.getElementById('allcheck').checked){						 $(".selectchk" ).prop( "checked", true );		 }else{			 $(".selectchk" ).prop( "checked", false );		 }			 }</script></body></html>