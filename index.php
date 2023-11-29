<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GOWORK - Freelance Platform</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #000;
      margin-top: 10px;
    }

    .hero {
      height: 80vh;
      display: flex;
      align-items: center;
    }

    .hero-content {
      color: #000;
    }

    .hero-image {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .hero-image img {
      max-width: 100%;
      height: auto;
    }

    .how-it-works {
      text-align: center;
    }

    .how-it-works h2 {
      margin-bottom: 30px;
    }

    .footer {
      background-color: #000;
      color: #fff;
      padding: 20px 0;
    }

    .footer p {
      margin-bottom: 0;
    }

    .footer-nav {
      list-style-type: none;
      padding: 0;
      display: flex;
      justify-content: flex-end;
    }

    .footer-nav li {
      margin-left: 10px;
    }

    .footer-nav li:first-child {
      margin-left: 0;
    }

    .footer-nav a {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">GOWORK</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Browse Jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log In</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="row">
        <div class="col-md-6 hero-content">
          <h1>Welcome to GOWORK</h1>
          <p>Find the best freelancers or freelance projects to work on.</p>
          <a href="register.php" class="btn btn-primary">Get Started</a>
        </div>
        <div class="col-md-6 hero-image">
          <img src="freelance.png" alt="Freelance Photo">
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">How It Works</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <h4>Search</h4>
          <p>Browse and search for freelancers or projects based on your requirements.</p>
        </div>
        <div class="col-md-4">
          <h4>Hire</h4>
          <p>Hire the most suitable freelancer for your project or get hired for freelance work.</p>
        </div>
        <div class="col-md-4">
          <h4>Collaborate</h4>
          <p>Collaborate and communicate with freelancers or clients to successfully complete projects.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer mt-auto">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2023 GOWORK. All rights reserved.</p>
        </div>
        <div class="col-md-6">
          <ul class="footer-nav">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
