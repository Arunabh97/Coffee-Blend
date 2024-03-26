<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$productsPerPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($page - 1) * $productsPerPage;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$productType = isset($_GET['productType']) ? $_GET['productType'] : '';

$query = "SELECT * FROM products WHERE 1";

if (!empty($searchTerm)) {
    $query .= " AND name LIKE :searchTerm";
}

if (!empty($productType)) {
    $query .= " AND type = :productType";
}

$query .= " LIMIT :offset, :per_page";

$products = $conn->prepare($query);
$products->bindParam(':offset', $offset, PDO::PARAM_INT);
$products->bindParam(':per_page', $productsPerPage, PDO::PARAM_INT);

if (!empty($searchTerm)) {
    $products->bindValue(':searchTerm', '%' . $searchTerm . '%');
}

if (!empty($productType)) {
    $products->bindValue(':productType', $productType);
}

$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

$totalPages = ceil($totalProducts / $productsPerPage);

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

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-bag"></i> Products</h5>
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
                                <label for="productType" class="sr-only">Product Type</label>
                                <select class="form-control" id="productType" name="productType">
                                    <option value="">All Types</option>
                                    <option value="drink">Drinks</option>
                                    <option value="dessert">Desserts</option>
                                    <option value="appetizer">Appetizers</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-filter"></i></button>
                        </form>
                    </div>
                    <div class="col-md-2 text-right">
                        <a href="create-products.php" class="btn btn-primary mb-4"><i class="fa-solid fa-plus"></i> Create Products</a>
                    </div>
                </div>
    
                    <?php if (!empty($searchTerm)) : ?>
                        <p class="lead">Search results for: <strong><?php echo htmlspecialchars($searchTerm); ?></strong></p>
                    <?php endif; ?>

                    <?php if (!empty($productType)) : ?>
                        <p class="lead">Filtering by product type: <strong><?php echo htmlspecialchars($productType); ?></strong></p>
                    <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><i class="fas fa-hashtag"></i> Id</th>
                            <th scope="col"><i class="fas fa-user"></i> Name</th>
                            <th scope="col"><i class="fas fa-image"></i> Image</th>
                            <th scope="col"><i class="fas fa-rupee-sign"></i> Price</th>
                            <th scope="col"><i class="fas fa-folder"></i> Type</th>
                            <th scope="col"><i class="fas fa-cubes"></i> Stock</th>
                            <th scope="col"><i class="fas fa-cogs"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allProducts as $product) : ?>
                            <tr>
                                <th scope="row"><?php echo $product->id; ?></th>
                                <td><?php echo $product->name; ?></td>
                                <td><img src="images/<?php echo $product->image; ?>" style="width: 60px; height:60px;"></td>
                                <td>₹<?php echo $product->price; ?></td>
                                <td><?php echo $product->type; ?></td>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>>
                                    <?php 
                                        if ($product->stock_quantity == 0) {
                                            echo '<span style="animation: blinker 1s linear infinite;">Out of Stock</span>';
                                        } else if ($product->stock_quantity <= 10) {
                                            echo '<span class="text-danger">Stock Low : ' . $product->stock_quantity . '</span>';
                                        } else {
                                            echo $product->stock_quantity;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="delete-products.php?id=<?php echo $product->id; ?>" class="btn btn-danger  text-center"><i class="fas fa-trash-alt"></i> Delete</a>
                                    <a href="edit-products.php?id=<?php echo $product->id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Add pagination links -->
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
</div>

<?php require "../layouts/footer.php"; ?>
