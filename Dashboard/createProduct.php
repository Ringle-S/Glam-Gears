<?php
session_start();
include_once('../config.php');
$userId = $_SESSION['user'];
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}

// echo $userId;

function generate_5_digit_number()
{
    return str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
}

$random_number = generate_5_digit_number();
// echo $random_number;
$errors = '';
if ((isset(($_POST['productSubmit'])) && isset($_FILES['mainImage']) && $_FILES['mainImage']['error'] === UPLOAD_ERR_OK)) {
    $productId = $random_number;
    $productName = $_POST["product_name"];
    $productDescription = $_POST["product_description"];
    $productPrice = $_POST['product_price'];
    $discount = $_POST['discount_percent'];
    $discountPercent = intval($discount) / 100;
    $productQuantity = $_POST['product_quantity'];
    $categoryName = $_POST['category_name'];
    $brandName = $_POST['brand_name'];
    $isFeatured = $_POST['is_featured'];

    $fileName = $_FILES["mainImage"]["name"];
    $image_name = pathinfo($fileName, PATHINFO_FILENAME);
    $image_extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    $tempName = $_FILES["mainImage"]["tmp_name"];
    $targetPath = "../uploads/" . $fileName;
    if (in_array($image_extension, $allowedTypes)) {
        if (move_uploaded_file($tempName, $targetPath)) {
            $sql = "INSERT INTO products (product_id, product_name, product_description, product_price, discount_percent, product_quantity, category_name, brand_name, merchant_id, main_image_name, main_img_extension, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            include_once('./config.php');
            $stmt = $config->prepare($sql);

            // Assuming you have validated the input data and have values for each variable
            $stmt->bind_param("ssssssssssss", $productId, $productName, $productDescription, $productPrice, $discountPercent, $productQuantity, $categoryName, $brandName, $userId, $image_name, $image_extension, $isFeatured);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Product created successfully!";
                header('Location: dashboard.php');
                exit();
            } else {
                $errors = mysqli_error($config);
                $_SESSION['message'] = "Error: " . $stmt->error;
                header('Location: createProduct.php');
                exit();
            }
        } else {
            echo "File is not uploaded";
        }
    } else {
        echo "Your files are not allowed";
    }
    // $filename = basename($_FILES['mainImage']['name']);

    // $image_name = pathinfo($filename, PATHINFO_FILENAME);

    // $image_extension = pathinfo($filename, PATHINFO_EXTENSION);

    // echo "Image Name: " . $image_name . "<br>";
    // echo "Image Extension: " . $image_extension . "<br>";
    // echo "Image directory: " . $target_dir . "<br>";


    // Insert into database

}




// if (isset($_POST['productSubmit'])) {
//     $extension = array('jpeg', 'jpg', 'png', 'gif');
//     foreach ($_FILES['imagefeatured']['tmp_name'] as $key => $value) {
//         $filename =  basename($_FILES['imagefeatured']['name'][$key]);

//         $image_name = pathinfo($filename, PATHINFO_FILENAME);
//         $ext = pathinfo($filename, PATHINFO_EXTENSION);
//         echo $image_name . "<br>";
//         echo $ext;

//         // if (in_array($ext, $extension)) {
//         //     if (!file_exists('images/' . $filename)) {
//         //         move_uploaded_file($filename_tmp, 'images/' . $filename);
//         //         $finalimg = $filename;
//         //     } else {
//         //         $filename = str_replace('.', '-', basename($filename, $ext));
//         //         $newfilename = $filename . time() . "." . $ext;
//         //         move_uploaded_file($filename_tmp, 'images/' . $newfilename);
//         //         $finalimg = $newfilename;
//         //         echo $finalimg;
//         //     }
//         //     // $creattime = date('Y-m-d h:i:s');
//         //insert
//         require_once "../config.php";
//         $insertqry = "INSERT INTO product_images ( `product_id`, `image_name`, `image_extension`) VALUES ('$itemId','$image_name','$ext')";
//         mysqli_query($config, $insertqry);

