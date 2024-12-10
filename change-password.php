<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Home</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="/css/responsive.css">
  <link rel="stylesheet" href="/css/style.css">
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
                        <div class="text-right"  >
						<br />
						<button class="btn" onclick="document.getElementById('id01').style.display='block'">Login</button>
	<br />	<br />
                        </div>
				<!-- Modify top header3 Navigation start here -->
            </div>
   </div>
</header>
<!--Header end here-->
<div class="clearFix"></div>
<!--Slider part starts here-->
<div align="center" style="background: url('/images/9.jpg')no-repeat;position: relative;background-size: cover;
    background-position: 50% 50%;padding:50px auto">
    <div class="twelve">
        <div class="row">
            <form id="changepass ">
                <div class="four innerbg" style="min-height:auto; margin:100px auto">
                    <div >
                        <div>
                           <h3>Change Password</h3> 
                        </div>
                    </div>
                    <div class="container">
                        <input type="hidden" value="<?php echo $_GET['authkey']; ?>" id="getid">
                            <label class="left"><b>Username</b></label>
                            <input type="text" placeholder="Enter username" name="username" id="username" class="textclass">
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
<!--    <img src="images/9.jpg" />-->
 </div>

<!--Slider part ends here-->
<div class="clearFix"></div>
<!--footer start -->
<footer class="twelve coptyright_bg"  id="footer">
        <div class="row">
            <div class="twelve columns">
                <!--First part starts here-->
           

                <!--First part ends here-->

            <!--Second part starts here-->

            <div class="four columns text-center" id="container2">

                <div class="copyright" >All right reserved, Copyright © 2017 Salary Module</div>

            </div>

            <!--Second part ends here-->

            <!--Third part starts here-->

            <div class="four columns text-left  footer-text mobicenter" id="container3">



            </div>

                </div>

            <!--Third part ends here-->

        </div>



 </footer>

    <script src='/js/jquery.min.js'></script>

<script src='/js/script.js'></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script>

    $("#setpassword").click(function() {
        var errormsg ='';
        var username = document.getElementById('username').value;
        var password = document.getElementById('newpassword').value;
        var confpassword = document.getElementById('confirmpassword').value;
        var getid = document.getElementById('getid').value;
        var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
        
         
        if(username ==""){
            error ="Please Enter Username";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
        }else if(password ==""){
            error ="Please Enter Password";
            $("#errormsg").text(error);
            $("#errormsg").show();
            return false;
            str.length
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
        }else{
            $("#errormsg").text('');
            $("#errormsg").hide();
            
            $.post('/pass-change',{
                'username':username,
                'password':password,
                'id':getid
            },function(data){
               error ="Password has been Reset";
                $("#errormsg").text(error);
                $("#errormsg").show();
               // return false;
                
    
    
            });
        }
        
    })


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
</script>

<!-- The Modal -->

<!--footer end -->

</body>

</html>