<?php
session_start();
//error_reporting(0);
//print_r($_SESSION);
include("../lib/class/admin-class.php");
$adminObj=new admin();
$company = $_POST['company'];
$user = $_POST['user'];

$menues = $adminObj->getAllParentMenus1($company,$user);
 $rowsmenu = mysqli_num_rows($menues);
$showpages =$adminObj->showPages();
$remainmenues = $adminObj->getRemainMenus($company,$user);

//$getUserDetails =$adminObj->getUserDetailsByCompany($usertype,$company);
$firstpage = $showpages;
?>

	<div class="row">
	<div class="six padd0 columns">&nbsp;</div>
	</div>

    <div class="row">
        <div class="six padd0 columns"><b>Menues</b></div>
        <div class="six padd0 columns"><b>Modules</b></div>
    </div>
    <div class="dd" id="nestable">
            <ol class="dd-list">
                <?php if($rowsmenu==0){ ?>
                <?php $j=1; $row1 = $firstpage->fetch_assoc();?>
                    <li class="dd-item" data-id="<?php echo $row1['pages_id'];?>">
                    <div class="dd-handle"><?php echo $row1['title'];?></div>
                </li>
                <?php } ?>                
                
                <?php while($row1 = $menues->fetch_assoc()){?>
                        <li class="dd-item" data-id="<?php echo $row1['model_id'];?>">
                        <div class="dd-handle"><?php echo $adminObj->getPageTitle($row1['model_id']);?></div>
                        <?php $child1 = $adminObj->getChildMenus($company,$row1['model_id'],$user);
                        if(mysqli_num_rows($child1) >0){?>
                            <ol class="dd-list">
                          <?php while($row2 = $child1->fetch_assoc()){?>
                            <li class="dd-item" data-id="<?php echo $row2['model_id'];?>">
                                <div class="dd-handle"><?php echo $adminObj->getPageTitle($row2['model_id']);?></div>
                                <?php $child2 = $adminObj->getChildMenus($company,$row2['model_id'],$user);
                                if(mysqli_num_rows($child2) >0){?>
                                    <ol class="dd-list">
                                    <?php while($row3 = $child2->fetch_assoc()){
                                    ?>
                                    <li class="dd-item" data-id="<?php echo $row3['model_id'];?>">
                                    <div class="dd-handle"><?php echo $adminObj->getPageTitle($row3['model_id']);?></div>
                                    </li>
                                    <?php } ?>
                                    </ol>
                                <?php } ?>
                            </li>
                        <?php } ?>
                         </ol>
                        <?php }?>
                    </li>
                   <?php } ?>
                </ol>
        </div>

        <div class="dd" id="nestable2">
            <ol class="dd-list">
                <?php if($rowsmenu!=0){?>
                    <?php  while($rowre = $remainmenues->fetch_assoc()){ ?>
                        <li class="dd-item" data-id="<?php echo $rowre['pages_id'];?>">
                        <div class="dd-handle"><?php echo $rowre['title'];?><?php if($rowre['page_name']==""){echo " (Blank)";}?></div>
                    </li>
                   <?php }
                 } else{ $i=1;
                  while($row = $showpages->fetch_assoc()){  ?>
                    <li class="dd-item" data-id="<?php echo $row['pages_id'];?>">
                    <div class="dd-handle"><?php echo $row['title'];?><?php if($row['page_name']==""){echo " (Blank)";}?></div>
                </li>
               <?php $i++;  } }?>
                
            </ol>
        </div>