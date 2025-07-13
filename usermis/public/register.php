<?php
session_start();
require_once '../src/db.php';
require_once '../src/user.php';

// Only allow Admins to access registration page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $photo = $_FILES['photo'] ?? null;

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($role) || !$photo || $photo['error'] != 0) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
    } else {
        // Check for unique username/email
        $userObj = new User($pdo);
        $existing = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $existing->execute([$username, $email]);
        if ($existing->fetch()) {
            $message = "Username or email already exists.";
        } else {
            // Handle file upload securely
            $targetDir = 'uploads/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $ext = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowed)) {
                $message = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
            } elseif ($photo['size'] > 2*1024*1024) {
                $message = "File too large. Max 2MB.";
            } else {
                $photoName = uniqid('user_', true) . '.' . $ext;
                $targetFile = $targetDir . $photoName;
                if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
                    $created = $userObj->createUser($username, $password, $email, $role, $targetFile);
                    if ($created) {
                        $message = "Registration successful. <a href='login.php'>Login here</a>.";
                    } else {
                        $message = "Registration failed. Please try again.";
                    }
                } else {
                    $message = "Failed to upload photo.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Register</h2>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">User Management</a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
            <li class="nav-item"><a class="nav-link active" href="register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <div class="card mt-4">
        <div class="card-body">
          <h2 class="card-title">Register</h2>
          <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
          <?php endif; ?>
          <form action="register.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role:</label>
              <select class="form-select" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Read-only">Read-only</option>
                <option value="Data Entry">Data Entry</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Profile Photo:</label>
              <input type="file" class="form-control" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
          </form>
        </div>
      </div>
    </div>
</body>
</html>