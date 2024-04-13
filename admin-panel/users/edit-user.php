<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='users.php';</script>";
    exit();
}

$userId = $_GET['id'];
$userQuery = $conn->prepare("SELECT * FROM users WHERE id = :userId");
$userQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
$userQuery->execute();
$user = $userQuery->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo "<script>window.location.href='users.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $street_address = $_POST['street_address'];
    $town = $_POST['town'];
    $zip_code = $_POST['zip_code'];
    $phone = $_POST['phone'];
    
    if(isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];
        
        if($new_password !== $confirm_new_password) {
            echo "<script>alert('New password and confirm password do not match');</script>";
            echo "<script>window.location.href='users.php';</script>";
            exit();
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    }

    if (isset($hashed_password)) {
        $updateQuery = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, street_address = :street_address, town = :town, zip_code = :zip_code, phone = :phone, password = :password WHERE id = :userId");
        $updateQuery->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    } else {
        $updateQuery = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, street_address = :street_address, town = :town, zip_code = :zip_code, phone = :phone WHERE id = :userId");
    }
    
    if ($email !== $user->email) {
        $checkEmailQuery = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND id != :userId");
        $checkEmailQuery->bindParam(':email', $email);
        $checkEmailQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
        $checkEmailQuery->execute();
        $emailCount = $checkEmailQuery->fetchColumn();

        if ($emailCount > 0) {
            echo "<script>alert('Email address already exists for another user. Please choose a different one.');</script>";
            echo "<script>window.location.href='edit-user.php';</script>";
            exit();
        }
    }

    $updateQuery = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, street_address = :street_address, town = :town, zip_code = :zip_code, phone = :phone WHERE id = :userId");

    $updateQuery->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $updateQuery->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $updateQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $updateQuery->bindParam(':street_address', $street_address, PDO::PARAM_STR);
    $updateQuery->bindParam(':town', $town, PDO::PARAM_STR);
    $updateQuery->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
    $updateQuery->bindParam(':phone', $phone, PDO::PARAM_STR);
    $updateQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    if ($updateQuery->execute()) {
        echo "<script>alert('User details updated successfully');</script>";
        echo "<script>window.location.href='users.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update user details');</script>";
    }
}

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

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
                <h5 class="card-title mb-5 d-inline"><i class="fa-solid fa-user-pen"></i> Edit User</h5>
                <form method="POST" action="">

                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="username" class="form-control" placeholder=" " value="<?php echo isset($user->username) ? $user->username : ''; ?>">
                    <label class="form-label" for="username">Username *</label>
                </div>

                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="first_name" class="form-control" placeholder=" " value="<?php echo isset($user->first_name) ? $user->first_name : ''; ?>">
                    <label class="form-label" for="first_name">First Name *</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="last_name" class="form-control" placeholder=" " value="<?php echo isset($user->last_name) ? $user->last_name : ''; ?>">
                    <label class="form-label" for="last_name">Last Name *</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="email" name="email" class="form-control" placeholder=" " value="<?php echo isset($user->email) ? $user->email : ''; ?>">
                    <label class="form-label" for="email">Email *</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="street_address" class="form-control" placeholder=" " value="<?php echo isset($user->street_address) ? $user->street_address : ''; ?>">
                    <label class="form-label" for="street_address">Street Address</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="town" class="form-control" placeholder=" " value="<?php echo isset($user->town) ? $user->town : ''; ?>">
                    <label class="form-label" for="town">Town/City</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="zip_code" class="form-control" placeholder=" " value="<?php echo isset($user->zip_code) ? $user->zip_code : ''; ?>">
                    <label class="form-label" for="zip_code">Zip Code</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="phone" class="form-control" placeholder=" " value="<?php echo isset($user->phone) ? $user->phone : ''; ?>">
                    <label class="form-label" for="phone">Phone Number</label>
                </div>

                <div class="form-outline mb-4">
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder=" ">
                        <label class="form-label" for="new_password">New Password</label>
                        <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                            <i class="fas fa-eye" id="newPasswordEye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-outline mb-4">
                    <div class="input-group">
                        <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder=" ">
                        <label class="form-label" for="confirm_new_password">Confirm New Password</label>
                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                            <i class="fas fa-eye" id="confirmPasswordEye"></i>
                        </button>
                    </div>
                </div>

                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center"><i class="fa fa-refresh"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("toggleNewPassword").addEventListener("click", function() {
        var passwordInput = document.getElementById("new_password");
        var passwordEye = document.getElementById("newPasswordEye");
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

    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        var confirmPasswordInput = document.getElementById("confirm_new_password");
        var confirmPasswordEye = document.getElementById("confirmPasswordEye");
        if (confirmPasswordInput.type === "password") {
            confirmPasswordInput.type = "text";
            confirmPasswordEye.classList.remove("fa-eye");
            confirmPasswordEye.classList.add("fa-eye-slash");
        } else {
            confirmPasswordInput.type = "password";
            confirmPasswordEye.classList.remove("fa-eye-slash");
            confirmPasswordEye.classList.add("fa-eye");
        }
    });

    document.getElementById("new_password").addEventListener("input", function() {
        var confirmPasswordInput = document.getElementById("confirm_new_password");
        confirmPasswordInput.required = this.value.trim().length > 0;
    });
</script>

<?php require "../layouts/footer.php"; ?>
