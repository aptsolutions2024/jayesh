<?php
session_start();
//error_reporting(0);

include("../lib/class/admin-class.php");

$adminObj=new admin();
    $company = $_POST['company'];
    $pagename = $_POST['pagename'];
    $name = $_POST['title'];
    $id = $_POST['id'];
    $result = $adminObj->editPages($company,$pagename,$name,$id);
?>

