<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

	$f=$_POST['fname'];
	$l=$_POST['lname'];
    $e=$_POST['email'];
    $p=$_POST['psw'];
    $u=$_POST['uname'];
   
require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 
 
$mail = new PHPMailer; 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'donisabk@gmail.com';   // SMTP username 
$mail->Password = 'tyqyyipzbvwahlxj';   // SMTP password 
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 
// Sender info 
$mail->setFrom('info@acelogic.com', 'acelogic'); 
$mail->addReplyTo('info@acelogic.com', 'acelogic'); 
// Add a recipient 
$mail->addAddress($e); 
 
//$mail->addCC('cc@example.com'); 
//$mail->addBCC('bcc@example.com'); 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Mail subject 
$mail->Subject = 'Email from acelogic'; 
 
// Mail body content 
$bodyContent .= '<html>
<head>
<meta charset="utf-8">
</head>

<body background="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4hVvyxHSVWVWGu8Uqq1bOi0x7KAhUG22svA&usqp=CAU" style="background-size: cover;">
    <center>
<h1 style="margin-top: 50px;">Welcome to <b style="color:crimson;">Local Shopee</b></h1>
<p>Hai,</p>
<p>Your new account with local shopee is ready please click the activate button below to activate your account</p>
Below given is your account details <br>
<table border="1" style="margin-top:30px">
  <tr>
    <th scope="row">Mail From</th>
    <td>Local Shopee</td>
  </tr>
  <tr>
    <th scope="row">Fist Name</th>
    <td>'.$f.'</td>
  </tr>
  <tr>
    <th scope="row">Last Name</th>
    <td>'.$l.'</td>
  </tr>
  <tr>
    <th scope="row">email</th>
    <td>'.$e.'</td>
  </tr>
  <tr>
    <th scope="row">Pasword</th>
    <td>'.$p.'</td>
  </tr>
  <tr>
    <th scope="row">Username</th>
    <td>'.$u.'</td>
  </tr>
  
</table>
<div style="margin-top:30px">
Explore from here--->> <a href="http://localhost/Project/local_shopee/activate.php?id="'. $x.'>Local Shopee</a></div>
</center>
</body>
</html>'; 
$mail->Body    = $bodyContent; 
 
// Send email 
if(!$mail->send()) { 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
    header("Location:email_user.php");
    echo 'Message has been sent.'; 
}   



?>