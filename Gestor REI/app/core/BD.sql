-- -----------------------------------------------------
-- Schema gestor_rei
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `gestor_rei` ;

CREATE SCHEMA IF NOT EXISTS `gestor_rei` 
DEFAULT CHARACTER SET UTF8 COLLATE utf8_spanish_ci;

CREATE DATABASE IF NOT EXISTS `gestor_rei`;
USE `gestor_rei`;

-- -----------------------------------------------------
-- Table `gestor_rei`.`Privilegios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Privilegios` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Privilegios` (
  `id_Privilegios` INT NOT NULL,
  `Nombre_Privilegio` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_Privilegios`),
  UNIQUE INDEX `id_Privilegios_UNIQUE` (`id_Privilegios` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Usuario` (
  `Id_Usuario` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Contraseña` VARCHAR(100) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Privilegios` INT NOT NULL,
  INDEX `fk_Usuario_Privilegios1_idx` (`Privilegios` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_Privilegios1`
    FOREIGN KEY (`Privilegios`)
    REFERENCES `gestor_rei`.`Privilegios` (`id_Privilegios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Jefes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Jefes` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Jefes` (
  `Id_Usuario` INT NULL,
  `Id_Jefe` INT NULL,
  INDEX `fk_Usuario_has_Usuario_Usuario1_idx` (`Id_Jefe` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Usuario_Usuario_idx` (`Id_Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1`
    FOREIGN KEY (`Id_Jefe`)
    REFERENCES `gestor_rei`.`Usuario` (`Id_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Tareas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Tareas` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Tareas` (
  `Id_Tarea` INT PRIMARY KEY AUTO_INCREMENT,
  `Id_Creador_Tarea` INT NOT NULL,
  `Fecha_Creación` DATE NOT NULL,
  `Tiempo_Estimado` DATETIME NOT NULL,
  `Nombre_Tarea` VARCHAR(45) NOT NULL,
  `Detalles` VARCHAR(45) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Tareas_Asignadas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Tareas_Asignadas` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Tareas_Asignadas` (
  `Tareas_Id_Tarea` INT NOT NULL,
  `Usuario_Id_Usuario` INT NOT NULL,
  PRIMARY KEY (`Tareas_Id_Tarea`, `Usuario_Id_Usuario`),
  INDEX `fk_Tareas_has_Usuario_Usuario1_idx` (`Usuario_Id_Usuario` ASC) VISIBLE,
  INDEX `fk_Tareas_has_Usuario_Tareas1_idx` (`Tareas_Id_Tarea` ASC) VISIBLE,
  CONSTRAINT `fk_Tareas_has_Usuario_Tareas1`
    FOREIGN KEY (`Tareas_Id_Tarea`)
    REFERENCES `gestor_rei`.`Tareas` (`Id_Tarea`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tareas_has_Usuario_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Institución` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Institución` (
  `id_Institución` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre_Institución` VARCHAR(60) NOT NULL,
  UNIQUE INDEX `Nombre_Institución_UNIQUE` (`Nombre_Institución` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Trabajadores_Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Trabajadores_Institución` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Trabajadores_Institución` (
  `Usuario_Id_Usuario` INT NOT NULL,
  `Institución_id_Institución` INT NOT NULL,
  PRIMARY KEY (`Usuario_Id_Usuario`, `Institución_id_Institución`),
  INDEX `fk_Usuario_has_Institución_Institución1_idx` (`Institución_id_Institución` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Institución_Usuario1_idx` (`Usuario_Id_Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Institución_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id_Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Institución_Institución1`
    FOREIGN KEY (`Institución_id_Institución`)
    REFERENCES `gestor_rei`.`Institución` (`id_Institución`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Objeto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Objeto` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Objeto` (
  `id_Objeto` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Num_Inventario` INT NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Estado` ENUM("Alta", "Baja", "Inactivo", "Averiado") NOT NULL,
  `Descripción_Avería` VARCHAR(45) NULL,
  `Institución_id_Institución` INT NOT NULL,
  UNIQUE INDEX `Num_Inventario_UNIQUE` (`Num_Inventario` ASC) VISIBLE,
  INDEX `fk_Objeto_Institución1_idx` (`Institución_id_Institución` ASC) VISIBLE,
  CONSTRAINT `fk_Objeto_Institución1`
    FOREIGN KEY (`Institución_id_Institución`)
    REFERENCES `gestor_rei`.`Institución` (`id_Institución`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO Privilegios VALUES 
  (1, "admin"),
  (2, "técnico"),
  (3, "usuario")
;

INSERT INTO Institución (Nombre_Institución) VALUES 
  ("Escuela"),
  ("Instituto"),
  ("Hospital"),
  ("Ayuntamiento")
;