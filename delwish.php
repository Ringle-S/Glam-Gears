<?php
include "./config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='./index.php'</script>";
}

$id = $_GET["wishID"];
if ($id) {

    $sql = "DELETE FROM wishlist WHERE wishlist_id = '$id';";
    include_once('./config.php');
    $result = mysqli_query($config, $sql);
}

$itemid = $_GET["itemid"];

if ($result) {
    header("Location: wishlist.php");
} else {
    echo "Failed: " . mysqli_error($config);
}
