<?php
session_start();
//error_reporting(0);
//print_r($_SESSION);
include("../lib/class/admin-class.php");
$adminObj=new admin();
//print_r($_POST); ///exit;
$company = $_POST['company'];
$array =json_decode($_POST['menues'], true);
//echo "<pre>";print_r($array);"</pre>";
$adminObj->deleteMenues($company,$_POST['user']);
$i=0;
//print_r($array);
$j =1;
foreach($array as $ar){
    $i++;
  // echo $sql = "inert into mast_menues(model_id,parent_id,status) values('".$ar[id]."',0,1)";
  $adminObj->insertMenus($ar['id'],0,$company,$_POST['user'],$i);
    
    foreach($ar['children'] as $ar1){ $j++;
          $adminObj->insertMenus($ar1['id'],$ar['id'],$company,$_POST['user'],$j);
           foreach($ar1['children'] as $ar2){ $j++;
               $adminObj->insertMenus($ar2['id'],$ar1['id'],$company,$_POST['user'],$j);
           }
    }
}
//$getjsonmenu = $adminObj->getAllMenusJson($company);
$getjsonmenu = $adminObj->getAllMenusJson1($company,$_POST['user']);

echo $rows =mysqli_num_rows($getjsonmenu);

if($rows==0){
$adminObj->insertJsonMenu($company,$_POST['menues'],$_POST['user']);
}else{
  $adminObj->updateJsonMenu($company,$_POST['menues'],$_POST['user']);  
}
?>