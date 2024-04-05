<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

if(isset($_SESSION['username'])){
    echo "<script>window.location.href = '" . APPURL . "';</script>";
  }
  
  if (isset($_POST['submit'])) {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
  
      // Check if the email already exists
      $check_email = $conn->prepare("SELECT * FROM users WHERE email = :email");
      $check_email->execute([':email' => $email]);
  
      if ($check_email->rowCount() > 0) {
          echo "<script>alert('This email is already registered. Please use a different email.');</script>";
      } elseif (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
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
  
          echo "<script>alert('Registered and created account successfully.');window.location.href = 'login.php';</script>";
  
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
                    <h1 class="mb-3 mt-5 bread"><i class="fas fa-user-plus"></i> Register</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Register</span></p>
                </div>
            </div>
        </div>
    </div>
</section>
  
<section class="ftco-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form action="register.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                    <h3 class="mb-4 billing-heading">Register</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Username">Username <span class="required-icon">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Enter your desired username" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="FirstName">First Name <span class="required-icon">*</span></label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter your first name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="LastName">Last Name <span class="required-icon">*</span></label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter your last name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Email">Email <span class="required-icon">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Password">Password <span class="required-icon">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter a strong password" id="passwordInput" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ConfirmPassword">Confirm Password <span class="required-icon">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter your password" id="confirmPasswordInput" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">Show</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <div class="radio">
                                    <button type="submit" name="submit" class="btn btn-primary py-3 px-4" style="width: 200px;">Register</button>
                                    <p class="mt-3">Already registered? <a href="login.php">Login here</a></p>
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
      const passwordInput = document.getElementById('passwordInput');
      const togglePassword = document.getElementById('togglePassword');
  
      togglePassword.addEventListener('click', function () {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          togglePassword.textContent = type === 'password' ? 'Show' : 'Hide';
      });
  
      const confirmPasswordInput = document.getElementById('confirmPasswordInput');
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
  
      toggleConfirmPassword.addEventListener('click', function () {
          const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          confirmPasswordInput.setAttribute('type', type);
          toggleConfirmPassword.textContent = type === 'password' ? 'Show' : 'Hide';
      });
  </script>
  
  <?php require "includes/footer.php"; ?>