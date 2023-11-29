<!DOCTYPE html>
<html>
<head>
  <title>Submit Proposal</title>
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

    /* Proposal Form */
    .proposal-form {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    .proposal-form label {
      display: block;
      margin-bottom: 10px; /* Add spacing between elements */
    }

    .proposal-form input,
    .proposal-form textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 20px; /* Add more spacing between elements */
    }

    .proposal-form button {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      margin: 0 auto; /* Center-align the button */
    }

    .proposal-form button:hover {
      background-color: #555;
    }

    /* Center-align the project title and "Submit Proposal" button */
    .project-title,
    .submit-button {
      text-align: center;
    }

    /* Left-align the project description */
    .project-description {
      text-align: left;
    }

    .go-back-button {
    margin-top: 10px; /* Adjust the value as needed to increase the gap */
    display: inline-block; /* Ensure it doesn't span the entire width */
    }
    /* Add any additional styles as needed */
  </style>
</head>
<body>
  <div class="container">
    <div class="proposal-form">
    
      <!-- Display the project title and description -->
      <?php
      session_start();
      // Retrieve project title and description from the database based on project_id
      if (isset($_GET['project_id'])) {
          $project_id = $_GET['project_id'];
          
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

          $sql = "SELECT project_title, description FROM project WHERE project_id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $project_id);
          
          if ($stmt->execute()) {
              $stmt->bind_result($project_title, $project_description);
              $stmt->fetch();
              $stmt->close();
          } else {
              $project_title = "Project Not Found";
              $project_description = "Description Not Available";
          }

          // Close the database connection
          $conn->close();
      }
      ?>

      <!-- Center-align the project title -->
      <div class="project-title">
        <h2>Project Title: <?php echo $project_title; ?></h2>
      </div>

      <!-- Left-align the project description -->
      <div class="project-description">
        <p>Description: <?php echo $project_description; ?></p>
      </div>

      <!-- Proposal submission form -->
      <form method="post" action="freelancer_submit_proposal.php">
        <!-- Hidden fields to store project_id and project_title -->
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <input type="hidden" name="project_title" value="<?php echo $project_title; ?>">

        <label for="budget">Budget (RS):</label>
        <input type="text" id="budget" name="budget" required>

        <label for="deadline">Deadline:</label>
        <input type="date" id="deadline" name="deadline" required>

        <!-- Center-align the "Submit Proposal" button -->
        <div class="submit-button">
          <button type="submit" name="submit">Submit Proposal</button>
          <a href="freelancer.php" class="go-back-button">Go Back</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
<?php
session_start(); // Start the session to access freelancer information

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $project_id = $_POST['project_id'];
    $project_title = $_POST['project_title'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];

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

    // Retrieve freelancer's name from the session
    $freelancer_name = $_SESSION['freelancer_name'];

    // Prepare the SQL statement
    $sql = "INSERT INTO proposals (project_id, project_title, freelancer_name, budget, deadline) 
            VALUES ('$project_id', '$project_title', '$freelancer_name', '$budget', '$deadline')";

    // Execute the statement
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message' style='text-align: center; color: blue;'>Proposal submitted successfully.</div>";
    } else {
        echo "<div class='error-message' style='text-align: center; color: red;'>Error: " . $conn->error . "</div>";
    }

    // Close the database connection
    $conn->close();
}
?>
