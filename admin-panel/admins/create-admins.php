<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if(!isset ($_SESSION['admin_name'])){
  echo "<script>window.location.href = '" . ADMINURL . "/admins/login-admins.php';</script>";
}

if (isset($_POST['submit'])) {
    if (empty($_POST['adminname']) || empty($_POST['email']) || empty($_POST['password'])) {
      echo "<script>alert('One or more inputs are empty');</script>";
    } else {
      $adminname = $_POST['adminname'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
      // Check if adminname already exists
      $checkAdminQuery = $conn->prepare("SELECT adminname FROM admins WHERE adminname = :adminname");
      $checkAdminQuery->execute([':adminname' => $adminname]);
      $existingAdmin = $checkAdminQuery->fetch(PDO::FETCH_ASSOC);
  
      // Check if email already exists
      $checkEmailQuery = $conn->prepare("SELECT email FROM admins WHERE email = :email");
      $checkEmailQuery->execute([':email' => $email]);
      $existingEmail = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);
  
      if ($existingAdmin) {
        echo "<script>alert('Adminname already exists');</script>";
      } elseif ($existingEmail) {
        echo "<script>alert('Email already exists');</script>";
      } else {
        $insert = $conn->prepare("INSERT INTO admins (adminname, email, password) VALUES (:adminname, :email, :password)");
        $insert->execute([
          ":adminname" => $adminname,
          ":email" => $email,
          ":password" => $password,
        ]);
  
        echo "<script>window.location.href = 'admins.php';</script>";
        exit(); 
      }
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
                <h5 class="card-title mb-5 d-inline"><i class="fa-solid fa-user-tie"></i> Create Admins</h5>
                <form method="POST" action="create-admins.php" enctype="multipart/form-data">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" class="form-control" placeholder=" " required/>
                        <label class="form-label" for="email">Email *</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" name="adminname" class="form-control" placeholder=" " required/>
                        <label class="form-label" for="adminname">Username *</label>
                    </div>

                    <div class="form-outline mb-4">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder=" " required/>
                            <label class="form-label" for="password">Password *</label>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye" id="passwordEye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">
                        <i class="fa-solid fa-plus"></i> Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordInput = document.getElementsByName("password")[0];
        var passwordEye = document.getElementById("passwordEye");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordEye.classList.remove("fa-eye");
            passwordEye.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordEye.classList.remove("fa-eye-slash");
            passwordEye.classList.add("fa-eye");
        }
    });
</script>

<?php require "../layouts/footer.php"; ?>