<?php
include("config.php");

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require './vendor/autoload.php';
$sql12="select * from email where status='pending'  " ;
$result12= mysqli_query($conn,$sql12);
while($row12=mysqli_fetch_array($result12))
{
 
    $id=$row12['id'];
    $email1=$row12['email'];


// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'akagarwal@inverted.in';
$senderName = 'AKSHAY AGARWAL';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = $email1;

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AWS User name';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'AWS Password';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-east-1.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'Regarding opportunity to work with Inverted Energy';

// The plain-text body of the email


// The HTML-formatted body of the email
$bodyHtml = file_get_contents("abhi1.html");

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
  //  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.
    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->Send();
    

    $query1="update email set  status='send',
    time= now()
     WHERE id='$id'";
    
        $result1 = mysqli_query($conn,$query1);
    
    if($result1){
        
        
        echo 'Email sent!' , PHP_EOL;
        
      
    }



    
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}
}
?>