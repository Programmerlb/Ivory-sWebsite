<?php 
require "functions.php"; 
check_admin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .users-table th, .users-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .users-table th {
            background-color: #333;
            color: #fff;
        }
        .users-table td {
            background-color: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            justify-content: space-around;
        }
        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #4CAF50;
            color: #fff;
        }
        .delete-button {
            background-color: #f44336;
            color: #fff;
        }
        .data{
            color: black;
        }
    </style>
</head>
<body>
    <?php require_once "header.php";?>

    <div class="container">
        <h2>Admin Page</h2>
        <table class="users-table">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            $query = "SELECT * FROM users";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="data">' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td class="data">' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td class="data">' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td class="action-buttons">';
                    echo '<button class="edit-button" onclick="editUser(' . $row['id'] . ')">Edit</button>';
                    echo '<button class="delete-button" onclick="deleteUser(' . $row['id'] . ')">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No users found</td></tr>';
            }
            ?>
        </table>
    </div>
    <?php require_once "footer.php";?>

    <script>
        function editUser(id) {
            window.location.href = `edit.php?id=${id}`;
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
