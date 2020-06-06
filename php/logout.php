<?php
include("checkSession.php");
$email = checkSession();
logout($email);
header("Location:../views/login.php");

//function to logout user with provided email
function logout($email){
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
    $sql = mysqli_prepare($conn, "DELETE FROM sessions WHERE Email= ?");
    mysqli_stmt_bind_param($sql, "s", $email);

    //Execute query
    mysqli_stmt_execute($sql);

    if(mysqli_stmt_affected_rows($sql) <= 0){
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        die("A session error was encountered");
    }else{
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        return false;
    }
}
?>