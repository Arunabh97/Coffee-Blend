<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if(!isset ($_SESSION['admin_name'])){
    header("location: ".ADMINURL."/admins/login-admins.php");
  }

// Check if delete action is requested
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Display delete confirmation modal
    echo "<script>
            if(confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'users.php?action=confirmDelete&id={$userId}';
            } else {
                window.location.href = 'users.php';
            }
          </script>";
    exit();
}

// Check if confirm delete action is requested
if (isset($_GET['action']) && $_GET['action'] == 'confirmDelete' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Perform deletion here (you need to implement this part)
    $deleteUser = $conn->prepare("DELETE FROM users WHERE id = :id");
    $deleteUser->bindParam(":id", $userId);
    $deleteUser->execute();

    // Redirect back to the users page after deletion
    header("location: users.php");
    exit();
}

$usersQuery = $conn->query("SELECT id, username, email, first_name, last_name FROM users");
$usersQuery->execute();
$allUsers = $usersQuery->fetchAll(PDO::FETCH_OBJ);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn-action {
        margin-right: 5px;
    }
</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline"><i class="fas fa-users"></i> Users</h5>
                <a href="create-user.php" class="btn btn-primary mb-4 text-center float-right"><i
                            class="fa-solid fa-plus"></i> Create Users</a>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><i class="fas fa-id-card"></i> Id</th>
                        <th scope="col"><i class="fas fa-user"></i> Username</th>
                        <th scope="col"><i class="fas fa-envelope"></i> Email</th>
                        <th scope="col"><i class="fas fa-user"></i> First Name</th>
                        <th scope="col"><i class="fas fa-user"></i> Last Name</th>
                        <th scope="col"><i class="fas fa-cog"></i> User Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allUsers as $user) : ?>
                        <tr>
                            <th scope="row"><?php echo $user->id; ?></th>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td><?php echo $user->first_name; ?></td>
                            <td><?php echo $user->last_name; ?></td>
                            <td>
                                <a href="edit-user.php?id=<?php echo $user->id; ?>"
                                   class="btn btn-sm btn-primary btn-action"><i class="fas fa-edit"></i> Edit</a>
                                <a href="users.php?action=delete&id=<?php echo $user->id; ?>"
                                   class="btn btn-sm btn-danger btn-action"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
