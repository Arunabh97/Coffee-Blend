<?php
require_once 'config/config.php';

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    $stmt = $conn->prepare("SELECT id, name FROM products WHERE name LIKE ? LIMIT 10");
    $stmt->execute(["%$searchQuery%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
?>
