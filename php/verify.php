<?php

    $email;
    if($_POST['Email'] == null){
        die("You have accessed this page illegally");
    }else{
        $email = $_POST['Email'];
    }

    $key;
    if($_POST['Key'] == null){
        die("You have accessed this page illegally");
    }else{
        $key = $_POST['Key'];
    }

    //connection parameters
    $configParams = include("config.php");
    $servername = $configParams["servername"];
    $dbusername = $configParams["dbusername"];
    $dbpassword = $configParams["dbpassword"];
    $dbName = $configParams["dbName"];

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
    mysqli_set_charset($conn, 'utf8');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = mysqli_prepare($conn, "SELECT verifKey FROM unverifiedusers WHERE Email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    $keyResult;
    mysqli_stmt_bind_result($sql, $keyResult);
    mysqli_stmt_execute($sql);
    $count = 0;
    while(mysqli_stmt_fetch($sql)){
        $count += 1;
    }

    if($count == 0){
        die("No unverified users found with that email");
    }elseif($count > 1){
        die("Fatal Error: multiple unverified users with that email - please contact an administrator");
    }elseif($keyResult != $key){
        die("Your verification key is not valid");
    }else{
        mysqli_stmt_close($sql);
        //EMAIL AND KEY MATCH DO THIS

        //GET DETAILS OF USERNAME AND PASSWORD FROM UNVERIFIED USER TABLE
        $sql = mysqli_prepare($conn, "SELECT Username, Hash FROM unverifiedusers WHERE Email= ?");
        mysqli_stmt_bind_param($sql, "s", $email);
        $usernameResult;
        $hashResult;
        mysqli_stmt_bind_result($sql, $usernameResult, $hashResult);
        mysqli_stmt_execute($sql);
        mysqli_stmt_fetch($sql);
        mysqli_stmt_close($sql);

        //DELETE RECORD FROM UNVERIFIED USER TABLE
        $sql = mysqli_prepare($conn, "DELETE FROM unverifiedusers WHERE Email=?");
        mysqli_stmt_bind_param($sql, "s", $email);
        mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);

        //INSERT USER DETAILS INTO VERIFIED USER TABLE
        $sql = mysqli_prepare($conn, "INSERT INTO admin (Email, Username, Hash) VALUES (? ,? ,?)");
        mysqli_stmt_bind_param($sql, "sss", $email, $usernameResult, $hashResult);
        mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);
        echo("Your email has been verified");
        header("Location:../views/login.php");
    }

    

    
?>