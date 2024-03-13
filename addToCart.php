<?php
session_start();
require "config/config.php";

if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit;
}

if (isset($_POST['product_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];

    $checkIfExists = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND pro_id = ?");
    $checkIfExists->execute([$userId, $productId]);

    if (!$checkIfExists->fetch()) {
        $insertIntoCart = $conn->prepare("INSERT INTO cart (user_id, pro_id, name, image, price, description, quantity, created_at) 
                                         SELECT ?, id, name, image, price, description, 1, current_timestamp() 
                                         FROM products WHERE id = ?");
        $insertIntoCart->execute([$userId, $productId]);

        echo "added";
    } else {
        echo "exists";
    }
} else {
    echo "missing_product_id";
}
?>
