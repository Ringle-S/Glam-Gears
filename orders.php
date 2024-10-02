<?php
session_start();

include_once('./config.php');
$userId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
    header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
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
        $sql = " SELECT COUNT(*) AS total_rows FROM orders   WHERE `user_id` = ?";
        $stmt = $config->prepare($sql);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalRows = $row['total_rows'];
        }
        ?>
        <h5>Orders (<?php echo $totalRows; ?> item)</h5>
        <div class="cart-container mt-3">
            <form action="" method="post">
                <div style="background-color: #0f6290" class="row text-white p-3 fw-medium d-none d-lg-flex">
                    <div class="col-1">
                        <p class="mb-0 text-center">Tracking No</p>
                    </div>
                    <div class="col-2">
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
                    <div class="col-2">
                        <p class="mb-0 text-center">Payment Mode</p>
                    </div>
                    <div class="col-2">
                        <p class="mb-0 text-center">Status</p>
                    </div>

                </div>
                <?php
                include('./config.php');

                $productSql = "SELECT *, CASE WHEN EXISTS ( SELECT 1 FROM order_items oi WHERE oi.order_id = o.order_id AND oi.order_status <> 'completed' ) THEN FALSE ELSE TRUE END AS all_items_completed FROM orders o JOIN order_items oi ON o.order_id = oi.order_id WHERE o.user_id= ? ORDER BY oi.ordered_at     DESC";
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
                            <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Tracking No:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['tracking_no'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Name:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['fname'] . ' ' . $productRow['lname'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Product:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['product_name'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-1 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Amount:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['price'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Ordered at:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['created_at'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Payment Mode:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center"><?php echo $productRow['payment_mode'];  ?></p>
                            </div>
                            <div class="col-12 col-lg-2 d-flex d-lg-block align-items-center ">
                                <p class="mb-0 text-start d-lg-none">Status:</p>
                                <p class="mb-0 fw-medium text-dark ms-2 ms-lg-0 text-center py-lg-3 <?php if ($productRow['order_status'] == "completed") {
                                                                                                        echo "text-bg-success text-white";
                                                                                                    } else {
                                                                                                        echo "text-bg-warning";
                                                                                                    };  ?>"><?php echo $productRow['order_status'];  ?></p>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo '<div style="border-bottom: 1px solid #0f6290" class="row text-secondary px-3 py-5 fw-medium d-flex gap-4 gap-lg-0 align-items-center ">
          <div class="col-12 text-center">You have not ordered anything yet </div>
          </div>';
                }
                ?>

        </div>
    </div>



</div>


<?php
include_once('./footer.php');
?>