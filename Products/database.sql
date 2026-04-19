CREATE DATABASE product_api;

USE product_api;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);