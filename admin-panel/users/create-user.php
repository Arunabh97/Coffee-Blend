<?php
require "../layouts/header.php";
require "../../config/config.php";

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission

    // Validate and sanitize input data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);

    // Insert new user into the database
    $insertUser = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (:username, :email, :password, :first_name, :last_name)");
    $insertUser->bindParam(":username", $username);
    $insertUser->bindParam(":email", $email);
    $insertUser->bindParam(":password", $password);
    $insertUser->bindParam(":first_name", $firstName);
    $insertUser->bindParam(":last_name", $lastName);

    if ($insertUser->execute()) {
        // Redirect to the users page after successful insertion
        header("location: users.php");
        exit();
    } else {
        // Handle error, you might want to display an error message or log the error
        echo "Error inserting user into the database.";
    }
}
?>

<style>
        body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        color: #007bff;
    }

    label {
        font-weight: bold;
        color: #495057;
    }

    form {
        max-width: 400px;
        margin: auto;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-back {
        background-color: #6c757d;
        border: none;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }
    </style>
</head>
<body>

<!-- Your HTML form for creating a new user -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <center><h5 class="card-title mb-4 d-inline"><i class="fas fa-user-plus"></i> Create User</h5></center>
                <form method="POST" action="create-user.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
