<?php 

  // db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee-blend";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

    session_start();
    define("APPURL","http://localhost/coffee-blend");
    define("IMAGEPRODUCTS", "http://localhost/coffee-blend/admin-panel/products-admins/images");

    // Check if alert message exists
if (isset($_SESSION['alert'])) {
  echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
  unset($_SESSION['alert']); // Clear the session variable
}
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Coffee - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/animate.css">
    
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/aos.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/icomoon.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/style.css">
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="<?php echo APPURL; ?>"><i class='bx bx-coffee-togo'></i>Coffee<small>Blend</small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="<?php echo APPURL; ?>" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="<?php echo APPURL; ?>/menu.php" class="nav-link">Menu</a></li>
	          <li class="nav-item"><a href="<?php echo APPURL; ?>/services.php" class="nav-link">Services</a></li>
	          <li class="nav-item"><a href="<?php echo APPURL; ?>/about.php" class="nav-link">About</a></li>
	         
	          <li class="nav-item"><a href="<?php echo APPURL; ?>/contact.php" class="nav-link">Contact</a></li>
	          <?php if(isset($_SESSION['username'])) : ?>
              <li class="nav-item cart">
    <a href="<?php echo APPURL; ?>/products/cart.php" class="nav-link">
        <span class="icon icon-shopping_cart"></span>
        <?php
        // Fetch and display the count of items in the cart
        $cartCount = 0; // Default value if the count is not available
        if (isset($_SESSION['user_id'])) {
            $cartQuery = $conn->query("SELECT COUNT(*) AS count FROM cart WHERE user_id = '$_SESSION[user_id]'");
            $cartCountResult = $cartQuery->fetch(PDO::FETCH_ASSOC);
            $cartCount = $cartCountResult['count'];
        }
        ?>
        <?php if ($cartCount > 0) : ?>
            <sup class="badge badge-pill badge-danger"><?php echo $cartCount; ?></sup>
        <?php endif; ?>
    </a>
</li>

 <!-- settings icon can delete this when needed -->
<?php if(isset($_SESSION['username'])) : ?>
        <!-- Add a separate list item for settings outside the dropdown menu -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo APPURL; ?>/users/user-settings.php">
            <i class='bx bx-cog' style="font-size: 1.5rem;"></i>
            </a>
        </li>
    <?php endif; ?>


              <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/bookings.php"><i class='bx bx-calendar'></i> Bookings</a></li>
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/logout.php">Logout <i class='bx bx-log-in' ></i></a></li>
          </ul>
        </li>
        <?php else: ?>
			  <li class="nav-item"><a href="<?php echo APPURL; ?>/login.php" class="nav-link">login</a></li>
			  <li class="nav-item"><a href="<?php echo APPURL; ?>/register.php" class="nav-link">register</a></li>
        <?php endif; ?>
	        </ul>
	      </div>
		</div>
	  </nav>
    <!-- END nav -->
</body>
</html>