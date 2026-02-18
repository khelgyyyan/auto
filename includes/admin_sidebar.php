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
                    <li><a href="dashboard.php" class="<?php echo ($currentPage ?? '') == 'dashboard' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="users.php" class="<?php echo ($currentPage ?? '') == 'users' ? 'active' : ''; ?>">Manage Users</a></li>
                    <li><a href="services.php" class="<?php echo ($currentPage ?? '') == 'services' ? 'active' : ''; ?>">Services</a></li>
                    <li><a href="appointments.php" class="<?php echo ($currentPage ?? '') == 'appointments' ? 'active' : ''; ?>">Appointments</a></li>
                    <li><a href="reports.php" class="<?php echo ($currentPage ?? '') == 'reports' ? 'active' : ''; ?>">Reports</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
