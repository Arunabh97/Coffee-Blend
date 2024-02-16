<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

	if(isset($_GET['id'])){
		$id = $_GET['id'];

		//data for single product
		$product = $conn->query("SELECT * FROM products WHERE id='$id'");
		$product->execute();

		$singleProduct = $product->fetch(PDO::FETCH_OBJ);

		//data for related products
		$relatedProducts = $conn->query("SELECT * FROM products WHERE type='$singleProduct->type'
        	AND id!='$singleProduct->id'");

		$relatedProducts->execute();
		$allRelatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

		//add to cart
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$image = $_POST['image'];
			$price = $_POST['price'];
			$pro_id = $_POST['pro_id'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];  // Fixed typo here
			$user_id = $_SESSION['user_id'];
		
			$insert_cart = $conn->prepare("INSERT INTO cart (name, image, price, pro_id, description, quantity, user_id) VALUES (:name, :image, :price, :pro_id, :description, :quantity, :user_id)");

			$insert_cart->execute([
    			":name" => $name,
    			":image" => $image,
    			":price" => $price,
    			":pro_id" => $pro_id,
    			":description" => $description,
    			":quantity" => $quantity,  // Fixed typo here
    			":user_id" => $user_id,
			]);

			echo "<script>alert('Added to cart successfully'); </script>";

		}

		//validation for the cart
		if(isset($_SESSION['user_id'])){
			$validateCart = $conn->query("SELECT * FROM cart WHERE pro_id='$id' AND
			user_id='$_SESSION[user_id]'");
			$validateCart->execute();

			$rowCount = $validateCart->rowCount();
		}	
	} else {
		header("location: ".APPURL."/404.php");
	}
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- JavaScript for quantity adjustment -->
<script>
  $(document).ready(function () {
    // Plus button
    $('.quantity-right-plus').click(function (e) {
      e.preventDefault();
      if (!isItemAddedToCart()) {
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
      }
    });

    // Minus button
    $('.quantity-left-minus').click(function (e) {
      e.preventDefault();
      if (!isItemAddedToCart()) {
        var quantity = parseInt($('#quantity').val());
        if (quantity > 1) {
          $('#quantity').val(quantity - 1);
        }
      }
    });

    // Function to check if the item is added to the cart
    function isItemAddedToCart() {
      <?php if (isset($_SESSION['user_id']) && $rowCount > 0) : ?>
        alert('Item is already added to the cart. Quantity adjustment is disabled.');
        return true;
      <?php else : ?>
        return false;
      <?php endif; ?>
    }
  });
</script>

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Product Detail</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Product Detail</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-6 mb-5 ftco-animate">
    				<a href="images/menu-2.jpg" class="image-popup"><img src="<?php echo IMAGEPRODUCTS; ?>/<?php echo $singleProduct->image; ?>" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
    				<h3><?php echo $singleProduct->name; ?></h3>
    				<p class="price"><span><?php echo $singleProduct->price; ?></span></p>
    				<p>
					<?php echo $singleProduct->description; ?>
					</p>

    				<form method="POST" action="product-single.php?id=<?php echo $id; ?>">

						<div class="row mt-4">
							<div class="col-md-6">
								<!-- <div class="form-group d-flex">
		              <div class="select-wrap">
	                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
	                  <select name="" id="" class="form-control">
	                  	<option value="">Small</option>
	                    <option value="">Medium</option>
	                    <option value="">Large</option>
	                    <option value="">Extra Large</option>
	                  </select>
	                </div> -->
		            </div>
							</div>
							<div class="w-100"></div>
							<div class="input-group col-md-6 d-flex mb-3">
    <span class="input-group-btn mr-2">
        <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
            <i class="icon-minus"></i>
        </button>
    </span>
        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
        <span class="input-group-btn ml-2">
            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                <i class="icon-plus"></i>
            </button>
        </span>
</div>
          	</div>
				<input name="name" value="<?php echo $singleProduct->name; ?>" type="hidden">
				<input name="image" value="<?php echo $singleProduct->image; ?>" type="hidden">
				<input name="price" value="<?php echo $singleProduct->price; ?>" type="hidden">
				<input name="pro_id" value="<?php echo $singleProduct->id; ?>" type="hidden">
				<input name="description" value="<?php echo $singleProduct->description; ?>" type="hidden">
				<?php if(isset($_SESSION['user_id'])) :?>
				<?php if($rowCount > 0) : ?>
					<button style="margin-top: -335px;" name="submit" type="submit" class="btn btn-secondary py-3 px-5" disabled>Added to Cart</button>
				<?php else : ?>
				<button style="display: inline-block; position: relative; z-index: 1; padding: 2em; margin-top: -280px; margin-left: 632px; height: 65px;" name="submit" type="submit" class="btn btn-primary py-3 px-5 ">Add to Cart</button>
				<?php endif; ?>
				<?php else :  ?>
					<p style="margin-top: -270px; margin-left: 632px; height: 65px; font-weight: bold; color: white;">Login To Add Product To Cart</p>
				<?php endif; ?>
			</form>	
		</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
          	<span class="subheading">Discover</span>
            <h2 class="mb-4">Related products</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <div class="row">
		<?php foreach ($allRelatedProducts as $relatedProduct) : ?>
    <div class="col-md-3">
        <div class="menu-entry">
            <a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $relatedProduct->id; ?>" class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $relatedProduct->image; ?>);"></a>
            <div class="text text-center pt-4">
                <h3><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $relatedProduct->id; ?>"><?php echo $relatedProduct->name; ?></a></h3>
                <p><?php echo $relatedProduct->description; ?></p>
                <p class="price"><span><?php echo $relatedProduct->price; ?></span></p>
                <p><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $relatedProduct->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
        </div>
    	</div>
    </section>
	<?php require "../includes/footer.php"; ?>