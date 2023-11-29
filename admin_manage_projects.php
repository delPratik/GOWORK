<?php
// Database connection details
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

// Function to fetch unapproved and approved projects from the database
function fetchProjects($status)
{
    global $conn;

    $sql = "SELECT * FROM project WHERE status = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("s", $status);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) {
        die("Failed to execute statement: " . $conn->error);
    }

    $projects = array();
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }

    $stmt->close();

    return $projects;
}

// Fetch unapproved and approved projects data
$unapprovedProjects = fetchProjects("Unapproved");
$approvedProjects = fetchProjects("Approved");

// Update project status to approved if submitted
if (isset($_POST['approve'])) {
    $id = $_POST['id'];

    $sql = "UPDATE project SET status = 'Approved' WHERE project_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo '<div class="alert alert-success">Project approved successfully.</div>';
    } 
    $stmt->close();
}

// Delete project if submitted
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM project WHERE project_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo '<div class="alert alert-success">Project deleted successfully.</div>';
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Admin - GoWork</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            text-align: center;
        }


        .logout-button {
        margin-left: 10px;
        }

        .go-back-button {
        margin-left: 10px; /* Adjust the margin as needed */
        }

        .footer {
        text-align: center;
        padding: 20px;
        background-color: #f8f9fa;
        margin-top: 20px; /* Adjust the margin as needed */
        }
    </style>


<!-- JavaScript code for AJAX requests -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to handle project approval
    function approveProject(id) {
        $.ajax({
            type: "POST",
            url: "approve_project.php", 
            data: { id: id },
            success: function(data) {
                // Update the UI to reflect the success or error message
                if (data === 'success') {
                    $('#approve-result-' + id).html('<div class="alert alert-success">Project approved successfully.</div>');
                } else {
                    $('#approve-result-' + id).html('<div class="alert alert-danger">Failed to approve project.</div>');
                }
            }
        });
    }

    // Function to handle project deletion
    function deleteProject(id) {
        $.ajax({
            type: "POST",
            url: "delete_project.php",
            success: function(data) {
                // Update the UI to reflect the success or error message
                if (data === 'success') {
                    $('#delete-result-' + id).html('<div class="alert alert-success">Project deleted successfully.</div>');
                    // Remove the deleted row from the table
                    $('#row-' + id).remove();
                } else {
                    $('#delete-result-' + id).html('<div class="alert alert-danger">Failed to delete project.</div>');
                }
            }
        });
    }
</script>

<!-- ... (HTML code for the project listing tables) ... -->

</head>
<body>
    <div class="container">
        <h1>Manage Projects</h1>


        <!-- Display unapproved projects table -->
        <h2>Unapproved Projects</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Title</th>
                    <th>Category</th>
                    <th>Budget</th>
                    <th>Deadline</th>
                    <th>Description</th>
                    <th>Client Name</th>
                    <th>Perform Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($unapprovedProjects) : ?>
                    <?php foreach ($unapprovedProjects as $project) : ?>
                        <tr>
                            <td><?php echo $project['project_id']; ?></td>
                            <td><?php echo $project['project_title']; ?></td>
                            <td><?php echo $project['category']; ?></td>
                            <td><?php echo $project['budget']; ?></td>
                            <td><?php echo $project['deadline']; ?></td>
                            <td><?php echo $project['description']; ?></td>
                            <td><?php echo $project['client_name']; ?></td>
                            <td>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                     <input type="hidden" name="id" value="<?php echo $project['project_id']; ?>">
                                     <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                     <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No unapproved projects found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Display approved projects table -->
        <h2>Approved Projects</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Title</th>
                    <th>Category</th>
                    <th>Budget</th>
                    <th>Deadline</th>
                    <th>Description</th>
                    <th>Client Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($approvedProjects) : ?>
                    <?php foreach ($approvedProjects as $project) : ?>
                        <tr>
                            <td><?php echo $project['project_id']; ?></td>
                            <td><?php echo $project['project_title']; ?></td>
                            <td><?php echo $project['category']; ?></td>
                            <td><?php echo $project['budget']; ?></td>
                            <td><?php echo $project['deadline']; ?></td>
                            <td><?php echo $project['description']; ?></td>
                            <td><?php echo $project['client_name']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">No approved projects found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <a href="logout.php" class="btn btn-success logout-button">Logout</a>
        <a href="admin.php" class="btn btn-success go-back-button">Go Back</a>
    </div> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
