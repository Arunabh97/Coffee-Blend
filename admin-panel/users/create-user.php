<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission

    // Validate and sanitize input data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);

    // Check if the email already exists in the database
    $checkEmail = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkEmail->bindParam(":email", $email);
    $checkEmail->execute();
    $emailCount = $checkEmail->fetchColumn();

    if ($emailCount > 0) {
        echo "<script>alert('Email address already exists. Please choose a different one.');</script>";
    } else {
        // Insert new user into the database
        $insertUser = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (:username, :email, :password, :first_name, :last_name)");
        $insertUser->bindParam(":username", $username);
        $insertUser->bindParam(":email", $email);
        $insertUser->bindParam(":password", $password);
        $insertUser->bindParam(":first_name", $firstName);
        $insertUser->bindParam(":last_name", $lastName);

        if ($insertUser->execute()) {
            echo "<script>window.location.href = 'users.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error inserting user into the database.');</script>";
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

<!-- Your HTML form for creating a new user -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline"><i class="fas fa-user-plus"></i> Create User</h5>
                <form method="POST" action="create-user.php">
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" class="form-control" name="username" placeholder=" " required>
                        <label class="form-label" for="username">Username *</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" name="first_name" placeholder=" " required>
                        <label class="form-label" for="first_name">First Name *</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" name="last_name" placeholder=" " required>
                        <label class="form-label" for="last_name">Last Name *</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" class="form-control" name="email" placeholder=" " required>
                        <label class="form-label" for="email">Email *</label>
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
                    
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create User</button>
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
