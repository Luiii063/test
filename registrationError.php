<!DOCTYPE html>
<html>
<head>
    <title>Scholarship Registration</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form action="registration.php" method="post" enctype="multipart/form-data">
        <label>Last Name:</label>
        <input type="text" name="lastName" required><br><br>
        <label>First Name:</label>
        <input type="text" name="firstName" required><br><br>
        <label>Middle Name:</label>
        <input type="text" name="middleName" required><br><br>
        <label>Email Address:</label>
        <input type="email" name="email" required><br><br>
        <label>Contact Number:</label>
        <input type="tel" name="contactNumber" required><br><br>
        <label>Upload Intent Letter (PDF or Image):</label>
        <input type="file" name="intentLetter" accept=".pdf, .jpg, .jpeg, .png" required><br><br>
        <label>
            <input type="checkbox" name="terms" required>
            I accept the <a href="terms_and_conditions.pdf" target="_blank">terms and conditions</a>.
        </label><br><br>
        <input type="submit" name="register" value="Register" onclick="this.disabled=true;this.form.submit();">

    </form>
    <a href="login.php">Already have an account? Login here</a>
</body>
</html>




<?php
require_once("db_connect.php");
session_start();

if (isset($_POST["register"])) {

    $lastName = mysqli_real_escape_string($connect, $_POST["lastName"]);
    $firstName = mysqli_real_escape_string($connect, $_POST["firstName"]);
    $middleName = mysqli_real_escape_string($connect, $_POST["middleName"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $contactNumber = mysqli_real_escape_string($connect, $_POST["contactNumber"]);
    $terms = isset($_POST["terms"]) ? 1 : 0;

    $allowedExtensions = [
        "pdf" => "application/pdf",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png"
    ];

    $extension = pathinfo($_FILES["intentLetter"]["name"], PATHINFO_EXTENSION);
    $intentLetterTmpName = $_FILES["intentLetter"]["tmp_name"];
    $intentLetterType = $_FILES["intentLetter"]["type"];

    if (isset($allowedExtensions[$extension])) {
        $intentLetterType = $allowedExtensions[$extension];

        $fileData = file_get_contents($intentLetterTmpName);

        $query = "INSERT INTO userdetails (lastName, firstName, middleName, emailAddress, contactNumber, intentLetterData, intentLetterType)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "sssssss", $lastName, $firstName, $middleName, $email, $contactNumber, $fileData, $intentLetterType);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Registration successful")</script>';
        } else {
            echo '<script>alert("Registration failed")</script>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo '<script>alert("Invalid file format for the intent letter. Please upload a PDF, JPG, JPEG, or PNG.")</script>';
    }
}
?>



<!-- registration.php 
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Last Name:</label>
        <input type="text" name="lastName" required><br><br>
        <label>First Name:</label>
        <input type="text" name="firstName" required><br><br>
        <label>Middle Name:</label>
        <input type="text" name="middleName" required><br><br>
        <label>Email Address:</label>
        <input type="email" name="emailAddress" required><br><br>
        <label>Contact Number:</label>
        <input type="text" name="contactNumber" required><br><br>
        <label>Intent Letter (PDF or Image):</label>
        <input type="file" name="intentLetter" accept=".pdf, .jpg, .jpeg, .png" required><br><br>
        <label>
            <input type="checkbox" name="termsAndConditions" required>
            I agree to the terms and conditions
        </label><br><br>
        <input type="submit" name="submitRegistration" value="Register">
    </form>
    <a href="login.php">Already have an account? Login here</a>
</body>
</html> -->

<?php
if (isset($_POST["submitRegistration"])) {
    // Handle registration form submission here
    // Make sure to validate and insert user details into the userDetails table
    // You will also need to handle file upload for the intent letter
}
?> 

