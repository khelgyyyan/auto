<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('staff');

$conn = getDBConnection();

// Get today's date
$today = date('Y-m-d');

// Get statistics
$todayAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE DATE(appointment_date) = '$today'")->fetch_assoc()['count'];
$pendingAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'")->fetch_assoc()['count'];
$confirmedToday = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE DATE(appointment_date) = '$today' AND status = 'confirmed'")->fetch_assoc()['count'];

// Get today's appointments
$appointments = $conn->query("
    SELECT a.*, u.name as customer_name, u.phone, s.name as service_name 
    FROM appointments a 
    JOIN users u ON a.customer_id = u.id 
    JOIN services s ON a.service_id = s.id 
    WHERE DATE(a.appointment_date) = '$today'
    ORDER BY a.appointment_date ASC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Staff Panel</h2>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
                        <div class="user-role">Staff Member</div>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="customers.php">Customers</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <div class="header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
                <p>Staff Dashboard - Branch Operations</p>
            </div>
            
            <div class="stats">
                <div class="stat-card blue">
                    <h3>Today's Appointments</h3>
                    <p class="stat-number"><?php echo $todayAppointments; ?></p>
                    <span class="stat-label"><?php echo date('M d, Y'); ?></span>
                </div>
                <div class="stat-card orange">
                    <h3>Pending Services</h3>
                    <p class="stat-number"><?php echo $pendingAppointments; ?></p>
                    <span class="stat-label">Needs confirmation</span>
                </div>
                <div class="stat-card green">
                    <h3>Confirmed Today</h3>
                    <p class="stat-number"><?php echo $confirmedToday; ?></p>
                    <span class="stat-label">Ready to serve</span>
                </div>
            </div>

            <div class="recent-section">
                <h2>Today's Schedule</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($appointments->num_rows > 0): ?>
                                <?php while($row = $appointments->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('h:i A', strtotime($row['appointment_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td><span class="badge badge-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                        <td>
                                            <a href="appointments.php?id=<?php echo $row['id']; ?>" class="btn-small">View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">No appointments scheduled for today</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
