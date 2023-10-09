<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($recipientEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'unladdolores@gmail.com'; // Your Gmail email address
        $mail->Password = 'vsjn rcyy jtgd bead'; // Your Gmail password or an app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS (SSL/TLS)
        $mail->Port = 465; // Port for SMTPS

        $mail->setFrom('unladdolores@gmail.com', 'UNLAD DOLORES'); // Your Gmail address and name
        $mail->addAddress($recipientEmail); // Recipient's email address

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$recipientEmail = 'unladdolores@gmail.com';
$subject = 'Test Email';
$message = 'This is a test email sent via Gmail SMTP.';
$errorInfo = sendEmail($recipientEmail, $subject, $message);



?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Status</title>
</head>
<body>
    <h2>Email Status</h2>

    <?php
  try {
    echo "Email sent!";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    ?>
    <a href="view_sent_emails.php">View Sent Emails</a>
    <a href="admin_dashboard.php">Back</a>
</body>
</html>