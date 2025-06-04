<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection without database
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Drop existing database to start fresh
$sql = "DROP DATABASE IF EXISTS event_registration";
if (mysqli_query($conn, $sql)) {
    echo "Existing database dropped successfully<br>";
} else {
    echo "Error dropping database: " . mysqli_error($conn) . "<br>";
}

// Create database
$sql = "CREATE DATABASE event_registration";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
if (mysqli_select_db($conn, "event_registration")) {
    echo "Database selected successfully<br>";
} else {
    echo "Error selecting database: " . mysqli_error($conn) . "<br>";
}

// Create events table
$sql = "CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Events table created successfully<br>";
} else {
    echo "Error creating events table: " . mysqli_error($conn) . "<br>";
}

// Create registrations table
$sql = "CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Registrations table created successfully<br>";
} else {
    echo "Error creating registrations table: " . mysqli_error($conn) . "<br>";
}

// Insert sample events with future dates
$currentYear = date('Y');
$sql = "INSERT INTO events (event_name, date, location) VALUES
    ('Summer Tech Conference', '$currentYear-07-15', 'Convention Center'),
    ('Business Workshop', '$currentYear-06-20', 'Hotel Grand'),
    ('Music Festival', '$currentYear-08-10', 'City Park'),
    ('Career Fair', '$currentYear-06-30', 'University Hall')";

if (mysqli_query($conn, $sql)) {
    echo "Sample events inserted successfully<br>";
} else {
    echo "Error inserting sample events: " . mysqli_error($conn) . "<br>";
}

// Verify events were inserted
$result = mysqli_query($conn, "SELECT * FROM events");
if ($result) {
    echo "<br>Events in database:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "- {$row['event_name']} on {$row['date']}<br>";
    }
} else {
    echo "Error checking events: " . mysqli_error($conn) . "<br>";
}

echo "<br>Database setup completed. <a href='index.php'>Go to homepage</a>";

mysqli_close($conn);
?> 