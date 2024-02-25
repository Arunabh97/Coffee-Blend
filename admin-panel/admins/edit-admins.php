<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

$adminId = $_GET['id'];

// Fetch admin details from the database based on $adminId
$adminQuery = $conn->prepare("SELECT * FROM admins WHERE id = :adminId");
$adminQuery->bindParam(':adminId', $adminId, PDO::PARAM_INT);
$adminQuery->execute();
$admin = $adminQuery->fetch(PDO::FETCH_OBJ);

if (!$admin) {
    // Admin not found, handle accordingly (e.g., redirect to admin list)
    //header("location: admins.php");
    echo "<script>window.location.href = 'admins.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user wants to update the password
    if (!empty($_POST['new_password'])) {
        // Validate the old password
        if (password_verify($_POST['old_password'], $admin->password)) {
            // Check if new password and confirm password match
            if ($_POST['new_password'] === $_POST['confirm_password']) {
                // Update the password
                $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                // Update the password in the database for the admin with $adminId
                $updatePasswordQuery = $conn->prepare("UPDATE admins SET password = :newPassword WHERE id = :adminId");
                $updatePasswordQuery->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
                $updatePasswordQuery->bindParam(':adminId', $adminId, PDO::PARAM_INT);
                $updatePasswordQuery->execute();

                echo "<script>alert('Password updated successfully');</script>";
                echo "<script>window.location.href='admins.php';</script>";
                exit();
            } else {
                echo "<script>alert('New password and confirm password do not match');</script>";
            }
        } else {
            echo "<script>alert('Incorrect old password');</script>";
        }
    }

    echo "<script>window.location.href=window.location.href;</script>";
    exit();
}
?>



<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Edit Admin</h5>
                <form method="POST" action="edit-admins.php?id=<?php echo $adminId; ?>" enctype="multipart/form-data">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" value="<?php echo $admin->email; ?>" required />
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="Username" value="<?php echo $admin->adminname; ?>" required />
                    </div>

                    <!-- Old Password input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" required/>
                    </div>

                    <!-- New Password input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password"/>
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password"/>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center"><i class="fa fa-refresh"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
