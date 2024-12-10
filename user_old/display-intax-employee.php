<?php
session_start();
//include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userObj=new user();
 $id=$_POST['id'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$rowintax=$userObj->showintaxincome($id,$comp_id,$user_id);
$tmpother=$userObj->checkoutotherinfo($id,$comp_id,$user_id);
$rowotherinfo=$tmpother->fetch_assoc();

?>

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script type="text/javascript" src="../js/jquery-ui.js"></script>


<script>
    $( document ).ready(function() {
     $('#tab1').show();
        refreshsection(document.getElementById("empid").value);
        refreshincome(document.getElementById("empid").value);
        refreshc(document.getElementById("empid").value);
       // refreshchapter(document.getElementById("empid").value);
        refreshchapter('<?php echo $id; ?>');
    });
    function clearerror1(){
        $('#anerror').html("");
        $('#amerror').html("");
    }
    function clearerror11(){
        $('#anerror1').html("");
        $('#amerror1').html("");
    }
    function deletesection(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_intax_allow_process', {
                'id': id
            },function(data){
                refreshsection('<?php echo $id; ?>');
                $("#success4").html("Recourd Delete Successfully!");
            });
        }
    }
    function insertsection(){
        clearerror1();
            var empid=document.getElementById("empid").value;
            var allow_name=document.getElementById("allow_name").value;
            var allow_amt=document.getElementById("allow_amt").value;

        if(allow_name == '') {
            $('#anerror').html("Please Enter the allow name");
            $('#anerror').show();
            document.getElementById("allow_name").focus();
            $("#success").hide();
        }
        else if (allow_amt == '') {
            $('#amerror').html("Please Enter the allow amount");
            $('#amerror').show();
            document.getElementById("allow_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_allow_process', {
                'empid': empid,
                'allow_name': allow_name,
                'allow_amt': allow_amt
            }, function(data){
                alert("Record Insert Successfully!");
                refreshsection('<?php echo $id; ?>');
                clearerror1();
            });
         }

   }
    function refreshsection(id){
        $.post('/display_emp_intax_allow',{
            'id':id
        },function(data){
            $("#displayallow").html(data);
            $("#displayallow").show();
        });
    }

    function editsection(id) {
        $.post('/edit_intax_allow',{
            'id':id
        },function(data){
            $('#editallow').html(data);
            $('#editallow').show();
            $("#insertallow").hide();
        });

    }

    function updatesection(){
        clearerror11();
    //alert("hi");
        var empid=document.getElementById("empid").value;
        var id=document.getElementById("allowid").value;
        var name=document.getElementById("name").value;
        var allow_name=document.getElementById("allow_name1").value;
        var allow_amt=document.getElementById("allow_amt1").value;

        if(allow_name == '') {
            $('#anerror').html("Please Enter the allow name");
            $('#anerror').show();
            document.getElementById("allow_name").focus();
            $("#success").hide();
        }
        else if (allow_amt == '') {
            $('#amerror').html("Please Enter the allow amount");
            $('#amerror').show();
            document.getElementById("allow_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_allow_process', {
                'id': id,
                'allow_name': allow_name,
                'allow_amt': allow_amt
            }, function(data){
                alert("Record Update Successfully!");
                refreshsection('<?php echo $id; ?>');
                clearerror11();
                document.getElementById("allowid").value =id;
            });
        }

    }
    //  tab 1
    function refreshincome(id){
        $.post('/display_emp_intax_income',{
            'id':id
        },function(data){
            $("#displayincome").html(data);
            $("#displayincome").show();

        });
    }
    function deleteincome(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_intax_allow_process', {
                'id': id
            },function(data){
                refreshincome('<?php echo $id; ?>');
                $("#success4").html("Recourd Delete Successfully!");
            });
        }
    }



    function editincome(id) {
        $.post('/edit_intax_income',{
            'id':id
        },function(data){
            $('#editincome').html(data);
            $('#editincome').show();
            $("#insertincome").hide();
        });

    }

    function clearerror2(){
        $('#iderror').html("");
        $('#amerror').html("");
    }
    function clearerror21(){
        $('#iderror1').html("");
        $('#amerror1').html("");
    }
    function insertincome(){
        clearerror2();
        var empid=document.getElementById("empid").value;
        var name=document.getElementById("name").value;
        var income_desc=document.getElementById("income_desc").value;
        var income_amt=document.getElementById("income_amt").value;

        if(income_desc == '') {
            $('#iderror').html("Please Enter the income desc");
            $('#iderror').show();
            document.getElementById("income_desc").focus();
            $("#success").hide();
        }
        else if(income_amt == '') {
            $('#iaerror').html("Please Enter the income amount");
            $('#iaerror').show();
            document.getElementById("income_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_income_process', {
                'empid': empid,
                'income_desc': income_desc,
                'income_amt': income_amt
            }, function(data){
               alert("Record Insert Successfully!");
                refreshincome(empid);
                clearerror2();
            });
        }

    }
   function updateincome(){
       clearerror21();
            var empid=document.getElementById("empid").value;
            var id=document.getElementById("incomeid").value;
            var name=document.getElementById("name").value;
            var income_desc=document.getElementById("income_desc1").value;
            var income_amt=document.getElementById("income_amt1").value;

        if(income_desc == '') {
            $('#iderror').html("Please Enter the income desc");
            $('#iderror').show();
            document.getElementById("income_desc").focus();
            $("#success").hide();
        }
        else if(income_amt == '') {
            $('#iaerror').html("Please Enter the income amount");
            $('#iaerror').show();
            document.getElementById("income_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_income_process', {
                'empid': empid,
                'id': id,
                'income_desc': income_desc,
                'income_amt': income_amt
            }, function(data){

               alert("Record Update Successfully!");
                document.getElementById("incomeid").value=id;
                refreshincome(empid);
                clearerror21();
            });
        }

   }
   // tab 2
    function deletec(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_intax_allow_process', {
                'id': id
            },function(data){
                refreshc('<?php echo $id; ?>');
                $("#success4").html("Recourd Delete Successfully!");
            });
        }
    }
    function editc(id) {
        $.post('/edit_intax_c',{
            'id':id
        },function(data){
            $('#editc').html(data);
            $('#editc').show();
            $("#insertc").hide();
        });

    }

    function clearerror3(){
        $('#cderror').html("");
        $('#caerror').html("");

    }
    function clearerror31(){
        $('#cderror1').html("");
        $('#caerror1').html("");

    }

    function refreshc(id){
        $.post('/display_emp_intax_c',{
            'id':id
        },function(data){
            $("#displayc").html(data);
            $("#displayc").show();

        });
    }

 function insert80c(){
     clearerror3();
            var empid=document.getElementById("empid").value;
            var name=document.getElementById("name").value;
            var c_desc=document.getElementById("80c_desc").value;
            var c_amt=document.getElementById("80c_amt").value;

        if(c_desc == '') {
            $('#cderror').html("Please Enter the income desc");
            $('#cderror').show();
            document.getElementById("income_desc").focus();
            $("#success").hide();
        }
        else if(c_amt == '') {
            $('#caerror').html("Please Enter the income amount");
            $('#caerror').show();
            document.getElementById("income_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_80c_process', {
                'empid': empid,
                'c_desc': c_desc,
                'c_amt': c_amt
            }, function(data){

                    alert("Record Insert Successfully!");
                refreshc('<?php echo $id; ?>');
            });
       }
   }
   function update80c(){
     clearerror31();
            var empid=document.getElementById("empid").value;
            var id=document.getElementById("cid").value;
            var name=document.getElementById("name").value;
            var c_desc=document.getElementById("80c_desc1").value;
            var c_amt=document.getElementById("80c_amt1").value;

        if(c_desc == '') {
            $('#cderror').html("Please Enter the income desc");
            $('#cderror').show();
            document.getElementById("income_desc").focus();
            $("#success").hide();
        }
        else if(c_amt == '') {
            $('#caerror').html("Please Enter the income amount");
            $('#caerror').show();
            document.getElementById("income_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_80c_process', {
                'empid': empid,
                'id': id,
                'c_desc': c_desc,
                'c_amt': c_amt
            }, function(data){
                    alert("Record Update Successfully!");
                    document.getElementById("cid").value =id;
                    refreshc('<?php echo $id; ?>');
            });
    }

   }

   // tab 3
    function refreshchapter(id){
        $.post('/display_emp_intax_chapter',{
            'id':id
        },function(data){
            $("#displaychapter").html(data);
            $("#displaychapter").show();

        });
    }
    function clearerror4(){
        $('#snerror').html("");
        $('#gaerror').html("");
        $('#qaerror').html("");
        $('#daerror').html("");

    }
    function clearerror41(){
        $('#snerror1').html("");
        $('#gaerror1').html("");
        $('#qaerror1').html("");
        $('#daerror1').html("");

    }
    function deletechapter(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete_intax_allow_process', {
                'id': id
            },function(data){
                refreshchapter('<?php echo $id; ?>');
                $("#success4").html("Recourd Delete Successfully!");
            });
        }
    }
    function editchapter(id) {
        $.post('/edit_intax_chapter',{
            'id':id
        },function(data){
            $('#editchapter').html(data);
            $('#editchapter').show();
            $("#insertchapter").hide();
        });

    }
