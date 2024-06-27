<?php 
    require "functions.php"; 
    check_login();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_id = $_SESSION['info']['id'];
        $content = addslashes($_POST['post']);
    
        if (!empty($content)) {
            $query = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
            mysqli_query($conn, $query);
        }
    
        header("Location: index.php");
        die;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $email, $_SESSION['info']['id']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['info']['username'] = $username;
            $_SESSION['info']['email'] = $email;
            $message = "Profile updated successfully.";
        } else {
            $message = "No changes made or error occurred.";
        }
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['info']['id']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            session_destroy();
            header("Location: signup.php");
            die;
        } else {
            $message = "Error deleting profile.";
        }
        $stmt->close();
    }
    
?>

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
            justify-content: center;
            align-items: center;
            height: calc(100vh - 130px);
        }
        .container {
            width: 100%;
            height: calc(100vh - 130px);
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: auto;
        }
        .user-profile {
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .user-profile table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .user-profile th, .user-profile td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        .user-profile th {
            background-color: #333;
            color: #fff;
        }
        .user-profile td {
            background-color: #eee;
            color: #333;
        }
        .form-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form {
            width: 100%;
            max-width: 300px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        button {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: grey;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .update{
            display: flex;
            gap: 2px;
        }
    </style>
</head>
<body>
    <?php require_once "header.php";?>

    <div class="container">
        <div class="user-profile">
            <h2>User Profiles</h2>
            <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <tr>
                    <td><?php echo $_SESSION['info']['username']; ?></td>
                    <td><?php echo $_SESSION['info']['email']; ?></td>
                </tr>
            </table>
            <form method="post" class="update">
                <button type="button" onclick="document.getElementById('edit-profile').style.display='block'">Edit Profile</button>
                <button type="submit" name="delete">Delete Profile</button>
            </form>
        </div>

        <div class="form-container" id="edit-profile" style="display:none;">
            <div class="form">
                <h2>Edit Profile</h2>
                <form method="post">
                    <input type="text" name="username" value="<?php echo $_SESSION['info']['username']; ?>" required>
                    <input type="email" name="email" value="<?php echo $_SESSION['info']['email']; ?>" required>
                    <button type="submit" name="update">Update</button>
                </form>
            </div>
        </div>

        <div class="form-container">
            <div class="form">
                <h2>Post Something</h2>
                <form method="post">
                    <textarea name="post" rows="8" placeholder="Enter your post here..."></textarea>
                    <button type="submit">Post</button>
                </form>
            </div>
        </div>
    </div>

    <?php require_once "footer.php";?>
</body>
</html>
