<?php
session_start();
require_once("db_connect.php");

if (isset($_SESSION["username"])) {
    // User is already logged in, redirect to homepage or dashboard
    header("Location: homepage.php"); // Change this to the appropriate page
    exit();
}

if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($connect, trim($_POST["username"]));
    $password = trim($_POST["password"]);

    $query = "SELECT id, username, saltedpassword, salt, user_type FROM userlogin WHERE username = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $userId, $dbUsername, $dbSaltedPassword, $dbSalt, $userType);

    if (mysqli_stmt_fetch($stmt)) {
        // Verify the password
        if (password_verify($password . $dbSalt, $dbSaltedPassword)) {
            if ($userType === "admin") {
                // Admin login
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $username;
                header("Location: homepage.php");
                exit();
            } elseif ($userType === "student") {
                // Student login
                $_SESSION['student_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $userId;
                header("Location: homepage.php");
                exit();
            }
        } else {
            // Incorrect password
            echo '<script>alert("Incorrect Password")</script>';
        }
    } else {
        // User not found
        echo '<script>alert("User Not Found")</script>';
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST["register"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo '<script>alert("Fill all the Fields")</script>';
    } else {
        $username = mysqli_real_escape_string($connect, $_POST["username"]);
        $password = mysqli_real_escape_string($connect, $_POST["password"]);

        $salt = uniqid();
        $saltedPassword = $password . $salt;
        $hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

        $query = "INSERT INTO userlogin (username, saltedpassword, salt) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPassword, $salt);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("You have been registered")</script>';
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style/login.css">
<title>UNLAD DOLORES</title>
</head>
<body>
<header>
    <div class="header-content">
      <div class="header-left">
        <img src="images/unlad.png" alt="Logo 1" width="110" height="70">
        <img src="images/dolores.png" alt="Logo 2" width="80" height="70">
      </div>
      <div class="header-center">
        <h1>UNLAD DOLORES</h1>
      </div>
      <div class="header-right">
        <a class="button-home" href="landing_page.php">Home</a>
      </div>
    </div>
  </header>
  <section class="home-section">
  <img src="images/stars.png">
  <img src="images/mountains_back.png" alt="Mountains back" id="mountains_back">
    <div class="login-box">
        <form action="login.php" method="post"> 
            <div class="user-box">
                <input type="text" name="username" required>
                <label>Username:</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password:</label>
            </div>
            <label class="txt" for="rememberMe">Remember Me:</label>
            <input type="checkbox" name="rememberMe" id="rememberMe"><br>
            <input class="login" type="submit" name="login" value="Login">
        </form><br>
        <p class="txt">Don't have an account? <a href="registration.php">Register here</a></p>
        <p class="txt">Forgot Password? <a href="forgot_password.php">Forgot Password</a></p>
    <form>
    </div>
    </section>
</body>
</html>
