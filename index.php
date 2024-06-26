<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

	$isLoggedIn = isset($_SESSION['user_id']);

	if ($isLoggedIn) {
		$userId = $_SESSION['user_id'];
		$userQuery = $conn->prepare("SELECT first_name, last_name, phone FROM users WHERE id = ?");
		$userQuery->execute([$userId]);
		$user = $userQuery->fetch(PDO::FETCH_ASSOC);
	
		$firstName = $user['first_name'] ?? '';
		$lastName = $user['last_name'] ?? '';
		$phone = $user['phone'] ?? '';
	} else {
		$firstName = '';
		$lastName = '';
		$phone = '';
	}

	$products = $conn->query("SELECT * FROM products WHERE type='drink' AND id IN (1, 2, 3, 4)");

	$products->execute();

	$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

	//reviews
	$reviews = $conn->query("SELECT * FROM reviews");
	$reviews->execute();

	$allReviews = $reviews->fetchAll(PDO::FETCH_OBJ);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlCq6M9YLPp+J9NUw9d9Q5qlenLRMwe8U08dR5LzC2wU" crossorigin="anonymous">

<style>
	#ftco-testimony {
        margin: 0 40px; 
    }
    .rating {
        font-size: 24px;
        color: #FFD700; 
    }
	.testimony {
		position: relative;
		padding: 10px;
		border-radius: 20px;
		margin-bottom: 40px;
		background: #4CAF50; 
		color: #fff; 
		overflow: hidden;
		font-family: 'Open Sans', sans-serif; 
		box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2); 
	}

	.testimony blockquote {
		font-size: 20px;
		font-style: italic;
		margin-bottom: 20px;
		border-left: 4px solid #fff; 
		padding-left: 20px;
	}

	.testimony .rating {
		font-size: 24px;
		color: #fff;
		margin-bottom: 15px;
	}

	.testimony .author {
		margin-top: 15px;
		font-size: 18px;
		font-weight: bold;
	}

	.testimony .icon {
		position: absolute;
		top: -25px;
		left: 50%;
		transform: translateX(-50%);
		background-color: #fff;
		padding: 10px;
		border-radius: 50%;
	}

	.testimony .icon i {
		color: #4CAF50;
		font-size: 24px;
	}

	.testimony .overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(255, 255, 255, 0.3); 
		pointer-events: none; 
		transition: opacity 0.3s ease; 
		opacity: 0; 
	}

	.testimony:hover .overlay {
		opacity: 1; 
	}

	@keyframes fadeInOverlay {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}

	.carousel-control-prev, .carousel-control-next {
		color: #fff;
		font-size: 30px;
		opacity: 0.8;
		transition: opacity 0.3s ease; 
	}

	.carousel-control-prev:hover, .carousel-control-next:hover {
		color: #fff;
		opacity: 1;
	}

	.testimony:before {
		content: "";
		position: absolute;
		top: 50%;
		left: -50px;
		width: 100px;
		height: 100px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 50%;
		transform: translateY(-50%);
		animation: moveUpDown 2s infinite alternate; 
	}

	.testimony:after {
		content: "";
		position: absolute;
		bottom: -30px;
		right: -50px;
		width: 150px;
		height: 150px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 50%;
		transform: rotate(45deg);
		animation: rotateScale 3s infinite; 
	}

	@keyframes moveUpDown {
		from {
			top: 50%;
		}
		to {
			top: 40%;
		}
	}

	@keyframes rotateScale {
		from {
			transform: rotate(45deg) scale(1);
		}
		to {
			transform: rotate(45deg) scale(1.2);
		}
	}

	.testimonial-image {
		display: none; 
		text-align: center; 
	}

	.testimonial-image img {
		max-width: 100%; 
		max-height: 300px; 
		border-radius: 8px; 
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
		margin-top: 10px; 
	}

	.carousel-indicators li {
        background-color: white; 
        border-radius: 50%; 
        width: 15px; 
        height: 15px;
		margin-bottom: 20px;
    }

    .carousel-indicators .active {
        background-color: yellow; 
    }
