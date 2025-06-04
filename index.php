<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';

// Fetch events from database
$sql = "SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC";
echo "<!-- Debug: SQL Query: " . $sql . " -->";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Debug: Print all events regardless of date
echo "<!-- Debug: Checking all events in database -->";
$all_events_sql = "SELECT * FROM events";
$all_events_result = mysqli_query($conn, $all_events_sql);
if ($all_events_result) {
    echo "<!-- Debug: Total events in database: " . mysqli_num_rows($all_events_result) . " -->";
} else {
    echo "<!-- Debug: Error getting all events: " . mysqli_error($conn) . " -->";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #666;
            text-decoration: none;
        }
        .admin-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="admin_login.php" class="admin-link">Admin Login</a>
    
    <div class="container">
        <h1>Upcoming Events</h1>
        
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="event-card">
                    <h2><?php echo $row['event_name']; ?></h2>
                    <p>Date: <?php echo $row['date']; ?></p>
                    <p>Location: <?php echo $row['location']; ?></p>
                    <a href="register.php?event_id=<?php echo $row['event_id']; ?>" class="btn">Register Now</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No upcoming events available.</p>";
            // Debug information
            echo "<p style='color: #666; font-size: 0.8em;'>";
            echo "Debug Info:<br>";
            echo "1. Database connection status: " . ($conn ? "Connected" : "Not connected") . "<br>";
            echo "2. Query result status: " . ($result ? "Success" : "Failed") . "<br>";
            if ($result) {
                echo "3. Number of rows: " . mysqli_num_rows($result) . "<br>";
            }
            echo "</p>";
        }
        ?>
    </div>
</body>
</html> 