
<?php
$host = "localhost";
$dbname = "student_auth_db";
$username = "root";
$password = ""; // Default local XAMPP setup only

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    exit("Unable to connect to the database. Please check your XAMPP settings.");
}

$conn->set_charset("utf8mb4");
?>
