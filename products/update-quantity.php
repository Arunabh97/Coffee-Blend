<?php
    require "../config/config.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];

        // Perform the update in the database
        $updateQuantity = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :productId");
        $updateQuantity->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $updateQuantity->bindParam(':productId', $productId, PDO::PARAM_INT);
        $updateQuantity->execute();

        // You can return a success message if needed
        echo 'Quantity updated successfully';
    }
?>
