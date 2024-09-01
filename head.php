<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Glam Gear/<?php
                        $pagename = $_SERVER['PHP_SELF'];
                        if (basename($pagename) == 'index.php') {
                            echo 'Home';
                        } elseif (basename($pagename) == 'shop.php') {
                            echo 'Shop';
                        } elseif (basename($pagename) == 'about.php') {
                            echo 'About';
                        } elseif (basename($pagename) == 'contact.php') {
                            echo 'Contact';
                        } elseif (basename($pagename) == 'blogs.php') {
                            echo 'Blog';
                        } elseif (basename($pagename) == 'login.php') {
                            echo 'Login';
                        } elseif (basename($pagename) == 'orders.php') {
                            echo 'Orders';
                        } elseif (basename($pagename) == 'merchant.php') {
                            echo 'Merchant';
                        } elseif (basename($pagename) == 'cart.php') {
                            echo 'Cart';
                        } elseif (basename($pagename) == 'shipping.php') {
                            echo 'Shipping';
                        } elseif (basename($pagename) == 'showproduct.php') {
                            echo 'ProductDetails';
                        } else {
                            echo '';
                        }
                        ?></title>
    <link rel="shortcut icon" href="./assets/icon/logo.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>