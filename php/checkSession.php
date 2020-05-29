<?php
session_start();



    //returns false if session doesnt correspond  to an active user,
    //ptherwise returns corresponding user email
    function checkSession(){
        //connection parameters
        $servername = "localhost:3308";
        $dbusername = "root";
        $dbpassword = "";
        $dbName = "adminaccounts";

        // Create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
        mysqli_set_charset($conn, 'utf8');

        //Create query
        $sql = mysqli_prepare($conn, "SELECT Email FROM sessions WHERE SessionID= ?");
        $sessionID = session_id();
        mysqli_stmt_bind_param($sql, "i", $sessionID);
        $emailResult;

        //Execute query
        mysqli_stmt_execute($sql);
        mysqli_stmt_bind_result($sql, $emailResult);

        //Count results
        $count = 0;
        while(mysqli_stmt_fetch($sql)){
            $count += 1;
        }

        if($count == 1){
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            return $emailResult;
        }elseif($count > 1){
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