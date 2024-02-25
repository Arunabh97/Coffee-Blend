<?php
require "../layouts/header.php";
require "../../config/config.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product details based on the provided ID
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_OBJ);

    // Check if the form is submitted for updating the product
    if (isset($_POST['update'])) {
        // Get the updated values from the form
        $updatedName = $_POST['name'];
        $updatedPrice = $_POST['price'];
        $updatedDescription = $_POST['description'];
        $updatedType = $_POST['type'];
        $updatedImage = $_FILES['image']['name'];

        // Check if a new image is uploaded
        if (!empty($updatedImage)) {
            $dir = "images/" . basename($updatedImage);
            move_uploaded_file($_FILES['image']['tmp_name'], $dir);
        } else {
            // If no new image is uploaded, use the existing image
            $updatedImage = $product->image;
        }

        // Update the product details in the database
        $updateStmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, type = ?, image = ? WHERE id = ?");
        $updateStmt->execute([$updatedName, $updatedPrice, $updatedDescription, $updatedType, $updatedImage, $productId]);

        //header("Location: show-products.php");
        echo "<script>window.location.href = 'show-products.php';</script>";
        exit();
    }
} else {
    //header("Location: show-products.php"); 
    echo "<script>window.location.href = 'show-products.php';</script>";
    exit();
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Edit Product</h5>
                <form method="POST" action="edit-products.php?id=<?php echo $productId; ?>" enctype="multipart/form-data">
                    <!-- Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" id="form2Example1" class="form-control" placeholder="Name" value="<?php echo $product->name; ?>" required />
                    </div>
                    <!-- Price input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="price" id="form2Example1" class="form-control" placeholder="Price" value="<?php echo $product->price; ?>" required />
                    </div>
                    <!-- Image input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" id="form2Example1" class="form-control" />
                    </div>
                    <!-- Description textarea -->
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $product->description; ?></textarea>
                    </div>
                    <!-- Type select -->
                    <div class="form-outline mb-4 mt-4">
                        <select name="type" class="form-select form-control" aria-label="Default select example" required>
                            <option selected>Choose Type</option>
                            <option value="drink" <?php echo ($product->type === 'drink') ? 'selected' : ''; ?>>Drink</option>
                            <option value="dessert" <?php echo ($product->type === 'dessert') ? 'selected' : ''; ?>>Dessert</option>
                            <option value="appetizer" <?php echo ($product->type === 'appetizer') ? 'selected' : ''; ?>>Appetizer</option>
                        </select>
                    </div>
                    <br>
                    <!-- Submit button -->
                    <button type="submit" name="update" class="btn btn-primary mb-4 text-center"><i class="fas fa-edit"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
