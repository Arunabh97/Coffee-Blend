<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

require_once('../TCPDF-main/tcpdf.php');
require "../config/config.php"; 

// Fetch order details from the database based on the order ID
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    $orderQuery = $conn->prepare("SELECT * FROM orders WHERE id=:orderId AND user_id=:userId");
    $orderQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $orderQuery->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $orderQuery->execute();

    $order = $orderQuery->fetch(PDO::FETCH_OBJ);

    if (!$order) {
        die("Order not found.");
    }

    // Generate PDF using TCPDF
    $pdf = new TCPDF();
    $pdf->SetTitle('Order Invoice');
    $pdf->AddPage();

   // Set background color
    $pdf->SetFillColor(255, 99, 71); // Tomato color
    $pdf->Rect(0, 0, $pdf->GetPageWidth(), 45, 'F');

    // Add website logo to the left
    $logoPath = 'images/invoice_icon.jpg'; 
    $pdf->Image($logoPath, 10, 10, 30); 

    $pdf->SetFont('dejavusans', 'B', 70); 
    $pdf->Cell(75); 
    $pdf->Write(10, html_entity_decode('&#9749;'), '', 0, 'C');

    // Add website name to the right
    $pdf->SetFont('dejavusans', 'B', 30);
    $websiteName = 'COFFEE'; 
    $pdf->Cell(0, 10, $websiteName, 0, 1, 'R');

    // Set font for the "BLEND" text
    $pdf->SetFont('times', 'B', 25); 
    $pdf->Cell(0, 10, 'BLEND', 0, 1, 'R');

    // Add horizontal line after logo and title
    $pdf->SetY(45); 
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    
    // Customize PDF content based on your needs
    $pdf->SetFont('dejavusans','B', 20);
    $pdf->Cell(0, 10, 'ORDER INVOICE', 0, 1, 'C');

    $pdf->SetY(55); 
    $pdf->Line(160, $pdf->GetY(), 50, $pdf->GetY());
    $pdf->Ln(10);
    // Fetch user details
    $userQuery = $conn->prepare("SELECT * FROM users WHERE id=:userId");
    $userQuery->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $userQuery->execute();
    $user = $userQuery->fetch(PDO::FETCH_OBJ);

    if (!$user) {
        die("User not found.");
    }

    $randomInvoiceNo = mt_rand(100000, 999999);
    
    $pdf->SetFont('times', '', 20); 
    $pdf->Cell(0, 10, 'To:', 0, 0, 'L');
    $pdf->Cell(0, 10, 'Invoice No:', 0, 1, 'R');
    
    $pdf->SetFont('dejavusans','', 25);

    // Display user details
    $fullName = $user->first_name . ' ' . $user->last_name;
    $pdf->SetFont('dejavusans', '', 25); 
    $pdf->Cell(0, 10, $fullName, 0, 0, 'L'); 

    // Set font for the invoice number
    $pdf->SetFont('dejavusans', '', 20); 
    $pdf->Cell(0, 10, '#' . $randomInvoiceNo, 0, 1, 'R');

    $pdf->Ln(10);

    $invoiceDate = date('Y-m-d H:i:s');

    $pdf->SetFont('times', 'B', 15);

   // Fetch address details from orders table
    $addressQuery = $conn->prepare("SELECT CONCAT(street_address, ', ', town) AS fullAddress, zip_code FROM orders WHERE id=:orderId");
    $addressQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $addressQuery->execute();
    $addressResult = $addressQuery->fetch(PDO::FETCH_OBJ);

    if ($addressResult) {
        $fullAddress = $addressResult->fullAddress;
        $pincode = $addressResult->zip_code;
        $pdf->Cell(0, 10, $fullAddress . ', IN- ' . $pincode, 0, 0, 'L');
    } else {
        $pdf->Cell(0, 10, 'Address: N/A', 0, 0, 'L'); 
    }

    $pdf->Cell(0, 10, 'Invoice Date: ' . $invoiceDate, 0, 1, 'R');

    // Fetch phone number from orders table
    $phoneQuery = $conn->prepare("SELECT phone FROM orders WHERE id=:orderId");
    $phoneQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $phoneQuery->execute();
    $phoneResult = $phoneQuery->fetch(PDO::FETCH_OBJ);

    if ($phoneResult) {
        $phoneNumber = $phoneResult->phone;
        $pdf->Cell(0, 10, 'Phone No: +91 ' . $phoneNumber, 0, 0, 'L');
    } else {
        $pdf->Cell(0, 10, 'Phone No: N/A', 0, 0, 'L'); 
    }

    $pdf->Cell(0, 10, 'Issue Date: ' . $invoiceDate, 0, 1, 'R');

    $pdf->Ln(10);

    $pdf->SetFont('dejavusans', 'B', 15);
    // Display order details
    $headers = array('Product Name', 'Quantity', 'Unit Price', 'Subtotal');

    // Fetch product details for the order
    $productQuery = $conn->prepare("SELECT * FROM order_items WHERE order_id=:orderId");
    $productQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $productQuery->execute();
    $products = $productQuery->fetchAll(PDO::FETCH_OBJ);

    // Check if there are products in the order
    if (count($products) > 0) {
        $productData = array();
        $subtotal = 0; 

        foreach ($products as $product) {
            $productSubtotal = $product->quantity * $product->price;
            $subtotal += $productSubtotal;

            $productData[] = array(
                $product->product_name,
                $product->quantity,
                html_entity_decode('&#8377;') . number_format($product->price, 2),
                html_entity_decode('&#8377;') . number_format($productSubtotal, 2)
            );
        }

    $total = 0;
    $deliveryCharge = 50;
    $discount = 5;
    $total = $subtotal + $deliveryCharge - $discount;

    $productColumnWidths = array(70, 40, 40, 40);

    // Display table headers for product details
    foreach ($headers as $key => $header) {
        $pdf->Cell($productColumnWidths[$key], 7, $header, 1);
    }

    $pdf->Ln(10);

    $pdf->SetFont('dejavusans','', 15);
    // Display table data for product details
    foreach ($productData as $row) {
        foreach ($row as $key => $value) {
            $pdf->Cell($productColumnWidths[$key], 7, $value, 0);
        }
        $pdf->Ln();
    }

    // Display subtotal
    $pdf->Ln(5); 
    $pdf->SetFont('dejavusans', 'B', 13);
    $pdf->Cell($productColumnWidths[0] + $productColumnWidths[1] + $productColumnWidths[2], 7, 'Subtotal', 0, 0, 'R');
    $pdf->Cell($productColumnWidths[3], 7, html_entity_decode('&#8377;') . number_format($subtotal, 2), 0, 1, 'C');

    $total = $subtotal + $deliveryCharge - $discount;

    // Display additional charges and discount
    $pdf->Cell($productColumnWidths[0] + $productColumnWidths[1] + $productColumnWidths[2], 7, 'Delivery Charge', 0, 0, 'R');
    $pdf->Cell($productColumnWidths[3], 7, html_entity_decode('&#8377;') . number_format($deliveryCharge, 2), 0, 1, 'C');

    $pdf->Cell($productColumnWidths[0] + $productColumnWidths[1] + $productColumnWidths[2], 7, 'Discount', 0, 0, 'R');
    $pdf->Cell($productColumnWidths[3], 7, html_entity_decode('&#8377;') . number_format($discount, 2), 0, 1, 'C');

    // Add a line to separate additional charges and discount from the total
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

    // Display total
    $pdf->Cell($productColumnWidths[0] + $productColumnWidths[1] + $productColumnWidths[2], 7, 'Total', 0, 0, 'R');
    $pdf->Cell($productColumnWidths[3], 7, html_entity_decode('&#8377;') . number_format($total, 2), 0, 1, 'C');

    // Adjust the Y-coordinate for the next section
    $pdf->Ln(10);
}
    $headers = array('Order ID', 'Total Price', 'Status', 'Order Date');

