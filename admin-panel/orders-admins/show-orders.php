<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
  }
  
  $ordersPerPage = 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $offset = ($page - 1) * $ordersPerPage;
  
  $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
  $filterType = isset($_GET['filter']) ? $_GET['filter'] : '';
  
  $query = "SELECT * FROM orders WHERE 1";
  
  if (!empty($searchTerm)) {
      $query .= " AND (first_name LIKE :searchTerm OR last_name LIKE :searchTerm)";
  }
  
  if (!empty($filterType)) {
      $query .= " AND status = :filterType";
  }
  
  $query .= " LIMIT :offset, :per_page";
  
  $ordersQuery = $conn->prepare($query);
  $ordersQuery->bindParam(':offset', $offset, PDO::PARAM_INT);
  $ordersQuery->bindParam(':per_page', $ordersPerPage, PDO::PARAM_INT);
  
  if (!empty($searchTerm)) {
      $searchParam = '%' . $searchTerm . '%';
      $ordersQuery->bindParam(':searchTerm', $searchParam);
  }
  
  if (!empty($filterType)) {
      $ordersQuery->bindParam(':filterType', $filterType);
  }
  
  $ordersQuery->execute();
  $allOrders = $ordersQuery->fetchAll(PDO::FETCH_OBJ);
  
  $totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
  $totalPages = ceil($totalOrders / $ordersPerPage);
  
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

    .pagination .prev,
    .pagination .next {
        padding: 8px 16px;
        margin: 0 5px;
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination .prev:hover,
    .pagination .next:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .table{
        margin-top: 20px;
    }
</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-cart"></i> Orders</h5>
                    </div>

                    <div class="col-md-4">
                        <form action="" method="GET" class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="search" class="sr-only">Search</label>
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Search</button>
                        </form>
                    </div>
                    <div class="col-md-2">
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

                <table class="table">
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
                                <td><?php echo $serial++; ?></td> <!-- Add the serial number -->
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

                                <td><a href="change-status.php?id=<?php echo $order->id; ?>" class="btn btn-warning  text-white text-center "><i class="fas fa-sync-alt"></i> Update Status</a></td>
                                <td><a href="delete-orders.php?id=<?php echo $order->id; ?>" class="btn btn-danger  text-center"><i class="fas fa-trash-alt"></i> Delete</a></td>
                                <td><a class="btn btn-success" href="../../users/print.php?order_id=<?php echo $order->id; ?>" target="_blank"><i class="fas fa-download"></i></a>OrdId: <?php echo $order->id; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

                <div class="pagination justify-content-center">
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

<?php require "../layouts/footer.php"; ?>

  