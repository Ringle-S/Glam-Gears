<?php
session_start();
include_once('../config.php');
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}


$id = $_GET["id"];
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];


    require_once "../config.php";
    $sql = "SELECT * FROM products WHERE  product_id = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $productId = $row["product_id"];
        $productName = $row["product_name"];
        $productDescription = $row["product_description"];
        $productPrice = $row['product_price'];
        $discount = $row['discount_percent'];
        $discountPercent = $discount * 100;
        $productQuantity = $row['product_quantity'];
        $categoryName = $row['category_name'];
        $brandName = $row['brand_name'];
        $isFeatured = $row['is_featured'];
        // echo $isFeatured;
        // echo "<script>alert($isFeatured)</script>";
        $imgName = $row['main_image_name'];
        $imgExt = $row['main_img_extension'];
    }



    // update product into DB

    $errors = '';
    if (isset($_POST['updateProduct'])) {

        $productName = $_POST["product_name"];
        $productDescription = $_POST["product_description"];
        $productPrice = $_POST['product_price'];
        $discount = $_POST['discount_percent'];
        $discountPercent = intval($discount) / 100;
        $productQuantity = $_POST['product_quantity'];
        $categoryName = $_POST['category_name'];
        $brandName = $_POST['brand_name'];
        $isFeatured = $_POST['is_featured'];

        // $target_dir = "C:\xampp\htdocs\GlamGears\assets\products";
        $fileName = $_FILES["mainImage"]["name"];
        $image_name = pathinfo($fileName, PATHINFO_FILENAME);
        $image_extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["mainImage"]["tmp_name"];
        $targetPath = "../uploads/" . $fileName;
        if (in_array($image_extension, $allowedTypes)) {
            if (move_uploaded_file($tempName, $targetPath)) {
                $sql = "UPDATE `products` SET `product_name`='$productName',`product_description`='$productDescription',`product_price`='$productPrice',`discount_percent`='$discountPercent',`product_quantity`='$productQuantity',`category_name`='$categoryName',`brand_name`='$brandName',`main_image_name`='$image_name',`main_img_extension`='$image_extension',`is_featured`='$isFeatured' WHERE `product_id` = $itemId";
                include_once('./config.php');
                $stmt = $config->prepare($sql);

                // Assuming you have validated the input data and have values for each variable

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Product Updated successfully!";
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $errors = mysqli_error($config);
                    $_SESSION['message'] = "Error: " . $stmt->error;
                    header('Location: editProduct.php');
                    exit();
                }
            } else {
                echo "File is not uploaded";
            }
        } else {
            echo "Your files are not allowed";
        }


        // // Insert into database





    }



    // image featured
    if (isset($_POST['productImgSubmit'])) {


        foreach ($_FILES["imagefeatured"]["tmp_name"] as $key => $tmp_name) {
            $fileName = $_FILES["imagefeatured"]["name"][$key];
            $image_name = pathinfo($fileName, PATHINFO_FILENAME);
            $image_extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            $tempName = $_FILES["imagefeatured"]["tmp_name"][$key];
            $targetPath = "../uploads/" . $fileName;
            // Check if the file uploaded successfully
            if (in_array($image_extension, $allowedTypes)) {
                if (move_uploaded_file($tempName, $targetPath)) {
                    include_once('./config.php');
                    $stmt = $config->prepare("INSERT INTO product_images (product_id,img_name,img_extension) VALUES (?,?,?)");
                    $stmt->bind_param("sss", $itemId, $image_name, $image_extension);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Image uploaded successfully!";
                        header('Location: dashboard.php');
                        exit();
                    } else {
                        $errors = mysqli_error($config);
                        $_SESSION['message'] = "Error inserting Image upload :" . $stmt->error;
                        header('Location: editProduct.php');
                        exit();
                    }
                } else {
                    echo "File is not uploaded";
                }
            } else {
                echo "Your files are not allowed";
            }
        }
        // $finalimg = '';
        // if (in_array($ext, $extension)) {
        //     if (!file_exists('images/' . $filename)) {
        //         move_uploaded_file($filename_tmp, 'images/' . $filename);
        //         $finalimg = $filename;
        //     } else {
        //         $filename = str_replace('.', '-', basename($filename, $ext));
        //         $newfilename = $filename . time() . "." . $ext;
        //         move_uploaded_file($filename_tmp, 'images/' . $newfilename);
        //         $finalimg = $newfilename;
        //     }
        //     $creattime = date('Y-m-d h:i:s');
        //     //insert
        //     $insertqry = "INSERT INTO `multiple-images`( `image_name`, `image_createtime`) VALUES ('$finalimg','$creattime')";
        //     mysqli_query($con, $insertqry);

        //     header('Location: index.php');
        // } else {
        //     //display error
        // }
    }

    // if (isset($_POST['productImgSubmit'])) {
    //     // Check if the 'imagefeatured' array is set and not empty

    //     // echo $_FILES['imagefeatured']['name'];
    //     // $fileCount = count($_FILES['imagefeatured']['name']);
    //     foreach ($_FILES['imagefeatured']['tmp_name'] as $key => $tmp_name) {
    //         $extension = array('jpeg', 'jpg', 'png', 'gif');
    //         echo $_FILES['imagefeatured']['name'];

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
    //         // require_once "../config.php";
    //         // $insertqry = "INSERT INTO product_images ( `product_id`, `image_name`, `image_extension`) VALUES ('$itemId','$image_name','$ext')";
    //         // if (mysqli_query($config, $query)) {
    //         //     $_SESSION['message'] = "Product created successfully!";
    //         //     header('Location: ./dashboard.php');
    //         //     exit();
    //         // } else {
    //         //     $_SESSION['message'] = "Error: " . mysqli_error($config);
    //         //     header('Location: editProduct.php');
    //         //     exit();
    //         // }
    //     }
    // }
}



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
    <section class=" container-fluid row d-flex justify-content-center">
        <div class="col-5">
            <div class="row d-flex justify-content-center vh-100 my-5">
                <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center">Product Update</h3>
                <form class="col-12" action="" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($_GET["message"])) {
                        $msg = $_GET["message"];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                 ' . $message . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
                    }
                    ?>
                    <div class="my-3 d-flex flex-column align-items-center">
                        <label for="blog_name" class="form-label text-center row ms-2">Old Image</label>
                        <img width="200px" height="150px" class=" shadow-sm" src="../uploads/<?php echo  $imgName . '.' . $imgExt; ?>" alt="">
                    </div>
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
                        <input type="checkbox" value="1" <?php if ($isFeatured === "1") {
                                                                echo "checked";
                                                            }  ?> class="form-check-input rounded-0" id="yes_featured" name="is_featured">
                        <label class="form-check-label me-4" for="yes_featured">
                            Yes
                        </label>
                        <input type="checkbox" value="0" <?php if ($isFeatured === "0") {
                                                                echo "checked";
                                                            } ?> class="form-check-input rounded-0" id="no_featured" name="is_featured">
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
                        <button type="submit" name="updateProduct" class="bte col-3">Update</button>
                    </div>


                </form>
            </div>
        </div>
        <div class="col-5">
            <div class="row d-flex justify-content-center vh-100 my-5 px-5">
                <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center">Featured Images Upload</h3>
                <form class="col-12 px-5 d-flex flex-column" action="" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Images</label>
                        <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" multiple id="featured_image" name="imagefeatured[]" required>
                    </div>
                    <div class="row d-flex justify-content-center mt-3 px-4">

                        <button type="submit" name="productImgSubmit" class="bte col-3">Upload</button>
                    </div>


                </form>
            </div>
        </div>
    </section>

    <!-- <script src="./img.js"></script> -->
    <script src="./dash.js"></script>
</body>

</html>