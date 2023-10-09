<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) && !isset($_SESSION["student_logged_in"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["admin_logged_in"])) {
    $userType = "admin";
} elseif (isset($_SESSION["student_logged_in"])) {
    $userType = "student";
}

require_once("db_connect.php");

$query = "SELECT fullName, user_type FROM userlogin";

$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="style/userdashboard.css">
<style>
        body{
        background-image: url("images/th.jpg");
    }
    <?php if ($userType === "admin"): ?>
        .card.admin:hover .edit-form {
            display: block;
        }
        <?php endif; ?>
      
</style>
</head>
<body>
<header>
<div class="headerww">
    <div class="header-left">
        <button class="toggle-sidebar-btn" onmouseover="showSidebar()">☰</button>
        <img src="images/unlad.png" alt="Logo" width="80" height="80">
        <span class="unlad">UNLAD DOLORES</span>
    </div>
    <div class="header-icons">
    <a href="homepage_email.php" title="Send Email"><i class="far fa-envelope"></i></a>
    <a href="#" title="Notifications"><i class="far fa-bell"></i></a>
    <a href="#" title="Profile"><i class="far fa-user"></i></a>
    <a href="#" title="Settings"><i class="fas fa-cog"></i></a>
    </div>
</div>
</header>
<div class="navbar">
    <button>Announcement</button>
    <div class="dropdown">
        <button>Help</button>
        <div class="dropdown-content">
            <a href="#">FAQ</a>
            <a href="#">Contact Us</a>
        </div>
    </div>
</div>

<div class="sidebar" onmouseleave="hideSidebar()">
    <a href="homepage.php">Home</a>
    <?php
    if ($userType === "admin") {
        echo '<a href="admin_dashboard.php">Manage Users</a>';
    } elseif ($userType === "student") {
        echo '<a href="view_assignment.php">View Assignments</a>';
        echo '<a href="submit_assignment.php">Submit Assignment</a>';
    }
    ?>
    <a href="user_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>
<div class="main-container">
<table>
    <tr>
        <th>Full Name</th>
        <th>Role</th> 
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row["fullName"]; ?></td>
            <td><?php echo $row["user_type"]; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</div>
<footer>
    <p>&copy; <?php echo date("Y"); ?> UNLAD DOLORES</p>
</footer>
<script>
    function showSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.left = '0';
    }

    function hideSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.left = '-250px';
    }
document.addEventListener("DOMContentLoaded", function () {
    const notificationPopup = document.getElementById("notification-popup");
    const okButton = document.getElementById("ok-button");

    const userIsLoggedIn = true; 
    if (userIsLoggedIn) {
        notificationPopup.style.display = "flex";
    }

    okButton.addEventListener("click", function () {
        notificationPopup.style.display = "none";
    });
});


function toggleEditMode(cardId) {
        const card = document.querySelector(`.${cardId}`);
        card.classList.toggle('edit-mode');

        const editButton = card.querySelector('.edit-button');
        const editForm = card.querySelector('.edit-form');

        if (card.classList.contains('edit-mode')) {
            editButton.style.display = 'none';
            editForm.style.display = 'block';
        } else {
            editButton.style.display = 'inline-block';
            editForm.style.display = 'none';
        }
    }
</script>
<script>
    // Function to change the color of a span after animation is complete
    function changeSpanColor(span) {
        span.style.color = ""; // Change the color to your desired color
    }

    // Function to handle the animation end event
    function handleAnimationEnd(event) {
        if (event.animationName === "loading6454") {
            // Change the color of the span when the animation ends
            changeSpanColor(event.target);
        }
    }

    // Add an animationend event listener to each span
    const spinnerSpans = document.querySelectorAll(".spinner span");
    spinnerSpans.forEach((span) => {
        span.addEventListener("animationend", handleAnimationEnd);
    });

    // Simulate a 4-second delay (adjust the delay as needed)
    setTimeout(function () {
        // Hide the loader container after the delay
        const loaderContainer = document.getElementById("loader-container");
        loaderContainer.style.display = "none";
    }, 2000); // 4000 milliseconds (4 seconds)
</script>
</body>
</html>
