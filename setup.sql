-- Database initialization for city_events
CREATE DATABASE IF NOT EXISTS city_events;
USE city_events;

-- Admin users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    event_date DATETIME NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin credentials (admin/admin)
-- Using plain text or simple hash as per common HW requirements, 
-- but using password_hash for better practice if possible.
-- For now, inserting the required admin user.
INSERT INTO users (username, password) VALUES ('admin', 'admin') 
ON DUPLICATE KEY UPDATE username=username;