</style>

<script>
    function redirectToLogin() {
        window.location.href = 'login.php';
    }
</script>

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url(images/bg_1.jpg);">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                <div class="col-md-8 col-sm-12 text-center ftco-animate">
                    <span class="subheading">Welcome</span>
                    <h1 class="mb-4">The Best Coffee Testing Experience</h1>
                    <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                    <p>
                        <?php if ($isLoggedIn) : ?>
                            <a href="products/cart.php" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php else : ?>
                            <a href="#" onclick="redirectToLogin()" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php endif; ?>
                        <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

      <div class="slider-item" style="background-image: url(images/bg_2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-8 col-sm-12 text-center ftco-animate">
            	<span class="subheading">Welcome</span>
              <h1 class="mb-4">Amazing Taste &amp; Beautiful Place</h1>
              <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              <p><?php if ($isLoggedIn) : ?>
                            <a href="products/cart.php" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php else : ?>
                            <a href="#" onclick="redirectToLogin()" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php endif; ?>
                        <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-8 col-sm-12 text-center ftco-animate">
            	<span class="subheading">Welcome</span>
              <h1 class="mb-4">Creamy Hot and Ready to Serve</h1>
              <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              <p><?php if ($isLoggedIn) : ?>
                            <a href="products/cart.php" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php else : ?>
                            <a href="#" onclick="redirectToLogin()" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a>
                        <?php endif; ?>
                        <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
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
	    						<p>Street 4, Dimna Chowk, Mango Jamshedpur, Jharkhand IN-831012</p>
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
								<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo isset($firstName) ? $firstName : ''; ?>" required>
							</div>

							<div class="form-group ml-md-4">
								<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo isset($lastName) ? $lastName : ''; ?>" required>
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
									<input name="time" type="text" class="form-control appointment_time" placeholder="Time" required>
								</div>
							</div>
							<div class="form-group ml-md-4">
								<input name="phone" type="text" class="form-control" placeholder="Phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required minlength="10" maxlength="10">
							</div>
						</div>
						<div class="d-md-flex">
							<div class="form-group">
								<textarea name="message" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
							</div>
							<?php if(isset($_SESSION['user_id'])) : ?>
							<div class="form-group ml-md-4">
								<button type="submit" name="submit" class="btn btn-white py-3 px-4">Book a table</button>
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

    <section class="ftco-about d-md-flex">
    	<div class="one-half img" style="background-image: url(images/about.jpg);"></div>
    	<div class="one-half ftco-animate">
    		<div class="overlap">
	        <div class="heading-section ftco-animate ">
	        	<span class="subheading">Discover</span>
	          <h2 class="mb-4">Our Story</h2>
	        </div>
	        <div>
	  				<p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
	  			</div>
  			</div>
    	</div>
    </section>

    <section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-choices"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Effortless Ordering</h3>
                <p>Dive into the finest blends with just a few clicks. Your coffee journey begins here. Start Your Coffee Adventure Today!</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-delivery-truck"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Express Delivery</h3>
                <p>Savor the aroma sooner than you think. We're committed to bringing your favorite brew to your doorstep.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-coffee-bean"></span></div>
              <div class="media-body">
                <h3 class="heading">Crafted with Care</h3>
                <p>From bean to cup, our dedication to quality shines through. Experience the taste of perfection in every sip.</p>
              </div>
            </div>    
          </div>
        </div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row align-items-center">
    			<div class="col-md-6 pr-md-5">
    				<div class="heading-section text-md-right ftco-animate">
	          	<span class="subheading">Discover</span>
	            <h2 class="mb-4">Our Menu</h2>
	            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
	            <p><a href="menu.php" class="btn btn-primary btn-outline-primary px-4 py-3">View Full Menu</a></p>
	          </div>
    			</div>
    			<div class="col-md-6">
    				<div class="row">
    					<div class="col-md-6">
    						<div class="menu-entry">
							<a href="<?php echo APPURL; ?>/products/product-single.php?id=1" class="img" style="background-image: url(images/menu-1.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="<?php echo APPURL; ?>/products/product-single.php?id=21" class="img" style="background-image: url(images/dessert-4.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry">
		    					<a href="<?php echo APPURL; ?>/products/product-single.php?id=14" class="img" style="background-image: url(images/image_6.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="<?php echo APPURL; ?>/products/product-single.php?id=34" class="img" style="background-image: url(images/menu-9.jpeg);"></a>
		    				</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
        	<div class="col-md-10">
        		<div class="row">
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="100">0</strong>
		              	<span>Coffee Branches</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="85">0</strong>
		              	<span>Number of Awards</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="10567">0</strong>
		              	<span>Happy Customer</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="900">0</strong>
		              	<span>Staff</span>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
          	<span class="subheading">Discover</span>
            <h2 class="mb-4">Best Coffee Sellers</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <div class="row">
			<?php foreach($allProducts as $product) : ?>
        	<div class="col-md-3">
        		<div class="menu-entry">
    					<a target="_blank" href="products/product-single.php?id=<?php echo $product->id; ?>" class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $product->image; ?>); height: 280px; background-size: cover;"></a>
    					<div class="text text-center pt-4">
    						<h3><a href="#"><?php echo $product->name; ?></a></h3>
    						<p><?php echo $product->description; ?></p>
    						<p class="price"><span>₹<?php echo $product->price; ?></span></p>
    						<p><a target="_blank" href="products/product-single.php?id=<?php echo $product->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
    					</div>
    				</div>
        	</div>
        	<?php endforeach; ?>

        </div>
    	</div>
    </section>

    <section class="ftco-gallery">
    	<div class="container-wrap">
    		<div class="row no-gutters">
					<div class="col-md-3 ftco-animate">
						<a href="gallery.php" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-1.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.php" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.php" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-8.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.php" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-4.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section>

    

