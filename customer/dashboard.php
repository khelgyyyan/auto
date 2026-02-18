<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('customer');

$pageTitle = 'Customer Dashboard';
$currentPage = 'dashboard';

$conn = getDBConnection();
$userId = $_SESSION['user_id'];

// Get statistics
$upcomingCount = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE customer_id = $userId AND appointment_date >= NOW() AND status != 'cancelled'")->fetch_assoc()['count'];
$historyCount = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE customer_id = $userId")->fetch_assoc()['count'];
$completedCount = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE customer_id = $userId AND status = 'completed'")->fetch_assoc()['count'];

// Get upcoming appointments
$upcomingAppointments = $conn->query("
    SELECT a.*, s.name as service_name, s.price 
    FROM appointments a 
    JOIN services s ON a.service_id = s.id 
    WHERE a.customer_id = $userId AND a.appointment_date >= NOW() AND a.status != 'cancelled'
    ORDER BY a.appointment_date ASC 
    LIMIT 5
");

// Get available services
$services = $conn->query("SELECT * FROM services LIMIT 3");

$conn->close();

// Include header and sidebar
require_once '../includes/customer_header.php';
require_once '../includes/customer_sidebar.php';
?>
            <div class="header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
                <p>Customer Dashboard</p>
            </div>
            
            <div class="stats">
                <div class="stat-card blue">
                    <h3>Upcoming Appointments</h3>
                    <p class="stat-number"><?php echo $upcomingCount; ?></p>
                    <span class="stat-label">Scheduled</span>
                </div>
                <div class="stat-card green">
                    <h3>Completed Services</h3>
                    <p class="stat-number"><?php echo $completedCount; ?></p>
                    <span class="stat-label">All time</span>
                </div>
                <div class="stat-card purple">
                    <h3>Total Visits</h3>
                    <p class="stat-number"><?php echo $historyCount; ?></p>
                    <span class="stat-label">Service history</span>
                </div>
            </div>

            <div class="recent-section">
                <div class="section-header">
                    <h2>Upcoming Appointments</h2>
                    <a href="book-appointment.php" class="btn-primary">Book New Appointment</a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($upcomingAppointments->num_rows > 0): ?>
                                <?php while($row = $upcomingAppointments->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y h:i A', strtotime($row['appointment_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                                        <td><span class="badge badge-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                        <td>
                                            <a href="my-appointments.php?id=<?php echo $row['id']; ?>" class="btn-small">View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">No upcoming appointments. <a href="book-appointment.php">Book one now!</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="services-section">
                <h2>Our Services</h2>
                <div class="services-grid">
                    <?php if ($services->num_rows > 0): ?>
                        <?php while($service = $services->fetch_assoc()): ?>
                            <div class="service-card">
                                <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                                <p><?php echo htmlspecialchars($service['description']); ?></p>
                                <div class="service-footer">
                                    <span class="price">$<?php echo number_format($service['price'], 2); ?></span>
                                    <a href="book-appointment.php?service=<?php echo $service['id']; ?>" class="btn-small">Book Now</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No services available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>

<?php require_once '../includes/customer_footer.php'; ?>
