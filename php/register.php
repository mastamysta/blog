<?php
    //values posted for html login form
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    $EMAIL = $_POST["eMail"];
    
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

    if($EMAIL != "benjamin-read@hotmail.co.uk"){
        die("You are not permitted to make an account");
    }

    //create SQL query
    $saltedPassword = createhash($USERNAME, $PASSWORD, $conn);
    $sql = mysqli_prepare($conn, "INSERT INTO admin (Username, Hash, Email) VALUES(?, ?, ?)");
    mysqli_stmt_bind_param($sql, "sss", $USERNAME, $saltedPassword, $EMAIL);
    mysqli_stmt_execute($sql);

    if (mysqli_stmt_affected_rows($sql) <= 0){
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }else{
        echo "New record created successfully";

    }

  

    mysqli_close($conn);
    header("Location:../views/login.php");


    function createHash($username, $plaintext, $conn) {
        $newSalt = utf8_encode(random_bytes(16));
        $newSalt = checkSalt($newSalt);
        $newHash = hash_hmac("sha256", $plaintext, $newSalt);
        $newStoredVal = $newSalt . "$" . utf8_encode($newHash);
        echo($newStoredVal);

        return $newStoredVal;
    }

    function checkSalt($salt){
        $newSalt = "";
        for($i = 0; $i <= strlen($salt) - 1; $i ++){
            if($salt[$i] == '$'){
                echo("removed a $ error");
                $newSalt = utf8_encode(random_bytes(16));
                return checkSalt($newSalt);
            }
        }
        return $salt;
    }
   
?>