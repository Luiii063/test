<?php
session_start();
require_once("db_connect.php");

date_default_timezone_set('Asia/Manila');

if (isset($_SESSION["username"])) {
    header("Location: homepage.php");
    exit();
}

if (isset($_POST["register"])) {
    $lastName = mysqli_real_escape_string($connect, $_POST["lastName"]);
    $firstName = mysqli_real_escape_string($connect, $_POST["firstName"]);
    $middleName = mysqli_real_escape_string($connect, $_POST["middleName"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $contactNumber = mysqli_real_escape_string($connect, $_POST["contactNumber"]);
    

    $check_email_query = "SELECT id FROM userdetails WHERE emailAddress = ?";
    $stmt_check_email = mysqli_prepare($connect, $check_email_query);
    mysqli_stmt_bind_param($stmt_check_email, "s", $email);
    mysqli_stmt_execute($stmt_check_email);
    mysqli_stmt_store_result($stmt_check_email);

    if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
        echo '<script>alert("Email address is already registered.");</script>';
    } else {
   
        $temp_username = $firstName;
        $temp_password = $lastName;

        $salt = uniqid();
        $salted_temp_password = $temp_password . $salt;
        $hashed_temp_password = password_hash($salted_temp_password, PASSWORD_DEFAULT);

        $submissionDate = date("Y-m-d h:i:s A");

        $insert_query = "INSERT INTO userdetails (lastName, firstName, middleName, emailAddress, contactNumber, intentLetterType, intentLetterData, file_unique_name, submissionDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = mysqli_prepare($connect, $insert_query);
        mysqli_stmt_bind_param($stmt_insert_user, "sssssssss", $lastName, $firstName, $middleName, $email, $contactNumber, $intentLetterType, $intentLetterData, $fileUniqueName, $submissionDate);

        if (mysqli_stmt_execute($stmt_insert_user)) {
            $insert_login_query = "INSERT INTO userlogin (username, saltedpassword, salt) VALUES (?, ?, ?)";
            $stmt_insert_login = mysqli_prepare($connect, $insert_login_query);
            mysqli_stmt_bind_param($stmt_insert_login, "sss", $temp_username, $hashed_temp_password, $salt);

            if (mysqli_stmt_execute($stmt_insert_login)) {
                echo '<script>alert("Registration complete! You can now log in.");</script>';
                echo '<script>setTimeout(function(){ window.location.href = "homepage.php"; }, 2000);</script>';
                exit();
            } else {
                echo '<script>alert("Error creating login credentials.");</script>';
            }

            mysqli_stmt_close($stmt_insert_login);
        } else {
            echo '<script>alert("Error registering user details.");</script>';
        }

        mysqli_stmt_close($stmt_insert_user);
    }

    mysqli_stmt_close($stmt_check_email);
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/registration.css">
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
    <h2 style="color:white;text-align: center;">Registration Form</h2>
    <form class="form" action="registration.php" method="post" enctype="multipart/form-data">
    <div class="user-box">       
        <input type="text" name="lastName" required>
        <label>Last Name:</label>
        </div>
        <div class="user-box">
        <input type="text" name="firstName" required>
        <label>First Name:</label>
        </div>
        <div class="user-box">
        <input type="text" name="middleName" required>
        <label>Middle Name:</label>
        </div>
        <div class="user-box">
        <input type="email" name="email" required>
        <label>Email Address:</label>
        </div>
        <div class="user-box">
        <input type="tel" name="contactNumber" required>
        <label>Contact Number:</label>
        </div>
        <label class="txt">Upload Intent Letter (PDF or Image):</label><br>
        <input type="file" name="intentLetter" accept=".pdf, .jpg, .jpeg, .png" required>
        
        <label>
        <br><input type="checkbox" name="terms" required>
            I accept the <a href="termsandcondition.php" target="_blank">terms and conditions</a>.
        </label><br>
        <input class="login "type="submit" name="register" value="Register">
        <span></span>
    </form>
    <p>Already have an account?<a href="login.php"> Login here</a></p>
</div>
</section>
</body>
</html>