function insertchapter(){
    clearerror4();
            var empid=document.getElementById("empid").value;

            var name=document.getElementById("name").value;
            var section_name=document.getElementById("section_name").value;
            var gross_amt=document.getElementById("gross_amt").value;
            var qual_amt=document.getElementById("qual_amt").value;
            var deduct_amt=document.getElementById("deduct_amt").value;

        if(section_name== '') {
            $('#snerror').html("Please Enter the section name");
            $('#snerror').show();
            document.getElementById("section_name").focus();
            $("#success").hide();
        }
        else if(gross_amt == '') {
            $('#gaerror').html("Please Enter the gross amount");
            $('#gaerror').show();
            document.getElementById("gross_amt").focus();
            $("#success").hide();
        }
        else if(qual_amt == '') {
            $('#qaerror').html("Please Enter the qual amount");
            $('#qaerror').show();
            document.getElementById("qual_amt").focus();
            $("#success").hide();
        }
        else if(deduct_amt == '') {
            $('#daerror').html("Please Enter the deduct amount");
            $('#daerror').show();
            document.getElementById("deduct_amt").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_chapter_process', {
                'empid': empid,
                'section_name': section_name,
                'gross_amt': gross_amt,
                'qual_amt': qual_amt,
                'deduct_amt': deduct_amt
            }, function(data){
               alert("Record Insert Successfully!");
                refreshchapter('<?php echo $id; ?>');
            });

    }

   }
   function updatechapter(){
       clearerror41();
            var empid=document.getElementById("empid").value;
            var id=document.getElementById("chapid").value;
            var name=document.getElementById("name").value;
            var section_name=document.getElementById("section_name1").value;
            var gross_amt=document.getElementById("gross_amt1").value;
            var qual_amt=document.getElementById("qual_amt1").value;
            var deduct_amt=document.getElementById("deduct_amt1").value;

        if(section_name== '') {
            $('#snerror1').html("Please Enter the section name");
            $('#snerror1').show();
            document.getElementById("section_name1").focus();
            $("#success").hide();
        }
        else if(gross_amt == '') {
            $('#gaerror1').html("Please Enter the gross amount");
            $('#gaerror1').show();
            document.getElementById("gross_amt1").focus();
            $("#success").hide();
        }
        else if(qual_amt == '') {
            $('#qaerror1').html("Please Enter the qual amount");
            $('#qaerror1').show();
            document.getElementById("qual_amt1").focus();
            $("#success").hide();
        }
        else if(deduct_amt == '') {
            $('#daerror1').html("Please Enter the deduct amount");
            $('#daerror1').show();
            document.getElementById("deduct_amt1").focus();
            $("#success").hide();
        }
        else {
            $.post('/update_intax_chapter_process', {
                'empid': empid,
                'id': id,
                'section_name': section_name,
                'gross_amt': gross_amt,
                'qual_amt': qual_amt,
                'deduct_amt': deduct_amt
            }, function(data){

                alert("Record Update Successfully!");

                refreshchapter('<?php echo $id; ?>');


            });

    }

   }


   /* function editincome(id){
        if(data!='') {

        $.post('/update_intax_income_process',{
            'id':id
        },function(data){
            $('#form1').trigger('reset');
            $("#success").html("Record Insert Successfully!");
            $("#success").show();
          document.getElementById("id").value = data;
                $("#insertincome").hide();
                $("#editincome").html(data);

         });
       }else{
           $("#editincome").hide();
           $("#insertincome").show();
       }
    }*/
    function insertOtherinfo(){
        clearerror4();
        var empid=document.getElementById("empid").value;

        var hsg_intrest=document.getElementById("hsg_intrest").value;
        var ccc=document.getElementById("80ccc").value;
        var ccd=document.getElementById("80ccd").value;
        var ccf=document.getElementById("80ccf").value;
        var relief_89=document.getElementById("relief_89").value;
        var taxbenefit_87=document.getElementById("taxbenefit_87").value;

        if(hsg_intrest== '') {
            $('#snerror').html("Please Enter the section name");
            $('#snerror').show();
            document.getElementById("section_name").focus();
            $("#success").hide();
        }


        else {
            $.post('/update_intax_otherinfo_process', {
                'empid': empid,
                'hsg_intrest': hsg_intrest,
                'ccc':ccc,
                'ccd':ccd,
                'ccf':ccf,
                'relief_89':relief_89,
                'taxbenefit_87':taxbenefit_87
            }, function(data){



                $("#success5").html("Record Updated Successfully!");
                $("#success5").show();


            });

        }

    }
    </script>



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->
<div class="twelve">
<div class="row">  <div class="three columns">Total Income</div>
    <div class="three columns">Tax Payable</div>
    <div class="three columns">Tax Paid</div>
    <div class="three columns">Tax Due Rs.</div>
    </div>
