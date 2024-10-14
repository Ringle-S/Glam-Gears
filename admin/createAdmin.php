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
        <div class="col-12 pb-5">
            <div class="row d-flex justify-content-center vh-100 my-5">
                <h3 style="color: #001e2f;" class=" display-6 fw-medium text-center d-flex align-items-end justify-content-center">Create Admin</h3>
                <form id="merchantForm" method="post" class="col-10 col-md-8 col-xl-4 mt-4">
                    <?php
                    if (isset($_POST['merchantSubmit'])) {
                        function generate_5_digit_number()
                        {
                            return str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
                        }

                        $random_number = generate_5_digit_number();
                        // echo "checking success";
                        $merchantId = $random_number;
                        $merchantName = $_POST["merchant_name"];

                        $merchantEmail = $_POST["merchant_email"];

                        $merchantPhone = $_POST["merchant_phone"];

                        $merchantRepass = $_POST["merchantRepass"];

                        $errors = array();

                        require_once "../config.php";
                        $sql = "SELECT * FROM merchants WHERE merchant_email = '$merchantEmail'";
                        $result = mysqli_query($config, $sql);
                        $rowCount = mysqli_num_rows($result);

                        if ($rowCount > 0) {
                            array_push($errors, "Email already exists!");
                        }
                        if (empty($merchantName) or empty($merchantEmail) or empty($merchantPhone) or empty($merchantRepass)) {
                            array_push($errors, "All fields are required");
                        }
                        if (!filter_var($merchantEmail, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Email is not valid");
                        }
                        if (strlen($merchantRepass) < 8) {
                            array_push($errors, "Password must be at least 8 charactes long");
                        }

                        if (strlen($merchantPhone) < 10) {
                            // echo strlen($merchantPhone);
                            array_push($errors, "Mobile number must be 10 charactes ");
                        }
                        if (count($errors) > 0) {
                            foreach ($errors as  $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        } else {
                            // echo "checking success";
                            $query = mysqli_query($config, "INSERT INTO merchants (merchant_id,merchant_name,business_name,merchant_email,merchant_phone,merchant_pass,user_type,merchant_status,userid) VALUES('$merchantId','$merchantName','Admin','$merchantEmail','$merchantPhone','$merchantRepass','admin','1','$userId')");
                            echo "<script>alert('Your Application was successful');</script>";
                            echo "<script>window.location.href='./dashboard.php'</script>";
                        }
                    }
                    ?>
                    <div class="mb-3">
                        <label for="merchant_name" class="form-label">Admin Name</label>
                        <input style="  border: 1px solid #001e2f; " placeholder="Enter the admin name" type="text" class="form-control rounded-0" id="merchant_name"
                            name="merchant_name" value="<?php if (isset($merchantName)) {
                                                            echo $merchantName;
                                                        } ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="merchant_email"
                            class="form-label"> Email</label>
                        <input style="  border: 1px solid #001e2f; " placeholder="business E-mail" type="email" class="form-control rounded-0" id="merchant_email" name="merchant_email" value="<?php if (isset($merchantEmail)) {
                                                                                                                                                                                                    echo $merchantEmail;
                                                                                                                                                                                                } ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="merchant_phone" class="form-label">Mobile Phone</label>
                        <input style="  border: 1px solid #001e2f; " placeholder="Enter the mobile number" type="number" class="form-control rounded-0" id="merchant_phone" name="merchant_phone" value="<?php if (isset($merchantPhone)) {
                                                                                                                                                                                                                echo $merchantPhone;
                                                                                                                                                                                                            } ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="merchantRepass" class="form-label">Password</label>
                        <input style="  border: 1px solid #001e2f; " placeholder="enter admin password" type="text" class="form-control rounded-0" id="merchantRepass" name="merchantRepass" value="<?php if (isset($merchantPhone)) {
                                                                                                                                                                                                        echo $merchantPhone;
                                                                                                                                                                                                    } ?>" required>
                    </div>
                    <div class="row d-flex justify-content-between mt-5">
                        <div class="col-6 col-md-3">
                            <a href="./dashboard.php" class=" btn btn-dark link-underline link-underline-opacity-0 rounded-0">Back to Home</a>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="submit" name="merchantSubmit" class="bte w-100">Send a Request</button>
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