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


<!-- blog banner -->
<div class="blogbanner row">
  <div style="
            height: 50vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url('./assets/img/blogban.png');
          " class="col-12 col-lg-6"></div>
  <div style="background-color: #fcfcfc" class="col-12 col-lg-6 d-flex flex-column align-items-center justify-content-center text-center p-5 p-lg-0">
    <div class="w-75">
      <h2 class="fs-1">ELECTRONIC GADGET BLOGS</h2>
      <p>
        Your go-to source for everything electric. Discover the latest
        tech trends, product reviews, and buying guides.Your one-stop shop
        for all things tech. From product recommendations to how-to
        guides, we've got you covered.
      </p>
    </div>
  </div>
</div>
<div class="blog-container row d-flex justify-content-center">
  <div class="blogs-contents col-11   col-xl-7">
    <div class=" d-flex flex-wrap justify-content-center justify-content-xl-start gap-4 ">
      <?php
      include('./config.php');

      $blogSql = "SELECT b.blog_id, b.title, b.blog_desc, b.blog_text, b.img_name, b.created_at, b.user_id FROM blogs b WHERE status ='active' ORDER BY b.created_at DESC LIMIT 6";
      $blogStmt = $config->prepare($blogSql);
      if (!$blogStmt) {
        die('Prepare failed: ' . $config->error);
      }
      $blogStmt->execute();
      $productResult = $blogStmt->get_result();
      if ($productResult->num_rows > 0) {
        while ($productRow = $productResult->fetch_assoc()) {
          // $productRow = $productResult->fetch_assoc();
          // $totalCart = round_to_2dp($productRow['total_price']);
          $userid = $productRow['user_id'];
          require_once "./config.php";
          $sql = "SELECT merchant_name FROM merchants WHERE merchant_id = ?";
          $stmt = $config->prepare($sql);
          $stmt->bind_param("s", $userid);
          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['merchant_name'];
            // $productprice = round($productRow['productPrice'], 2);
            // echo $productprice . "<br>";


      ?>
            <style>
              .blog-img {
                width: 100%;
                height: 300px !important;

              }
            </style>

            <div class="blog-card col-12 col-md-7 col-lg-7 col-xl-5">
              <img height="290px" class="blog-img img-fluid object-fit-cover" src="./uploads/<?php echo $productRow['img_name']; ?>" alt="" />
              <div class="d-flex align-items-center gap-3 py-2">
                <img src="./assets/icon/Avatar.svg" alt="" />
                <p class="mb-0"><?php echo $name; ?></p>
                <div style="width: 50px; background-color: #cac9cf; height: 3px" class="line"></div>
                <p class="mb-0"><?php echo $productRow['created_at']; ?></p>
              </div>
              <h4><?php echo $productRow['title']; ?></h4>
              <p style="height: 45px; overflow: hidden;">
                <?php echo $productRow['blog_desc']; ?>
              </p>
            </div>

      <?php
          }
        }
      } else {
        echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                                      <div class="col-12 text-center">No blogs Yet</div>
                                          </div>';
      }
      ?>
    </div>
  </div>
  <div class="blog-search col-10 col-md-6 col-xl-4 d-flex flex-column align-items-center align-items-xl-start mt-5 mt-lg-0 gap-3">
    <div class="row">
      <div class=" mb-3 col-12">
        <form action="" method="post" class="input-group">
          <span class="input-group-text bg-transparent border-end-0 rounded-0" style="border-color: #001e2f" id="basic-addon1">
            <i class="bi bi-search"></i></span>



          <select style="border-color: #001e2f" name="bloginput" class=" py-2 pe-5 text-start border-start-0 rounded-0 form-select input-group-text bg-transparent" placeholder="search blogs category" id="blogSearch" required>
            <option value="" selected disabled>Select blog category</option>
            <?php
            $blogSql = "SELECT DISTINCT(category) AS category FROM blogs b WHERE status ='active' ORDER BY b.category ASC";
            $blogStmt = $config->prepare($blogSql);
            if (!$blogStmt) {
              die('Prepare failed: ' . $config->error);
            }
            $blogStmt->execute();
            $productResult = $blogStmt->get_result();
            if ($productResult->num_rows > 0) {
              while ($productRow = $productResult->fetch_assoc()) {
            ?>
                <option value="<?php echo $productRow['category'] ?>"><?php echo $productRow['category'] ?></option>
            <?php

              }
            }
            ?>
          </select>
          <button style="background-color: #0f6290; border-color: #001e2f" type="submit" class="border-0  text-white py-2 px-3" name="blogsubmit">Search</button>

        </form>
      </div>
    </div>
    <div class="row">
      <?php
      include 'config.php';

      if (isset($_POST['blogsubmit'])) {
        $search = $_POST['bloginput'];

        $sql = "SELECT b.blog_id, b.title, b.blog_desc, b.blog_text, b.img_name, b.created_at FROM blogs b WHERE b.status = 'active' AND (b.category LIKE ?)";

        $stmt = $config->prepare($sql);
        $search = '%' . $search . '%'; // Add wildcards for LIKE operator
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
      ?>
            <style>
              .search-blog {
                /* width: 100%; */
                height: 101px !important;
              }
            </style>

            <div class="d-flex gap-3 align-items-center my-2">
              <img class="search-blog object-fit-cover" height="101px" src=" ./uploads/<?php echo $row['img_name']; ?>" alt="" />
              <h3 class="fs-4"><?php echo $row['title']; ?></h3>
            </div>
      <?php
          }
        } else {
          echo "No results found.";
        }
        $stmt->close();
        $config->close();
      }
      ?>
    </div>
    <div class="row d-flex flex-column gap-4 mt-5">
      <h2 class="fs-3 fw-medium">POPULAR POST</h2>
      <?php
      include('./config.php');

      $blogSql = "SELECT b.blog_id, b.title, b.blog_desc, b.blog_text, b.img_name, b.created_at, b.user_id FROM blogs b WHERE status ='active' ORDER BY b.created_at ASC LIMIT 1 ";
      $blogStmt = $config->prepare($blogSql);

      $blogStmt->execute();
      $productResult = $blogStmt->get_result();
      if ($productResult->num_rows > 0) {
        while ($productRow = $productResult->fetch_assoc()) {
      ?>
          <div class="d-flex gap-3 align-items-center">
            <img class=" object-fit-contain" height="101" src="./uploads/<?php echo $productRow['img_name']; ?>" alt="" />
            <h3 class="fs-4"><?php echo $productRow['title']; ?></h3>
          </div>
      <?php
        }
      } else {
        echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                                      <div class="col-12 text-center">Your cart is empty</div>
                                          </div>';
      }
      ?>

    </div>
    <div class="row"></div>
  </div>
</div>



<?php
include_once('./footer.php');
?>