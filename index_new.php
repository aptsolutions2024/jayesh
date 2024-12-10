<?php 
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Home</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/style.css">
</head>
 <body>
<!--Header starts here-->
<header class="twelve header_bg">
    <div class="row">
        <div class="twelve padd0 columns" >
            <div class="eight padd0 columns text-left " id="container1">
<br>
<!--                <a href="index.php"><div class="logo" ><img src="../images/logo.png"></div></a>-->
 <h3 class="Color2"> Dev. By &nbsp &nbsp APT Solutions </h3> <br>
                <br>
                <!-- Modify top header1 ends here -->
            </div>
            <div class="four columns text-right text-center" id="container3">
                <!-- Modify top header3  Navigation start here -->
                   <!--     <div class="text-right"  >
						<br />
<button class="btn" onclick="document.getElementById('id01').style.display='block'">Login</button>
	<br />	<br />
                        </div>-->
				<!-- Modify top header3 Navigation start here -->
            </div>
   </div>
</header>
<!--Header end here-->
<div class="clearFix"></div>
<!--Slider part starts here-->
<div align="center" style="background-color: #f6fde8;position: relative;height:539px;background-size: cover;
    background-position: 50% 50%;padding:50px auto">
 <div class="twelve">
        <div class="row">
            <form id="changepass" style="display:none">
                <div class="four innerbg" style="min-height:auto; margin:100px auto">
                    <div >
                        <div>
                           <h3>Change Password</h3> 
                        </div>
                    </div>
                    <div class="container">
                        //$_GET['authkey']
                        <input type="hidden" value="<?php echo 'authkey'; ?>" id="getid">
                            <label class="left"><b>Username</b></label>
                            <input type="text" placeholder="Enter username" name="username1" id="username1" class="textclass">
                    </div>
                    <div class="container">
                            <label class="left"><b>New Password</b></label>
                            <input type="password" placeholder="Enter password" name="newpassword" id="newpassword" class="textclass">
                    </div>
                    <div class="container">
                            <label class="left"><b>Confirm Password</b></label>
                            <input type="password" placeholder="Enter confirm password" name="confirmpassword" id="confirmpassword" class="textclass">
                    </div>
                    <div class="container " style="height:50px">
                        <span id="errormsg" class="errorclass hidecontent"></span>
                    </div>
                    <div class="container" style="background-color:#f1f1f1">
                        <button class="cancelbtn" type="button" id="setpassword">Set password</button> 
                        
                <!--            <button class="cancelbtn" onclick="login();">Login</button>-->
                    </div>
        		</div>
            </form>
        </div>
    </div>
 </div>
<!--Slider part ends here-->
<div class="clearFix"></div>
<!--footer start -->
<footer class="twelve coptyright_bg"  id="footer">
        <div class="row">
            <div class="twelve columns">
                <!--First part starts here-->
            <div class="four columns text-left   mobicenter" id="container1">
            </div>
                <!--First part ends here-->
            <!--Second part starts here-->
            <div class="four columns text-center" id="container2">
                <div class="copyright" >All right reserved, Copyright © 2023 Salary Module</div>
            </div>
            <!--Second part ends here-->
            <!--Third part starts here-->
            <div class="four columns text-left  footer-text mobicenter" id="container3">
            </div>
                </div>
            <!--Third part ends here-->
        </div>
 </footer>
    <script src='js/jquery.min.js'></script>
<script src='js/script.js'></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
    function validation() {
        var errormsg ='';
        var usernamea = document.getElementById('ur').value;
        var password = document.getElementById('pwd').value;
        if(usernamea ==""){
            error ="Please Enter Username";
            $(".loginvalidation").text(error);
            $(".loginvalidation").show();
            return false;
        }else if(password ==""){
          
            error ="Please Enter Password";
            $(".loginvalidation").text(error);
            $(".loginvalidation").show();
            return false;
        }
    }


