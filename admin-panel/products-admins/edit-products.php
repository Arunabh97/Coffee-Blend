<?php
require "../layouts/header.php";
require "../../config/config.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['update'])) {
        // Get the updated values from the form
        $updatedName = $_POST['name'];
        $updatedPrice = $_POST['price'];
        $updatedDescription = $_POST['description'];
        $updatedType = $_POST['type'];
        $updatedImage = $_FILES['image']['name'];
        $updatedStockQuantity = $_POST['stock_quantity'];

        if (!empty($updatedImage)) {
            $dir = "images/" . basename($updatedImage);
            move_uploaded_file($_FILES['image']['tmp_name'], $dir);
        } else {
            $updatedImage = $product->image;
        }

        $updateStmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, type = ?, image = ?, stock_quantity = stock_quantity + ? WHERE id = ?");
        $updateStmt->execute([$updatedName, $updatedPrice, $updatedDescription, $updatedType, $updatedImage, $updatedStockQuantity, $productId]);

        echo "<script>window.location.href = 'show-products.php';</script>";
        exit();
    }
} else {

    echo "<script>window.location.href = 'show-products.php';</script>";
    exit();
}

?>

<style>
.form-control {
  line-height: 1;
  margin: 0;
  height: 45px;
  padding: 8px 12px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.form-outline {
  position: relative;
}

.form-label {
  color: #495057;
  position: absolute;
  pointer-events: none;
  left: 12px;
  top: 10px;
  transition: 0.3s;
}

.form-control:focus ~ .form-label,
.form-control:not(:placeholder-shown) ~ .form-label {
  top: -12px;
  left: 12px;
  font-size: 12px;
  background-color: #fff;
  padding: 0 5px 0 5px;
}
</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline"><i class="fas fa-edit"></i> Edit Product</h5>
                <form method="POST" action="edit-products.php?id=<?php echo $productId; ?>" enctype="multipart/form-data">
                    <!-- Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" class="form-control" placeholder=" " value="<?php echo $product->name; ?>" required>
                        <label class="form-label" for="name">Name *</label>
                    </div>
                    <!-- Price input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="price" class="form-control" placeholder=" " value="<?php echo $product->price; ?>" required>
                        <label class="form-label" for="price">Price *</label>
                    </div>
                    <!-- Image input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" class="form-control">
                        <label class="form-label" for="image">Image</label>
                    </div>
                    <!-- Description textarea -->
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"><?php echo $product->description; ?></textarea>
                    </div>
                    <!-- Type select -->
                    <div class="form-outline mb-4 mt-4">
                        <select name="type" class="form-select form-control" aria-label="Type" required>
                            <option selected disabled>Choose Type *</option>
                            <option value="drink" <?php echo ($product->type === 'drink') ? 'selected' : ''; ?>>Drink</option>
                            <option value="dessert" <?php echo ($product->type === 'dessert') ? 'selected' : ''; ?>>Dessert</option>
                            <option value="appetizer" <?php echo ($product->type === 'appetizer') ? 'selected' : ''; ?>>Appetizer</option>
                        </select>
                    </div>
                    <!-- Stock quantity input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="number" name="stock_quantity" class="form-control" placeholder=" " value="<?php echo $product->stock_quantity; ?>" required>
                        <label class="form-label" for="stock_quantity">Stock Quantity *</label>
                    </div>
                    <!-- Submit button -->
                    <button type="submit" name="update" class="btn btn-primary mb-4 text-center"><i class="fas fa-edit"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
