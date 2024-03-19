<?php
require "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["product_id"]) && isset($_POST["quantity"])) {

        $productId = $_POST["product_id"];
        $quantity = $_POST["quantity"];

        if ($quantity > 10) {

            echo "Quantity cannot exceed 10.";
            exit; 

        }

        $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $productId);
        
        if ($stmt->execute()) {

            $stmt = $conn->prepare("SELECT price * quantity AS total FROM cart WHERE id = :id");
            $stmt->bindParam(':id', $productId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo $row["total"];
        } else {

            echo "Error updating cart.";
        }
    } else {

        echo "Product ID or quantity not specified.";
    }
} else {

    echo "Invalid request method.";
}

// Close the database connection
$conn = null;
?>
