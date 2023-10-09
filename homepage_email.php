<?php
session_start();
require_once("db_connect.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if (!isset($_SESSION["admin_logged_in"]) && !isset($_SESSION["student_logged_in"])) {
    header("Location: login.php"); 
    exit();
}

$defaultRecipientEmail = 'unladdolores@gmail.com'; 

if (isset($_POST["send_email"])) {
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'unladdolores@gmail.com'; // Your Gmail email address
        $mail->Password = 'vsjn rcyy jtgd bead'; // Your Gmail password or an app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS (SSL/TLS)
        $mail->Port = 465; // Port for SMTPS

        $mail->setFrom('unladdolores@gmail.com', 'UNLAD DOLORES'); // Your Gmail address and name

        if (isset($_SESSION["admin_logged_in"])) {
            $recipient_email = $_POST["recipient_email"];
        } elseif (isset($_SESSION["student_logged_in"])) {
            $recipient_email = $defaultRecipientEmail;
        }

        $mail->addAddress($recipient_email); // Recipient's email address

        $mail->isHTML(true);
        $mail->Subject = $_POST["email_subject"];
        $mail->Body = $_POST["email_message"];

        $mail->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo 'Error: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header-container {
            background-color: #0050a7;
            padding: 10px;
            text-align: center;
            margin-bottom:30px;
        }

        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-content h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        .orange {
  color: red;
}

.form-container {
    max-width: 700px;
            margin: 0 auto;
            background-color: #0050a7;
            padding: 30px;
            border-left: 5px solid #ff7a01;
            clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%);
        }

.heading {
  display: block;
  color: white;
  font-size: 1.5rem;
  font-weight: 800;
  margin-bottom: 20px;
}

.form {
  position: relative;
  display: flex;
  align-items: flex-start;
  flex-direction: column;
  margin: 0 auto; 
  gap: 10px;
  width: 700px;
  background-color: #0050a7;;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 30px 30px -30px rgba(27, 26, 26, 0.315);
}

.form  {
  color: royalblue;
  font-size: 30px;
  font-weight: 600;
  letter-spacing: -1px;
  line-height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form input {
  outline: 0;
  border: 1px solid rgb(219, 213, 213);
  padding: 8px 14px;
  border-radius: 8px;
  width: 100%;
  height: 50px;
}

.form textarea {
  border-radius: 8px;
  height: 100px;
  width: 100%;
  resize: none;
  outline: 0;
  padding: 8px 14px;
  border: 1px solid rgb(219, 213, 213);
}

button {
 font-size: 20px;
 padding: 0.5em 2em;
 border: transparent;
 box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
 background: dodgerblue;
 color: white;
 border-radius: 4px;
}

button:hover {
 background: rgb(2,0,36);
 background: linear-gradient(90deg, rgba(30,144,255,1) 0%, rgba(0,212,255,1) 100%);
}

button:active {
 transform: translate(0em, 0.2em);
}
.button {
 font-size: 15px;
 padding: 0.5em 2em;
 border: transparent;
 box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
 background: dodgerblue;
 color: white;
 border-radius: 4px;
}

.button:hover {
 background: rgb(2,0,36);
 background: linear-gradient(90deg, rgba(30,144,255,1) 0%, rgba(0,212,255,1) 100%);
}

.button:active {
 transform: translate(0em, 0.2em);
}
    </style>
</head>
<body>
<div class="header-container">
        <div class="header-content">
            <h2>Email Form</h2>
        </div>
    </div>
    <form class="form" action="homepage_email.php" method="post">
        <?php
        if (isset($_SESSION["admin_logged_in"])) {
            echo '<input type="email" id="recipient_email" name="recipient_email" placeholder="Recipient Email"  class="input" ><br><br>';
        }elseif (isset($_SESSION["student_logged_in"])){
            echo '<input type="email" id="recipient_email" name="recipient_email" placeholder="Recipient Email" value="' . $defaultRecipientEmail . '" class="input" readonly><br><br>';
        }

        ?>
        <input type="text" id="email_subject" name="email_subject" placeholder="Subject" required><br><br>
        <textarea id="email_message" name="email_message" rows="10" cols="30" placeholder="Message" required></textarea><br><br>
        <button type="submit" name="send_email" value="Send Email">Send Email</button>
        <?php
        if (isset($_SESSION["admin_logged_in"])) {
            echo '<a class="button" href="view_email.php" >View Emails</a>';
        }
        ?>
        <a class="button" href="homepage.php" >Home</a>
        
    </form>
    <br> 
</body>
</html>
