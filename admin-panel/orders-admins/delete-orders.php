<?php
require "../../config/config.php";

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    
    // Fetch the order details based on the provided ID
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_OBJ);
} else {
    // Handle the case where no ID is provided
    // Redirect or display an error message as needed
    //header("Location: index.php"); 
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Check if the form is submitted for deletion
if (isset($_POST['delete'])) {
    // Perform the actual deletion
    $deleteStmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $deleteStmt->execute([$orderId]);

    //header("Location: show-orders.php");
    echo "<script>window.location.href = 'show-orders.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .modal-content {
            border: 1px solid #007bff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Adjust the width as needed */
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: 1px solid #007bff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-footer {
            border-top: 1px solid #007bff;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Are you sure you want to delete the order for <?php echo $order->first_name . ' ' . $order->last_name; ?>?</p>
                    </div>
                    <div class="modal-footer">
                        <form method="post">
                            <button type="button" class="btn btn-secondary" onclick="goBack()">Cancel</button>
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Show the modal when the page is loaded
        $(document).ready(function () {
            $('#deleteOrderModal').modal('show');
        });

        // Function to go back to the previous page
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>
