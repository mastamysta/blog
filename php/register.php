<?php
    //values posted for html login form
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    $EMAIL = $_POST["eMail"];
    
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
    $saltedPassword = createhash($USERNAME, $PASSWORD, $conn);
    $sql = "INSERT INTO admin (Username, Hash, Email) VALUES('" . $USERNAME . "', '" . $saltedPassword . "', '" . $EMAIL . "')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

  

    mysqli_close($conn);


    function createHash($username, $plaintext, $conn) {
        $newSalt = utf8_encode(random_bytes(16));
        $newHash = hash_hmac("sha256", $plaintext, $newSalt);
        $newStoredVal = $newSalt . "$" . utf8_encode($newHash);
        echo($newStoredVal);

        return $newStoredVal;
    }
   
?>