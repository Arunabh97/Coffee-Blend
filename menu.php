<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

$desserts = $conn->query("SELECT * FROM products WHERE type='dessert'");
$desserts->execute();

$allDesserts = $desserts->fetchAll(PDO::FETCH_OBJ);

//grapping drinks
$drinks = $conn->query("SELECT * FROM products WHERE type='drink'");
$drinks->execute();

$allDrinks = $drinks->fetchAll(PDO::FETCH_OBJ);

//grapping appetizers
$appetizers = $conn->query("SELECT * FROM products WHERE type='appetizer'");
$appetizers->execute();

$allAppetizers = $appetizers->fetchAll(PDO::FETCH_OBJ);

?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
.product-category-container {
    max-height: 650px;
    overflow-y: auto;
	margin: 20px 0;
}

#searchInput {
    padding: 12px;
    border: 2px solid #3498db;
    border-radius: 25px;
    font-size: 15px;
    width: 300px;
    margin-bottom: 20px;
    outline: none;
    transition: border-color 0.3s ease-in-out;
}

#searchInput:focus {
    border-color: #2ecc71;
}

#searchResults {
    background-color: #ffffff;
    border-radius: 5px;
	padding: none;
    padding-left: 10px;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.searchResult {
    padding: 8px;
    margin-bottom: 8px;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s ease-in-out;
}

.searchResult:hover {
    background-color: #f9f9f9;
}

::placeholder {
    color: #aaa;
    opacity: 1; 
}

#searchResults::-webkit-scrollbar {
    width: 8px;
}

#searchResults::-webkit-scrollbar-thumb {
    background-color: #3498db;
    border-radius: 10px;
}

