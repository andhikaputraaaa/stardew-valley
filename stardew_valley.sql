-- buat bikin databasenya

CREATE DATABASE stardew_valley;

USE stardew_valley;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role varchar(5) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL
);