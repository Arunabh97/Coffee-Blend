<?php
require "includes/header.php";
require "config/config.php";

if(isset($_SESSION['username'])){
  //header("location: ".APPURL."");
  echo "<script>window.location.href = '" . APPURL . "';</script>";
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match');</script>";
    } else {
        // Proceed with the registration process
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (:username, :email, :password, :first_name, :last_name)");

        $insert->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $password_hash,
            ":first_name" => $first_name,
            ":last_name" => $last_name,
        ]);

        header("location: login.php");
        exit();
    }
}
?>

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Register</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Register</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate">
			<form action="register.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
				<h3 class="mb-4 billing-heading">Register</h3>
	          	<div class="row align-items-end">
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="FirstName">First Name</label>
                      <input type="text" name="first_name" class="form-control" placeholder="First Name">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="LastName">Last Name</label>
                      <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                  </div>
                </div>

                 <div class="col-md-12">
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>
                 </div>
	          	  <div class="col-md-12">
	                <div class="form-group">
	                	<label for="Email">Email</label>
	                  <input type="text" name="email" class="form-control" placeholder="Email">
	                </div>
	              </div>
                 
	              <div class="col-md-12">
	                <div class="form-group">
	                	<label for="Password">Password</label>
	                    <input type="password" name="password" class="form-control" placeholder="Password">
	                </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                      <label for="ConfirmPassword">Confirm Password</label>
                      <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                  </div>
              </div>

                <div class="col-md-12">
                	<div class="form-group mt-4">
							<div class="radio">
                  <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Register</button>
                  <p class="mt-3">Already registered? <a href="login.php">Login here</a></p>
						    </div>
					</div>
                </div>

               
	          </form><!-- END -->
          </div> <!-- .col-md-8 -->
          </div>
        </div>
      </div>
    </section> <!-- .section -->

   <?php require "includes/footer.php"; ?>