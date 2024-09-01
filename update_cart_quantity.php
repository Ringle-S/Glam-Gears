<?php
session_start();


include_once('./config.php');
$userId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    header("Location: login.php?msg='You haven't logged in yet'&productID=" . $_GET['productID']);
}



// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glamgears";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
print_r($data);
$productId = $data['productId'];
$quantity = $data['quantity'];

// Update the cart quantity in the database
$sql = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?"; // Assuming you have a user_id column
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $quantity, $productId, $userId); // Replace $userId with the actual user ID
$stmt->execute();

// Check for errors
if ($stmt->error) {
    echo json_encode(['success' => false, 'message' => 'Error updating cart quantity']);
} else {
    echo json_encode(['success' => true, 'message' => 'Cart quantity updated successfully']);
}

$stmt->close();
$conn->close();
