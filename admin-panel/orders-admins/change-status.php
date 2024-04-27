<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if(!isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."/admins/login-admins.php");
}

if(isset($_GET['id'])){

  $id = $_GET['id'];

  if (isset($_POST['submit'])) {
      if (empty($_POST['status'])) {
          echo "<script>alert('One or more inputs are empty');</script>";
      } else {
          $status = $_POST['status'];
          
          // Check if the current status is 'Cancelled' or 'Delivered'
          $check_status = $conn->prepare("SELECT status, pay_type FROM orders WHERE id=:id");
          $check_status->execute([":id" => $id]);
          $order_info = $check_status->fetch(PDO::FETCH_ASSOC);
          $current_status = $order_info['status'];
          $pay_type = $order_info['pay_type'];

          if ($current_status === 'Cancelled') {
              echo "<script>alert('Once cancelled, status cannot be changed.');</script>";
          } elseif ($current_status === 'Delivered') {
              echo "<script>alert('Once delivered, status cannot be changed.');</script>";
          } else {
              // Proceed with updating the status
              $update = $conn->prepare("UPDATE orders SET status = :status WHERE id=:id");
              $update->execute([
                  ":status" => $status,
                  ":id" => $id
              ]);
    
              if ($status === 'Delivered' && $pay_type === 'Cash On Delivery') {
                $update_payment_status = $conn->prepare("UPDATE orders SET pay_status = 'Completed' WHERE id=:id");
                $update_payment_status->execute([
                    ":id" => $id
                ]);
            }

              echo "<script>alert('Status updated successfully.');</script>";
              echo "<script>window.location.href = 'show-orders.php';</script>";
            }
        }
    }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-U3+K+F5ldqGz8U+XfW1deyOKNEdFG+4Bp2HBf5vHvXsfyM9Oo4+c2bqk4f+UZaBm" crossorigin="anonymous">

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Orders Update Status</h5>
        <form method="POST" action="change-status.php?id=<?php echo $id; ?>">

          <div class="form-outline mb-4 mt-4">
            <select name="status" class="form-select form-control" aria-label="Default select example">
              <option selected>Choose Type</option>
              <option value="Pending">Pending <i class="fas fa-info-circle text-info"></i> - Waiting for processing</option>
              <option value="In Progress">In Progress <i class="fas fa-sync-alt text-warning"></i> - Currently being processed</option>
              <!-- <option value="Shipped">Shipped <i class="fas fa-truck text-primary"></i> - Order has been shipped</option> -->
              <option value="Delivered">Delivered <i class="fas fa-check-circle text-success"></i> - Order has been delivered</option>
              <option value="Cancelled">Cancelled <i class="fas fa-times-circle text-danger"></i> - Order has been cancelled</option>
            </select>
          </div>

          <button type="submit" name="submit" class="btn btn-primary mb-4 text-center"><i class="fas fa-sync-alt"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>
