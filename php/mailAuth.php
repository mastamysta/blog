
<?php
//import php mailer module
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '..\composer\vendor\autoload.php';

function authenticate($EMAIL, $USERNAME, $KEY){
      $mail = new PHPMailer(TRUE);
   try {

      //this needs a patch to increase security
      $mail->SMTPOptions = array(
         'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
         )
      );
      
      $mail->setFrom('webmaster@benread.dev', 'DO NOT REPLY -- USER AUTHENTICATION');
      $mail->addAddress($EMAIL, 'Site User');
      $mail->Subject = 'Verify Your Account';
      $mail->Body = 'This is your authentication key for the site: ' . $KEY . "<br>" . "Use this auth link: https://www.benread.dev/views/verify.php?key=$KEY&email=$EMAIL";
      
      $params = include("configs/mailConfig.php");
      
      /* SMTP parameters. */
      
      /* Tells PHPMailer to use SMTP. */
      $mail->isSMTP();
      
      /* SMTP server address. */
      $mail->Host = $params["Host"];
   
      /* Use SMTP authentication. */
      $mail->SMTPAuth = $params["SMTPAuth"];
      
      /* Set the encryption system. */
      $mail->SMTPSecure = $params["SMTPSecure"];
      
      /* SMTP authentication username. */
      $mail->Username = $params["Username"];
      
      /* SMTP authentication password. */
      $mail->Password = $params["Password"];
      
      /* Set the SMTP port. */
      $mail->Port = $params["Port"];

      $mail->SMTPDebug = $params["SMTPDebug"];
      
      /* Finally send the mail. */
      $mail->send();
   }catch (Exception $e){
      /* PHPMailer exception. */
      echo $e->errorMessage();
   }
}

?>