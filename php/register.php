<?php

    include("mailAuth.php");
    
    $USERNAME;
    // validate username
    if($_POST['userName'] == "") {
        die("Please enter a username");
    }elseif(trim($_POST['userName']) != $_POST["userName"]){
        die("You may not have spaces in your username");
    }elseif(filter_var($_POST["userName"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) != $_POST["userName"]){
        die("You have used illegal characters in your username");
    }else{
        $USERNAME=$_POST["userName"];
    }
    
    //password validation
    $PASSWORD;
    if($_POST["passWord"] == ""){
        die("Please enter a password");
    }elseif(strlen($_POST["passWord"]) < 6 || strlen($_POST["passWord"]) > 25){      
        die("Please enter a password of length >= 6  length <= 25");
    }else{
        $PASSWORD = $_POST["passWord"];
    }

    //EMAIL VALIDATION
    $EMAIL;
    if($_POST["eMail"] == ""){
        die("Please enter an email adress");
    } elseif(trim($_POST["eMail"]) != $_POST["eMail"]){
        die("You may not have spaces in an email address");
    } elseif(filter_var($_POST["eMail"], FILTER_SANITIZE_EMAIL) != $_POST["eMail"]){
        die("Invalid characters in email provided");
    } elseif(!filter_var($_POST["eMail"], FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    } else {
        $EMAIL = $_POST["eMail"];
    }

    
    //connection parameters
    $configParams = include("configs/config.php");
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

    //check for email collisions
    $sql = mysqli_prepare($conn, "SELECT * FROM admin WHERE Email= ?");
    mysqli_stmt_bind_param($sql, "s", $EMAIL);
    mysqli_stmt_execute($sql);
    while(mysqli_stmt_fetch($sql)){
        die("A user already exists with that email");
    }
    mysqli_stmt_close($sql);

    //check for username collisions
    $sql = mysqli_prepare($conn, "SELECT * FROM admin WHERE Username= ?");
    mysqli_stmt_bind_param($sql, "s", $USERNAME);
    mysqli_stmt_execute($sql);
    while(mysqli_stmt_fetch($sql)){
        die("A user already exists with that username");
    }
    mysqli_stmt_close($sql);

    //USERNAME IS VALID ----------------------------------

    //generate verification key
    $key = random_int(0, 999999);
    $keyStr = strval($key);
    $keyLen = strlen($keyStr);

    $diff = 6 - $keyLen;
    for($i = $diff; $i > 0; $i --){
        $keyStr = "0" . $keyStr;
    }


    //PLACE RECORD OF USER IN UNVERIFIED USERS TABLE
    $saltedPassword = createhash($USERNAME, $PASSWORD, $conn);
    $sql = mysqli_prepare($conn, "INSERT INTO unverifiedusers (Username, Hash, Email, verifKey) VALUES(?, ?, ?, ?)");
    mysqli_stmt_bind_param($sql, "ssss", $USERNAME, $saltedPassword, $EMAIL, $keyStr);
    mysqli_stmt_execute($sql);

    if (mysqli_stmt_affected_rows($sql) <= 0){
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }else{
        echo "New record created successfully";

    }
    
    //SEND AUTHENTICATION EMAIL TO USER
    authenticate($EMAIL, $USERNAME, $keyStr);

    mysqli_close($conn);
    //cant change header as smtp has altered it already
    header("Location:../views/verify.php?email=$EMAIL");


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