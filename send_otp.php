<?php
session_start();

require 'vendor/autoload.php'; // Include the Composer-generated autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gowork";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];

    $sql = "SELECT * FROM client WHERE email = '$email'";
    $resultClient = $conn->query($sql);

    $sql = "SELECT * FROM freelancer WHERE email = '$email'";
    $resultFreelancer = $conn->query($sql);

    if ($resultClient->num_rows > 0) {
        $tableName = "client";
    } elseif ($resultFreelancer->num_rows > 0) {
        $tableName = "freelancer";
    } else {
        echo "<script>document.querySelector('.error-message').innerHTML = 'Invalid email. Please try again.';</script>";
        $conn->close();
        session_destroy();
        exit();
    }

    $otp = generateOTP();
    sendOTPEmail($email, $otp);

    $_SESSION['reset_otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['table'] = $tableName;

    header("Location: enter_otp.php");

    $conn->close();
    session_destroy();
}

function generateOTP() {
    return rand(1000, 9999);
}

function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'tls';  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'goworkfreelanceplatform@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'igqy egtj yxmy ppxt'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // Use the appropriate port for your SMTP host

        $mail->setFrom('goworkfreelanceplatform@gmail.com', 'GOWORK Freelance Platfrom'); // Replace with your email address and name
        $mail->addAddress($email); // Recipient email address

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = 'Your OTP is: ' . $otp;

        $mail->send();
        echo "<script>alert('An OTP has been sent to your email. Please check your inbox.');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to send OTP. Please try again.');</script>";
    }
}
?>
