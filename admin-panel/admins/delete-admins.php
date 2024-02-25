<?php
require "../../config/config.php";

if (!isset($_SESSION['admin_id']) || $_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

$adminIdToDelete = $_GET['id'];

if ($_SESSION['admin_id'] == $adminIdToDelete) {
    // Proceed with deletion logic
    $deleteQuery = $conn->prepare("DELETE FROM admins WHERE id = :adminId");
    $deleteQuery->bindParam(':adminId', $adminIdToDelete, PDO::PARAM_INT);
    $deleteQuery->execute();

    // Logout after deletion
    session_destroy(); // Destroy all session data

    // Redirect to login page
    //header("location: " . ADMINURL . "/admins/login-admins.php");
    echo "<script>window.location.href = '" . ADMINURL . "/admins/login-admins.php';</script>";
    exit();
} else {
    // Redirect to a safe location if unauthorized deletion attempt
    header("location: " . ADMINURL . "/admins/show-admins.php");
    echo "<script>window.location.href = '" . ADMINURL . "/admins/show-admins.php';</script>";
    exit();
}
?>
