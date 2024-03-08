<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$bookings = $conn->query("SELECT * FROM bookings");
$bookings->execute();
$allBookings = $bookings->fetchAll(PDO::FETCH_OBJ);

// Count bookings based on status
$pendingCount = 0;
$confirmedCount = 0;
$doneCount = 0;

foreach ($allBookings as $booking) {
    switch ($booking->status) {
        case 'Pending':
            $pendingCount++;
            break;
        case 'Confirmed':
            $confirmedCount++;
            break;
        case 'Done':
            $doneCount++;
            break;
    }
}

// Filtered bookings based on status
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filteredBookings = [];

if ($filter == 'all') {
    $filteredBookings = $allBookings;
} else {
    foreach ($allBookings as $booking) {
        if ($booking->status == $filter) {
            $filteredBookings[] = $booking;
        }
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    #bookingChart {
        max-width: 100%;
        max-height: 40%;
    }
</style>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline"><i class="far fa-calendar"></i> Bookings</h5>

            <canvas id="bookingChart" width="200" height="100"></canvas>

             <!-- Search Bar and Filters -->
             <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name">
                </div>
                <div class="mb-3">
                    <select id="statusFilter" class="form-select">
                        <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Status</option>
                        <option value="Pending" <?php echo $filter == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Confirmed" <?php echo $filter == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Done" <?php echo $filter == 'Done' ? 'selected' : ''; ?>>Done</option>
                    </select>
                </div>

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
      <script>
    // Use PHP variables to pass data to JavaScript
    var pendingCount = <?php echo $pendingCount; ?>;
    var confirmedCount = <?php echo $confirmedCount; ?>;
    var doneCount = <?php echo $doneCount; ?>;

    // Chart.js configuration
    var ctx = document.getElementById('bookingChart').getContext('2d');
    var bookingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Confirmed', 'Done'],
            datasets: [{
                label: 'Booking Status',
                data: [pendingCount, confirmedCount, doneCount],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    // JavaScript for Search and Filters
    document.getElementById('searchInput').addEventListener('input', function () {
        var searchTerm = this.value.toLowerCase();
        var rows = document.querySelectorAll('tbody tr');

        rows.forEach(function (row) {
            var firstName = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            var lastName = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            var fullName = firstName + ' ' + lastName;

            if (fullName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('statusFilter').addEventListener('change', function () {
        var selectedStatus = this.value;
        var rows = document.querySelectorAll('tbody tr');

        rows.forEach(function (row) {
            var status = row.querySelector('td:nth-child(8)').innerText.toLowerCase();
            
            if (selectedStatus === 'all' || status.includes(selectedStatus.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php require "../layouts/footer.php"; ?>