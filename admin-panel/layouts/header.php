<?php

    session_start();
    define("ADMINURL", "http://localhost/coffee-blend/admin-panel");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo ADMINURL; ?>/styles/style.css" rel="stylesheet">
    <link rel="icon" href="<?php echo ADMINURL; ?>/icon.png" type="image/x-icon">
    
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
      .navbar {
            background: linear-gradient(to right, #007bff, #6c757d); 
        }
        .navbar-nav.side-nav {
            background: linear-gradient(to right, #007bff, #6c757d);
            margin: 20px 0;
            border-top-right-radius: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        }
        .nav-item {
            padding: 10px;
            margin: 0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #00d4ff, #0d47a1); 
            padding: 10px 15px; 
            border-radius: 5px;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); 
            color: white; 
            font-size: 16px; 
            font-weight: bold; 
            text-align: center; 
            text-decoration: none; 
            transition: background-color 0.3s ease, box-shadow 0.3s ease; 
        }

        .nav-item.active i {
            margin-right: 8px; 
        }

        .nav-item.active span {
            vertical-align: middle; 
        }

      </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="#"><i class='bx bx-coffee-togo' style='font-size: 1.5em;'></i> <span class="coffee-blend-text" style='font-size: 1.2em;'>COFFEE BLEND</span> Admin Panel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarText">
        <?php if(isset($_SESSION['admin_name'])) : ?>
        <ul class="navbar-nav side-nav" >
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <a class="nav-link" style="margin-left: 20px;" href="<?php echo ADMINURL; ?>"><i class="fas fa-home"></i> Home
                <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'admins.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/admins/admins.php" style="margin-left: 20px;"><i class="fa-solid fa-user-tie"></i> Admins</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/users/users.php" style="margin-left: 20px;"><i class="fa-solid fa-user"></i> Users</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'show-products.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/products-admins/show-products.php" style="margin-left: 20px;"><i class="fas fa-shopping-bag"></i> Products</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'show-orders.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/orders-admins/show-orders.php" style="margin-left: 20px;"><i class="fa-solid fa-cart-shopping"></i> Orders</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'show-bookings.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/bookings-admins/show-bookings.php" style="margin-left: 20px;"><i class="far fa-calendar"></i> Bookings</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'show-payments.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/payments-admin/show-payments.php" style="margin-left: 20px;"><i class="fas fa-credit-card"></i> Payments</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'show_reviews.php' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo ADMINURL; ?>/reviews-admins/show_reviews.php" style="margin-left: 20px;"><i class="fas fa-comments"></i> Reviews</a>
          </li>
        </ul>
        <?php endif; ?>
        <ul class="navbar-nav ml-md-auto d-md-flex">
            <?php if(isset($_SESSION['admin_name'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-user-tie"></i> <?php echo $_SESSION['admin_name']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo ADMINURL; ?>/admins/logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
              
          </li>
                <?php else : ?>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/admins/login-admins.php">
            </a>
          </li>    
          <?php endif; ?>       
          
        </ul>
      </div>
    </div>
    </nav>
    <div class="container-fluid">