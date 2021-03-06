<!doctype html>
<html>
  <?php
    include("../php/checkSession.php");
    if(!checkSession()){

    }else{
      header("Location: ../index.php");
    }
  ?>
  <head>
    <meta charset="utf-8">

    <title>Ben Read</title>
    <meta name="Ben Read's development blog" content="The HTML5 Herald">
    <meta name="Ben Read" content="SitePoint">
  </head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="../script/jquery-3.5.1.js"></script>
  <body>

    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="collapse navbar-collapse">
        <ul class="mr-auto navbar-nav">
          <li class="nav-item active">
            <a href="../index.php" class="nav-link">
              Blog
            </a>
          </li>
          <li class="nav-item disabled">
            <a href="portfolio.php" class="nav-link disabled">
              Portolio
            </a>
          </li>
          <li class="nav-item active">
            <a href="contact.php" class="nav-link">
              Contact Me
            </a>
          </li>
          <li class="nav-item active">
            <a href="register.php" class="nav-link">
              Blog Admin Registration
            </a>
          </li>
          <li class="nav-item active">
            <a href="login.php" class="nav-link">
              Admin Login
            </a>
          </li>
        </ul>
      </div>
    </nav>


    <!--ADMINISTRATOR LOGIN FORM-->
    <div class="container p-5">
      <h1>Administrator Login</h1>
      <form action="../php/login.php" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="userName" id="username" class="form-control" placeholder="Username" aria-describedby="unHelpText">
          <small id="unHelpText" class="text-muted">Enter Your Username Here</small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="passWord" id="password" class="form-control" placeholder="Password" aria-describedby="pwHelpText">
          <small id="pwHelpText" class="text-muted">Enter Your Password Here</small>
        </div>
        <button type="submit" class="btn btn-dark">Login</button>
      </form>
    </div>


    <!--GITHUB LINK -->
    <nav class="navbar fixed-bottom navbar-dark bg-dark justify-content-center">
      <a class="navbar-brand" href="https://github.com/mastamysta">
        <img src="../res/GitHub-Mark-Light-120px-plus.png" alt="GitHub Logo" class="w-25">
      </a>
    </div>
  </nav>
  </body>
</html>