/*    function login(){
        var ur=document.getElementById('ur').value;
        var pwd=document.getElementById('pwd').value;
        alert(ur);
        alert(pwd);
        $.get('login-process.php',{
            'username':ur,
            'password':pwd
        },function(data){
           alert(data);
            if(data=='user'){
               window.location.href="/user/index.php";
            } else{

            }


        });

    }*/
     $("#setpassword").click(function() {
        var errormsg ='';
        var username1 = document.getElementById('username1').value;
        var password = document.getElementById('newpassword').value;
        var confpassword = document.getElementById('confirmpassword').value;
        var getid = document.getElementById('getid').value;
        var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
        
         alert(password);
        if(username1 ==""){
            error ="Please Enter Username";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(password ==""){
            error ="Please Enter Password";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(password ==""){
            error ="Please Enter Password";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(!regularExpression.test(password)) {
            error ="Password should contain atleast one number and one special character";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(password.length < 6){
            error ="Password should not be less than 6 character";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(password =! confpassword){
            error ="Password and confirm password are not match";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else{
            $("#errormsg").text('');
            $("#errormsg").hide();
            
            $.post('/pass-change',{
                'username':username1,
                'password':confpassword,
                'id':getid
            },function(data){
                alert(data);
                alert(confpassword);
               error ="Password has been Reset";
                $("#errormsg").html('<span style="color:#013501">'+error+'</span>');
                $("#errormsg").show();
               // return false;
                $("#container3").text(data);
    
    
            });
        }
        
    })
</script>

<!-- The Modal -->
<div id="id01" class="modal">
  <!--<span onclick="document.getElementById('id01').style.display='none'"  class="close" title="Close Modal">&times;</span>-->

    <!-- Modal Content -->
    <form class="modal-content animate" action="login-process.php" onsubmit="return validation();" method="post"  id="loginform">
     <!--   <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>-->
<div style="margin-left: 30px;">
    <div style='background:darkcyan;-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);
    transform: rotate(270deg);border-radius: 0 0 10px 10px;position: fixed;margin-left:-111px;width: 202px;margin-top: 83px;'>
        <div style="padding: 5px 15px;font-size: 22px;color: #fff;">
            LOGIN
        </div>
    </div>
    <div class="container">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="ur" class="textclass">

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="pwd" class="textclass">

          <!--            <input type="checkbox" checked="checked"> Remember me-->
        </div>

        <div class="container" style="background-color:#f1f1f1">
        
            <button class="cancelbtn" type="submit">Login</button>
<!--            <button class="cancelbtn" onclick="login();">Login</button>-->
            <a href="javascript:void(0)" id="forgot">Forgot Password</a><br>
        <span id="errormsg" class="errorclass hidecontent loginvalidation"></span>
        </div>
		</div>
    </form>
      <form id="forgotpass" style="display:none" class="modal-content animate" >
        <div style="margin-left: 30px;">
            <div style='background:darkcyan;-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);
            transform: rotate(270deg);border-radius: 0 0 10px 10px;position: fixed;margin-left:-111px;width: 202px;margin-top: 83px;'>
                <div style="padding: 5px 15px;font-size: 22px;color: #fff;">
                    Forgot Password
                </div>
            </div>
            <div class="container">
                    <label><b>Username</b></label>
                    <input type="text" placeholder="Enter emailid" name="emailaddress" id="emailaddress" class="textclass">
            </div>
            <div class="container" style="height:50px">
                <span id="errorfor"></span>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button class="cancelbtn" type="button" id="forgotpassgt">Get Password</button> &nbsp; <button class="cancelbtn" type="button" id="login">Login</button>
                <span id="errormsg" class="errorclass hidecontent"></span>
        <!--            <button class="cancelbtn" onclick="login();">Login</button>-->
            </div>
		</div>
    </form>
</div>


<script>
  
    
    $(document).ready(function(){
        
          // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
  /* window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }*/
      displayLoginWindow();
        
         $("#forgot").click(function(){
             $("#loginform").hide();
             $("#forgotpass").show();
             valsubmit();
        });
        
        function displayLoginWindow(){
            document.getElementById('id01').style.display='block';
        } 
        function isEmail(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
        }
        
        $("#forgotpassgt").click(function() { // intercepts the submit event
        
            var email = $("#emailaddress").val();
            if(email ==""){
                $("#errorfor").html("<div style='color:#f00'>Please Enter Email Address.</div>");
                return false;
            }else if(isEmail(email) == false){
                 $("#errorfor").html("<div style='color:#f00'>Please Enter Valid Email Address.</div>");
                return false;
             }
            
          $.ajax({ // make an AJAX request
            type: "POST",
            url: "/getpassword", // it's the URL of your component B
            data: $("#forgotpass").serialize(), // serializes the form's elements
            success: function(data)
            {
                 $("#errorfor").html("<div style='color:#048604'>Please check your email account.</div>");
                //alert(data);
              // show the data you got from B in result div
             // $("#result").html(data);
            }
          });
         // e.preventDefault(); // avoid to execute the actual submit of the form
        });
        
        $("#login").click(function() {
             $("#loginform").show();
             $("#forgotpass").hide();
        })
        
        var url_string = window.location.href;
        
        var url = new URL(url_string);
        var authkey = url.searchParams.get("authkey");
       // alert(authkey);
        if(authkey !="" && authkey !=null){
            $("#changepass").css({'display':'block'});
        }

    })
</script>
<!--footer end -->
</body>
</html>