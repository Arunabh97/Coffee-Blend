<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$bookingsQuery = $conn->prepare("SELECT * FROM bookings ORDER BY created_at DESC");
$bookingsQuery->execute();
$allBookings = $bookingsQuery->fetchAll(PDO::FETCH_OBJ);

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

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

    .btn {
        border-radius: 15px; 
    }

    #bookingChart {
        max-width: 100%;
        max-height: 100%;
    }

    .dashboard-container {
        display: flex;
        justify-content: space-between;
    }

    .canvas-container {
        width: 50%;
        box-sizing: border-box;
    }

    .dashboard-overview {
        width: 45%; 
        box-sizing: border-box;
    }
    .overview-info {
        font-family: Arial, sans-serif;
        color: #333;
        font-size: 16px;
    }

    .overview-value {
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        color: #007bff;
    }

    .done-booking td {
    text-decoration: line-through;
    text-decoration-color: red; 
    text-decoration-thickness: 2px; 
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline"><i class="far fa-calendar"></i> Bookings</h5>

                <div class="dashboard-container">
                    <!-- Canvas on the left -->
                    <div class="canvas-container">
                        <canvas id="bookingChart" width="200" height="100"></canvas>
                    </div>

                    <!-- Dashboard Overview on the right -->
                    <div class="dashboard-overview">
                        <h3>Bookings Dashboard Overview</h3>
                        <?php
                        // Total Number of Bookings
                        $totalBookings = count($allBookings);
                        echo "<p class='overview-info'>Total Number of Bookings: <span class='overview-value'>$totalBookings</span></p>";

                        // Bookings per Day
                        $bookingsPerDay = [];
                        foreach ($allBookings as $booking) {
                            $bookingDate = $booking->date;
                            $bookingsPerDay[$bookingDate] = isset($bookingsPerDay[$bookingDate]) ? $bookingsPerDay[$bookingDate] + 1 : 1;
                        }

                        echo "<p class='overview-info'>Bookings per Day:</p>";
                        echo "<ul>";
                        foreach ($bookingsPerDay as $date => $count) {
                            echo "<li class='overview-value'>$date: $count bookings</li>";
                        }
                        echo "</ul>";

                        ?>
                    </div>
                </div>
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

                <table id="bookingTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><i class="fas fa-id-card"></i> Id</th>
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
                        <?php foreach ($allBookings as $booking) : ?>
                            <?php
                            // Determine if the status is "Done"
                            $doneClass = $booking->status === 'Done' ? 'done-booking' : '';
                            ?>
                            <tr class="<?php echo $doneClass; ?>">
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
                                <td><a href="change-status.php?id=<?php echo $booking->id; ?>" class="btn btn-warning text-white text-center"><i class="fas fa-sync-alt"></i> Change Status</a></td>
                                <td><?php echo $booking->created_at; ?></td>
                                <td><a href="delete-bookings.php?id=<?php echo $booking->id; ?>" class="btn btn-danger text-center"><i class="fas fa-trash-alt"></i> Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    var pendingCount = <?php echo $pendingCount; ?>;
    var confirmedCount = <?php echo $confirmedCount; ?>;
    var doneCount = <?php echo $doneCount; ?>;

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

<script>
    $(document).ready(function() {
        $('#bookingTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>