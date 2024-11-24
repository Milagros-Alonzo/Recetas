# Página Web de Recetas

## Descripción del Proyecto

Este proyecto consiste en una página web diseñada para compartir y buscar recetas de cocina. Fue desarrollado utilizando PHP y MySQL como tecnologías principales, sin el uso de frameworks. 

El objetivo principal es proporcionar una plataforma donde los usuarios puedan:
- Añadir, editar y eliminar recetas.
- Buscar recetas según diferentes criterios.
- Comentar y valorar las recetas publicadas.
- Administrar usuarios, comentarios y recetas mediante un panel de administración.

---

## Características

### Funcionalidades principales:
1. **Gestión de Usuarios**:
   - Registro de nuevos usuarios.
   - Inicio y cierre de sesión.
   - Recuperación de contraseñas.

2. **Catálogo de Recetas**:
   - Visualización de recetas disponibles.
   - Búsqueda por tipo de comida, ingredientes, y tiempo de preparación.
   - Detalles de cada receta con ingredientes, pasos y fotografías.

3. **Publicación de Recetas**:
   - Los usuarios pueden añadir sus propias recetas.
   - Edición y eliminación de recetas por parte del autor.

4. **Comentarios y Valoraciones**:
   - Sistema de comentarios para cada receta.
   - Valoraciones para clasificar las recetas.

5. **Administración**:
   - Panel administrativo para gestionar usuarios, recetas y comentarios.

6. **Soporte y Contacto**:
   - Formulario para enviar consultas al administrador.

---

## Tecnologías Utilizadas

- **Lenguaje de Programación:** PHP
- **Base de Datos:** MySQL
- **Servidor Web:** Apache2
- **Frontend:** HTML5, CSS3, JavaScript
- **Herramientas adicionales:** Laragon (entorno local), PHPMailer (gestión de correos electrónicos)

---

## Instalación

### Requisitos previos:
- Laragon o XAMPP (servidor local).
- PHP 7.4 o superior.
- MySQL.

### Pasos de instalación:
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/colocas_tu_username/recetas.git
   

2. Colocar el proyecto en el directorio raíz del servidor local:
    ```bash
    mv recetas C:/laragon/www/PROYECTO_FINAL/Recetas

3. Importar la base de datos:

    - Abre phpMyAdmin o tu herramienta favorita de gestión de bases de datos.
    - Crea una base de datos llamada recetas.
    - Importa el archivo Database/Database.sql.

4. Configurar el archivo config.php:

Ajusta las credenciales de la base de datos:

    define('DB_HOST', 'localhost');
    define('DB_USER', 'recetas');
    define('DB_PASSWORD', 'recetas');
    define('DB_NAME', 'recetas_web');

5. Inicia Laragon y accede al proyecto:
    ```bash
    http://localhost/PROYECTO_FINAL/Recetas

---

## Uso
### Funcionalidades básicas:

1. Registro de usuario:
   - Crea una cuenta para poder añadir recetas y comentar.

2. Añadir una receta:
   - Accede a la opción "Agregar Receta" desde el menú.
   
3. Búsqueda de recetas:
   - Usa los filtros disponibles para encontrar recetas específicas.

4. Gestión de comentarios:
   - Deja comentarios y calificaciones en las recetas publicadas.

5. Administración:
   - Los administradores pueden gestionar usuarios, recetas y comentarios desde el panel.

---

## Contribuciones
### Si deseas contribuir a este proyecto:

1. Haz un fork del repositorio.
2. Crea una nueva rama para tu funcionalidad:

    ```bash
    git checkout -b feature/nueva-funcionalidad

3. Realiza un pull request explicando tus cambios.

---

## Autores
### Milagros Alonzo
### Kenneth Pardo


