<?php
require_once 'config/database.php';

echo "<h2>Auto Shop Setup</h2>";

$conn = getDBConnection();

// Create users with proper password hashing
$password = password_hash('admin123', PASSWORD_DEFAULT);

$users = [
    ['Admin User', 'admin@autoshop.com', 'admin'],
    ['Staff User', 'staff@autoshop.com', 'staff'],
    ['Customer User', 'customer@autoshop.com', 'customer']
];

echo "<h3>Creating users...</h3>";

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?");
    $stmt->bind_param("sssss", $user[0], $user[1], $password, $user[2], $password);
    
    if ($stmt->execute()) {
        echo "✓ Created/Updated: {$user[0]} ({$user[1]}) - Role: {$user[2]}<br>";
    } else {
        echo "✗ Error creating {$user[0]}: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

echo "<br><h3>Login Credentials:</h3>";
echo "Email: admin@autoshop.com | Password: admin123<br>";
echo "Email: staff@autoshop.com | Password: admin123<br>";
echo "Email: customer@autoshop.com | Password: admin123<br>";
echo "<br><a href='index.php'>Go to Login Page</a>";

$conn->close();
?>
