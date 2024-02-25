<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if(isset ($_SESSION['admin_name'])){
  header("location: ".ADMINURL."");
}

if (isset($_POST['submit'])) {
  
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $login = $conn->query("SELECT * FROM admins WHERE email = '$email'");
        $login->execute();

        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if($login->rowCount() > 0){

          if (password_verify($password, $fetch['password'])) {
            //start session

            $_SESSION['admin_name'] = $fetch['adminname'];
            $_SESSION['email'] = $fetch['email'];
            $_SESSION['admin_id'] = $fetch['id'];

            header("location: ".ADMINURL."");

          } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
      echo "<script>alert('Invalid email or password');</script>";
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
        background: linear-gradient(to right, #3494e6, #ec6ead);
        font-family: 'Roboto', sans-serif;
        margin: 0;
    }

    .card {
        margin: 50px auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        border-radius: 25px;
        background: linear-gradient(to bottom, #ffffff, #f0f0f0);
        border: 1px solid #d1d1d1;
        overflow: hidden;
        position: relative;
        z-index: 1;
        width: 60%; /* You can adjust this value */
    }

    .card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, #003366, #3494e6);
        clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%);
        z-index: -1;
    }

    .card-title {
        color: #ffffff;
        font-size: 32px;
        margin: 20px 0;
        text-align: center;
    }

.admin-icon {
    margin-right: 12px;
}

.form-group {
    margin-bottom: 30px;
}

.form-control {
    border-radius: 15px;
    padding: 18px;
    font-size: 20px;
    border: none;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
    background-color: #f5f5f5;
}

.form-control:hover,
.form-control:focus {
    box-shadow: 0 0 15px rgba(0, 51, 102, 0.3);
}

.input-group-prepend span {
    width: 3em;
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 15px 0 0 15px;
    padding: 18px;
}

.input-group-append span {
    cursor: pointer;
    transition: color 0.3s ease;
}

.input-group-append span:hover {
    color: #003366;
}

.btn-primary {
    background-color: #003366;
    color: white;
    font-size: 22px;
    padding: 18px;
    border-radius: 15px;
    transition: background-color 0.3s ease;
    width: 100%;
}

.btn-primary:hover {
    background-color: #001a33;
}

.container {
    margin: 0;
    box-sizing: border-box;
    overflow: hidden;
}

    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mt-3 text-center">
                            <span class="admin-icon"><i class="fas fa-user-shield"></i></span> ADMIN LOGIN
                        </h5>
                        <form method="POST" action="login-admins.php" class="p-3">
                            <!-- Email input with icon -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required />
                            </div>

                            <!-- Password input with icon and eye icon -->
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required />
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                        <i id="eye-icon" class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "../layouts/footer.php"; ?>

    <!-- Add this script to the head section -->
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>



