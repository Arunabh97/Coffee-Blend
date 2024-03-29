<?php
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_status"])) {
    try {

        $inquiry_id = $_POST["inquiry_id"];
        $new_status = $_POST["new_status"];

        $update_sql = "UPDATE customer_inquiries SET status = :status WHERE id = :id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindValue(':status', $new_status);
        $update_stmt->bindValue(':id', $inquiry_id);
        $update_stmt->execute();

        echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '";</script>';
        exit();

    } catch (PDOException $e) {

        echo 'PDOException: ' . $e->getMessage();
    }
}

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
        border-collapse: collapse;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th, .table tbody td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .no-inquiries {
        margin-top: 10px;
    }

    .closed-inquiry td {
    text-decoration: line-through;
    text-decoration-color: red;
    text-decoration-thickness: 2px;
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <h5 class="card-title mb-4 d-inline"><i class="fas fa-envelope"></i> Customer Inquiries</h5>
                    </div>
                </div>
                <table id="inquiriesTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sql = "SELECT * FROM customer_inquiries ORDER BY id DESC";
                            $stmt = $conn->query($sql);

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $status_class = ($row['status'] == 'closed') ? 'closed-inquiry' : '';
                                    echo '<tr class="' . $status_class . '">';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['email'] . '</td>';
                                    echo '<td>' . $row['subject'] . '</td>';
                                    echo '<td>' . $row['message'] . '</td>';
                                    echo '<td>' . $row['status'] . '</td>';
                                    echo '<td>
                                        <form method="post" action="">
                                            <input type="hidden" name="inquiry_id" value="' . $row['id'] . '">
                                            <select name="new_status">
                                                <option value="pending" ' . ($row['status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                                                <option value="resolved" ' . ($row['status'] == 'resolved' ? 'selected' : '') . '>Resolved</option>
                                                <option value="closed" ' . ($row['status'] == 'closed' ? 'selected' : '') . '>Closed</option>
                                            </select>
                                            <button type="submit" name="change_status">Change Status</button>
                                        </form>
                                    </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No customer inquiries found.</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo 'PDOException: ' . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#inquiriesTable').DataTable();
    });
</script>

