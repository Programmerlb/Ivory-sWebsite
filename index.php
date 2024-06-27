<?php 
require "functions.php"; 
check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            width: 100%;
            margin: 70px;
        }
        .post-form, .post-list {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .post-form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .post-form button {
            background-color: #333;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .post-form button:hover {
            background-color: grey;
        }
        .post-list .post {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .post-list .post:last-child {
            border-bottom: none;
        }
        .post-list .post .username {
            font-weight: bold;
            font-size: 12px;
            color: black;
        }
        .post-list .post .content {
            margin: 4px;
            color: black;
        }
        .post-list .post .date {
            color: #999;
            font-size: 0.9em;
        }

    </style>
</head>
<body>
    <?php require_once "header.php";?>

    <div class="container">
        <div class="post-form">
            <form action="post.php" method="post">
                <textarea name="post" placeholder="What's on your mind?" required></textarea>
                <button type="submit">Post</button>
            </form>
        </div>

        <div class="post-list">
            <h2>Posts</h2>
            <?php
            $query = "SELECT posts.content, posts.date, users.username 
                      FROM posts 
                      JOIN users ON posts.user_id = users.id 
                      ORDER BY posts.date DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="post">';
                    echo '<p class="username">' . htmlspecialchars($row['username']) . '</p>';
                    echo '<p style="color:black" class="content">' . htmlspecialchars($row['content']) . '</p>';
                    echo '<p class="date">' . htmlspecialchars($row['date']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No posts found</p>';
            }
            ?>
        </div>
    </div>

    <?php require_once "footer.php";?>
</body>
</html>
