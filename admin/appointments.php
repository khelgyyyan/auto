<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('admin');

$conn = getDBConnection();

$success = '';

// Handle status update
if (isset($_GET['update']) && isset($_GET['status'])) {
    $appointmentId = $_GET['update'];
    $status = $_GET['status'];
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $appointmentId);
    if ($stmt->execute()) {
        $success = 'Appointment status updated!';
    }
    $stmt->close();
}

// Get all appointments
$appointments = $conn->query("
    SELECT a.*, u.name as customer_name, u.email, u.phone, s.name as service_name, s.price 
    FROM appointments a 
    JOIN users u ON a.customer_id = u.id 
    JOIN services s ON a.service_id = s.id 
    ORDER BY a.appointment_date DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="users.php">Manage Users</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="appointments.php" class="active">Appointments</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <h1>All Appointments</h1>
            <p>Manage all customer appointments</p>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="recent-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($apt = $appointments->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $apt['id']; ?></td>
                                    <td><?php echo htmlspecialchars($apt['customer_name']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($apt['email']); ?><br>
                                        <small><?php echo htmlspecialchars($apt['phone'] ?? 'N/A'); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($apt['service_name']); ?></td>
                                    <td><?php echo date('M j, Y g:i A', strtotime($apt['appointment_date'])); ?></td>
                                    <td>$<?php echo number_format($apt['price'], 2); ?></td>
                                    <td><span class="badge badge-<?php echo $apt['status']; ?>"><?php echo ucfirst($apt['status']); ?></span></td>
                                    <td>
                                        <?php if ($apt['status'] === 'pending'): ?>
                                            <a href="?update=<?php echo $apt['id']; ?>&status=confirmed" class="btn-small">Confirm</a>
                                        <?php elseif ($apt['status'] === 'confirmed'): ?>
                                            <a href="?update=<?php echo $apt['id']; ?>&status=completed" class="btn-small">Complete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
