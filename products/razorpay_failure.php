<?php
session_start();

require "../config/config.php";

if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href = 'http://localhost/coffee-blend';</script>";
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '" . APPURL . "';</script>";
}

if (isset($_SESSION['total_price']) && isset($_SESSION['user_id']) && isset($_SESSION['order_data'])) {
    // Payment failed, so remove session data related to the order
    unset($_SESSION['total_price']);
    unset($_SESSION['order_data']);
    unset($_SESSION['cart_items']);

    echo '<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Payment Failure</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #004d40; /* Dark teal */
            margin: 20px;
            padding: 0;
            display: flex;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Payment Failed</h2>
            <p>We are sorry, but your payment was not successful.</p>
            <p>Please try again later or contact customer support for assistance.</p>
            <p>If you have any questions, <a href="<?php echo APPURL; ?>/contact.php">Contact Us</a>.</p>
            <p>You will be redirected to the homepage in <span id="countdown">10</span> seconds.</p>
            </div>
        
            <script>
                var countdown = 10;
                var timer = setInterval(function() {
                    countdown--;
                    document.getElementById("countdown").textContent = countdown;
                    if (countdown <= 0) {
                        clearInterval(timer);
                        window.location.href = "../index.php";
                    }
                }, 1000);
            </script>
        </body>
        </html>';

} else {
    echo "Invalid session variables.";
}

?>

