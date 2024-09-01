<?php
include "../config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}

$id = $_GET["id"];

$sql = "UPDATE `products` SET `product_status`='inactive' WHERE product_id = $id";

include_once('../config.php');
$result = mysqli_query($config, $sql);

if ($result) {
    header("Location: dashboard.php?msg=Data deleted successfully");
} else {
    echo "Failed: " . mysqli_error($config);
}