<section class="ftco-section img" id="ftco-testimony" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading">Testimony</span>
                <h2 class="mb-4">Customers Say</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>
    </div>
    <div class="container-wrap">
		<div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php $reviewsChunks = array_chunk($allReviews, 4); ?>
				<?php foreach ($reviewsChunks as $index => $reviewsChunk) : ?>
					<div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
						<div class="row">
							<?php foreach ($reviewsChunk as $review) : ?>
								<div class="col-md-3 ftco-animate d-flex align-items-center">
									<div class="testimony" onclick="flipTestimony(this)">
										<div class="testimonial-content">
											<blockquote>
												<p>&ldquo;<?php echo $review->review; ?>.&rdquo;</p>
											</blockquote>
											<div class="rating">
												<?php
												// Display stars based on the user rating
												for ($i = 1; $i <= 5; $i++) {
													echo ($i <= $review->rating) ? '★' : '☆';
												}
												?>
											</div>
											<div class="author d-flex mt-4">
												<div class="name align-self-center">~ <?php echo $review->username; ?></div>
											</div>
										</div>
										<div class="testimonial-image" style="display: none;">
											<img src="reviews/uploads/<?php echo $review->image; ?>" alt="Review Image">
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<ol class="carousel-indicators" style="position: absolute; bottom: -25px; left: 35%; transform: translateX(-50%);">
				<?php foreach ($reviewsChunks as $index => $reviewsChunk) : ?>
					<li data-target="#testimonialCarousel" data-slide-to="<?php echo $index; ?>" class="<?php echo ($index === 0) ? 'active' : ''; ?>"></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>

<script>
	
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

	function flipTestimony(element) {
    var testimonialContent = element.querySelector('.testimonial-content');
    var testimonialImage = element.querySelector('.testimonial-image');

    if (testimonialContent.style.display === 'block') {
        testimonialContent.style.display = 'none';
        testimonialImage.style.display = 'block';
    } else {
        testimonialContent.style.display = 'block';
        testimonialImage.style.display = 'none';
    }
}

</script>

<?php require "includes/footer.php"; ?>