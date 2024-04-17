<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 

// Check if previous counts are set in session, if not set them to 0
$prevAdminsCount = isset($_SESSION['prevAdminsCount']) ? $_SESSION['prevAdminsCount'] : 0;
$prevUsersCount = isset($_SESSION['prevUsersCount']) ? $_SESSION['prevUsersCount'] : 0;
$prevProductsCount = isset($_SESSION['prevProductsCount']) ? $_SESSION['prevProductsCount'] : 0;
$prevOrdersCount = isset($_SESSION['prevOrdersCount']) ? $_SESSION['prevOrdersCount'] : 0;
$prevBookingsCount = isset($_SESSION['prevBookingsCount']) ? $_SESSION['prevBookingsCount'] : 0;
$prevReviewsCount = isset($_SESSION['prevReviewsCount']) ? $_SESSION['prevReviewsCount'] : 0;

if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
}

// admins
$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$admins->execute();
$adminsCount = $admins->fetch(PDO::FETCH_OBJ);

// products
$products = $conn->query("SELECT COUNT(*) AS count_products FROM products");
$products->execute();
$productsCount = $products->fetch(PDO::FETCH_OBJ);

// orders
$orders = $conn->query("SELECT COUNT(*) AS count_orders FROM orders");
$orders->execute();
$ordersCount = $orders->fetch(PDO::FETCH_OBJ);

// bookings
$bookings = $conn->query("SELECT COUNT(*) AS count_bookings FROM bookings");
$bookings->execute();
$bookingsCount = $bookings->fetch(PDO::FETCH_OBJ);

// users
$users = $conn->query("SELECT COUNT(*) AS count_users FROM users");
$users->execute();
$usersCount = $users->fetch(PDO::FETCH_OBJ);

// reviews
$reviews = $conn->query("SELECT COUNT(*) AS count_reviews FROM reviews");
$reviews->execute();
$reviewsCount = $reviews->fetch(PDO::FETCH_OBJ);

// Check if the current counts are greater than the previous counts to determine if there are new records
$newAdmins = $adminsCount->count_admins > $prevAdminsCount;
$newUsers = $usersCount->count_users > $prevUsersCount;
$newProducts = $productsCount->count_products > $prevProductsCount;
$newOrders = $ordersCount->count_orders > $prevOrdersCount;
$newBookings = $bookingsCount->count_bookings > $prevBookingsCount;
$newReviews = $reviewsCount->count_reviews > $prevReviewsCount;

// Store current counts in session variables
$_SESSION['prevAdminsCount'] = $adminsCount->count_admins;
$_SESSION['prevUsersCount'] = $usersCount->count_users;
$_SESSION['prevProductsCount'] = $productsCount->count_products;
$_SESSION['prevOrdersCount'] = $ordersCount->count_orders;
$_SESSION['prevBookingsCount'] = $bookingsCount->count_bookings;
$_SESSION['prevReviewsCount'] = $reviewsCount->count_reviews;

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
  .custom-card {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  background: linear-gradient(135deg, #FF6F61, #6B5B95, #4682B4);
  position: relative; 
}

.custom-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.1); 
}

.custom-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.custom-card .card-body {
  padding: 20px;
}

.custom-card-title {
  font-size: 2rem; 
  color: #fff;
  margin-bottom: 10px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
}

.custom-card-text {
  font-size: 1.6rem; 
  color: #f0f0f0;
}

.custom-btn {
  font-size: 1.2rem; 
  border-radius: 25px;
  background-color: #FF6347;
  color: #fff;
  padding: 10px 24px;
  border: none;
  transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
  position: relative; 
  overflow: hidden; 
}

.custom-btn::before {
  content: '';
  position: absolute;
  width: 120%; 
  height: 120%; 
  background: rgba(255, 255, 255, 0.3); 
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(45deg); 
  transition: width 0.3s ease-in-out, height 0.3s ease-in-out;
  z-index: -1;
}

.custom-btn:hover::before {
  width: 300%; 
  height: 300%; 
}

.custom-btn:hover {
  background-color: #E63946;
  transform: translateY(-2px);
}

</style>

<div class="row">
  <div class="col-md-2">
      <div class="card bg-warning text-dark custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                <i class="fa-solid fa-user-tie"></i> Admins
                  <?php if ($newAdmins && $prevAdminsCount != 0) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $adminsCount->count_admins; ?></p>
              <a href="<?php echo ADMINURL; ?>/admins/admins.php" class="btn btn-dark custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

  <div class="col-md-2">
      <div class="card bg-primary text-white custom-card">
        <div class="card-body">
          <h5 class="card-title custom-card-title">
            <i class="fas fa-shopping-bag"></i> Products
            <?php if ($newProducts && $prevProductsCount != 0) { ?>
                <span class="badge bg-danger">New</span>
            <?php } ?>
          </h5>
          <p class="card-text custom-card-text">Total: <?php echo $productsCount->count_products; ?></p>
          <a href="<?php echo ADMINURL; ?>/products-admins/show-products.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="card bg-warning text-dark custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="fas fa-user"></i> Users
                  <?php if ($newUsers && $prevUsersCount != 0) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $usersCount->count_users; ?></p>
              <a href="<?php echo ADMINURL; ?>/users/users.php" class="btn btn-dark custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

  <div class="col-md-2">
      <div class="card bg-info text-white custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="far fa-calendar"></i> Bookings
                  <?php if ($newBookings && $prevBookingsCount != 0) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $bookingsCount->count_bookings; ?></p>
              <a href="<?php echo ADMINURL; ?>/bookings-admins/show-bookings.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

    <div class="col-md-2">
      <div class="card bg-success text-white custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="fas fa-shopping-cart"></i> Orders
                  <?php if ($newOrders && $prevOrdersCount != 0) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $ordersCount->count_orders; ?></p>
              <a href="<?php echo ADMINURL; ?>/orders-admins/show-orders.php" class="btn btn-dark custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

  <div class="col-md-2">
      <div class="card bg-warning text-dark custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                <i class="fas fa-comments"></i> Reviews
                  <?php if ($newReviews && $prevReviewsCount != 0) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $reviewsCount->count_reviews; ?></p>
              <a href="<?php echo ADMINURL; ?>/reviews-admins/show_reviews.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>
  
</div>  

<?php require "users/show-customer-enquiries.php"; ?>
<?php require "layouts/footer.php"; ?>
