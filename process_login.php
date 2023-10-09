<?php
session_start();
require_once("db_connect.php");

if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($connect, trim($_POST["username"]));
    $password = trim($_POST["password"]);

    if ($username === "admin" && $password === "admin") {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: homepage.php");
        exit();
    } else {
        $query = "SELECT id, username, saltedpassword, salt FROM userlogin WHERE username = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId, $dbUsername, $dbSaltedPassword, $dbSalt);

        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password . $dbSalt, $dbSaltedPassword)) { 
                $_SESSION['student_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $userId;
                header("Location: homepage.php");
                exit();
            } else {
                echo '<script>alert("Wrong User Details: Passwords do not match")</script>';
            }
        } else {
            echo '<script>alert("Wrong User Details: User not found")</script>';
        }
        
        mysqli_stmt_close($stmt);
    }
}
?>
