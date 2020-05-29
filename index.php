<!doctype html>
<html>
  <?php
    include("php/checkSession.php");
    include("php/getSessionName.php");
    include("php/getPosts.php");
  ?>
  <head>
    <meta charset="utf-8">

    <title>Ben Read</title>
    <meta name="Ben Read's development blog" content="The HTML5 Herald">
    <meta name="Ben Read" content="SitePoint">
  </head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="script/jquery-3.5.1.js"></script>
  <body>

    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="collapse navbar-collapse">
        <ul class="mr-auto navbar-nav d-flex justify-content-start">
          <li class="nav-item active p-2">
            <a href="index.php" class="nav-link">
              Blog
            </a>
          </li>
          <li class="nav-item disabled p-2">
            <a href="portfolio.php" class="nav-link disabled">
              Portolio
            </a>
          </li>
          <li class="nav-item active p-2">
            <a href="views/contact.php" class="nav-link">
              Contact Me
            </a>
          </li>
          <li class="nav-item active p-2">
            <a href="views/register.php" class="nav-link">
              Blog Admin Registration
            </a>
          </li>
          <li class="nav-item active p-2">
            <a href="views/login.php" class="nav-link">
              Admin Login
            </a>
          </li>
        </ul>
        <?php
            if(!checkSession()){

            }else{
              $userName = getSessionName(checkSession());
              echo('
                <ul class="navbar-nav d-flex justify-content-end">
                  <li class="nav-item active p-2">
                    <a href="views/compose.php" class="nav-link">
                      Create a Post
                    </a>
                  </li>
                  <li class="nav-item active p-2">
                    <a href="#" class="nav-link">
                      Welcome Back ' . $userName . '
                    </a>
                  </li>
                  <li class="nav-item active p-2">
                    <form action="php/logout.php" method="post" id="form1">
                      <button id="logout-btn" class="btn btn-outline-light my-2 my-sm-0">Logout</button>
                    </form>
                  </li>
                </ul>
              ');
            }
          ?>
      </div>
    </nav>


    <!--IN DEVELOPMENT JUMBO SIGN-->
    <?php
      getPosts();
    ?>


    <!--GITHUB LINK -->
    <nav class="navbar fixed-bottom navbar-dark bg-dark justify-content-center">
      <a class="navbar-brand" href="https://github.com/mastamysta">
        <img src="res/GitHub-Mark-Light-120px-plus.png" alt="GitHub Logo" class="w-25">
      </a>
    </div>
  </nav>
  </body>
</html>
