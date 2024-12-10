<?php
session_start();
//error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


//require('../send-email/PHPMailer/PHPMailerAutoload.php');
include("../lib/connection/db-config.php");

include("../lib/class/user-class.php");


$pdfHtml='';
include("../lib/class/admin-class.php");
$userObj=new user();

$resclt=$userObj->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
}
else{
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
		$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
		
			
/*	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];*/
	$frdt = $userObj->getLastDay($frdt);
	/*$sql = "SELECT LAST_DAY('".$todt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$todt = $res['last_day'];*/
	$todt =$userObj->getLastDay($todt);


}


//$sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
$empid=$_REQUEST['empid'];
$res = $userObj->reportPayslipSendMail($tab_days,$clintid,$frdt,$todt,$emp,$empid);
/*$sql = "SELECT * FROM $tab_days WHERE client_id ='".$clintid."' AND sal_month >= '$frdt' AND sal_month <= '$todt' ";


if($emp!='all'){
    
    $sql .= " AND emp_id=".$empid;
}



$res = mysql_query($sql);*/
$tcount= mysqli_num_rows($res);

//$_SESSION['client_name']=$resclt['client_name'];
//$_SESSION['reporttitle']=$reporttitle;

?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   

<?php 
/*
//recipient
 $to = "developer.vilas@gmail.com";

//sender
$from = 'vilasbondre@gmail.com';
$fromName = 'Just for test';

//email subject
$subject = 'PHP Email with Attachment by vilas 123'; 

//attachment file path
$file = $_SERVER['DOCUMENT_ROOT'].'/reports/106_ATUL-SUBHASH-ZANJALE_September-2019.pdf';
//$file = "codexworld.pdf";

//email body content
$htmlContent = '<h1>PHP Email with Attachment by Vilas for test</h1>
    <p>This email has sent from PHP script with attachment.</p>';

//header for sender info
$headers = "From: $fromName"." <".$from.">";

//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
// Cc email
$headers .= "\nCc: aparnakatkar@gmail.com";
//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

//preparing attachment
if(!empty($file) > 0){
    if(is_file($file)){
        $message .= "--{$mime_boundary}\n";
        $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));

        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
        "Content-Description: ".basename($file)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
}
$message .= "--{$mime_boundary}--";
$returnpath = "-f" . $from;

//send email
$mail = mail($to, $subject, $message, $headers, $returnpath); 

//email sending status
echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";*/

?>




        <?php
        //$count=1;
        //$per=2;
        $sendmsg='';
	//	require('../send-email/PHPMailer/class.phpmailer.php');
        while($row=$res->fetch_assoc()){
		$monthtit =  date('F Y',strtotime($row['sal_month']));
	
        $empid=$row['emp_id'];
        $emprows1=$userObj->showEployeedetails($empid,$comp_id,$user_id);
        $temp=$clintid.'_'.$emprows1["first_name"]."-".$emprows1["middle_name"]."-".$emprows1["last_name"].'_'.$monthtit;
                 $name=$_SERVER['DOCUMENT_ROOT'].'/pdffiles/payslip/'.$temp.'.pdf';
                

			   //recipient
                     $to = "developer.vilas@gmail.com";
                    
                    //sender
                    $from = 'vilasbondre@gmail.com';
                    $fromName = 'Just for test';
                    
                    //email subject
                    $subject = 'PHP Email with Attachment by vilas 123'; 
                    
                    //attachment file path
                    //$file = $_SERVER['DOCUMENT_ROOT'].'/reports/106_ATUL-SUBHASH-ZANJALE_September-2019.pdf';
                    $file = $name;
                    //$file = "codexworld.pdf";
                    
                    //email body content
                    $htmlContent = '<h1>PHP Email with Attachment by Vilas for test</h1>
                        <p>This email has sent from PHP script with attachment.</p>';
                    
                    //header for sender info
                    $headers = "From: $fromName"." <".$from.">";
                    
                    //boundary 
                    $semi_rand = md5(time()); 
                    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                    
                    //headers for attachment 
                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                    // Cc email
                    $headers .= "\nCc: aparnakatkar@gmail.com";
                    //multipart boundary 
                    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                    "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
                    
                    //preparing attachment
                    if(!empty($file) > 0){
                        if(is_file($file)){
                            $message .= "--{$mime_boundary}\n";
                            $fp =    @fopen($file,"rb");
                            $data =  @fread($fp,filesize($file));
                    
                            @fclose($fp);
                            $data = chunk_split(base64_encode($data));
                            $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
                            "Content-Description: ".basename($file)."\n" .
                            "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
                            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                        }
                    }
                    $message .= "--{$mime_boundary}--";
                    $returnpath = "-f" . $from;
                    
                    //send email
                    $mail = mail($to, $subject, $message, $headers, $returnpath); 
                    
                    //email sending status
                    echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";
                                   // $count++; 
                                   } 
                    
                    //echo $sendmsg;

               ?>
                <!-- content end -->

</body>
</html>