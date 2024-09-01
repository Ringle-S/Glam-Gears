<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
?>


<div class="forget-container">
    <div style="height:50vh;" class="row d-flex justify-content-center align-items-center">
        <div class="col-3">
            <h2 class="text-center">Change your Password</h2>
            <p class="text-center">Fill the valid password field</p>
            <?php
            if (isset($_POST['otpSubmit'])) {

                $registerPass = $_POST["registerPass"];
                $passwordRepeat = $_POST["passwordRepeat"];
                $verifyemail = $_GET['email'];
                $errors = array();

                if (empty($registerPass) or empty($passwordRepeat)) {
                    array_push($errors, "All fields are required");
                }
                if (strlen($registerPass) < 8) {
                    array_push($errors, "Password must be at least 8 charactes long");
                }
                if ($registerPass !== $passwordRepeat) {
                    array_push($errors, "Password does not match");
                }
                if (count($errors) > 0) {
                    foreach ($errors as  $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    require_once "./config.php";
                    $sql = "UPDATE users SET password = ? WHERE email = ?";
                    $stmt = $config->prepare($sql);
                    $stmt->bind_param("ss", $passwordRepeat, $verifyemail);

                    if ($stmt->execute()) {
                        echo "<script>alert('Password changed successfully');</script>";
                        echo "<script>window.location.href='./login.php'</script>";
                    } else {

                        echo "Error: " . $stmt->error;
                    }

                    exit;
                }
            }

            ?>
            <form action="" method="post" class="d-flex flex-column">
                <div class="row">
                    <div class="input-group mb-3">
                        <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-key"></i></span>
                        <input style="border: 1px solid #0F6290;" type="password" class="form-control bg-light border-start-0 py-2" placeholder="Enter your new password" name="registerPass" value="<?php if (isset($registerPass)) {
                                                                                                                                                                                                            echo $registerPass;
                                                                                                                                                                                                        } ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group mb-3">
                        <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-key"></i></span>
                        <input style="border: 1px solid #0F6290;" type="password" class="form-control bg-light border-start-0 py-2" placeholder="Re enter password" name="passwordRepeat" value="<?php if (isset($passwordRepeat)) {
                                                                                                                                                                                                        echo $passwordRepeat;
                                                                                                                                                                                                    } ?>">
                    </div>
                </div>

                <div class="input-group my-4 d-flex justify-content-center">
                    <button type="submit" class="bte" name="otpSubmit">Verify Email</button>
                </div>


            </form>
        </div>
    </div>

</div>





<?php
include_once('./footer.php');
?>