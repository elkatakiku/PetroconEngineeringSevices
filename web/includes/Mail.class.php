<?php

namespace Includes;

use Model\Invitation;
use Model\Reset;
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
            // Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
//             echo 'Message has been sent';
        } catch (Exception $e) {
            $result = false;
//             echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $result;
    }

    public static function verify($user, $key)
    {
        // var_dump($_SESSION);
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

    public static function invitation(Invitation $invitation)
    {
        $url = SITE_URL.'/auth/invitation';
        $body = "               
                <div class='email-container'>
                    <div class='email'>
                        <div class='header'>
                            <span class='brand'>
                                <img src='".IMAGES_PATH."petrocon-icon-2.png' class='brand-icon' alt='Petrocon Logo'>
                                <p class='brand-name'>Petrocon</p>
                            </span>
                            <h1>PETROCON ENGINEERING SERVICES</h1>
                        </div>
                        <div class='body'>
                            <p>Hi {$invitation->getName()}!
                                <br>
                                <br>
                                We are inviting you to use our Web-based application, which will give you a better view of all that’s happening with your project.
                                <br>
                                <br>
                                Here's your account.
                                <br>
                                <br>
                                Username: {$invitation->getUsername()} <br>
                                Password: {$invitation->getPassword()}</p>
                
                            <span style='text-align: center; padding: 1rem'>
                                <p>Check out the link below: <br>
                                    <a href='{$url}/{$invitation->getCode()}'>{$url}</a>
                                </p>
                            </span>
                            
                            <h3>Note</h3>
                            <p>Please keep in mind that this invitation is only valid for  48 hours.</p>
                            <p>Accept the Invitation to activate your account.</p>
                        </div>
                        <div class='footer'>
                            <a href='{$url}/{$invitation->getCode()}'>
                                <button class='btn primary-btn'>Accept Invitation</button>
                            </a>
                        </div>
                    </div>
                </div>";
                
        return $body;
        // TODO: Create an email that will greet the user with their name 
        // and a clickable link that will activate their account in the server
        
        // $url = SITE_URL.'/user/activate/'.$key;
        // return 'Welcome '.$user['lastname'].' Thanks for registering.
        //         <br>
        //         <br>
        //         Please Click on the Link below to activate your account.
        //         <br>
        //         <br>
        //         <a href='' .$url. '">' .SITE_URL.'/user/activate/'.$_SESSION['accID']. '</a>
        //         <br>
        //         <br>
        //         This Link can only be used within 24 hours since the request of activation. You will need to request activation again when it expires.';
    }

    public static function reset(Reset $reset)
    {
        $url = SITE_URL.'/auth/reset/'.$reset->getId();
        $body = '<h1>Forgot your password?</h1>
                <p>Thats okay, it happens! Click on the button below to reset your password.</p>
                <a href="'.$url.'"><button>RESET YOUR PASSWORD</button></a>';

        return $body;
    }
}