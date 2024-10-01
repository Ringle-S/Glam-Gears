<?php
if (isset($_POST["otpSubmit"])) {
    $verifyotp = $_POST["verifyotp"];

    $verifyemail = $_GET['email'];
    $errorMsg = '';

    require_once "./config.php";

    $sql = "SELECT * FROM users WHERE otp = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $verifyotp);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header("Location: changepassword.php?email=" . $verifyemail);
    } else {
        $errorMsg = 'Wrong OTP';
    }
}
?>



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
        <div class="col-10 col-md-8 col-xl-4">
            <h2 class="text-center">OTP Verification</h2>
            <p class="text-center">Please enter your one time password which is send it to your email</p>
            <?php
            if (isset($_GET["msg"])) {
                $msg = $_GET["msg"];
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            ?>
            <?php
            if (!empty($errorMsg)) {
                echo "<div class='alert alert-danger'>$errorMsg</div>";
            }
            ?>
            <form action="" method="post" class="d-flex flex-column">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"></span>
                    <input style="border: 1px solid #0F6290;" type="number" class="form-control bg-light border-start-0 py-2" placeholder="Enter your OTP" name="verifyotp" value="<?php if (isset($verifyotp)) {
                                                                                                                                                                                        echo $verifyotp;
                                                                                                                                                                                    } ?>">
                </div>

                <div class="input-group my-4 d-flex justify-content-center">
                    <button type="submit" class="bte align-self-center" name="otpSubmit">OTP Verify</button>
                </div>


            </form>
        </div>
    </div>

</div>







<?php
include_once('./footer.php');
?>