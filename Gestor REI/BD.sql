-- -----------------------------------------------------
-- Schema gestorei
-- -----------------------------------------------------
-- DROP SCHEMA IF EXISTS `gestorei` ;

-- CREATE SCHEMA IF NOT EXISTS `gestorei` 
-- DEFAULT CHARACTER SET UTF8 COLLATE utf8_spanish_ci;

CREATE DATABASE IF NOT EXISTS `gestorei`;
USE `gestorei`;

-- -----------------------------------------------------
-- Table `gestorei`.`Privilegios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Privilegios` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Privilegios` (
  `id_Privilegios` INT NOT NULL,
  `Nombre_Privilegio` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_Privilegios`),
  UNIQUE INDEX `id_Privilegios_UNIQUE` (`id_Privilegios` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Usuario` (
  `Id_Usuario` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Contraseña` VARCHAR(100) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Privilegios` INT NOT NULL,
  INDEX `fk_Usuario_Privilegios1_idx` (`Privilegios` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_Privilegios1`
    FOREIGN KEY (`Privilegios`)
    REFERENCES `gestorei`.`Privilegios` (`id_Privilegios`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Jefes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Jefes` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Jefes` (
  `Id_Jefe` INT NULL,
  `Id_Usuario` INT NULL,
  INDEX `fk_Usuario_has_Usuario_Usuario1_idx` (`Id_Jefe` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Usuario_Usuario_idx` (`Id_Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `gestorei`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1`
    FOREIGN KEY (`Id_Jefe`)
    REFERENCES `gestorei`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Tarea`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Tarea` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Tarea` (
  `Id_Tarea` INT PRIMARY KEY AUTO_INCREMENT,
  `Id_Creador_Tarea` INT NOT NULL,
  `Fecha_Creación` DATE NOT NULL,
  `Tiempo_Estimado` DATE NOT NULL,
  `Nombre_Tarea` VARCHAR(100) NOT NULL,
  `Detalles` VARCHAR(200) NULL,
  `Estado` ENUM("Pendiente", "Completada") NOT NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Tarea_Asignadas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Tarea_Asignadas` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Tarea_Asignadas` (
  `Tarea_Id_Tarea` INT NOT NULL,
  `Usuario_Id_Usuario` INT NOT NULL,
  PRIMARY KEY (`Tarea_Id_Tarea`, `Usuario_Id_Usuario`),
  INDEX `fk_Tarea_has_Usuario_Usuario1_idx` (`Usuario_Id_Usuario` ASC) VISIBLE,
  INDEX `fk_Tarea_has_Usuario_Tarea1_idx` (`Tarea_Id_Tarea` ASC) VISIBLE,
  CONSTRAINT `fk_Tarea_has_Usuario_Tarea1`
    FOREIGN KEY (`Tarea_Id_Tarea`)
    REFERENCES `gestorei`.`Tarea` (`Id_Tarea`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tarea_has_Usuario_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `gestorei`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Institución` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Institución` (
  `Id_Institución` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre_Institución` VARCHAR(60) NOT NULL,
  UNIQUE INDEX `Nombre_Institución_UNIQUE` (`Nombre_Institución` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Trabajadores_Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Trabajadores_Institución` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Trabajadores_Institución` (
  `Usuario_Id_Usuario` INT NOT NULL,
  `Institución_Id_Institución` INT NOT NULL,
  PRIMARY KEY (`Usuario_Id_Usuario`, `Institución_Id_Institución`),
  INDEX `fk_Usuario_has_Institución_Institución1_idx` (`Institución_Id_Institución` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Institución_Usuario1_idx` (`Usuario_Id_Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Institución_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `gestorei`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Institución_Institución1`
    FOREIGN KEY (`Institución_Id_Institución`)
    REFERENCES `gestorei`.`Institución` (`Id_Institución`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestorei`.`Objeto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestorei`.`Objeto` ;

CREATE TABLE IF NOT EXISTS `gestorei`.`Objeto` (
  `Id_Objeto` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Nombre` VARCHAR(45) NOT NULL,
  `Estado` ENUM("Alta", "Baja", "Inactivo", "Averiado") NOT NULL,
  `Descripción_Avería` VARCHAR(45) NULL,
  `Institución_Id_Institución` INT NOT NULL,
  INDEX `fk_Objeto_Institución1_idx` (`Institución_Id_Institución` ASC) VISIBLE,
  CONSTRAINT `fk_Objeto_Institución1`
    FOREIGN KEY (`Institución_Id_Institución`)
    REFERENCES `gestorei`.`Institución` (`Id_Institución`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO Privilegios VALUES 
  (1, "admin"),
  (2, "técnico"),
  (3, "usuario"),
  (4, "owner")
;

INSERT INTO Institución (Nombre_Institución) VALUES 
  ("Escuela"),
  ("Instituto"),
  ("Hospital"),
  ("Ayuntamiento"),
  ("Academia"),
  ("Biblioteca")
;

-- La contraseña de las cuentas base son 1234
INSERT INTO Usuario (Nombre,Contraseña,Correo,Privilegios) VALUES
  ("Admin","$2y$10$jaPNr8/4L18u0xlL2PF0mOwcGPJEmFJedaxSv6UXR/ir.orl7qWjC","admin@correo.es",1),
  ("tecnico","$2y$10$/IVtCLkoyC22aDOqwPMCAOco9GTXfdIT2nYHAGjV3hHZQKSu82RbS","tecnico@correo.es",2),
  ("usuario ","$2y$10$iTxw38WV8D2IRb5OpXrNtOjCGwpMOroeiHSWvGvLV02hB1OYTS7.e","usuario@correo.es",3),
  ("tecnico2","$2y$10$olsEItRnCguM0.R1rxWfTuW90AXnt/KE4Hxv9Rmx4/atXuqYtJul.","tecnico2@correo.es",2),
  ("tecnico3","$2y$10$gIY3qdrSmHXH2iai8xiQoO5m/3S9WJ8Q1RmlMVSAtpPyGEKHcOvp.","tecnico3@correo.es",2),
  ("tecnico4","$2y$10$gIY3qdrSmHXH2iai8xiQoO5m/3S9WJ8Q1RmlMVSAtpPyGEKHcOvp.","tecnico3@correo.es",2),
  ("tecnico5","$2y$10$IecB9BIIkq6iVqGvx9EuzeCVPXzjXKqal6ChUb47GRnvQK86SyzrK","tecnico5@correo.es",2),
  ("prueba","$2y$10$roDhFHMevaYxGi3/fudDt.CFnLmqqwqPdkTMzB8naAPEdYz6C8LIO","prueba@correo.es",3),
  ("test","$2y$10$Id0fW1.c9locyTTYFbIAxesqtokJak7Q0Fk4qPCLlDfgWsD85BxAu","test@correo.es",3),
  ("alvaro","$2y$10$4SHEwiqKSLtKclJISxGT9eWFRaDyG6VjB7sop4BaPKt5vTk6DlI7K","alvaro@correo.es",4),
  ("adminbib","$2y$10$/ebl6nS3t3bb/FtvB5.Cd.K1VgJpZgHTDN13fmqNHJ2rQ9dBQM4/C","adminbib@correo.es",1)
;

INSERT INTO Trabajadores_Institución VALUES 
(1,1),
(2,1),
(3,1),
(4,1),
(6,1),
(7,1),
(8,1),
(9,1),
(11,6)
;

INSERT INTO Jefes VALUES
(1,2),
(1,5),
(1,6),
(1,7),
(2,5),
(2,6),
(7,2),
(7,5)
;

INSERT INTO Tarea VALUE
(6,1,"2025-04-21","2025-04-25","terminar trabajo AHORA","no habeis accabado","Pendiente"),
(9,1,"2025-04-22","2025-04-26","revisar papeleo","","Pendiente"),
(10,1,"2025-04-26","2025-05-02","dadad","adadadada","Pendiente"),
(11,1,"2025-05-15","2025-05-24","prueba completa","esta prueba está completa","Completada"),
(12,1,"2025-05-15","2025-05-29","prueba 1","","Pendiente"),
(13,1,"2025-05-15","2025-05-17","prueba 2","","Pendiente"),
(14,1,"2025-05-15","2025-05-23","prueba 3","esto es una prueba","Pendiente"),
(15,1,"2025-05-15","2025-05-22","prueba 4","esto es una prueba","Completada"),
(16,1,"2025-05-15","2025-05-24","prueba 5","esto es una prueba","Completada"),
(17,1,"2025-05-15","2025-05-28","prueba 7","esto es una prueba","Pendiente")
;

INSERT INTO Tarea_Asignadas VALUES
(6,2),
(12,2),
(13,2),
(14,2),
(15,2),
(16,2),
(17,2),
(6,5),
(11,5),
(6,6),
(10,6),
(9,7),
(10,7)
;

INSERT INTO Objeto VALUES
(3,"pc no patata","Alta","",1)
;