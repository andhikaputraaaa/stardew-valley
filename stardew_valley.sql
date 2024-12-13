-- buat bikin databasenya

CREATE DATABASE stardew_valley;

USE stardew_valley;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role varchar(10) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL
);

INSERT INTO user (role, first_name, last_name, email, password, gender) VALUES ('mayor', 'mayo', 'r', 'mayor@gmail.com', '12345678', 'Male')


-- belum
CREATE TABLE hasil_mancing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE jenis_ikan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL
);

INSERT INTO jenis_ikan (name, image) VALUES
('Carp', 'assets/Carp.png'),
('Catfish', 'assets/Catfish.png'),
('Eel', 'assets/Eel.png'),
('Lava Eel', 'assets/Lava_Eel.png'),
('Octopus', 'assets/Octopus.png'),
('Pufferfish', 'assets/Pufferfish.png'),
('Salmon', 'assets/Salmon.png'),
('Sandfish', 'assets/Sandfish.png'),
('Sardine', 'assets/Sardine.png'),
('Squid', 'assets/Squid.png'),
('Stonefish', 'assets/Stonefish.png'),
('Super Cucumber', 'assets/Super_Cucumber.png'),
('Tuna', 'assets/Tuna.png');
