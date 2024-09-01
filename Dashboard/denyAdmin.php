<?php
include "../config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}

$id = $_GET["merchantid"];
$status = $_GET["status"];


$setStatus = "";
$msg = "";
if ($status == "merchant") {
    $setStatus = "admin";
    $msg = "Switched";
} else {
    $setStatus = "merchant";
    $msg = "Approved";
}

$sql = "UPDATE `merchants` SET `user_type`= '$setStatus' WHERE merchant_id = $id";

include_once('../config.php');
$result = mysqli_query($config, $sql);

if ($result) {
    header("Location: dashboard.php?msg=User " . $msg . " successfully");
} else {
    echo "Failed: " . mysqli_error($config);
}
