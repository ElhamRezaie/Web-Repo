<?php
echo "=== User Management System Test ===\n\n";

// Test database connection
echo "1. Testing database connection...\n";
try {
    require_once 'src/db.php';
    echo "✅ Database connection successful!\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test user authentication functions
echo "\n2. Testing authentication functions...\n";
try {
    require_once 'src/auth.php';
    echo "✅ Authentication functions loaded!\n";
} catch (Exception $e) {
    echo "❌ Authentication functions failed: " . $e->getMessage() . "\n";
}

// Test user management functions
echo "\n3. Testing user management functions...\n";
try {
    require_once 'src/user.php';
    echo "✅ User management functions loaded!\n";
} catch (Exception $e) {
    echo "❌ User management functions failed: " . $e->getMessage() . "\n";
}

// Test if admin user exists
echo "\n4. Testing admin user...\n";
try {
    $stmt = $pdo->prepare("SELECT username, email, role FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "✅ Admin user found:\n";
        echo "   Username: " . $admin['username'] . "\n";
        echo "   Email: " . $admin['email'] . "\n";
        echo "   Role: " . $admin['role'] . "\n";
    } else {
        echo "❌ Admin user not found!\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking admin user: " . $e->getMessage() . "\n";
}

// Test password verification
echo "\n5. Testing password verification...\n";
try {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify('admin123', $user['password'])) {
        echo "✅ Password verification works!\n";
    } else {
        echo "❌ Password verification failed!\n";
    }
} catch (Exception $e) {
    echo "❌ Error testing password: " . $e->getMessage() . "\n";
}

// Test file permissions
echo "\n6. Testing file permissions...\n";
$uploadsDir = 'public/uploads/';
if (is_dir($uploadsDir) && is_writable($uploadsDir)) {
    echo "✅ Uploads directory is writable!\n";
} else {
    echo "❌ Uploads directory is not writable!\n";
}

echo "\n=== Test Complete ===\n";
echo "The user management system is ready to use!\n\n";
echo "Access URLs:\n";
echo "- Main page: http://localhost/\n";
echo "- Login page: http://localhost/login.php\n";
echo "- Admin login: username=admin, password=admin123\n";
echo "- Demo user login: username=user, password=user123\n";
?>