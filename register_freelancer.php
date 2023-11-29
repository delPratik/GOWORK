<!DOCTYPE html>
<html>
<head>
    <title>Freelancer Registration Form</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="number"] {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group input[type="number"]::-webkit-inner-spin-button,
        .form-group input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none; /* Chrome, Safari */
            appearance: none; /* Firefox */
        }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group .skills-group {
            margin-top: 5px;
        }

        .form-group .skills-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group .skills-group input[type="checkbox"] {
            margin-right: 5px;
        }

        .form-group .error {
            color: red;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Freelancer Registration Form</h2>
        <?php
        $nameErr = $ageErr = $addressErr = $phoneErr = $emailErr = $passwordErr = $confirmPasswordErr = $skillsErr = "";

        // Establish a connection to your MySQL database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gowork";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define variables to store user input
        $name = $age = $address = $phone_number = $email = $password = $confirm_password = "";
        $selectedSkills = [];

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST["name"];
            $age = $_POST["age"];
            $address = $_POST["address"];
            $phone_number = $_POST["phone_number"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Retrieve selected skills
            if (isset($_POST["skills"]) && is_array($_POST["skills"])) {
                $selectedSkills = $_POST["skills"];
            } else {
                $skillsErr = "At least one skill must be selected.";
            }

            // Validate data types
            if (!is_numeric($age)) {
                $ageErr = "Age must be a number.";
            }
            if (!preg_match("/^[0-9]+$/", $phone_number)) {
                $phoneErr = "Phone number must be a valid number.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format.";
            }

            // Check if passwords match
            if ($password !== $confirm_password) {
                $confirmPasswordErr = "Passwords do not match.";
            }

            // If there are no errors, insert data into the database
            if (empty($ageErr) && empty($phoneErr) && empty($emailErr) && empty($skillsErr) && empty($confirmPasswordErr)) {
                // Insert data into the freelancer table
                $skillsList = implode(", ", $selectedSkills);
                $sql = "INSERT INTO freelancer (name, age, address, phone_number, email, password, skills)
                        VALUES ('$name', $age, '$address', '$phone_number', '$email', '$hash', '$skillsList')";

                if ($conn->query($sql) === true) {
                    echo "Registration successful!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
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
                <label for="skills">Skills:</label>
                <div class="skills-group">
                    <label><input type="checkbox" name="skills[]" value="Web Development"> Web Development</label>
                    <label><input type="checkbox" name="skills[]" value="Graphic Design"> Graphic Design</label>
                    <label><input type="checkbox" name="skills[]" value="Content Writing"> Content Writing</label>
                    <label><input type="checkbox" name="skills[]" value="Data Entry"> Data Entry</label>
                    <label><input type="checkbox" name="skills[]" value="Video Editing"> Video Editing</label>
                    <label><input type="checkbox" name="skills[]" value="Digital Marketing"> Digital Marketing</label>
                    <label><input type="checkbox" name="skills[]" value="SEO"> SEO</label>
                    <!-- Add more skills as needed -->
                </div>
                <span class="error"><?php echo $skillsErr; ?></span>
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
