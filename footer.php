<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>
<footer class="row px-2 px-lg-5 text-light d-flex justify-content-center" style="background-color: #001e2f">
    <div class="row border-bottom border-light p-2 p-md-5 mt-5 d-flex gap-5 gap-lg-0">
        <div class="col-11 col-lg-3">
            <a href="./index.php">
                <img class="img-fluid w-50 w-lg-100" src="./assets/icon/logowhite.png" alt="" />
            </a>
            <p>400 University Drive Suite 200 Madurai,<br>Tamil Nadu</p>
        </div>
        <div class="col-5 col-lg-3">
            <ul class="list-unstyled d-flex flex-column gap-4">
                <p class="fw-bold">QUICK LINKS</p>

                <li>
                    <a href="./index.php" class="link-light link-underline-opacity-0">HOME</a>
                </li>
                <li>
                    <a href="./shop.php" class="link-light link-underline-opacity-0">SHOP</a>
                </li>
                <li>
                    <a href="./blogs.php" class="link-light link-underline-opacity-0">BLOGS</a>
                </li>
                <li>
                    <a href="./about.php" class="link-light link-underline-opacity-0">ABOUT</a>
                </li>
                <li>
                    <a href="./contact.php" class="link-light link-underline-opacity-0">CONTACT</a>
                </li>
            </ul>
        </div>
        <div class="col-5 col-lg-3">
            <ul class="list-unstyled d-flex flex-column gap-4">
                <p class="fw-bold">OUR SUPPORTS</p>
                <li>
                    <a href="" class="link-light link-underline-opacity-0">HELP</a>
                </li>
                <li>
                    <a href="" class="link-light link-underline-opacity-0">PAYMENT OPTION</a>
                </li>
                <li>
                    <a href="" class="link-light link-underline-opacity-0">RETURNS</a>
                </li>
                <li>
                    <a href="" class="link-light link-underline-opacity-0">PRIVACY POLICIES</a>
                </li>
            </ul>
        </div>
        <div class="col-11 col-lg-3 order-2 order-lg-last">
            <p class="fw-bold">NEWSLETTER</p>

            <?php
            $errors = [];
            if (isset($_POST['subscribe'])) {

                $smail = $_POST["newsEmail"];

                require_once "./config.php";
                $sql = "SELECT * FROM newsletter WHERE news_email = '$smail'";
                $result = mysqli_query($config, $sql);
                $rowCount = mysqli_num_rows($result);


                if ($rowCount > 0) {
                    array_push($errors, "Email already exists!");
                }
                if ($smail == '') {
                    array_push($errors, "Enter your email");
                }
                if (!filter_var($smail, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Enter your email properly");
                }

                if (count($errors) > 0) {
                    foreach ($errors as  $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {

                    $query = mysqli_query($config, "INSERT INTO newsletter (news_email) VALUES('$smail')");
                    echo "<script>alert('Subscribed successful');</script>";
                    // echo "<script>window.location.href='./login.php'</script>";
                    //Load Composer's autoloader
                    require 'vendor/autoload.php';

                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                        $mail->Username   = 'starkringle@gmail.com';                //SMTP username
                        $mail->Password   = 'ezvn agcz fsvi sdsj';                  //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('starkringle@gmail.com', 'Glam Gears');
                        $mail->addAddress($smail, 'subscriber');                    //Add a recipient
                        $mail->addAttachment('./assets/img/Thank-you.png', 'image.png');

                        //Content
                        $mail->isHTML(true);                                        //Set email format to HTML
                        $mail->Subject = 'Subscribed For Glam Gears';
                        $mail->Body    = '<h3>You will receive an newsletters</h3>';

                        $mail->send();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    exit;
                }
            };

            ?>
            <form class="flex flex-column flex-lg-row align-items-center" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input placeholder="Enter Your Email Address" type="email" name="newsEmail" class="bg-transparent text-light border-bottom border-light placeholder-glow border-top-0 border-start-0 border-end-0" required />
                <button type="submit" name="subscribe" class="bg-transparent text-light border-bottom border-top-0 border-start-0 border-end-0">
                    SUBSCRIBE
                </button>
            </form>
        </div>
    </div>
    <div class="row px-5 py-3">
        <p>&copy;2024 Glam Gears. All rights reserved</p>
    </div>
</footer>
</section>

<script src="./assets/js/cart.js"></script>
<script src="./assets/js/main.js"></script>
<script src="./assets/js/log.js"></script>
<script src="./assets/js/hover.js"></script>
<script src="./assets/js/shop.js"></script>
<script src="./assets/js/location.js"></script>
<script src="./assets/js/showCase.js"></script>
<script src="./assets/js/play.js"></script>
<!-- <script src="./assets/js/contactform.js"></script> -->
<script src="./assets/js/blog.js"></script>
<script src="./assets/js/search.js"></script>
<script src="./assets/js/jquery-1.10.2.min.js"></script>
<script src="./assets/js/jquery-ui.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>