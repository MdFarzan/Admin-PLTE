<?php
    /* 
        mailer.php
        contains function for sending email
    */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './libs/php_mailer/src/PHPMailer.php';
require_once './libs/php_mailer/src/SMTP.php';
require_once './libs/php_mailer/src/Exception.php';
require_once "./config/phpmailer.php";
require_once realpath(__DIR__.'../../../app.php');

$mail = new PHPMailer(true);

function send_forget_password_mail_to($to_email){
    try {
        
        global $mail;

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = MAILER_EMAIL;                     
        $mail->Password   = MAILER_PASSKEY;                              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                   
    
        //Recipients
        $mail->setFrom(MAILER_EMAIL);
        $mail->addAddress($to_email, 'Admin');
        
    
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Recovery | '. APP_NAME;

        $otp = rand(111111, 999999);
        $mail->Body    = 'Admin password recovery requested.<br> Your OTP is <strong>'.$otp.'</strong>. Valid for 10 minutes only!';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        return $otp;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}