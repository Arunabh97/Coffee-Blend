<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if(!isset($_SERVER['HTTP_REFERER'])){
	echo "<script>window.location.href = 'http://localhost/coffee-blend';</script>";
	exit;
}

if(!isset($_SESSION['user_id'])){
	header("location: ".APPURL."");
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = :user_id");
$user_query->execute([':user_id' => $user_id]);
$user_data = $user_query->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    // Handle the case where user data is not found
    die("User data not found");
}

$logged_in_first_name = $user_data['first_name'];
$logged_in_last_name = $user_data['last_name'];
$logged_in_email = $user_data['email'];

$cartTotal = $conn->query("SELECT SUM(quantity*price) AS total FROM cart WHERE user_id='$_SESSION[user_id]'");
$cartTotal->execute();

$allCartTotal = $cartTotal->fetch(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {

    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['state'])
	|| empty($_POST['street_address']) || empty($_POST['town']) || empty($_POST['zip_code'])
	|| empty($_POST['phone']) || empty($_POST['email'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$state = $_POST['state'];
		$street_address = $_POST['street_address'];
		$town = $_POST['town'];
		$zip_code = $_POST['zip_code'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$user_id = $_SESSION['user_id'];
		$status = "Pending";
		$total_price = $_SESSION['total_price'];

		$payment_method = $_POST['payment_method'];

        if ($payment_method == "cashOnDelivery") {

         $place_orders = $conn->prepare("INSERT INTO orders (first_name, last_name, state,
            street_address, town, zip_code, phone, email, user_id, status, total_price, payment_type, payment_status) VALUES (:first_name,
            :last_name, :state, :street_address, :town, :zip_code, :phone, :email, :user_id, :status, :total_price, :payment_type, :payment_status)");

            $place_orders->execute([
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":state" => $state,
                ":street_address" => $street_address,
                ":town" => $town,
                ":zip_code" => $zip_code,
                ":phone" => $phone,
                ":email" => $email,
                ":user_id" => $user_id,
                ":status" => $status,
                ":total_price" => $total_price,
                ":payment_type" => "Cash On Delivery",
                ":payment_status" => "Pending",
            ]);

            // Get the last inserted order ID
            $order_id = $conn->lastInsertId();

            // Retrieve cart items
            $cartItemsQuery = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id");
            $cartItemsQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $cartItemsQuery->execute();
            $cartItems = $cartItemsQuery->fetchAll(PDO::FETCH_ASSOC);

            // Insert order items into the 'order_items' table
            $insertOrderItems = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, quantity, price)
                                            VALUES (:order_id, :product_id, :product_name, :product_image, :quantity, :price)");

            foreach ($cartItems as $cartItem) {
                $insertOrderItems->execute([
                    ':order_id'   => $order_id,
                    ':product_id' => $cartItem['pro_id'],
                    ':quantity'   => $cartItem['quantity'],
                    ':price'      => $cartItem['price'],
                    ':product_name' => $cartItem['name'],
                    ':product_image'=> $cartItem['image'],
                ]);

                // Update stock quantity
                $updateStockQuantity = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - :quantity WHERE id = :product_id");
                $updateStockQuantity->execute([
                    ':quantity'   => $cartItem['quantity'],
                    ':product_id' => $cartItem['pro_id'],
                ]);
            }

			// Clear the cart after placing the order
			$deleteCartItems = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
			$deleteCartItems->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$deleteCartItems->execute();
			
            echo "<script>alert('Your order has been placed successfully. Your Order ID is: $order_id');</script>";
            echo '<script>window.location.href="../users/orders.php";</script>';
            exit;

        	} elseif ($payment_method == "payOnline") {

            $_SESSION['order_data'] = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'state' => $state,
                'street_address' => $street_address,
                'town' => $town,
                'zip_code' => $zip_code,
                'phone' => $phone,
                'email' => $email,
                'user_id' => $user_id,
                'status' => 'Pending',
                'total_price' => $total_price,
                'payment_type' => "Online Payment",
                'payment_status' => "Pending",
            );

			// Retrieve cart items and store them in session
			$cartItemsQuery = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id");
			$cartItemsQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$cartItemsQuery->execute();
			$cartItems = $cartItemsQuery->fetchAll(PDO::FETCH_ASSOC);
		
			$_SESSION['cart_items'] = $cartItems;

            echo '<script>window.location.href="pay.php";</script>';
            exit; 
        }
    }
}

?>

<style>
	.form-control option {
    	color: black; 
}
</style>

