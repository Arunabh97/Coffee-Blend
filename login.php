<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

if(isset($_SESSION['username'])) {
  echo "<script>window.location.href = '" . APPURL . "';</script>";
}

if(isset($_POST['submit'])) {

  if(empty($_POST['email']) || empty($_POST['password'])) {
      echo "<script>alert('One or more inputs are empty');</script>";
  } else {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $login = $conn->query("SELECT * FROM users WHERE email = '$email'");
      $login->execute();
      $fetch = $login->fetch(PDO::FETCH_ASSOC);

      if($login->rowCount() > 0) {
          if(password_verify($password, $fetch['password'])) {
              // Start session
              $_SESSION['username'] = $fetch['username'];
              $_SESSION['email'] = $fetch['email'];
              $_SESSION['user_id'] = $fetch['id'];

              echo "<script>window.location.href = '" . APPURL . "';</script>";
          } else {

              echo "<script>alert('Invalid email or password');</script>";
          }
      } else {

          echo "<script>alert('Invalid email or password');</script>";
      }
  }
}

?>

<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
          <div class="row slider-text justify-content-center align-items-center">
              <div class="col-md-7 col-sm-12 text-center ftco-animate">
                  <h1 class="mb-3 mt-5 bread">Login</h1>
                  <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Login</span></p>
              </div>
          </div>
      </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12 ftco-animate">
              <form action="login.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                  <h3 class="mb-4 billing-heading">Login</h3>
                  <div class="row align-items-end">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="email">Email <span class="required-icon">*</span></label>
                              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="password">Password <span class="required-icon">*</span></label>
                              <div class="input-group">
                                  <input type="password" name="password" class="form-control" placeholder="Enter your password" id="passwordInput" required>
                                  <div class="input-group-append">
                                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group mt-4">
                              <div class="radio">
                                <button type="submit" name="submit" class="btn btn-primary py-3 px-4" style="width: 200px;">Login</button>
                                  <p class="mt-3">Not registered yet? <a href="register.php">Register here</a></p>
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
</script>

<?php require "includes/footer.php"; ?>