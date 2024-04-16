<?php 

  // db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee-blend";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

    session_start();
    define("APPURL","http://localhost/coffee-blend");
    define("IMAGEPRODUCTS", "http://localhost/coffee-blend/admin-panel/products-admins/images");

    // Check if alert message exists
if (isset($_SESSION['alert'])) {
  echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
  unset($_SESSION['alert']); // Clear the session variable
}
 
// Fetch user details if the user is logged in
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];

  $userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
  $userQuery->execute([$userId]);
  $userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Coffee Blend (Coffee Ordering and Reservation System)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.1.4/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/animate.css">
    <link rel="icon" href="<?php echo APPURL; ?>/images/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/aos.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/icomoon.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/style.css">
    <style>
        .container-fluid{
            width: 90%;
        }
    /* Customize the modal appearance */
    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(to right, #ff4e50, #ff7a57);
        color: #fff;
        border-radius: 8px 8px 0 0;
        padding: 15px;
        text-align: center;
    }

    .modal-header h5 {
        margin: 0;
        font-size: 18px;
    }

    .modal-body {
        padding: 15px;
    }

    .modal-footer {
        border-top: 1px solid #ddd;
        padding: 15px;
        text-align: center;
        border-radius: 0 0 8px 8px;
    }

    /* Customize the form inside the modal */
    #editDetailsForm {
        max-width: 600px;
        margin: 0 auto;
    }

    #editDetailsForm label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    #editDetailsForm input {
    width: 100%;
    padding: 5px;
    margin-bottom: 15px; 
    box-sizing: border-box;
    border: none; 
    border-bottom: 2px solid #007bff; 
    background-color: #f4f4f4; 
    border-radius: 6px; 
    font-size: 14px; 
    color: #333; 
    transition: border-color 0.3s ease-in-out; 
}

#editDetailsForm input:focus {
    outline: none; 
    border-bottom-color: #ff6347; 
}

    #saveChangesBtn,
    #cancelEditBtn {
        display: inline-block;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    #saveChangesBtn {
        background-color: #28a745;
        color: #fff;
    }

    #saveChangesBtn:hover {
        background-color: #218838;
    }

    #cancelEditBtn {
        color: #007bff;
        margin-left: 10px;
    }

    #cancelEditBtn:hover {
        color: #0056b3;
    }
    #changePasswordForm {
    max-width: 600px;
    margin: 0 auto;
}

#changePasswordForm label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
    font-size: 14px;
}

#changePasswordForm input {
    width: 100%;
    padding: 5px;
    margin-bottom: 15px; 
    box-sizing: border-box;
    border: none; 
    border-bottom: 2px solid #007bff; 
    background-color: #f4f4f4; 
    border-radius: 6px; 
    font-size: 14px; 
    color: #333; 
    transition: border-color 0.3s ease-in-out;
}

#changePasswordForm input:focus {
    outline: none; 
    border-bottom-color: #ff6347;
}

#savePasswordBtn,
#cancelPasswordBtn {
    display: inline-block;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
}

#savePasswordBtn {
    background-color: #28a745;
    color: #fff;
}

#savePasswordBtn:hover {
    background-color: #218838;
}

#cancelPasswordBtn {
    color: #007bff;
    margin-left: 10px;
}

#cancelPasswordBtn:hover {
    color: #0056b3;
}

.password-field {
        position: relative;
    }

    .password-field input {
        padding-right: 40px; /* Adjust as needed */
    }

    .password-field .field-icon {
        position: absolute;
        top: 40%;
        right: 10px; 
        transform: translateY(-50%);
        cursor: pointer;
    }

    #addDetailsForm {
        max-width: 600px;
        margin: 0 auto;
    }

    #addDetailsForm label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    #addDetailsForm input {
    width: 100%;
    padding: 5px;
    margin-bottom: 15px; 
    box-sizing: border-box;
    border: none; 
    border-bottom: 2px solid #007bff; 
    background-color: #f4f4f4; 
    border-radius: 6px; 
    font-size: 14px; 
    color: #333; 
    transition: border-color 0.3s ease-in-out; 
}

