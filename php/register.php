<?php
    //values posted for html login form


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
        
    $PASSWORD;
    if($_POST["passWord"] != ""){
        filter_var($password, FILTER_VALIDATE_REGEXP, array( "options"=> array( "regexp" => "/.{6,25}/")));
    }else{
        die("Please enter a password");
    }

    //EMAIL VALIDATION
    $EMAIL;
    if($_POST["eMail"] != ""){
        $EMAIL = trim($_POST["eMail"]);
        $EMAIL = filter_var($EMAIL, FILTER_SANITIZE_EMAIL);
    }
    if (filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
        echo("$EMAIL is a valid email address");
    } else {
        die("Invalid email please try again...");
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

    if($EMAIL != "benjamin-read@hotmail.co.uk"){
        die("You are not permitted to make an account");
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