<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}

include 'includes/db.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $PassportID = mysqli_real_escape_string($conn, $_GET['id']);

    // Input validation (example: ensure it's numeric)
    if (!is_numeric($PassportID)) {
        echo "Invalid Passport ID";
        exit;
    }

    $username = $_SESSION['username'];

    // Prepared statement
    $stmt = $conn->prepare("INSERT INTO renewapplication (PassportID, username) VALUES (?, ?)");
    $stmt->bind_param("ss", $PassportID, $username); 

    if ($stmt->execute()) {
        header("location: success.php"); // Renewal application successful
    } else {
        // More informative error message
        echo "Error: Could not submit renewal application. " . $stmt->error; 
    }

    $stmt->close();
}