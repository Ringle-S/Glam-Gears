<?php
session_start();

include_once('./config.php');
if (isset($_SESSION['user'])) {
  $userId = $_SESSION['user'];
  // echo $userId;
}


// add to cart

if (isset($_POST['addcart'])) {
  $productid = $_POST["productid"];

  if ($_SESSION['user']) {
    $userId = $_SESSION['user'];

    require_once "./config.php";
    $sql = "SELECT * FROM cart WHERE `product_id` = '$productid' AND `user_id` = '$userId'";
    $result = mysqli_query($config, $sql);
    $rowCount = mysqli_num_rows($result);
    // echo $productid;
    if (!($rowCount > 0)) {
      require_once "./config.php";
      $query = mysqli_query($config, "INSERT INTO cart (`user_id`,`product_id`) VALUES('$userId','$productid')");
      header("Location: cart.php?productID=" . $productid);
    } else {
      $errorMsg = 'Already Waiting on your Cart';
    }
  } else {
    header("Location: login.php?msg='You haven't logged in yet'&productID=" . $productid);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
// echo $userId;
?>

<!-- content -->
<section class="banner-container">
  <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./assets/img/bannerhome1.jpg" class="w-100 d-none d-lg-block object-fit-cover" style="background-position: bottom;" alt="..." />
        <img src="./assets/img/mobbanhome1.jpg" class="w-100 d-block d-lg-none object-fit-contain" style="background-position: bottom;" alt="..." />
        <div class="carousel-caption caroCaption text-center text-lg-start d-flex flex-column align-items-center align-items-lg-start gap-3">
          <h5 class="">All New Phones up to 25% Flat Sale</h5>
          <h2>WELCOME TO SMARTWORLD</h2>
          <a href="./shop.php" class="btr link-underline link-underline-opacity-0 align-self-center align-self-lg-start">
            SHOP NOW
          </a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="./assets/img/bannerhome2.jpg" class="w-100 d-none d-lg-block object-fit-cover" style="background-position: bottom;" alt="..." />
        <img src="./assets/img/mobbanhome2.jpg" class="w-100 d-block d-lg-none object-fit-contain" style="background-position: bottom;" alt="..." />
        <div class="carousel-caption caroCaption text-center text-lg-start d-flex flex-column align-items-center align-items-lg-start gap-3">
          <h5 class="">All New Phones up to 25% Flat Sale</h5>
          <h2>LET'S CHANGE YOUR STYLE IN TRENDS</h2>
          <a href="./shop.php" class="btr link-underline link-underline-opacity-0 align-self-center align-self-lg-start">
            SHOP NOW
          </a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="./assets/img/bannerhome3.jpg" class="w-100 d-none d-lg-block object-fit-cover" style="background-position: bottom;" alt="..." />
        <img src="./assets/img/mobbanhome3.jpg" class="w-100 d-block d-lg-none object-fit-contain" style="background-position: bottom;" alt="..." />
        <div class="carousel-caption caroCaption text-center text-lg-start d-flex flex-column align-items-center align-items-lg-start gap-3">
          <h5 class="">All New Latest smart watch</h5>
          <h2>UP TO 25% FLAT <br>SALE All NEW WATCHES</h2>
          <a href="./shop.php" class="btr link-underline link-underline-opacity-0 align-self-center align-self-lg-start">
            SHOP NOW
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<style>

</style>
<!-- category container -->
<section style="height: fit content; padding: 10vh 0 " class="category d-flex justify-content-center align-items-center px-5 w-100 gap-3 overflow-x-scroll">
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/Camera.png" alt="" />
    <h6 class="text-gray-700">CAMERA</h6>
  </div>
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/Computer.png" alt="" />
    <h6 class="text-gray-700">COMPUTER</h6>
  </div>
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/TV&video.png" alt="" />
    <h6 class="text-gray-700">TV&VIDEO</h6>
  </div>
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/Watch.png" alt="" />
    <h6 class="text-gray-700">WATCH</h6>
  </div>
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/speakers.png" alt="" />
    <h6 class="text-gray-700">SPEAKERS</h6>
  </div>
  <div class="cat-card bg-light px-5 d-flex flex-column shadow-sm gap-4 justify-content-center align-items-center text-center">
    <img class="img-fluid w-75" src="./assets/icon/ElectronicDevices.png" alt="" />
    <h6 class="text-gray-700">ELECTRONIC DEVICES</h6>
  </div>
</section>
<!-- christmas container -->
<section class="christmas row">
  <div style="background-color: #f7f6f5" class="col-12 col-lg-6 p-2 p-md-5 d-flex flex-column gap-3 text-center justify-content-center">
    <h2 class="fs-1">Up to 40% off our Christmas collection</h2>
    <p class="fs-5">
      It is a long established fact that a reader will be distracted by
      the readable content of a page when looking at it's layout. the offer could save you a lot of amount
    </p>
    <a href="./shop.php" class="link link-dark fw-bold"> SHOP NOW</a>
  </div>
  <div class="col-12 col-lg-6 p-5 gradient d-flex justify-content-center align-items-center">
    <img width="290px" height="290px" class="img-fluid" src="./assets/img/christlap.png" alt="" />
  </div>
</section>

<!-- best Seller -->
<section class="seller">
  <div class="col-12">
    <h2 class="text-center h1 fw-semibold">BEST SELLERS</h2>
    <div class="row sellers-card p-0 p-md-0 g-0">
      <div class="row  gap-3 gap-md-0 g-0 g-md-5">
        <?php
        $sql = "SELECT p.product_id,p.main_image_name,p.discount_percent,p.product_description,p.category_name, p.product_name, p.product_price,(p.product_price*oi.quantity) AS total_amt FROM order_items oi INNER JOIN products p ON oi.product_id = p.product_id GROUP BY p.product_id ORDER BY total_amt DESC LIMIT 8;";
        $result = mysqli_query($config, $sql);
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <form method="post" class=" col-12 col-md-6 col-lg-3  ">
            <input class="d-none" type="text" name="productid" value="<?php echo $row['product_id']; ?>">
            <a href="./showproduct.php?productID=<?php echo $row['product_id']; ?>" class="link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller">
              <div class="row">
                <img height="330px" class=" img-fluid object-fit-contain" src="./uploads/<?php echo $row['main_image_name']; ?>" alt="" />
              </div>
              <div class="row mt-2">
                <p style="height: 35px; overflow: hidden;" class="fw-medium fs-5 text-black"><?php echo $row['product_name']; ?></p>
              </div>
              <div class="row">
                <h5 style="color: #0f6290;" class=" fs-3">&#8377;<?php echo $row['product_price'] * (1 - $row['discount_percent']); ?> <del class="text-black ms-3 fs-5">&#8377;<?php echo $row['product_price']; ?></del></h5>
              </div>
              <div class="row">
                <p style="height: 50px; overflow: hidden;" class="productDesc text-secondary">
                  <?php echo $row['product_description']; ?>
                </p>
              </div>
            </a>
            <div class="row">
              <button type="submit" name="addcart" class="btn-main-outline text-center ">
                ADD TO CART
              </button>
            </div>
          </form>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<!-- trends container -->
<section class="trends">
  <section class="christmas row">
    <div class="col-12 col-lg-6 p-5 gradient d-flex flex-column-reverse flex-lg-row justify-content-center align-items-center">
      <img class="img-fluid" src="./assets/img/mobilecover.png" alt="" />
    </div>
    <div style="background-color: #f7f6f5" class="col-12 col-lg-6 p-3 p-md-5 d-flex flex-column gap-3 text-center justify-content-center">
      <h2 class="fs-1">Our Histroy</h2>
      <p class="fs-5">
        The point of It is a long established fact that a reader will be
        distracted by the readable content of a page when looking at it's
        layout. The point of It is a long established fact that a reader
        will be distracted
      </p>
      <a href="./about.php" class="link link-dark fw-bold">LEARN MORE</a>
    </div>
  </section>
  <section class="christmas row d-flex flex-column-reverse flex-lg-row">
    <div style="background-color: #f7f6f5" class="col-12 col-lg-6 p-3 p-md-5 d-flex flex-column gap-3 text-center justify-content-center">
      <h2 class="fs-1">Medal Worthy Brands To Bag</h2>
      <p class="fs-5">
        It is a long established fact that a reader will be distracted by
        the readable content of a page when looking at it's layout. The
        point of using Lorem Ipsum is that
      </p>
      <a href="./shop.php" class="link link-dark fw-bold"> SHOP NOW</a>
    </div>
    <div class="col-12 col-lg-6 p-5 gradient d-flex justify-content-center align-items-center">
      <img class="img-fluid" src="./assets/img/system.png" alt="" />
    </div>
  </section>
</section>

<!-- new Seller -->
<section class="seller">
  <div class="col-12 d-flex flex-column justify-content-center">
    <h2 class="text-center h1 fw-semibold">DISCOVER NEW ARRIVALS</h2>
    <div class="row sellers-card p-0 p-md-0 g-0">
      <div class="row  gap-3 gap-md-0 g-0 g-md-5 ">
        <?php
        $sql = "SELECT * FROM products WHERE is_featured='1' AND product_status='active' ORDER BY id DESC LIMIT 4;";
        $result = mysqli_query($config, $sql);
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <form method="post" class=" col-12 col-md-6 col-lg-3  ">
            <input class="d-none" type="text" name="productid" value="<?php echo $row['product_id']; ?>">
            <a href="./showproduct.php?productID=<?php echo $row['product_id']; ?>" class="link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller">
              <div class="row">
                <img height="330px" class=" img-fluid object-fit-contain" src="./uploads/<?php echo $row['main_image_name']; ?>" alt="" />
              </div>
              <div class="row mt-2">
                <p style="height: 35px; overflow: hidden;" class="fw-medium fs-5 text-black"><?php echo $row['product_name']; ?></p>
              </div>
              <div class="row">
                <h5 style="color: #0f6290;" class=" fs-3">&#8377;<?php echo $row['product_price'] * (1 - $row['discount_percent']); ?> <del class="text-black ms-3 fs-5">&#8377;<?php echo $row['product_price']; ?></del></h5>
              </div>
              <div class="row">
                <p style="height: 50px; overflow: hidden;" class="productDesc text-secondary">
                  <?php echo $row['product_description']; ?>
                </p>
              </div>
            </a>
            <div class="row">
              <button type="submit" name="addcart" class="btn-main-outline text-center ">
                ADD TO CART
              </button>
            </div>
          </form>

        <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<!-- timer section -->
<section class="timer row d-flex align-items-center justify-content-center mt-5">
  <div class="col-11 col-lg-5 d-flex justify-content-center align-items-center">
    <img class="img-fluid" src="./assets/img/countTv.png" alt="" />
  </div>
  <div class="col-11 col-lg-5 d-flex flex-column justify-content-center gap-3">
    <h2 class="display-3">30% DISCOUNT ON PC COLLECTION</h2>
    <div class="timer-content d-flex align-items-center gap-3">
      <div class="d-flex flex-column align-items-center">
        <p id="days" class="fs-1 mb-0">00</p>
        <p>Days</p>
      </div>

      <div class="d-flex flex-column align-items-center">
        <p id="hours" class="fs-1 mb-0">
          00<span class="mx-2">&#58;</span>
        </p>
        <p>Hours</p>
      </div>

      <div class="d-flex flex-column align-items-center">
        <p id="minutes" class="fs-1 mb-0">
          00<span class="mx-2">&#58;</span>
        </p>
        <p>Minutes</p>
      </div>

      <div class="d-flex flex-column align-items-center">
        <p id="seconds" class="fs-1 mb-0">00</p>
        <p>Seconds</p>
      </div>
    </div>
    <a href="./shop.php" class="bte link-underline link-underline-opacity-0">SHOP NOW</a>
  </div>
</section>

<!-- social media -->
<section class="socialmedia d-flex flex-column align-items-center py-5 gap-4 text-center">
  <span class="fs-3 fw-semibold">Follow us on Social Media</span>
  <h2 class="fs-1">FOR NEWS, COLLECTIONS & MORE</h2>
  <div class="mediarow d-flex gap-3">
    <a href="https://www.facebook.com/login/" target="_blank">
      <img src="./assets/icon/Social Media Icon Square/Facebook.png" alt="" />
    </a>
    <a href="https://www.instagram.com/accounts/login/" target="_blank">
      <img src="./assets/icon/Social Media Icon Square/Instagram.png" alt="" />
    </a>
    <a href="https://www.linkedin.com/feed/" target="_blank">
      <img src="./assets/icon/Social Media Icon Square/LinkedIn.png" alt="" />
    </a>
    <a href="https://x.com/i/flow/login" target="_blank">
      <img src="./assets/icon/Social Media Icon Square/Twitter.png" alt="" />
    </a>
    <a href="https://www.youtube.com/account" target="_blank">
      <img src="./assets/icon/Social Media Icon Square/YouTube.png" alt="" />
    </a>
  </div>
</section>


<?php
include_once('./footer.php');
?>