<?php
include "./config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='./index.php'</script>";
}

$itemid = $_GET["itemid"];
$id = $_GET["cartID"];
if ($id) {

    $sql = "DELETE FROM cart WHERE cart_id = '$id';";
    include_once('./config.php');
    $result = mysqli_query($config, $sql);


    if ($result) {
        $_SESSION['message'] = "item deleted successfully!";
        header('Location: ./cart.php?msg=' . $_SESSION['message']);
        // exit();
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($config);
        header('Location: cart.php?msg=' . $_SESSION['message']);
        // exit();
    }
}
