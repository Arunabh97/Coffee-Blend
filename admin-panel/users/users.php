<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    echo "<script>
            if(confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'users.php?action=confirmDelete&id={$userId}';
            } else {
                window.location.href = 'users.php';
            }
          </script>";
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'confirmDelete' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    $deleteUser = $conn->prepare("DELETE FROM users WHERE id = :id");
    $deleteUser->bindParam(":id", $userId);
    $deleteUser->execute();

    //header("location: users.php");
    echo "<script>window.location.href = 'users.php';</script>";
    exit();
}

$usersPerPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $usersPerPage;

$usersQuery = $conn->prepare("SELECT id, username, email, first_name, last_name FROM users LIMIT :offset, :per_page");
$usersQuery->bindParam(':offset', $offset, PDO::PARAM_INT);
$usersQuery->bindParam(':per_page', $usersPerPage, PDO::PARAM_INT);
$usersQuery->execute();
$allUsers = $usersQuery->fetchAll(PDO::FETCH_OBJ);

// Count total number of users
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalPages = ceil($totalUsers / $usersPerPage);

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

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination a {
        color: #007bff;
        padding: 8px 12px;
        text-decoration: none;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a.active,
    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination .prev,
    .pagination .next {
        padding: 8px 16px;
        margin: 0 5px;
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination .prev:hover,
    .pagination .next:hover {
        background-color: #0056b3;
        border-color: #0056b3;
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
                        <th scope="col"><i class="fas fa-user"></i> First Name</th>
                        <th scope="col"><i class="fas fa-user"></i> Last Name</th>
                        <th scope="col"><i class="fas fa-envelope"></i> Email</th> 
                        <th scope="col"><i class="fas fa-cog"></i> User Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allUsers as $user) : ?>
                        <tr>
                            <th scope="row"><?php echo $user->id; ?></th>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->first_name; ?></td>
                            <td><?php echo $user->last_name; ?></td>
                            <td><?php echo $user->email; ?></td>
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

                <div class="pagination justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
