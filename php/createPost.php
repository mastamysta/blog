<?php
include("checkSession.php");

if(!checkSession()){
    die("A sesion error occurred");
}else{
    createPost();
    header("Location:../index.php");
}

    //returns false if session doesnt correspond  to an active user,
    //ptherwise returns corresponding user email
    function createPost(){
        //connection parameters
        $servername = "localhost:3308";
        $dbusername = "root";
        $dbpassword = "";
        $dbName = "adminaccounts";

        // Create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
        mysqli_set_charset($conn, 'utf8');

        //Create query
        $sql = mysqli_prepare($conn, "INSERT INTO `posts` (`PostID`, `Email`, `Content`, `Time`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP);");
        $email = checkSession();
        $content = $_POST["Content"];
        mysqli_stmt_bind_param($sql, "ss", $email, $content);

        //Execute query
        mysqli_stmt_execute($sql);

        if(mysqli_stmt_affected_rows($sql) <= 0){
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            die("Post was not created");
        }else{
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            return false;
        }
    }
?>