#addDetailsForm input:focus {
    outline: none; 
    border-bottom-color: #ff6347; 
}

    #saveAddBtn,
    #cancelAddBtn {
        display: inline-block;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    #saveAddBtn {
        background-color: #28a745;
        color: #fff;
    }

    #saveAddBtn:hover {
        background-color: #218838;
    }

    #cancelAddBtn {
        color: #007bff;
        margin-left: 10px;
    }

    #cancelAddBtn:hover {
        color: #0056b3;
    }

    .logoutmodal {
        cursor: pointer;
    }
        
    .btn {
        border-radius: 5px;
    }
</style>

  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container-fluid">
	      <a class="navbar-brand" href="<?php echo APPURL; ?>"><i class='bx bx-coffee-togo'></i>Coffee<small>Blend</small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'menu.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>/menu.php" class="nav-link">Menu</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'gallery.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>/gallery.php" class="nav-link">Gallery</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>/services.php" class="nav-link">Services</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>/about.php" class="nav-link">About</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">
                    <a href="<?php echo APPURL; ?>/contact.php" class="nav-link">Contact</a>
                </li>

	            <?php if(isset($_SESSION['username'])) : ?>
                <li class="nav-item cart">
                    <a href="<?php echo APPURL; ?>/products/cart.php" class="nav-link">
                        <span class="icon icon-shopping_cart"></span>
                        <?php
                        // Fetch and display the count of items in the cart
                        $cartCount = 0; // Default value if the count is not available
                        if (isset($_SESSION['user_id'])) {
                            $cartQuery = $conn->query("SELECT COUNT(*) AS count FROM cart WHERE user_id = '$_SESSION[user_id]'");
                            $cartCountResult = $cartQuery->fetch(PDO::FETCH_ASSOC);
                            $cartCount = $cartCountResult['count'];
                        }
                        ?>
                        <?php if ($cartCount > 0) : ?>
                            <sup class="badge badge-pill badge-danger"><?php echo $cartCount; ?></sup>
                        <?php endif; ?>
                    </a>
                </li>

 <!-- settings icon can delete this when needed -->
