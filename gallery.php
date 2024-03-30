<?php require "includes/header.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    border-radius: 8px;
    margin: 20px; 
    }

    .gallery img {
        border: 2px solid #333; 
        margin: 10px; 
        padding: 5px; 
        border-radius: 8px; 
        transition: all 0.3s ease; 
    }

    .gallery img:hover {
        opacity: 0.8; 
        transform: scale(1.1); 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); 
        background-color: #f5f5f5; 
    }

    @media (max-width: 768px) {
        .gallery {
            margin: 10px; 
        }

        .gallery img {
            margin: 5px; 
        }
    }
    .quote-section{
        margin-top: 10px;
    }
    .quote-container {
        background: linear-gradient(45deg, #3498db, #9b59b6);
        padding: 5px;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        color: #ecf0f1;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .quote-text {
        font-family: 'Pacifico', cursive;
        font-size: 30px;
        font-weight: bold;
        line-height: 1.5;
        margin-bottom: 20px;
        color: #ecf0f1;
    }

    .quote-author {
        font-style: italic;
        font-size: 10px;
        color: #ecf0f1;
    }

    .coffee-cup {
        position: absolute;
        top: 50%;
        left: -10%;
        transform: translateY(-50%);
        animation: floatCoffee 5s ease-in-out infinite alternate;
    }

    @keyframes floatCoffee {
        0% {
            transform: translateY(-50%) rotate(0deg);
        }
        100% {
            transform: translateY(-50%) rotate(10deg);
        }
    }
    .quote-icons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .quote-icons i {
        font-size: 20px;
        opacity: 0.7;
        transition: opacity 0.3s ease; /* Add a smooth transition effect */

        animation: bounceIcon 0.5s ease-in-out infinite alternate;
    }

    .quote-icons i:hover {
        opacity: 1; 
    }

    @keyframes bounceIcon {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Style for the Lightbox Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 60%;
        max-height: 95%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
    }

    .close {
        position: absolute;
        top: 20px;
        right: 150px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-content, .close {
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(images/bg_9.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Our Gallery</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Gallery</span></p>
            </div>

          </div>
        </div>
      </div>

</section>

<section class="quote-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 text-center">
                <div class="quote-container">
                    <p class="quote-text">"Sip, Savor, Repeat."</p>
                    <p class="quote-author">- Coffee Connoisseur</p>
                    <div class="quote-icons">
                        <i class="fas fa-coffee"></i>
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-gallery">
    <div class="container-wrap">
        <div class="row no-gutters">
            <?php
            $imageFilenames = array("gallery-1.jpg", "gallery-3.jpg", "gallery-4.jpg", "bg_7.jpg", "bg_5.jpg", "gallery-5.jpg", "gallery-6.jpg"
            , "gallery-7.jpg", "gallery-8.jpg", "gallery-9.jpg", "gallery-10.jpg", "gallery-11.jpg");

            foreach ($imageFilenames as $filename) {
                $imageUrl = "images/" . $filename;
                echo '
                <div class="col-md-3 ftco-animate">
                    <a href="javascript:void(0);" onclick="openModal(\'' . $imageUrl . '\')" class="gallery img d-flex align-items-center" style="background-image: url(' . $imageUrl . ');">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-search"></span>
                        </div>
                    </a>
                </div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Modal for Lightbox -->
<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<!-- Add this script after your other scripts -->
<script>
    // Function to open the modal and display the selected image
    function openModal(imageSrc) {
        var modal = document.getElementById('imageModal');
        var modalImage = document.getElementById('modalImage');

        modal.style.display = 'block';
        modalImage.src = imageSrc;
    }

    // Function to close the modal
    function closeModal() {
        var modal = document.getElementById('imageModal');
        modal.style.display = 'none';
    }
</script>

<?php require "includes/footer.php"; ?>