<?php

namespace Includes;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Mail {
    public static function sendMail($subject, $body, $address) {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        $result = true;

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_  SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'servicespetrocon@gmail.com';                     //SMTP username
            $mail->Password   = 'bnlinojfdccwuaty';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            //Recipients
            $mail->setFrom('notification@petrocon.com', 'Petrocon Engineering Services');
            // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress($address);               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);
        
            $mail->send(); 
            // echo 'Message has been sent';
        } catch (Exception $e) {
            $result = false;
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $result;
    }

    public static function verify($user, $key)
    {
        var_dump($_SESSION);
        $url = SITE_URL.'/user/activate/'.$_SESSION['accID'].'/'.$key;
        return 'Welcome '.$user['lastname'].' Thanks for registering.
                <br>
                <br>
                Please Click on the Link below to activate your account.
                <br>
                <br>
                <a href="' .$url. '">' .SITE_URL.'/user/activate/'.$_SESSION['accID']. '</a>
                <br>
                <br>
                This Link can only be used within 24 hours since the request of activation. You will need to request activation again when it expires.';
    }
}