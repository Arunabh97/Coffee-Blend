<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

	if(!isset($_SESSION['user_id'])){
		header("location: ".APPURL."");
	}
	
	$products = $conn->query("SELECT cart.*, products.*, 
                          CASE 
                            WHEN cart.quantity > products.stock_quantity THEN products.stock_quantity
                            ELSE cart.quantity
                          END AS max_quantity 
                          FROM cart 
                          JOIN products ON cart.pro_id = products.id
                          WHERE cart.user_id = '$_SESSION[user_id]'");
	$products->execute();
	$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

	//cart total
	$cartTotal = $conn->query("SELECT SUM(quantity*price) AS total FROM cart WHERE user_id='$_SESSION[user_id]'");
	$cartTotal->execute();

	$allCartTotal = $cartTotal->fetch(PDO::FETCH_OBJ);

	define("CONSTANT_COUPON_CODE", "COFFEEBLEND10");

	if(isset($_POST['apply_coupon'])){
		$entered_coupon = $_POST['coupon_code'];

		if($entered_coupon === CONSTANT_COUPON_CODE){

			$discount_amount = 10; 
			$total_price = $allCartTotal->total + 50 - 5; 
			$discounted_price = $total_price - $discount_amount; 
			echo "<script>alert('Coupon code applied successfully! You got a ₹$discount_amount discount.');</script>";
		} else {
			echo "<script>alert('Invalid coupon code.');</script>";
		}
	}

	//proceed to checkout
	if(isset($_POST['checkout'])){

		$_SESSION['total_price'] = $_POST['total_price'];
		$_SESSION['total_discount'] = $_POST['total_discount'];

		//header("location: checkout.php");
		echo '<script>window.location.href="checkout.php";</script>';
	}

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
  #cart-icon {
    font-size: 80px;
    bottom: 40px;
    color: #3498db;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
  }

  #cart-icon:hover {
    transform: scale(1.1);
  }

  #empty-cart-message {
    font-size: 18px;
    font-weight: bold;
    color: #555;
    margin-top: 10px;
  }

  #menu-link:hover {
    color: #3498db;
  }

  .trash {
  display: inline-block;
  width: 20px; 
  height: 20px; 
  background-image: url('../images/trash.png'); 
  background-size: contain;
  background-repeat: no-repeat;
  cursor: pointer;
}

.trash:hover {
  filter: brightness(150%);
}

.discount-banner {
    background-color: #fdf5e6; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.discount-content {
    text-align: center;
}

.discount-content h2 {
    font-size: 28px;
    color: #ff7f50; 
	margin-top: 10px;
    margin-bottom: 10px;
}

.discount-content p {
    font-size: 18px;
    color: #333; 
    margin-bottom: 10px; 
}

