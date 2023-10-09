<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: homepage.php");
    exit();
}

require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    $delete_query = "DELETE FROM userdetails WHERE id = ?";
    $stmt_delete = mysqli_prepare($connect, $delete_query);
    mysqli_stmt_bind_param($stmt_delete, "i", $user_id);

    if (mysqli_stmt_execute($stmt_delete)) {
        echo '<script>alert("Registration deleted successfully.");</script>';
    } else {
        echo '<script>alert("Error deleting registration: ' . mysqli_error($connect) . '");</script>';
    }

    mysqli_stmt_close($stmt_delete);
}

mysqli_close($connect);
header("Location: admin_dashboard.php");
exit();
?>
