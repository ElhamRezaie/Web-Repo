<?php
session_start();
require_once '../src/db.php';
require_once '../src/user.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userObj = new User($pdo);
$user_id = $_SESSION['user_id'];
$user = $userObj->getUserById($user_id);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $upload_dir = '../public/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed)) {
            $message = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        } elseif ($_FILES['profile_photo']['size'] > 2*1024*1024) {
            $message = "File too large. Max 2MB.";
        } else {
            $photoName = uniqid('profile_', true) . '.' . $ext;
            $upload_file = $upload_dir . $photoName;
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_file)) {
                $userObj->updateUserProfilePhoto($user_id, 'uploads/' . $photoName);
                $user['photo'] = 'uploads/' . $photoName;
                $message = "Profile photo updated.";
            } else {
                $message = "Failed to upload photo.";
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
    <title>User Profile</title>
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
          <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <div class="card mt-4">
        <div class="card-body text-center">
          <h1 class="card-title">User Profile</h1>
          <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
          <?php endif; ?>
          <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile Photo" width="150" style="border-radius:50%;margin-bottom:16px;">
          <form action="profile.php" method="post" enctype="multipart/form-data" class="mb-3">
            <div class="mb-3">
              <label for="profile_photo" class="form-label">Upload Profile Photo:</label>
              <input type="file" class="form-control" name="profile_photo" id="profile_photo" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Update Photo</button>
          </form>
          <h2 class="mt-4">Profile Information</h2>
          <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
          <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
          <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
        </div>
      </div>
    </div>
</body>
</html>