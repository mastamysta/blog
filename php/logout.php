<?php
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
    mysqli_stmt_bind_param($sql, "i", $email);

    //Execute query
    mysqli_stmt_execute($sql);
    

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