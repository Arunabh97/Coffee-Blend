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
?>

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
    font-size: 1.2rem;
  }
</style>

<div class="row">
  <div class="col-md-3">
    <div class="card bg-primary text-white custom-card">
      <div class="card-body">
        <h5 class="card-title custom-card-title"><i class="fas fa-box"></i> Products</h5>
        <p class="card-text custom-card-text">Total: <?php echo $productsCount->count_products; ?></p>
        <a href="#" class="btn btn-light custom-btn">View Details</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-success text-white custom-card">
      <div class="card-body">
        <h5 class="card-title custom-card-title"><i class="fas fa-shopping-cart"></i> Orders</h5>
        <p class="card-text custom-card-text">Total: <?php echo $ordersCount->count_orders; ?></p>
        <a href="#" class="btn btn-light custom-btn">View Details</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-info text-white custom-card">
      <div class="card-body">
        <h5 class="card-title custom-card-title"><i class="fas fa-book"></i> Bookings</h5>
        <p class="card-text custom-card-text">Total: <?php echo $bookingsCount->count_bookings; ?></p>
        <a href="#" class="btn btn-light custom-btn">View Details</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-warning text-dark custom-card">
      <div class="card-body">
        <h5 class="card-title custom-card-title"><i class="fas fa-user"></i> Admins</h5>
        <p class="card-text custom-card-text">Total: <?php echo $adminsCount->count_admins; ?></p>
        <a href="#" class="btn btn-dark custom-btn">View Details</a>
      </div>
    </div>
  </div>
</div>

<?php require "layouts/footer.php"; ?>
