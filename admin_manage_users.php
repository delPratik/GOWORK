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

// Function to fetch user data from the database
function fetchUsers($table)
{
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    } else {
        return false;
    }
}

// Function to delete user data from the database
function deleteUser($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE {$table}_id = $id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Fetch client and freelancer data
$clients = fetchUsers("client");
$freelancers = fetchUsers("freelancer");

// Delete user data if submitted
if (isset($_POST['delete'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];

    if (deleteUser($table, $id)) {
        echo '<div class="alert alert-success">User deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to delete user.</div>';
    }
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
</head>

<body>
    <div class="container">
        <h1>Manage Users</h1>

        <!-- Display clients table -->
        <h2>Clients</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Perform Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($clients) : ?>
                    <?php foreach ($clients as $client) : ?>
                        <tr>
                            <td><?php echo $client['client_id']; ?></td>
                            <td><?php echo $client['name']; ?></td>
                            <td><?php echo $client['age']; ?></td>
                            <td><?php echo $client['address']; ?></td>
                            <td><?php echo $client['phone_number']; ?></td>
                            <td><?php echo $client['email']; ?></td>
                            <td>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="table" value="client">
                                    <input type="hidden" name="id" value="<?php echo $client['client_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">No clients found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Display freelancers table -->
        <h2>Freelancers</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Perform Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($freelancers) : ?>
                    <?php foreach ($freelancers as $freelancer) : ?>
                        <tr>
                            <td><?php echo $freelancer['freelancer_id']; ?></td>
                            <td><?php echo $freelancer['name']; ?></td>
                            <td><?php echo $freelancer['age']; ?></td>
                            <td><?php echo $freelancer['address']; ?></td>
                            <td><?php echo $freelancer['phone_number']; ?></td>
                            <td><?php echo $freelancer['email']; ?></td>
                            <td>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="table" value="freelancer">
                                    <input type="hidden" name="id" value="<?php echo $freelancer['freelancer_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">No freelancers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <a href="logout.php" class="btn btn-success logout-button">Logout</a>
        <a href="admin.php" class="btn btn-success go-back-button">Go Back</a>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
