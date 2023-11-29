<!DOCTYPE html>
<html>
<head>
  <title>Freelancer Dashboard</title>
  <style>
    /* Reset default browser styles */
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

    /* Add any additional styles as needed */
  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation Menu -->
    <nav>
      <ul>
        <li><a href="#">View Projects</a></li>
        <li><a href="freelancer_my_projects.php">My Projects</a></li>
        <li><a href="freelancer_profile_settings.php">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <div class="dashboard">
      <?php
      // Start the session
      session_start();

      // Check if the freelancer name is set in the session
      if (isset($_SESSION['freelancer_name'])) {
        $freelancerName = $_SESSION['freelancer_name'];
        echo "<h1>Welcome, $freelancerName!</h1>";
      } else {
        echo "<h1>Welcome Freelancer</h1>";
      }
      ?>
    </div>
    
    <!-- View Projects Section -->
    <div class="view-projects">
      <h1>View Projects</h1>
      
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

      // SQL query to retrieve approved projects with freelancer_name as null
      $sql = "SELECT project_id, project_title, category, budget, deadline, description, client_name 
              FROM project 
              WHERE status = 'Approved' AND freelancer_name IS NULL";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of approved projects
        while ($row = $result->fetch_assoc()) {
          echo "<div class='project-listing'>";
          echo "<div class='project-title'>Project ID: " . $row["project_id"] . "</div>"; // Display Project ID
          echo "<div class='project-title'>" . $row["project_title"] . "</div>";
          echo "<div class='project-description'>Description: " . $row["description"] . "</div>";
          echo "<div class='project-details'>";
          echo "Category: " . $row["category"] . "<br>";
          echo "Budget: RS " . $row["budget"] . "<br>";
          echo "Deadline: " . $row["deadline"] . "<br>";
          echo "Client Name: " . $row["client_name"] . "<br>"; // Display Client Name
          echo "<a href='freelancer_submit_proposal.php?project_id=" . $row["project_id"] . "'>Submit Proposal</a>";
          echo "</div>";
          echo "</div>";
        }
      } else {
        echo "<div class='error-message' style='text-align: center; color: red;'>No approved projects found.</div>";
      }

      // Close the database connection
      $conn->close();
      ?>
    </div>
  </div>
</body>
</html>
