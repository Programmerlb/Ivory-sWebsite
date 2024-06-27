

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - My Website</title>
    <style>
        * {
            padding: 0px;
            margin: 0px;
        }
        a {
            text-decoration: none;
        }
        body {
            background-color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header div {
            padding: 20px;
        }
        header a {
            color: white;
        }
        header {
            display: flex;
            background-color: grey;
            color: white;
            justify-content: center;
            align-items: center;
            gap: 22px;
        }
        footer {
            padding: 20px;
            text-align: center;
            background-color: #eee;
            margin-top: auto;
        }
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }
        .form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        .form h2 {
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php require_once "header.php";?>

    <div class="form-container">
        <div class="form">
            <h2>Log In</h2>
            <form method="post" action="./lgin.php">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>

    <?php require_once "footer.php";?>
</body>
</html>