// Define table data
$data = array(
    array($order->id, html_entity_decode('&#8377;') . number_format($order->total_price, 2), $order->status, $order->created_at)
);

// Set column widths
$columnWidths = array(35, 43, 40, 70);

// Display table headers
foreach ($headers as $key => $header) {
    $pdf->Cell($columnWidths[$key], 7, $header, 1);
}

$pdf->Ln(10);

// Display table data
$pdf->SetFont('dejavusans','', 15);
foreach ($data as $row) {
    foreach ($row as $key => $value) {
        $pdf->Cell($columnWidths[$key], 7, $value, 1);
    }
    $pdf->Ln(15);
    
}

// Move to the bottom of the page
$pdf->SetY(-71);
$signatureLabel = 'Authorized Signature:';
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->Cell(0, 10, $signatureLabel, 0, 1, 'L');

$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
// Add a fixed footer for contact information
$pdf->SetFont('dejavusans', 'B', 15);
$pdf->SetFillColor(255, 99, 71);

$pdf->Rect(0, $pdf->GetY(), $pdf->GetPageWidth(), 60, 'F');
$pdf->Cell(0, 10, 'Contact Us:', 0, 0, 'L');
$pdf->Cell(0, 10, 'Follow Us:', 0, 1, 'R'); 

$pdf->SetFont('dejavusans','', 13);
$pdf->SetTextColor(255, 255, 255);

// Add Instagram icon with Instagram ID
$instagramIconPath = 'images/insta.jpg'; 
$pdf->Image($instagramIconPath, $pdf->GetX() + 114, $pdf->GetY(), 9); 
$pdf->Cell(0, 10, 'Street 4, Mango Jsr, IN-831012', 0, 0, 'L');
$pdf->SetX($pdf->GetX() + 20); 
$pdf->Cell(0, 10, 'instagram.com/coffee-blend', 0, 1, 'R'); 

// Add Facebook icon with Facebook ID
$facebookIconPath = 'images/facebook.jpg'; 
$pdf->Image($facebookIconPath, $pdf->GetX() + 114, $pdf->GetY(), 9); 
$pdf->Cell(0, 10, 'Phone No: +91 22 1234 5678', 0, 0, 'L');
$pdf->SetX($pdf->GetX() + 20); 
$pdf->Cell(0, 10, 'facebook.com/coffee-blend', 0, 1, 'R'); 

// Add mail icon with mail ID
$mailIconPath = 'images/mail.jpg'; 
$pdf->Image($mailIconPath, $pdf->GetX() + 114, $pdf->GetY(), 9); 
$pdf->SetX($pdf->GetX() + 20); 
$pdf->Cell(0, 10, 'coffee.blend@gmail.com', 0, 1, 'R'); 

// Add page numbers
$numberOfPages = $pdf->getNumPages();
for ($pageNumber = 1; $pageNumber <= $numberOfPages; $pageNumber++) {
    $pdf->setPage($pageNumber);
    $pdf->SetY(0); 
    $pdf->SetFont('dejavusans', 'B', 10); 
    $pdf->Cell(0, 10, 'Page ' . $pageNumber . ' of ' . $numberOfPages, 0, 1, 'R'); 
}
    
    // Output the PDF to the browser
    ob_end_clean();  
    $invoiceNumber = '#' . $randomInvoiceNo;
    $filename = 'Order_Invoice_' . $invoiceNumber . '.pdf';
    $pdf->Output($filename, 'I');
    
} else {
    die("Order ID not provided.");
}
?>
