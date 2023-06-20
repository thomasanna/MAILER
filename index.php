
<?php

require 'Mailer.php';
// PHPMailer //
require 'PHPMailerLibrary.php';
$phpMailer = new PHPMailerLibrary();

// require 'MailgunLibrary.php'; // For Mailgun
// $phpMailer = new MailgunLibrary();

// require 'SendGridLibrary.php'; // For SendGridLibrary
// $phpMailer = new SendGridLibrary();

$mailer = new Mailer($phpMailer);

$mailer->setFrom('sender@example.com');
$mailer->addTo(['teenuthomas12@gmail.com' => 'Teenu Thomas', 'teenutc12@gmail.com' => 'Thomas Teenu']);
$mailer->addCc(['teenuthomas12@gmail.com' => 'Thomas Sebastian']);
$mailer->addBcc(['teenutc12@gmail.com' => 'BCC Recipient']);
$mailer->addAttachment('c:\Users\hp\Pictures\images.jfif');
$mailer->setReplyTo('replyto@example.com');
$mailer->setHTMLBody('<html><body><h1>Hello!</h1></body></html>');
$mailer->setTextBody('Hello! This is the text version of the email.');
$mailer->setSubject('Test Subject');

if ($mailer->send()) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}

?>