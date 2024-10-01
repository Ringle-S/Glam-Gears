<?php
session_start();

include_once('./config.php');
if (!isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
}
$userId = $_SESSION['user'];
$productid = $_GET["productID"];



// $productid = $_POST["productid"];


// echo $userId;

require_once "./config.php";
$sql = "SELECT * FROM cart WHERE `product_id` = '$productid' AND `user_id` = '$userId'";
$result = mysqli_query($config, $sql);
$rowCount = mysqli_num_rows($result);
echo $rowCount;
if (!($rowCount > 0)) {
    require_once "./config.php";
    $query = mysqli_query($config, "INSERT INTO cart (`user_id`,`product_id`) VALUES('$userId','$productid')");
    header("Location: cart.php?productID=" . $productid);
} else {
    header("Location: cart.php?msg='Already Waiting on your Cart");
    // $errorMsg = 'Already Waiting on your Cart';
}
