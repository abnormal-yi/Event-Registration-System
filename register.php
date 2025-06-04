<?php
require_once 'db.php';

$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

// Fetch event details if event_id is provided
$event_name = '';
if ($event_id > 0) {
    $sql = "SELECT event_name FROM events WHERE event_id = $event_id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $event_name = $row['event_name'];
    }
}

// Fetch all events for dropdown if no specific event is selected
$sql = "SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC";
$events = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Event Registration</h1>
        
        <form action="save_registration.php" method="POST">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="event_id">Select Event:</label>
                <select id="event_id" name="event_id" required>
                    <?php if ($event_id == 0): ?>
                        <option value="">Choose an event</option>
                    <?php endif; ?>
                    
                    <?php while ($event = mysqli_fetch_assoc($events)): ?>
                        <option value="<?php echo $event['event_id']; ?>"
                            <?php echo ($event_id == $event['event_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($event['event_name']); ?> - 
                            <?php echo htmlspecialchars($event['date']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>
        
        <p><a href="index.php">Back to Events</a></p>
    </div>
</body>
</html> 