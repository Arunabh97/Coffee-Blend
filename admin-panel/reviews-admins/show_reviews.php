<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $reviewId = $_GET['id'];

    echo "<script>
            if(confirm('Are you sure you want to delete this review?')) {
                window.location.href = 'show_reviews.php?action=delete&id=$reviewId';
            } else {
                window.location.href = 'show_reviews.php';
            }
          </script>";
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && isset($_GET['confirm'])) {
    $reviewId = $_GET['id'];

    $deleteReview = $conn->prepare("DELETE FROM reviews WHERE id = :id");
    $deleteReview->bindParam(":id", $reviewId);
    $deleteReview->execute();

    echo "<script>
            alert('Review deleted successfully');
            window.location.href = 'show_reviews.php';
          </script>";
    exit();
}

$filterRating = isset($_GET['rating']) ? $_GET['rating'] : '';

$ratingsCondition = '';
if (!empty($filterRating)) {
    $ratingsCondition = "WHERE rating = :rating";
}

$reviewsQuery = $conn->prepare("SELECT id, review, rating, username, created_at FROM reviews $ratingsCondition");
if (!empty($filterRating)) {
    $reviewsQuery->bindParam(':rating', $filterRating);
}
$reviewsQuery->execute();
$reviews = $reviewsQuery->fetchAll(PDO::FETCH_OBJ);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn {
        border-radius: 15px; 
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-comments"></i> Reviews</h5>
                    </div>
                    <div class="col-md-2 text-right">
                        <form action="" method="GET" class="form-inline">
                            <div class="form-group mb-2 mr-1">
                                <label for="rating" class="mr-2"></label>
                                <select class="form-control" id="rating" name="rating">
                                    <option value="">All Ratings</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa-solid fa-filter"></i></button>
                        </form>
                    </div>
                </div>

                <?php if (!empty($filterRating)) : ?>
                <p class="lead">Filtering by rating no: <strong><?php echo htmlspecialchars($filterRating); ?></strong></p>
                <?php endif; ?>

                <table id="reviewTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Review</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Username</th>
                            <th scope="col">Reviewed At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review) : ?>
                            <tr>
                                <td><?php echo $review->id; ?></td>
                                <td><?php echo $review->review; ?></td>
                                <td><?php echo $review->rating; ?></td>
                                <td><?php echo $review->username; ?></td>
                                <td><?php echo $review->created_at; ?></td>
                                <td>
                                    <a href="show_reviews.php?action=delete&id=<?php echo $review->id; ?>" class="btn btn-sm btn-danger btn-action"><i class="fas fa-trash-alt"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#reviewTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>
