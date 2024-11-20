CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'administrador') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE recetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    pasos text not NULL,
    tiempo VARCHAR(50) NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receta_id INT NOT NULL,
    user_id INT NOT NULL,
    estrellas TINYINT NOT NULL CHECK (estrellas BETWEEN 1 AND 5),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receta_id) REFERENCES recetas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receta_id INT NOT NULL,
    user_id INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receta_id) REFERENCES recetas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);



CREATE TABLE ingredientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receta_id INT,
    ingrediente VARCHAR(255),
    FOREIGN KEY (receta_id) REFERENCES recetas(id) ON DELETE CASCADE
);

