<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$adminId = $_GET['id'];

$adminQuery = $conn->prepare("SELECT * FROM admins WHERE id = :adminId");
$adminQuery->bindParam(':adminId', $adminId, PDO::PARAM_INT);
$adminQuery->execute();
$admin = $adminQuery->fetch(PDO::FETCH_OBJ);

if (!$admin) {
    echo "<script>window.location.href = 'admins.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user wants to update the password
    if (!empty($_POST['new_password'])) {
        if (password_verify($_POST['old_password'], $admin->password)) {
            if ($_POST['new_password'] === $_POST['confirm_password']) {
                $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                $updatePasswordQuery = $conn->prepare("UPDATE admins SET password = :newPassword WHERE id = :adminId");
                $updatePasswordQuery->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
                $updatePasswordQuery->bindParam(':adminId', $adminId, PDO::PARAM_INT);
                $updatePasswordQuery->execute();
            } else {
                echo "<script>alert('New password and confirm password do not match');</script>";
                echo "<script>window.location.href='admins.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Incorrect old password');</script>";
            echo "<script>window.location.href='admins.php';</script>";
            exit();
        }
    }

    // Check if the user wants to update email and username
    if (!empty($_POST['email']) && !empty($_POST['adminname'])) {

        $email = $_POST['email'];
        $adminname = $_POST['adminname'];

        $updateInfoQuery = $conn->prepare("UPDATE admins SET email = :email, adminname = :adminname WHERE id = :adminId");
        $updateInfoQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $updateInfoQuery->bindParam(':adminname', $adminname, PDO::PARAM_STR);
        $updateInfoQuery->bindParam(':adminId', $adminId, PDO::PARAM_INT);
        $updateInfoQuery->execute();
    }

    echo "<script>alert('Profile updated successfully');</script>";
    echo "<script>window.location.href='admins.php';</script>";
    exit();
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
                <h5 class="card-title mb-5 d-inline"><i class="fa-solid fa-user-tie"></i> Edit Admin</h5>
                <form method="POST" action="edit-admins.php?id=<?php echo $adminId; ?>" enctype="multipart/form-data">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" class="form-control" placeholder=" " value="<?php echo $admin->email; ?>" required/>
                        <label class="form-label" for="email">Email *</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" name="adminname" class="form-control" placeholder=" " value="<?php echo $admin->adminname; ?>" required/>
                        <label class="form-label" for="adminname">Username *</label>
                    </div>

                    <!-- Old Password input -->
                    <div class="form-outline mb-4 mt-4">
                        <div class="input-group">
                            <input type="password" name="old_password" class="form-control" placeholder=" ">
                            <label class="form-label" for="old_password">Old Password</label>
                            <button type="button" class="btn btn-outline-secondary" id="toggleOldPassword">
                                <i class="fas fa-eye" id="oldPasswordEye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- New Password input -->
                    <div class="form-outline mb-4 mt-4">
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control" placeholder=" ">
                            <label class="form-label" for="new_password">New Password</label>
                            <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                                <i class="fas fa-eye" id="newPasswordEye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-outline mb-4">
                        <div class="input-group">
                            <input type="password" name="confirm_password" class="form-control" placeholder=" ">
                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                <i class="fas fa-eye" id="confirmPasswordEye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center"><i class="fa fa-refresh"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("toggleOldPassword").addEventListener("click", function() {
        var oldPasswordInput = document.getElementsByName("old_password")[0];
        var oldPasswordEye = document.getElementById("oldPasswordEye");
        if (oldPasswordInput.type === "password") {
            oldPasswordInput.type = "text";
            oldPasswordEye.classList.remove("fa-eye");
            oldPasswordEye.classList.add("fa-eye-slash");
        } else {
            oldPasswordInput.type = "password";
            oldPasswordEye.classList.remove("fa-eye-slash");
            oldPasswordEye.classList.add("fa-eye");
        }
    });

    document.getElementById("toggleNewPassword").addEventListener("click", function() {
        var newPasswordInput = document.getElementsByName("new_password")[0];
        var newPasswordEye = document.getElementById("newPasswordEye");
        if (newPasswordInput.type === "password") {
            newPasswordInput.type = "text";
            newPasswordEye.classList.remove("fa-eye");
            newPasswordEye.classList.add("fa-eye-slash");
        } else {
            newPasswordInput.type = "password";
            newPasswordEye.classList.remove("fa-eye-slash");
            newPasswordEye.classList.add("fa-eye");
        }
    });

    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        var confirmPasswordInput = document.getElementsByName("confirm_password")[0];
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

    function togglePasswordRequired() {
        var oldPasswordInput = document.getElementsByName("old_password")[0];
        var newPasswordInput = document.getElementsByName("new_password")[0];
        var confirmPasswordInput = document.getElementsByName("confirm_password")[0];

        if (oldPasswordInput.value.trim() !== "") {
            newPasswordInput.required = true;
            confirmPasswordInput.required = true;
        } else {
            newPasswordInput.required = false;
            confirmPasswordInput.required = false;
        }
    }

    document.getElementsByName("old_password")[0].addEventListener("input", togglePasswordRequired);

</script>

<?php require "../layouts/footer.php"; ?>
