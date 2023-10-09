<?php
require_once("db_connect.php");

if (isset($_GET["user_id"])) {
    $userId = $_GET["user_id"];

    $query = "SELECT intentLetterData, intentLetterType FROM userdetails WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $intentLetterData, $intentLetterType);

    if (mysqli_stmt_fetch($stmt)) {
        header("Content-Type: $intentLetterType");

        echo $intentLetterData;
    } else {
        echo "Image not found";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid user ID";
}

mysqli_close($connect);
?>
