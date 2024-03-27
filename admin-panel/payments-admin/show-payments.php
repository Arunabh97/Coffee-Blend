<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit(); 
}

$paymentsPerPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $paymentsPerPage;

$paymentsQuery = $conn->prepare("SELECT id, user_id, payment_id, amount_paid, status, timestamp FROM payments ORDER BY timestamp DESC LIMIT :offset, :per_page");
$paymentsQuery->bindParam(':offset', $offset, PDO::PARAM_INT);
$paymentsQuery->bindParam(':per_page', $paymentsPerPage, PDO::PARAM_INT);
$paymentsQuery->execute();
$payments = $paymentsQuery->fetchAll(PDO::FETCH_ASSOC);

// Total number of payments
$totalPayments = $conn->query("SELECT COUNT(*) FROM payments")->fetchColumn();
$totalPages = ceil($totalPayments / $paymentsPerPage);

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

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination a {
        color: #007bff;
        padding: 8px 12px;
        text-decoration: none;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a.active,
    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
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
                    <?php $serialNo = $offset + 1; ?>
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

                <div class="pagination">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
