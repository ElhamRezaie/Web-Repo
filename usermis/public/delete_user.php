<?php
session_start();
require_once '../src/db.php';
require_once '../src/user.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userObj = new User($pdo);
    if ($userObj->deleteUser($userId)) {
        header('Location: users.php?message=User deleted successfully');
    } else {
        header('Location: users.php?error=Failed to delete user');
    }
} else {
    header('Location: users.php?error=No user ID provided');
}
?>