<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit(); 
}

$paymentsQuery = $conn->prepare("SELECT id, user_id, payment_id, amount_paid, status, timestamp FROM payments ORDER BY timestamp DESC");
$paymentsQuery->execute();
$payments = $paymentsQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                <div class="row mb-3">
                    <div class="col-md-8">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-credit-card"></i> Payments</h5>
                    </div>
                </div>

                <table id="paymentTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S No.</th>
                            <th><i class="fas fa-id-card"></i> ID</th>
                            <th><i class="fas fa-user"></i> User ID</th>
                            <th><i class="fas fa-receipt"></i> Payment ID</th>
                            <th><i class="fas fa-coins"></i> Amount Paid</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-clock"></i> Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $serial = 1; 
                        foreach($payments as $payment) : ?>
                        <tr>
                            <td><?php echo $serial++; ?></td> 
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

<script>
    $(document).ready(function() {
        $('#paymentTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>
