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
        $body = '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SailChimp HTML Email Template</title>
            <style type="text/css">
                @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap");
                body {
                    margin: 0;
                }
                                table {
                    border-spacing: 0;
                                }
                                td {
                    padding: 0;
                }
                                img {
                    border: 0;
                }
            
                h1, h2, h3, h4, h5, h6 {
                    font-family: "Open Sans", sans-serif;
                    font-weight: 700;
                    line-height: 1.28;
                }
            
                p, label {
                    font-size: 1rem;
                    font-family: "Open Sans", sans-serif;
                    font-weight: 400;
                    line-height: 1.5;
                }
            
                .email-container {
                    background-color: #F1F1F1;
                    color: #111111;
                    margin: auto;
                    position: relative;
                    box-shadow: 10px 0 8px -5px #e9e1ff, -10px 0 8px -5px #e9e1ff;
                    overflow-x: hidden;
                }
            
                .email {
                    background-color: white;
                    margin: 2rem auto;
                    max-width: 640px;
                    box-shadow: 0 5px 25px -10px rgba(0, 0, 0, .3);
                }
            
                .brand {
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                    color: inherit;
                    text-decoration: none;
                }
            
                .brand-icon {
                    aspect-ratio: 1 / 1;
                    width: 40px;
                    height: 40px;
                }
            
                .brand-name {
                    margin: 0;
                    font-size: .5rem;
                    text-transform: uppercase;
                }
            
                .header {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    padding: 1rem 2rem;
                    background-color: #3D3DBB;
                    color: white;
                }
            
                .header h1 {
                    width: 100%;
                    flex-grow: 1;
                    font-size: 24px;
                    text-align: center;
                }
            
                .body {
                    padding: 1rem 2rem;
                }
            
                .footer {
                    padding: 1rem 2rem 2rem;
                    text-align: center;
                }
            
                .btn {
                    display: inline-block;
                    font-weight: bold;
                    text-align: center;
                    vertical-align: middle;
                    user-select: none;
                    border: 1px solid transparent;
                    padding: .375rem 50px;
                    font-size: 1.2rem;
                    line-height: 1.5;
                    border-radius: 5rem;
                }
            
                .primary-btn {
                    background-color: #3D3DBB;
                    color: white;
                }
            
                .primary-btn:hover {
                    background-color: #3D1C9B;
                    color: white;
                }
            
            </style>
            </head>
            <body>
            
                <div class="email-container">
                    <div class="email">
                        <div class="header">                                
                            <h1>PETROCON ENGINEERING SERVICES</h1>
                        </div>
                        <div class="body">
                            <p>Hi '.$invitation->getName().'!
                                <br>
                                <br>
                                We are inviting you to use our Web-based application, which will give you a better view of all that’s happening with your project.
                                <br>
                                <br>
                                Here\'s your account.
                                <br>
                                <br>
                                Username: '.$invitation->getUsername().' <br>
                                Password: '.$invitation->getPassword().'</p>
            
                            <h3>Note</h3>
                            <p>Please keep in mind that this invitation is only valid for  48 hours.</p>
                            <p>Accept the Invitation to activate your account.</p>
                        </div>
                        <div class="footer">
                            <a href="'.$url.'/'.$invitation->getCode().'">
                                <button class="btn primary-btn" style="cursor: pointer;">Accept Invitation</button>
                            </a>
                        </div>
                    </div>
                </div>
            
            </body>
            </html>';

        return $body;
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