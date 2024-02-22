<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if(!isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."/admins/login-admins.php");
}

if (isset($_POST['submit'])) {
  if (empty($_POST['adminname']) || empty($_POST['email']) || empty($_POST['password'])) {
      echo "<script>alert('One or more inputs are empty');</script>";
  } else {
      $adminname = $_POST['adminname'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Assuming $conn is your database connection object
      $insert = $conn->prepare("INSERT INTO admins (adminname, email, password) VALUES (:adminname, :email, :password)");

      $insert->execute([
          ":adminname" => $adminname,
          ":email" => $email,
          ":password" => $password,
      ]);

      header("location: admins.php");
      exit(); 
  }
}



?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="create-admins.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" required/>
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" required/>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" required/>
                </div>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center"><i class="fa-solid fa-plus"></i> Create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
      <?php require "../layouts/footer.php"; ?>