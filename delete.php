<?php
require "functions.php";
check_admin();

// Check if user ID is provided via GET parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect or handle error if ID is not provided or invalid
    header("Location: admin.php");
    exit;
}

// Delete user's posts first
$userId = $_GET['id'];

// Start a transaction to ensure atomicity (either all operations succeed or fail)
$conn->begin_transaction();

// Delete user's posts
$queryDeletePosts = "DELETE FROM posts WHERE user_id = ?";
$stmtDeletePosts = $conn->prepare($queryDeletePosts);
$stmtDeletePosts->bind_param("i", $userId);
$stmtDeletePosts->execute();

// Check if posts deletion was successful
if ($stmtDeletePosts->affected_rows >= 0) {
    // If posts deletion was successful, delete the user
    $queryDeleteUser = "DELETE FROM users WHERE id = ?";
    $stmtDeleteUser = $conn->prepare($queryDeleteUser);
    $stmtDeleteUser->bind_param("i", $userId);
    $stmtDeleteUser->execute();

    // Check if user deletion was successful
    if ($stmtDeleteUser->affected_rows > 0) {
        // Commit transaction if both operations were successful
        $conn->commit();
        header("Location: admin.php");
        exit;
    } else {
        // Rollback if user deletion failed
        $conn->rollback();
        $error = "Failed to delete user.";
    }
} else {
    // Rollback if posts deletion failed
    $conn->rollback();
    $error = "Failed to delete user's posts.";
}
