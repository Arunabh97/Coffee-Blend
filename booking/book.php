<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if (isset($_POST['submit'])) {
  
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['date'])
    || empty($_POST['time']) || empty($_POST['phone']) || empty($_POST['message'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id'];

        if($date > date("n/j/Y")){

            $insert = $conn->prepare("INSERT INTO bookings (first_name,last_name,date,time,phone,message,user_id)
            VALUES (:first_name, :last_name, :date, :time, :phone, :message, :user_id)");

            $insert->execute([
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":date" => $date,
                ":time" => $time,
                ":phone" => $phone,
                ":message" => $message,
                ":user_id" => $user_id,
            ]);

            $_SESSION['alert'] = 'You booked this table successfully';
        } else {
            $_SESSION['alert'] = 'Choose a valid date, You cannot choose a date in the past';
        }
    }
    //header("location: ".APPURL."");
    echo "<script>window.history.back();</script>";
    exit(); // Ensure script stops execution after the redirect
}
?>