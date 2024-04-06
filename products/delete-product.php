<?php require "../config/config.php"; ?>

<?php

	if(!isset($_SESSION['user_id'])){
		header("location: ".APPURL."");
	}

    if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $productId = $_GET['id'];
    
        $deleteProduct = $conn->prepare("DELETE FROM cart WHERE pro_id = :product_id");
    
        $deleteProduct->bindParam(':product_id', $productId);
    
        if($deleteProduct->execute()) {
            echo "<script>alert('Product deleted successfully');</script>";
            echo "<script>window.location.href='cart.php';</script>"; 
            exit;
        } else {
            echo "<script>alert('Failed to delete the product from the cart');</script>";
            echo "<script>window.location.href='cart.php';</script>"; 
            exit;
        }
    } else {
        echo "<script>alert('Invalid product ID');</script>";
        echo "<script>window.location.href='cart.php';</script>"; 
        exit;
    }

?>