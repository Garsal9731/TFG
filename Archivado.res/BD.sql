CREATE DATABASE tiendadetiendas;

USE tiendadetiendas;

CREATE TABLE
  IF NOT EXISTS usuarios (
    idusuario int (50) NOT NULL AUTO_INCREMENT,
    nombre varchar(200) COLLATE utf8_bin NOT NULL,
    contrasenya varchar(200) COLLATE utf8_bin NOT NULL,
    privilegio int(50) COLLATE utf8_bin NOT NULL,
    correo varchar(900) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (idusuario)
  );

CREATE TABLE
  IF NOT EXISTS tiendas (
    idtienda int (50) NOT NULL AUTO_INCREMENT,
    nombre varchar(900) COLLATE utf8_bin NOT NULL,
    idpropietario int(50) COLLATE utf8_bin NOT NULL,
    descripcion varchar(900) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (idtienda),
    FOREIGN KEY (idpropietario) REFERENCES usuarios(idusuario)
  );

CREATE TABLE
  IF NOT EXISTS productos (
    idproducto int (50) NOT NULL AUTO_INCREMENT,
    tienda int(50) COLLATE utf8_bin NOT NULL,
    nombre varchar(200) COLLATE utf8_bin NOT NULL,
    descripcion varchar(900) COLLATE utf8_bin NOT NULL,
    rutafoto varchar(900) COLLATE utf8_bin NOT NULL,
    unidades int(50) COLLATE utf8_bin NOT NULL,
    precio DECIMAL(65,2) NOT NULL,
    PRIMARY KEY (idproducto),
    FOREIGN KEY (tienda) REFERENCES tiendas(idtienda)
  );

CREATE TABLE
  IF NOT EXISTS reservas (
    idreserva int (50) NOT NULL AUTO_INCREMENT,
    usuario int(50) COLLATE utf8_bin NOT NULL,
    productos varchar(999) COLLATE utf8_bin NOT NULL,
    precio DECIMAL(65,2) NOT NULL,
    PRIMARY KEY (idreserva),
    FOREIGN KEY (usuario) REFERENCES usuarios(idusuario)
  );

INSERT INTO usuarios (nombre, contrasenya, privilegio, correo) VALUES 
  ("admin", "$2y$10$AazPverunODYkw9LVEKGXOE.lOLBozgbwuoRn/nxt5g5PxmnGNnPq", "1", "admin@1234"),
  ("manolo", "$2y$10$O3563RCxKTjMy9iP5eqIb.BgpE0p0kcrQo1e9yYSPkecSEHBhjPtu", "0", "manolo@patata.com"),
  ("antonio", "$2y$10$Sh9Rgo/hltiQq8v2kb9M0egPa5IZdNYA7JPMpbYodLMfHJHddO5h.", "0", "antonio@sas.com"),
("admin", "$2y$10$JxBe6rhmcs1hwoeYRTOIy.B1xYLmBkg2VzJjlcphpuPp9eagasgcC", "1", "admin@12345678.es");

INSERT INTO tiendas (nombre, idpropietario, descripcion) VALUES
  ("tienda prueba", 1, "esto es una prueba de la primera tienda en la BD"),
  ("tienda de manolo", 2, "manolo vende muchas patatas"),
("otra tienda admin", 1, "esto es otra tienda del admin");

INSERT INTO productos (tienda, nombre, descripcion, rutafoto, unidades, precio) VALUES
  (1, "Ferrero", "Los ferrero están muy caros", "../View/img/1.jpg", 20000000, "9999.00"),
  (2, "Guitarra", "Guitarra Española", "../View/img/2.jpg", 50, "60.00"),
(1, "Peluche Pikachu", "Muy cotizados", "../View/img/3.png", 2, "999.00");