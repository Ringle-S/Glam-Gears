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
$setStatus = $status;
$msg = "";
if ($status == "1") {
    $setStatus = 0;
    $msg = "Revoked";
} else {
    $setStatus = 1;
    $msg = "Approved";
}

$sql = "UPDATE `merchants` SET `merchant_status`='$setStatus' WHERE merchant_id = $id";

include_once('../config.php');
$result = mysqli_query($config, $sql);

if ($result) {
    header("Location: dashboard.php?msg=User " . $msg . " successfully");
} else {
    echo "Failed: " . mysqli_error($config);
}
