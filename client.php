<!DOCTYPE html>
<html>
<head>
  <title>Client Dashboard</title>
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
      text-align: center; /* Center-align text within the dashboard */
    }

    /* Post a Project Form */
    .post-project {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    .post-project form label {
      display: block;
      margin-bottom: 5px;
    }

    .post-project form input,
    .post-project form select,
    .post-project form textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }

    .post-project form button {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .post-project form button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation Menu -->
    <nav>
      <ul>
        <li><a href="#">Post a Project</a></li>
        <li><a href="client_view_proposals.php">View Proposals</a></li>
        <li><a href="client_see_projects.php">See Projects</a></li>
        <li><a href="#">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

<!-- Dashboard Overview -->
<div class="dashboard">
  <?php
  // Start the session
  session_start();

  // Check if the client name is set in the session
  if (isset($_SESSION['client_name'])) {
    $clientName = $_SESSION['client_name'];
    echo "<h1>Welcome, $clientName!</h1>";
  } else {
    echo "<h1>Welcome Client</h1>";
  }
  ?>
</div>


    <!-- Post a Project Form -->
    <div class="post-project">
      <h1>Post a Project</h1>
      <form method="post" action="client.php">
        <label for="project-title">Project Title</label>
        <input type="text" id="project-title" name="project_title" required>

        <label for="project-category">Project Category</label>
        <select id="project-category" name="category" required>
          <option value="Content Writing">Content Writing</option>
          <option value="Web Design">Web Design</option>
          <option value="Graphic Design">Graphic Design</option>

        </select>

        <label for="project-budget">Budget</label>
        <input type="number" id="project-budget" name="budget" required>

        <label for="project-deadline">Deadline</label>
        <input type="date" id="project-deadline" name="deadline" required>

        <!-- New Project Description field -->
        <label for="project-description">Project Description</label>
        <textarea id="project-description" name="project_description" rows="4" required></textarea>

        <button type="submit" name="submit">Post</button>
      </form>
    </div>
  </div>
</body>
</html>
<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $projectTitle = $_POST['project_title'];
    $category = $_POST['category'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];
    $projectDescription = $_POST['project_description'];
    
    // Retrieve the client's name from the session
    $clientName = $_SESSION['client_name'];

    // Set the initial work status to "Pending"
    $workStatus = "Pending";

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO project (project_title, category, budget, deadline, description, client_name, work) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssss", $projectTitle, $category, $budget, $deadline, $projectDescription, $clientName, $workStatus);

    // Execute the statement
    if ($stmt->execute()) {
        $project_id = $conn->insert_id;  // Get the ID of the newly inserted project
        $_SESSION['project_id'] = $project_id;  // Set the session variable
        echo "<div class='success-message' style='text-align: center; color: blue;'>Project posted successfully.</div>";
    } else {
        echo "<div class='error-message' style='text-align: center; color: red;'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

