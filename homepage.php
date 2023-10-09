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

if (!isset($_SESSION["welcome_notification_displayed"])) {
    $_SESSION["welcome_notification_displayed"] = true;
    $displayWelcomeNotification = true;
} else {
    $displayWelcomeNotification = false;
}

$announcementText = "Welcome to our system!";
$dateTime = date("Y-m-d H:i:s");

if ($userType === "admin" && isset($_POST["edit_announcement"])) {
    $newAnnouncementText = $_POST["new_announcement_text"];
    updateAnnouncementText($newAnnouncementText);
    $announcementText = $newAnnouncementText;
}

function getAnnouncementText() {
    return "Welcome to our system!";
}

function updateAnnouncementText($text) {
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="style/homepage.css">
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
<div id="loader-container">
    <div class="spinner">
        <span>U</span>
        <span>N</span>
        <span>L</span>
        <span>A</span>
        <span>D</span>
        <span> </span>
        <span>D</span>
        <span>O</span>
        <span>L</span>
        <span>O</span>
        <span>R</span>
        <span>E</span>
        <span>S</span>
    </div>
</div>
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
<?php
if ($displayWelcomeNotification) {
    echo '
    <div id="notification-popup" class="notification-popup">
        <div class="popup-content">
            <h1>Welcome ' . ucfirst($userType) . '</h1>
            <h3>UNLAD DOLORES EDUCATIONAL ASSISTANCE</h3>
            <p>This is the official Unlad Dolores page for Educational Assistance</p>
            <button id="ok-button">OK</button>
        </div>
    </div>
    ';
}
?>
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
    <main>
        <div class="content">
            
            <section>

            </section>
        </div>
    </main>
    
    <aside class="sidebar-right">
    <div class="announcementcard card <?php echo ($userType === 'admin') ? 'admin' : ''; ?>">
        <h3>Announcements</h3>
        <p><?php echo htmlspecialchars($announcementText); ?></p>
        <div class="edit-form">
            <form method="post">
                <textarea name="new_announcement_text"><?php echo htmlspecialchars($announcementText); ?></textarea>
                <input type="submit" name="edit_announcement" value="Save">
            </form>
        </div>
    </div>
        <div class="updatescard card <?php echo ($userType === 'admin') ? 'admin' : ''; ?>">
            <h3>Updates</h3>
            <div class="edit-form">
                <form method="post">
                    <textarea name="new_updates_text">Initial updates text</textarea>
                    <input type="submit" name="edit_updates" value="Save">
                </form>
            </div>
            <div class="card-content">
                <p>Initial updates text.</p>
            </div>
        </div>
        <div class="date-timecard card">
            <h3>Date and Time</h3>
            <div class="card-content">
                <p><?php echo $dateTime; ?></p>
            </div>
        </div>
    </aside>
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
