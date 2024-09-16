<?php
session_start();

include_once('./config.php');
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    // echo $userId;
}

if (isset($_POST['merchantSubmit'])) {
    function generate_5_digit_number()
    {
        return str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
    }

    $random_number = generate_5_digit_number();
    // echo "checking success";
    $merchantId = $random_number;
    $merchantName = $_POST["merchant_name"];
    $businessName = $_POST["business_name"];
    $merchantEmail = $_POST["merchant_email"];

    $merchantPhone = $_POST["merchant_phone"];
    $merchantpass = $_POST["merchantpass"];
    $merchantRepass = $_POST["merchantRepass"];

    $errors = array();


    require_once "./config.php";
    $sql = "SELECT * FROM merchants WHERE merchant_email = '$merchantEmail'";
    $result = mysqli_query($config, $sql);
    $rowCount = mysqli_num_rows($result);

    if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
    }
    if (empty($merchantName) or empty($businessName) or empty($merchantEmail) or empty($merchantPhone) or empty($merchantpass) or empty($merchantRepass)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($merchantEmail, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($merchantpass) < 8) {
        array_push($errors, "Password must be at least 8 charactes long");
    }
    if ($merchantpass !== $merchantRepass) {
        array_push($errors, "Password does not match");
    }
    if (strlen($merchantPhone) < 10) {
        // echo strlen($merchantPhone);
        array_push($errors, "Mobile number must be 10 charactes ");
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
// echo $userId;
?>
<div class="row d-flex justify-content-center my-5">
    <h3 class="text-center">Application for Merchant</h3>
    <form id="merchantForm" method="post" class="col-5 mt-4">
        <?php
        if (count($errors) > 0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // echo "checking success";

            $query = mysqli_query($config, "INSERT INTO merchants (merchant_id,merchant_name,business_name,merchant_email,merchant_phone,merchant_pass,userid) VALUES('$merchantId','$merchantName','$businessName','$merchantEmail','$merchantPhone','$merchantRepass','$userId')");
            echo "<script>alert('Your Application was successful');</script>";
            echo "<script>window.location.href='./index.php'</script>";
        }
        ?>
        <div class="mb-3">
            <label for="merchant_name" class="form-label">Merchant Name</label>
            <input style="  border: 1px solid #001e2f; " placeholder="Enter the sellers name" type="text" class="form-control rounded-0" id="merchant_name"
                name="merchant_name" value="<?php if (isset($merchantName)) {
                                                echo $merchantName;
                                            } ?>" required>
        </div>
        <div class="mb-3">
            <label for="business_name" class="form-label">Business Name</label>
            <input style="  border: 1px solid #001e2f; " placeholder="Enter your business name" type="text" class="form-control rounded-0"
                id="business_name" name="business_name" value="<?php if (isset($businessName)) {
                                                                    echo $businessName;
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
            <label for="merchantpass" class="form-label">Set password</label>
            <input style="  border: 1px solid #001e2f; " placeholder="Set your admin password" type="password" class="form-control rounded-0" id="merchantpass" name="merchantpass" value="<?php if (isset($merchantPhone)) {
                                                                                                                                                                                                echo $merchantPhone;
                                                                                                                                                                                            } ?>" required>
        </div>
        <div class="mb-3">
            <label for="merchantRepass" class="form-label">Re enter password</label>
            <input style="  border: 1px solid #001e2f; " placeholder="Re enter your admin password" type="password" class="form-control rounded-0" id="merchantRepass" name="merchantRepass" value="<?php if (isset($merchantPhone)) {
                                                                                                                                                                                                        echo $merchantPhone;
                                                                                                                                                                                                    } ?>" required>
        </div>
        <div class="row d-flex justify-content-between mt-5">
            <div class="col-3">
                <a href="./index.php" class=" btn btn-dark link-underline link-underline-opacity-0 rounded-0">Back to Home</a>
            </div>
            <div class="col-3">
                <button type="submit" name="merchantSubmit" class="bte w-100">Send a Request</button>
            </div>
        </div>
    </form>

</div>

<?php
include_once('./footer.php');
?>