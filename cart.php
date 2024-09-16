<?php
session_start();


include_once('./config.php');
$userId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
  $userId = $_SESSION['user'];
  header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
}

// $quantitys = array();
// if (isset($_POST['updateCart'])) {

//   $quantitys[] = $_POST['quantity'];
//   // print_r($quantitys) . "<br>";
//   $productSql = "SELECT cart.cart_id AS cartId FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
//   $productStmt = $config->prepare($productSql);
//   $productStmt->bind_param("i", $userId);
//   $productStmt->execute();
//   $productResult = $productStmt->get_result();

//   if ($productResult->num_rows > 0) {
//     while ($productRow = $productResult->fetch_assoc()) {
//       // $totalCart = round_to_2dp($productRow['total_price']);
//       $cartId = $productRow['cartId'];
//     }
//     // echo $cartId . "<br>";
//   }
//   include('./config.php');
//   // foreach ($quantitys as $quantity) {
//   //   $productSql = "UPDATE cart SET `quantity`='$quantity' WHERE `cart_id`=?";
//   //   $productStmt = $config->prepare($productSql);
//   //   $productStmt->bind_param("i", $userId);
//   //   $productStmt->execute();
//   // }
// }

?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
?>

<div class="cart-items">
  <?php
  if (isset($_GET["message"])) {
    $msg = $_GET["message"];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                 ' . $message . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
  }
  ?>
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
  <div class="row">
    <?php
    require_once "./config.php";
    $sql = " SELECT COUNT(*) AS total_rows FROM cart WHERE `user_id` = ? ";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $totalRows = $row['total_rows'];
    }
    ?>
    <h5>Cart (<?php echo $totalRows; ?> item)</h5>
    <div class="cart-container mt-3">
      <form action="" method="post">
        <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
          <div class="col-12 col-lg-1">
            <i class="bi bi-trash"></i>
          </div>
          <div class="col-2">
            <p class="mb-0 text-center">Photo</p>
          </div>
          <div class="col-3">
            <p class="mb-0 text-center">Product</p>
          </div>
          <div class="col-1">
            <p class="mb-0 text-center">Price</p>
          </div>
          <div class="col-1">
            <p class="mb-0 text-center">Quantity</p>
          </div>
          <div class="col-2">
            <p class="mb-0 text-center">Discount(%)</p>
          </div>
          <div class="col-2">
            <p class="mb-0 text-center">SubTotal</p>
          </div>

        </div>
        <?php
        include('./config.php');

        $productSql = "SELECT  products.product_id AS productID, cart.cart_id AS cartID, products.main_image_name AS img_name, products.main_img_extension AS img_ext, products.product_name AS productName, products.product_price AS productPrice,products.discount_percent AS discountpercent , cart.quantity AS quantity FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
        $productStmt = $config->prepare($productSql);
        $productStmt->bind_param("i", $userId);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        if ($productResult->num_rows > 0) {
          while ($productRow = $productResult->fetch_assoc()) {
            // $productRow = $productResult->fetch_assoc();
            // $totalCart = round_to_2dp($productRow['total_price']);

            // $productprice = round($productRow['productPrice'], 2);
            // echo $productprice . "<br>";


        ?>

            <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
              <div class="col-12 col-lg-1">
                <a href="./delcart.php?cartID=<?php echo $productRow['cartID']; ?>">
                  <i class="bi bi-x-lg fs-3"></i>
                </a>
              </div>
              <div class="col-12 col-lg-2">
                <img class="img-fluid shadow-sm" src="./uploads/<?php echo $productRow['img_name'] . '.' . $productRow['img_ext']; ?>" alt="" />
              </div>
              <div class="col-10 col-lg-3">
                <p class="mb-0 text-center"><?php echo $productRow['productName']; ?></p>
              </div>
              <div class="col-12 col-lg-1">
                <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                  <p class="mb-0 d-lg-none">PRICE:</p>
                  <p class="mb-0 text-center">&#8377;<?php echo $productRow['productPrice'];
                                                      ?> </p>
                </div>
              </div>
              <div class="col-12 col-lg-1">
                <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                  <p class="mb-0 d-lg-none">QUANTITY:</p>
                  <div style="border: 1px solid #0f6290" class="quantityContainer d-flex justify-content-between px-3 py-2">
                    <i class="cartItemDecre bi bi-dash-lg" style="color: #0f6290; cursor: pointer"></i>
                    <input data-product-id="<?php echo $productRow['productID']; ?>" id="count" class="cartCount bg-transparent border-0 w-50 text-center" style="color: #0f6290" type="text" name="quantity[]" value="<?php echo $productRow['quantity']; ?>" />

                    <i class=" cartItemIncre bi bi-plus-lg" style="color: #0f6290; cursor: pointer"></i>
                  </div>
                </div>
              </div>
              <div class=" col-12 col-lg-2">
                <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                  <p class="mb-0 d-lg-none">DISCOUNT:</p>
                  <p class="mb-0 text-center"><?php echo $productRow['discountpercent'] * 100; ?></p>
                </div>
              </div>
              <div class="col-12 col-lg-2">
                <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                  <p class="mb-0 d-lg-none">SUBTOTAL:</p>
                  <p class="mb-0 text-center">&#8377;<?php echo ($productRow['productPrice'] * (1 - $productRow['discountpercent']) * $productRow['quantity']);
                                                      ?></p>
                </div>
              </div>

            </div>

        <?php
          }
        } else {
          echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
          <div class="col-12 text-center">Your cart is empty</div>
          </div>';
        }
        ?>
        <div class="row couponrow mt-5 d-flex justify-content-end">
          <div class="col-12 col-lg-4">
            <button type="submit" name="updatesubmit" class="bte fw-normal w-100">
              UPDATE SUBMIT
            </button>
          </div>
      </form>
    </div>
  </div>



