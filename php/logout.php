<?php
include("checkSession.php");
$email = checkSession();
logout($email);
//function to logout user with provided email
function logout($email){
    //connection parameters
    $servername = "localhost:3308";
    $dbusername = "root";
    $dbpassword = "";
    $dbName = "adminaccounts";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
    mysqli_set_charset($conn, 'utf8');

    //Create query
    $sql = mysqli_prepare($conn, "DELETE FROM sessions WHERE Email= ?");
    mysqli_stmt_bind_param($sql, "s", $email);
    
    //Change session id
    $id = random_int(0, 2147483647);
    session_id($id);

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