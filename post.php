<?php
require "functions.php";
check_login();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['info']['id'];
    $content = addslashes($_POST['post']);

    if (!empty($content)) {
        $query = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: index.php");
            die;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Post content cannot be empty.";
    }
}