<?php if(isset($_SESSION['username'])) : ?>
        <!-- Add a separate list item for settings outside the dropdown menu -->
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#userSettingsModal">
            <i class='bx bx-cog' style="font-size: 1.5rem;"></i>
          </a>
        </li>
    <?php endif; ?>


              <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/bookings.php"><i class='bx bx-calendar'></i> Bookings</a></li>
            <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item logoutmodal" data-toggle="modal" data-target="#logoutConfirmationModal">Logout <i class='bx bx-log-in' ></i></a></li>
          </ul>
        </li>
        <?php else: ?>
			  <li class="nav-item"><a href="<?php echo APPURL; ?>/login.php" class="nav-link">login</a></li>
			  <li class="nav-item"><a href="<?php echo APPURL; ?>/register.php" class="nav-link">register</a></li>
        <?php endif; ?>
	        </ul>
	      </div>
		</div>
	  </nav>
    <!-- END nav -->
    <div class="modal fade" id="userSettingsModal" tabindex="-1" role="dialog" aria-labelledby="userSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userSettingsModalLabel">User Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display user details in the modal -->
                    <div id="userDetailsContainer">
                        <p>User Id: <span id="userId"><?php echo $userDetails['id']; ?></span></p>
                        <p>First Name: <span id="firstName"><?php echo $userDetails['first_name']; ?></span></p>
                        <p>Last Name: <span id="lastName"><?php echo $userDetails['last_name']; ?></span></p>
                        <p>Username: <span id="username"><?php echo $userDetails['username']; ?></span></p>
                        <p>Email: <span id="email"><?php echo $userDetails['email']; ?></span></p>

                        <p><center><u><b>Additional Details</b></u></center></p>

                        <p>Street Address: <span id="email"><?php echo $userDetails['street_address']; ?></span></p>
                        <p>Town / City: <span id="email"><?php echo $userDetails['town']; ?></span></p>
                        <p>ZipCode: <span id="email"><?php echo $userDetails['zip_code']; ?></span></p>
                        <p>Phone Number: <span id="email"><?php echo $userDetails['phone']; ?></span></p>

                        <!-- Add a link to edit details -->
                        <a href="#" id="editDetailsBtn" class="btn btn-primary">Edit Details</a>
                        <a href="#" id="addDetailsBtn" class="btn btn-success">Add Details</a>
                        <a href="#" id="changePasswordBtn" class="btn btn-secondary">Change Password</a>
                    </div>

                    <!-- Editable form, initially hidden -->
                    <form id="editDetailsForm" style="display: none;">
                        <label for="editUsername">Username:</label>
                        <input type="text" id="editUsername" name="editUsername" value="<?php echo $userDetails['username']; ?>" readonly placeholder="Username">

                        <label for="editFirstName">First Name:</label>
                        <input type="text" id="editFirstName" name="editFirstName" value="<?php echo $userDetails['first_name']; ?>" placeholder="Enter your first name">

                        <label for="editLastName">Last Name:</label>
                        <input type="text" id="editLastName" name="editLastName" value="<?php echo $userDetails['last_name']; ?>" placeholder="Enter your last name">
                        
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" name="editEmail" value="<?php echo $userDetails['email']; ?>" placeholder="Enter your email">


                        <!-- Add a button to save changes -->
                        <button type="button" class="btn btn-success" id="saveChangesBtn">Save Changes</button>
                        <a href="#" id="cancelEditBtn">Cancel</a>
                    </form>

                    <form id="addDetailsForm" style="display: none;">
                        <label for="editStreetAddress">Street Address:</label>
                        <input type="text" id="editStreetAddress" name="editStreetAddress" value="<?php echo $userDetails['street_address']; ?>" placeholder="Enter your House No with Full Address">

                        <label for="editTown">Town/City:</label>
                        <input type="text" id="editTown" name="editTown" value="<?php echo $userDetails['town']; ?>" placeholder="Enter your town/city">

                        <label for="editZipCode">Zip Code:</label>
                        <input type="text" id="editZipCode" name="editZipCode" value="<?php echo $userDetails['zip_code']; ?>" placeholder="Enter your Pin Code">
                        
                        <label for="editPhone">Phone Number:</label>
                        <input type="text" id="editPhone" name="editPhone" value="<?php echo $userDetails['phone']; ?>" minlength="10" maxlength="10" placeholder="Enter your phone">

                        <button type="button" class="btn btn-success" id="saveAddBtn">Save Changes</button>
                        <a href="#" id="cancelAddBtn">Cancel</a>
                    </form>

                    <!-- Editable form for changing password, initially hidden -->
                    <form id="changePasswordForm" style="display: none;">
                        <label for="currentPassword">Current Password:</label>
                            <div class="password-field">
                                <input type="password" id="currentPassword" name="currentPassword" placeholder="Enter your current password" required>
                                <span class="field-icon toggle-password" data-status="hidden">👁️</span>
                            </div>

                            <label for="newPassword">New Password:</label>
                            <div class="password-field">
                                <input type="password" id="newPassword" name="newPassword" placeholder="Enter your new password" required>
                                <span class="field-icon toggle-password" data-status="hidden">👁️</span>
                            </div>

                            <label for="confirmPassword">Confirm New Password:</label>
                            <div class="password-field">
                                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password" required>
                                <span class="field-icon toggle-password" data-status="hidden">👁️</span>
                            </div>

                        <!-- Add a button to save changes -->
                        <button type="button" class="btn btn-success" id="savePasswordBtn">Save Password</button>
                        <a href="#" id="cancelPasswordBtn">Cancel</a>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?php echo APPURL; ?>/logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Use jQuery to handle the button click events
        $("#editDetailsBtn").click(function () {
            // Hide details container, show the form
            $("#userDetailsContainer").hide();
            $("#editDetailsForm").show();
        });

        $("#cancelEditBtn").click(function () {
            // Hide the form, show details container
            $("#editDetailsForm").hide();
            $("#userDetailsContainer").show();
        });

        $("#saveChangesBtn").click(function () {
            // Prepare data for update
            var updatedData = {
                userId: <?php echo isset($userDetails['id']) ? $userDetails['id'] : 0; ?>,
                firstName: $("#editFirstName").val(),
                lastName: $("#editLastName").val(),
                username: $("#editUsername").val(),
                email: $("#editEmail").val()
            };

            // Send the updated data to the server via AJAX
            $.ajax({
                type: "POST",
                url: "update_user_details.php", 
                data: updatedData,
                success: function (response) {
                    // Update displayed details with edited values
                    alert(response);
                    $("#firstName").text(updatedData.firstName);
                    $("#lastName").text(updatedData.lastName);
                    $("#username").text(updatedData.username);
                    $("#email").text(updatedData.email);

                    // Hide the form, show details container
                    $("#editDetailsForm").hide();
                    $("#userDetailsContainer").show();
                },
                error: function (xhr, status, error) {
                    console.error("AJAX request error:", xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#addDetailsBtn").click(function () {

            $("#userDetailsContainer").hide();
            $("#addDetailsForm").show();
        });

        $("#cancelAddBtn").click(function () {

            $("#addDetailsForm").hide();
            $("#userDetailsContainer").show();
        });

        $("#saveAddBtn").click(function () {

            var addDetailsData = {
                userId: <?php echo isset($userDetails['id']) ? $userDetails['id'] : 0; ?>,
                streetAddress: $("#editStreetAddress").val(),
                town: $("#editTown").val(),
                zipCode: $("#editZipCode").val(),
                phone: $("#editPhone").val()
            };

            $.ajax({
                type: "POST",
                url: "add_details.php", 
                data: addDetailsData,
                success: function (response) {

                    alert(response);
                    $("#streetAddress").text(addDetailsData.streetAddress);
                    $("#town").text(addDetailsData.town);
                    $("#zipCode").text(addDetailsData.zipCode);
                    $("#phone").text(addDetailsData.phone);

                    $("#addDetailsForm").hide();
                    $("#userDetailsContainer").show();
                    
                },
                error: function (xhr, status, error) {
                    console.error("AJAX request error:", xhr.responseText);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function () {
    // Handle "Change Password" button click
    $("#changePasswordBtn").click(function () {
        $("#userDetailsContainer").hide();
        $("#changePasswordForm").show();
    });

    // Handle "Cancel Password Change" button click
    $("#cancelPasswordBtn").click(function () {
        $("#changePasswordForm").hide();
        $("#userDetailsContainer").show();
    });

    // Handle "Save Password" button click
    $("#savePasswordBtn").click(function () {
        var passwordData = {
            userId: <?php echo isset($userDetails['id']) ? $userDetails['id'] : 0; ?>,
            currentPassword: $("#currentPassword").val(),
            newPassword: $("#newPassword").val(),
            confirmPassword: $("#confirmPassword").val()
        };

        // Send the password update request to the server via AJAX
        $.ajax({
            type: "POST",
            url: "update_password.php", 
            data: passwordData,
            success: function (response) {
                alert(response);

                if (response.includes("successfully")) {
                    $("#changePasswordForm").hide();
                    $("#userDetailsContainer").show();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request error:", xhr.responseText);
            }
        });
    });
});
</script>

<script>
    $(".toggle-password").click(function() {
        var input = $(this).prev('input');
        var status = $(this).attr("data-status");
        
        if (status === "hidden") {
            input.attr("type", "text");
            $(this).text("🔒");
            $(this).attr("data-status", "visible");
        } else {
            input.attr("type", "password");
            $(this).text("👁️");
            $(this).attr("data-status", "hidden");
        }
    });
</script>

<script>
    $(document).ready(function() {
        $("#logoutButton").click(function() {
            $("#logoutConfirmationModal").modal("show");
        });
    });
</script>

</body>
</html>