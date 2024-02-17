<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."/admins/login-admins.php");
}

$products = $conn->query("SELECT * FROM products");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline"><i class="fas fa-shopping-bag"></i> Products</h5>
              <a  href="create-products.php" class="btn btn-primary mb-4 text-center float-right"><i class="fa-solid fa-plus"></i> Create Products</a>

              <table class="table">
                <thead>
                  <tr>
                  <th scope="col"><i class="fas fa-hashtag"></i> Id</th>
                  <th scope="col"><i class="fas fa-user"></i> Name</th>
                  <th scope="col"><i class="fas fa-image"></i> Image</th>
                  <th scope="col"><i class="fas fa-dollar-sign"></i> Price</th>
                  <th scope="col"><i class="fas fa-folder"></i> Type</th>
                  <th scope="col"><i class="fas fa-trash-alt"></i> Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allProducts as $product) : ?>
                  <tr>
                     <th scope="row"><?php echo $product->id; ?></th>
                     <td><?php echo $product->name; ?></td>
                     <td><img src="images/<?php echo $product->image; ?>" style="width: 60px; height:60px;"></td>
                     <td><?php echo $product->price; ?></td>
                     <td><?php echo $product->type; ?></td>
                     <td><a href="delete-products.php?id=<?php echo $product->id; ?>" class="btn btn-danger  text-center"><i class="fas fa-trash-alt"></i> Delete</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



<?php require "../layouts/footer.php"; ?>
