<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

if (isset($_POST['submit'])) {
    if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['description']) || empty($_POST['type']) || empty($_POST['stock_quantity'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $stock_quantity = $_POST['stock_quantity'];
        $image = $_FILES['image']['name'];

        $dir = "images/" . basename($image);

        $insert = $conn->prepare("INSERT INTO products (name, price, description, type, stock_quantity, image) 
        VALUES (:name, :price, :description, :type, :stock_quantity, :image)");

        $insert->execute([
            ":name" => $name,
            ":price" => $price,
            ":description" => $description,
            ":type" => $type,
            ":stock_quantity" => $stock_quantity,
            ":image" => $image,
        ]);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
            echo "<script>window.location.href = 'show-products.php';</script>";
        }

        exit();
    }
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
                <h5 class="card-title mb-5 d-inline"><i class="fas fa-plus"></i> Create Product</h5>
                <form method="POST" action="create-products.php" enctype="multipart/form-data">
                    <!-- Product Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" class="form-control" placeholder=" " required>
                        <label class="form-label" for="name">Name *</label>
                    </div>
                    <!-- Price input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="price" class="form-control" placeholder=" " required>
                        <label class="form-label" for="price">Price *</label>
                    </div>
                    <!-- Image input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" class="form-control" required>
                        <label class="form-label" for="image">Image *</label>
                    </div>
                    <!-- Description textarea -->
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <!-- Stock Quantity input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="stock_quantity" class="form-control" placeholder=" " required>
                        <label class="form-label" for="stock_quantity">Stock Quantity *</label>
                    </div>
                    <!-- Type select -->
                    <div class="form-outline mb-4 mt-4">
                        <select name="type" class="form-select form-control" aria-label="Type" required>
                            <option selected disabled>Choose Type *</option>
                            <option value="drink">Drink</option>
                            <option value="dessert">Dessert</option>
                            <option value="appetizer">Appetizer</option>
                        </select>
                    </div>
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center"><i class="fa-solid fa-plus"></i> Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>