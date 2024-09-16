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


if (isset($_GET['productID'])) {
  $productid = $_GET["productID"];


  require_once "./config.php";
  $sql = "SELECT * FROM products WHERE  product_id = ?";
  $stmt = $config->prepare($sql);
  $stmt->bind_param("s", $productid);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $productId = $row["product_id"];
    $productName = $row["product_name"];
    $productDescription = $row["product_description"];
    $productPrice = $row['product_price'];
    $discount = $row['discount_percent'];
    $discountPercent = $discount * 100;
    $productQuantity = $row['product_quantity'];
    $categoryName = $row['category_name'];
    $brandName = $row['brand_name'];
    $isFeatured = $row['is_featured'];
    // echo $isFeatured;
    // echo "<script>alert($isFeatured)</script>";
    $imgName = $row['main_image_name'];
    $imgExt = $row['main_img_extension'];
    $merchatId = $row['merchant_id'];
    if ($merchatId) {
      require_once "./config.php";
      $sql = "SELECT * FROM merchants WHERE  merchant_id = ?";
      $stmt = $config->prepare($sql);
      $stmt->bind_param("s", $merchatId);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $merchantName = $row['merchant_name'];
        $businessName = $row['business_name'];
        $merchantMail = $row['merchant_email'];
        $CreatedDate = $row['date_created'];
        $merchantPhone = $row['merchant_phone'];
      }
    }
  }



  // add to wishlist
  $errorMsg = '';
  if (isset($_POST['addWish'])) {
    $productid = $_GET["productID"];
    if ($_SESSION['user']) {
      $userId = $_SESSION['user'];

      require_once "./config.php";
      $sql = "SELECT * FROM wishlist WHERE `product_id` = '$productid' AND `user_id` = '$userId'";
      $result = mysqli_query($config, $sql);
      $rowCount = mysqli_num_rows($result);
      // echo $productid;
      if (!($rowCount > 0)) {
        require_once "./config.php";
        $query = mysqli_query($config, "INSERT INTO wishlist (`user_id`,`product_id`) VALUES('$userId','$productid')");
        header("Location: wishlist.php?productID=" . $productid);
      } else {
        $errorMsg = 'Already Waiting on your wishlist';
      }
    } else {
      header("Location: login.php?msg='You haven't logged in yet'&productID=" . $productid);
    }
  }



  // add to cart

  if (isset($_POST['addcart'])) {
    $productid = $_GET["productID"];
    $quantity = $_POST['quantity'];
    if ($_SESSION['user']) {
      $userId = $_SESSION['user'];

      require_once "./config.php";
      $sql = "SELECT * FROM cart WHERE `product_id` = '$productid' AND `user_id` = '$userId'";
      $result = mysqli_query($config, $sql);
      $rowCount = mysqli_num_rows($result);
      // echo $productid;
      if (!($rowCount > 0)) {
        require_once "./config.php";
        $query = mysqli_query($config, "INSERT INTO cart (`user_id`,`product_id`,`quantity`) VALUES('$userId','$productid','$quantity')");
        header("Location: cart.php?productID=" . $productid);
      } else {
        $errorMsg = 'Already Waiting on your Cart';
      }
    } else {
      header("Location: login.php?msg='You haven't logged in yet'&productID=" . $productid);
    }
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
?>


<!-- show product Container -->
<div class="show-container">
  <?php
  if (!empty($errorMsg)) {
    echo  '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $errorMsg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  ?>
  <?php
  if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  ?>
  <div class="row g-5">
    <div class="col-12 col-lg-6 left">
      <div class="product-imgs">
        <div class="img-display">
          <div id="imageZoom" style="
                    --url: url('./uploads/<?php echo  $imgName . '.' . $imgExt; ?>');
                    --zoom-x: 0%;
                    --zoom-y: 0%;
                    --display: none;
                  " class="img-showcase">
            <?php
            require_once "./config.php";
            $sql = "SELECT * FROM product_images WHERE  product_id = $productid";
            $result = mysqli_query($config, $sql);
            $total_row = $result->num_rows;
            if ($total_row > 0) {
            ?>
              <img src="./uploads/<?php echo  $imgName . '.' . $imgExt; ?>" alt="<?php echo $imgName ?>" />
              <?php
              while ($row = mysqli_fetch_array($result)) {
              ?>
                <img src="./uploads/<?php echo $row['img_name'] . '.' . $row['img_extension']; ?>" alt="<?php echo $row['img_name'] ?>" />
            <?php
              }
            }
            ?>
          </div>
        </div>
        <div class="img-select">
          <div class="img-item">
            <a href="#" data-id="1">
              <img src="./uploads/<?php echo  $imgName . '.' . $imgExt; ?>" alt="<?php echo $imgName ?>" />
            </a>
          </div>
          <?php
          require_once "./config.php";
          $sql = "SELECT * FROM product_images WHERE  product_id = $productid";
          $result = mysqli_query($config, $sql);
          $i = 2;
          while ($row = mysqli_fetch_array($result)) {
          ?>
            <div class="img-item">
              <a href="#" data-id="<?php echo $i ?>">
                <img src="./uploads/<?php echo $row['img_name'] . '.' . $row['img_extension']; ?>" alt="<?php echo $row['img_name'] ?>" />
              </a>
            </div>
          <?php
            $i++;
          }
          ?>

        </div>
      </div>
    </div>
    <div class="col-12 col-lg-5">
      <h2><?php echo $productName; ?></h2>
      <p class="fs-4">
        Stock: <span style="color: #f79e1b"> <?php if ($productQuantity == 0) {
                                                echo 'Out of stock';
                                              } else {
                                                echo "Instock";
                                              } ?></span>
      </p>
      <p class="fs-3">
        &#8377;<?php echo $productPrice * (1 - $discount); ?> <del class="text-black ms-3 fs-5">&#8377;<?php echo $productPrice; ?></del></span>
      </p>
      <div class="product-btn mt-5">
        <form action="" method="post">
          <div class="row d-flex align-items-center">
            <div class="col-3">
              <div style="border: 1px solid #0f6290" class="quantityContainer d-flex justify-content-between px-3 py-2">
                <i onclick="decrement()" class="bi bi-dash-lg" style="color: #0f6290; cursor: pointer"></i>
                <input id="counter" class="bg-transparent border-0 w-50 text-center" style="color: #0f6290" type="number" name="quantity" value="1" />

                <i onclick="increment()" class="bi bi-plus-lg" style="color: #0f6290; cursor: pointer"></i>
              </div>
            </div>
            <div class="col-9">
              <button type="submit" name="addcart" class="bte link-underline link-underline-opacity-0 w-100 py-4">ADD TO CART</button>
            </div>
          </div>
          <div class="row mt-4 d-flex align-items-center">
            <div class="col-11">
              <a href="./shipping.php?product_id=<?php echo $productid ?>" style="border: 1px soild #0f6290" class="bto bg-transparent link-underline link-underline-opacity-0 w-100 py-4">BUY NOW</a>
            </div>
            <div class="col-1 p-0">
              <button type="submit" name="addWish" class="bto w-100 py-4"><i class="bi bi-heart"></i></button>
            </div>
          </div>
        </form>
      </div>
      <div class="share-product mt-3">
        <p>Share this:</p>
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
      </div>
      <div class="product-details mt-4">
        <div class="accordian">
          <div style="width: 100%; height: 1px; background-color: #0f6290" class="accline"></div>
          <div class="accordian-item mt-3 active">
            <div class="accordian-head">
              <h5>Product Details</h5>
              <i class="bi bi-plus-lg"></i>
            </div>
            <div class="accordian-body">
              <?php echo  $productDescription; ?>
            </div>
            <div style="width: 100%; height: 1px; background-color: #0f6290" class="accline"></div>
          </div>
          <div class="accordian-item">
            <div class="accordian-head">
              <h5>Sellers details</h5>
              <i class="bi bi-plus-lg"></i>
            </div>

            <div class="accordian-body">
              <p class="fs-5 fw-medium">Seller Name: <span class=" fs-6 ms-2 fw-normal"><?php echo $merchantName; ?></span></p>
              <p class="fs-5 fw-medium">Business Name: <span class=" fs-6 ms-2 fw-normal"><?php echo $businessName; ?></span></p>
              <p class="fs-5 fw-medium">Mail Address: <span class=" fs-6 ms-2 fw-normal"><?php echo $merchantMail; ?></span></p>
              <p class="fs-5 fw-medium">Contact Number: <span class=" fs-6 ms-2 fw-normal"><?php echo $merchantPhone; ?></span></p>
              <p class="fs-5 fw-medium">Uploaded Date: <span class=" fs-6 ms-2 fw-normal"><?php echo $CreatedDate; ?></span>
              </p>
            </div>
            <div style="width: 100%; height: 1px; background-color: #0f6290" class="accline"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SIMILAR PRODUCTS -->
<section class="seller">
  <div class="col-12">
    <h2 class="text-start h1 fw-semibold">SIMILAR ITEMS</h2>
    <div class="row sellers-card p-0 p-md-5 p-lg-0">
      <div class="row g-5">
        <?php
        $sql = "SELECT * FROM products WHERE is_featured='1' AND product_status='active' ORDER BY id DESC LIMIT 4;";
        $result = mysqli_query($config, $sql);
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <form method="post" class=" col-12 col-md-6 col-lg-3  ">
            <input class="d-none" type="text" name="productid" value="<?php echo $row['product_id']; ?>">
            <a href="./showproduct.php?productID=<?php echo $row['product_id']; ?>" class="link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller">
              <div class="row">
                <img class="img-fluid" src="./uploads/<?php echo $row['main_image_name'] . '.' . $row['main_img_extension']; ?>" alt="" />
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



<?php
include_once('./footer.php');
?>