<?php
// Start the session
session_start();

// Include your database connection code (similar to db.php)
include('config/config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit();
}

// Get user ID and new password from the POST request
$userId = $_SESSION['user_id'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

// Validate inputs
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo "Please fill in all fields.";
    exit();
}

// Check if the new password and confirm password match
if ($newPassword !== $confirmPassword) {
    echo "New password and confirm password do not match.";
    exit();
}

// Fetch the user's current hashed password from the database
$userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->execute([$userId]);
$userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);

// Verify the current password
if (!password_verify($currentPassword, $userDetails['password'])) {
    echo "Incorrect current password.";
    exit();
}

// Hash the new password
$newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the user's password in the database
$updateQuery = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$success = $updateQuery->execute([$newHashedPassword, $userId]);

// Check if the update was successful
if ($success) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password: " . implode(" ", $updateQuery->errorInfo());
}

// Close the database connection
$conn = null;
?>
