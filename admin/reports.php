<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('admin');

$conn = getDBConnection();

// Get statistics
$totalRevenue = $conn->query("
    SELECT SUM(s.price) as total 
    FROM appointments a 
    JOIN services s ON a.service_id = s.id 
    WHERE a.status = 'completed'
")->fetch_assoc()['total'] ?? 0;

$monthlyRevenue = $conn->query("
    SELECT SUM(s.price) as total 
    FROM appointments a 
    JOIN services s ON a.service_id = s.id 
    WHERE a.status = 'completed' 
    AND MONTH(a.appointment_date) = MONTH(CURRENT_DATE())
    AND YEAR(a.appointment_date) = YEAR(CURRENT_DATE())
")->fetch_assoc()['total'] ?? 0;

$completedAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'completed'")->fetch_assoc()['count'];
$cancelledAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'cancelled'")->fetch_assoc()['count'];

// Top services
$topServices = $conn->query("
    SELECT s.name, COUNT(a.id) as bookings, SUM(s.price) as revenue
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    WHERE a.status = 'completed'
    GROUP BY s.id
    ORDER BY bookings DESC
    LIMIT 5
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="reports.php" class="active">Reports</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <h1>Business Reports</h1>
            <p>Analytics and insights</p>
            
            <div class="stats">
                <div class="stat-card blue">
                    <h3>Total Revenue</h3>
                    <p class="stat-number">$<?php echo number_format($totalRevenue, 2); ?></p>
                    <span class="stat-label">All time</span>
                </div>
                <div class="stat-card green">
                    <h3>This Month</h3>
                    <p class="stat-number">$<?php echo number_format($monthlyRevenue, 2); ?></p>
                    <span class="stat-label"><?php echo date('F Y'); ?></span>
                </div>
                <div class="stat-card purple">
                    <h3>Completed</h3>
                    <p class="stat-number"><?php echo $completedAppointments; ?></p>
                    <span class="stat-label">Appointments</span>
                </div>
                <div class="stat-card orange">
                    <h3>Cancelled</h3>
                    <p class="stat-number"><?php echo $cancelledAppointments; ?></p>
                    <span class="stat-label">Appointments</span>
                </div>
            </div>
            
            <div class="recent-section">
                <h2>Top Services</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Total Bookings</th>
                                <th>Revenue Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($topServices->num_rows > 0): ?>
                                <?php while($service = $topServices->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($service['name']); ?></td>
                                        <td><?php echo $service['bookings']; ?></td>
                                        <td>$<?php echo number_format($service['revenue'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">No completed services yet</td>
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
