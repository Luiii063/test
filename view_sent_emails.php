<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function getSentEmails() {
    // Replace with your database connection code
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "scholarsystem";

    // Create a database connection
    $connect = mysqli_connect($host, $username, $password, $database);

    // Check if the connection is successful
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Define your SQL query to retrieve sent emails
    $sql = "SELECT * FROM sent_emails";

    // Execute the query
    $result = $connect->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $sentEmails = array();

        // Fetch the results and store them in an array
        while ($row = $result->fetch_assoc()) {
            $sentEmails[] = $row;
        }

        // Close the database connection
        $connect->close();

        return $sentEmails;
    } else {
        // No emails found, return an empty array
        $connect->close();
        return array();
    }
}

$sentEmails = getSentEmails();

// Function to send an email
function sendEmail($recipientEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.yahoo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'luigimiguelamat@yahoo.com'; // Your Yahoo email address
        $mail->Password = 'AmatLuigiMiguelMay062002'; // Your Yahoo password
        $mail->SMTPSecure = 'ssl'; // Use 'ssl' for SSL encryption
        $mail->Port = 465; // Port for SSL

        // Recipients
        $mail->setFrom('luigimiguelamat@yahoo.com', 'Luigi Miguel Amat'); // Your email and name
        $mail->addAddress($recipientEmail); // Recipient's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Example usage to send an email
$recipientEmail = 'recipient@example.com';
$subject = 'Test Email';
$message = 'This is a test email sent via Yahoo Mail SMTP.';
$errorInfo = sendEmail($recipientEmail, $subject, $message);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sent Emails</title>
</head>
<body>
    <h2>View Sent Emails</h2>

    <?php
    if (empty($sentEmails)) {

        echo '<p>No sent emails found.</p>';
    } else {

        echo '<table border="1">
                <tr>
                    <th>Recipient</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent Date</th>
                </tr>';

        foreach ($sentEmails as $email) {
            echo '<tr>';
            echo '<td>' . $email['recipient'] . '</td>';
            echo '<td>' . $email['subject'] . '</td>';
            echo '<td>' . $email['message'] . '</td>';
            echo '<td>' . $email['sent_date'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
    ?>
    <a href="admin_dashboard.php">Back</a>
</body>
</html>