</style>

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(images/bg_6.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Our Menu</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Menu</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-intro">
    	<div class="container-wrap">
    		<div class="wrap d-md-flex align-items-xl-end">
	    		<div class="info">
	    			<div class="row no-gutters">
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-phone"></span></div>
	    					<div class="text">
	    						<h3>+91 22 1234 5678</h3>
	    						<p>A small river named Duden flows by their place and supplies.</p>
	    					</div>
	    				</div>
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-my_location"></span></div>
	    					<div class="text">
	    						<h3>198 West 21th Street</h3>
	    						<p>	Street 4, Dimna Chowk, Mango Jamshedpur, Jharkhand IN-831012</p>
	    					</div>
	    				</div>
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-clock-o"></span></div>
	    					<div class="text">
	    						<h3>Open Monday-Friday</h3>
	    						<p>8:00am - 9:00pm</p>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    		<div class="book p-4">
	    			<h3>Book a Table</h3>
	    			<form action="booking/book.php" method="POST" class="appointment-form">
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<input name = "first_name" type="text" class="form-control" placeholder="First Name">
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<input name = "last_name" type="text" class="form-control" placeholder="Last Name">
		    				</div>
							<div class="form-group ml-md-4">
								<input name="seats" type="number" class="form-control" placeholder="Seats" required min="1" max="10">
							</div>
	    				</div>
	    				<div class="d-md-flex">
							<div class="form-group">
								<div class="input-wrap">
								<input name="date" type="date" class="form-control" placeholder="Date" min="<?php echo date('Y-m-d'); ?>" required>
								</div>
            				</div>
		    				<div class="form-group ml-md-4">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-ios-clock"></span></div>
		            		<input name = "time" type="text" class="form-control appointment_time" placeholder="Time">
	            		</div>
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<input name = "phone" type="text" class="form-control" placeholder="Phone">
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group">
		              <textarea name="message" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
		            </div>

					<?php if(isset($_SESSION['user_id'])) : ?>
		            <div class="form-group ml-md-4">
		              <input name = "submit" type="submit" value="Book Table" class="btn btn-white py-3 px-4">
		            </div>
					<?php else : ?>
						<p class="text-white">Login to Book Table </p>
					<?php endif; ?>
					
	    				</div>
	    			</form>
	    		</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">

		<input type="text" id="searchInput" placeholder="Search for products">
		<div id="searchResults"></div>

        <div class="row">
			<div class="col-md-6 product-category-container">
				<h3 class="mb-5 heading-pricing ftco-animate">Drinks</h3>
				<?php foreach($allDrinks as $drink) : ?>
					<div class="pricing-entry d-flex ftco-animate">
						<div class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $drink->image; ?>);"></div>
						<div class="desc pl-3">
							<div class="d-flex text align-items-center">
								<h3><span><?php echo $drink->name; ?></span></h3>
								<span class="price">₹<?php echo $drink->price; ?></span>
							</div>
							<div class="d-block">
								<p><?php echo $drink->description; ?></p>
								<?php if ($drink->stock_quantity > 0) : ?>
									<span class="availability" style="color: yellow;">In Stock (<?php echo $drink->stock_quantity; ?> available)</span>
									<?php
									$productId = $drink->id;
									if (isset($_SESSION['user_id'])) { // Check if user is logged in
										$checkIfExists = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND pro_id = ?");
										$checkIfExists->execute([$_SESSION['user_id'], $productId]);
										$productInCart = $checkIfExists->fetch();
										?>
										<button class="btn btn-primary float-right add-to-cart-btn" data-product-id="<?php echo $productId; ?>" <?php echo ($productInCart ? 'disabled' : ''); ?>>
											<?php echo $productInCart ? 'Added to Cart' : 'Add to Cart'; ?>
										</button>
									<?php
									}
									?>
								<?php else : ?>
									<p class="availability"><span class="text-danger">Out of Stock</span></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			
            <div class="col-md-6 product-category-container">
				<h3 class="mb-5 heading-pricing ftco-animate">Desserts</h3>
				<?php foreach($allDesserts as $dessert) : ?>
					<div class="pricing-entry d-flex ftco-animate">
						<div class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $dessert->image; ?>);"></div>
						<div class="desc pl-3">
							<div class="d-flex text align-items-center">
								<h3><span><?php echo $dessert->name; ?></span></h3>
								<span class="price">₹<?php echo $dessert->price; ?></span>
							</div>
							<div class="d-block">
								<p><?php echo $dessert->description; ?></p>
								<?php if ($dessert->stock_quantity > 0) : ?>
									<span class="availability" style="color: yellow;">In Stock (<?php echo $dessert->stock_quantity; ?> available)</span>
									<?php
									$productId = $dessert->id;
									if (isset($_SESSION['user_id'])) { // Check if user is logged in
										$checkIfExists = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND pro_id = ?");
										$checkIfExists->execute([$_SESSION['user_id'], $productId]);
										$productInCart = $checkIfExists->fetch();
										?>
										<button class="btn btn-primary float-right add-to-cart-btn" data-product-id="<?php echo $productId; ?>" <?php echo ($productInCart ? 'disabled' : ''); ?>>
											<?php echo $productInCart ? 'Added to Cart' : 'Add to Cart'; ?>
										</button>
									<?php
									}
									?>
								<?php else : ?>
									<span class="availability"><span class="text-danger">Out of Stock</span></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>


            <div class="col-md-6 product-category-container">
				<h3 class="mb-5 heading-pricing ftco-animate">Appetizers</h3>
				<?php foreach($allAppetizers as $appetizer) : ?>
					<div class="pricing-entry d-flex ftco-animate">
						<div class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $appetizer->image; ?>);"></div>
						<div class="desc pl-3">
							<div class="d-flex text align-items-center">
								<h3><span><?php echo $appetizer->name; ?></span></h3>
								<span class="price">₹<?php echo $appetizer->price; ?></span>
							</div>
							<div class="d-block">
								<p><?php echo $appetizer->description; ?></p>
								<?php if ($appetizer->stock_quantity > 0) : ?>
									<span class="availability" style="color: yellow;">In Stock (<?php echo $appetizer->stock_quantity; ?> available)</span>
									<?php
									$productId = $appetizer->id;
									if (isset($_SESSION['user_id'])) { // Check if user is logged in
										$checkIfExists = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND pro_id = ?");
										$checkIfExists->execute([$_SESSION['user_id'], $productId]);
										$productInCart = $checkIfExists->fetch();
										?>
										<button class="btn btn-primary float-right add-to-cart-btn" data-product-id="<?php echo $productId; ?>" <?php echo ($productInCart ? 'disabled' : ''); ?>>
											<?php echo $productInCart ? 'Added to Cart' : 'Add to Cart'; ?>
										</button>
									<?php
									}
									?>
								<?php else : ?>
									<span class="availability"><span class="text-danger">Out of Stock</span></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
        </div>
    </div>
