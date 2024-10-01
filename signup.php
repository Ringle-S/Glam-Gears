<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
?>


<div style="padding: 100px 0;" id=" signupModal" class="row signup d-flex mt-4 px-lg-5 justify-content-center">
    <div class="col-10 col-md-8 col-xl-4">
        <h2 class="text-center">CREATE YOUR ACCOUNT</h2>
        <?php

        if (isset($_POST['registerSubmit'])) {


            $fullName = $_POST["regiterName"];
            $email = $_POST["registerEmail"];
            $password = $_POST["registerPass"];

            $passwordRepeat = $_POST["repassword"];


            $errors = array();


            require_once "./config.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($config, $sql);
            $rowCount = mysqli_num_rows($result);

            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }
            if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 charactes long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }
            if (count($errors) > 0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {

                $query = mysqli_query($config, "INSERT INTO users (name,email,password) VALUES('$fullName','$email','$passwordRepeat')");
                echo "<script>alert('Registration successful');</script>";
                echo "<script>window.location.href='./login.php'</script>";
                exit;
            }
        };
        ?>

        <form action="" method="post" class="px-lg-5 mt-5">
            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0f6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-person"></i></span>
                    <input style="border: 1px solid #0F6290;" type="text" class="form-control bg-light border-start-0 py-2" placeholder="Full Name" name="regiterName" value="<?php if (isset($fullName)) {
                                                                                                                                                                                    echo $fullName;
                                                                                                                                                                                } ?>">
                </div>
            </div>

            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                    <input style="border: 1px solid #0F6290;" type="email" class="form-control bg-light border-start-0 py-2" placeholder="E-mail" name="registerEmail" value="<?php if (isset($email)) {
                                                                                                                                                                                    echo $email;
                                                                                                                                                                                } ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-key"></i></span>
                    <input style="border: 1px solid #0F6290;" type="password" class="form-control bg-light border-start-0 py-2" placeholder="Password" name="registerPass" value="<?php if (isset($password)) {
                                                                                                                                                                                        echo $password;
                                                                                                                                                                                    } ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-key"></i></span>
                    <input style="border: 1px solid #0F6290;" type="password" class="form-control bg-light border-start-0 py-2" placeholder="Re password" name="repassword" value="<?php if (isset($passwordRepeat)) {
                                                                                                                                                                                        echo $passwordRepeat;
                                                                                                                                                                                    } ?>">
                </div>
            </div>

            <div class="row d-flex justify-content-center mt-3">
                <div class="col-6 ">
                    <button type="submit" name="registerSubmit" class="bte w-100">CREATE AN ACCOUNT</button>
                </div>
            </div>
        </form>
        <div class="row d-flex align-items-center mt-4 px-5 ">
            <div style="width: 100%; height:2px;" class="col bg-secondary"></div>

        </div>
        <div class="row mt-3">
            <p class="text-center">Already have an account? <a style="color: #0F6290;" id="regRedirect" href="./login.php" class=" fw-semibold link-underline link-underline-opacity-0">Log in</a></p>
        </div>
    </div>

</div>


<?php
include_once('./footer.php');
?>