<?php
include("getUserNameByEmail.php");
//returns false if session doesnt correspond  to an active user,
//ptherwise returns corresponding user email
function getPosts(){
    //connection parameters
    $configParams = include("config.php");
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

    //get date
    $date = include("date.php");
    $today = $date . " 00:00:01";


    //Create query
    $sql = mysqli_prepare($conn, "SELECT * FROM posts WHERE Time >= ?");
 //   $sql = mysqli_prepare($conn, "SELECT * FROM posts");
    mysqli_stmt_bind_param($sql,"s" ,$today);
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
        echo('
        <div class="jumbotron p-5 m-5">
            <h2 class="display-5">' . getUserNameByEmail($emailResult) . ' at: '. $timeResult. '</h2>
            <hr class="my-2">
            <p>' . $contentResult . '</p>
        </div>
        ');
    }

        mysqli_stmt_close($sql);
        mysqli_close($conn);
}
?>