<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('customer');

$conn = getDBConnection();
$userId = $_SESSION['user_id'];

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = $_POST['service_id'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];
    $notes = $_POST['notes'] ?? '';
    
    $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime;
    
    $stmt = $conn->prepare("INSERT INTO appointments (customer_id, service_id, appointment_date, notes, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iiss", $userId, $serviceId, $appointmentDateTime, $notes);
    
    if ($stmt->execute()) {
        $success = 'Appointment booked successfully! We will confirm shortly.';
    } else {
        $error = 'Failed to book appointment. Please try again.';
    }
    $stmt->close();
}

// Get all services
$services = $conn->query("SELECT * FROM services ORDER BY name ASC");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
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
                    <li><a href="book-appointment.php" class="active">Book Appointment</a></li>
                    <li><a href="my-appointments.php">My Appointments</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <h1>Book an Appointment</h1>
            <p>Schedule your auto service appointment</p>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="service_id">Select Service *</label>
                        <select id="service_id" name="service_id" required>
                            <option value="">Choose a service...</option>
                            <?php while($service = $services->fetch_assoc()): ?>
                                <option value="<?php echo $service['id']; ?>">
                                    <?php echo htmlspecialchars($service['name']); ?> - $<?php echo number_format($service['price'], 2); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Date *</label>
                            <input type="date" id="appointment_date" name="appointment_date" 
                                   min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_time">Time *</label>
                            <input type="time" id="appointment_time" name="appointment_time" 
                                   min="08:00" max="17:00" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="4" 
                                  placeholder="Any specific concerns or requests..."></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Book Appointment</button>
                        <a href="dashboard.php" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
