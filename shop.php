<?php
session_start();

include('./config.php');
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
?>


<!-- product container -->
<section class="product-container d-flex row position-relative">
  <div class="product-filter d-flex flex-column gap-3 col-12 col-lg-3 d-none d-lg-block">
    <?php
    require_once "./config.php";
    $sql = " SELECT COUNT(*) AS total_rows FROM products WHERE product_status='active' AND product_quantity>0 AND is_featured=1";
    $stmt = $config->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $totalRows = $row['total_rows'];
    }
    ?>
    <span style="color: #0f6290" class="fw-medium">Showing <?php echo $totalRows; ?> items</span>
    <div class="line my-3"></div>
    <form class="d-flex flex-column gap-2" method="post" action="">
      <div class="list-group d-flex flex-column gap-2 mb-3">
        <h5>Sort by</h5>

        <div class="row d-flex  gap-3">
          <label><input type="radio" name="price" class="common_selector sort" value="ASC"> Price Low - High</label>
          <label><input type="radio" name="price" class="common_selector sort" value="DESC"> Price High - Low</label>
        </div>

      </div>
      <div class="list-group row">
        <div class="col-8">
          <h5>Price Range</h5>
          <input type="hidden" id="hidden_minimum_price" value="0" />
          <input type="hidden" id="hidden_maximum_price" value="50000" />
          <p id="price_show">100 - 50000</p>
          <div id="price_range" class=""></div>
        </div>
      </div>

      <div class="list-group d-flex flex-column gap-2 mt-3">
        <h4>Categories</h4>
        <?php
        include_once('./config.php');
        $query = "SELECT DISTINCT(category_name) FROM products WHERE product_status = 'active' ORDER BY category_name DESC";
        $stmt = $config->prepare($query);
        if (!$stmt) {
          die('Prepare failed: ' . $config->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        // echo  $result;
        if (!$result) {
          die('Prepare failed: ' . $config->error);
        }

        $categorys = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($categorys as $category) {
        ?>
          <div class="row d-flex  gap-3">
            <label><input type="checkbox" class="common_selector category" value="<?php echo $category['category_name']; ?>"> <?php echo $category['category_name']; ?></label>
          </div>
        <?php
        }

        ?>
      </div>

      <div class="list-group d-flex flex-column gap-2 mt-3">
        <h4>Brands</h4>
        <?php
        $query = "SELECT DISTINCT(brand_name) FROM products WHERE product_status = 'active' ORDER BY brand_name DESC";
        $stmt = $config->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $brands = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($brands as $brand) {
        ?>
          <div class="row d-flex  gap-3">
            <label><input type="checkbox" class="common_selector brand" value="<?php echo $brand['brand_name']; ?>"> <?php echo $brand['brand_name']; ?> </label>
          </div>
        <?php
        }
        ?>
      </div>
    </form>
  </div>
  </div>
  <div class="product-card col-12 col-lg-9 position-relative">
    <div class="row d-flex justify-content-end mb-3 ">
      <div id="filterBtn" class="fliter col-2 d-flex align-items-center gap-3 me-5 d-lg-none">
        <img src="./assets/icon/Filters.png" alt="" />
        <span>FILTER</span>
      </div>

    </div>
    <span style="color: #0f6290" class="fw-medium d-lg-none">Showing <?php echo $totalRows; ?> items</span>
    <div class="row filter_data g-5">

    </div>

  </div>
  <!-- mob filter -->
  <div class="mob-filter bg-light position-absolute d-none shadow-lg flex-column top-0 w-75 w-md-50  p-5 left-0">
    <i id="fliterClose" class="bi bi-x-lg fs-2 align-self-end"></i>

    <form class="d-flex flex-column gap-2" method="post" action="">
      <div class="list-group d-flex flex-column gap-2 mb-3">
        <h4>Sort by</h4>

        <div class="row d-flex  gap-3">
          <label><input type="radio" name="price" class="common_selector sort" value="ASC"> Price Low - High</label>
          <label><input type="radio" name="price" class="common_selector sort" value="DESC"> Price High - LOW</label>
        </div>

      </div>
      <div class="list-group">
        <h5>Price Range</h5>
        <input type="hidden" id="hidden_minimum_price" value="0" />
        <input type="hidden" id="hidden_maximum_price" value="50000" />
        <p id="price_show">100 - 50000</p>
        <div id="price_range"></div>
      </div>

      <div class="list-group d-flex flex-column gap-2 mt-3">
        <h4>Categories</h4>
        <?php
        include_once('./config.php');
        $query = "SELECT DISTINCT(category_name) FROM products WHERE product_status = 'active' ORDER BY category_name DESC";
        $stmt = $config->prepare($query);
        if (!$stmt) {
          die('Prepare failed: ' . $config->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        // echo  $result;
        if (!$result) {
          die('Prepare failed: ' . $config->error);
        }

        $categorys = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($categorys as $category) {
        ?>
          <div class="row d-flex  gap-3">
            <label><input type="checkbox" class="common_selector category" value="<?php echo $category['category_name']; ?>"> <?php echo $category['category_name']; ?></label>
          </div>
        <?php
        }

        ?>
      </div>

      <div class="list-group d-flex flex-column gap-2 mt-3">
        <h4>Brands</h4>
        <?php
        $query = "SELECT DISTINCT(brand_name) FROM products WHERE product_status = 'active' ORDER BY brand_name DESC";
        $stmt = $config->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $brands = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($brands as $brand) {
        ?>
          <div class="row d-flex  gap-3">
            <label><input type="checkbox" class="common_selector brand" value="<?php echo $brand['brand_name']; ?>"> <?php echo $brand['brand_name']; ?> </label>
          </div>
        <?php
        }
        ?>
      </div>

    </form>

  </div>
</section>


<style>
  #loading {
    text-align: center;
    background: url('loader.gif') no-repeat center;
    height: 150px;
  }
</style>
<script>
  $(document).ready(function() {

    filter_data();

    function filter_data() {
      $('.filter_data').html('<div id="loading" style="" ></div>');
      var action = 'fetch_data';
      var minimum_price = $('#hidden_minimum_price').val();
      var maximum_price = $('#hidden_maximum_price').val();
      var brand = get_filter('brand');
      var sort = get_sorter('sort');
      // console.log(brand);
      // console.log(sort);

      var category = get_filter('category');
      $.ajax({
        url: "fetch_data.php",
        method: "POST",
        data: {
          action: action,
          minimum_price: minimum_price,
          maximum_price: maximum_price,
          brand_name: brand,
          category_name: category,
          sort: sort,
        },
        success: function(data) {
          $('.filter_data').html(data);
        }
      });
    }

    function get_filter(class_name) {
      var filter = [];
      $('.' + class_name + ':checked').each(function() {
        filter.push($(this).val());
      });
      return filter;
    }

    function get_sorter(class_name) {
      var filter = '';

      // filter = $('.' + class_name + ':selected').val();
      filter = ($('.' + class_name + ':checked').val());

      // console.log(filter);

      return filter;
    }
    $('.common_selector').click(function() {
      filter_data();
    });

    $('#price_range').slider({
      range: true,
      min: 100,
      max: 50000,
      values: [100, 50000],
      step: 50,
      stop: function(event, ui) {
        $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
        $('#hidden_minimum_price').val(ui.values[0]);
        $('#hidden_maximum_price').val(ui.values[1]);
        filter_data();
      }
    });

  });
</script>

<?php
include_once('./footer.php');
?>