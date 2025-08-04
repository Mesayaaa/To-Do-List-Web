-- =============================================
-- Database Setup untuk To-Do List Web App
-- =============================================

-- Buat database baru
CREATE DATABASE IF NOT EXISTS todo;
USE todo;

-- Tabel untuk users (sistem login/register)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk tugas/tasks
CREATE TABLE IF NOT EXISTS tbl_tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    priority ENUM('High', 'Medium', 'Low') NOT NULL DEFAULT 'Medium',
    tugas TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'No Status',
    user_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_priority (priority),
    INDEX idx_status (status),
    INDEX idx_user_id (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample data (opsional)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: "password"

INSERT INTO tbl_tugas (priority, tugas, status) VALUES 
('High', 'Setup database untuk aplikasi', 'Done'),
('Medium', 'Buat sistem login dan register', 'On Progress'),
('Low', 'Styling UI dengan CSS', 'No Status');

-- =============================================
-- Database setup selesai!
-- =============================================
