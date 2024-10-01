<?php
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

//fetch_data.php

include('./config.php');

if (isset($_POST["action"])) {
  $query = "SELECT * FROM products WHERE product_status = 'active'";
  if (isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
    $query .= "AND product_price BETWEEN '" . $_POST["minimum_price"] . "' AND '" . $_POST["maximum_price"] . "'";
  }
  if (isset($_POST["brand_name"])) {
    $brand_filter = implode("','", $_POST["brand_name"]);
    $query .= "AND brand_name IN('" . $brand_filter . "')";
  }

  if (isset($_POST["category_name"])) {
    $category_filter = implode("','", $_POST["category_name"]);
    $query .= "AND category_name IN('" . $category_filter . "')";
  }

  if (isset($_POST["sort"])) {
    $sort = $_POST["sort"];

    $query .= " ORDER BY product_price " . $sort . "";
  }
  // echo $query;
  $statement = $config->prepare($query);
  if (!$statement) {
    die('Prepare failed: ' . $config->error);
  }
  $statement->execute();
  $result = $statement->get_result();
  if (!$result) {
    die('Error: ' . $statement->error);
  }
  // print_r($result);
  $fetchResult = $result->fetch_all(MYSQLI_ASSOC);
  $total_row = $result->num_rows;
  $output = '';
  if ($total_row > 0) {
    foreach ($fetchResult as $row) {
      $output .= "
			   <form method='post' class='col-12 col-md-6 col-lg-4'>
                   <input class='d-none' type='text' name='productid' value='" . $row['product_id'] . "'>
                    <a href='./showproduct.php?productID=" . $row['product_id'] . "' class='link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller'>
                  <div class='row'>
                    <img height='330px' class='img-fluid object-fit-contain' src='./uploads/" . $row['main_image_name'] . "' alt='' />
                  </div>
                 <div class='row mt-2'>
                  <p style='height: 35px; overflow: hidden;' class='fw-medium fs-5 text-black'>" . $row['product_name'] . "</p>
                   </div>
                   <div class='row'>
                     <h5 style='color: #0f6290;' class=' fs-3'>&#8377;" . $row['product_price'] * (1 - $row['discount_percent']) . "<del class='text-black ms-3      fs-5'>&#8377;" . $row['product_price'] . "</del></h5>
                   </div>
                   <div class='row'>
                     <p style='height: 50px; overflow: hidden;' class='productDesc text-secondary'>
                       " . $row['product_description'] . "
                     </p>
                   </div>
                 </a>
                 <div class='row'>
                   <button type='submit' name='addcart' class='btn-main-outline text-center'>
                     ADD TO CART
                   </button>
                 </div>
               </form>
		       ";
    }
  } else {
    $output = '<h3>No Data Found</h3>';
  }
  echo $output;
}
