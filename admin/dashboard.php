<?php
session_start();

include_once('../config.php');
$userId = $_SESSION['user'];
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}


if (!empty($userId)) {
    // username and email 
    require_once "../config.php";
    $sql = "SELECT * FROM merchants WHERE  merchant_id = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $merchantId = $row['merchant_id'];
        $merchantName = $row['merchant_name'];
        $businessName = $row['business_name'];
        $merchantMail = $row['merchant_email'];
        $CreatedDate = $row['date_created'];
        $merchantPhone = $row['merchant_phone'];
        // $merchantPhone = $row['merchant_phone'];
        // $merchantId = $row['merchant_id'];
        // echo $merchantPhone;
        if (!$merchantId) {
            echo "<script>window.location.href='../index.php'</script>";
        };
    } else {
        echo "<script>window.location.href='../index.php'</script>";
    }
}

$errorMsg = '';
if (isset($_POST["updateProfile"])) {
    $merchantName = $_POST['merchantName'];
    $businessName = $_POST['businessName'];
    $merchantEmail = $_POST['merchantEmail'];
    $merchantPhone = $_POST['merchantPhone'];

    $sql = "UPDATE `merchants` SET `merchant_name`='$merchantName',`business_name`='$businessName',`merchant_email`='$merchantEmail',`merchant_phone`='$merchantPhone',`date_updated` = NOW() WHERE `merchant_id` = $userId";

    include_once('../config.php');
    $result = mysqli_query($config, $sql);

    if ($result) {

        $errorMsg = 'Profile Updated successFully';
    } else {
        echo "Failed: " . mysqli_error($config);
    }
}

