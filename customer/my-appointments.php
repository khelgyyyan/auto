<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('customer');

$conn = getDBConnection();
$userId = $_SESSION['user_id'];

// Handle cancellation
if (isset($_GET['cancel']) && is_numeric($_GET['cancel'])) {
    $appointmentId = $_GET['cancel'];
    $stmt = $conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $appointmentId, $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: my-appointments.php");
    exit();
}

// Get all appointments
$appointments = $conn->query("
    SELECT a.*, s.name as service_name, s.price, s.duration 
    FROM appointments a 
    JOIN services s ON a.service_id = s.id 
    WHERE a.customer_id = $userId 
    ORDER BY a.appointment_date DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
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
                    <li><a href="my-appointments.php" class="active">My Appointments</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <div class="section-header">
                <h1>My Appointments</h1>
                <a href="book-appointment.php" class="btn-primary">Book New</a>
            </div>
            
            <div class="appointments-list">
                <?php if ($appointments->num_rows > 0): ?>
                    <?php while($apt = $appointments->fetch_assoc()): ?>
                        <div class="appointment-card">
                            <div class="appointment-header">
                                <div>
                                    <h3><?php echo htmlspecialchars($apt['service_name']); ?></h3>
                                    <p class="appointment-date">
                                        <?php echo date('l, F j, Y', strtotime($apt['appointment_date'])); ?> 
                                        at <?php echo date('g:i A', strtotime($apt['appointment_date'])); ?>
                                    </p>
                                </div>
                                <span class="badge badge-<?php echo $apt['status']; ?>">
                                    <?php echo ucfirst($apt['status']); ?>
                                </span>
                            </div>
                            
                            <div class="appointment-details">
                                <div class="detail-item">
                                    <strong>Price:</strong> $<?php echo number_format($apt['price'], 2); ?>
                                </div>
                                <div class="detail-item">
                                    <strong>Duration:</strong> <?php echo $apt['duration']; ?> minutes
                                </div>
                                <div class="detail-item">
                                    <strong>Booked:</strong> <?php echo date('M j, Y', strtotime($apt['created_at'])); ?>
                                </div>
                            </div>
                            
                            <?php if ($apt['notes']): ?>
                                <div class="appointment-notes">
                                    <strong>Notes:</strong> <?php echo htmlspecialchars($apt['notes']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($apt['status'] === 'pending' || $apt['status'] === 'confirmed'): ?>
                                <div class="appointment-actions">
                                    <a href="?cancel=<?php echo $apt['id']; ?>" 
                                       class="btn-danger" 
                                       onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        Cancel Appointment
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>You don't have any appointments yet.</p>
                        <a href="book-appointment.php" class="btn-primary">Book Your First Appointment</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
