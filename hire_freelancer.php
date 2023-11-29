<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gowork"; // Name of the database you created

// Retrieve the freelancer name and the project title from the AJAX request
$freelancerName = $_POST['freelancer_name'];
$projectTitle = $_POST['project_title'];

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Begin a transaction for data consistency
$conn->begin_transaction();

// Update the "project" table to set the freelancer name where the project title matches
$updateSql = "UPDATE project SET freelancer_name = '$freelancerName' WHERE project_title = '$projectTitle'";

if ($conn->query($updateSql) === TRUE) {
  // If the update was successful, delete the corresponding row from the "proposals" table
  $deleteSql = "DELETE FROM proposals WHERE project_title = '$projectTitle'";
  
  if ($conn->query($deleteSql) === TRUE) {
    // Both update and delete were successful, commit the transaction
    $conn->commit();
    echo "Freelancer hired successfully!";
  } else {
    // An error occurred while deleting from "proposals," rollback the transaction
    $conn->rollback();
    echo "Error deleting proposal: " . $conn->error;
  }
} else {
  // An error occurred while updating "project," rollback the transaction
  $conn->rollback();
  echo "Error hiring freelancer: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
