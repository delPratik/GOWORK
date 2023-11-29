<!DOCTYPE html>
<html>
<head>
    <title>Submit Work</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    
    h2 {
        color: #333;
        text-align: center;
    }
    
    .container {
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
    }
    
    input[type="file"] {
        border: 1px solid #ccc;
        padding: 8px;
        width: 95%;
    }
    
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 20px auto;
        display: block;
    }
    
    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .container form {
        margin-left: auto;
        margin-right: auto;
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Submit Your Project</h2>

        <form action="freelancer_submit_work.php" method="post" enctype="multipart/form-data">
            <input type="file" name="project_file" id="project_file" accept=".pdf, .doc, .docx, .txt">
            <br>
            <input type="submit" value="Upload Project" name="submit">
        </form>
    </div>
</body>
</html>
<?php
// Start the session at the beginning of the script
session_start();

// Check if the freelancer name and project ID are set in the session
if (!isset($_SESSION['freelancer_name']) || !isset($_SESSION['project_id'])) {
    // Handle the case when the freelancer is not logged in or the project is not specified
    echo "You are not logged in or the project is not specified.";
    exit; // Exit to prevent further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
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

    // Check if a file was uploaded
    if (isset($_FILES["project_file"]) && $_FILES["project_file"]["error"] === UPLOAD_ERR_OK) {
        // Define the directory where uploaded files will be stored
        $uploadDir = "/Applications/XAMPP/xamppfiles/htdocs/GOWORK/uploads"; // Update this path

        // Generate a unique file name to avoid overwriting existing files
        $fileName = uniqid() . "_" . basename($_FILES["project_file"]["name"]);

        // Define the full path to the uploaded file
        $uploadFilePath = $uploadDir . $fileName;

        // Check file type
        $allowedFileTypes = array("pdf", "doc", "docx", "txt");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedFileTypes)) {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["project_file"]["tmp_name"], $uploadFilePath)) {
                // Get project ID and freelancer name from the session
                $projectId = $_SESSION['project_id'];
                $freelancerName = $_SESSION['freelancer_name'];

                // Use prepared statements to prevent SQL injection
                $sql = "UPDATE project SET work_file = ?, work = 'Complete' WHERE project_id = ? AND freelancer_name = ? AND work = 'Pending'";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("sss", $fileName, $projectId, $freelancerName);

                    if ($stmt->execute()) {
                        echo "File uploaded successfully. Work status updated to Complete.";
                    } else {
                        echo "Error updating database: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "Error preparing the SQL statement.";
                }
            } else {
                echo "Error moving the uploaded file to the destination directory.";
            }
        } else {
            echo "Invalid file type. Allowed file types: pdf, doc, docx, txt.";
        }
    } else {
        echo "No file uploaded or an error occurred during the upload. Error code: " . $_FILES["project_file"]["error"];
    }

    // Close the database connection
    $conn->close();
}
?>



