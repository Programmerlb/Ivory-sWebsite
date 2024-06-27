<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - My Website</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #333;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            width: 100%;
            background-color: grey;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            top: 0;
            z-index: 1000; 
        }
        header a{
            text-decoration: none;
            color: white;
            margin: 0 15px;
        }
        .content {
            margin-top: 60px; 
            flex: 1;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <?php if(empty($_SESSION['info'])):?>
			<a href="login.php">Login</a>
			<a href="signup.php">Signup</a>
		<?php else:?>
            <?php if($_SESSION['info']['admin'] == 1): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
			<a href="logout.php">Logout</a>
		<?php endif;?>
    </header>