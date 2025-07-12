<?php
require_once '../src/db.php';
require_once '../src/user.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
$user_id = $_GET['id'] ?? null;
$userObj = new User($pdo);
$user = $user_id ? $userObj->getUserById($user_id) : null;
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';
    $photo = $_FILES['photo'] ?? null;
    $photo_path = $user['photo'];
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../public/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $ext = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed) && $photo['size'] <= 2*1024*1024) {
            $photoName = uniqid('user_', true) . '.' . $ext;
            $photo_path = 'uploads/' . $photoName;
            move_uploaded_file($photo['tmp_name'], $upload_dir . $photoName);
        }
    }
    $userObj->updateUser($user_id, $username, $email, $role, $photo_path);
    header('Location: users.php?message=User updated successfully');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
      <div class="card mt-4">
        <div class="card-body">
          <h1 class="card-title">Edit User</h1>
          <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role:</label>
              <select class="form-select" name="role" id="role" required>
                <option value="Admin" <?php echo $user['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="Read-only" <?php echo $user['role'] === 'Read-only' ? 'selected' : ''; ?>>Read-only</option>
                <option value="Data Entry" <?php echo $user['role'] === 'Data Entry' ? 'selected' : ''; ?>>Data Entry</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Profile Photo:</label>
              <input type="file" class="form-control" name="photo" id="photo">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
          </form>
          <a class="btn btn-secondary mt-3" href="users.php">Back to Users</a>
        </div>
      </div>
    </div>
</body>
</html>