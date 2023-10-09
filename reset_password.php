<?php
require_once("db_connect.php");

if (isset($_POST["reset_password"])) {
    $token = $_POST["token"];
    $newPassword = $_POST["new_password"];

    // Validate the new password (you can add more validation rules)
    if (strlen($newPassword) < 6) {
        echo 'Password must be at least 6 characters long.';
        exit;
    }

    // Check if the token exists and is not expired
    $query = "SELECT username FROM password_reset WHERE token = ? AND expiration_time > NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $username = $result["username"];

        // Generate a new salt
        $salt = bin2hex(random_bytes(16));

        // Hash the new password with the salt
        $hashedPassword = password_hash($newPassword . $salt, PASSWORD_DEFAULT);

        // Update the user's password
        $query = "UPDATE userlogin SET saltedpassword = ?, salt = ? WHERE username = ?";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute([$hashedPassword, $salt, $username])) {
            // Password update successful
            // Delete the used token from the password_reset table
            $query = "DELETE FROM password_reset WHERE token = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$token]);

            echo 'Password reset successful. You can now log in with your new password.';
        } else {
            echo 'Error updating password. Please try again later.';
        }
    } else {
        echo 'Invalid or expired token.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="update_password.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token = $_GET['token']; ?>">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</body>
</html>