<?php
require_once '../src/db.php';
require_once '../src/user.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
$userObj = new User($pdo);
$users = $userObj->listUsers();
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
            <li class="nav-item"><a class="nav-link active" href="users.php">Users</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <div class="card mt-4">
        <div class="card-body">
          <h1 class="card-title">User Management</h1>
          <?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
          <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?php echo htmlspecialchars($user['id']); ?></td>
                  <td><?php echo htmlspecialchars($user['username']); ?></td>
                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                  <td><?php echo htmlspecialchars($user['role']); ?></td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="view_user.php?id=<?php echo $user['id']; ?>">View</a>
                    <a class="btn btn-warning btn-sm" href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
    <?php include '../templates/footer.php'; ?>
</body>
</html>