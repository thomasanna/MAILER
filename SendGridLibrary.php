<?php
require 'vendor/autoload.php';
use SendGrid\Mail\Mail;

class SendGridLibrary implements MailerLibrary {
    public function send(string $from, array $to, array $cc, array $bcc, string $subject, string $htmlBody, string $textBody, array $attachments,string $replyTo): bool {
        require 'sendGridLibraryConfig.php';
        // Set your SendGrid API key
        $apiKey = $SENDGRID_API_KEY;
       
        // Create a new SendGrid email instance
        $mail = new Mail();
        $mail->setFrom($from);

        // Add "To" recipients
        
        foreach ($to as $toArray) {
            $mail->addTo($toArray['email'], $toArray['name']);   
        }
        // Add "Cc" recipients
        foreach ($cc as $ccArray) {
            $mail->addCC($ccArray['email'], $ccArray['name']);
        }
        // Add "Bcc" recipients
        foreach ($bcc as $bccArray) {
            $mail->addBCC($bccArray['email'], $bccArray['name']);
        }

        $mail->setSubject($subject);
        $mail->addContent("text/plain", $textBody);
        $mail->addContent("text/html", $htmlBody);

        foreach ($attachments as $key => $value) {
            $fileType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $value);
            $fileName = basename($value);
            $mail->addAttachment($value,$fileType,$fileName,'attachment');         //Add attachments
        }

        // Set the Reply-To address
        $mail->setReplyTo($replyTo);


        // Initialize SendGrid
        $sendgrid = new \SendGrid($apiKey);
        
        // Send the email
        try {
            $response = $sendgrid->send($mail);
            if ($response->statusCode() === 202) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'An error occurred while sending the email: ' . $e->getMessage();
        }

        return false;
    }
}

?>