<?php
require_once("db_connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST["reset_password"])) {
    $token = $_POST["token"];
    $newPassword = $_POST["new_password"];

    // Validate the new password (you can add more validation rules)
    if (strlen($newPassword) < 6) {
        echo 'Password must be at least 6 characters long.';
        exit;
    }

    $query = "SELECT username FROM password_reset WHERE token = ? AND expiration_time > NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);
    $result = $stmt->fetch();

    if ($result) {
        $email = $result["username"];

        
    // Debugging: Print out the email and token
    echo 'Email: ' . $email . '<br>';
    echo 'Token: ' . $token . '<br>';

        $newPassword = $_POST['new_password'];
        $salt = bin2hex(random_bytes(16));
        $hashedPassword = password_hash($newPassword . $salt, PASSWORD_DEFAULT);
        
        $query = "UPDATE userlogin SET saltedpassword = ?, salt = ? WHERE username = ?";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([$hashedPassword, $salt, $email])) {
            // Password updated successfully
            // Delete the used token from the password_reset table
            $deleteQuery = "DELETE FROM password_reset WHERE token = ?";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute([$token]);

            echo 'Password reset successful. You can now log in with your new password.';
        } else {
            echo 'Error updating password. Please try again later.';
        }
    } else {
        echo 'Invalid or expired token.';
    }
}
?>
