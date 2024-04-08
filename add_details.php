<?php
require "config/config.php";

$userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
$streetAddress = filter_input(INPUT_POST, 'streetAddress', FILTER_SANITIZE_STRING);
$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_STRING);
$zipCode = filter_input(INPUT_POST, 'zipCode', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING); // Corrected filter

if ($userId === false || $streetAddress === null || $town === null || $zipCode === null || $phone === null) {
    echo "Invalid input data";
    exit;
}

try {
    $userQuery = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $userQuery->execute([$userId]);
    $userExists = $userQuery->fetchColumn();

    if ($userExists) {
        $updateQuery = $conn->prepare("UPDATE users SET street_address = ?, town = ?, zip_code = ?, phone = ? WHERE id = ?");
        $updateQuery->execute([$streetAddress, $town, $zipCode, $phone, $userId]);

        if ($updateQuery->rowCount() > 0) {
            echo "Update successful";
        } else {
            echo "No changes made";
        }
    } else {
        $insertQuery = $conn->prepare("INSERT INTO users (id, street_address, town, zip_code, phone) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->execute([$userId, $streetAddress, $town, $zipCode, $phone]);
        echo "Insert successful";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
