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

    <!--get url params if they exist (email and key if following email link)-->
    <?php
      $email;
      $key;
      $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
      $url_components;

      //if url params arent null, parse them
      if($_SERVER['QUERY_STRING'] == NULL){
            $email = "";
            $key = "";
      } else{
        $url_components = parse_url($url);
      
        parse_str($url_components['query'], $params); 

        //if email param is not null put it into var
        if($params['email'] != null){
            $email = $params['email']; 
        }else{
            $email = "";
        }

        //if key param is not null put it into var
        if($params['key'] != null){
            $key = $params['key'];
        }else{
            $key = "";
        }
      }

      

    ?>

    <!--USER VERIFICATION FORM-->
    <div class="container p-5">
      <h1>Verify Your Account</h1>
      <p>A verification email has been sent to the email address you provided...</p>
      <form action="../php/verify.php" method="POST">
        <div class="form-group">
          <label for="username">Email</label>
          <?php echo('<input type="text" name="Email" id="email" class="form-control" value="'. $email .'" aria-describedby="pwHelpText">')?>
          <small id="unHelpText" class="text-muted">Enter Your Email Here</small>
        </div>
        <div class="form-group">
          <label for="password">Verification Key</label>
          <?php echo('<input type="text" name="Key" id="key" class="form-control" value="'. $key .'" aria-describedby="pwHelpText">')?>
          <small id="pwHelpText" class="text-muted">Enter Your Verification Key Here</small>
        </div>
        <button type="submit" class="btn btn-dark">Verify</button>
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
