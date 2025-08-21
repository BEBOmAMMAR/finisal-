CREATE DATABASE finance_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE finance_manager;

-- جدول العملاء
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول التصنيفات
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('income','expense') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المعاملات
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    category_id INT,
    amount DECIMAL(10,2) NOT NULL,
    date DATE NOT NULL,
    note TEXT,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
