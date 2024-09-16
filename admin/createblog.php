<?php
session_start();
include_once('../config.php');
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
} else {
    echo "<script>window.location.href='../index.php'</script>";
}
$userId = $_SESSION['user'];






$errors = '';

if (isset($_POST['blogSubmit'])) {
    // Input sanitization and validation
    $blogName = filter_var($_POST['blog_name'], FILTER_SANITIZE_STRING);
    $blogDescription = filter_var($_POST['blog_description'], FILTER_SANITIZE_STRING);
    $blogText = filter_var($_POST['blog_text'], FILTER_SANITIZE_STRING);
    $blogcategory = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    if (isset($_FILES['blogImage']) && $_FILES['blogImage']['error'] == 0) {



        $fileName = $_FILES["blogImage"]["name"];
        $image_name = pathinfo($fileName, PATHINFO_FILENAME);
        $image_extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["blogImage"]["tmp_name"];
        $targetPath = "../uploads/" . $fileName;
        if (in_array($image_extension, $allowedTypes)) {
            if (move_uploaded_file($tempName, $targetPath)) {
                $sql = "INSERT INTO blogs (`user_id`, title, img_name, blog_desc, blog_text,category) VALUES (?, ?, ?, ?, ?,?)";
                include_once('./config.php');
                $stmt = $config->prepare($sql);
                $stmt->bind_param("ssssss", $userId, $blogName, $fileName, $blogDescription, $blogText, $blogcategory);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Blog created successfully!";
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $errors = mysqli_error($config);
                    $_SESSION['message'] = "Error inserting blog data:" . $stmt->error;
                    header('Location: createblog.php');
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
    <section class=" container-fluid row  d-flex justify-content-center">
        <div class="col-12">
            <div class="row d-flex justify-content-center vh-100 my-5">
                <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center">Blog Upload</h3>

                <form class="col-5" action="" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($_GET["message"])) {
                        $msg = $_GET["message"];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">  ' . $message . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    }
                    ?>
                    <div class="mb-3">
                        <label for="blog_name" class="form-label">Blog Title</label>
                        <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_name" placeholder="Blog Name" name="blog_name" value="<?php if (isset($blogName)) {
                                                                                                                                                                                    echo $blogName;
                                                                                                                                                                                } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="blog_description" class="form-label">Blog Description</label>
                        <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_description" placeholder="Blog description" name="blog_description" value="<?php if (isset($blogdescription)) {
                                                                                                                                                                                                        echo $blogdescription;
                                                                                                                                                                                                    } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="blog_text" class="form-label">Blog Text</label>
                        <textarea style="  border: 1px solid #001e2f; " class="form-control rounded-0"
                            id="blog_text" name="blog_text" placeholder="Type the text" required><?php if (isset($blogtext)) {
                                                                                                        echo $blogtext;
                                                                                                    } ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="blog_category" class="form-label">Blog Category</label>
                        <input style="  border: 1px solid #001e2f; " type="text" class="form-control rounded-0" id="blog_description" placeholder="Blog category" name="category" value="<?php if (isset($blogcategory)) {
                                                                                                                                                                                                echo $blogcategory;
                                                                                                                                                                                            } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="blog_image" class="form-label">Blog Image</label>
                        <input style="  border: 1px solid #001e2f; " type="file" class="form-control rounded-0" id="blog_image" name="blogImage" required>
                    </div>

                    <div class="row d-flex justify-content-between mt-5 px-4">
                        <a href="./dashboard.php" class="link-underline link-underline-opacity-0 btn btn-dark col-3 rounded-0"> Cancel</a>
                        <button type="submit" name="blogSubmit" class="bte col-3">Create</button>
                    </div>


                </form>

            </div>
        </div>

    </section>
    <!-- <script src="./img.js"></script> -->
    <script src="./dash.js"></script>
</body>

</html>