<?php
require_once "./config.php";
require_once 'vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';

function generateRandomFiveDigitNumber()
{
    $randomNumber = mt_rand(5000, 9999);
    return $randomNumber;
}
$randomNumber = generateRandomFiveDigitNumber();


if (isset($_POST["forgetSubmit"])) {

    $verifyemail = $_POST["verifyemail"];

    $errorMsg = '';

    // require_once "./config.php";

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $config->prepare($sql);
    $stmt->bind_param("s", $verifyemail);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!empty($verifyemail)) {

        if (!filter_var($verifyemail, FILTER_VALIDATE_EMAIL)) {

            $errorMsg = 'Invalid email format';
        } else if ($result->num_rows > 0) {
            $query = "UPDATE users SET otp = $randomNumber  WHERE email=?";
            // require_once "./config.php";
            $stmt = $config->prepare($query);

            if (!$stmt) {
                die('Prepare failed: ' . $config->error);
            }

            $stmt->bind_param("s", $verifyemail);

            if ($stmt->execute()) {

                echo "<script>alert('before the mailer process');</script>";


                try {
                    $mail = new PHPMailer(true);
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                 //Enable verbose debug output
                    $mail->isSMTP();                                          //Send using SMTP
                    $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->Username   = 'starkringle@gmail.com';              //SMTP username
                    $mail->Password   = 'ezvn agcz fsvi sdsj';                //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       //Enable implicit TLS encryption
                    $mail->Port       = 587;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    // $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('starkringle@gmail.com', 'Glam Gears');
                    $mail->addAddress($verifyemail, 'receiver');              //Add a recipient



                    //Content
                    $mail->isHTML(true);                                      //Set email format to HTML
                    $mail->Subject = 'One time password from glam gears';
                    $mail->Body    = $randomNumber;


                    $mail->send();
                    header("Location: otpverify.php?email=" . $verifyemail);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                exit;
                // header("Location: otpverify.php?email=" . $verifyemail);
            } else {
                $errorMsg = $stmt->error;
            }
        } else {

            $errorMsg = 'Email not found';
        }
    } else {

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


<div class="forget-container">
    <div style="height:50vh;" class="row d-flex justify-content-center align-items-center">
        <div class="col-3">
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
            <h2 class="text-center">Validate Email</h2>
            <p class="text-center">Please enter your valid email which you used to create an account</p>
            <form action="" method="post" class="d-flex flex-column">
                <div class="input-group mb-3">
                    <span style="border-color: #0F6290;" class="input-group-text border-end-0 bg-light py-2" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                    <input style="border: 1px solid #0F6290;" type="email" class="form-control bg-light border-start-0 py-2" placeholder="E-mail" name="verifyemail" value="<?php if (isset($verifyemail)) {
                                                                                                                                                                                echo $verifyemail;
                                                                                                                                                                            } ?>">
                </div>

                <!-- <div class="input-group my-4 d-flex justify-content-center">
                    <button type="submit" class="bte" name="forgetSubmit">Verify Email</button>
                </div> -->

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="input-group my-4 d-flex justify-content-center">
                    <button type="submit" class="bte" name="forgetSubmit">Verify Email</button>
                </form>


            </form>
        </div>
    </div>

</div>



<?php
include_once('./footer.php');
?>