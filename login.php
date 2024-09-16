<?php
if (isset($_POST["logsubmit"])) {
    $logemail = $_POST["logemail"];
    $logpassword = $_POST["logpass"];

    $errorMsg = '';

    require_once "./config.php";

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $logemail);
    $stmt->execute();
    $result = $stmt->get_result();


    if (!empty($logemail) && !empty($logpassword)) {

        if (!filter_var($logemail, FILTER_VALIDATE_EMAIL)) {
            // echo "<div class='alert alert-danger'>Invalid email format </div>";
            $errorMsg = 'Invalid email format';
        } else if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];
            $actualEmail = $row['email'];
            $actualPassword = $row['password'];
            // echo $userId;
            // echo $userId;
            // echo $userId;
            if ($logemail == $actualEmail && $logpassword == $actualPassword) {

                // echo "<div class='alert alert-success'>Login successful</div>";


                session_start();

                $_SESSION['user'] = $userId;
                echo "<script>window.location.href='./index.php'</script>";
            } else {
                // echo "<div class='alert alert-danger'>Incorrect password</div>";
                $errorMsg = 'Incorrect password';
            }
        } else {
            // echo "<div class='alert alert-danger'>Email not found</div>";
            $errorMsg = 'Email not found';
        }
    } else {
        // echo "<div class='alert alert-danger'>You have to enter required fields</div>";
        $errorMsg = 'You have to enter required fields';
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


<a class="fs-5 link-underline link-underline-opacity-0 fw-semibold px-5 text-end d-block" style="color: #0F6290;" href="./adminlogin.php">
    <p class="mt-5 me-4">Admin Login</p>
</a>
<div style="padding: 100px 0;" id="loginModal" class="row login mt-4 px-lg-5 d-flex justify-content-center">
    <div class="col-4">
        <h2 class="text-center">Log in to Glam Gears</h2>



        <form action="" method="post" class="px-lg-5  mt-5">
            <div class="row">
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
            </div>
            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                    <input style="border: 1px solid #0F6290;" type="email" class="form-control bg-light border-start-0 py-2" placeholder="E-mail" name="logemail" value="<?php if (isset($logemail)) {
                                                                                                                                                                                echo $logemail;
                                                                                                                                                                            } ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-key"></i></span>
                    <input style="border: 1px solid #0F6290;" type="password" class="form-control bg-light border-start-0 py-2" placeholder="Password" name="logpass" value="<?php if (isset($logpassword)) {
                                                                                                                                                                                    echo $logpassword;
                                                                                                                                                                                } ?>">
                </div>
            </div>
            <div class="row">
                <a style="color: #0F6290;" class=" link-underline link-underline-opacity-0 fw-medium text-end" href="./frgtpass.php">Forgot password?</a>
            </div>
            <div class="row d-flex justify-content-center mt-3">
                <div class="col-6 ">
                    <button type="submit" name="logsubmit" class="bte w-100">Login</button>
                </div>
            </div>
        </form>
        <div class="row d-flex align-items-center mt-4 px-5 ">
            <div style="width: 100%; height:2px;" class="col bg-secondary"></div>

        </div>
        <div class="row mt-3">
            <p class="text-center">New User? <a style="color: #0F6290;" id="regRedirect" href="./signup.php" class=" fw-semibold link-underline link-underline-opacity-0">Register</a></p>
        </div>
    </div>
</div>


<?php
include_once('./footer.php');
?>