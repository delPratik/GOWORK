<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            text-align: left;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="tel"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group input[type="number"]::-webkit-inner-spin-button,
        .form-group input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            appearance: none;
        }

        .form-group button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group .button-container {
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Client Registration Form</h2>
        <?php
        $nameErr = $ageErr = $addressErr = $phoneErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            function validateInput($data) {
                return htmlspecialchars(trim($data));
            }

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gowork";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $name = validateInput($_POST["name"]);
            $age = validateInput($_POST["age"]);
            $address = validateInput($_POST["address"]);
            $phone_number = validateInput($_POST["phone_number"]);
            $email = validateInput($_POST["email"]);
            $password = validateInput($_POST["password"]);
            $confirm_password = validateInput($_POST["confirm_password"]);

            if (!is_numeric($age)) {
                $ageErr = "Age must be a number.";
            }
            if (!preg_match("/^[0-9]+$/", $phone_number)) {
                $phoneErr = "Phone number must be a valid number.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format.";
            }

            if ($password !== $confirm_password) {
                $confirmPasswordErr = "Passwords do not match.";
            }

            if (empty($nameErr) && empty($ageErr) && empty($phoneErr) && empty($emailErr) && empty($confirmPasswordErr)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO client (name, age, address, phone_number, email, password)
                        VALUES (?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sissss", $name, $age, $address, $phone_number, $email, $hash);

                if ($stmt->execute()) {
                    echo "<p>Registration successful!</p>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            }

            $conn->close();
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" required>
                <span class="error"><?php echo $ageErr; ?></span>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" name="phone_number" required minlength="10" maxlength="10">
                <span class="error"><?php echo $phoneErr; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required>
                <span class="error"><?php echo $confirmPasswordErr; ?></span>
            </div>
            <div class="form-group">
                <div class="button-container">
                    <button type="submit" name="register">Register</button>
                </div>
                <div class="button-container">
                    <button type="button" onclick="location.href='login.php';">Back to Login</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
