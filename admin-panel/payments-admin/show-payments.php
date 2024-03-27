<?php
require "../layouts/header.php";
require "../../config/config.php";

// Check if the user is logged in
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit(); // Stop further execution
}

$paymentsQuery = $conn->query("SELECT id, user_id, payment_id, amount_paid, status, timestamp FROM payments ORDER BY timestamp DESC");
$payments = $paymentsQuery->fetchAll(PDO::FETCH_ASSOC);

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
        margin-top: 20px;
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
                <h5 class="card-title mb-4 d-inline"><i class="fas fa-money-bill-wave"></i> Payments</h5>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Serial No</th>
                            <th><i class="fas fa-id-card"></i> ID</th>
                            <th><i class="fas fa-user"></i> User ID</th>
                            <th><i class="fas fa-receipt"></i> Payment ID</th>
                            <th><i class="fas fa-coins"></i> Amount Paid</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-clock"></i> Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $serialNo = 1; ?>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?php echo $serialNo++; ?></td>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['user_id']; ?></td>
                            <td><?php echo $payment['payment_id']; ?></td>
                            <td><?php echo $payment['amount_paid']; ?></td>
                            <td><?php echo $payment['status']; ?></td>
                            <td><?php echo $payment['timestamp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>