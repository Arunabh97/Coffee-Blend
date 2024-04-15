<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

$reviews = $conn->query("SELECT * FROM reviews");
$reviews->execute();

$allReviews = $reviews->fetchAll(PDO::FETCH_OBJ);

?>

<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        margin-bottom: 10px;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        width: 30px;
        height: 30px;
        background-color: #ccc;
        border-radius: 50%;
        margin: 0 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .rating input:checked+label,
    .rating input:checked+label~label {
        background-color: #ffcc00;
        box-shadow: 0 0 10px rgba(255, 204, 0, 0.7);
    }
    
    .testimony {
    position: relative;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px; 
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5); 
        border-radius: 50%; 
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 120px; 
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(0, 0, 0, 0.7); 
    }
    
    .carousel-indicators li {
        background-color: white; 
        border-radius: 50%; 
        width: 15px; 
        height: 15px;
        margin-right: 5px; 
    }

    .carousel-indicators .active {
        background-color: yellow; 
    }
</style>

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url(images/bg_8.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">About Us</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>About</span></p>
                </div>
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
                <p>On her way, she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading">Testimony</span>
                <h2 class="mb-4">Customers Say</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="customerReviewsCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                        <?php
                        $chunkedReviews = array_chunk($allReviews, 4);
                        foreach ($chunkedReviews as $index => $reviewsChunk) :
                        ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($reviewsChunk as $review) : ?>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <div class="testimony">
                                                <blockquote>
                                                    <p>&ldquo;<?php echo $review->review; ?>.&rdquo;</p>
                                                </blockquote>
                                                <div class="rating">
                                                    <?php
                                                    for ($i = 5; $i >= 1; $i--) {
                                                        echo '<input type="radio" id="star' . $i . '_review_' . $review->id . '" name="rating_' . $review->id . '" value="' . $i . '" disabled';
                                                        if ($i == $review->rating) {
                                                            echo ' checked';
                                                        }
                                                        echo '>';
                                                        echo '<label for="star' . $i . '_review_' . $review->id . '">&#9733;</label>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="author d-flex mt-4">
                                                    <div class="name align-self-center">-<?php echo $review->username; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#customerReviewsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#customerReviewsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <ol class="carousel-indicators" style="position: absolute; bottom: -35px; left: 35%; transform: translateX(-50%);"> <!-- Adjust position as needed -->
                        <?php foreach ($chunkedReviews as $index => $reviewsChunk) : ?>
                            <li data-target="#customerReviewsCarousel" data-slide-to="<?php echo $index; ?>" class="<?php echo ($index === 0) ? 'active' : ''; ?>"></li>
                        <?php endforeach; ?>
                    </ol>
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

    <?php require "includes/footer.php"; ?>