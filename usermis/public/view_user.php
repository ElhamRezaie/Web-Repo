<?php
require_once '../src/db.php';
require_once '../src/user.php';
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit;
}
$userId = $_GET['id'];
$userObj = new User($pdo);
$user = $userObj->getUserById($userId);
if (!$user) {
    header('Location: users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">User Management</a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
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
      <div class="card mt-4 user-profile">
        <div class="card-body text-center">
          <h1 class="card-title">User Profile</h1>
          <img src="../<?php echo htmlspecialchars($user['photo']); ?>" alt="User Photo" class="user-photo mb-3" style="border-radius:50%;max-width:150px;">
          <h2><?php echo htmlspecialchars($user['username']); ?></h2>
          <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
          <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
          <a href="edit_user.php?id=<?php echo $userId; ?>" class="btn btn-warning btn-sm">Edit User</a>
          <a href="users.php" class="btn btn-secondary btn-sm">Back to Users</a>
        </div>
      </div>
    </div>
</body>
</html>