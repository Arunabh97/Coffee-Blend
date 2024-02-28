<?php
session_start();

include('config/config.php');

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit();
}

$userId = $_SESSION['user_id'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

// Validate inputs
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo "Please fill in all fields.";
    exit();
}

if ($newPassword !== $confirmPassword) {
    echo "New password and confirm password do not match.";
    exit();
}

$userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->execute([$userId]);
$userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);

if (!password_verify($currentPassword, $userDetails['password'])) {
    echo "Incorrect current password.";
    exit();
}

$newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$updateQuery = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$success = $updateQuery->execute([$newHashedPassword, $userId]);

if ($success) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password: " . implode(" ", $updateQuery->errorInfo());
}

$conn = null;
?>
