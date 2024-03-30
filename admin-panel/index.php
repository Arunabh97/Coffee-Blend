<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
}

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

// admins
$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$admins->execute();
$adminsCount = $admins->fetch(PDO::FETCH_OBJ);

// Previous counts (You may store these in session or a database)
$prevProductsCount = isset($_SESSION['prev_counts']['products']) ? $_SESSION['prev_counts']['products'] : 0;
$prevOrdersCount = isset($_SESSION['prev_counts']['orders']) ? $_SESSION['prev_counts']['orders'] : 0;
$prevBookingsCount = isset($_SESSION['prev_counts']['bookings']) ? $_SESSION['prev_counts']['bookings'] : 0;
$prevAdminsCount = isset($_SESSION['prev_counts']['admins']) ? $_SESSION['prev_counts']['admins'] : 0;

// Update session with current counts
$_SESSION['prev_counts'] = array(
    'products' => $productsCount->count_products,
    'orders' => $ordersCount->count_orders,
    'bookings' => $bookingsCount->count_bookings,
    'admins' => $adminsCount->count_admins
);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
  .custom-card {
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
  }

  .custom-card:hover {
    transform: scale(1.05);
  }

  .custom-card .card-body {
    padding: 20px;
  }

  .custom-card-title {
    font-size: 1.5rem;
  }

  .custom-card-text {
    font-size: 1.2rem;
  }

  .custom-btn {
    font-size: 1.1rem;
    border-radius: 20px;
  }
</style>

<div class="row">
  <div class="col-md-3">
      <div class="card bg-primary text-white custom-card">
        <div class="card-body">
          <h5 class="card-title custom-card-title">
            <i class="fas fa-shopping-bag"></i> Products
            <?php if ($productsCount->count_products > $prevProductsCount) { ?>
              <span class="badge bg-danger">New</span>
            <?php } ?>
          </h5>
          <p class="card-text custom-card-text">Total: <?php echo $productsCount->count_products; ?></p>
          <a href="<?php echo ADMINURL; ?>/products-admins/show-products.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-success text-white custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="fas fa-shopping-cart"></i> Orders
                  <?php if ($ordersCount->count_orders > $prevOrdersCount) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $ordersCount->count_orders; ?></p>
              <a href="<?php echo ADMINURL; ?>/orders-admins/show-orders.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

  <div class="col-md-3">
      <div class="card bg-info text-white custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="far fa-calendar"></i> Bookings
                  <?php if ($bookingsCount->count_bookings > $prevBookingsCount) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $bookingsCount->count_bookings; ?></p>
              <a href="<?php echo ADMINURL; ?>/bookings-admins/show-bookings.php" class="btn btn-light custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>

  <div class="col-md-3">
      <div class="card bg-warning text-dark custom-card">
          <div class="card-body">
              <h5 class="card-title custom-card-title">
                  <i class="fas fa-user"></i> Admins
                  <?php if ($adminsCount->count_admins > $prevAdminsCount) { ?>
                      <span class="badge bg-danger">New</span>
                  <?php } ?>
              </h5>
              <p class="card-text custom-card-text">Total: <?php echo $adminsCount->count_admins; ?></p>
              <a href="<?php echo ADMINURL; ?>/admins/admins.php" class="btn btn-dark custom-btn"><i class="fa-solid fa-eye"></i> View Details</a>
          </div>
      </div>
  </div>
</div>  

<?php require "users/show-customer-enquiries.php"; ?>
<?php require "layouts/footer.php"; ?>
