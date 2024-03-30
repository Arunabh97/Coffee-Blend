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
          $update = $conn->prepare("UPDATE bookings SET status = :status WHERE id='$id'");
          $update->execute([
              ":status" => $status,
          ]);
          echo "<script>window.location.href = 'show-bookings.php';</script>";
      }
  }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-U3+K+F5ldqGz8U+XfW1deyOKNEdFG+4Bp2HBf5vHvXsfyM9Oo4+c2bqk4f+UZaBm" crossorigin="anonymous">

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Bookings Update Status</h5>
                <form method="POST" action="change-status.php?id=<?php echo $id; ?>">
                    <div class="form-outline mb-4 mt-4">
                        <select name="status" class="form-select form-control" aria-label="Default select example">
                            <option selected>Choose Status</option>
                            <option value="Pending">Pending <i class="fas fa-info-circle text-info"></i> - Waiting for confirmation</option>
                            <option value="Confirmed">Confirmed <i class="fas fa-check-circle text-success"></i> - Booking is confirmed</option>
                            <option value="In Progress">In Progress <i class="fas fa-sync-alt text-warning"></i> - Booking is in progress</option>
                            <option value="Cancelled">Cancelled <i class="fas fa-times-circle text-danger"></i> - Booking has been cancelled</option>
                            <option value="Done">Completed <i class="fas fa-check-circle text-success"></i> - Booking is completed</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center"><i class="fas fa-sync-alt"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>