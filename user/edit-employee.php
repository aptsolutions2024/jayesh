<?phpsession_start();if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){    header("/home");}include("../lib/connection/db-config.php");include("../lib/class/user-class.php");$userObj=new user();?><!DOCTYPE html><head>  <meta charset="utf-8"/>  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width"/>  <title>Salary | Edit Employee</title>  <!-- Included CSS Files -->  <link rel="stylesheet" href="../css/responsive.css">  <link rel="stylesheet" href="../css/style.css">  <script type="text/javascript" src="../js/jquery.min.js"></script>  <!--<script> function deleteeirow(id) {    if(confirm('Are you You Sure want to delete this Field?')) {        $.post('delete-emp-income-process.php', {            'id': id        }, function (data) {            alert('Recourd Delete Successfully');            refreshIncome('<?php echo $id; ?>');        });    }}function deletederow(id) {    if(confirm('Are you You Sure want to delete this Field?')) {        $.post('delete-emp-deduct-process.php', {            'id': id        }, function (data) {            alert('Recourd Delete Successfully');            refreshDeduct('<?php echo $id; ?>');        });    }}     </script--></head> <body><!--Header starts here--><?php include('header.php');?><!--Header end here--><div class="clearFix"></div><!--Menu starts here--><?php include('menu.php');?><!--Menu ends here--><div class="clearFix"></div><!--Slider part starts here--><div class="twelve mobicenter innerbg" >    <div class="row">        <div class="two columns"  id="margin1">            <span class="labelclass">Employee :</span>        </div>        <div class="six columns" id="margin1">            <input type="text" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off">            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">        </div>        </div>        <div class="four  columns"  id="margin1">         <a href="/edit_employee"><input type="button" name="Clear" id="Clear" value="Clear" class="btnclass"></a>            <input type="hidden" name="empid" id="empid" value="">           </div>        </div>        <div class="clearFix"></div><div id="displaydata"></div>    </div><br/></div><div class="clearFix"></div><!--Slider part ends here--><!--footer start --><?php include('footer.php');?><script>function showTabdata(id,name){       $.post('/display_employee', {           'id': id       }, function (data) {           $('#searching').hide();           $('#displaydata').html(data);           $('#name').val(name);           $('#displaydata').show();           document.getElementById('empid').value=id;refreshconutIncome(id);       });    } function openTab(evt, tabName) {    // Declare all variables    var i, tabcontent, tablinks;    // Get all elements with class="tabcontent" and hide them    tabcontent = document.getElementsByClassName("tabcontent");    for (i = 0; i < tabcontent.length; i++) {        tabcontent[i].style.display = "none";    }    // Get all elements with class="tablinks" and remove the class "active"    tablinks = document.getElementsByClassName("tablinks");    for (i = 0; i < tablinks.length; i++) {        tablinks[i].className = tablinks[i].className.replace(" active", "");    }    // Show the current tab, and add an "active" class to the button that opened the tab    document.getElementById(tabName).style.display = "block";    evt.currentTarget.className += " active";}function clearemp(){    alert("HI");  //  window.location.href="edit-employee.php";}      function serachemp(val){        $.post('/display_employee1', {            'name': val        }, function (data) {            $('#searching').html(data);            $('#searching').show();        });    }  </script><!--footer end --></body></html>