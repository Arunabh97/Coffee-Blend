<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
}

$adminsPerPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($page - 1) * $adminsPerPage;

$adminsQuery = $conn->prepare("SELECT * FROM admins LIMIT :offset, :per_page");
$adminsQuery->bindParam(':offset', $offset, PDO::PARAM_INT);
$adminsQuery->bindParam(':per_page', $adminsPerPage, PDO::PARAM_INT);
$adminsQuery->execute();

$allAdmins = $adminsQuery->fetchAll(PDO::FETCH_OBJ);

$totalAdmins = $conn->query("SELECT COUNT(*) FROM admins")->fetchColumn();

$totalPages = ceil($totalAdmins / $adminsPerPage);

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
              <h5 class="card-title mb-4 d-inline"><i class="fas fa-user-tie"></i> Admins</h5>
             <a  href="create-admins.php" class="btn btn-primary mb-4 text-center float-right"><i class="fa-solid fa-plus"></i> Create Admins</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col"><i class="fas fa-id-card"></i> Id</th>
                    <th scope="col"><i class="fas fa-user"></i> Admin Name</th>
                    <th scope="col"><i class="fas fa-envelope"></i> Email</th>
                    <th scope="col"><i class="fas fa-cog"></i> Profile Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allAdmins as $admin) : ?>
                    <tr>
                      <th scope="row"><?php echo $admin->id; ?></th>
                      <td><?php echo $admin->adminname; ?></td>
                      <td><?php echo $admin->email; ?></td>
                      <td>
                        <?php if ($_SESSION['admin_id'] == $admin->id) : ?>
                          <a href="edit-admins.php?id=<?php echo $admin->id; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

               <!-- Add pagination links -->
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