</style>

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Cart</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Cart</span></p>
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
						<?php if(count($allProducts) > 0) : ?>
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
							  	<th class="product-remove-all">
								<a href="delete-cart.php" onclick="return confirm('Are you sure you want to remove all items from the cart?');">
									<span class="trash" title="Remove all items"></span>
								</a>
								</th>
						        <th>&nbsp;</th>
						        <th>Product</th>
						        <th>Price</th>
						        <th>Quantity</th>
						        <th>Total</th>
						      </tr>
						    </thead>
						    <tbody>
								<?php foreach($allProducts as $product) : ?>
						      <tr class="text-center">
							  <td class="product-remove">
									<a href="delete-product.php?id=<?php echo $product->id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
										<span class="icon-close"></span>
									</a>
								</td>
						        <td class="image-prod"><div class="img" style="background-image:url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $product->image; ?>);"></div></td>
						        
						        <td class="product-name">
						        	<h3><?php echo $product->name; ?></h3>
						        	<p><?php echo $product->description; ?></p>
						        </td>
						        
						        <td class="price">₹ <?php echo $product->price; ?></td>
						        
						        <td>
									<div style="position: relative;">
										<div class="input-group mb-3">
											<input type="number" name="quantity_<?php echo $product->id; ?>" class="quantity form-control input-number" value="<?php echo $product->quantity; ?>" min="1" max="10" data-product-id="<?php echo $product->id; ?>" style="padding: 7px;">
										</div>

										<div style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); text-align: center; margin-top:5px;">
											<p class="availability" style="color: #FFDAB9;">Available Stock: <?php echo $product->stock_quantity; ?></p>
										</div>
									</div>
								</td>
				        
								<td class="total">₹<?php echo $product->price * $product->quantity; ?></td>
								
						      </tr>

						      <?php endforeach; ?>
						    </tbody>
						  </table>
						  <?php else : ?>
							<i id="cart-icon" class="icon-shopping-cart"></i>
							<div id="empty-cart-message">
								Coffee shop cart is empty! ☕️
								</div>
							<?php endif; ?>
					  </div>
					  <a href="<?php echo APPURL; ?>/menu.php" id="menu-link">Click here to Explore Menu</a>
    			</div>
    		</div>
    		<div class="row justify-content-end">
				<div class="col-md-6 mt-5 ftco-animate float-left">
				<?php if(count($allProducts) > 0) : ?>
					<section class="discount-banner">
						<div class="container">
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="discount-content">
										<h2>Hurry! Limited Time Offer</h2>
										<p>Get 10% off on your order using coupon code COFFEEBLEND10</p>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php endif; ?>
				</div>

				<?php if(count($allProducts) > 0) : ?>
    			<div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
					<form method="POST" action="cart.php">
						<div class="form-group">
							<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter promo code">
							<button type="submit" name="apply_coupon" class="btn btn-primary" style="color: white !important; z-index: 1; margin-top:10px;">Apply</button>
						</div>
					</form>
    				<div class="cart-total mb-3">
    					<h3>Cart Totals</h3>
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
    						<span>
								₹<?php 
									$total_discount = isset($discounted_price) ? $discount_amount + 5 : 5; 
									echo $total_discount; 
								?>
							</span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
							<span>Total</span>
							<span><?php echo isset($discounted_price) ? '₹' . $discounted_price : '₹' . ($allCartTotal->total + 50 - 5); ?></span>
						</p>
    				</div>
					<form method="POST" action="cart.php" onsubmit="return confirm('Are you sure you want to proceed to checkout?');">
						<?php
						$total_price = $allCartTotal->total + 50 - 5; 
						if (isset($discounted_price)) {
							$total_price = $discounted_price + 5 - 5; 
						}
						?>
						<input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
						<input type="hidden" name="total_discount" value="<?php echo $total_discount; ?>">
						<?php if($allCartTotal->total > 0) : ?>
							<button name="checkout" type="submit" class="btn btn-primary" style="color: white !important; z-index: 1; font-weight: bold;">Proceed to Checkout</button>
						<?php endif; ?>
					</form>
				</div>
				<?php endif; ?>
    		</div>
		</div>
</section>

<script>

$(document).ready(function() {
    $('.quantity').on('change', function() {
        var productId = $(this).data('product-id');
        var newQuantity = $(this).val();
        var currentElement = $(this); 

        $.ajax({
            url: 'update-cart.php',
            method: 'POST',
            data: { product_id: productId, quantity: newQuantity },
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    alert(response.message);

                    var total = parseFloat(response.total);
                    var row = currentElement.closest('tr');
                    row.find('.total').text('₹' + total.toFixed(2));

                    var subtotal = 0;
                    $('.total').each(function() {
                        subtotal += parseFloat($(this).text().replace('₹', ''));
                    });
                    var totalWithDelivery = subtotal + 50 - 5;
                    $('.cart-total span:contains("Subtotal")').next().text('₹' + subtotal.toFixed(2));
                    $('.cart-total span:contains("Total")').next().text('₹' + totalWithDelivery.toFixed(2));
                } else {
                    alert(response.message);
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while updating quantity. Please try again later.');
                location.reload();
            }
        });
    });
});

</script>

<?php require "../includes/footer.php"; ?>