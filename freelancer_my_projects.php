<!DOCTYPE html>
<html>
<head>
  <title>Freelancer Dashboard - My Projects</title>
  <style>
    /* Reset default browser styles (Same as in your original code) */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Global styles (Same as in your original code) */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
      margin: 0; /* Remove default body margin */
      padding: 0; /* Remove default body padding */
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

    /* Navigation Menu (Same as in your original code) */
    nav {
      background-color: #333;
      padding: 10px 0;
    }

    nav ul {
      list-style-type: none;
      text-align: center;
      margin: 0; /* Remove default margin */
      padding: 0; /* Remove default padding */
    }

    nav ul li {
      display: inline-block;
      margin-right: 20px; /* Add space between menu items */
    }

    nav ul li:last-child {
      margin-right: 0; /* Remove margin from the last menu item */
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

    /* Project Listing Styles */
    .view-projects {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .project-listing {
      border: 1px solid #ccc;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
      background-color: #f9f9f9;
    }

    .project-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .project-description {
      font-size: 16px;
      margin-top: 10px;
      color: #555;
    }

    .project-details {
      margin-top: 10px;
      font-size: 14px;
      color: #777;
    }

    .error-message {
      text-align: center;
      color: red;
      margin-top: 20px;
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
        <li><a href="freelancer_profile_settings.php">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <!-- My Projects Section (Updated PHP code for displaying projects) -->
    <div class="view-projects">
      <h1>My Projects</h1>

      <?php
// Start the session at the beginning of the script
session_start();

// Check if the freelancer name is set in the session
if (isset($_SESSION['freelancer_name'])) {
    $freelancerName = $_SESSION['freelancer_name'];

    // Database connection parameters (Update these with your actual database credentials)
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

    // Initialize an empty array to store project IDs
    $projectIds = [];

    // Fetch and display projects assigned to the freelancer
    $sql = "SELECT project_id, project_title, category, budget, deadline, description, client_name, work
        FROM project 
        WHERE status = 'Approved' AND freelancer_name = '$freelancerName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of assigned projects
        while ($row = $result->fetch_assoc()) {
            echo "<div class='project-listing'>";
            $projectId = $row["project_id"];
            $projectIds[] = $projectId; // Store project ID in the array
            echo "<div class='project-title'>Project ID: " . $projectId . "</div>"; // Display Project ID
            echo "<div class='project-title'>" . $row["project_title"] . "</div>";
            echo "<div class='project-description'>Description: " . $row["description"] . "</div>";
            echo "<div class='project-details'>";
            echo "Category: " . $row["category"] . "<br>";
            echo "Budget: RS " . $row["budget"] . "<br>";
            echo "Deadline: " . $row["deadline"] . "<br>";
            echo "Client Name: " . $row["client_name"] . "<br>"; // Display Client Name
            echo "Work: " . $row["work"] . "<br>";

            // Check if "work" is "Pending," and if so, display the "Submit Work" link
            if ($row["work"] === "Pending") {
                // Link to the Submit Work page with the project_id as a session variable
                echo "<a href='freelancer_submit_work.php'>Submit Work</a><br>";
                // Store the project_id in the session
                $_SESSION['project_id'] = $projectId;
            }

            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='error-message'>No projects assigned.</div>";
    }

    // Store the array of project IDs as a session variable
    $_SESSION['project_ids'] = $projectIds;

    // Close the database connection
    $conn->close();
} else {
    // Handle the case when the freelancer is not logged in
    echo "<div class='error-message'>You are not logged in.</div>";
}
?>

    </div>
  </div>
</body>
</html>
