<!DOCTYPE html>
<html>
<head>
  <title>GOWORK - Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .login-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      color: #333;
      font-weight: 500;
      text-align: center;
      margin-bottom: 30px;
    }

    .login-container .form-group {
      margin-bottom: 20px;
    }

    .login-container label {
      font-weight: 500;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
      border-radius: 3px;
      border: 1px solid #ccc;
      padding: 8px 12px;
      width: 100%;
      font-size: 14px;
    }

    .login-container .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      width: 100%;
    }

    .login-container .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .login-container .text-center a {
      color: #007bff;
    }

    .login-container .text-center a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="login-container">
          <h2>GOWORK LOGIN</h2>
          <?php
          session_start(); // Start the session
          $_SESSION['name']=
         // Database connection configuration
$host = "localhost";
$username = "root";
$password = "";
$dbname = "gowork";

// Establish a connection to the database
$connection = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

          // Check if the form is submitted
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve user input from the login form
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Prepare the SQL statement to check user credentials in the "admin" table
            $sql = "SELECT * FROM admin WHERE email = '$email'";
            $result = mysqli_query($connection, $sql);

            // Check if any row matches the provided credentials
            if (mysqli_num_rows($result) > 0) {
                // Admin login successful
                mysqli_close($connection);
                header("Location: admin.php");
                exit();
            } else {
                // No match in the "admin" table, check the "client" table
                $sql = "SELECT * FROM client WHERE email = '$email'";
                $result = mysqli_query($connection, $sql);

                // Check if any row matches the provided credentials
                if (mysqli_num_rows($result) > 0) {
                    // Retrieve the hashed password for the client
                    $row = mysqli_fetch_assoc($result);
                    $hashedPassword = $row['password'];
                    $clientName = $row['name']; // Assuming the column name for the name is 'name'

                    // Use the password_verify() function to compare the user's input password to the hashed password
                    if (password_verify($password, $hashedPassword)) {
                        // Client login successful
                        $_SESSION['client_name'] = $clientName; // Store client name in session
                        mysqli_close($connection);
                        header("Location: client.php");
                        exit();
                    } else {
                        // Client password is incorrect
                        echo "<p class='text-danger text-center'>Invalid email or password.</p>";
                    }
                } else {
                    // No match in the "client" table, check the "freelancer" table
                    $sql = "SELECT * FROM freelancer WHERE email = '$email'";
                    $result = mysqli_query($connection, $sql);

                    // Check if any row matches the provided credentials
                    if (mysqli_num_rows($result) > 0) {
                        // Retrieve the hashed password for the freelancer
                        $row = mysqli_fetch_assoc($result);
                        $hashedPassword = $row['password'];
                        $freelancerName = $row['name']; // Assuming the column name for the name is 'name'

                        // Use the password_verify() function to compare the user's input password to the hashed password
                        if (password_verify($password, $hashedPassword)) {
                            // Freelancer login successful
                            $_SESSION['freelancer_name'] = $freelancerName; // Store freelancer name in session
                            mysqli_close($connection);
                            header("Location: freelancer.php");
                            exit();
                        } else {
                            // Freelancer password is incorrect
                            echo "<p class='text-danger text-center'>Invalid email or password.</p>";
                        }
                    } else {
                        // No match in any table, login failed
                        echo "<p class='text-danger text-center'>Invalid email or password.</p>";
                    }
                }
            }
        }
        ?>
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="submit" value="Login" class="btn btn-primary">
            </div>
          </form>
          <div class="text-center">
            <p>Forgot password? <a href="forgot_password.php">Reset here</a></p>
            <p>Not a member yet? <a href="register.php">Register here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
