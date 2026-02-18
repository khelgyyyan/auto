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
                    <li><a href="dashboard.php" class="<?php echo ($currentPage ?? '') == 'dashboard' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="appointments.php" class="<?php echo ($currentPage ?? '') == 'appointments' ? 'active' : ''; ?>">Appointments</a></li>
                    <li><a href="customers.php" class="<?php echo ($currentPage ?? '') == 'customers' ? 'active' : ''; ?>">Customers</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
