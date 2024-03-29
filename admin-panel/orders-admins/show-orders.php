<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$filterType = isset($_GET['filter']) ? $_GET['filter'] : '';

$query = "SELECT * FROM orders WHERE 1";

if (!empty($filterType)) {
    $query .= " AND status = :filterType";
}

$query .= " ORDER BY created_at DESC";

$ordersQuery = $conn->prepare($query);

if (!empty($filterType)) {
    $ordersQuery->bindParam(':filterType', $filterType);
}

$ordersQuery->execute();
$allOrders = $ordersQuery->fetchAll(PDO::FETCH_OBJ);
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
        margin-top: 20px;
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

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-cart"></i> Orders</h5>
                    </div>

                    <div class="col-md-2 text-right">
                        <form action="" method="GET" class="form-inline">
                            <div class="form-group mb-2 mr-1">
                                <label for="status" class="sr-only">Status</label>
                                <select class="form-control" id="status" name="filter">
                                    <option value="">All Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-filter"></i> </button>
                        </form>
                    </div>
                </div>
                    <?php if (!empty($filterType)) : ?>
                    <p class="lead">Filtering by status type: <strong><?php echo htmlspecialchars($filterType); ?></strong></p>
                    <?php endif; ?>
                
                    <table id="orderTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">S No.</th>
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
                            <th scope="col"><i class="fas fa-file-invoice"></i> Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $serial = 1; // Initialize the serial number
                        foreach($allOrders as $order) : ?>
                            <tr>
                                <td><?php echo $serial++; ?></td> 
                                <td><?php echo $order->first_name; ?></td>
                                <td><?php echo $order->last_name; ?></td>
                                <td><?php echo $order->town; ?></td>
                                <td><?php echo $order->state; ?></td>
                                <td><?php echo $order->zip_code; ?></td>
                                <td><?php echo $order->phone; ?></td>
                                <td><?php echo $order->street_address; ?></td>
                                <td>₹<?php echo $order->total_price; ?></td>
                                <td style="color: <?php echo $order->status === 'Delivered' ? 'green' : ($order->status === 'Pending' ? 'orange' : 'black'); ?>; font-weight: bold;">
                                    <?php echo $order->status; ?>
                                </td>
                                <td><a href="change-status.php?id=<?php echo $order->id; ?>" class="btn btn-warning text-white text-center"><i class="fas fa-sync-alt"></i> Update Status</a></td>
                                <td><a href="delete-orders.php?id=<?php echo $order->id; ?>" class="btn btn-danger text-center"><i class="fas fa-trash-alt"></i> Delete</a></td>
                                <td><a class="btn btn-success" href="../../users/print.php?order_id=<?php echo $order->id; ?>" target="_blank"><i class="fas fa-download"></i></a>OrdId: <?php echo $order->id; ?></td>
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
        $('#orderTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>

  