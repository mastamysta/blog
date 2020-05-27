<?php
    $USERNAME = $_POST["userName"];
    $PASSWORD = $_POST["passWord"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    echo("memes");

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

?>