<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee-blend";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href = 'http://localhost/coffee-blend';</script>";
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '" . APPURL . "';</script>";
}

$order_data = $_SESSION['order_data'];
$cartItems = $_SESSION['cart_items'];

if(isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    if (isset($_SESSION['total_price']) && isset($_SESSION['user_id']) && isset($_SESSION['order_data'])) {
        $amount_paid = floatval($_SESSION['total_price']);
        $user_id = $_SESSION['user_id'];
        $order_data = $_SESSION['order_data'];

        // Insert payment details into the database
        $sql_payment = "INSERT INTO payments (user_id, payment_id, amount_paid) VALUES ('$user_id', '$payment_id', $amount_paid)";

        if ($conn->query($sql_payment) === TRUE) {
            $pay_id = $conn->insert_id;

            $status = "Pending";
            $total_price = $_SESSION['total_price'];
            $payment_type = "Online Payment";
            $payment_status = "Completed";

            $sql_order = "INSERT INTO orders (first_name, last_name, state, street_address, town, zip_code, phone, email, user_id, status, total_price, payment_type, payment_status, pay_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql_order);
            $stmt->bind_param('ssssssssissssi', 
                $order_data['first_name'],
                $order_data['last_name'],
                $order_data['state'],
                $order_data['street_address'],
                $order_data['town'],
                $order_data['zip_code'],
                $order_data['phone'],
                $order_data['email'],
                $user_id,
                $status,
                $total_price,
                $payment_type,
                $payment_status,
                $pay_id
            );

            if ($stmt->execute()) {
                $inserted_order_id = $conn->insert_id;

                $sql_order_item = "INSERT INTO order_items (order_id, product_id, product_name, product_image, quantity, price)
                   VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_order_item = $conn->prepare($sql_order_item);

                foreach ($cartItems as $cartItem) {
                    $product_id = $cartItem['pro_id'];
                    $product_name = $cartItem['name'];
                    $product_image = $cartItem['image'];
                    $quantity = $cartItem['quantity'];
                    $price = $cartItem['price'];

                    $stmt_order_item->bind_param('iissid', $inserted_order_id, $product_id, $product_name, $product_image, $quantity, $price);
                    
                    if ($stmt_order_item->execute()) {
                        $updateStockQuantity = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
                        $updateStockQuantity->bind_param('ii', $quantity, $product_id);
                        $updateStockQuantity->execute();
                    } else {
                        echo "Error inserting order item: " . $conn->error;
                    }
                }

                $conn->close();

                // Construct success message with order details
                $order_details = '<ul>';
                foreach ($cartItems as $cartItem) {
                    $order_details .= '<li style="list-style-type: none;">' . $cartItem['name'] . ': ' . $cartItem['quantity'] . ' x ₹' . $cartItem['price'] . '</li>';
                }
                $order_details .= '</ul>';

                echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="" content="url=/../coffee-blend/users/orders.php">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Payment Success</title>
                    <style>
                        body {
                            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                            background-color: #f5f5f5;
                            color: #333;
                            text-align: center;
                            margin-top: 20px;
                            padding: 0;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            height: 100vh;
                        }
                        .container {
                            background-color: #fff;
                            border-radius: 10px;
                            padding: 20px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        h2 {
                            color: #28a745;
                        }
                        p {
                            margin-top: 10px;
                        }
                        p span {
                            font-weight: bold;
                            color: #333;
                        }
                        a {
                            color: #007bff;
                            text-decoration: none;
                        }
                        .countdown {
                            font-size: 24px;
                            font-weight: bold;
                            color: #333;
                            margin-top: 20px;
                        }
                    </style>
                    </head>
                    <body>
                    <div class="container">
                    <h2>Order and payment details successfully stored in the database.</h2>
                    <p>Payment ID: ' . $payment_id . '</p>
                    <p>Order ID: ' . $inserted_order_id . '</p>
                    <p>Amount Paid: ₹' . $amount_paid . '</p>
                    <p>Order Details:</p>' . $order_details . '
                    <p>You will be redirected to the orders page in <span id="countdown">10</span> seconds.</p>
                    <p>If not redirected, <a href="../users/orders.php">click here</a>.</p>
                </div>
                <script>
                function countdown() {
                    var count = 10; 
                    var timer = setInterval(function() {
                        document.getElementById("countdown").textContent = count;
                        count--; 
                        if (count === 0) {
                            clearInterval(timer); // Stop the countdown
                            window.location.href = "../users/orders.php";
                        }
                    }, 1000); 
                }
                countdown(); 
                </script>
            </body>
            </html>';
    
        }
            } else {
                echo "Error inserting payment details: " . $conn->error;
            }
        } else {
            echo "Invalid session variables.";
        }
    } else {
        echo "Invalid payment ID";
    }
    ?>
