<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
requireRole('admin');

$conn = getDBConnection();

$success = '';
$error = '';

// Handle service deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $serviceId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $serviceId);
    if ($stmt->execute()) {
        $success = 'Service deleted successfully!';
    }
    $stmt->close();
}

// Handle new service creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    
    $stmt = $conn->prepare("INSERT INTO services (name, description, price, duration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $name, $description, $price, $duration);
    
    if ($stmt->execute()) {
        $success = 'Service created successfully!';
    } else {
        $error = 'Failed to create service.';
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
    <title>Manage Services</title>
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
                    <li><a href="services.php" class="active">Services</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <div class="section-header">
                <h1>Manage Services</h1>
                <button onclick="toggleModal()" class="btn-primary">Add New Service</button>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="services-grid">
                <?php while($service = $services->fetch_assoc()): ?>
                    <div class="service-card">
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                        <div class="service-meta">
                            <span><strong>Duration:</strong> <?php echo $service['duration']; ?> min</span>
                        </div>
                        <div class="service-footer">
                            <span class="price">$<?php echo number_format($service['price'], 2); ?></span>
                            <a href="?delete=<?php echo $service['id']; ?>" 
                               class="btn-danger" 
                               onclick="return confirm('Delete this service?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
    
    <!-- Modal -->
    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="toggleModal()">&times;</span>
            <h2>Add New Service</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Service Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration (minutes) *</label>
                        <input type="number" id="duration" name="duration" min="1" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Create Service</button>
                    <button type="button" onclick="toggleModal()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function toggleModal() {
            const modal = document.getElementById('serviceModal');
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('serviceModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
