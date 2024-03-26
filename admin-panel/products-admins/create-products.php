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

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Product</h5>
                <form method="POST" action="create-products.php" enctype="multipart/form-data">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="name" id="form2Example1" class="form-control" placeholder="Name" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="price" id="form2Example1" class="form-control" placeholder="Price" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" id="form2Example1" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="stock_quantity" class="form-control" placeholder="Stock Quantity" />
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <select name="type" class="form-select form-control" aria-label="Default select example">
                            <option selected>Choose Type</option>
                            <option value="drink">Drink</option>
                            <option value="dessert">Dessert</option>
                            <option value="appetizer">Appetizer</option>
                        </select>
                    </div>

                    <br />

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center"><i class="fa-solid fa-plus"></i> Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>