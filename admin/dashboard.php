<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('admin');

$pageTitle = 'Admin Dashboard';
$currentPage = 'dashboard';

$conn = getDBConnection();

// Get statistics
$totalAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
$totalStaff = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'staff'")->fetch_assoc()['count'];
$totalCustomers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'")->fetch_assoc()['count'];
$pendingAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'")->fetch_assoc()['count'];

// Get recent appointments
$recentAppointments = $conn->query("
    SELECT a.*, u.name as customer_name, s.name as service_name 
    FROM appointments a 
    JOIN users u ON a.customer_id = u.id 
    JOIN services s ON a.service_id = s.id 
    ORDER BY a.created_at DESC 
    LIMIT 5
");

$conn->close();

// Include header
require_once '../includes/admin_header.php';
// Include sidebar
require_once '../includes/admin_sidebar.php';
?>
            <div class="header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
                <p>Admin Dashboard - Full system access</p>
            </div>
            
            <div class="stats">
                <div class="stat-card blue">
                    <h3>Total Appointments</h3>
                    <p class="stat-number"><?php echo $totalAppointments; ?></p>
                    <span class="stat-label">All time</span>
                </div>
                <div class="stat-card green">
                    <h3>Active Staff</h3>
                    <p class="stat-number"><?php echo $totalStaff; ?></p>
                    <span class="stat-label">Across all branches</span>
                </div>
                <div class="stat-card purple">
                    <h3>Total Customers</h3>
                    <p class="stat-number"><?php echo $totalCustomers; ?></p>
                    <span class="stat-label">Registered</span>
                </div>
                <div class="stat-card orange">
                    <h3>Pending Appointments</h3>
                    <p class="stat-number"><?php echo $pendingAppointments; ?></p>
                    <span class="stat-label">Needs attention</span>
                </div>
            </div>

            <div class="recent-section">
                <h2>Recent Appointments</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentAppointments->num_rows > 0): ?>
                                <?php while($row = $recentAppointments->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($row['appointment_date'])); ?></td>
                                        <td><span class="badge badge-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">No appointments yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

<?php require_once '../includes/admin_footer.php'; ?>
