<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '" . APPURL . "';</script>";
    exit();
}

// Ensure that an order ID is provided in the URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>window.location.href = '" . APPURL . "/orders.php';</script>";
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
<link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Order Details - Order #<?php echo $orderDetails->id; ?></h2>
            </div>
            <div class="col-md-6 text-right">
                <?php if ($orderDetails->status == "Delivered") : ?>
                    <div class="mb-3">
                        <a class="btn btn-success" href="print.php?order_id=<?php echo $orderDetails->id; ?>" target="_blank">
                            <i class='bx bx-receipt'></i> Invoice
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    
                    <p>Status: <?php $status = $orderDetails->status;
                                                $badge_class = '';

                                                switch ($status) {
                                                    case 'Delivered':
                                                        $badge_class = 'badge badge-success';
                                                        break;
                                                    case 'In Progress':
                                                        $badge_class = 'badge badge-primary';
                                                        break;
                                                    case 'Shipped':
                                                        $badge_class = 'badge badge-info';
                                                        break;
                                                    case 'Pending':
                                                    case 'Processing':
                                                        $badge_class = 'badge badge-warning';
                                                        break;
                                                    case 'Cancelled':
                                                        $badge_class = 'badge badge-danger';
                                                        break;
                                                    default:
                                                        $badge_class = 'badge badge-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="<?php echo $badge_class; ?>"><?php echo $status; ?></span></p>

                    <p>Total Price: ₹<?php echo $orderDetails->total_price; ?></p>
                    <p>Payment Type: <?php echo $orderDetails->pay_type; ?></p>
                    <p>Payment Status: <?php echo $orderDetails->pay_status; ?></p>

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
                                <td class="image-prod"><img src="<?php echo IMAGEPRODUCTS; ?>/<?php echo $item->product_image; ?>" alt="Product Image" class="img-fluid" style="max-width: 120px; max-height: 120px;"></td>
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
