<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login($username, $password) {
    include 'db.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}


function logout() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
}
// User registration with validation and unique username check
function register($username, $password, $role, $photo = null) {
    include 'db.php';
    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        return ['success' => false, 'message' => 'All fields are required.'];
    }
    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        return ['success' => false, 'message' => 'Username already exists.'];
    }
    $stmt->close();
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $role, $photo);
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Registration successful.'];
    } else {
        return ['success' => false, 'message' => 'Registration failed.'];
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>