//         if (mysqli_query($config, $insertqry)) {
//             $_SESSION['message'] = "Product created successfully!";
//             header('Location: ./dashboard.php');
//             exit();
//         } else {
//             $_SESSION['message'] = "Error: " . mysqli_error($config);
//             header('Location: createProduct.php');
//             exit();
//         }
//     }
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Glam Gears</title>
    <link rel="shortcut icon" href="../assets/icon/logo.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
</head>

<body>
    <section class=" container-fluid row  d-flex justify-content-center">
        <div class="col-12">
            <div class="row d-flex justify-content-center vh-100 my-5">
                <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center">Product Upload</h3>
                <form class="col-5" action="" method="post" enctype="multipart/form-data">

                    <?php
                    if (isset($_GET["message"])) {
                        $msg = $_GET["message"];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
                    }
                    ?>
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="product_name" placeholder="Product Name" name="product_name" value="<?php if (isset($productName)) {
                                                                                                                                                                                            echo $productName;
                                                                                                                                                                                        } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_description" class="form-label">Product Description</label>
                        <textarea style="  border: 1px solid #001e2f; " class="form-control rounded-0"
                            id="product_description" name="product_description" placeholder="description" required><?php if (isset($productDescription)) {
                                                                                                                        echo $productDescription;
                                                                                                                    } else {
                                                                                                                        echo "";
                                                                                                                    } ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="product_price"
                            class="form-label">Product Price</label>
                        <input style="  border: 1px solid #001e2f; " type="number" placeholder="Enter the amount" class="form-control rounded-0" id="product_price" name="product_price" value="<?php if (isset($productPrice)) {
                                                                                                                                                                                                    echo $productPrice;
                                                                                                                                                                                                } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_percent"
                            class="form-label">Discount Percent</label>
                        <input style="  border: 1px solid #001e2f; " type="number" placeholder="100.00" pattern="^\d+(?:\.\d{1,2})?$" max=" 100" class="form-control rounded-0" id="discount_percent" name="discount_percent" value="<?php if (isset($discountPercent)) {
                                                                                                                                                                                                                                            echo $discountPercent;
                                                                                                                                                                                                                                        } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_quantity" class="form-label">Product Quantity</label>
                        <input style="  border: 1px solid #001e2f; " type="number" placeholder="100" max="100" class="form-control rounded-0" id="product_quantity" name="product_quantity" value="<?php if (isset($productQuantity)) {
                                                                                                                                                                                                        echo $productQuantity;
                                                                                                                                                                                                    } ?>" required>
                    </div>
                    <div class="mb-3">

                        <label for="category_name" class="form-label">Category Name</label>
                        <input style="  border: 1px solid #001e2f; " type="text" placeholder="Category" class="form-control rounded-0" id="category_name"
                            name="category_name" value="<?php if (isset($categoryName)) {
                                                            echo $categoryName;
                                                        } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand_name"
                            class="form-label">Brand Name</label>
                        <input style="  border: 1px solid #001e2f; " type="text" placeholder="Brand name" class="form-control rounded-0" id="brand_name" name="brand_name" value="<?php if (isset($brandName)) {
                                                                                                                                                                                        echo $brandName;
                                                                                                                                                                                    } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_featured"
                            class="form-label d-block">Allow Featured</label>
                        <input type="checkbox" value="1" <?php (isset($isFeatured) == "1") ? "checked" : ""; ?> class="form-check-input rounded-0" id="yes_featured" name="is_featured">
                        <label class="form-check-label me-4" for="yes_featured">
                            Yes
                        </label>
                        <input type="checkbox" value="0" <?php (isset($isFeatured) == "0") ? "checked" : ""; ?> class="form-check-input rounded-0" id="no_featured" name="is_featured">
                        <label class="form-check-label" for="no_featured">
                            No
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="main_image" class="form-label">Main Image</label>
                        <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="main_image" name="mainImage" required>
                    </div>

                    <div class="row d-flex justify-content-between mt-5 px-4">
                        <a href="./dashboard.php" class="link-underline link-underline-opacity-0 btn btn-dark col-3 rounded-0"> Cancel</a>
                        <button type="submit" name="productSubmit" class="bte col-3">Create</button>
                    </div>


                </form>
            </div>
        </div>

    </section>
    <!-- <script src="./img.js"></script> -->
    <script src="./dash.js"></script>
</body>

</html>