</div>
<div class="twelve mobicenter innerbg">
    <div class="row">



        <div class="twelve" id="margin1">
            <div class="tab">
                <button id="t1" class="tablinks active" onclick="openTab(event, 'tab1')">Section - 10</button>
                <button id="t2" class="tablinks" onclick="openTab(event, 'tab2')" >Other Income</button>
                <button id="t3" class="tablinks" onclick="openTab(event, 'tab3')">Section 80 C</button>
                <button id="t4" class="tablinks" onclick="openTab(event, 'tab4')">Chapter VI-A (Other Section)</button>
                <button id="t4" class="tablinks" onclick="openTab(event, 'tab5')">Other Info.</button>

            </div>

            <div id="tab1" class="tabcontent ">
             <h3>Section - 10 (Excluding Conveyance)</h3>
                <div id="insertallow">
                <form method="post"  id="form1">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success">
                        </div>

                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Allow Name :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="allow_name" id="allow_name" placeholder="Allow Name" class="textclass">
                            <span class="errorclass hidecontent" id="anerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Allow Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="allow_amt" id="allow_amt" placeholder="Allow Amount" class="textclass">
                            <span class="errorclass hidecontent" id="amerror"></span>
                        </div>
                        <div class="clearFix"></div>
                        <div class="ten columns">
                        </div>
                        <div class="two columns text-right">
                               <input type="button" name="submit" id="submit1" value="Save" class="btnclass" onclick="insertsection();">
                        </div>
                    </div>

                </form>
                </div>
                <div id="editallow">
                </div>

                <div id="displayallow">
                </div>

            </div>


            <div id="tab2" class="tabcontent">
                <h3>Other Income</h3>
                <div id="insertincome">
                <form method="post"  id="form2">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success1">


                        </div>

                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Income Desc :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="income_desc" id="income_desc" placeholder="Income Desc" class="textclass" >
                            <span class="errorclass hidecontent" id="iderror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Income Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="income_amt" id="income_amt" placeholder="Income Amount" class="textclass">
                            <span class="errorclass hidecontent" id="iaerror"></span>
                        </div>
                        <div class="clearFix"></div>
                        <div class="ten columns">
                        </div>
                        <div class="two columns text-right">

                                <input type="button" name="submit" id="submit1" value="Save" class="btnclass" onclick="insertincome();">


                        </div>
                    </div>


                </form>
            </div>
            <div id="editincome">
            </div>

            <div id="displayincome">
            </div>
            </div>







            <div id="tab3" class="tabcontent">
                <h3>Section 80 C (Excluding PF & ESI)</h3>
                <div id="insertc">
                <form method="post"  id="form3">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success1">


                        </div>

                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">80c Desc :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="80c_desc" id="80c_desc" placeholder="80c Desc" class="textclass">
                            <span class="errorclass hidecontent" id="cderror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">80c Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="80c_amt" id="80c_amt" placeholder="80c Amount" class="textclass">
                            <span class="errorclass hidecontent" id="canerror"></span>
                        </div>
                        <div class="clearFix"></div>
                        <div class="ten columns">
                        </div>
                        <div class="two columns text-right">

                                <input type="button" name="submit" id="submit1" value="Save" class="btnclass" onclick="insert80c();">

                        </div>
                    </div>


                </form>
            </div>
            <div id="editc">
            </div>

            <div id="displayc">
            </div>

            </div>
            <div id="tab4" class="tabcontent">
                <h3>Chapter VI-A (Other Section)</h3>
                <div id="insertchapter">
                <form method="post"  id="form4">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success1">


                        </div>

                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Section Name :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="section_name" id="section_name" placeholder="Section Name" class="textclass" >
                            <span class="errorclass hidecontent" id="snerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">Gross Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="gross_amt" id="gross_amt" placeholder="Gross Amount" class="textclass" >
                            <span class="errorclass hidecontent" id="gaerror"></span>
                        </div>
                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Qual Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="qual_amt" id="qual_amt" placeholder="Qual Amount" class="textclass" >
                            <span class="errorclass hidecontent" id="qaerror"></span>
                        </div>
                    <div class="two columns">
                            <span class="labelclass">Deduct Amount :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="deduct_amt" id="deduct_amt" placeholder="Deduct Amount" class="textclass" >
                            <span class="errorclass hidecontent" id="daerror"></span>
                        </div>


                        <div class="clearFix"></div>
                        <div class="ten columns">
                        </div>
                        <div class="two columns text-right">

                                <input type="button" name="submit" id="submit1" value="Save" class="btnclass" onclick="insertchapter();">
                                 </div>
                    </div>

                </form>


            </div>
            <div id="editchapter">
            </div>

            <div id="displaychapter">
            </div>

            </div>
            <div id="tab5" class="tabcontent">
                <h3>Other Info.</h3>
                <div id="insertotherinfo">
                <form method="post"  id="form5">
                    <div class="twelve" id="margin1">
                        <div class="twelve padd0 columns successclass hidecontent" id="success5">


                        </div>

                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Interest on Hsg. Loan :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="hsg_intrest" id="hsg_intrest" placeholder="Interest on Hsg. Loan" class="textclass" value="<?php echo $rowotherinfo['hsg_intrest'];?>">
                            <span class="errorclass hidecontent" id="snerror"></span>
                        </div>

                        <div class="two columns">
                            <span class="labelclass">80CCC :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="80ccc" id="80ccc" placeholder="80CCC" class="textclass" value="<?php echo $rowotherinfo['80ccc'];?>">
                            <span class="errorclass hidecontent" id="gaerror"></span>
                        </div>
                        <div class="clearFix"></div>


                        <div class="two columns">
                            <span class="labelclass">80CCD :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="80ccd" id="80ccd" placeholder="80CCD" class="textclass" value="<?php echo $rowotherinfo['80ccd'];?>">
                            <span class="errorclass hidecontent" id="gaerror"></span>
                        </div>
                        <div class="two columns">
                            <span class="labelclass">80CCF :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="80ccf" id="80ccf" placeholder="80CCF" class="textclass" value="<?php echo $rowotherinfo['80ccf'];?>">
                            <span class="errorclass hidecontent" id="gaerror"></span>
                        </div>
                        <div class="clearFix"></div>

                        <div class="two columns">
                            <span class="labelclass">Relief Under 89 :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="relief_89" id="relief_89" placeholder="Relief Under 89" class="textclass" value="<?php echo $rowotherinfo['relief_89'];?>">
                            <span class="errorclass hidecontent" id="qaerror"></span>
                        </div>
                    <div class="two columns">
                            <span class="labelclass">Tax Benefit 87 :</span>
                        </div>
                        <div class="four  columns">
                            <input type="text" name="taxbenefit_87" id="taxbenefit_87" placeholder="Tax Benefit 87" class="textclass" value="<?php echo $rowotherinfo['taxbenefit_87'];?>">
                            <span class="errorclass hidecontent" id="daerror"></span>
                        </div>


                        <div class="clearFix"></div>
                        <div class="ten columns">
                        </div>
                        <div class="two columns text-right">

                                <input type="button" name="submit" id="submit1" value="Save" class="btnclass" onclick="insertOtherinfo();">
                                 </div>
                    </div>

                </form>


            </div>


            <div id="displaychapter">
            </div>

            </div>


        </div>



<br/>

<div class="clearFix"></div>

<!--Slider part ends here-->
