<?php
require_once("db_connect.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    // Check if the username exists in your userlogin table
    // Fetch the user's email address associated with the username

    // Replace 'your_db_query_here' with your actual database query to retrieve the email address
    $query = "SELECT emailAddress FROM userlogin WHERE username = ?";
    
    // Assuming you are using PDO for database operations
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result["emailAddress"])) {
        $studentExists = true; // Define the variable as true if the student exists
        $studentEmail = $result["emailAddress"];

        // Generate a unique token
        $token = generateUniqueToken();

       if ($token) { // Check if the token was generated successfully
    // Calculate token expiration time (e.g., 2 hours from now)
    $expirationTime = date('Y-m-d H:i:s', strtotime('+2 hours'));

    // Store the token and expiration time in the password_reset table
    $query = "INSERT INTO password_reset (username, token, expiration_time) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $token, $expirationTime]);

            // Compose the password reset email
            $resetLink = "http://localhost/ScholarSystemTest/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Dear student,\n\n";
            $message .= "You have requested to reset your password. ";
            $message .= "To reset your password, please click the following link:\n";
            $message .= "$resetLink\n\n";
            $message .= "If you didn't request this, you can ignore this email.\n";
            $message .= "Best regards,\nYour School";

            // Send the email
            if (sendEmail($studentEmail, $subject, $message)) {
                // Redirect the student to a confirmation page
                header("Location: password_reset_sent.php");
                exit();
            } else {
                echo 'Error sending email.';
            }
        } else {
            echo 'Error generating the token.';
        }
    } else {
        $studentExists = false; // Define the variable as false if the student doesn't exist
        // Username not found, show an error message or redirect to an error page
    }
}

// Function to send an email (you can reuse your existing sendEmail function)
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

        $mail->setFrom('unladdolores@gmail.com', 'Unlad Dolores'); // Your Gmail address and name
        $mail->addAddress($recipientEmail); // Recipient's email address

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

// Function to generate a unique token (you can use a library like random_bytes)
function generateUniqueToken() {
    // Generate a unique token and return it
    // For example, you can use random_bytes and bin2hex to generate a token
    return bin2hex(random_bytes(16));
}
?>
