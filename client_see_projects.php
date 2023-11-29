<!DOCTYPE html>
<html>
<head>
  <title>Client Projects</title>
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
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
    }

    /* Navigation Menu */
    nav {
      background-color: #333;
      color: #fff;
    }

    nav ul {
      list-style-type: none;
      text-align: center;
      padding: 10px 0;
    }

    nav ul li {
      display: inline-block;
      margin-right: 20px;
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

    /* Table styles for Projects in Progress */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th,
    table td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    table th {
      background-color: #333;
      color: #fff;
    }

    table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    table tr:hover {
      background-color: #ddd;
    }

    /* Additional styles */
    p {
      margin-top: 20px;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation Menu -->
    <nav>
      <ul>
        <li><a href="client.php">Post a Project</a></li>
        <li><a href="client_view_proposals.php">View Proposals</a></li>
        <li><a href="client_see_projects.php">See Projects</a></li>
        <li><a href="#">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <?php
    session_start();

    // Check if the client name is set in the session
    if (isset($_SESSION['client_name'])) {
      $clientName = $_SESSION['client_name'];

      // Establish a database connection (Assuming you have a valid database connection here)
      $conn = new mysqli("localhost", "root", "", "gowork");

      // Check if the database connection was successful
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query to retrieve projects in progress associated with the client with a work value of 'Pending'
      $sql = "SELECT project_id, project_title, category, budget, deadline, description, status, freelancer_name FROM project WHERE client_name = ? AND work = 'Pending'";

      // Prepare and bind the SQL statement
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $clientName);

      // Execute the statement
      $stmt->execute();

      // Get the result set
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h1>Projects in Progress</h1>";
        echo "<table>";
        echo "<tr><th>Project ID</th><th>Project Title</th><th>Category</th><th>Budget</th><th>Deadline</th><th>Description</th><th>Status</th><th>Freelancer</th></tr>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['project_id'] . "</td>";
          echo "<td>" . $row['project_title'] . "</td>";
          echo "<td>" . $row['category'] . "</td>";
          echo "<td>" . $row['budget'] . "</td>";
          echo "<td>" . $row['deadline'] . "</td>";
          echo "<td>" . $row['description'] . "</td>";
          echo "<td>" . $row['status'] . "</td>";
          echo "<td>" . $row['freelancer_name'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
      } else {
        echo "<div class='container'>";
        echo "<h1>Projects in Progress</h1>";
        echo "<p>No projects in progress</p>";
        echo "</div>";
      }

      // Close the statement
      $stmt->close();

      // Close the database connection
      $conn->close();
    } else {
      echo "<div class='container'>";
      echo "<p>You are not logged in as a client.</p>";
      echo "</div>";
    }
    ?>

  </div>
</body>
</html>
