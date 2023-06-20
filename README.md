# MAILER
create a PHP 8 Mailer Class that should be easy to use within any existing project and send mails by creating a new instance of that class. 



//  In this implementation, I've introduced an interface MailerLibrary that defines a send method. 
//  This allows different email libraries to be easily integrated into the Mailer class. The PHPMailerLibrary,
//  SendGridLibrary, and MailgunLibrary classes implement the MailerLibrary interface and
//   provide the necessary logic to send emails using their respective libraries.

//  The Mailer class accepts an instance of the desired email library through its constructor,
//  allowing for easy integration of different libraries. The class provides public methods to
//   set the email's sender, recipients, CC and BCC recipients, attachments, reply-to address, 
//   HTML and text versions of the email body. The send method sends the email using the specified library.

// // To use the Mailer class, you can create an instance with the desired library as a parameter,
//  and then use its methods to set the necessary information before sending the email. 


// The Mailer class can be easily extended to include additional libraries by creating 
//new classes that implement the MailerLibrary interface and providing their respective email sending logic.

Note : Add credentials for API to the library's corresponding config file
