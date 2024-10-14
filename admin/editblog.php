<?php

session_start();
include_once('../config.php');
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}
$userId = $_SESSION['user'];
$id = $_GET["blogid"];





$errors = '';

if (isset($_POST['updateBlog'])) {
    // Input sanitization and validation
    $blogName = filter_var($_POST['blog_name'], FILTER_SANITIZE_STRING);
    $blogDescription = filter_var($_POST['blog_description'], FILTER_SANITIZE_STRING);
    $blogText = filter_var($_POST['blog_text'], FILTER_SANITIZE_STRING);
    $blogcategory = filter_var($_POST['category'], FILTER_SANITIZE_STRING);



    $sql = "UPDATE blogs SET title = ?, blog_desc = ?, blog_text = ?, category = ? WHERE blog_id = ?";
    include_once('./config.php');
    $stmt = $config->prepare($sql);
    $stmt->bind_param("sssss",  $blogName, $blogDescription, $blogText, $blogcategory, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Blog data updated successfully!";
        header('Location: editblog.php?blogid=' . $id);
        exit();
    } else {
        $errors = mysqli_error($config);
        $_SESSION['message'] = "Error updating blog data:" . $stmt->error;
        header('Location: editblog.php?blogid=' . $id);
        exit();
    }
}

if (isset($_POST['updateBlogImg'])) {

    if (isset($_FILES['blogImage']) && $_FILES['blogImage']['error'] == 0) {
        $filename = $_POST['blogImage'];

        $fileName = $_FILES["blogImage"]["name"];
        $image_name = pathinfo($fileName, PATHINFO_FILENAME);
        $image_extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["blogImage"]["tmp_name"];
        $targetPath = "../uploads/" . $fileName;
        if (in_array($image_extension, $allowedTypes)) {
            if (move_uploaded_file($tempName, $targetPath)) {
                $sql = "UPDATE blogs SET img_name = ? WHERE blog_id = ?";
                include_once('./config.php');
                $stmt = $config->prepare($sql);
                $stmt->bind_param("ss", $fileName, $id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Blog Image updated successfully!";
                    header('Location: editblog.php?blogid=' . $id);
                    exit();
                } else {
                    $errors = mysqli_error($config);
                    $_SESSION['message'] = "Error updating blog image :" . $stmt->error;
                    header('Location: editblog.php?blogid=' . $id);
                    exit();
                }
            } else {
                echo "File is not uploaded";
            }
        } else {
            echo "Your files are not allowed";
        }
    } else {
        $errors .= "Error uploading image.";
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
        <div class="row d-flex justify-content-center vh-100 my-5">
            <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center">Blog Update</h3>

            <form class="col-5" action="" method="post" enctype="multipart/form-data">
                <?php
                if (isset($_GET["message"])) {
                    $msg = $_GET["message"];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">  ' . $message . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                ?>
                <?php
                require_once "../config.php";
                $sql = "SELECT * FROM `blogs` WHERE blog_id = $id ";
                $result = mysqli_query($config, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="img-container mb-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <label for="blog_name" class="form-label text-center row ms-2">Old Image</label>
                        <img width="200px" height="150px" src="../uploads/<?php echo $row["img_name"]; ?>" alt="">
                    </div>
                    <div class="mb-3">

                        <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="blog_image" name="blogImage">
                    </div>
                    <button type="submit" name="updateBlogImg" class="bte col-3">Update Image</button>
                </div>

                <div class="mb-3">
                    <label for="blog_name" class="form-label">Blog Title</label>
                    <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_name" placeholder="Blog Name" name="blog_name" value="<?php echo $row["title"]; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="blog_description" class="form-label">Blog Description</label>
                    <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_description" placeholder="Blog description" name="blog_description" value="<?php echo $row["blog_desc"]; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="blog_text" class="form-label">Blog Text</label>
                    <textarea style="  border: 1px solid #001e2f; " class="form-control rounded-0"
                        id="blog_text" name="blog_text" placeholder="" required><?php echo $row["blog_text"]; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="blog_category" class="form-label">Blog Category</label>
                    <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_description" placeholder="Blog category" name="category" value="<?php echo $row["category"]; ?>" required>
                </div>

                <div class="row d-flex justify-content-between mt-5 px-4">
                    <a href="./dashboard.php" class="link-underline link-underline-opacity-0 btn btn-dark col-3 rounded-0"> Cancel</a>
                    <button type="submit" name="updateBlog" class="bte col-3">Update</button>
                </div>


            </form>

        </div>
    </section>

    <!-- <script src="./img.js"></script> -->
    <script src="./dash.js"></script>
</body>

</html>