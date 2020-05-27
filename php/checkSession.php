<?php

//connection parameters
$servername = "localhost:3308";
$dbusername = "root";
$dbpassword = "";
$dbName = "adminaccounts";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
mysqli_set_charset($conn, 'utf8');
checkSession($conn);

    function checkSession($conn){
        $sql = mysqli_prepare($conn, "SELECT Email FROM sessions WHERE SessionID= ?");
        $sessionID = session_id();
        echo($sessionID);
        mysqli_stmt_bind_param($sql, "i", $sessionID);
        $emailResult;
        mysqli_stmt_execute($sql);
        mysqli_stmt_bind_result($sql, $emailResult);
        $count = 0;
        while(mysqli_stmt_fetch($sql)){
            $count += 1;
            echo($count);
        }

        if($count == 1){
            echo("WElcome back You");
            //TODO CHANGE THIS TO BE A DIFFERENT FILE
            //header("Location: anotherDirectory/anotherFile.php");
        }elseif($count > 1){
            die("A session error was encountered");
        }else{
            echo($emailResult);
            echo("yeetos");
        }

        mysqli_stmt_close($sql);
    }
?>