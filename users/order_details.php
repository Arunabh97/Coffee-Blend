<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
    exit();
}

// Ensure that an order ID is provided in the URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    header("location: " . APPURL . "/orders.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details from the database
$orderDetailsQuery = $conn->prepare("SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id");
$orderDetailsQuery->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$orderDetailsQuery->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$orderDetailsQuery->execute();

$orderDetails = $orderDetailsQuery->fetch(PDO::FETCH_OBJ);

// Fetch items within the order with product details
$orderItemsQuery = $conn->prepare("SELECT oi.*, p.name AS product_name, p.image AS product_image FROM order_items oi
                                   INNER JOIN products p ON oi.product_id = p.id
                                   WHERE oi.order_id = :order_id");
$orderItemsQuery->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$orderItemsQuery->execute();

$orderedItems = $orderItemsQuery->fetchAll(PDO::FETCH_OBJ);
?>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <h2>Order Details - Order #<?php echo $orderDetails->id; ?></h2>
                    <p>Status: <?php echo $orderDetails->status; ?></p>
                    <p>Total Price: ₹<?php echo $orderDetails->total_price; ?></p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderedItems as $item) : ?>
                                <tr>
                                <td class="image-prod"><div class="img" style="background-image:url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $item->product_image; ?>);"></div></td>
                                    <td><?php echo $item->product_name; ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td>₹<?php echo $item->price; ?></td>
                                    <td>₹<?php echo number_format($item->quantity * $item->price, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-right mb-4">
                        <a href="<?php echo APPURL . '/users/orders.php'; ?>" class="btn btn-primary">&lt; Back to Orders</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require "../includes/footer.php"; ?>
