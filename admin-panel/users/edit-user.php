<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: users.php");
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
        $updateQuery = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, password = :password WHERE id = :userId");
        $updateQuery->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    } else {
        $updateQuery = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email WHERE id = :userId");
    }
    
    $updateQuery->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $updateQuery->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $updateQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
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

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Edit User</h5>
                <form method="POST" action="">

                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $user->username; ?>"  required/>
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $user->first_name; ?>"  required/>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $user->last_name; ?>"  required/>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $user->email; ?>"  required/>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password"  />
                            <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                                <i class="fas fa-eye" id="newPasswordEye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <div class="input-group">
                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Confirm New Password"  />
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
