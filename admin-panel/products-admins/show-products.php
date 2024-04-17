<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
// Check if admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit; 
}

$productType = isset($_GET['productType']) ? $_GET['productType'] : '';

$query = "SELECT * FROM products WHERE 1";

if (!empty($productType)) {
    $query .= " AND type = :productType";
}

$products = $conn->prepare($query);
if (!empty($productType)) {
    $products->bindValue(':productType', $productType);
}
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

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
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn {
        border-radius: 15px; 
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .text-danger td {
        background-color: #ffcccc; /* or any other shade of red */
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-12">
                    <div class="col-md-8">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-bag"></i> Products</h5>
                    </div>

                    <div class="col-md-2 text-right">
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
                
                <?php if (!empty($productType)) : ?>
                    <p class="lead">Filtering by product type: <strong><?php echo htmlspecialchars($productType); ?></strong></p>
                <?php endif; ?>

                <table id="productTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><i class="fas fa-id-card"></i> Id</th>
                            <th scope="col"><i class="fas fa-user"></i> Name</th>
                            <th scope="col"><i class="fas fa-image"></i> Image</th>
                            <th scope="col"><i class="fas fa-info-circle"></i> Description</th>
                            <th scope="col"><i class="fas fa-rupee-sign"></i> Price</th>
                            <th scope="col"><i class="fas fa-folder"></i> Type</th>
                            <th scope="col"><i class="fas fa-cubes"></i> Stock</th>
                            <th scope="col"><i class="fas fa-cogs"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allProducts as $product) : ?>
                            <tr <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>>
                                <th scope="row"><?php echo $product->id; ?></th>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>><?php echo $product->name; ?></td>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>><img src="images/<?php echo $product->image; ?>" style="width: 60px; height:60px;"></td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;"<?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>><?php echo $product->description; ?></td>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>>₹<?php echo $product->price; ?></td>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>><?php echo $product->type; ?></td>
                                <td <?php echo ($product->stock_quantity <= 10) ? 'class="text-danger"' : ''; ?>>
                                    <?php 
                                        if ($product->stock_quantity == 0) {
                                            echo '<span style="animation: blinker 1s linear infinite;"><strong>Out of Stock</strong></span>';
                                        } else if ($product->stock_quantity <= 10) {
                                            echo '<strong>Stock Low :</strong> <span class="text-danger">' . $product->stock_quantity . '</span>';
                                        } else {
                                            echo $product->stock_quantity;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="delete-products.php?id=<?php echo $product->id; ?>" class="btn btn-danger text-center"><i class="fas fa-trash-alt"></i> Delete</a>
                                    <a href="edit-products.php?id=<?php echo $product->id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                </td>
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
        $('#productTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>
