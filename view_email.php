<?php
session_start();
require_once("db_connect.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if (isset($_POST["send_email"])) {
    try {
        // Your email sending code here...
    } catch (Exception $e) {
        echo 'Error: ' . $mail->ErrorInfo;
    }
}

// Define your IMAP credentials
$imap_username = 'unladdolores@gmail.com'; // Your Gmail email address
$imap_password = 'vsjn rcyy jtgd bead'; // Your Gmail password or app-specific password

// Connect to Gmail IMAP server
$inbox = imap_open("{imap.gmail.com:993/ssl}INBOX", $imap_username, $imap_password) or die('Cannot connect to mailbox: ' . imap_last_error());

// Get the number of emails in the inbox
$num_emails = imap_num_msg($inbox);

echo '<table border="1">';
echo '<tr><th>From</th><th>Subject</th><th>Date</th><th>Action</th></tr>';

// Loop through each email and display subject and sender
for ($i = 1; $i <= $num_emails; $i++) {
    $header = imap_headerinfo($inbox, $i);
    $from = $header->from[0]->mailbox . "@" . $header->from[0]->host;
    $date = date("Y-m-d H:i:s", strtotime($header->date));
    
    // Check if the 'subject' property is defined
    if (isset($header->subject)) {
        $subject = $header->subject;
    } else {
        $subject = '(No Subject)';
    }
    
    echo '<tr>';
    echo '<td>' . $from . '</td>';
    echo '<td>' . $subject . '</td>';
    echo '<td>' . $date . '</td>';
    echo '<td><a href="view_email.php?id=' . $i . '">View Email</a></td>';
    echo '</tr>';
}


echo '</table>';

// Close the IMAP connection
imap_close($inbox);
?>
