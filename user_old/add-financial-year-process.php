<?php
session_start();
$yr = addslashes($_POST['yr']);
 $_SESSION['yr']=$yr;
?>

