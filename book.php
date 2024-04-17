<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
	$userId = $_SESSION['user_id'];
	$userQuery = $conn->prepare("SELECT first_name, last_name, phone FROM users WHERE id = ?");
	$userQuery->execute([$userId]);
	$user = $userQuery->fetch(PDO::FETCH_ASSOC);

	$firstName = $user['first_name'] ?? '';
	$lastName = $user['last_name'] ?? '';
	$phone = $user['phone'] ?? '';
} else {
	$firstName = '';
	$lastName = '';
	$phone = '';
}

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<style>
    .content-section {
        padding: 50px 0;
    }

    .content-section .col-md-6 {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .content-section .col-md-6 {
            align-items: center;
            text-align: center;
        }
    }

    .form-floating label {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0.5;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
    }

    .form-style {
        max-width: 600px; 
        margin: 0 auto;
        padding: 20px;
        background-color: #fff; 
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
    }

    .form-floating {
        position: relative;
        margin-bottom: 20px;
    }

    .form-control {
        height: 50px; 
        border-radius: 5px;
        border: 1px solid #ced4da;
        color: black !important; 
        font-size: 15px;
    }

    .form-floating label {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0.5;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
        font-size: 15px; 
        padding: 15px;
        color: #ffff; 
    }

    .form-floating input:focus ~ label,
    .form-floating input:not(:placeholder-shown) ~ label {
        top: -22px;
        font-size: 15px; 
        opacity: 1;
        color: #fff; 
    }

    .form-floating textarea {
        min-height: 100px; 
    }

    .form-control {
        border-color: #ccc !important;
    }

    .form-floating input[type="text"]:focus,
    .form-floating input[type="email"]:focus,
    .form-floating input[type="tel"]:focus,
    .form-floating textarea:focus {
        border-color: #6c757d !important;
    }

    .form-floating label {
        color: #212529 !important;
    }
</style>

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url(images/book.png);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Booking</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Booking</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container-fluid">
    <h1 class="text-white mb-6 text-center">Book A Table Online</h1>

        <div class="row">
            <div class="col-md-6 order-md-first"> <!-- Move YouTube video to the left by using order-md-last -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="video/video.mp4" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-6 order-md-last">
            <div class="p-5 wow fadeInUp formcont" data-wow-delay="0.2s">
                <div class="booking-form-container" style="background-color: #f0f0f0; padding: 20px; border-radius: 10px;">
                    <form method="POST" action="booking/book.php" >
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo isset($firstName) ? $firstName : ''; ?>" placeholder=" " required>
                                    <label for="first_name" style="color: black;">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="last_name" type="text" class="form-control" id="last_name" value="<?php echo isset($lastName) ? $lastName : ''; ?>" placeholder=" " required>
                                    <label for="last_name" style="color: black;">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="seats" type="number" class="form-control" id="seats" placeholder=" " required min="1" max="10">
                                    <label for="seats" style="color: black;">Seats</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating date" id="date3" data-target-input="nearest">
                                <input name="date" type="date" class="form-control" placeholder=" " min="<?php echo date('Y-m-d'); ?>" required>
                                    <label for="datetime" style="color: black;">Date</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name = "time" type="text" class="form-control appointment_time" placeholder=" " required>
                                    <label for="time" style="color: black;">Time</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input name="phone" type="tel" class="form-control" id="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" placeholder=" " minlength="10" maxlength="10">
                                    <label for="phone" style="color: black;">Phone</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="message" class="form-control" placeholder="Message" id="message" style="height: 100px"></textarea>
                                    <label for="message" style="color: black;"></label>
                                </div>
                            </div>
                            <?php if(isset($_SESSION['user_id'])) : ?>
                                <div class="col-md-12">
                                    <button name="submit" class="btn btn-primary w-100 py-3" style="font-size:12px;"type="submit">Book Now</button>
                                </div>
                            <?php else : ?>
                                <div class="col-md-12">
                                    <p class="text-dark">Login to book a table</p>
                                </div>
                            <?php endif; ?>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function () {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd', 
            autoclose: true,
            todayHighlight: true
        });

        $(document).ready(function() {
        $('.appointment_time').timepicker({
            timeFormat: 'H:i',
            interval: 30,
            minTime: '08:00am',
            maxTime: '09:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>

<?php require "includes/footer.php"; ?>
