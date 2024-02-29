<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."/admins/login-admins.php");
}

$bookings = $conn->query("SELECT * FROM bookings");
$bookings->execute();

$allBookings = $bookings->fetchAll(PDO::FETCH_OBJ);

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
              <h5 class="card-title mb-4 d-inline"><i class="far fa-calendar"></i> Bookings</h5>
            
              <table class="table">
                <thead>
                  <tr>
                  <th scope="col"><i class="fas fa-hashtag"></i> Id</th>
                  <th scope="col"><i class="fas fa-user"></i> First Name</th>
                  <th scope="col"><i class="fas fa-user"></i> Last Name</th>
                  <th scope="col"><i class="fas fa-calendar"></i> Date</th>
                  <th scope="col"><i class="fas fa-clock"></i> Time</th>
                  <th scope="col"><i class="fas fa-phone"></i> Phone</th>
                  <th scope="col"><i class="fas fa-envelope"></i> Message</th>
                  <th scope="col"><i class="fas fa-info-circle"></i> Status</th>
                  <th scope="col"><i class="fas fa-sync-alt"></i> Change Status</th>
                  <th scope="col"><i class="fas fa-clock"></i> Created_At</th>
                  <th scope="col"><i class="fas fa-cogs"></i> Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allBookings as $booking) : ?>
                  <tr>
                    <th scope="row"><?php echo $booking->id; ?></th>
                    <td><?php echo $booking->first_name; ?></td>
                    <td><?php echo $booking->last_name; ?></td>
                    <td><?php echo $booking->date; ?></td>
                    <td><?php echo $booking->time; ?></td>
                    <td><?php echo $booking->phone; ?></td>
                    <td><?php echo $booking->message; ?></td>
                    <td style="color: <?php echo $booking->status === 'Pending' ? 'orange' : ($booking->status === 'Confirmed' ? 'green' : ($booking->status === 'Done' ? 'blue' : 'black')); ?>; font-weight: bold;">
                        <?php echo $booking->status; ?>
                    </td>
                    <td><a href="change-status.php?id=<?php echo $booking->id; ?>" class="btn btn-warning  text-white text-center "><i class="fas fa-sync-alt"></i> Change Status</a></td>
                    <td><?php echo $booking->created_at; ?></td>
                    
                     <td><a href="delete-bookings.php?id=<?php echo $booking->id; ?>" class="btn btn-danger  text-center "><i class="fas fa-trash-alt"></i> Delete</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>


<?php require "../layouts/footer.php"; ?>