<?php
    //values posted for html login form
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    
    //connection parameters
    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbName = "adminaccounts";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);


    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully<br>";

    //create SQL query
    $sql = "SELECT Hash FROM admin WHERE Username='" . $USERNAME . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
            echo((mysqli_fetch_assoc($result))["Hash"] . "<br>");
    }else{
        echo("no matching usernames<br>");
    }


    mysqli_close($conn);
    echo "Session Closed<br>";

?>