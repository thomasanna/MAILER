<?php

class Mailer {
    private string $from;
    private array $to = [];
    private array $cc = [];
    private array $bcc = [];
    private array $attachments = [];
    private string $replyTo;
    private string $htmlBody;
    private string $textBody;

    public function setFrom(string $from): void {
        $this->from = $from;
    }

    public function addTo(string $email, string $name = ''): void {
        $this->to[] = ['email' => $email, 'name' => $name];
    }

    public function addCc(string $email, string $name = ''): void {
        $this->cc[] = ['email' => $email, 'name' => $name];
    }

    public function addBcc(string $email, string $name = ''): void {
        $this->bcc[] = ['email' => $email, 'name' => $name];
    }

    public function addAttachment(string $filePath): void {
        $this->attachments[] = $filePath;
    }

    public function setReplyTo(string $replyTo): void {
        $this->replyTo = $replyTo;
    }

    public function setHTMLBody(string $htmlBody): void {
        $this->htmlBody = $htmlBody;
    }

    public function setTextBody(string $textBody): void {
        $this->textBody = $textBody;
    }

    public function validate(): bool {
        // Implement your validation logic here
        // You can check if required fields are set, email addresses are valid, etc.
        // Return true if the validation is successful, otherwise return false
        // You can customize the validation rules as per your requirements
        // For simplicity, let's assume the validation always succeeds
        return true;
    }

    public function send(): bool {
        if (!$this->validate()) {
            return false;
        }

        // Implement your email sending logic here using the information provided
        // You can use PHP's built-in mail() function or any third-party libraries for sending emails
        // Return true if the email is sent successfully, otherwise return false

        // Example using PHP's built-in mail() function
        $to = $this->formatEmails($this->to);
        $cc = $this->formatEmails($this->cc);
        $bcc = $this->formatEmails($this->bcc);

        $headers = "From: {$this->from}\r\n";
        if (!empty($cc)) {
            $headers .= "Cc: {$cc}\r\n";
        }
        if (!empty($bcc)) {
            $headers .= "Bcc: {$bcc}\r\n";
        }
        if (!empty($this->replyTo)) {
            $headers .= "Reply-To: {$this->replyTo}\r\n";
        }
        $headers .= "MIME-Version: 1.0\r\n";
        $boundary = uniqid('np');
        $headers .= "Content-Type: multipart/mixed;boundary=" . $boundary . "\r\n";
        $message = "";

        if (!empty($this->textBody)) {
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: text/plain;charset=utf-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
            $message .= $this->textBody . "\r\n";
        }

        if (!empty($this->htmlBody)) {
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: text/html;charset=utf-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
            $message .= $this->htmlBody . "\r\n";
        }

        foreach ($this->attachments as $attachment) {
            if (file_exists($attachment)) {
                $message .= "--{$boundary}\r\n";
                $message .= "Content-Type: application/octet-stream\r\n";
                $message .= "Content-Transfer-Encoding: base64\r\n";
                $message .= "Content-Disposition: attachment; filename=\"" . basename($attachment) . "\"\r\n\r\n";
                $message .= chunk_split(base64_encode(file_get_contents($attachment))) . "\r\n";
            }
        }

        $message .= "--{$boundary}--";

        return mail($to, '', $message, $headers);
    }

    private function formatEmails(array $emails): string {
        $formattedEmails = [];
        foreach ($emails as $email) {
            if (!empty($email['name'])) {
                $formattedEmails[] = "{$email['name']} <{$email['email']}>";
            } else {
                $formattedEmails[] = $email['email'];
            }
        }
        return implode(', ', $formattedEmails);
    }
}



$mailer = new Mailer();

$mailer->setFrom('sender@example.com');
$mailer->addTo('recipient1@example.com', 'Recipient 1');
$mailer->addTo('recipient2@example.com', 'Recipient 2');
$mailer->addCc('cc@example.com', 'CC Recipient');
$mailer->addBcc('bcc@example.com');
$mailer->addAttachment('/path/to/file1.pdf');
$mailer->addAttachment('/path/to/file2.jpg');
$mailer->setReplyTo('replyto@example.com');
$mailer->setHTMLBody('<html><body><h1>Hello!</h1></body></html>');
$mailer->setTextBody('Hello! This is the text version of the email.');

if ($mailer->send()) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}


?>
