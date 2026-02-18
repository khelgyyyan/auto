<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('staff');

$conn = getDBConnection();

// Get all customers with their appointment count
$customers = $conn->query("
    SELECT u.*, COUNT(a.id) as total_appointments
    FROM users u
    LEFT JOIN appointments a ON u.id = a.customer_id
    WHERE u.role = 'customer'
    GROUP BY u.id
    ORDER BY u.created_at DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
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
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="customers.php" class="active">Customers</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <h1>Customer Directory</h1>
            <p>View all registered customers</p>
            
            <div class="recent-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Appointments</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($customer = $customers->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $customer['id']; ?></td>
                                    <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo $customer['total_appointments']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($customer['created_at'])); ?></td>
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
