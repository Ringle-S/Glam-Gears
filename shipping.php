<?php
session_start();

include_once('./config.php');
$userId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
  header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
}
if (isset($_GET['product_id'])) {

  $selectedProductId = $_GET['product_id'];
  $selectedQuantity = $_GET['quantity'];
}

if (isset($_POST['couponSubmit'])) {


  $couponCode = $_POST['couponvalue'];
}

function generateRandomFiveDigitNumber()
{
  $randomNumber = mt_rand(5000, 9999);
  return $randomNumber;
}
function generateRandomFiveDigitNumber2()
{
  $randomNumber = mt_rand(80000, 99999);
  return $randomNumber;
}
$randomNumber = generateRandomFiveDigitNumber();
$randomNumber2 = generateRandomFiveDigitNumber2();


$errMsg = '';
if (isset($_POST['placeOrder'])) {

  $trackid = $randomNumber2;

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $shipMail = $_POST['shipMail'];
  $shipAddress = $_POST['shipAddress'];
  $shipState = $_POST['shipState'];
  $shipCity = $_POST['shipCity'];
  $shipCode = $_POST['shipZip'];
  $shipMobile = $_POST['shipPhone'];
  $shipTotalAmount = $_POST['totalCost'];
  $shipPaymentMode = $_POST['payment'];
  $couponCode = $_POST['couponvalue'];
  $cardnumber = $_POST['cardNumber'];
  $cardname = $_POST['nameOnCard'];
  $expDate = $_POST['expiryDate'];
  $errors = array();
  // echo $shipPaymentMode . "<br>";
  if (empty($fname) or empty($lname) or empty($shipAddress) or empty($shipMail) or empty($shipCity) or empty($shipState) or empty($shipMobile) or empty($shipCode)) {
    array_push($errors, "All fields are required");
  }
  if (!filter_var($shipMail, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Email is not valid");
  }
  if (strlen($shipMobile) != 10) {
    array_push($errors, "Mobile number must have 10 digits");
  }
  if (strlen($shipCode) != 6) {
    array_push($errors, "Zip code must have 6 digits");
  }

  if (count($errors) > 0) {
    foreach ($errors as  $error) {
      $errMsg = $error;
    }
  } else {

    if (isset($selectedProductId)) {
      if ($shipPaymentMode == "card") {
        include_once('./config.php');
        $sql = "INSERT INTO payments (track_id, cardnumber, cardname, expire_date) VALUES (?, ?, ?, ?)";
        $stmt = $config->prepare($sql);

        if (!$stmt) {
          die('Prepare failed: ' . $config->error);
        }

        $stmt->bind_param("isss", $trackid, $cardnumber, $cardname, $expDate);

        if (!$stmt->execute()) {
          die('Execute failed1: ' . $stmt->error);
        } else {
          include_once('./config.php');
          $insert_query = "INSERT INTO orders (`tracking_no`,`user_id`,`fname`,`lname`,`email`,`address`,`state`,`city`,`zipcode`,`phone`,`total_amount`,`coupon_code`,`payment_mode`) VALUES ('$trackid','$userId','$fname','$lname','$shipMail','$shipAddress','$shipState','$shipCity','$shipCode','$shipMobile','$shipTotalAmount','$couponCode','$shipPaymentMode')";
          $stmt2 = $config->prepare($insert_query);
          if (!$stmt2) {
            die('Prepare failed: ' . $config->error);
          }
          if (!$stmt2->execute()) {
            die('Execute failed2: ' . $stmt2->error);
          } else {
            include_once('./config.php');
            $productSql = "SELECT order_id FROM orders WHERE tracking_no = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $trackid);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
              $orderId = $row['order_id'];
            }
            // Insert order items
            $productSql = "SELECT products.product_id, products.product_price, products.product_name,products.product_quantity FROM products WHERE products.product_id = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $selectedProductId);
            $stmt->execute();
            $result_new = $stmt->get_result();

            while ($row = $result_new->fetch_assoc()) {
              $productId = $row['product_id'];
              $productQuantity = $selectedQuantity;
              $productPrice = $row['product_price'];
              $productName = $row['product_name'];
              $actualQuantity = $row['product_quantity'];
              echo $newQuantity = $actualQuantity - $productQuantity . "<br>";

              $order_item_sql = "INSERT INTO order_items (product_id, order_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
              $stmt3 = $config->prepare($order_item_sql);
              $stmt3->bind_param("iiids", $productId, $orderId, $productQuantity, $productPrice, $productName);
              $stmt3->execute();
            }

            $quantitySql = "UPDATE `products` SET `product_quantity`=? WHERE `product_id` = ?";
            $stmtQ = $config->prepare($quantitySql);
            $stmtQ->bind_param("ii", $newQuantity, $productId);

            if (!$stmtQ) {
              die('Prepare failed: ' . $config->error);
            }

            if (!$stmtQ->execute()) {
              die('Execute failedQ: ' . $stmtQ->error);
            } else {
              $_SESSION['message'] = "Order placed successfully";
              $productSql = "DELETE FROM cart WHERE user_id = ?";
              $stmt = $config->prepare($productSql);
              $stmt->bind_param("i", $userId);
              $stmt->execute();
              header('Location: ./orders.php');
              die();
            }

            $stmt3->close();
          }
        }
      } else {
        // include_once('./config.php');
        $insert_query = "INSERT INTO orders (`tracking_no`,`user_id`,`fname`,`lname`,`email`,`address`,`state`,`city`,`zipcode`,`phone`,`total_amount`,`coupon_code`,`payment_mode`) VALUES ('$trackid','$userId','$fname','$lname','$shipMail','$shipAddress','$shipState','$shipCity','$shipCode','$shipMobile','$shipTotalAmount','$couponCode','$shipPaymentMode')";
        $stmt2 = $config->prepare($insert_query);

        if (!$stmt2) {
          die('Prepare failed: ' . $config->error);
        }
        if (!$stmt2->execute()) {
          die('Execute failed2: ' . $stmt2->error);
        } else {
          include_once('./config.php');
          $productSql = "SELECT order_id FROM orders WHERE tracking_no = ?";
          $stmt = $config->prepare($productSql);
          $stmt->bind_param("i", $trackid);
          $stmt->execute();
          $result = $stmt->get_result();

          while ($row = $result->fetch_assoc()) {
            $orderId = $row['order_id'];
          }
          // Insert order items
          $productSql = "SELECT products.product_id, products.product_price, products.product_name,products.product_quantity FROM products WHERE products.product_id = ?";
          $stmt = $config->prepare($productSql);
          $stmt->bind_param("i", $selectedProductId);
          $stmt->execute();
          $result_new = $stmt->get_result();

          while ($row = $result_new->fetch_assoc()) {
            $productId = $row['product_id'];
            $productQuantity = $selectedQuantity;
            $productPrice = $row['product_price'];
            $productName = $row['product_name'];
            $actualQuantity = $row['product_quantity'];
            echo $newQuantity = $actualQuantity - $productQuantity . "<br>";

            $order_item_sql = "INSERT INTO order_items (product_id, order_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
            $stmt3 = $config->prepare($order_item_sql);
            $stmt3->bind_param("iiids", $productId, $orderId, $productQuantity, $productPrice, $productName);
            $stmt3->execute();
          }

          $quantitySql = "UPDATE `products` SET `product_quantity`=? WHERE `product_id` = ?";
          $stmtQ = $config->prepare($quantitySql);
          $stmtQ->bind_param("ii", $newQuantity, $productId);

          if (!$stmtQ) {
            die('Prepare failed: ' . $config->error);
          }

          if (!$stmtQ->execute()) {
            die('Execute failedQ: ' . $stmtQ->error);
          } else {
            $_SESSION['message'] = "Order placed successfully";
            $productSql = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            header('Location: ./orders.php');
            die();
          }
        }
        $stmt3->close();
      }
    } else {
      if ($shipPaymentMode == "card") {
        include_once('./config.php');
        $sql = "INSERT INTO payments (track_id, cardnumber, cardname, expire_date) VALUES (?, ?, ?, ?)";
        $stmt = $config->prepare($sql);

        if (!$stmt) {
          die('Prepare failed: ' . $config->error);
        }

        $stmt->bind_param("isss", $trackid, $cardnumber, $cardname, $expDate);

        if (!$stmt->execute()) {
          die('Execute failed1: ' . $stmt->error);
        } else {
          include_once('./config.php');
          $insert_query = "INSERT INTO orders (`tracking_no`,`user_id`,`fname`,`lname`,`email`,`address`,`state`,`city`,`zipcode`,`phone`,`total_amount`,`coupon_code`,`payment_mode`) VALUES ('$trackid','$userId','$fname','$lname','$shipMail','$shipAddress','$shipState','$shipCity','$shipCode','$shipMobile','$shipTotalAmount','$couponCode','$shipPaymentMode')";
          $stmt2 = $config->prepare($insert_query);
          if (!$stmt2) {
            die('Prepare failed: ' . $config->error);
          }
          if (!$stmt2->execute()) {
            die('Execute failed2: ' . $stmt2->error);
          } else {
            include_once('./config.php');
            $productSql = "SELECT order_id FROM orders WHERE tracking_no = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $trackid);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
              $orderId = $row['order_id'];
            }
            // Insert order items
            $productSql = "SELECT products.product_id, cart.quantity, products.product_price, products.product_name,products.product_quantity FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result_new = $stmt->get_result();

            while ($row = $result_new->fetch_assoc()) {
              $productId = $row['product_id'];
              $productQuantity = $row['quantity'];
              $productPrice = $row['product_price'];
              $productName = $row['product_name'];
              $actualQuantity = $row['product_quantity'];
              echo $newQuantity = $actualQuantity - $productQuantity . "<br>";

              $order_item_sql = "INSERT INTO order_items (product_id, order_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
              $stmt3 = $config->prepare($order_item_sql);
              $stmt3->bind_param("iiids", $productId, $orderId, $productQuantity, $productPrice, $productName);
              $stmt3->execute();
            }

            $quantitySql = "UPDATE `products` SET `product_quantity`=? WHERE `product_id` = ?";
            $stmtQ = $config->prepare($quantitySql);
            $stmtQ->bind_param("ii", $newQuantity, $productId);

            if (!$stmtQ) {
              die('Prepare failed: ' . $config->error);
            }

            if (!$stmtQ->execute()) {
              die('Execute failedQ: ' . $stmtQ->error);
            } else {
              $_SESSION['message'] = "Order placed successfully";
              $productSql = "DELETE FROM cart WHERE user_id = ?";
              $stmt = $config->prepare($productSql);
              $stmt->bind_param("i", $userId);
              $stmt->execute();
              header('Location: ./orders.php');
              die();
            }

            $stmt3->close();
          }
        }
      } else {
        // include_once('./config.php');
        $insert_query = "INSERT INTO orders (`tracking_no`,`user_id`,`fname`,`lname`,`email`,`address`,`state`,`city`,`zipcode`,`phone`,`total_amount`,`coupon_code`,`payment_mode`) VALUES ('$trackid','$userId','$fname','$lname','$shipMail','$shipAddress','$shipState','$shipCity','$shipCode','$shipMobile','$shipTotalAmount','$couponCode','$shipPaymentMode')";
        $stmt2 = $config->prepare($insert_query);

        if (!$stmt2) {
          die('Prepare failed: ' . $config->error);
        }
        if (!$stmt2->execute()) {
          die('Execute failed2: ' . $stmt2->error);
        } else {
          // include_once('./config.php');
          $productSql = "SELECT order_id FROM orders WHERE tracking_no = ?";
          $stmt = $config->prepare($productSql);
          $stmt->bind_param("i", $trackid);
          $stmt->execute();
          $result = $stmt->get_result();

          $row = $result->fetch_assoc();
          $orderId = $row['order_id'];

          $productSql = "SELECT products.product_id, cart.quantity, products.product_price, products.product_name, products.product_quantity FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
          $stmt = $config->prepare($productSql);
          $stmt->bind_param("i", $userId);
          $stmt->execute();
          $result_new = $stmt->get_result();

          while ($row = $result_new->fetch_assoc()) {
            $productId = $row['product_id'];
            $productQuantity = $row['quantity'];
            $productPrice = $row['product_price'];
            $productName = $row['product_name'];
            $actualQuantity = $row['product_quantity'];
            echo $newQuantity = $actualQuantity - $productQuantity . "<br>";

            $order_item_sql = "INSERT INTO order_items (product_id, order_id, quantity, price, product_name) VALUES (?, ?, ?, ?, ?)";
            $stmt3 = $config->prepare($order_item_sql);
            $stmt3->bind_param("iiids", $productId, $orderId, $productQuantity, $productPrice, $productName);
            $stmt3->execute();
          }

          $quantitySql = "UPDATE `products` SET `product_quantity`=? WHERE `product_id` = ?";
          $stmtQ = $config->prepare($quantitySql);
          $stmtQ->bind_param("ii", $newQuantity, $productId);

          if (!$stmtQ) {
            die('Prepare failed: ' . $config->error);
          }

          if (!$stmtQ->execute()) {
            die('Execute failedQ: ' . $stmtQ->error);
          } else {
            $_SESSION['message'] = "Order placed successfully";
            $productSql = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $config->prepare($productSql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            header('Location: ./orders.php');
            die();
          }
        }
        $stmt3->close();
      }
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
<?php

$errorMsg = "";
if (isset($_POST['couponSubmit'])) {
  $couponCode = $_POST['couponvalue'];
  // echo  $couponCode;

  require_once "./config.php";
  $sql = "SELECT * FROM coupons WHERE coupon_code = ?";
  $stmt = $config->prepare($sql);
  $stmt->bind_param("s", $couponCode);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $couponDiscount = $row['coupon_value'];
    // echo $couponDiscount;
  } else {
    $errorMsg = "NO coupon available";
  }
}
?>

<!-- billing details -->
<div class="billing-details row">
  <div class="row d-flex justify-content-center justify-content-lg-between align-items-center mb-4">
    <div class="col-12 col-lg-4 d-flex align-items-center">
      <a href="./cart.php" class="text-secondary link-underline link-underline-opacity-0"><i class="bi bi-chevron-left me-2"></i>RETURN TO CART</a>
    </div>
  </div>
  <form action="" method="post" class="row">
    <div style="color: #001e2f" class="col-lg-7 col-12 mb-4">
      <h3 class="fw-bold">BILLING DETAILS</h3>
      <?php if ($errMsg != '') {
        echo "<div class='alert alert-danger'>$errMsg</div>";
      } ?>

      <div class="row d-flex flex-column justify-content-center gap-3 mt-3">
        <div class="row">
          <div class="col-6">
            <label for="fname" class="form-label">First Name*</label>
            <input required type="text" class="form-control py-2 rounded-0 display-6" style="border: 1px solid #001e2f" placeholder="First name" aria-label="First name" name="fname" id="fname" value="<?php if (isset($fname)) {
                                                                                                                                                                                                          echo $fname;
                                                                                                                                                                                                        } ?>" required />
          </div>
          <div class="col-6">
            <label for="lname" class="form-label">Last Name*</label>
            <input required type="text" class="form-control py-2 rounded-0 display-6" style="border: 1px solid #001e2f" placeholder="Last name" aria-label="Last name" name="lname" id="lname" value="<?php if (isset($lname)) {
                                                                                                                                                                                                        echo $lname;
                                                                                                                                                                                                      } ?>" required />
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input required type="email" class="form-control py-2 rounded-0 display-6" style="border: 1px solid #001e2f" name="shipMail" placeholder="example@youremail.com" id="inputEmail4" value="<?php if (isset($shipMail)) {
                                                                                                                                                                                                        echo $shipMail;
                                                                                                                                                                                                      } ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label for="inputAddress" class="form-label">Street Address*</label>
            <input required type="text" class="form-control py-2 rounded-0 display-6" name="shipAddress" style="border: 1px solid #001e2f" id="inputAddress" placeholder="1234 Main St" value="<?php if (isset($shipAddress)) {
                                                                                                                                                                                                  echo $shipAddress;
                                                                                                                                                                                                } ?>" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label for="inputState" class="form-label">State*</label>
            <select onchange="loadStates()" id="inputState" name="shipState" class="form-select py-2 rounded-0 display-6" style="border: 1px solid #001e2f">
              <option disabled>State</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="inputCity" class="form-label">Town / City*</label>
            <input style="border: 1px solid #001e2f" type="text" name="shipCity" id="inputCity" placeholder="Enter your city/town" class="form-select py-2 rounded-0 display-6" value="<?php if (isset($shipCity)) {
                                                                                                                                                                                          echo $shipCity;
                                                                                                                                                                                        } ?>" required>

          </div>
        </div>
        <div class=" row">
          <div class="col-md-6 position-relative">
            <label for="inputZip" class="form-label">Zip Code</label>
            <input required type="number" placeholder="Zip code" name="shipZip" class="form-control py-2 rounded-0 display-6" style="border: 1px solid #001e2f" id="inputZip" value="<?php if (isset($shipCode)) {
                                                                                                                                                                                        echo $shipCode;
                                                                                                                                                                                      } ?>" required />
            <ul id="pincodes" class="pincodes list-unstyled"></ul>
          </div>
          <div class="col-md-6">
            <label for="inputMobile" class="form-label">Phone*</label>
            <input required type="number" placeholder="(123) 456 - 7890" name="shipPhone" class="form-control py-2 rounded-0 display-6" style="border: 1px solid #001e2f" id="inputMobile" value="<?php if (isset($shipMobile)) {
                                                                                                                                                                                                    echo $shipMobile;
                                                                                                                                                                                                  } ?>" required />
          </div>
        </div>

      </div>
    </div>
    <div class="col-lg-5 col-12">
      <div class="row">
        <div class="col-12 d-flex justify-content-between">
          <!-- <?php echo $selectedProductId;  ?> -->
          <h4>Product</h4>
          <h4>Subtotal</h4>
        </div>
      </div>
      <div class="line w-100 my-3"></div>
      <?php
      include('./config.php');

      if (isset($selectedProductId)) {
        $productSql1 = "SELECT  products.product_id AS productID, products.main_image_name AS img_name, products.product_name AS productName, products.product_price AS productPrice,products.discount_percent AS discountpercent FROM products WHERE  products.product_id = ?";
        $productStmt1 = $config->prepare($productSql1);
        $productStmt1->bind_param("i", $selectedProductId);
        $productStmt1->execute();
        $productResult1 = $productStmt1->get_result();
        if ($productResult1->num_rows > 0) {
          while ($productRow = $productResult1->fetch_assoc()) {


      ?>
            <div class="row">
              <div class="col-12 d-flex justify-content-between align-items-center">
                <p class="mb-0"><?php echo $productRow['productName']; ?> <span class="ms-2">&#215;<?php echo $selectedQuantity; ?></span></p>
                <div class=" d-flex align-items-center justify-content-end w-25 ">
                  &#8377;<input disabled type="number" class="form-control bg-transparent border-0  text-end text-dark" value="<?php
                                                                                                                                echo $productRow['productPrice'] * $selectedQuantity;
                                                                                                                                ?>" />
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
          <div class="col-12 text-center">Your have no Product</div>
          </div>';
        }
      } else {

        $productSql = "SELECT  products.product_id AS productID, cart.cart_id AS cartID, products.main_image_name AS img_name, products.product_name AS productName, products.product_price AS productPrice,products.discount_percent AS discountpercent , cart.quantity AS quantity FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
        $productStmt = $config->prepare($productSql);
        $productStmt->bind_param("i", $userId);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        if ($productResult->num_rows > 0) {
          while ($productRow = $productResult->fetch_assoc()) {


          ?>
            <div class="row">
              <div class="col-12 d-flex justify-content-between align-items-center">
                <p class="mb-0"><?php echo $productRow['productName']; ?> <span class="ms-2">&#215;<?php echo $productRow['quantity']; ?></span></p>
                <div class=" d-flex align-items-center justify-content-end w-25 ">
                  &#8377;<input disabled type="number" class="form-control bg-transparent border-0  text-end text-dark" value="<?php
                                                                                                                                echo $productRow['productPrice'] * $productRow['quantity'];
                                                                                                                                ?>" />
                </div>
              </div>
            </div>
      <?php
          }
        } else {
          echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
          <div class="col-12 text-center">Your have no Product</div>
          </div>';
        }
      }
      ?>



      <?php
      include('./config.php');

      $productSql = "SELECT SUM(products.product_price * cart.quantity) AS total_price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
      $productStmt = $config->prepare($productSql);
      $productStmt->bind_param("i", $userId);
      $productStmt->execute();
      $productResult = $productStmt->get_result();

      if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        // $totalCart = round_to_2dp($productRow['total_price']);
        $totalCart = round($productRow['total_price'], 2);
        // echo $totalCart . "<br>";
      }

      $productStmt->close();

      // 
      $productSql = "SELECT SUM(products.product_price* cart.quantity) AS total_price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
      $productStmt = $config->prepare($productSql);
      $productStmt->bind_param("i", $userId);
      $productStmt->execute();
      $productResult = $productStmt->get_result();

      if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        // $totalCart = round_to_2dp($productRow['total_price']);
        $subTotal = round($productRow['total_price'], 2);
        // echo $totalCart . "<br>";
      }

      $productStmt->close();

      // 
      $productSql = "SELECT SUM( (products.product_price * products.discount_percent) * cart.quantity) AS total_price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
      $productStmt = $config->prepare($productSql);
      $productStmt->bind_param("i", $userId);
      $productStmt->execute();
      $productResult = $productStmt->get_result();

      if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        // $totalCart = round_to_2dp($productRow['total_price']);
        $disTotal = round($productRow['total_price'], 2);
        $discount = $subTotal -  $disTotal;
      }

      $productStmt->close();



      $errorMsg = "";
      if (isset($_POST['couponSubmit'])) {

        $couponCode = $_POST['couponvalue'];
        // echo  $couponCode;

        require_once "./config.php";
        $sql = "SELECT * FROM coupons WHERE coupon_code = ?";
        $stmt = $config->prepare($sql);
        $stmt->bind_param("s", $couponCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $couponDiscount = $row['coupon_value'];
          // echo $couponDiscount;
        } else {
          $errorMsg = "Invalid Coupon Code";
        }
      }
      if (isset($selectedProductId)) {
        $productSql1 = "SELECT  products.product_id AS productID, products.main_image_name AS img_name, products.product_name AS productName, products.product_price AS productPrice,products.discount_percent AS discountpercent FROM products WHERE  products.product_id = ?";
        $productStmt1 = $config->prepare($productSql1);
        $productStmt1->bind_param("i", $selectedProductId);
        $productStmt1->execute();
        $productResult1 = $productStmt1->get_result();
        if ($productResult1->num_rows > 0) {
          while ($productRow = $productResult1->fetch_assoc()) {
            $productPrice = $productRow['productPrice'] - ($productRow['productPrice'] * ($productRow['discountpercent']));
            $discountpercent = $productRow['productPrice'] - $productPrice;
            // $productPrice = $productRow['productPrice'];
          }
        }
      }
      ?>
      <div class="row mt-5">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h5 class="fw-semibold">Subtotal</h5>
          <div class=" d-flex align-items-center justify-content-end w-25 h5">
            &#8377;<input disabled type="number" class="form-control bg-transparent border-0 fw-semibold pt-3 text-dark text-end h5" value="<?php if (isset($selectedProductId)) {

                                                                                                                                              if (isset($_POST['couponSubmit'])) {
                                                                                                                                                echo $productPrice * $selectedQuantity;
                                                                                                                                              } else {
                                                                                                                                                echo $productPrice * $selectedQuantity;
                                                                                                                                              }
                                                                                                                                            } else {

                                                                                                                                              echo $totalCart;
                                                                                                                                            }
                                                                                                                                            ?>" />
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Discount</h5>
        <div class=" d-flex align-items-center justify-content-end w-25 h5">
          &#8377;<input disabled type="number" class="form-control bg-transparent border-0 fw-semibold pt-3 text-dark text-end h5" value="<?php if (isset($selectedProductId)) {

                                                                                                                                            if (isset($_POST['couponSubmit'])) {
                                                                                                                                              echo ($discountpercent * $selectedQuantity) + ((1 - $couponDiscount) * $productPrice);
                                                                                                                                            } else {
                                                                                                                                              echo $discountpercent * $selectedQuantity;
                                                                                                                                            }
                                                                                                                                          } else {
                                                                                                                                            if (isset($_POST['couponSubmit'])) {
                                                                                                                                              echo $disTotal + ($discount * $couponDiscount);
                                                                                                                                            } else {
                                                                                                                                              echo $disTotal;
                                                                                                                                            }
                                                                                                                                          } ?>" />
        </div>
      </div>
      <div class="line w-100 my-3"></div>
      <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <h5 class="fw-semibold">Total Amount</h5>
          <div class=" d-flex align-items-center justify-content-end w-25 h5">
            &#8377;<input type="number" name="totalCost" class="form-control bg-transparent border-0 fw-semibold pt-3 text-dark text-end h5" value="<?php if (isset($selectedProductId)) {

                                                                                                                                                      if (isset($_POST['couponSubmit'])) {
                                                                                                                                                        echo ($productPrice * $selectedQuantity) - ($productPrice * $selectedQuantity * (($couponDiscount)));
                                                                                                                                                      } else {
                                                                                                                                                        echo $productPrice * $selectedQuantity;
                                                                                                                                                      }
                                                                                                                                                    } else {
                                                                                                                                                      if (isset($_POST['couponSubmit'])) {
                                                                                                                                                        echo $discount - (($discount * $couponDiscount));
                                                                                                                                                      } else {
                                                                                                                                                        echo $discount;
                                                                                                                                                      }
                                                                                                                                                    } ?>" />
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-12 g-0 mt-4">
        <div class="row g-0">


          <div class="col-12 col-lg-7 px-0 px-lg-0">
            <input style="border-color: #0f6290" type="text" class="w-100 border-1 px-3 py-2" name="couponvalue" placeholder="Coupon code" value="<?php if (isset($couponCode)) {
                                                                                                                                                    echo $couponCode;
                                                                                                                                                  } ?>" />
          </div>
          <div class="col-12 col-lg-5 px-0 px-lg-0 my-2 my-lg-0">
            <button type="submit" name="couponSubmit" class="bte fw-normal w-100">
              APPLY COUPON
            </button>

          </div>
        </div>
      </div>
      <div class="row place-order mt-5">
        <div style="background-color: #001e2f" class="col-12 text-white px-5 py-4">
          <h4 class="fw-bold">Payment</h4>
          <div class="form-check border-bottom py-3">
            <input class="form-check-input bg-transparent border-2" type="radio" onchange="offConatiner()" name="payment" id="cashOnDelivery" value="COD" checked />
            <label class="form-check-label" for="cashOnDelivery">
              Cash on Delivery
            </label>
          </div>
          <div class="form-check border-bottom py-3">


            <input class="form-check-input bg-transparent border-2" onchange="toggleContainer()" type="radio" name="payment" id="card" value="card" />
            <label class="form-check-label" for="card">Credit Cards

              <img class="img-fluid ms-5" src="./assets/img/master.png" alt="" />

              <img class="img-fluid" src="./assets/img/visa.png" alt="" />
            </label>
          </div>
          <div style="display: none;" id="card-details" class="row card-details g-3 mt-3">
            <div class="col-12">
              <input type="number" class="form-control rounded-0 bg-transparent text-white" <?php if (isset($_POST['payment']) && ! $_POST['payment'] == "COD" &&  $_POST['payment'] == "") {
                                                                                              echo "disabled";
                                                                                            } ?> id="cardNumber" name="cardNumber" placeholder="Enter card number" />
            </div>
            <div class="col-12">
              <input type="text" class="form-control rounded-0 bg-transparent text-white" <?php if (isset($_POST['payment']) && ! $_POST['payment'] == "COD" &&  $_POST['payment'] == "") {
                                                                                            echo "disabled";
                                                                                          } ?> id="nameOnCard" name="nameOnCard" placeholder="Enter name on card" />
            </div>
            <div class="col-12">
              <input type="date" class="form-control rounded-0 bg-transparent text-white" <?php if (isset($_POST['payment']) && ! $_POST['payment'] == "COD" &&  $_POST['payment'] == "") {
                                                                                            echo "disabled";
                                                                                          } ?> id="expiryDate" name="expiryDate" placeholder="MM/YY" />
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" name="placeOrder" class="bg-transparent border-light w-100 py-2 text-white">
                PLACE AN ORDER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  function offConatiner() {
    const container = document.getElementById("card-details");
    // const radio1 = document.getElementById("radio1");
    // const radio2 = document.getElementById("radio2");



    container.style.display = "none";

  }

  function toggleContainer() {
    const container = document.getElementById("card-details");
    // const radio1 = document.getElementById("radio1");
    // const radio2 = document.getElementById("radio2");



    container.style.display = "block";

  }
</script>
<?php
include_once('./footer.php');
?>