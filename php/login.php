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
    $sql = mysqli_prepare($conn, "SELECT Hash FROM admin WHERE Username= ?");
    mysqli_stmt_bind_param($sql, "s", $USERNAME);
    $result;
    
    
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    $count = 0;
    while (mysqli_stmt_fetch($sql)) {
        $count += 1;
    }

  
    //get hash for username provided
    $oldHash;
    if ($count > 0){
        $oldHash = ($result);
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
        $newSalt = checkSalt($newSalt);
        $newHash = utf8_encode(hash_hmac("sha256", $plaintext, $newSalt));
        $newStoredVal = $newSalt . "$" . $newHash;
        echo($newStoredVal);

        //will be used to update hash for each login once fully implimented
        $sql = mysqli_prepare($conn, "UPDATE admin SET Hash= ? WHERE Username= ?");
        mysqli_stmt_bind_param($sql, "ss", $newStoredVal, $username);
        mysqli_stmt_execute($sql);
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