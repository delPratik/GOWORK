<!DOCTYPE html>
<html>
<head>
  <title>View Proposals</title>
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
      margin-bottom: 10px;
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

    /* Display table styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    .hire-button {
      background-color: brown; /* Blue background color */
      color: white; /* White text color */
      padding: 10px 20px; /* Increase button size */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .hire-button:hover {
      background-color: green; /* Green on hover */
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Navigation Menu -->
    <nav>
      <ul>
        <li><a href="client.php">Post a Project</a></li>
        <li><a href="#">View Proposals</a></li>
        <li><a href="client_see_projects.php">See Projects</a></li>
        <li><a href="#">Profile Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <!-- View Proposals -->

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gowork"; // Name of the database you created

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Query the database to fetch proposals with project title, budget, deadline, and freelancer name
    $sql = "SELECT project_title, budget, deadline, freelancer_name
            FROM proposals";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr><th>Project Title</th><th>Budget</th><th>Deadline</th><th>Freelancer Name</th><th>Action</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['project_title']}</td>";
        echo "<td>{$row['budget']}</td>";
        echo "<td>{$row['deadline']}</td>";
        echo "<td>{$row['freelancer_name']}</td>";
        echo "<td>";
        // Create a button that calls the JavaScript function when clicked
        echo "<button class='hire-button' onclick=\"hireFreelancer('{$row['freelancer_name']}', '{$row['project_title']}')\">Hire</button>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<p>No proposals have been submitted.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>

  <script>
    function hireFreelancer(freelancerName, projectTitle) {
      // Send an AJAX request to the server to hire the freelancer.
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'hire_freelancer.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            // Handle a successful response
            alert(xhr.responseText); // You can display a success message or handle errors here.
            // Optionally, you can update the UI to reflect that the freelancer is hired.
          } else {
            // Handle an error response
            alert('Error: ' + xhr.status);
          }
        }
      };
      
      // Send the data to the server
      const data = 'freelancer_name=' + encodeURIComponent(freelancerName) + '&project_title=' + encodeURIComponent(projectTitle);
      xhr.send(data);
    }
  </script>
</body>
</html>
