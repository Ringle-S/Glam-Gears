<?php
include "../config.php";
session_start();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}

$id = $_GET["queryid"];

$sql = "UPDATE `contacts_queries` SET `status`='read' WHERE contact_id = $id";

include_once('../config.php');
$result = mysqli_query($config, $sql);

if ($result) {
    header("Location: dashboard.php");
} else {
    echo "Failed: " . mysqli_error($config);
}
