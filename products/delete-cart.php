<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    echo "<script>window.location.href = 'http://localhost/coffee-blend';</script>";
	exit;
}

if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href = '" . APPURL . "';</script>";
}

$deleteAll = $conn->query("DELETE FROM cart WHERE user_id='$_SESSION[user_id]'");
$deleteAll->execute();

echo "<script>window.location.href = 'cart.php';</script>";

?>