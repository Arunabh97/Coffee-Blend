<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."/admins/login-admins.php");
}

$orders = $conn->query("SELECT * FROM orders");
$orders->execute();

$allOrders = $orders->fetchAll(PDO::FETCH_OBJ);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn-action {
        margin-right: 5px;
    }
</style>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-cart"></i> Orders</h5>
            
              <table class="table">
                <thead>
                  <tr>
                  <th scope="col"><i class="fas fa-user"></i> First Name</th>
                  <th scope="col"><i class="fas fa-user"></i> Last Name</th>
                  <th scope="col"><i class="fas fa-city"></i> Town</th>
                  <th scope="col"><i class="fas fa-flag"></i> State</th>
                  <th scope="col"><i class="fas fa-map-pin"></i> Zip code</th>
                  <th scope="col"><i class="fas fa-phone"></i> Phone No.</th>
                  <th scope="col"><i class="fas fa-road"></i> Street Address</th>
                  <th scope="col"><i class="fas fa-dollar-sign"></i> Total Price</th>
                  <th scope="col"><i class="fas fa-info-circle"></i> Status</th>
                  <th scope="col"><i class="fas fa-edit"></i> Update</th>
                  <th scope="col"><i class="fas fa-cogs"></i> Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allOrders as $order) : ?>
                  <tr>
                    <td><?php echo $order->first_name; ?></td>
                    <td><?php echo $order->last_name; ?></td>
                    <td><?php echo $order->town; ?></td>
                    <td><?php echo $order->state; ?></td>
                    <td>
                    <?php echo $order->zip_code; ?>
                    </td>
                    <td><?php echo $order->phone; ?></td>
                    <td><?php echo $order->street_address; ?></td>
                    <td><?php echo $order->total_price; ?></td>

                    <td style="color: <?php echo $order->status === 'Delivered' ? 'green' : ($order->status === 'Pending' ? 'orange' : 'black'); ?>; font-weight: bold;">
                        <?php echo $order->status; ?>
                    </td>

                    <td><a href="change-status.php?id=<?php echo $order->id; ?>" class="btn btn-warning  text-white text-center "><i class="fas fa-sync-alt"></i> Update Status</a></td>
                    <td><a href="delete-orders.php?id=<?php echo $order->id; ?>" class="btn btn-danger  text-center"><i class="fas fa-trash-alt"></i> Delete</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>

      <?php require "../layouts/footer.php"; ?>

  