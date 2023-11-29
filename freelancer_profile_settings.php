<!DOCTYPE html>
<html>
<head>
  <title>Freelancer Profile Settings</title>
  <style>
    /* Your existing CSS styles for the navigation bar */
    /* ... (Copy the styles from your original code) ... */

    /* Additional styles for the profile section */
    .profile {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      margin-top: 20px;
    }

    .profile-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .profile-table th,
    .profile-table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Global styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    /* Navigation Menu */
    nav {
      background-color: #333;
      padding: 10px 0;
    }

    nav ul {
      list-style-type: none;
      text-align: center;
    }

    nav ul li {
      display: inline-block;
    }

    nav ul li a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
    }

    nav ul li a:hover {
      background-color: #555;
    }

    /* Dashboard Overview */
    .dashboard {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
      text-align: center;
    }

    /* View Projects Section */
    .view-projects {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    /* Project Listing Styles */
    .project-listing {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
    }

    .project-title {
      font-size: 18px;
      font-weight: bold;
    }

    .project-description {
      margin-top: 10px;
    }

    .project-details {
      margin-top: 10px;
    }

  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation Menu (Same as in your original code) -->
    <nav>
      <ul>
        <li><a href="freelancer.php">View Projects</a></li>
        <li><a href="freelancer_my_projects.php">My Projects</a></li>
        <li><a href="#">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <div class="profile">
      <?php
      // Start the session
      session_start();

      // Check if the freelancer name is set in the session
      if (isset($_SESSION['freelancer_name'])) {
        $freelancerName = $_SESSION['freelancer_name'];
        echo "<h1>Profile Settings:</h1>";
      }
      ?>

      <table class="profile-table">
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gowork";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch freelancer profile information from the database
        $profileQuery = "SELECT age, address, phone_number, email, skills FROM freelancer WHERE freelancer_name = '$freelancerName'";
        $profileResult = $conn->query($profileQuery);

        if ($profileResult->num_rows > 0) {
          $profileData = $profileResult->fetch_assoc();
          echo "<tr><th>Age</th><td>" . $profileData['age'] . "</td></tr>";
          echo "<tr><th>Address</th><td>" . $profileData['address'] . "</td></tr>";
          echo "<tr><th>Phone Number</th><td>" . $profileData['phone_number'] . "</td></tr>";
          echo "<tr><th>Email</th><td>" . $profileData['email'] . "</td></tr>";
          echo "<tr><th>Skills</th><td>" . $profileData['skills'] . "</td></tr>";
        } else {
          echo "<tr><th colspan='2'>No profile information found.</th></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
      </table>
    </div>
  </div>
</body>
</html>
