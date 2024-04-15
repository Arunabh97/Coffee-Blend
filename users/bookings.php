<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if(!isset($_SESSION['user_id'])){
	header("location: ".APPURL."");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $bookingId = $_POST['booking_id'];

    $cancelBooking = $conn->prepare("UPDATE bookings SET status='Cancelled' WHERE id=:bookingId AND user_id=:userId");
    $cancelBooking->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    $cancelBooking->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $cancelBooking->execute();
}

    $bookings = $conn->query("SELECT * FROM bookings WHERE user_id='$_SESSION[user_id]'");
    $bookings->execute();

    $allBookings = $bookings->fetchAll(PDO::FETCH_OBJ);

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">

<style>
	.cart-list table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        background-color: #f8f9fa; 
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .cart-list th,
    .cart-list td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
        font-family: 'Arial', sans-serif; 
		text-align: center;
    }

    .cart-list td.booking_id {
        color: #2196f3; 
        font-weight: bold;
        font-style: italic;
    }

    .cart-list th {
        background-color: #f44336; 
        color: #fff;
        font-weight: bold;
        text-transform: uppercase; 
    }

    .cart-list tbody tr:nth-child(even) {
        background-color: #ffe0b2;
    }

    .cart-list tbody tr:hover {
        background-color: #ff7043; 
        color: #fff; 
    }

    .cart-list tbody td {
        vertical-align: middle;
    }

    .cart-list .btn {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4caf50; 
        color: #fff;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
        font-family: 'Arial', sans-serif; 
    }

    .cart-list .btn:hover {
        background-color: #fff; 
        color: #2196f3;
    }

    .cart-list .btn-primary {
        background-color: #2196f3; 
        color: #fff;
    }

    .cart-list .btn-primary:hover {
        background-color: #fff;
    }

    .cart-list .btn-success {
        background-color: red; 
    }

    .cart-list .btn-success:hover {
        background-color: #fff; 
    }

    .cart-list .btn-link {
        padding: 0;
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #2196f3; 
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .cart-list .btn-link:hover {
        color: #1976d2; 
    }

        .no-bookings {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            background-image: linear-gradient(to right, #ff7e5f, #feb47b);
        }

        .no-bookings p {
            font-size: 24px;
            margin-bottom: 20px;
			color: #fff;
        }

        .no-bookings i {
            font-size: 64px;
            color: blue;
            margin-bottom: 20px;
            display: block;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
</style>	

<section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Bookings</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Your Bookings</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-cart">
			<div class="container-fluid">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
						<?php if(count($allBookings) > 0) : ?>
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
							  	<th>Booking Id</th>
							  	<th>Name</th>
								<th>Seats</th>
						        <th>Date</th>
						        <th>Time</th>
						        <th>Phone</th>
						        <th>Message</th>
                                <th>Status</th>
								<th>Review</th>
						      </tr>
						    </thead>
						    <tbody>
								<?php foreach($allBookings as $booking) : ?>
						      	<tr class="text-center">
								<td class="booking_id"><?php echo $booking->id; ?></td>
							  	<td class="name"><?php echo $booking->first_name . ' ' . $booking->last_name; ?></td>
								<td class="seats"><?php echo $booking->seats; ?></td>
								<td class="date"><?php echo $booking->date; ?></td>
								<td class="time"><?php echo $booking->time; ?></td>
								<td class="phone"><?php echo $booking->phone; ?></td>
								<td><?php echo $booking->message; ?></td>
						        
						        <?php
                                        $status = $booking->status;
                                        $badgeClass = '';
                                        switch ($status) {
                                            case 'Pending':
                                                $badgeClass = 'badge badge-info';
                                                break;
                                            case 'Confirmed':
                                                $badgeClass = 'badge badge-success';
                                                break;
                                            case 'In Progress':
                                                $badgeClass = 'badge badge-warning';
                                                break;
                                            case 'Cancelled':
                                                $badgeClass = 'badge badge-danger';
                                                break;
                                            case 'Done':
                                                $badgeClass = 'badge badge-success';
                                                break;
                                            default:
                                                $badgeClass = 'badge badge-secondary';
                                                break;
                                        }

                                    ?>
                                    <td class="status"><span class="<?php echo $badgeClass; ?>"><?php echo $status; ?></span></td>
									<?php if ($booking->status == "Done") : ?>
										<td class="status"><a class="btn btn-primary" href="<?php echo APPURL; ?>/reviews/write-review.php">Write Review</a></td>
									<?php elseif ($booking->status == "Pending" || $booking->status == "Confirmed") : ?>
										<td class="status">
											<form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
												<input type="hidden" name="booking_id" value="<?php echo $booking->id; ?>">
												<button type="submit" name="cancel_booking" class="btn btn-link">
													<img src="../images/cancel-icon.png" alt="Cancel Booking" width="40" height="40">
												</button>
											</form>
										</td>
									<?php else : ?>
										<td class="err">N/A</td>
									<?php endif; ?>
								</tr>

						    <?php endforeach; ?>
						    </tbody>
						</table>
							<?php else : ?>
							<div class="no-bookings">
								<p><i class='bx bx-calendar'></i> You do not have any bookings for now.</p>
								<p>Ready to book your next appointment?</p>
								<a href="<?php echo APPURL; ?>/menu.php" class="btn btn-primary"><i class='bx bx-plus-circle'></i> Book Now</a>
							</div>
							<?php endif; ?>
					  </div>
    			</div>
    		</div>	
		</div>
	</section>

<?php require "../includes/footer.php"; ?>