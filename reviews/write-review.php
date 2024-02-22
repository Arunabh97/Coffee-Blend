<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: http://localhost/coffee-blend');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
}

if (isset($_POST['submit'])) {
    if (empty($_POST['review']) || empty($_POST['rating'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $review = $_POST['review'];
        $rating = $_POST['rating'];
        $username = $_SESSION['username'];

        $writeReview = $conn->prepare("INSERT INTO reviews (review, rating, username) VALUES (:review, :rating, :username)");

        $writeReview->execute([
            ":review" => $review,
            ":rating" => $rating,
            ":username" => $username,
        ]);

        echo "<script>alert('Review Submitted');</script>";
        header("location: " . APPURL . "/users/orders.php");
    }
}
?>

<!-- Add some CSS for styling the star rating -->
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
</style>

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Write Review</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Write Review</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form action="write-review.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                    <h3 class="mb-4 billing-heading">Write a Review</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea name="review" rows="5" cols="30" class="form-control" placeholder="Write Review"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <div class="rating">
                                    <?php
                                    // Display 5 stars dynamically
                                    for ($i = 5; $i >= 1; $i--) {
                                        echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '">';
                                        echo '<label for="star' . $i . '">&#9733;</label>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <div class="radio">
                                    <p><button type="submit" name="submit" class="btn btn-primary py-3 px-4">Submit Review</button></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

<?php require "../includes/footer.php"; ?>
