# Event Registration System

A simple PHP-based event registration system that allows users to register for various events.

## Features

- View list of upcoming events
- Register for events
- Admin view of all registrations
- Basic form validation
- Simple and clean interface

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- MAMP or similar local server environment

## Setup Instructions

1. Place all files in your web server directory (e.g., htdocs for MAMP)

2. Create the database and tables:
   - Open phpMyAdmin (usually at http://localhost/phpmyadmin)
   - Create a new database named 'event_registration'
   - Import the `database.sql` file

3. Configure database connection:
   - Open `db.php`
   - Update the database credentials if needed:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "root";  // Change if your password is different
     $dbname = "event_registration";
     ```

4. Access the system:
   - Main page: http://localhost/Event-Registration-System/
   - Admin view: http://localhost/Event-Registration-System/view_registrations.php

## File Structure

- `index.php` - Homepage with event list
- `register.php` - Event registration form
- `save_registration.php` - Handles form submission
- `view_registrations.php` - Admin view of registrations
- `db.php` - Database connection
- `style.css` - Styling
- `database.sql` - Database setup

## Notes

- This is a basic system without authentication
- For production use, add proper security measures
- Add error handling as needed
- Customize styling in style.css
