<?php
    //values posted for html login form
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    
    //connection parameters
    $servername = "localhost:3308";
    $dbusername = "root";
    $dbpassword = "";
    $dbName = "adminaccounts";


    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbName);
    mysqli_set_charset($conn, 'utf8');


    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    //create SQL query
    $sql = "SELECT Hash FROM admin WHERE Username='" . $USERNAME . "'";
    $result = mysqli_query($conn, $sql);
    $oldHash;

    //get hash for username provided
    if (mysqli_num_rows($result) > 0){
        $oldHash = (mysqli_fetch_assoc($result))["Hash"];
        if(checkHash($oldHash, $PASSWORD)){
            echo("password valid updating hash to: <br>");
            updateHash($USERNAME, $PASSWORD, $conn);
        }else{
            die("Invalid Password");
        }
    }else{
        mysqli_close($conn);
        die("no matching usernames<br>");
    }

    mysqli_close($conn);

    function checkHash($hash, $password){

        $parts = explode("$", $hash);
        $oldSalt = $parts[0];
        $oldHash = $parts[1];

        $checkHash = $oldSalt . "$" . utf8_encode(hash_hmac("sha256", $password, $oldSalt));
        echo("OLD HASH : " . $hash . "<br>");
        echo("NEW HASH : " . $checkHash . "<br>");

        if ($checkHash == $hash){
            return true;
        }else{
            return false;
        }
    }

    function updateHash($username, $plaintext, $conn) {
        $newSalt = utf8_encode(random_bytes(16));
        $newHash = utf8_encode(hash_hmac("sha256", $plaintext, $newSalt));
        $newStoredVal = $newSalt . "$" . $newHash;
        echo($newStoredVal);

        //will be used to update hash for each login once fully implimented
        $sql = "UPDATE admin SET Hash='" . $newStoredVal . "' WHERE Username='" . $username . "'";
        $result = mysqli_query($conn, $sql);
    }
   
?>