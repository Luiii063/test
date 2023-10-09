<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: homepage.php");
    exit();
}

if (isset($_SESSION["admin_logged_in"])) {
    $userType = "admin";
}
require_once("db_connect.php");

$query = "SELECT *, DATE_FORMAT(submissionDate, '%Y-%m-%d') AS formattedDate FROM userdetails ORDER BY submissionDate DESC";


$result = mysqli_query($connect, $query);

if (isset($_POST["approve"])) {
    foreach ($_POST["approve"] as $student_id) {

        $temp_username = "temp_" . uniqid();
        $temp_password = password_hash(uniqid(), PASSWORD_DEFAULT);
        if (sendTemporaryCredentialsEmail($temp_username, $temp_password, $student_id)) {
            $update_query = "UPDATE userdetails SET approved = 1 WHERE id = ?";
            $update_stmt = mysqli_prepare($connect, $update_query);
            mysqli_stmt_bind_param($update_stmt, "i", $student_id);

            if (mysqli_stmt_execute($update_stmt)) {
                echo '<script>alert("Student approved successfully.");</script>';
            } else {
                echo '<script>alert("Error updating approval status: ' . mysqli_error($connect) . '");</script>';
            }

            mysqli_stmt_close($update_stmt);
        } else {
            echo '<script>alert("Error sending email to student.");</script>';
        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            background-image: url("images/th.jpg");
    background-repeat: no-repeat;
    background-position: bottom;
    background-attachment: fixed;
  background-size: cover;
    margin: 0 50px;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 120vh;
    
}
        header {
    color: #fff;
    padding: 25px 250px; 
    display: flex;
    justify-content: space-between;
    align-items: center;
}
header h2{
    text-align: center;
    color: black;
    font-size: 30px;
}
table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    
}

th, td {

    padding: 8px;
    font-size: 20px;
    font-weight: bold;
    
}

th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #00379e;
    color: white;
}

        .approve-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
        }

        .approve-button:hover {
            background-color: #45a049;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        .home-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        .home-button:hover {
            background-color: #0056b3;
        }

        .view-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
        }

        .view-button:hover {
            background-color: #0056b3;
        }
        .approved {
            background-color: green;
            color: white;
            padding: 3px 5px;
            border-radius: 3px;
        }
        .approvedStudent {
            background-color: #4CAF50;
            color: white;
            padding: 3px 5px;
            border-radius: 3px;
        }
        .not-approved {
        background-color: red;
        color: white;
        padding: 3px 5px;
        border-radius: 3px;
    }
    .delete-button {
        background-color: red;
        color: #fff;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
    }
    .delete-button:hover {
        background-color: darkred;
    }
    .sidebar {
    width: 250px;
    background-color: #0066ff;
    height: 100%;
    position: fixed;
    top: 0;
    left: -250px; /* Hide the sidebar by default */
    transition: left 1s; /* Add smooth transition effect */
    overflow-x: hidden;
    padding-top: 20px;
}

.sidebar a {
    padding: 10px 15px;
    text-align: left;
    text-decoration: none;
    font-size: 18px;
    color: white;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #0050a7;
}

/* Style for the button that shows/hides the sidebar */
.toggle-sidebar-btn {
    align-self: center;
margin-right: 10px;
font-size: 30px;
    color: black;
    padding: 30px 10px;
    text-align: center;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    background: transparent;
    height: 135px;
}

.toggle-sidebar-btn:hover {
    background-color: #463c3c;
}
    </style>
</head>
<body>
    <header>
    <button class="toggle-sidebar-btn" onmouseover="showSidebar()">☰</button>
    <h2>Admin Dashboard</h2>
    <div class="sidebar" onmouseleave="hideSidebar()">
    <a href="homepage.php">Home</a>
    <?php
    if ($userType === "admin") {
        echo '<a href="admin_dashboard.php">Manage Users</a>';
    } 
    ?>
    <a href="user_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>
    </header>
<table>
    <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Contact Number</th>
        <th>Intent Letter</th>
        <th>Submission Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row["fullName"]; ?></td>
            <td><?php echo $row["emailAddress"]; ?></td>
            <td><?php echo $row["contactNumber"]; ?></td>
            <td>
                <a href="file_viewer.php?user_id=<?php echo $row["id"]; ?>" class="view-button"  target="_blank">View</a>
            </td>
            <td><?php echo $row["submissionDate"]; ?></td>           
            <td>
                <?php if ($row["approved"] == 1): ?>
                    <span class="approvedStudent">Approved</span>
                <?php else: ?>
                    <span class="not-approved">New</span>
                <?php endif; ?>
            </td>
            <td>
                <form action="admin_email_form.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <button type="submit" class="approve-button">Approve</button>
                </form><br>
                <form action="delete.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $row["id"]; ?>">
                    <button type="submit" class="delete-button">Decline</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
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
</body>
</html>
