<?php
include("getUserNameByEmail.php");
//returns false if session doesnt correspond  to an active user,
//ptherwise returns corresponding user email
function getPosts($date){
    //connection parameters
    $configParams = include("configs/config.php");
    $servername = $configParams["servername"];
    $dbusername = $configParams["dbusername"];
    $dbpassword = $configParams["dbpassword"];
    $dbName = $configParams["dbName"];

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
    mysqli_set_charset($conn, 'utf8');

    //get time (UNIX)
    // $time = include("time.php");
    // echo($time['y'] . "<br>");
    // echo($time['h'] . ":");
    // echo($time['m']  . ":");
    // echo($time['s']);

    //Create query
    $sql = mysqli_prepare($conn, "SELECT * FROM posts WHERE Time >= ? AND Time <= ?");
 //   $sql = mysqli_prepare($conn, "SELECT * FROM posts");
    $d1 = $date  . " 00:00:01";
    $d2 = $date . " 23:59:59";
    mysqli_stmt_bind_param($sql,"ss" ,$d1, $d2);
    $sessionID = session_id();
    $postIDResult;
    $emailResult;
    $contentResult;
    $timeResult;

    //Execute query
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $postIDResult ,$emailResult, $contentResult, $timeResult);

    //Count results
    $count = 0;
    while(mysqli_stmt_fetch($sql)){
        $count += 1;
        //produce appropriate html code to display post entries
        $pre = ('
        <div class="jumbotron p-5 m-5">
            <h2 class="display-5">
        ');
        $emailandtime = getUserNameByEmail($emailResult) . ' at: ' . $timeResult;
        $mid = ('
        </h2>
            <hr class="my-2">
            <p>
        ');
        $post = ('
        </p>
        </div>
        ');
        echo($pre);
        echo htmlspecialchars($emailandtime, ENT_QUOTES, 'UTF-8');
        echo($mid);
        echo htmlspecialchars($contentResult, ENT_QUOTES, 'UTF-8');
        echo($post);
    }

        mysqli_stmt_close($sql);

        //if there are less than three results cycle back through time and print out more --------------------------------------

        $sql = mysqli_prepare($conn, "SELECT * FROM posts WHERE Time >= ? AND Time <= ?");
        $postIDResult;
        $emailResult;
        $contentResult;
        $timeResult;

        $dateObject = date_create($date);
        $dayBefore;


        while($count <= 3){
          //this is pseudocode
          $dayBefore = date_sub($dateObject, date_interval_create_from_date_string("1 day"));
          $dayBeforeString = $dayBefore->format('Y-m-d');
          $d1 = $dayBeforeString  . " 00:00:01";
          $d2 = $dayBeforeString . " 23:59:59";
          mysqli_stmt_bind_param($sql,"ss" ,$d1, $d2);
          $sessionID = session_id();
          mysqli_stmt_execute($sql);
          mysqli_stmt_bind_result($sql, $postIDResult ,$emailResult, $contentResult, $timeResult);

          while(mysqli_stmt_fetch($sql)){
              $count += 1;
              //produce appropriate html code to display post entries
              $pre = ('
              <div class="jumbotron p-5 m-5">
                  <h2 class="display-5">
              ');
              $emailandtime = getUserNameByEmail($emailResult) . ' at: ' . $timeResult;
              $mid = ('
              </h2>
                  <hr class="my-2">
                  <p>
              ');
              $post = ('
              </p>
              </div>
              ');
              echo($pre);
              echo htmlspecialchars($emailandtime, ENT_QUOTES, 'UTF-8');
              echo($mid);
              echo htmlspecialchars($contentResult, ENT_QUOTES, 'UTF-8');
              echo($post);
          }

        }

        mysqli_stmt_close($sql);
        mysqli_close($conn);
}
?>
