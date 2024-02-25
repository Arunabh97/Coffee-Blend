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
<style>
	.product-category-container {
    max-height: 650px;
    overflow-y: auto;
	margin: 20px 0;
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
	    				</div>
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-md-calendar"></span></div>
		            		<input name = "date" type="text" class="form-control appointment_date" placeholder="Date">
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
        <div class="row">
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

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
								<?php for ($i = 0; $i < ceil(count($allDrinks) / 3); $i++) : ?>
									<li data-target="#drinksCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allDrinks as $drink) : ?>
									<?php if ($count % 3 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-4 text-center">
									<div class="menu-wrap">
										<a href="products/product-single.php?id=<?php echo $drink->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $drink->image; ?>);"></a>
										<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $drink->id; ?>"><?php echo $drink->name; ?></a></h3>
											<p><?php echo $drink->description; ?></p>
											<p class="price"><span><?php echo $drink->price; ?></span></p>
											<p><a href="products/product-single.php?id=<?php echo $drink->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
										</div>
									</div>
									</div>
									<?php if ($count % 3 == 2 || $count === count($allDrinks) - 1) : ?>
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
								<?php for ($i = 0; $i < ceil(count($allDesserts) / 3); $i++) : ?>
									<li data-target="#dessertsCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allDesserts as $dessert) : ?>
									<?php if ($count % 3 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-4 text-center">
									<div class="menu-wrap">
										<a href="products/product-single.php?id=<?php echo $dessert->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $dessert->image; ?>);"></a>
										<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $dessert->id; ?>"><?php echo $dessert->name; ?></a></h3>
											<p><?php echo $dessert->description; ?></p>
											<p class="price"><span><?php echo $dessert->price; ?></span></p>
											<p><a href="products/product-single.php?id=<?php echo $dessert->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
										</div>
									</div>
									</div>
									<?php if ($count % 3 == 2 || $count === count($allDesserts) - 1) : ?>
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
								<?php for ($i = 0; $i < ceil(count($allAppetizers) / 3); $i++) : ?>
									<li data-target="#appetizersCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
								<?php endfor; ?>
							</ol>
							<div class="carousel-inner">
								<?php $count = 0; ?>
								<?php foreach ($allAppetizers as $appetizer) : ?>
									<?php if ($count % 3 == 0) : ?>
										<div class="carousel-item<?php echo ($count === 0) ? ' active' : ''; ?>">
											<div class="row">
									<?php endif; ?>
									<div class="col-md-4 text-center">
									<div class="menu-wrap">
										<a href="products/product-single.php?id=<?php echo $appetizer->id; ?>" class="menu-img img mb-4" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $appetizer->image; ?>);"></a>
										<div class="text">
											<h3><a href="products/product-single.php?id=<?php echo $appetizer->id; ?>"><?php echo $appetizer->name; ?></a></h3>
											<p><?php echo $appetizer->description; ?></p>
											<p class="price"><span><?php echo $appetizer->price; ?></span></p>
											<p><a href="products/product-single.php?id=<?php echo $appetizer->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
										</div>
									</div>
									</div>
									<?php if ($count % 3 == 2 || $count === count($allAppetizers) - 1) : ?>
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

    <?php require "includes/footer.php"; ?>