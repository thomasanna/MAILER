<?php
interface MailerLibrary {
    public function send(string $from, array $to, array $cc, array $bcc, string $subject, string $htmlBody, string $textBody, array $attachments, string $replyTo): bool;
}
?>