<section class="home-slider owl-carousel">
   <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
         <div class="row slider-text justify-content-center align-items-center">
            <div class="col-md-7 col-sm-12 text-center ftco-animate">
               <h1 class="mb-3 mt-5 bread">Checkout</h1>
               <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Checkout</span></p>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="ftco-section">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12 ftco-animate">
		 	<form name="checkoutForm" action="checkout.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5" onsubmit="return validateForm();">
               <h3 class="mb-4 billing-heading">Billing Details</h3>
               <div class="row align-items-end">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input name="first_name" type="text" class="form-control" value="<?php echo htmlspecialchars($logged_in_first_name); ?>" placeholder="Enter your first name" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" type="text" class="form-control" value="<?php echo htmlspecialchars($logged_in_last_name); ?>" placeholder="Enter your last name" required>
                     </div>
                  </div>
                  <div class="w-100"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="state">State</label>
                        <div class="select-wrap">
                           <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                           <select name="state" id="" class="form-control">
                              <option value="Jharkhand">Jharkhand</option>
                              <option value="West Bengal">West Bengal</option>
                              <option value="Delhi">Delhi</option>
                              <option value="Karnataka">Karnataka</option>
                              <option value="Odisha">Odisha</option>
                              <option value="Gujrat">Gujrat</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="w-100"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="street_address">Street Address</label>
                        <input name="street_address" type="text" class="form-control" placeholder="House number and street name" required>
                     </div>
                  </div>
                  <!-- <div class="col-md-12">
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="Appartment, suite, unit etc: (optional)">
                       </div>
                     </div> -->
                  <div class="w-100"></div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="town">Town / City</label>
                        <input name="town" type="text" class="form-control" placeholder="Enter your town / city" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="zip_code">Postcode / ZIP *</label>
                        <input name="zip_code" type="text" class="form-control" placeholder="Enter your zip code" required>
                     </div>
                  </div>
                  <div class="w-100"></div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="phone">Phone</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text">+91</span>
                           </div>
                           <input name="phone" type="text" class="form-control" placeholder="Enter your phone number" minlength="10" maxlength="10" required>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="email">Email Address</label>
                        <input name="email" type="text" class="form-control" value="<?php echo htmlspecialchars($logged_in_email); ?>" placeholder="Enter your email address" readonly required>
                     </div>
                  </div>
                  <div class="w-100"></div>
                  <!-- <div class="col-md-12">
                     <div class="form-group mt-4">
                     <div class="radio">
                          <p><button type="submit" name="submit" class="btn btn-primary py-3 px-4">Place an order on pay</button></p>
                     
                     </div>
                     </div>
                     </div> -->
               </div>
               <div class="row mt-5 pt-3 d-flex">
                  <div class="col-md-6 d-flex">
                     <div class="cart-detail cart-total ftco-bg-dark p-3 p-md-4">
                        <h3 class="billing-heading mb-4">Cart Total</h3>
                        <p class="d-flex">
                           <span>Subtotal</span>
                           <span>₹<?php echo $allCartTotal->total; ?></span>
                        </p>
                        <p class="d-flex">
                           <span>Delivery</span>
                           <span>₹50</span>
                        </p>
                        <p class="d-flex">
                           <span>Discount</span>
                           <span>₹5</span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                           <span>Total</span>
                           <?php if($allCartTotal->total > 0) : ?>
                           <span>₹<?php echo $allCartTotal->total + 50 - 5; ?></span>
                           <?php endif; ?>
                        </p>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="cart-detail ftco-bg-dark p-3 p-md-4">
                        <h3 class="billing-heading mb-4">Payment Method</h3>
                        <div class="form-group">
                           <div class="col-md-12">
                              <div class="radio">
                                 <label><input type="radio" name="payment_method" value="cashOnDelivery" class="mr-2"> Cash On Delivery</label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-md-12">
                              <div class="radio">
                                 <label><input type="radio" name="payment_method" value="payOnline" class="mr-2"> Pay Online with Razorpay</label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-md-12">
                              <div class="checkbox">
                                 <label><input type="checkbox" id="termsCheckbox" value="" class="mr-2"> I have read and accept the terms and conditions</label>
                              </div>
                           </div>
                        </div>
                        <p><button type="submit" name="submit" class="btn btn-primary py-3 px-4">Place Order</button></p>
                     </div>
                  </div>
            </form>
            </div> 
         </div>
      </div>
   </div>
</section>

<script>
    function validateForm() {
        var firstName = document.forms["checkoutForm"]["first_name"].value;
        var lastName = document.forms["checkoutForm"]["last_name"].value;
        var state = document.forms["checkoutForm"]["state"].value;
        var streetAddress = document.forms["checkoutForm"]["street_address"].value;
        var town = document.forms["checkoutForm"]["town"].value;
        var zipCode = document.forms["checkoutForm"]["zip_code"].value;
        var phone = document.forms["checkoutForm"]["phone"].value;
        var email = document.forms["checkoutForm"]["email"].value;
        var paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        var termsCheckbox = document.getElementById("termsCheckbox");

        if (firstName == "" || lastName == "" || state == "" || streetAddress == "" || town == "" || zipCode == "" || phone == "" || email == "") {
            alert("All fields are required");
            return false;
        }

        if (!paymentMethod) {
            alert("Please select a payment method");
            return false;
        }

        if (!termsCheckbox.checked) {
            alert("Please accept the terms and conditions");
            return false;
        }

        return true;
    }
</script>

<?php require "../includes/footer.php"; ?>