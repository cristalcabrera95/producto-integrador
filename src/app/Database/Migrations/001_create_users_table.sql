-- Migración: Tabla de usuarios con roles
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    login VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    avatar VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_login (login),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario administrador por defecto
INSERT INTO users (name, email, login, password, role) VALUES
('Administrador', 'admin@example.com', 'admin', '$2y$10$5ArJDIIr7lqGQC0pwe/VoeQtWqN.Lo8fkiavrhjNMZkgW4DuFs4.y', 'admin'),
('Usuario Básico', 'user@example.com', 'user', '$2y$10$maVasgUJrSHJnHCeUoe8k.mt.TSZRjV5Sj9a27P4f1.7E8tegf.x2', 'user');
