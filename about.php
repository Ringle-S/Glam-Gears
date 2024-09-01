<?php
session_start();

include_once('./config.php');
if (isset($_SESSION['user'])) {
  $userId = $_SESSION['user'];
  // echo $userId;
}


?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
?>

<section style="
          height: 70vh;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          background-image: url('./assets/icon/aboutban.png');
        " class="about-top w-100 d-flex flex-column justify-content-center align-items-center text-light">
  <h1 class="display-1 fw-semibold">About Us</h1>
  <p class="fs-5">The Device that takes you high</p>
</section>
<!-- about summary -->
<section class="summary">
  <h4>About Glam Gears :</h4>
  <p>
    Glam Gears is an innovative online store that offers a diverse
    selection of digital gadgets, available for purchase in both cash and
    installment options. Embodying the motto "Join the digital revolution
    today" the website not only provides a seamless shopping experience
    but also features a captivating blog section filled with insightful
    reviews, articles, and videos about cutting-edge technology and
    digital gadgets. Users can actively engage with the content through
    comments and a question-answer section, fostering a dynamic community
    of tech enthusiasts.
  </p>
  <h4>Some of Glam Gears’s impressive features :</h4>
  <ul class="list-unstyled">
    <li>Diverse digital gadgets for purchase in cash or installments</li>
    <li>
      A blog with reviews and articles about the latest technology and
      gadgets
    </li>
    <li>User comments and Q&A section for community interaction</li>
    <li>Represents a tech-savvy "home" with all necessary technology</li>
    <li>Easy-to-use interface for a great user experience</li>
    <li>Consistent and visually appealing design</li>
    <li>A hub for tech enthusiasts to connect and share insights</li>
    <li>Helps users make informed purchase decisions</li>
  </ul>
</section>
<!-- partners -->
<div class="partners d-flex justify-content-center align-items-center gap-3 mb-5 flex-wrap">
  <img class="img-fluid" src="./assets/icon/brand_1.png" alt="" />
  <img class="img-fluid" src="./assets/icon/brand_2.png" alt="" />
  <img class="img-fluid" src="./assets/icon/brand_3.png" alt="" />
  <img class="img-fluid" src="./assets/icon/brand_4.png" alt="" />
  <img class="img-fluid" src="./assets/icon/brand_5.png" alt="" />
  <img class="img-fluid" src="./assets/icon/brand_6.png" alt="" />
</div>
<!-- video Container -->
<div class="video-container row d-flex justify-content-center align-items-center gap-4">
  <div class="imageVideo position-relative col-12 col-lg-5 d-flex justify-content-center">
    <video class="" id="myVideo">
      <source src="./assets/video.mp4" type="video/mp4" />

      Your browser does not support HTML5 video.
    </video>
    <div class="btn-row position-absolute">
      <button id="playButton" class="bg-transparent border-0" type="button">
        <img class="img-fluid" src="./assets/icon/vuesax/bold/video-square.png" alt="" />
      </button>
      <button id="pauseButton" class="d-none bg-transparent border-0" type="button">
        <img class="img-fluid" src="./assets/icon/vuesax/bold/pause.png" alt="" />
      </button>
    </div>
  </div>
  <div class="videocontent col-12 col-lg-5 flex flex-column">
    <h2 class="display-4">Best Digital Store BasicStore</h2>
    <p class="fs-5">
      "Are you tired of searching for the latest gadgets? Look no further!
      [Your Store Name] is your one-stop shop for all your electronic
      needs. From cutting-edge smartphones to stylish accessories, we've
      got you covered. Experience lightning-fast delivery, competitive
      prices, and exceptional customer support.
    </p>
    <a class="bte link-underline link-underline-opacity-0" href="./shop.php">SHOP NOW</a>
  </div>
</div>
<div class="shiping row">
  <div class="col-12 col-md-6 col-lg-3 d-flex gap-3">
    <img class="img-fluid h-50" src="./assets/icon/solar_cart-large-minimalistic-outline.png" alt="" />
    <div class="row">
      <h5>FREE DELIVERY</h5>
      <p>you can create an engaging and informative</p>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 d-flex gap-3">
    <img class="img-fluid h-50" src="./assets/icon/solar_cup-outline.png" alt="" />
    <div class="row">
      <h5>QUALITY GUARANTEE</h5>
      <p>Explore our collection today and elevate</p>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 d-flex gap-3">
    <img class="img-fluid h-50" src="./assets/icon/solar_tag-price-outline.png" alt="" />
    <div class="row">
      <h5>DAILY OFFERS</h5>
      <p>Invest in professional product photography</p>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 d-flex gap-3">
    <img class="img-fluid h-50" src="./assets/icon/solar_chat-round-check-outline.png" alt="" />
    <div class="row">
      <h5>100% SECURE PAYMENT</h5>
      <p>Media platforms to reach a wider audience.</p>
    </div>
  </div>
</div>

<?php
include_once('./footer.php');
?>