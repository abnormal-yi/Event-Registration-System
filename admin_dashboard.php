<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

require_once 'db.php';

// Handle event deletion
if (isset($_POST['delete_event']) && isset($_POST['event_id'])) {
    $event_id = (int)$_POST['event_id'];
    $delete_sql = "DELETE FROM events WHERE event_id = $event_id";
    mysqli_query($conn, $delete_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .admin-actions {
            display: flex;
            gap: 10px;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <div class="admin-actions">
                <a href="add_event.php" class="btn">Add New Event</a>
                <a href="admin_logout.php" class="btn delete-btn">Logout</a>
            </div>
        </div>

        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>

        <h3>Manage Events</h3>
        <?php
        // Fetch all events
        $sql = "SELECT * FROM events ORDER BY date DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Actions</th>
                  </tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                echo "<td>
                        <form method='POST' style='display: inline;' onsubmit='return confirm(\"Are you sure you want to delete this event?\");'>
                            <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                            <button type='submit' name='delete_event' class='btn delete-btn'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No events found</p>";
        }
        ?>

        <h3>View Registrations</h3>
        <?php
        // Fetch all registrations with event names
        $sql = "SELECT r.*, e.event_name 
                FROM registrations r 
                JOIN events e ON r.event_id = e.event_id 
                ORDER BY r.registration_date DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Event</th>
                    <th>Registration Date</th>
                  </tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['registration_date']) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No registrations found</p>";
        }
        ?>
    </div>
</body>
</html> 