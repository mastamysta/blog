
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
      $mail->Body = 'This is your authentication key for the site: ' . $KEY . "<br>" . "Use this auth link: http://blog/views/verify.php?key=$KEY&email=$EMAIL";
      
      /* SMTP parameters. */
      
      /* Tells PHPMailer to use SMTP. */
      $mail->isSMTP();
      
      /* SMTP server address. */
      $mail->Host = 'mail.benread.dev';
   
      /* Use SMTP authentication. */
      $mail->SMTPAuth = TRUE;
      
      /* Set the encryption system. */
      $mail->SMTPSecure = 'tls';
      
      /* SMTP authentication username. */
      $mail->Username = 'webmaster@benread.dev';
      
      /* SMTP authentication password. */
      $mail->Password = 'XLuEM(b-Uhwe';
      
      /* Set the SMTP port. */
      $mail->Port = 26;

      $mail->SMTPDebug = 4; 
      
      /* Finally send the mail. */
      $mail->send();
   }catch (Exception $e){
      /* PHPMailer exception. */
      echo $e->errorMessage();
   }
}

?>