<?php
include "base.php";
include "vendor/autoload.php";

/* Session values */
$fromEmail = $_SESSION['witEmail'];
$fromName = $_SESSION['name'];

/* GET params */
$toEmail = $_GET['witEmail'];
$toName = $_GET['name'];
$date = $_GET['date'];
$fTime = $_GET['fTime'];
$tTime = $_GET['tTime'];
$reason = $_GET['reason'];

// Create a new PHPMailer instance
$mail = new PHPMailer;

// Tell PHPMailer to use SMTP
$mail->isSMTP();

// Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

// Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

// Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

// Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

// Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

// Whether to use SMTP authentication
$mail->SMTPAuth = true;

// Username to use for SMTP authentication - use full email address for gmail
$mail->Username = SMTP_USERNAME;

// Password to use for SMTP authentication
$mail->Password = SMTP_PASSWORD;

// Set who the message is to be sent from
$mail->setFrom(SMTP_USERNAME, SMTP_NAME);

// Set an alternative reply-to address
$mail->addReplyTo($fromEmail, $fromName);

// Set who the message is to be sent to
$mail->addAddress($toEmail, $toName);

// Set the subject line
$mail->Subject = 'ScheduleHub Appointment from ' . $fromName;

// Plain-text body
$mail->isHTML(false);
$mail->Body = "Hi " . htmlspecialchars($toName) . ",\n\n" . htmlspecialchars($fromName) . " would like you meet with you.\n\n"
    . "Date: " . htmlspecialchars($date) . "\n"
    . "Time: " . htmlspecialchars($fTime) . " - " . htmlspecialchars($tTime) . "\n"
    . "Reason: " . (!empty($reason) ? htmlspecialchars($reason) : "None specified.") . "\n\n"
    . "You can reply to this email to get in touch with them.";

// Send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Invitation sent!";
}
