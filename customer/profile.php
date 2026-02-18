<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('customer');

$conn = getDBConnection();
$userId = $_SESSION['user_id'];

$success = '';
$error = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    
    // Get current user data
    $result = $conn->query("SELECT password FROM users WHERE id = $userId");
    $user = $result->fetch_assoc();
    
    // Update basic info
    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $phone, $userId);
    
    if ($stmt->execute()) {
        $_SESSION['name'] = $name;
        $success = 'Profile updated successfully!';
        
        // Update password if provided
        if ($currentPassword && $newPassword) {
            if (password_verify($currentPassword, $user['password'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashedPassword, $userId);
                $stmt->execute();
                $success .= ' Password changed successfully!';
            } else {
                $error = 'Current password is incorrect.';
            }
        }
    } else {
        $error = 'Failed to update profile.';
    }
    $stmt->close();
}

// Get user data
$result = $conn->query("SELECT * FROM users WHERE id = $userId");
$user = $result->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Customer Portal</h2>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
                        <div class="user-role">Customer</div>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="book-appointment.php">Book Appointment</a></li>
                    <li><a href="my-appointments.php">My Appointments</a></li>
                    <li><a href="profile.php" class="active">Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <h1>My Profile</h1>
            <p>Manage your account information</p>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="">
                    <h3>Personal Information</h3>
                    
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        <small>Email cannot be changed</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                               placeholder="+1 (555) 123-4567">
                    </div>
                    
                    <hr>
                    
                    <h3>Change Password</h3>
                    <p class="text-muted">Leave blank if you don't want to change your password</p>
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
