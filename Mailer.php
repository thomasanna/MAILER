<?php
require_once 'MailerLibrary.php';

class Mailer {
    private MailerLibrary $library;
    private string $from;
    private array $to = [];
    private array $cc = [];
    private array $bcc = [];
    private array $attachments = [];
    private string $replyTo;
    private string $htmlBody;
    private string $textBody;
    private string $subject;

    public function __construct(MailerLibrary $library) {
        $this->library = $library;
    }

    public function setFrom(string $from): void {
        $this->from = $from;
    }

    public function addTo(array $recipients): void {
        foreach ($recipients as $email => $name) {
            $this->to[] = ['email' => $email, 'name' => $name];
        }
        
    }

    public function addCc(array $recipients): void {
        foreach ($recipients as $email => $name) {
            $this->cc[] = ['email' => $email, 'name' => $name];
        }
    }

    public function addBcc(array $recipients): void {
        foreach ($recipients as $email => $name) {
            $this->bcc[] = ['email' => $email, 'name' => $name];
        }
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
    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function validate(): bool { 
        if(empty($this->library) || empty($this->from) || empty($this->to) || empty($this->subject) || (empty($this->textBody) && empty($this->htmlBody))){
            return false;
        }
        else{
            return true;
        } 
       
    }

    public function send(): bool {
        if (!$this->validate()) {
            return false;
        }

        // Call the send method of the specified library
        return $this->library->send(
            $this->from,
            $this->to,
            $this->cc,
            $this->bcc,
            $this->subject,
            $this->htmlBody,
            $this->textBody,
            $this->attachments,
            $this->replyTo
        );
    }
}


?>
