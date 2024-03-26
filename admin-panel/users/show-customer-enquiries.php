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
    }

</style>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline"><i class="fas fa-envelope"></i> Customer Inquiries</h5>
                <?php
                try {
                    // Fetch customer inquiries from the database
                    $sql = "SELECT * FROM customer_inquiries";
                    $stmt = $conn->query($sql);

                    // Check if there are any inquiries
                    if ($stmt->rowCount() > 0) {
                        // Display the inquiries in a table
                        echo '<table class="table">
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
                                <tbody>';

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

                        echo '</tbody></table>';
                    } else {
                        // Display a message if there are no inquiries
                        echo '<p class="no-inquiries">No customer inquiries found.</p>';
                    }
                } catch (PDOException $e) {
                    // Handle any PDO exceptions here
                    echo 'PDOException: ' . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>
</div>