</div>
<div class="totalamount-cart mt-5">
  <div class="row d-flex justify-content-end">
    <div style="background-color: #001e2f" class="amountCard col-lg-4 col-12 text-white p-3 p-md-5">
      <h4>Cart totals</h4>
      <?php
      include('./config.php');

      $productSql = "SELECT SUM(products.product_price*products.discount_percent * cart.quantity) AS total_price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
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
      $productSql = "SELECT SUM(products.product_price* cart.quantity - products.product_price*products.discount_percent * cart.quantity) AS total_price1 FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
      $productStmt = $config->prepare($productSql);
      $productStmt->bind_param("i", $userId);
      $productStmt->execute();
      $productResult = $productStmt->get_result();

      if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        // $totalCart = round_to_2dp($productRow['total_price']);
        $disTotal = round($productRow['total_price1'], 2);
        $discount = $subTotal - $disTotal;
      }

      $productStmt->close();



      // $errorMsg = "";
      // if (isset($_POST['couponSubmit'])) {
      //   $couponCode = $_POST['couponvalue'];
      //   // echo  $couponCode;

      //   require_once "./config.php";
      //   $sql = "SELECT * FROM coupons WHERE coupon_code = ?";
      //   $stmt = $config->prepare($sql);
      //   $stmt->bind_param("s", $couponCode);
      //   $stmt->execute();
      //   $result = $stmt->get_result();
      //   if ($result->num_rows > 0) {
      //     $row = $result->fetch_assoc();
      //     $couponDiscount = $row['coupon_value'];
      //     // echo $couponDiscount;
      //   } else {
      //     $errorMsg = "NO coupon available";
      //   }
      // }

      ?>
      <form action="" method="post">
        <div class="row mt-3">
          <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">Subtotal</p>
            <div class=" d-flex align-items-center w-25">
              &#8377;<input type="number" class="form-control bg-transparent border-0 text-white text-end" value="<?php echo $subTotal; ?>" />
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">Discount</p>
            <div class=" d-flex align-items-center w-25">
              &#8377;<input type="number" class="form-control bg-transparent border-0 text-white text-end" value="<?php echo $totalCart; ?>" />
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">Total Amount</p>
            <div class=" d-flex align-items-center w-25">
              &#8377;<input type="number" class="form-control bg-transparent border-0 text-white text-end" value="<?php echo $disTotal; ?>" />
            </div>
          </div>
        </div>

        <div class="col-12 mt-4 d-flex justify-content-center">


          <?php
          if ($totalCart > 0) {

          ?>
            <a href="./shipping.php" class="border bg-transparent py-2 border-1 border-light text-light link-underline text-center link-underline-opacity-0 w-100">PROCEED TO CHECKOUT</a>
          <?php
          } else {
          ?>
            <button type="button" class="border bg-transparent py-2 border-1 border-light text-light link-underline text-center link-underline-opacity-0 w-100" onclick="return alert(' Your cart is Empty!!')">PROCEED TO CHECKOUT</button>
          <?php
          }
          ?>

        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

<?php
include_once('./footer.php');
?>