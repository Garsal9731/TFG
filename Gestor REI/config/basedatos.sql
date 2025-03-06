-- Crear la base de datos
CREATE DATABASE mvc_example;

-- Usar la base de datos
USE mvc_example;

-- Crear la tabla 'users'
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Insertar algunos usuarios de ejemplo
INSERT INTO users (name) VALUES
('Juan Pérez'),
('María Gómez'),
('Carlos Rodríguez');

-- Crear la tabla 'notes' con la columna 'nota'
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    user_id INT,
    nota INT CHECK (nota >= 1 AND nota <= 10),  -- Columna para la calificación
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertar algunas notas de ejemplo con calificación
INSERT INTO notes (content, user_id, nota) VALUES
('Esta es una nota de ejemplo 1', 1, 8),
('Esta es una nota de ejemplo 2', 2, 9),
('Esta es una nota de ejemplo 3', 3, 7);

