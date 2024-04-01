<?php

require "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orders'])) {
    $selectedOrders = $_POST['orders'];

    // Prepare and execute DELETE queries for selected orders and associated order items
    $deleteOrderItemsStmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $deleteOrderStmt = $conn->prepare("DELETE FROM orders WHERE id = ?");

    foreach ($selectedOrders as $orderId) {

        $deleteOrderItemsStmt->execute([$orderId]);

        $deleteOrderStmt->execute([$orderId]);
    }

    echo 'Orders deleted successfully.';
} else {
    echo 'No orders selected for deletion.';
}
?>