if (!empty($userId)) {


    require_once "../config.php";
    $sql = " SELECT COUNT(*) AS total_rows FROM products WHERE  merchant_id = ? AND product_status='active'";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalRows = $row['total_rows'];
    }

    // username and email 
    require_once "../config.php";
    $sql = "SELECT * FROM products WHERE  merchant_id = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $userId);
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

        $imgName = $row['main_image_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Glam Gears</title>
    <link rel="shortcut icon" href="../assets/icon/logo.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
    <style>
        .activeDash {
            background-color: #0f6290;
            color: aliceblue !important;
        }
    </style>
</head>

<body>
    <section style="background-color: #F5F5F5;" class="container-fluid   vh-100 ">
        <div class="row h-100 ">
            <div class="col-2  h-100 bg-white d-flex flex-column justify-content-between gap-5 align-items-center py-5">

                <div class="row">
                    <a href="">
                        <div class="col-12">
                            <img class="img-fluid" src="../assets/icon/logo.svg" alt="">
                        </div>
                    </a>
                </div>
                <div class="row mt-5">
                    <div class="col-12 d-flex flex-column gap-3 mb-5">
                        <div id="btnDash1" class=" dashBtn activeDash px-3 py-2  row">
                            <button type="button" class=" bg-transparent border-0 text-start fs-4 fw-medium"><i class="me-3  bi bi-house"></i>Home</button>
                        </div>
                        <div id="btnDash2" class=" dashBtn px-3 py-2 row ">
                            <button type="button" class=" bg-transparent border-0 text-start fs-4 fw-medium"><i class="me-3  bi bi-person"></i>Profile</button>
                        </div>
                        <div id="btnDash3" class=" dashBtn px-3 py-2 row">
                            <button type="button" class=" bg-transparent border-0 text-start fs-4 fw-medium"><i class="me-3  bi bi-truck"></i>Orders</button>
                        </div>
                        <div id="btnDash4" class=" dashBtn px-3 py-2 row">
                            <button type="button" class=" bg-transparent border-0 text-start fs-4 fw-medium"><i class="me-3  bi bi-bag-plus"></i>Products</button>
                        </div>
                        <div id="btnDash5" class=" dashBtn px-3 py-2 row">
                            <button type="button" class=" bg-transparent border-0 text-start fs-4 fw-medium"><i class="me-3  bi bi-people"></i>Blogs</button>
                        </div>
                        <?php

                        if (!empty($userId)) {
                            // username and email 
                            require_once "../config.php";
                            $sql = "SELECT * FROM merchants WHERE user_type='admin' AND  merchant_id = ?";
                            $stmt = $config->prepare($sql);
                            $stmt->bind_param("s", $userId);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {

                                echo "  <div id='btnDash6' class=' dashBtn px-3 py-2 row'>
                            <button type='button' class=' bg-transparent border-0 text-start fs-4 fw-medium'><i class='me-3  bi bi-people'></i>Merchants</button>
                            </div>
                            <div id='btnDash7' class=' dashBtn px-3 py-2 row'>
                            <button type='button' class=' bg-transparent border-0 text-start fs-4 fw-medium'><i class='me-3  bi bi-people'></i>Admin</button>
                            </div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="  px-4 py-2 row mb-5">
                    <a href="../logout.php" class="text-dark px-0 link-underline link-underline-opacity-0  fs-4 fw-medium"><i class="me-3  bi bi-box-arrow-in-right"></i>Log out</a>
                </div>
            </div>

            <div class="col-10  px-3">
                <!-- dash Header -->
                <div class="row px-5 mt-5 d-flex align-items-center justify-content-between">
                    <div class="col-7">
                        <h3 class="display-5 fw-semibold">Hello,<?php echo " " . $merchantName;
                                                                ?></h3>
                    </div>
                    <div class=" col-5">
                        <div class="row d-flex justify-content-end gap-3">
                            <div class="col-10 d-flex justify-content-end gap-4">
                                <a href="./createblog.php" id="addProductBtn" style="background-color: #0f6290;" class="link-underline link-underline-opacity-0 border-0 fs-5 fw-medium py-2 px-3 text-white"> BLOG</a>
                                <a href="./createProduct.php" id="addProductBtn" style="background-color: #0f6290;" class="link-underline link-underline-opacity-0 border-0 fs-5 fw-medium py-2 px-3 text-white"> ADD PRODUCT</a>
                            </div>
                            <?php
                            if (!empty($userId)) {
                                // username and email 
                                require_once "../config.php";
                                $sql = "SELECT * FROM merchants WHERE user_type='admin' AND  merchant_id = ?";
                                $stmt = $config->prepare($sql);
                                $stmt->bind_param("s", $userId);
                                $stmt->execute();

                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                            ?>
                                    <div id="notificationBtn" class="col-1 position-relative ">
                                        <?php

                                        $sql = "SELECT count(*) AS totalcontact FROM contacts_queries WHERE `status`='unread'";
                                        $stmt = $config->prepare($sql);
                                        // $stmt->bind_param("i", $userId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        $productIds = array();
                                        while ($row = $result->fetch_assoc()) {
                                            $totalcontact = $row['totalcontact'];
                                        }
                                        ?>
                                        <div style="cursor: pointer;" class=" position-absolute bg-danger rounded-circle px-2 end-0 "><span class="text-light"><?php echo $totalcontact; ?></span></div>

                                        <button type="button" class="notificationBtn  border-0 fs-4 fw-medium text-dark"> <i class="bi bi-bell"></i></button>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Dash Home -->
                <div id="dashHome" style="background-color: #F5F5F5;" class="displayDash px-5 pb-2  h-auto  ">
                    <div class="row">
                        <div class="col-8">
                            <div class="row mt-5">
                                <div class="col-12 bg-white px-5 py-4">
                                    <div class="row">
                                        <h5>Overview</h5>
                                    </div>
                                    <div class="row mt-2">
                                        <?php
                                        include_once('../config.php'); // Replace with your database configuration file

                                        $usertotal = 0;
                                        $sql = "SELECT product_id FROM products WHERE merchant_id = ?";
                                        $stmt = $config->prepare($sql);
                                        $stmt->bind_param("i", $userId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        $productIds = array();
                                        while ($row = $result->fetch_assoc()) {
                                            $productIds[] = $row['product_id'];

                                            // Replace with the actual product ID
                                            foreach ($productIds as $productId) {
                                                $sql = "SELECT COUNT(DISTINCT o.user_id) AS buyer_count FROM orders o INNER JOIN order_items oi ON o.order_id = oi.order_id INNER JOIN products p ON oi.product_id = p.product_id WHERE p.product_id = ? AND p.product_status='active'";

                                                $stmt = $config->prepare($sql);
                                                $stmt->bind_param("i", $productId);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $row = $result->fetch_assoc();

                                                $buyerCount = $row['buyer_count'];

                                                $stmt->close();
                                            }
                                            $usertotal += $buyerCount;
                                        }

                                        include_once('../config.php');

                                        $amount = 0;
                                        $sql = "SELECT ((p.product_price*(1-p.discount_percent))*oi.quantity) AS total_amount FROM order_items oi INNER JOIN products p ON oi.product_id = p.product_id WHERE p.merchant_id = ? AND p.product_status='active'";
                                        $stmt = $config->prepare($sql);
                                        $stmt->bind_param("i", $userId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();


                                        while ($row = $result->fetch_assoc()) {
                                            $amount += $row['total_amount'];
                                        }
                                        ?>
                                        <div style="background-color: #F5F5F5;" class="col-12 p-4">
                                            <div class="row">
                                                <div class="col-6 bg-white d-flex flex-column justify-content-center align-items-center gap-2 py-5">
                                                    <p class="mb-0 fs-4">Customers</p>
                                                    <h5 class="fs-3 fw-medium"><?php echo $usertotal; ?></h5>
                                                </div>
                                                <div class="col-6 d-flex flex-column justify-content-center align-items-center gap-2 py-5">
                                                    <p class="mb-0 fs-4">Income</p>
                                                    <h5 class="fs-3 fw-medium">&#8377;<?php echo number_format($amount, 0); ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <section class="row mt-0">
                                <div class="col-12">
                                    <h5 class="mb-0 mt-4">Your Product</h5>
                                    <div class="row  ">
                                        <div class=" d-flex overflow-x-scroll">
                                            <?php
                                            $sql = "SELECT * FROM products WHERE merchant_id=$userId AND product_status='active' ORDER BY id DESC;";
                                            $result = mysqli_query($config, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <form method="post" class=" col-3 px-2 py-3 mt-0">
                                                    <a href="./editproduct.php?id=<?php echo $row['product_id']; ?>" class="link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller">
                                                        <div class="row">
                                                            <img height="220px" class=" object-fit-cover" src="../uploads/<?php echo $row['main_image_name'] ?>" alt="" />
                                                        </div>
                                                        <div class="row mt-2">
                                                            <p style="height: 35px; overflow: hidden;" class="fw-medium fs-5 text-black"><?php echo $row['product_name']; ?></p>
                                                        </div>

                                                    </a>
                                                    <div class="row px-3">
                                                        <a href='./editproduct.php?id=<?php echo $row['product_id']; ?>' style="border:1px solid #0f6290;" class=" link-underline link-underline-opacity-0 text-center px-5 w-100 py-2">
                                                            EDIT ITEM
                                                        </a>
                                                    </div>
                                                </form>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <!-- <div style="background-color: #F5F5F5;" class="col-4  px-5 py-4 mt-4"> -->
                        <div style="background-color: #F5F5F5;" class="col-4  px-5 py-4 mt-4">

                            <div class="row ">
                                <div class="col-12 bg-white  py-3">
                                    <div class="px-3 d-flex justify-content-between">
                                        <p>Product</p>
                                        <p>Earnings</p>
                                    </div>
                                    <?php
                                    include_once('../config.php');
                                    // echo $userId;
                                    $sql = "SELECT p.main_image_name, p.category_name, p.product_name, SUM(p.product_price * (1 - p.discount_percent)) AS total_price, SUM(oi.quantity) AS total_quantity, SUM(p.product_price * (1 - p.discount_percent) * oi.quantity) AS total_amount FROM order_items oi INNER JOIN products p ON oi.product_id = p.product_id WHERE p.merchant_id = ? AND p.product_status = 'active' GROUP BY p.product_name, p.product_price ORDER BY total_amount DESC;";
                                    // echo $sql . "<br>";

                                    $stmt = $config->prepare($sql);
                                    $stmt->bind_param("i", $userId);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    // $products = array();
                                    // print_r($products);
                                    while ($row = $result->fetch_assoc()) {

                                        // print_r($products);
                                    ?>
                                        <div style="border-bottom: 1px solid #D6DDEE;" class="mx-2 mt-2 row pb-3 ">
                                            <div class="col-3">
                                                <img class="img-fluid" src="../uploads/<?php echo  $row['main_image_name'] ?>" alt="">
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <p class="mb-0 fw-medium fs-6"><?php echo  $row['product_name']; ?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="mb-0 "><?php echo  $row['category_name']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <p class="mb-0 fw-medium fs-6">&#8377; <?php echo  round($row['total_amount']) ?></p>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row px-5 mt-3">
                                        <a href="" style="border:1px solid #0f6290; color:#0f6290;" class=" link-underline link-underline-opacity-0 text-center px-5 w-100 py-2">All Products</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- profile Dash -->
                <div id="dashProfile" style="background-color: #F5F5F5;" class="displayDash col-10 px-5 pb-2 h-auto d-none">
                    <div class="row  mt-5 d-flex align-items-center justify-content-between">
                        <div id="ProfileEditContainer" class="col-12 d-none flex-column gap-2 mt-3 ps-5">

                            <div class="row">
                                <form action="" method="post" class="col-6 bg-white px-5 py-4 d-flex flex-column gap-3">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="merchantId" class="form-label fw-medium fs-5 mb-2 ">Merchant ID</label>
                                            <input type="text" disabled class="form-control py-2 fs-6" value="<?php echo $merchantId; ?>" id="merchantId" name="merchantId" placeholder="Enter merchant name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="merchantName" class="form-label fw-medium fs-5 mb-2 ">Merchant Name</label>
                                            <input type="text" class="form-control py-2 fs-6" value="<?php echo $merchantName; ?>" id="merchantName" name="merchantName" placeholder="Enter merchant name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="businessName" class="form-label fw-medium fs-5 mb-2 ">Business Name</label>
                                            <input type="text" class="form-control py-2 fs-6" value="<?php echo $businessName; ?>" id="businessName" name="businessName"
                                                placeholder="Enter business name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="merchantEmail" class="form-label fw-medium fs-5 mb-2 ">Merchant Email</label>
                                            <input type="email" class="form-control py-2 fs-6" value="<?php echo $merchantMail; ?>" id="merchantEmail" name="merchantEmail" placeholder="Enter merchant email">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="merchantPhone" class="form-label fw-medium fs-5 mb-2 ">Merchant Phone</label>
                                            <input type="tel" class="form-control py-2 fs-6" value="<?php echo $merchantPhone; ?>" id="merchantPhone" name="merchantPhone" placeholder="Enter merchant phone number">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 ">
                                            <button id="editClose" class="btn btn-dark rounded-0 px-5 py-2" type="button">Cancel</button>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <button class="bte" name="updateProfile" type="submit">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="ProfileShowContainer" class="col-12 d-flex flex-column gap-4 mt-3 ps-5">
                            <?php
                            if ($errorMsg) {
                                echo "<div class='alert alert-success col-4'>$errorMsg</div>";
                            }
                            ?>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>ID</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $merchantId; ?></h5>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>Merchant Name</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $merchantName; ?></h5>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>Business Name</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $businessName; ?></h5>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>E-mail id</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $merchantMail; ?></h5>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>Mobile Number</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $merchantPhone; ?></h5>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <h4>Joined Date</h4>
                                </div>
                                <div class="col-3">
                                    <h5 style="background-color: aliceblue;" class="px-4 py-3"><?php echo $CreatedDate; ?></h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-4 d-flex justify-content-center">
                                    <button id="profileEdit" class="bte" type="button">Edit Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- orders dash -->
                <div id="dashOrders" style="background-color: #F5F5F5;" class="displayDash col-12 px-5 pb-2 h-auto d-none">

                    <div class="row mt-5">
                        <?php
                        if (isset($_GET["msg"])) {
                            $msg = $_GET["msg"];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        ?>
                        <?php
                        require_once "../config.php";
                        $sql = " SELECT COUNT(DISTINCT oi.order_item_id) AS order_count, p.product_id FROM order_items oi INNER JOIN products p ON oi.product_id = p.product_id WHERE p.merchant_id = ?  ";
                        $stmt = $config->prepare($sql);
                        $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRows = $row['order_count'];
                        }
                        ?>
                        <h5>Order (<?php echo $totalRows; ?> item)</h5>
                        <div class="cart-container mt-3">
                            <form action="" method="post">
                                <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                                    <div class="col-1">
                                        <p class="mb-0 text-center">Tracking No</p>
                                    </div>
                                    <div class="col-1">
                                        <p class="mb-0 text-center">Name</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="mb-0 text-center">PRODUCT</p>
                                    </div>
                                    <div class="col-1">
                                        <p class="mb-0 text-center">Amount</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="mb-0 text-center">Ordered at</p>
                                    </div>
                                    <div class="col-1">
                                        <p class="mb-0 text-center">Payment </p>
                                    </div>
                                    <div class="col-2">
                                        <p class="mb-0 text-center">Status</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="mb-0 text-center">Confirmation</p>
                                    </div>

                                </div>
                                <?php
                                include('../config.php');

                                $productSql = "SELECT * FROM order_items oi INNER JOIN products p ON oi.product_id = p.product_id WHERE p.merchant_id = ? GROUP BY oi.order_item_id ORDER BY oi.ordered_at DESC";
                                $productStmt = $config->prepare($productSql);
                                $productStmt->bind_param("i", $userId);
                                $productStmt->execute();
                                $productResult = $productStmt->get_result();
                                if ($productResult->num_rows > 0) {
                                    while ($productRow = $productResult->fetch_assoc()) {

                                        $productOrderId = $productRow['order_id'];
                                        // echo $productOrderId . "<br>";
                                        $sql = "SELECT * FROM orders WHERE order_id=$productOrderId ";
                                        $result = mysqli_query($config, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $trackingNo = $row['tracking_no'];
                                            $Fname = $row['fname'];
                                            $lname = $row['lname'];
                                            $email = $row['email'];
                                            $mode = $row['payment_mode'];
                                            // $mode=$row['tracking_no'];




                                ?>

                                            <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                                <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Tracking No:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $trackingNo;  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Name:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $Fname . ' ' . $lname;  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Product:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['product_name'];  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Amount:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo ($productRow['price'] * (1 - $productRow['discount_percent'])) * $productRow['quantity'];  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Ordered at:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['created_at'];  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Payment Mode:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $mode;  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-2 d-flex d-lg-flex justify-content-center align-items-center ">
                                                    <p class="mb-0 text-start d-lg-none">Status:</p>
                                                    <p class="mb-0 fw-medium text-dark ms-2 w-50 ms-lg-0 text-center py-lg-2 <?php if ($productRow['order_status'] == "Completed") {
                                                                                                                                    echo "text-bg-success text-white";
                                                                                                                                } else {
                                                                                                                                    echo "text-bg-warning";
                                                                                                                                };  ?>"><?php echo $productRow['order_status'];  ?></p>
                                                </div>
                                                <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center justify-content-center">
                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <?php if ($productRow['order_status'] == "Completed") {
                                                                echo "<a class='link-underline link-underline-opacity-0 text-white btn btn-danger w-100' href='./denyorder.php?trackno=" . $productRow['order_item_id'] . " '>Deny</a>";
                                                            } else {
                                                                echo "<a class='link-underline link-underline-opacity-0 text-white btn btn-success w-100' href='./confirmorder.php?trackno=" . $productRow['order_item_id'] . " '>Confirm</a>";
                                                            } ?>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>


                                <?php
                                        }
                                    }
                                } else {
                                    echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                                      <div class="col-12 text-center">Your order is empty</div>
                                          </div>';
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- products dash -->
                <div id="dashProducts" style="background-color: #F5F5F5;" class="displayDash col-12 px-5 pb-2 h-auto  d-none">
                    <div class="row mt-5">
                        <h3 class="mb-3">Your products</h3>

                        <?php
                        require_once "../config.php";
                        $sql = " SELECT COUNT(*) AS total_rows FROM products   WHERE `merchant_id` = ? AND `product_status`='active'";
                        $stmt = $config->prepare($sql);
                        $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRows = $row['total_rows'];
                        }
                        ?>
                        <h5>Products (<?php echo $totalRows; ?> item)</h5>
                        <?php
                        if (isset($_GET["msg1"])) {
                            $msg = $_GET["msg1"];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        ?>
                        <div class="cart-container mt-3 col-12">
                            <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                                <div class="col-12 col-lg-1">
                                    <i class="bi bi-trash"></i>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Photo</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Product Id</p>
                                </div>
                                <div class="col-3 overflow-x-hidden">
                                    <p class="mb-0 text-center">Product Name</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Price(&#8377;)</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Offer(%)</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Quantity</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Category</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Brand</p>
                                </div>
                                <div class="col-1">
                                    <p class="mb-0 text-center">Edit</p>
                                </div>
                            </div>
                            <?php
                            require_once "../config.php";
                            $sql = "SELECT * FROM `products` WHERE merchant_id =$userId AND product_status='active' ";
                            $result = mysqli_query($config, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                        <div class="col-12 col-lg-1">
                                            <a href="./deleteProduct.php?id=<?php echo $row['product_id']; ?>" class="link-underline link-underline-opacity-0 text-secondary">
                                                <i class="bi bi-x-lg fs-3"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 col-lg-1">
                                            <img class="img-fluid shadow-sm" src="../uploads/<?php echo $row['main_image_name']; ?>" alt="" />
                                        </div>

                                        <div class="col-10 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row["product_id"];   ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-3">
                                            <p class="mb-0 text-center"><?php echo $row["product_name"]; ?> </p>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row['product_price']; ?></p>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row['discount_percent'] * 100; ?></p>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row['product_quantity']; ?></p>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row['category_name']; ?></p>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <p class="mb-0 text-center"><?php echo $row['brand_name']; ?></p>
                                        </div>
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="./editProduct.php?id=<?php echo $row["product_id"] ?>" class="link-underline link-underline-opacity-0 text-secondary ">
                                                <i class="bi bi-pencil-square fs-3 text-center"></i>
                                            </a>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                                      <div class="col-12 text-center">You have no products</div>
                                          </div>';
                            }
                            ?>
                        </div>

                    </div>

                </div>


                <!-- Blogs dash -->
                <div id="dashBlogs" style="background-color: #F5F5F5;" class="displayDash col-12 px-5 pb-2 h-auto  d-none">
                    <div class="row mt-5">
                        <h3 class="mb-3">Your blogs</h3>
                        <?php
                        require_once "../config.php";
                        $sql = " SELECT COUNT(*) AS total_rows FROM blogs WHERE `user_id` = ? AND `status`='active'";
                        $stmt = $config->prepare($sql);
                        $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRows = $row['total_rows'];
                        }
                        ?>
                        <h5>Blogs (<?php echo $totalRows; ?> item)</h5>
                        <?php
                        if (isset($_GET["msg2"])) {
                            $msg = $_GET["msg2"];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        ?>
                        <div class="cart-container mt-3 col-12">
                            <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                                <div class="col-12 col-lg-2">
                                    <i class="bi bi-trash"></i>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">Blog Image</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">Blog Title</p>
                                </div>

                                <div class="col-3 overflow-x-hidden">
                                    <p class="mb-0 text-center">Blog Description</p>
                                </div>
                                <div class="col-3">
                                    <p class="mb-0 text-center">Edit</p>
                                </div>

                            </div>
                            <?php
                            require_once "../config.php";
                            $sql = "SELECT * FROM `blogs` WHERE user_id =$userId AND status='active' ";
                            $result = mysqli_query($config, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                        <div class="col-12 col-lg-2">
                                            <a href="./delblog.php?blogid=<?php echo $row['blog_id']; ?>" class="link-underline link-underline-opacity-0 text-secondary">
                                                <i class="bi bi-x-lg fs-3"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 col-lg-2">
                                            <img class="img-fluid shadow-sm" src="../uploads/<?php echo $row['img_name'] ?>" alt="" />
                                        </div>

                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["title"];   ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-3">
                                            <p class="mb-0 text-center"><?php echo $row["blog_desc"]; ?> </p>
                                        </div>

                                        <div class="col-3 d-flex justify-content-center">
                                            <a href="./editblog.php?blogid=<?php echo $row["blog_id"] ?>" class="link-underline fs-4 link-underline-opacity-0 text-secondary ">Edit
                                                <i class="bi bi-pencil-square ps-2 fs-3 text-center"></i>
                                            </a>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                                      <div class="col-12 text-center">You have hot written any blog</div>
                                          </div>';
                            }
                            ?>
                        </div>

                    </div>

                </div>


                <!-- MErchants dash -->
                <div id="dashsuperAdmin" style="background-color: #F5F5F5;" class="displayDash col-12 px-5 pb-2 h-auto  d-none">
                    <div class="row mt-5">
                        <h3 class="mb-3">Merchants list</h3>
                        <?php
                        require_once "../config.php";
                        $sql = " SELECT COUNT(*) AS total_rows FROM merchants WHERE merchant_id !=$userId";
                        $stmt = $config->prepare($sql);
                        // $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRows = $row['total_rows'];
                        }
                        ?>
                        <h5> <?php echo $totalRows; ?> Results</h5>
                        <?php
                        if (isset($_GET["msg3"])) {
                            $msg = $_GET["msg3"];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        ?>
                        <div class="cart-container mt-3 col-12">
                            <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                                <div class="col-2">
                                    <p class="mb-0 text-center">MERCHANT ID</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">MERCHANT NAME</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">MERCHANT EMAIL</p>
                                </div>

                                <div class="col-2 overflow-x-hidden">
                                    <p class="mb-0 text-center">MERCHANT MOBILE</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">STATUS</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">CONFIRM</p>
                                </div>

                            </div>
                            <?php
                            require_once "../config.php";
                            $sql = "SELECT * FROM `merchants` WHERE merchant_id !=$userId ORDER BY date_created DESC ";
                            $result = mysqli_query($config, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                        <div class="col-4 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_id"];   ?> </p>
                                        </div>

                                        <div class="col-4 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_name"];   ?> </p>
                                        </div>

                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_email"];   ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_phone"]; ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center <?php if ($row["merchant_status"] == "1") {
                                                                            echo "text-success";
                                                                        } else {
                                                                            echo "text-warning";
                                                                        }; ?>"><?php if ($row["merchant_status"] == "1") {
                                                                                    echo "Approved";
                                                                                } else {
                                                                                    echo "Pending";
                                                                                }; ?> </p>
                                        </div>
                                        <div class="col-2 d-flex justify-content-center">
                                            <a href="./denyuser.php?merchantid=<?php echo $row["merchant_id"] ?>&status=<?php echo $row["merchant_status"] ?>" class=" link-underline fs-6  link-underline-opacity-0 text-white py-2 px-3    <?php if ($row["merchant_status"] == "1") {
                                                                                                                                                                                                                                                    echo "bg-danger";
                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                    echo "bg-success";
                                                                                                                                                                                                                                                }; ?>">
                                                <?php if ($row["merchant_status"] == "1") {
                                                    echo "Revoke";
                                                } else {
                                                    echo "Accept";
                                                }; ?></i>
                                            </a>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo 'no data found';
                            }
                            ?>
                        </div>

                    </div>

                </div>

                <!-- Admin dash -->
                <div id="dashAdmin" style="background-color: #F5F5F5;" class="displayDash col-12 px-5 pb-2 h-auto  d-none">
                    <div class="row mt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="mb-3">Admin list</h3>
                            <a href="./createAdmin.php" style="background-color: #0f6290;" class="link-underline link-underline-opacity-0 border-0 fs-5 fw-medium py-2 px-3 text-white">New Admin</a>
                        </div>
                        <?php
                        require_once "../config.php";
                        $sql = " SELECT COUNT(*) AS total_rows FROM merchants WHERE merchant_id !=$userId AND merchant_status='1'";
                        $stmt = $config->prepare($sql);
                        // $stmt->bind_param("s", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRows = $row['total_rows'];
                        }
                        ?>
                        <h5> <?php echo $totalRows; ?> Results</h5>
                        <?php
                        if (isset($_GET["msg4"])) {
                            $msg = $_GET["msg4"];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        ?>
                        <div class="cart-container mt-3 col-12">
                            <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                                <div class="col-2">
                                    <p class="mb-0 text-center">SUB USER ID</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">SUB USER</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">USER EMAIL</p>
                                </div>

                                <div class="col-2 overflow-x-hidden">
                                    <p class="mb-0 text-center">USER MOBILE</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">USER TYPE</p>
                                </div>
                                <div class="col-2">
                                    <p class="mb-0 text-center">SWITCH</p>
                                </div>

                            </div>
                            <?php
                            require_once "../config.php";
                            $sql = " SELECT * FROM merchants WHERE merchant_status='1'  AND  merchant_id !=$userId  ";
                            $result = mysqli_query($config, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                        <div class="col-4 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_id"];   ?> </p>
                                        </div>

                                        <div class="col-4 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_name"];   ?> </p>
                                        </div>

                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_email"];   ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center"><?php echo $row["merchant_phone"]; ?> </p>
                                        </div>
                                        <div class="col-10 col-lg-2">
                                            <p class="mb-0 text-center <?php if ($row["user_type"] == "merchant") {
                                                                            echo "Merchant";
                                                                        } else {
                                                                            echo "Admin";
                                                                        }; ?>"><?php if ($row["user_type"] == "merchant") {
                                                                                    echo "Merchant";
                                                                                } else {
                                                                                    echo "Admin";
                                                                                }; ?></p>
                                        </div>
                                        <div class="col-2 d-flex justify-content-center">
                                            <a href="./denyAdmin.php?merchantid=<?php echo $row["merchant_id"] ?>&status=<?php echo $row["user_type"] ?>" class=" link-underline fs-6  link-underline-opacity-0 text-white py-2 px-3    <?php if ($row["user_type"] == 'admin') {
                                                                                                                                                                                                                                            echo 'bg-danger';
                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                            echo 'bg-success';
                                                                                                                                                                                                                                        }; ?>">
                                                <?php if ($row["user_type"] == "admin") {
                                                    echo "Revoke";
                                                } else {
                                                    echo "Swith to admin";
                                                }; ?></i>
                                            </a>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo 'no data found';
                            }
                            ?>
                        </div>

                    </div>

                </div>

                <div style="height: 100vh; width:25%; background-color: #F5F5F5;" id="notifyContainer" class="notifyContainer position-absolute top-0 end-0 d-none shadow-lg p-4 overflow-y-scroll">
                    <div class="row">
                        <div class="col-1" id="closeNot" style="cursor:pointer"> <i class="bi bi-x-lg fs-3"></i></div>
                        <p class="mt-4">Contact Queries</p>
                        <?php
                        $sql = "SELECT * FROM contacts_queries WHERE `status`='unread' ";
                        $stmt = $config->prepare($sql);

                        $stmt->execute();

                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $name = $row['contact_name'];
                                $email = $row['contact_email'];
                                $message = $row['contact_message'];
                        ?>
                                <div class=" py-4 bg-body-secondary my-3">

                                    <div class="d-flex align-items-center gap-3 py-2">
                                        <img src="../assets/icon/Avatar.svg" alt="" />
                                        <p class="mb-0 "><?php echo $email ?></p>
                                    </div>
                                    <p class="mt-2"><?php echo $message ?></p>
                                    <div class="row d-flex justify-content-end px-3">
                                        <a href="./read.php?queryid=<?php echo $row["contact_id"] ?>" class="btn btn-success col-4 ">Read<i class="bi bi-check-lg ms-2"></i></a>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <p>No New queries yet</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>


            </div>

    </section>
    <script src="./dash.js"></script>
    <script src="./btn.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const notificationBtn = document.getElementById('notificationBtn');
        const notContainer = document.getElementById("notifyContainer");
        const closeNot = document.getElementById("closeNot");

        closeNot.addEventListener("click", () => {
            notContainer.classList.add('d-none')

        })

        notificationBtn.addEventListener("click", () => {
            notContainer.classList.remove('d-none')

        })
    </script>
</body>

</html>