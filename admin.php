<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('admin.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: repeat;
    }
    
    .container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: none;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    
    h1 {
      font-size: 30px;
      color: white;
      margin-bottom: 20px;
    }
    
    .button {
      margin: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome, Admin!</h1>
    <a href="admin_manage_users.php" class="btn btn-primary btn-lg btn-block button">Manage Users</a>
    <a href="admin_manage_projects.php" class="btn btn-success btn-lg btn-block button">Manage Projects</a>
    <a href="logout.php" class="btn btn-danger btn-lg btn-block button">Logout</a>
  </div>
</body>
</html>
