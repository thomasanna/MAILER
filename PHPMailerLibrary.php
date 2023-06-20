<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailerLibrary implements MailerLibrary {


    public function send(string $from, array $to, array $cc, array $bcc, string $subject, string $htmlBody, string $textBody, array $attachments,string $replyTo): bool {
        
        require 'vendor/autoload.php';
        require 'phpMailerConfig.php';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $SMTP_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $SMTP_USERNAME;                     //SMTP username
            $mail->Password   = $SMTP_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            $mail->setFrom($from, $from);
            
            foreach ($to as $toArray) {
                $mail->addAddress($toArray['email'], $toArray['name']);     //Add a recipient
            }
           
            $mail->addReplyTo($replyTo);
            
            foreach ($cc as $ccArray) {
                $mail->addCC($ccArray['email'], $ccArray['name']);
            }
            foreach ($bcc as $bccArray) {
                $mail->addBCC($bccArray['email'], $bccArray['name']);
            }
            foreach ($attachments as $key => $value) {
                $mail->addAttachment($value);         //Add attachments
            }
           
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody;

            if($mail->send()){
                return true;
            }
            else {
                return false;
            }
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
       
        return false;
    }
}
?>