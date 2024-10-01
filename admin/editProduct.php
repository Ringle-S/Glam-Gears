<?php
session_start();
include_once('../config.php');
$userId = $_SESSION['user'];
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
        // $imgExt = $row['main_img_extension'];
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
                $sql = "UPDATE `products` SET `product_name`='$productName',`product_description`='$productDescription',`product_price`='$productPrice',`discount_percent`='$discountPercent',`product_quantity`='$productQuantity',`category_name`='$categoryName',`brand_name`='$brandName',`main_image_name`='$fileName',`is_featured`='$isFeatured' WHERE `product_id` = $itemId";
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
    if (isset($_POST['productImgSubmit1'])) {

        if (!isset($_FILES['featuredImage1'])) {
            $_SESSION['message'] = "Please select featured images 1.";
            header('Location: editProduct.php');
            exit();
        }
        $fileerr1 = $_FILES["featuredImage1"];
        $file1 = $_FILES["featuredImage1"]["name"];
        $temppicName1 = $_FILES["featuredImage1"]["tmp_name"];



        // echo $file;
        $pic_name1 = pathinfo($file1, PATHINFO_FILENAME);
        $pic_extension1 = pathinfo($file1, PATHINFO_EXTENSION);


        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName1 = $_FILES["featuredImage1"]["tmp_name"];



        $targetPath1 = "../uploads/" . $file1;

        if ($fileerr1["error"] === UPLOAD_ERR_OK) {
            // Check if the file uploaded successfully
            if (in_array($pic_extension1, $allowedTypes)) {
                if (move_uploaded_file($tempName1, $targetPath1)) {
                    include_once('../config.php');
                    $stmt = $config->prepare("UPDATE product_images SET  img_name1=? WHERE product_id=?");
                    $stmt->bind_param("si",  $file1, $id);

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
        } else {
            echo "Error uploading file  : " . $fileerr1["error"], $fileerr2["error"], $fileerr3["error"] . "<br>";
        }
    }
    // image featured
    if (isset($_POST['productImgSubmit2'])) {

        if (!isset($_FILES['featuredImage2'])) {
            $_SESSION['message'] = "Please select featured images 2 ";
            header('Location: editProduct.php');
            exit();
        }


        $fileerr2 = $_FILES["featuredImage2"];
        $file2 = $_FILES["featuredImage2"]["name"];
        $temppicName2 = $_FILES["featuredImage2"]["tmp_name"];




        // echo $file;

        $pic_name2 = pathinfo($file2, PATHINFO_FILENAME);
        $pic_extension2 = pathinfo($file2, PATHINFO_EXTENSION);

        $allowedTypes = array("jpg", "jpeg", "png", "gif");

        $tempName2 = $_FILES["featuredImage2"]["tmp_name"];





        $targetPath2 = "../uploads/" . $file2;

        if ($fileerr2["error"] === UPLOAD_ERR_OK) {
            // Check if the file uploaded successfully
            if (in_array($pic_extension2, $allowedTypes)) {
                if (move_uploaded_file($tempName2, $targetPath2)) {
                    include_once('../config.php');
                    $stmt = $config->prepare("UPDATE product_images SET  img_name2=? WHERE product_id=?");
                    $stmt->bind_param("si",  $file2, $id);

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
        } else {
            echo "Error uploading file  : " .  $fileerr2["error"] . "<br>";
        }
    }


    // image featured3
    if (isset($_POST['productImgSubmit3'])) {

        if (!isset($_FILES['featuredImage3'])) {
            $_SESSION['message'] = "Please select featured images  3.";
            header('Location: editProduct.php');
            exit();
        }


        $fileerr3 = $_FILES["featuredImage3"];
        $file3 = $_FILES["featuredImage3"]["name"];
        $temppicName3 = $_FILES["featuredImage3"]["tmp_name"];


        // echo $file;

        $pic_name3 = pathinfo($file3, PATHINFO_FILENAME);
        $pic_extension3 = pathinfo($file3, PATHINFO_EXTENSION);


        $allowedTypes = array("jpg", "jpeg", "png", "gif");

        $tempName3 = $_FILES["featuredImage3"]["tmp_name"];




        $targetPath3 = "../uploads/" . $file3;
        if ($fileerr3["error"] === UPLOAD_ERR_OK) {
            // Check if the file uploaded successfully
            if (in_array($pic_extension3, $allowedTypes)) {
                if (move_uploaded_file($tempName3, $targetPath3)) {
                    include_once('../config.php');
                    $stmt = $config->prepare("UPDATE product_images SET  img_name3=? WHERE product_id=?");
                    $stmt->bind_param("si",   $file3, $id);

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
        } else {
            echo "Error uploading file  : " .  $fileerr3["error"] . "<br>";
        }
    }
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
                        <img width="200px" height="200px" class=" shadow-sm" src="../uploads/<?php echo  $imgName  ?>" alt="">
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
                <form class="col-12 px-5 d-flex flex-column my-5" action="" method="post" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM product_images WHERE  product_id = ?";
                    $stmt = $config->prepare($sql);
                    $stmt->bind_param("s", $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = mysqli_fetch_array($result)


                    ?>
                    <div class="row">
                        <div class="col-12 mb-2 pe-4 d-flex align-items-center gap-3">
                            <div class="my-3  d-flex flex-column align-items-center">
                                <label for="blog_name" class="form-label text-center row ms-2">Featured Image<?php echo 1; ?></label>
                                <img width="200px" height="200px" class=" shadow-sm" src="../uploads/<?php
                                                                                                        echo  $row['img_name1'];
                                                                                                        ?>" alt="<?php
                                                                                                                    echo  $row['img_name1'];
                                                                                                                    ?>">
                            </div>
                            <div class=" ">
                                <!-- <label for="featuredImage<?php echo $i; ?>" class="form-label text-center row ms-2">Featured Image<?php echo $i; ?></label> -->
                                <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="featuredImage1" name="featuredImage1" required>
                                <div class="row d-flex justify-content-center mt-3 px-4">

                                    <button type="submit" name="productImgSubmit1" class="bte col-3">Upload</button>
                                </div>
                            </div>
                        </div>


                    </div>


                </form>
                <form class="col-12 px-5 d-flex flex-column my-5" action="" method="post" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM product_images WHERE  product_id = ?";
                    $stmt = $config->prepare($sql);
                    $stmt->bind_param("s", $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = mysqli_fetch_array($result)


                    ?>
                    <div class="row">

                        <div class="col-12 mb-2 pe-4 d-flex align-items-center gap-3">
                            <div class="my-3  d-flex flex-column align-items-center">
                                <label for="blog_name" class="form-label text-center row ms-2">Featured Image<?php echo 2; ?></label>
                                <img width="200px" height="200px" class=" shadow-sm" src="../uploads/<?php
                                                                                                        echo  $row['img_name2'];
                                                                                                        ?>" alt="<?php
                                                                                                                    echo  $row['img_name2'];
                                                                                                                    ?>">
                            </div>
                            <div class="">
                                <!-- <label for="featuredImage<?php echo $i; ?>" class="form-label text-center row ms-2">Featured Image<?php echo $i; ?></label> -->
                                <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="featuredImage2" name="featuredImage2" required>
                                <div class="row d-flex justify-content-center mt-3 px-4">

                                    <button type="submit" name="productImgSubmit2" class="bte col-3">Upload</button>
                                </div>
                            </div>
                        </div>


                    </div>


                </form>
                <form class="col-12 px-5 d-flex flex-column my-5" action="" method="post" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM product_images WHERE  product_id = ?";
                    $stmt = $config->prepare($sql);
                    $stmt->bind_param("s", $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = mysqli_fetch_array($result)


                    ?>
                    <div class="row">

                        <div class="col-12 mb-2 pe-4 d-flex align-items-center gap-3">
                            <div class="my-3  d-flex flex-column align-items-center">
                                <label for="blog_name" class="form-label text-center row ms-2">Featured Image3</label>
                                <img width="200px" height="200px" class=" shadow-sm" src="../uploads/<?php
                                                                                                        echo  $row['img_name3'];
                                                                                                        ?>" alt="<?php
                                                                                                                    echo  $row['img_name3'];
                                                                                                                    ?>">
                            </div>
                            <div class=" ">
                                <!-- <label for="featuredImage<?php echo $i; ?>" class="form-label text-center row ms-2">Featured Image<?php echo $i; ?></label> -->
                                <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="featuredImage3" name="featuredImage3" required>
                                <div class="row d-flex justify-content-center mt-3 px-4">

                                    <button type="submit" name="productImgSubmit3" class="bte col-3">Upload</button>
                                </div>
                            </div>
                        </div>

                    </div>


                </form>
            </div>
        </div>
    </section>

    <!-- <script src="./img.js"></script> -->
    <script src="./dash.js"></script>
</body>

</html>