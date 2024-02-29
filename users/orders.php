<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $orderId = $_POST['order_id'];

    // Update the order status to "Cancelled"
    $cancelOrder = $conn->prepare("UPDATE orders SET status='Cancelled' WHERE id=:orderId AND user_id=:userId");
    $cancelOrder->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $cancelOrder->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $cancelOrder->execute();
}

$orders = $conn->prepare("SELECT * FROM orders WHERE user_id=:userId");
$orders->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
$orders->execute();

$allOrders = $orders->fetchAll(PDO::FETCH_OBJ);

?>
<!-- Include Font Awesome CSS in your HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Your Orders</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Orders</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <?php if (count($allOrders) > 0) : ?>
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr class="text-center">
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Town</th>
                                        <th>Street Address</th>
                                        <th>Phone</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allOrders as $order) : ?>
                                        <tr class="text-center">
                                            <td class="product-remove"><?php echo $order->first_name; ?></td>
                                            <td class="image-prod"><?php echo $order->last_name; ?></td>
                                            <td class="product-name">
                                                <h3><?php echo $order->town; ?></h3>
                                            </td>
                                            <td class="price"><?php echo $order->street_address; ?></td>
                                            <td class="price"><?php echo $order->phone; ?></td>
                                            <td>₹<?php echo $order->total_price; ?></td>
                                            <td class="total"><?php echo $order->status; ?></td>
                                            <td class="total">
    <?php if ($order->status == "Delivered") : ?>
        <a class="btn btn-primary" href="<?php echo APPURL; ?>/reviews/write-review.php">Write Review</a>
    <?php elseif ($order->status == "Pending" || $order->status == "Processing") : ?>
        <form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this order?');">
            <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
            <button type="submit" name="cancel_order" class="btn btn-link">
    <img src="../images/cancel-icon.png" alt="Cancel Order" width="40" height="40">
    
</button>
        </form>
    <?php else : ?>
        N/A
    <?php endif; ?>
</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <p>You do not have any orders for now</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require "../includes/footer.php"; ?>