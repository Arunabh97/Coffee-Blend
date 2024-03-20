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

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $imageName;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {

                if (in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
                    // Upload image to server
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        
                        $writeReview = $conn->prepare("INSERT INTO reviews (review, rating, username, image) VALUES (:review, :rating, :username, :image)");
                        $writeReview->execute([
                            ":review" => $review,
                            ":rating" => $rating,
                            ":username" => $username,
                            ":image" => $imageName
                        ]);

                        echo "<script>alert('Review Submitted');</script>";
                        echo "<script>window.history.go(-2);</script>";
                    } else {
                        echo "<script>alert('Error uploading image');</script>";
                    }
                } else {
                    echo "<script>alert('Invalid image format');</script>";
                }
            } else {
                echo "<script>alert('File is not an image');</script>";
            }
        } else {
            echo "<script>alert('Image not uploaded');</script>";
        }
    }
}
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
                <form action="write-review.php" method="POST" enctype="multipart/form-data" class="billing-form ftco-bg-dark p-3 p-md-5">
                    <h3 class="mb-4 billing-heading">Write a Review</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="review">Review (Maximum 25 words)</label>
                                <textarea name="review" id="review" rows="5" cols="30" class="form-control" placeholder="Write Review"></textarea>
                                <span id="wordCount"></span>
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
                            <div class="form-group">
                                <label for="image">Upload Image</label>
                                <input type="file" name="image" id="image" class="form-control-file">
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
            </div> 
        </div>
    </div>
</section> 

<script>

    document.addEventListener("DOMContentLoaded", function() {
        var reviewTextArea = document.getElementById('review');
        var wordCountSpan = document.getElementById('wordCount');
        
        reviewTextArea.addEventListener('input', function() {
            var words = reviewTextArea.value.trim().split(/\s+/);
            var wordCount = words.length;
            if (wordCount <= 25) {
                wordCountSpan.textContent = wordCount + " words";
            } else {
                reviewTextArea.value = words.slice(0, 25).join(" ");
                wordCountSpan.textContent = "25 words";
            }
        });
    });
</script>

<?php require "../includes/footer.php"; ?>
