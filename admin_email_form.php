<?php
session_start();
require_once("db_connect.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

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

$result = null;
$id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($id) {
    $query = "SELECT * FROM userdetails WHERE id = $id";
    $result = mysqli_query($connect, $query);

    if ($result === false) {
        die("Error: " . mysqli_error($connect));
    }
}

$email_sent = false;

if (isset($_POST["create_and_send_temp_credentials"])) {
    $id = isset($_GET["id"]) ? $_GET["id"] : null; 
    $query = "SELECT * FROM userdetails WHERE id = $id";
    $result = mysqli_query($connect, $query);

    if ($result === false) {
        die("Error: " . mysqli_error($connect));
    }

    $recipient_email = $_POST["recipient_email"];

    if (filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
        if ($row = mysqli_fetch_assoc($result)) {
            $first_name = $row["firstName"];
            $last_name = $row["lastName"];

            $temp_username = $first_name;
            $temp_password = $last_name;

            $insert_query = "INSERT INTO userlogin (username, saltedpassword, salt, user_type, emailAddress, fullName) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert_credentials = mysqli_prepare($connect, $insert_query);
            $salt = uniqid();
            $salted_temp_password = $temp_password . $salt;
            $hashed_temp_password = password_hash($salted_temp_password, PASSWORD_DEFAULT);
            $usertype = "student"; 

            // Add fullName here
            $full_name = $row["fullName"];

            mysqli_stmt_bind_param($stmt_insert_credentials, "ssssss", $temp_username, $hashed_temp_password, $salt, $usertype, $recipient_email, $full_name);

            if (mysqli_stmt_execute($stmt_insert_credentials)) {
                $subject = 'Temporary Credentials';
                $message = "Your temporary username: $temp_username\nYour temporary password: $temp_password";
            
                if (sendEmail($recipient_email, $subject, $message)) {
                    // Update the 'approved' column in userdetails to 1 since the email was sent successfully
                    $update_approval_query = "UPDATE userdetails SET approved = 1 WHERE id = ?";
                    $stmt_update_approval = mysqli_prepare($connect, $update_approval_query);
                    mysqli_stmt_bind_param($stmt_update_approval, "i", $id);
            
                    if (mysqli_stmt_execute($stmt_update_approval)) {
                        echo '<script>alert("Email sent successfully. User approved.")</script>';
                        echo '<script>setTimeout(function(){ window.location.href = "admin_dashboard.php"; }, 2000);</script>';
                exit();
                    } else {
                        echo '<script>alert("Error updating user approval status.")</script>';
                    }
            
                    mysqli_stmt_close($stmt_update_approval);
                } else {
                    echo '<script>alert("Error sending email.")</script>';
                }
            } else {
                echo '<script>alert("Error creating temporary credentials.")</script>';
            }
            
            mysqli_stmt_close($stmt_insert_credentials);
        } else {
            echo '<script>alert("User not found.")</script>';
        }
    } else {
        echo '<script>alert("Invalid recipient email address.")</script>';
    }
}
echo '<div id="notification" style="display:none;">';
echo 'Email sent successfully.';
echo '</div>';

if (isset($_POST["change_credentials"])) {
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];

    if ($_SESSION['student_logged_in']) {
        $user_id = $_SESSION['user_id'];

        $query = "SELECT salt FROM userlogin WHERE id = ?";
        $stmt_select_salt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt_select_salt, "i", $user_id);
        mysqli_stmt_execute($stmt_select_salt);
        mysqli_stmt_bind_result($stmt_select_salt, $user_salt);

        if (mysqli_stmt_fetch($stmt_select_salt)) {

            $salted_new_password = $new_password . $user_salt;
            $hashed_new_password = password_hash($salted_new_password, PASSWORD_DEFAULT);

            $update_query = "UPDATE userlogin SET username = ?, saltedpassword = ? WHERE id = ?";
            $stmt_update_credentials = mysqli_prepare($connect, $update_query);

            mysqli_stmt_bind_param($stmt_update_credentials, "ssi", $new_username, $hashed_new_password, $user_id);

            if (mysqli_stmt_execute($stmt_update_credentials)) {
                echo '<script>alert("Credentials updated successfully.")</script>';
            } else {
                echo '<script>alert("Error updating credentials.")</script>';
            }

            mysqli_stmt_close($stmt_update_credentials);
        } else {
            echo '<script>alert("Error retrieving user salt.")</script>';
        }

        mysqli_stmt_close($stmt_select_salt);
    } else {
        echo '<script>alert("You are not logged in as a student.")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Email Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
        #notification {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
        }

        #notification.show {
            display: block;
        }

        #notification.hide {
            display: none;
        }
    </style>
</head>
<body>

<h2>Send Email to Student</h2>

<form action="admin_email_form.php?id=<?php echo $id; ?>" method="post">
    <?php if ($result && $row = mysqli_fetch_assoc($result)): ?>
        <label for="recipient_email">Recipient's Email:</label>
        <input type="email" id="recipient_email" value="<?php echo $row["emailAddress"]; ?>" name="recipient_email" required><br><br>
        <label for="temp_username">Temporary Username:</label>
        <input type="text" id="temp_username" name="temp_username" value="<?php echo $row["firstName"]; ?>" required><br><br>
        <label for="temp_password">Temporary Password:</label>
        <input type="password" id="temp_password" name="temp_password" value="<?php echo $row["lastName"]; ?>" required><br><br>
        <input type="submit" name="create_and_send_temp_credentials" value="Send">
        <a href="admin_dashboard.php" class="back-button">Back</a>
    <?php endif; ?>
</form>
<?php if ($email_sent): ?>
<div id="notification">
    Email sent successfully.
</div>
<?php endif; ?>

</body>
</html>
<script>
<?php
if (isset($email_sent) && $email_sent === true) {
    echo 'document.getElementById("notification").classList.add("show");';
    echo 'setTimeout(function() {';
    echo '    document.getElementById("notification").classList.remove("show");';
    echo '}, 5000);'; // Hide the notification after 5 seconds (adjust as needed)
}
?>
</script>
