<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $getUserQuery = $conn->prepare("SELECT id, username, email, first_name, last_name FROM users WHERE id = :id");
    $getUserQuery->bindParam(":id", $userId);
    $getUserQuery->execute();
    $userData = $getUserQuery->fetch(PDO::FETCH_OBJ);

    if (!$userData) {
        header("location: users.php");
        exit();
    }
} else {
    header("location: users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the submitted data
    // Update user details in the database
    $updateUserQuery = $conn->prepare("UPDATE users SET username = :username, email = :email, first_name = :first_name, last_name = :last_name WHERE id = :id");
    $updateUserQuery->bindParam(":id", $userId);
    $updateUserQuery->bindParam(":username", $_POST['username']);
    $updateUserQuery->bindParam(":email", $_POST['email']);
    $updateUserQuery->bindParam(":first_name", $_POST['first_name']);
    $updateUserQuery->bindParam(":last_name", $_POST['last_name']);
    
    if ($updateUserQuery->execute()) {
        // Redirect back to the users page after updating
        echo "<script>window.location.href = 'users.php';</script>";
        exit();
    } else {
        // Handle the update failure, if needed
        echo "Update failed!";
    }
}

?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        color: #007bff;
    }

    label {
        font-weight: bold;
        color: #495057;
    }

    form {
        max-width: 400px;
        margin: auto;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-back {
        background-color: #6c757d;
        border: none;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center mb-4"><i class="fas fa-user-edit"></i> Edit User</h5>

            <form method="post" action="" class="mt-4">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $userData->username; ?>"
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name"
                           value="<?php echo $userData->first_name; ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name"
                           value="<?php echo $userData->last_name; ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $userData->email; ?>"
                           class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Save Changes
                </button>

                <a href="users.php" class="btn btn-back btn-block mt-3"><i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </form>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
