<?php
require "functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);

 
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

     $hash = hash('sha256',$password);

        if($hash === $hashed_password){
            
            $_SESSION['info'] = $row;
            header("Location: profile.php");
            die;
        } else {
            // header("Location: login.php");
            $error = "Wrong email or password";
        }
    } else {
        // header("Location: login.php");
        $error = "Wrong email or password";
    }

    $stmt->close();
}
