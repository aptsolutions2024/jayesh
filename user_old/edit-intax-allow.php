<?phpsession_start();if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){    header("/home");}if(isset($_POST['id'])&&$_POST['id']!='') {    $id = $_POST['id'];    $_SESSION['tempcid'] = $id;}else{    $id = $_SESSION['tempcid'];}include("../lib/connection/db-config.php");include("../lib/class/user-class.php");$userObj=new user();$rowintax1=$userObj->showintax($id);?><form method="post"  id="form11">    <div class="twelve" id="margin1">        <div class="twelve padd0 columns successclass hidecontent" id="success">        </div><input type="hidden" value="<?php echo $id; ?>" id="allowid">        <div class="clearFix"></div>        <div class="two columns">            <span class="labelclass">Allow Name :</span>        </div>        <div class="four  columns">            <input type="text" name="allow_name1" id="allow_name1" placeholder="Allow Name" class="textclass" value="<?php echo $rowintax1['allow_name']; ?>" >            <span class="errorclass hidecontent" id="anerror1"></span>        </div>        <div class="two columns">            <span class="labelclass">Allow Amount :</span>        </div>        <div class="four  columns">            <input type="text" name="allow_amt1" id="allow_amt1" placeholder="Allow Amount" class="textclass"  value="<?php echo $rowintax1['allow_amt']; ?>" >            <span class="errorclass hidecontent" id="amerror1"></span>        </div>        <div class="clearFix"></div>        <div class="ten columns">        </div>        <div class="two columns text-right">            <input type="button" name="submit" id="submit1" value="Update" class="btnclass" onclick="updatesection();">        </div>    </div></form>