CREATE DATABASE stock_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE stock_db;

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    quantite INT DEFAULT 0
);