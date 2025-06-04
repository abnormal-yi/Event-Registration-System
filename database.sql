-- Create database
CREATE DATABASE IF NOT EXISTS event_registration;
USE event_registration;

-- Create events table
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Create registrations table
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);

-- Insert sample events
INSERT INTO events (event_name, date, location) VALUES
('Summer Tech Conference', '2024-07-15', 'Convention Center'),
('Business Workshop', '2024-06-20', 'Hotel Grand'),
('Music Festival', '2024-08-10', 'City Park'),
('Career Fair', '2024-06-30', 'University Hall'); 