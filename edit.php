<?php
require "functions.php";
check_admin();

// Check if user ID is provided via GET parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect or handle error if ID is not provided or invalid
    header("Location: admin.php");
    exit;
}

// Fetch user details based on the provided ID
$userId = $_GET['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Redirect or handle error if user with provided ID does not exist
    header("Location: admin.php");
    exit;
}

$user = $result->fetch_assoc();

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;

    // Update user information including admin status
    $updateQuery = "UPDATE users SET username = ?, email = ?, admin = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssii", $username, $email, $isAdmin, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to admin page after successful update
        header("Location: admin.php");
        exit;
    } else {
        // Error handling if update fails
        $error = "Failed to update user information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
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
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: black;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            color: black;
        }
        input[type="text"], input[type="email"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="checkbox"] {
            margin-bottom: 10px;
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
    </style>
</head>
<body>
<?php require_once "header.php";?>
    <div class="container">
        <h2>Edit User - <?php echo htmlspecialchars($user['username']); ?></h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label for="admin">Admin:</label>
            <input type="checkbox" id="admin" name="admin" <?php echo ($user['admin'] == 1) ? 'checked' : ''; ?>>
            <button type="submit">Update</button>
        </form>
    </div>
    <?php require_once "footer.php";?>
</body>
</html>
