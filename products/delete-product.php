<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

	if(!isset($_SESSION['user_id'])){
		header("location: ".APPURL."");
	}

    if(isset($_GET['id'])){
        $id = $_GET['id'];

       $delete = $conn->query("DELETE FROM cart WHERE id='$id'"); 
       $delete->execute();

       //header("location: cart.php");
       echo "<script>alert('Removed from cart successfully'); window.location.href = 'cart.php';</script>";
    }

?>