<?php
require_once 'db.php';

$success_message = '';
$error_message = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Basic validation
    if (empty($event_name) || empty($date) || empty($location)) {
        $error_message = "Please fill in all fields";
    } else {
        // Insert the new event
        $sql = "INSERT INTO events (event_name, date, location) VALUES ('$event_name', '$date', '$location')";
        
        if (mysqli_query($conn, $sql)) {
            $success_message = "Event added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Event</h1>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required>
            </div>

            <div class="form-group">
                <label for="date">Event Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>

            <button type="submit" class="btn">Add Event</button>
        </form>

        <p><a href="index.php">Back to Events List</a></p>

        <!-- Show recently added events -->
        <h2>Recent Events</h2>
        <?php
        $recent_sql = "SELECT * FROM events ORDER BY event_id DESC LIMIT 5";
        $recent_result = mysqli_query($conn, $recent_sql);

        if (mysqli_num_rows($recent_result) > 0) {
            echo "<table>";
            echo "<tr><th>Event Name</th><th>Date</th><th>Location</th></tr>";
            
            while ($row = mysqli_fetch_assoc($recent_result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No events found</p>";
        }
        ?>
    </div>
</body>
</html> 