<?php

function getSessionName($email){
    //connection parameters
    $configParams = include("configs/config.php");
    $servername = $configParams["servername"];
    $dbusername = $configParams["dbusername"];
    $dbpassword = $configParams["dbpassword"];
    $dbName = $configParams["dbName"];

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
    mysqli_set_charset($conn, 'utf8');

    //Create query
    $sql = mysqli_prepare($conn, "SELECT Username FROM admin WHERE Email= ?");
    mysqli_stmt_bind_param($sql, "s", $email);
    $userNameResult;

    //Execute query
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $userNameResult);

    //Count results
    $count = 0;
    while(mysqli_stmt_fetch($sql)){
        $count += 1;
    }

    if($count == 1){
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        return $userNameResult;
    }else{
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        die("A session error was encountered");
    }
}

?>