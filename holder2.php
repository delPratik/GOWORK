<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .password-reset-container {
            margin-top: 50px;
        }

        .center-button {
            text-align: center;
        }

        .login-button {
            margin-top: 10px;
        }

        .login-button a {
            background-color: #4CAF50;
            color: #fff;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="password-reset-container">
                    <h2 class="text-center">Reset Password</h2>
                    <div class="error-message">
                        <!-- Error messages will be displayed here -->
                    </div>
                    <form id="password-reset-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="number">Phone Number:</label>
                            <input type="text" class="form-control" name="number" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="form-group center-button">
                            <input type="submit" class="btn btn-primary btn-block" value="Reset Password">
                        </div>
                        <div class="form-group center-button login-button">
                            <a href="login.php" class="btn btn-success btn-block">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();

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
    $number = $_POST["number"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if the email and phone number exist and match in 'client' table
    $sql = "SELECT * FROM client WHERE email = '$email' AND phone_number = '$number'";
    $resultClient = $conn->query($sql);

    // Check if the email and phone number exist and match in 'freelancer' table
    $sql = "SELECT * FROM freelancer WHERE email = '$email' AND phone_number = '$number'";
    $resultFreelancer = $conn->query($sql);

    if ($resultClient->num_rows > 0) {
        $tableName = "client";
    } elseif ($resultFreelancer->num_rows > 0) {
        $tableName = "freelancer";
    } else {
        echo "<script>document.querySelector('.error-message').innerHTML = 'Invalid email or phone number. Please try again.';</script>";
        $conn->close();
        session_destroy();
        exit();
    }

    if ($newPassword === $confirmPassword) {
        // Hash the new password before updating
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update the password in the appropriate table
        $sql = "UPDATE $tableName SET password = '$hashedPassword' WHERE email = '$email' AND phone_number = '$number'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password reset successful!');</script>";
        } else {
            echo "<script>alert('Password reset failed. Please try again.');</script>";
        }
    } else {
        echo "<script>document.querySelector('.error-message').innerHTML = 'Password do not match. Please try again.';</script>";
    }

    $conn->close();
    session_destroy();
}
?>
