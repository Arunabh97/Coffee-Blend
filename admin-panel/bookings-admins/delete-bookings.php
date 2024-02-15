<?php
require "../../config/config.php";

if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Fetch the booking details based on the provided ID
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->execute([$bookingId]);
    $booking = $stmt->fetch(PDO::FETCH_OBJ);
} else {
    // Handle the case where no ID is provided
    // Redirect or display an error message as needed
    header("Location: show-bookings.php"); // Redirect to the bookings page
    exit();
}

// Check if the form is submitted for deletion
if (isset($_POST['delete'])) {
    // Perform the actual deletion
    $deleteStmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $deleteStmt->execute([$bookingId]);

    // Redirect to the bookings page after deletion
    header("Location: show-bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <div class="modal fade" id="deleteBookingModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBookingModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the booking for <?php echo $booking->first_name . ' ' . $booking->last_name; ?>?</p>
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
            $('#deleteBookingModal').modal('show');
        });

        // Function to go back to the previous page
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>
