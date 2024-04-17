<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 

if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
}

$adminsQuery = $conn->prepare("SELECT * FROM admins");
$adminsQuery->execute();

$allAdmins = $adminsQuery->fetchAll(PDO::FETCH_OBJ);

$totalAdmins = count($allAdmins);

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

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
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-user-tie"></i> Admins</h5>
                    </div>
                    <div class="col-md-2 text-right"> 
                        <?php if ($_SESSION['admin_id'] == 1) : ?>
                            <a href="create-admins.php" class="btn btn-primary mb-2 text-center"><i class="fa-solid fa-plus"></i> Create Admins</a>
                        <?php endif; ?>
                    </div>
                </div>
                <table id="adminTable" class="table table-striped table-hover">
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
                                <?php if ($_SESSION['admin_id'] == $admin->id || $_SESSION['admin_id'] == 1) : ?>
                                    <a href="edit-admins.php?id=<?php echo $admin->id; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <?php endif; ?>
                                
                                <?php if ($_SESSION['admin_id'] == 1 && $_SESSION['admin_id'] != $admin->id) : ?>
                                    <button class="btn btn-sm btn-danger delete-admin" data-id="<?php echo $admin->id; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#adminTable').DataTable();

        $('.delete-admin').click(function() {
            var adminId = $(this).data('id');
            if (confirm("Are you sure you want to delete this admin?")) {
                $.ajax({
                    url: 'delete-admin.php',
                    method: 'POST',
                    data: {
                        admin_id: adminId
                    },
                    success: function(response) {
                        if (response == "success") {
                            alert("Admin deleted successfully!");
                            location.reload();
                        } else {
                            alert("Failed to delete admin. Please try again later.");
                        }
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#adminTable').DataTable();
    });
</script>

<?php require "../layouts/footer.php"; ?>
