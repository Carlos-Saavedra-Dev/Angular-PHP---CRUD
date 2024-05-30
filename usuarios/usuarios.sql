CREATE DATABASE usuarios;

USE usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    cedula VARCHAR(255) NOT NULL,
    edad INT NOT NULL,
    pais VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);