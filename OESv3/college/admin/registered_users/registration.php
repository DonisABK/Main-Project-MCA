<html>
<head>
<title>Registration</title>
</head>
<body>
	<?php
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
	include('connection.php');
    $sql="";
	$u=$_POST['Name'];
	$m=$_POST['Mobile'];
    $e=$_POST['Email'];
    $ad=$_POST['Address'];
    $h=$_POST['Houseno'];
    $s=$_POST['Street'];
    $p=$_POST['Pincode'];
    $pwd=$_POST['Password'];
    //$encrypted_pwd = md5($pwd);
    $sql1="insert into tbl_login(Username,Password,Role,Status) values ('$e','$pwd',1,0)";
    $sql=mysqli_query($conn,$sql1);
    $x=mysqli_insert_id($conn);
    $sqlu="insert into tbl_user(Uname, U_mobile, U_email, Login_id, U_address, U_houseno, U_street, U_pincode) values ('$u','$m','$e','$x','$ad','$h','$s','$p')"; 
    $sql2=mysqli_query($conn,$sqlu);
require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 
 
$mail = new PHPMailer; 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'localshopee2021@gmail.com';   // SMTP username 
$mail->Password = 'cvjrufgccldhdwql';   // SMTP password 
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 
// Sender info 
$mail->setFrom('sender@localshopee.com', 'Local_Shopee'); 
$mail->addReplyTo('reply@localshopee.com', 'Local_shopee'); 
// Add a recipient 
$mail->addAddress($e); 
 
//$mail->addCC('cc@example.com'); 
//$mail->addBCC('bcc@example.com'); 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Mail subject 
$mail->Subject = 'Email from localshopee'; 
 
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
    <th scope="row">Username</th>
    <td>'.$u.'</td>
  </tr>
  <tr>
    <th scope="row">Contact</th>
    <td>'.$m.'</td>
  </tr>
  <tr>
  <th scope="row">Email</th>
  <td>'.$e.'</td>
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
    header("Location:../local_shopee/login.html");
    echo 'Message has been sent.'; 
}   
?>
</body>
</html>