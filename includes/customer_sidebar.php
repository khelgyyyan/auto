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
                    <li><a href="dashboard.php" class="<?php echo ($currentPage ?? '') == 'dashboard' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="book-appointment.php" class="<?php echo ($currentPage ?? '') == 'book-appointment' ? 'active' : ''; ?>">Book Appointment</a></li>
                    <li><a href="my-appointments.php" class="<?php echo ($currentPage ?? '') == 'my-appointments' ? 'active' : ''; ?>">My Appointments</a></li>
                    <li><a href="profile.php" class="<?php echo ($currentPage ?? '') == 'profile' ? 'active' : ''; ?>">Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
