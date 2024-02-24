<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php
// Assume you have a session variable indicating whether the user is logged in
$isUserLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $isUserLoggedIn) {
  // Retrieve form data
  $name = $_POST["name"];
  $email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];

  try {
      $sql = "INSERT INTO customer_inquiries (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':subject', $subject);
      $stmt->bindParam(':message', $message);
      
      if ($stmt->execute()) {
          // Success message
          echo '<script>alert("Message sent successfully!");</script>';
      } else {
          // Error message
          $errorInfo = $stmt->errorInfo();
          echo '<script>alert("Error: ' . $errorInfo[2] . '");</script>';
      }
  } catch (PDOException $e) {
      // Handle any PDO exceptions here
      echo '<script>alert("PDOException: ' . $e->getMessage() . '");</script>';
  }

  // Close the connection properly for PDO
  $conn = null;
}

?>

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(images/bg_7.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Contact Us</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Contact</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section">
      <div class="container mt-5">
        <div class="row block-9">
					<div class="col-md-4 contact-info ftco-animate">
						<div class="row">
							<div class="col-md-12 mb-4">
	              <h2 class="h4">Contact Information</h2>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Address:</span> Street 4, Dimna Chowk, Mango Jamshedpur, Jharkhand IN-831012</p>
	            </div>
	            <div class="col-md-12 mb-3">
                <p><span>Phone:</span> <a href="tel:+917004396959">+91 22 1234 5678</a></p> 
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Email:</span> <a href="mailto:dasarunabh036@gmail.com">coffee.blend@gmail.com</a></p>
	            </div>
	            <div class="col-md-12 mb-3">
	              <p><span>Website:</span> <a href="index.php">coffee-blend.com</a></p>
	            </div>
						</div>
					</div>
					<div class="col-md-1"></div>
          <div class="col-md-6 ftco-animate">
            <form action="contact.php" method="POST" class="contact-form">
            	<div class="row">
            		<div class="col-md-6">
	                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="Your Name">
	                </div>
                </div>
                <div class="col-md-6">
	                <div class="form-group">
                  <input type="text" name="email" class="form-control" placeholder="Your Email">
	                </div>
	                </div>
              </div>
              <div class="form-group">
              <input type="text" name="subject" class="form-control" placeholder="Subject">
              </div>
              <div class="form-group">
                <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <?php
                // Check if the user is logged in before rendering the submit button
                if ($isUserLoggedIn) {
                    echo '<input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">';
                } else {
                    echo '<button type="button" class="btn btn-secondary py-3 px-5" disabled>Send Message (Login Required)</button>';
                }
                ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <div id="map" class="mt-5">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1838.509069233807!2d86.22459362872881!3d22.83881842410478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f5e23814400001%3A0x7f679b2fee79a1a9!2sDimna%20Residency!5e0!3m2!1sen!2sin!4v1708751807066!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>


    <?php require "includes/footer.php"; ?>