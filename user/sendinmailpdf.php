<?php
session_start();
include("../lib/connection/db-config.php");
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include("../lib/class/user-class.php");
$userObj=new user();
require('../fpdf/fpdf.php');
$res1 = $userObj->showEmployee($comp_id,$user_id);

while($data1= mysql_fetch_assoc($res1)){
 $data2=$userObj->showEployeedetails($data1['emp_id'],$comp_id,$user_id);

$pdf = new FPDF();

$pdf->AddPage();
$title = 'Emp Details';
$pdf->SetTitle($title);
$pdf->SetFont("Arial","B",8);
$pdf->Cell(0,10,$title,0,1,'C');
 
 
$pdf->Cell(10,10,' ',0,1,'C');
$pdf->Cell(20,10,"Emp Id",1,0,'C');
$pdf->Cell(30,10,"First Name",1,0,'C');
$pdf->Cell(30,10,"Middle Name",1,0,'C');
 
$pdf->Cell(30,10,"Last Name",1,1,'C');

   $last_name= $data2['last_name'];
   $emp_id = $data2['emp_id'];
   $first_name= $data2['first_name'];
   $middle_name= $data2['middle_name'];
 
    $pdf->Cell(20,10,$emp_id,1,0,'C');
    $pdf->Cell(30,10,$first_name,1,0,'C');
     $pdf->Cell(30,10,$middle_name,1,0,'C');
    $pdf->Cell(30,10, $last_name,1,0,'C');
    $pdf->Ln();
     

$name='../pdffiles/emp_details/emp'.$data1['emp_id'].'.pdf';

$pdf->Output($name,'F');
}



$mailto='anita@wedetailships.com';
$filename="emp925.pdf";
$subject="pdf file attached";
$file = "../pdffiles/emp_details/emp925.pdf";
$content = file_get_contents($name);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file);
$message='Hello';
// header
$header = "From:pingalerohit@gmail.com"."<pingalerohit@gmail.com>\r\n";
$header .= "Reply-To:pingalerohit@gmail.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

// message & attachment
$nmessage = "--".$uid."\r\n";
$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$nmessage .= $message."\r\n\r\n";
$nmessage .= "--".$uid."\r\n";
$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
$nmessage .= "Content-Transfer-Encoding: base64\r\n";
$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$nmessage .= $content."\r\n\r\n";
$nmessage .= "--".$uid."--";

mail($mailto, $subject, $nmessage, $header);