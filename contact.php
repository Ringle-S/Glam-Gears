<?php
session_start();

include_once('./config.php');
if (isset($_SESSION['user'])) {
  $userId = $_SESSION['user'];
  // echo $userId;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;






?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once('./head.php');
?>


<?php
include_once('./header.php');
?>


<!-- conatct banner -->
<section style="
          height: 80vh;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          background-image: url('./assets/img/Contactban.png');
        " class="contactban row">
  <div class="contactban-contact col-12 col-lg-6 d-flex gap-3 flex-column justify-content-center align-items-center text-light">
    <img src="./assets/icon/logowhite.png" alt="" />
    <h1 class="display-3 fw-semibold">CONTACT US</h1>
    <!-- <div class="line"></div> -->
    <p>FOLLOW US ON SOCIAL MEDIA</p>
    <div class="mediarow d-flex gap-3">
      <a href="https://www.facebook.com/login/" target="_blank">
        <img width="28px" height="28px" src="./assets/icon/Social Media Icon Square/Facebook.png" alt="" />
      </a>
      <a href="https://www.instagram.com/accounts/login/" target="_blank">
        <img width="28px" height="28px" src="./assets/icon/Social Media Icon Square/Instagram.png" alt="" />
      </a>
      <a href="https://www.linkedin.com/feed/" target="_blank">
        <img width="28px" height="28px" src="./assets/icon/Social Media Icon Square/LinkedIn.png" alt="" />
      </a>
      <a href="https://x.com/i/flow/login" target="_blank">
        <img width="28px" height="28px" src="./assets/icon/Social Media Icon Square/Twitter.png" alt="" />
      </a>
      <a href="https://www.youtube.com/account" target="_blank">
        <img width="28px" height="28px" src="./assets/icon/Social Media Icon Square/YouTube.png" alt="" />
      </a>
    </div>
  </div>
  <div class="contactban-img col-18 col-lg-6 d-flex justify-content-center align-items-center justify-content-lg-start">
    <img class="img-fluid" src="./assets/img/airbuds.png" alt="" />
  </div>
</section>
<!-- form container -->
<section class="form-container">
  <div class="row">
    <div class="d-flex flex-column align-items-center">
      <h2 class="display-5 fw-semibold">Get In Touch With Us</h2>
      <p class="w-75 w-lg-50 text-center">
        For More Information About Our Product & Services. Please Feel
        Free To Drop Us An Email. Our Staff Always Be There To Help You
        Out. Do Not Hesitate!
      </p>
    </div>
  </div>
  <div class="row mt-5 pt-5">
    <div class="col-12 col-lg-6 d-flex flex-column gap-4">
      <div class="d-flex row flex-column align-items-center align-items-lg-start text-center text-lg-start gap-2">
        <div class=" d-flex justify-content-center gap-4 justify-content-lg-start align-items-center ">
          <img class="" src="./assets/icon/location.png" alt="" />
          <h5 class="fs-4 mb-0" style="color: #0f6290">ADDRESS</h5>
        </div>
        <div class="d-flex flex-column ms-0 ms-lg-5">
          <p class="fs-5 mb-0">
            400 University Drive Suite 200 Madurai,Tamil Nadu
          </p>
        </div>
      </div>
      <div class="d-flex row flex-column align-items-center align-items-lg-start text-center text-lg-start gap-2">
        <div class=" d-flex justify-content-center gap-4 justify-content-lg-start align-items-center ">
          <img class="" src="./assets/icon/phone.png" alt="" />
          <h5 class="fs-4 mb-0" style="color: #0f6290">PHONE</h5>
        </div>
        <div class="d-flex flex-column ms-0 ms-lg-5">
          <p class="fs-5  mb-0">Mobile: <a class="link-underline text-dark link-underline-opacity-0" href="tel:+">+91 8548569854</a></p>
          <p class="fs-5 ">Hotline: <a class="link-underline text-dark link-underline-opacity-0" href="tel:+">20054 254184</a></p>
        </div>
      </div>
      <div class="d-flex row flex-column align-items-center align-items-lg-start text-center text-lg-start gap-2">
        <div class=" d-flex justify-content-center gap-4 justify-content-lg-start align-items-center">
          <img class="" src="./assets/icon/Clcok.png" alt="" />
          <h5 class="fs-4 mb-0" style="color: #0f6290">WORKING TIME</h5>
        </div>
        <div class="d-flex flex-column ms-0 ms-lg-5">
          <p class="fs-5 mb-0">Monday-Friday: 9:00 - 22:00</p>
          <p class="fs-5">Saturday-Sunday: 9:00 - 21:00</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6 wrapper">
      <div id="error_message"></div>
      <?php

      if (isset($_POST['contactSubmit'])) {
        // echo "checking success";

        $contactName = $_POST["contactname"];
        $contactEmail = $_POST["contactmail"];
        $contactText = $_POST["Contactmessage"];


        $errors = array();


        include_once('./config.php');
        $sql = "SELECT * FROM contacts_queries WHERE contact_email = '$contactEmail'";
        $stmt = $config->prepare($sql);
        if (!$stmt) {
          die('Prepare failed: ' . $config->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
          die('Query execution failed: ' . $stmt->error);
        }

        $rowCount = $result->num_rows;

        // if (!empty($gender)) {
        //     array_push($errors, "Please choose your gender");
        // }
        if ($rowCount > 0) {
          array_push($errors, "Email already exists!");
        }
        if (empty($contactName) or empty($contactEmail) or empty($contactText)) {
          array_push($errors, "All fields are required");
        }
        if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
          array_push($errors, "Email is not valid");
        }

        if (count($errors) > 0) {
          foreach ($errors as  $error) {
            echo "<div class='alert alert-danger'>$error</div>";
          }
        } else {
          include_once('./config.php');
          $query = "INSERT INTO contacts_queries (contact_name, contact_email, contact_message) VALUES (?, ?, ?)";
          $stmt = $config->prepare($query);

          if (!$stmt) {
            die('Prepare failed: ' . $config->error);
          }

          $stmt->bind_param("sss", $contactName, $contactEmail, $contactText);




          if ($stmt->execute()) {
            echo "<div class='alert alert-success'>You will get reply from us shortly</div>";
            $mail = new PHPMailer(true);

            try {
              //Server settings
              // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
              $mail->isSMTP();                                            //Send using SMTP
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
              $mail->Username   = 'starkringle@gmail.com';                     //SMTP username
              $mail->Password   = 'ezvn agcz fsvi sdsj';                               //SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
              $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

              //Recipients
              $mail->setFrom('starkringle@gmail.com', 'Glam Gears');
              $mail->addAddress($contactEmail, 'COntacter');     //Add a recipient


              //Attachments
              // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
              // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

              //Content
              $mail->isHTML(true);                                  //Set email format to HTML
              $mail->Subject = 'Reply From Glam Gears';
              $mail->Body    = '<h3>Your query has been received and we will respond briefly</h3>';
              // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

              $mail->send();
              // echo 'Message has been sent';
            } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {" . $contactEmail . "->ErrorInfo}";
            }
            exit;
          }
        }
      }

      ?>
      <form action="" id="contactform" method="post" class="d-flex flex-column gap-4">
        <div class="input_field">
          <label for="name" class="form-label fs-5 fw-medium">Your name</label>
          <input style="border-color: #001e2f" value="<?php if (isset($contactName)) {
                                                        echo $contactName;
                                                      } ?>" name="contactname" class="border-1" type="text" placeholder="Your name" id="name" required />
        </div>

        <div class="input_field">
          <label for="email" class="form-label fs-5 fw-medium">Email address</label>
          <input style="border-color: #001e2f" value="<?php if (isset($contactEmail)) {
                                                        echo $contactEmail;
                                                      } ?>" name="contactmail" class="border-1" type="text" placeholder="Abc@def.com" id="email" required />
        </div>
        <div class="input_field">
          <label for="message" class="form-label fs-5 fw-medium">Message</label>
          <textarea style="border-color: #001e2f" value="<?php if (isset($contactText)) {
                                                            echo $contactText;
                                                          } ?>" name="Contactmessage" class="border-1" placeholder="Hi! i’d like to ask about" id="message"></textarea>
        </div>
        <div class="d-flex justify-content-center justify-content-lg-start">
          <button type="submit" name="contactSubmit" class="bte">SUBMIT</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- map container -->

<section class="map-container row">
  <iframe class="col-12" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d246.1709269339998!2d77.87779107236427!3d9.178375305120815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1722587985601!5m2!1sen!2sin" style="border: 0; height: 50vh" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<?php
include_once('./footer.php');
?>