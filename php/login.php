<?php
    $id = random_int(0, 2147483647);
    session_id($id);
    session_start();

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
    $sql = mysqli_prepare($conn, "SELECT Hash, eMail FROM admin WHERE Username= ?");
    mysqli_stmt_bind_param($sql, "s", $USERNAME);
    $resultHash;
    $resultEmail;
    
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $resultHash, $resultEmail);
    $count = 0;
    while (mysqli_stmt_fetch($sql)) {
        $count += 1;
    }
    
    //get hash for username provided
    $oldHash;
    if ($count == 1){
        $oldHash = $resultHash;
        $email = $resultEmail;
        if(checkHash($oldHash, $PASSWORD)){
            echo("password valid updating hash to: <br>");
            updateHash($USERNAME, $PASSWORD, $conn);
            logSession($email, $conn);
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

    function logSession($userEmail, $conn){
        //check for an existing session and deleting those that exist
        $sql = mysqli_prepare($conn, "DELETE FROM sessions WHERE Email= ?");
        mysqli_stmt_bind_param($sql, "s", $userEmail);
        mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);

        //create new session record
        $id = session_id();
        $sql2 = mysqli_prepare($conn, "INSERT INTO sessions (SessionID, Email) VALUES (?, ?)");
        mysqli_stmt_bind_param($sql2, "is", $id, $userEmail);
        mysqli_stmt_execute($sql2);
        mysqli_stmt_close($sql2);
        echo("Session ID: " . session_id() . "<br>");
    }

    function updateHash($username, $plaintext, $conn) {
        $newSalt = utf8_encode(random_bytes(16));
        $newSalt = checkSalt($newSalt);
        $newHash = utf8_encode(hash_hmac("sha256", $plaintext, $newSalt));
        $newStoredVal = $newSalt . "$" . $newHash;
        echo($newStoredVal . "<br>");

        //will be used to update hash for each login once fully implimented
        $sql = mysqli_prepare($conn, "UPDATE admin SET Hash= ? WHERE Username= ?");
        mysqli_stmt_bind_param($sql, "ss", $newStoredVal, $username);
        mysqli_stmt_execute($sql);
    }

    function checkSalt($salt){
        $newSalt = "";
        for($i = 0; $i <= strlen($salt) - 1; $i ++){
            if($salt[$i] == '$'){
                echo("removed a $ error<br>");
                $newSalt = utf8_encode(random_bytes(16));
                return checkSalt($newSalt);
            }
        }
        return $salt;
    }
   
?>