</section>


    <section class="ftco-menu mb-5 pb-5">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Discover</span>
            <h2 class="mb-4">Our Products</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
    		<div class="row d-md-flex">
	    		<div class="col-lg-12 ftco-animate p-md-5">
		    		<div class="row">
		          <div class="col-md-12 nav-link-wrap mb-5">
		            <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">

		              <a class="nav-link active" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Drinks</a>

		              <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Desserts</a>

					  <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Appetizers</a>
		            </div>
		          </div>
		          <div class="col-md-12 d-flex align-items-center">
		            
		            <div class="tab-content ftco-animate" id="v-pills-tabContent">

					<div class="tab-pane fade show active" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
						<div id="drinksCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
							<ol class="carousel-indicators">
								<?php for ($i = 0; $i < ceil(count($allDrinks) / 4); $i++) : ?>
									<li data-target="#drinksCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allDrinks as $drink) : ?>
									<?php if ($count % 4 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-3 text-center">
										<div class="menu-wrap">
											<a href="products/product-single.php?id=<?php echo $drink->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $drink->image; ?>);"></a>
											<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $drink->id; ?>"><?php echo strlen($drink->name) > 15 ? substr($drink->name, 0, 15) . '...' : $drink->name; ?></a></h3>
												<p><?php echo strlen($drink->description) > 50 ? substr($drink->description, 0, 50) . '...' : $drink->description; ?></p>
												<p class="price"><span>₹<?php echo $drink->price; ?></span></p>
												<?php if ($drink->stock_quantity > 0) : ?>
													<p class="availability"><span style="color: yellow;">In Stock (<?php echo $drink->stock_quantity; ?> available)</span></p>
												<?php else : ?>
													<p class="availability"><span class="text-danger">Out of Stock</span></p>
												<?php endif; ?>
												<p><a href="products/product-single.php?id=<?php echo $drink->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
											</div>
										</div>
									</div>
									<?php if ($count % 4 == 3 || $count === count($allDrinks) - 1) : ?>
											</div>
										</div>
									<?php endif; ?>
									<?php $count++; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
						<div id="dessertsCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
							<ol class="carousel-indicators">
								<?php for ($i = 0; $i < ceil(count($allDesserts) / 4); $i++) : ?>
									<li data-target="#dessertsCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allDesserts as $dessert) : ?>
									<?php if ($count % 4 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-3 text-center">
										<div class="menu-wrap">
											<a href="products/product-single.php?id=<?php echo $dessert->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $dessert->image; ?>);"></a>
											<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $dessert->id; ?>"><?php echo strlen($dessert->name) > 15 ? substr($dessert->name, 0, 15) . '...' : $dessert->name; ?></a></h3>
												<p><?php echo strlen($dessert->description) > 50 ? substr($dessert->description, 0, 50) . '...' : $dessert->description; ?></p>
												<p class="price"><span>₹<?php echo $dessert->price; ?></span></p>
												<?php if ($dessert->stock_quantity > 0) : ?>
													<p class="availability"><span style="color: yellow;">In Stock (<?php echo $dessert->stock_quantity; ?> available)</span></p>
												<?php else : ?>
													<p class="availability"><span class="text-danger">Out of Stock</span></p>
												<?php endif; ?>
												<p><a href="products/product-single.php?id=<?php echo $dessert->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
											</div>
										</div>
									</div>
									<?php if ($count % 4 == 3 || $count === count($allDesserts) - 1) : ?>
											</div>
										</div>
									<?php endif; ?>
									<?php $count++; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
						<div id="appetizersCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
							<ol class="carousel-indicators">
								<?php for ($i = 0; $i < ceil(count($allAppetizers) / 4); $i++) : ?>
									<li data-target="#appetizersCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allAppetizers as $appetizer) : ?>
									<?php if ($count % 4 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-3 text-center">
										<div class="menu-wrap">
											<a href="products/product-single.php?id=<?php echo $appetizer->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $appetizer->image; ?>);"></a>
											<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $appetizer->id; ?>"><?php echo strlen($appetizer->name) > 15 ? substr($appetizer->name, 0, 15) . '...' : $appetizer->name; ?></a></h3>
												<p><?php echo strlen($appetizer->description) > 50 ? substr($appetizer->description, 0, 50) . '...' : $appetizer->description; ?></p>
												<p class="price"><span>₹<?php echo $appetizer->price; ?></span></p>
												<?php if ($appetizer->stock_quantity > 0) : ?>
													<p class="availability"><span style="color: yellow;">In Stock (<?php echo $appetizer->stock_quantity; ?> available)</span></p>
												<?php else : ?>
													<p class="availability"><span class="text-danger">Out of Stock</span></p>
												<?php endif; ?>
												<p><a href="products/product-single.php?id=<?php echo $appetizer->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
											</div>
										</div>
									</div>
									<?php if ($count % 4 == 3 || $count === count($allAppetizers) - 1) : ?>
											</div>
										</div>
									<?php endif; ?>
									<?php $count++; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
    	</div>
    </section>

<script>
$(document).ready(function() {
    $(".btn-primary").on("click", function() {
        var button = $(this);
        var productId = button.data("product-id");

        $.ajax({
            type: "POST",
            url: "addToCart.php",
            data: { product_id: productId },
            success: function(response) {
                if (response === "added") {
                    button.prop("disabled", true);
                    alert("Product added to the cart.");
					location.reload();
                } else if (response === "exists") {
                    alert("Product is already in the cart.");
                } else {
                    alert("Error adding product to cart.");
                }
            }
        });
    });
});

$(document).ready(function() {
        $('.appointment_time').timepicker({
            timeFormat: 'H:i',
            interval: 30,
            minTime: '08:00am',
            maxTime: '09:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });

</script>

<script>
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        var query = $(this).val();
        if (query.length >= 2) { // Minimum characters to start search
            searchProducts(query);
        } else {
            $('#searchResults').empty(); // Clear search results if query is too short
        }
    });
});

function searchProducts(query) {
    $.ajax({
        type: 'GET',
        url: 'searchProducts.php',
        data: { query: query },
        dataType: 'json',
        success: function(response) {
            displaySearchResults(response);
        },
        error: function() {
            console.log('Error fetching search results');
        }
    });
}

function displaySearchResults(results) {
    var searchResultsDiv = $('#searchResults');
    searchResultsDiv.empty();

    if (results.length > 0) {
        $.each(results, function(index, product) {
            var productLink = '<a href="products/product-single.php?id=' + product.id + '">' + product.name + '</a>';
            searchResultsDiv.append('<div>' + productLink + '</div>');
        });
    } else {
        searchResultsDiv.append('<div>No results found</div>');
    }
}

</script>

<?php require "includes/footer.php"; ?>