
<?php
if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
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
                                    </tr>
                                </thead>
                                <tbody>';

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['subject'] . '</td>';
                            echo '<td>' . $row['message'] . '</td>';
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

