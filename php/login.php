<?php
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    
    $servername = "localhost:3308";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password);


    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully\n";

    mysqli_close($conn);
    echo "Session Closed\n";

?>