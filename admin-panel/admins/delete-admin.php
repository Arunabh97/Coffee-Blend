<?php
session_start();

if (!isset($_SESSION['admin_name']) || $_SESSION['admin_id'] != 1) {
    echo "error";
    exit;
}

if (!isset($_POST['admin_id'])) {
    echo "error";
    exit;
}

require_once "../../config/config.php";

$adminId = $_POST['admin_id'];
$deleteQuery = $conn->prepare("DELETE FROM admins WHERE id = :admin_id");
$deleteQuery->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

if ($deleteQuery->execute()) {
    echo "success"; 
} else {
    echo "error"; 
}
