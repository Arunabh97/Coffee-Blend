<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php require "../razorpay-php-master/Razorpay.php"; ?>

<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href = 'http://localhost/coffee-blend';</script>";
    exit;
}

if (!isset($_SESSION['user_id'])) {
   // header("location: " . APPURL . "");
   echo "<script>window.location.href = '" . APPURL . "';</script>";
}

// Initialize Razorpay with your API key and secret
$razorpay = new Razorpay\Api\Api('rzp_test_FaDquQvryAR0L8', 'NkcrCAQCRWIq0mHz7DebVjGE');

?>

<style>
    .payment-container {
        text-align: center;
        margin-top: 50px;
    }

    .payment-heading-container {
        display: flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
        margin-bottom: 20px;
    }

    .payment-heading {
        font-size: 40px;
        margin-left: 10px; /* Add some spacing between image and heading */
    }

    .payment-image {
        max-width: 20%;
        height: auto;
        margin-bottom: 20px;
    }

     #rzp-button {
        background-color: #267bbf;
        color: #fff;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        display: inline-block;
        border-radius: 5px;
        margin-top: 20px;
        margin-bottom: 10px; 
        transition: background-color 0.3s ease-in-out; 
    }

    #rzp-button:hover {
        background-color: #3498db; 
    }

    #rzp-button img {
        vertical-align: middle;
        margin-right: 10px;
    }

    .razorpay-badge-container {
       margin: 10px;
    }
</style>

<section class="home-slider owl-carousel">

    <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">

                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Payment</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Payment</span></p>
                </div>


            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="payment-container">
        <!-- Set up a container element for the Razorpay button -->
        <div class="payment-heading-container">
        
        <h2 class="payment-heading">Online Payment with <img src="../images/pay.png" alt="Coffee Blend Logo" class="payment-image"> Gateway</h2>
        </div>

        <form action="razorpay_success.php" method="POST">
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <input type="hidden" name="amount" value="<?php echo $_SESSION['total_price'] * 100; ?>">
            <input type="hidden" name="currency" value="INR">
            <button id="rzp-button">
                <img src="../images/pay.png" alt="Razorpay Icon" height="30">
                Pay with Razorpay
            </button>
        </form>
        <!-- Wrap the Razorpay badge in a div with margin -->
        <div class="razorpay-badge-container">
            <a href="https://razorpay.com/" target="_blank">
                <img referrerpolicy="origin" src="https://badges.razorpay.com/badge-dark.png" style="height: 60px; width: 150px;" alt="Razorpay | Payment Gateway | Neobank">
            </a>
        </div>
        <script>
            var options = {
                key: 'rzp_test_FaDquQvryAR0L8',
                amount: <?php echo $_SESSION['total_price'] * 100; ?>,
                currency: 'INR',
                name: 'Coffee-Blend',
                description: 'Payment for your purchase',
                handler: function(response) {
                    // Handle the success response and redirect if needed
                    window.location.href = 'delete-cart.php';
                    window.location.href = 'razorpay_success.php?id=' + response.razorpay_payment_id;
                }
            };

            var rzp = new Razorpay(options);

            document.getElementById('rzp-button').onclick = function(e) {
                rzp.open();
                e.preventDefault();
            }
        </script>
    </div>
</div>

<?php require "../includes/footer.php"; ?>