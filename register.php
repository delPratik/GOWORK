<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f2f2f2;
    }

    .background-pattern {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .pattern-1 {
      background-image: radial-gradient(circle, #F3D250 0%, #F18F43 100%);
      opacity: 0.3;
    }

    .pattern-2 {
      background-image: radial-gradient(circle, #72B7D2 0%, #3970A8 100%);
      opacity: 0.3;
    }

    .pattern-3 {
      background-image: radial-gradient(circle, #F18F43 0%, #D92752 100%);
      opacity: 0.3;
    }

    .btn-big {
      padding: 20px 40px;
      font-size: 24px;
      margin-top: 20px;
      background-color: green;
      border-color: green;
      width: 300px;
      height: 100px;
      border-radius: 20px;
    }

    .big-font {
      font-size: 36px;
      font-weight: bold;
      margin-top: 50px;
      margin-bottom: 20px;
    }

    .center-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: calc(75vh - 250px);
    }
  </style>
</head>

<body>
  <div class="background-pattern pattern-1"></div>
  <div class="background-pattern pattern-2"></div>
  <div class="background-pattern pattern-3"></div>

  <div class="container">
    <div class="text-center">
      <h1 class="big-font">WELCOME TO GOWORK REGISTRATION</h1>
      <p style="margin-bottom: 30px;">GOWORK is a platform connecting clients with talented freelancers. Join us today
        and unlock new opportunities! Whether you are a client looking for top-notch professionals or a freelancer
        seeking exciting projects, GOWORK is the place to be. Our platform provides a seamless experience for both
        clients and freelancers, ensuring efficient collaboration and successful outcomes.</p>

        <p style="margin-bottom: 30px;">GOWORK is not just a freelance workplace; 
        it is a platform designed to unlock and unleash your professional capabilities.
         Whether you are a freelancer seeking new opportunities or a client looking for top talent, 
         GOWORK provides the tools and resources to help you excel in your endeavors.</p>
    </div>
    <div class="center-content">
      <a href="register_client.php" class="btn btn-primary btn-big">Register as Client</a>
      <a href="register_freelancer.php" class="btn btn-primary btn-big">
        <span style="display: flex; align-items: center; justify-content: center; height: 100%;">
          Register as Freelancer
        </span>
      </a>
    </div>
  </div>
</body>

</html>
