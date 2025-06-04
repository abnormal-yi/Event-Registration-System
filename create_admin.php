<?php
require_once 'db.php';

// Create admin table
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Admin table created successfully<br>";
} else {
    echo "Error creating admin table: " . mysqli_error($conn) . "<br>";
}

// Create default admin user (username: admin, password: admin123)
$username = 'admin';
$password = 'admin123';  // Plain text password

$sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Default admin user created successfully<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
} else {
    echo "Error creating admin user: " . mysqli_error($conn) . "<br>";
}
?> 
 