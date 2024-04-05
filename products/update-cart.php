<?php
require "../config/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = intval($_POST['quantity']);

        // Fetch the stock quantity of the product
        $stockQuery = $conn->prepare("SELECT stock_quantity FROM products WHERE id = :productId");
        $stockQuery->bindParam(':productId', $productId);
        $stockQuery->execute();
        $stockResult = $stockQuery->fetch(PDO::FETCH_ASSOC);
        $stockQuantity = $stockResult['stock_quantity'];

        // Limit the quantity to the available stock
        $quantity = min($quantity, $stockQuantity);

        // Update the cart quantity in the database
        $updateQuery = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE pro_id = :productId AND user_id = :userId");
        $updateQuery->bindParam(':quantity', $quantity);
        $updateQuery->bindParam(':productId', $productId);
        $updateQuery->bindParam(':userId', $_SESSION['user_id']);
        $updateQuery->execute();

        // Check if the quantity was updated successfully
        if ($updateQuery->rowCount() > 0) {
            // Quantity updated successfully
            echo json_encode(array('success' => true, 'message' => 'Quantity updated successfully.'));
        } else {
            // Quantity not updated (e.g., product not found in cart)
            echo json_encode(array('success' => false, 'message' => 'Unable to update quantity.'));
        }
    } else {
        http_response_code(400);
        echo "Missing product_id or quantity";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
