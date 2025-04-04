CREATE DATABASE user_management;
USE user_management;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('user', 'admin') DEFAULT 'user',
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_token_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$jye/1E9m13N2B2bbaEGsf.5TtkxNg2otv5B9SbPBqQ720a337Tne.', 'admin@example.com', 'admin'),
('thang', '$2y$10$jye/1E9m13N2B2bbaEGsf.5TtkxNg2otv5B9SbPBqQ720a337Tne.', 'user1@example.com', 'user'),
('ngoc', '$2y$10$jye/1E9m13N2B2bbaEGsf.5TtkxNg2otv5B9SbPBqQ720a337Tne.', 'user2@example.com', 'user');