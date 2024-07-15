DROP DATABASE IF EXISTS  archivadores;
CREATE DATABASE archivadores;

USE archivadores;

CREATE TABLE
  IF NOT EXISTS usuarios (
    idusuario int (50) NOT NULL AUTO_INCREMENT,
    nombre varchar(200) COLLATE utf8_bin NOT NULL,
    contrasenya varchar(200) COLLATE utf8_bin NOT NULL,
    privilegio int(50) COLLATE utf8_bin NOT NULL,
    correo varchar(900) COLLATE utf8_bin NOT NULL,
    descripcion varchar(900) COLLATE utf8_bin,
    PRIMARY KEY (idusuario)
  );

CREATE TABLE
  IF NOT EXISTS archivos (
    idarchivo int (50) NOT NULL AUTO_INCREMENT,
    usuario_subida int(50) COLLATE utf8_bin NOT NULL,
    descripcion varchar(900) COLLATE utf8_bin NOT NULL,
    ruta_archivo varchar(900) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (idarchivo),
    FOREIGN KEY (usuario_subida) REFERENCES usuarios(idusuario)
  );

CREATE TABLE
  IF NOT EXISTS contenido (
    idpost int (50) NOT NULL AUTO_INCREMENT,
    tipo_contenido int(50) COLLATE utf8_bin NOT NULL,
    nombre varchar(200) COLLATE utf8_bin NOT NULL,
    detalles varchar(900) COLLATE utf8_bin,
    Autor_original varchar(900) COLLATE utf8_bin NOT NULL,
    Autor_post int(50) COLLATE utf8_bin NOT NULL,
    -- Actua como un array de IDs de los archivos subidos
    Archivos varchar(999) COLLATE utf8_bin NOT NULL,
    fecha_subida Date NOT NULL,
    PRIMARY KEY (idpost),
    FOREIGN KEY (Autor_post) REFERENCES usuarios(idusuario),
  );

INSERT INTO usuarios (nombre, contrasenya, privilegio, correo) VALUES 
  ("admin", "$2y$10$AazPverunODYkw9LVEKGXOE.lOLBozgbwuoRn/nxt5g5PxmnGNnPq", "1", "admin@1234"),
  ("manolo", "$2y$10$O3563RCxKTjMy9iP5eqIb.BgpE0p0kcrQo1e9yYSPkecSEHBhjPtu", "0", "manolo@patata.com"),
  ("antonio", "$2y$10$Sh9Rgo/hltiQq8v2kb9M0egPa5IZdNYA7JPMpbYodLMfHJHddO5h.", "0", "antonio@sas.com"),
("admin", "$2y$10$JxBe6rhmcs1hwoeYRTOIy.B1xYLmBkg2VzJjlcphpuPp9eagasgcC", "1", "admin@12345678.es");
