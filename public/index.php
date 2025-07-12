<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">User Management</a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <div class="card mt-4">
        <div class="card-body text-center">
          <h1 class="card-title">Welcome to the User Management System</h1>
          <p>&copy; <?php echo date('Y'); ?> User Management System. All rights reserved.</p>
        </div>
      </div>
    </div>
</body>
</html>