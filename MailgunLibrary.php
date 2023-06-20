<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;
class MailgunLibrary implements MailerLibrary {

    public function send(string $from, array $to, array $cc, array $bcc, string $subject, string $htmlBody, string $textBody, array $attachments,string $replyTo): bool {
        
        require 'mailgunLibraryConfig.php';
        $mailgun = Mailgun::create($MAILGUN_API);

        $domain = $MAILGUN_DOMAIN;
        
        $toRecipients = [];
        $ccRecipients = [];
        $bccRecipients = [];
        $files   = [];
        foreach ($to as $toArray) {
            $toRecipients[] = $toArray['name'] .' ' .$toArray['email'];
        }
        foreach ($cc as $ccArray) {
            $ccRecipients[] = $ccArray['name'] .' ' .$ccArray['email'];
        }
        foreach ($bcc as $bccArray) {
            $bccRecipients[]  =  $bccArray['name'] .' ' .$bccArray['email'];
        }
        foreach ($attachments as $key => $value) {
            $files[]['filePath'] =  $value;
        }
        // Send the email
        $result = $mailgun->messages()->send($domain, [
            'from'    => $from,
            'to'      => $toRecipients,
            'cc'      => $ccRecipients,
            'bcc'     => $bccRecipients,
            'subject' => $subject,
            'text'    => $textBody,
            'html'    => $htmlBody,
            'attachment' => $files,
            'h:Reply-To' => $replyTo
        ]);

        // Check the result
        if ($result) {
           return true;
        } else {
            return false;
        }

         
    }
}
?>