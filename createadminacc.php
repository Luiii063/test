<?php
require_once("db_connect.php"); // Make sure to include your database connection script

$username = "admin"; // Set the username for the admin account
$password = "admin"; // Set the password for the admin account

// Generate a unique salt for the admin account
$salt = uniqid();

// Combine the password and salt and hash them
$saltedPassword = $password . $salt;
$hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

// Define the user type as "admin"
$userType = "admin";

// Prepare and execute the SQL query to insert the admin account
$query = "INSERT INTO userlogin (username, saltedpassword, salt, user_type) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPassword, $salt, $userType);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin account has been added successfully.";
} else {
    echo "Error: " . mysqli_error($connect);
}

mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connect);
?>
