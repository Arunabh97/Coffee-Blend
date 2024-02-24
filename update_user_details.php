<?php
require "config/config.php";

// Validate and sanitize user inputs
$userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

// Check if user inputs are valid
if ($userId === false || $firstName === null || $lastName === null || $username === null || $email === false) {
    // Handle invalid inputs
    echo "Invalid input data";
    exit;
}

try {
    // Prepare and execute the update query using a prepared statement
    $updateQuery = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ? WHERE id = ?");
    $updateQuery->execute([$firstName, $lastName, $username, $email, $userId]);

    // Check if the update was successful
    if ($updateQuery->rowCount() > 0) {
        echo "Update successful";
    } else {
        echo "No changes made"; // Optional message if no changes were detected
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Database error: " . $e->getMessage();
}
?>
