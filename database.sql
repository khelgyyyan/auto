-- Create database
CREATE DATABASE IF NOT EXISTS autoshop_db;
USE autoshop_db;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'customer') NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (password: admin123)
-- Note: Run generate_hash.php to create proper password hashes
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@autoshop.com', '$2y$10$rZ5qH8qF9vX7yJ3kL2mN4OYxGzKjP8wQ6tR7sU9vW0xY1zA2bC3dE', 'admin'),
('Staff User', 'staff@autoshop.com', '$2y$10$rZ5qH8qF9vX7yJ3kL2mN4OYxGzKjP8wQ6tR7sU9vW0xY1zA2bC3dE', 'staff'),
('Customer User', 'customer@autoshop.com', '$2y$10$rZ5qH8qF9vX7yJ3kL2mN4OYxGzKjP8wQ6tR7sU9vW0xY1zA2bC3dE', 'customer');

-- Services table
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    duration INT NOT NULL COMMENT 'Duration in minutes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);
