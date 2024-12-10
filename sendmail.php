<?php 
$to = "adamitdesai15@gmail.com";
 $from = 'amit041092@gmail.com';
 
  $headers = "From: " . strip_tags($from) . "\r\n";
  $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
  $headers .= "CC: info@phpgang.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $subject='test email';

$message = '<html><body>';
 
$message .= '<table width="100%"; rules="all" style="border:1px solid #3A5896;" cellpadding="10">';
 
$message .= "<tr><td><img src='http://www.phpgang.com/wp-content/uploads/gang.jpg' alt='PHP Gang' /></td></tr>";
 
$message .= "<tr><td colspan=2>Dear \$Name,<br /><br />We thank you for subscribe phpgang.com you are now in phpgang download list you can download any source package from our site.</td></tr>";
 
$message .= "<tr><td colspan=2 font='colr:#999999;'><I>PHPGang.com<br>Solve your problem. :)</I></td></tr>"; 
 
$message .= "</table>";
 
$message .= "</body></html>";
  
 mail($to, $subject, $message, $headers);
    
    ?>