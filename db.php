<?php
$host = "localhost"; // Updated to use localhost; replace with your actual host if different
$user = "uannmukxu07nw";
$password = "nhh1divf0d2c";
$dbname = "db4jg0s1fx9bze";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Log error to a file instead of displaying to users
    error_log("Database Connection Error: " . $e->getMessage(), 3, "error.log");
    // Display a user-friendly message
    die("Sorry, we're experiencing a database connection issue. Please try again later or contact support.");
}
?>
