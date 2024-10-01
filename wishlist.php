<?php
session_start();

include_once('./config.php');
$userId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
}

if (isset($_GET['productID'])) {
    $productid = $_GET["productID"];
    $userId = $_SESSION['user'];
    // echo $productid;
    require_once "./config.php";
}


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


<div class="row px-3 px-md-5 my-5">
    <div class="col-12 px-0 px-md-5">
        <div class="row mt-5 px-0 px-md-5 my-5">
            <h3 class="mb-3">Your Wishlist</h3>
            <?php
            require_once "./config.php";
            $sql = " SELECT COUNT(*) AS total_rows FROM wishlist WHERE `user_id` = ?";
            $stmt = $config->prepare($sql);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalRows = $row['total_rows'];
            }
            ?>

            <h5>Total Products (<?php echo $totalRows; ?> item)</h5>
            <?php
            if (isset($_GET["msg"])) {
                $msg = $_GET["msg"];
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            ?>
            <div class="cart-container mt-3 col-12">
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
                    <div class="col-2">
                        <p class="mb-0 text-center">Price</p>
                    </div>

                    <div class="col-2">
                        <p class="mb-0 text-center">Brand</p>
                    </div>
                    <div class="col-2">
                        <p class="mb-0 text-center">ADD TO CART</p>
                    </div>
                </div>
                <?php
                require_once "./config.php";
                $sql = "SELECT * FROM wishlist WHERE `user_id`=$userId;";
                // echo $userId;
                $result = mysqli_query($config, $sql);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $itemid = $row['product_id'];
                        $wishid = $row['wishlist_id'];

                        // echo $itemid;
                        require_once "./config.php";
                        $sql3 = "SELECT * FROM products WHERE `product_id`=$itemid;";
                        $itemresult = mysqli_query($config, $sql3);
                        while ($itemrow = mysqli_fetch_array($itemresult)) {
                ?>
                            <div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-4 fw-medium d-flex gap-4 gap-lg-0 align-items-center">
                                <div class="col-12 col-lg-1">
                                    <a href="./delwish.php?wishID=<?php echo $wishid; ?>&itemid=<?php echo $itemid; ?>">
                                        <i class="bi bi-x-lg fs-3"></i>
                                    </a>
                                </div>
                                <div class="col-8 col-md-5 col-lg-2">
                                    <img class="img-fluid shadow-sm" src="./uploads/<?php echo $itemrow['main_image_name']; ?>" alt="" />
                                </div>
                                <div class="col-10 col-lg-3">
                                    <p class="mb-0 text-center"><?php echo $itemrow['product_name']; ?></p>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                                        <p class="mb-0 fw-semibold fs-5 d-lg-none">PRICE:</p>
                                        <p class="mb-0 text-center">&#8377;<?php echo $itemrow['product_price'] * $itemrow['discount_percent'];
                                                                            ?> </p>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2">
                                    <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                                        <p class="mb-0 fw-semibold fs-5 d-lg-none">Brand:</p>
                                        <p class="mb-0 text-center"><?php echo $itemrow['brand_name']; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="d-flex align-items-center justify-content-between justify-content-lg-center">
                                        <p class="mb-0 fw-semibold fs-5 d-lg-none">Checkout:</p>

                                        <a href="./addtocart.php?productID=<?php echo $itemrow['product_id']; ?>" class="bte text-center link-underline link-underline-opacity-0">
                                            ADD TO CART
                                        </a>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                } else {
                    echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
                    <div class="col-12 text-center">Your Wishlist is empty</div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

</div>



<?php
include_once('./footer.php');
?>