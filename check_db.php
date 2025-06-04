<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';

echo "<h2>Database Check Results:</h2>";

// Check if tables exist
$tables_query = "SHOW TABLES";
$tables_result = mysqli_query($conn, $tables_query);

if ($tables_result) {
    echo "<p>Tables in database:</p>";
    echo "<ul>";
    while ($table = mysqli_fetch_array($tables_result)) {
        echo "<li>" . $table[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Error checking tables: " . mysqli_error($conn) . "</p>";
}

// Check events table contents
$events_query = "SELECT * FROM events";
$events_result = mysqli_query($conn, $events_query);

if ($events_result) {
    echo "<h3>Events in database:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Date</th><th>Location</th></tr>";
    
    while ($event = mysqli_fetch_assoc($events_result)) {
        echo "<tr>";
        echo "<td>" . $event['event_id'] . "</td>";
        echo "<td>" . $event['event_name'] . "</td>";
        echo "<td>" . $event['date'] . "</td>";
        echo "<td>" . $event['location'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>Error checking events: " . mysqli_error($conn) . "</p>";
}

// Check current date for comparison
echo "<h3>System Information:</h3>";
echo "<p>Current Date (MySQL): ";
$date_result = mysqli_query($conn, "SELECT CURDATE() as today");
$date = mysqli_fetch_assoc($date_result);
echo $date['today'] . "</p>";

echo "<p>Current Date (PHP): " . date('Y-m-d') . "</p>";

// Check MySQL version
$version_result = mysqli_query($conn, "SELECT VERSION() as version");
$version = mysqli_fetch_assoc($version_result);
echo "<p>MySQL Version: " . $version['version'] . "</p>";
?> 