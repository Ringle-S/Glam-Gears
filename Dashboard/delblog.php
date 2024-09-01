<?php
include "../config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}

$id = $_GET["blogid"];

$sql = "UPDATE `blogs` SET `status`='inactive' WHERE blog_id = $id";

include_once('../config.php');
$result = mysqli_query($config, $sql);

if ($result) {
    header("Location: dashboard.php?msg=Blog deleted successfully");
} else {
    echo "Failed: " . mysqli_error($config);
}
