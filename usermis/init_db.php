<?php
require_once 'src/db.php';

try {
    // Check if admin user already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $adminExists = $stmt->fetchColumn() > 0;
    
    if (!$adminExists) {
        // Create default admin user
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', $adminPassword, 'admin@example.com', 'Admin']);
        echo "✅ Admin user created successfully!\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
        echo "Email: admin@example.com\n";
    } else {
        echo "ℹ️ Admin user already exists.\n";
    }
    
    // Create a demo regular user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute(['user']);
    $userExists = $stmt->fetchColumn() > 0;
    
    if (!$userExists) {
        $userPassword = password_hash('user123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['user', $userPassword, 'user@example.com', 'Read-only']);
        echo "✅ Demo user created successfully!\n";
        echo "Username: user\n";
        echo "Password: user123\n";
        echo "Email: user@example.com\n";
    } else {
        echo "ℹ️ Demo user already exists.\n";
    }
    
    echo "\n🎉 Database initialization completed!\n";
    echo "You can now access the user management system.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>