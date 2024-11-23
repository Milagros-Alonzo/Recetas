
-- Database: `recetas_web`
CREATE DATABASE IF NOT EXISTS recetas_web;
USE recetas_web;

-- --------------------------------------------------------

-- Table structure for table `usuarios`
CREATE TABLE usuarios (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  email varchar(100) NOT NULL UNIQUE,
  contrasena varchar(255) NOT NULL,
  rol enum('usuario','administrador') DEFAULT 'usuario',
  token_sesion varchar(255) DEFAULT NULL,
  fecha_registro timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `recetas`
CREATE TABLE recetas (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  titulo varchar(100) NOT NULL,
  descripcion text NOT NULL,
  pasos text NOT NULL,
  tiempo varchar(50) NOT NULL,
  imagen varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `comentarios`
CREATE TABLE comentarios (
  id int(11) NOT NULL AUTO_INCREMENT,
  receta_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  comentario text NOT NULL,
  estrellas tinyint(5) NOT NULL CHECK (`estrellas` BETWEEN 0 AND 5),
  fecha datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `receta_id` (`receta_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `ingredientes`
CREATE TABLE ingredientes (
  id int(11) NOT NULL AUTO_INCREMENT,
  receta_id int(11) DEFAULT NULL,
  ingrediente varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receta_id` (`receta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------



-- Add foreign keys after all tables are created
ALTER TABLE recetas
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

ALTER TABLE comentarios
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

ALTER TABLE ingredientes
  ADD CONSTRAINT `ingredientes_ibfk_1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE;

ALTER TABLE valoraciones
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

