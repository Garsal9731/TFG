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
  `id Privilegios` INT NOT NULL,
  `Nombre Privilegio` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id Privilegios`),
  UNIQUE INDEX `id Privilegios_UNIQUE` (`id Privilegios` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Usuario` (
  `Id Usuario` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Contraseña` VARCHAR(60) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Privilegios` INT NOT NULL,
  INDEX `fk_Usuario_Privilegios1_idx` (`Privilegios` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_Privilegios1`
    FOREIGN KEY (`Privilegios`)
    REFERENCES `gestor_rei`.`Privilegios` (`id Privilegios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Jefes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Jefes` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Jefes` (
  `Id Usuario` INT NULL,
  `Id Jefe` INT NULL,
  INDEX `fk_Usuario_has_Usuario_Usuario1_idx` (`Id Jefe` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Usuario_Usuario_idx` (`Id Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario`
    FOREIGN KEY (`Id Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1`
    FOREIGN KEY (`Id Jefe`)
    REFERENCES `gestor_rei`.`Usuario` (`Id Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Tareas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Tareas` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Tareas` (
  `Id Tarea` INT PRIMARY KEY AUTO_INCREMENT,
  `Id Creador Tarea` INT NOT NULL,
  `Fecha Creación` DATE NOT NULL,
  `Tiempo estimado` DATETIME NOT NULL,
  `Nombre Tarea` VARCHAR(45) NOT NULL,
  `Detalles` VARCHAR(45) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Tareas Asignadas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Tareas Asignadas` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Tareas Asignadas` (
  `Tareas_Id Tarea` INT NOT NULL,
  `Usuario_Id Usuario` INT NOT NULL,
  PRIMARY KEY (`Tareas_Id Tarea`, `Usuario_Id Usuario`),
  INDEX `fk_Tareas_has_Usuario_Usuario1_idx` (`Usuario_Id Usuario` ASC) VISIBLE,
  INDEX `fk_Tareas_has_Usuario_Tareas1_idx` (`Tareas_Id Tarea` ASC) VISIBLE,
  CONSTRAINT `fk_Tareas_has_Usuario_Tareas1`
    FOREIGN KEY (`Tareas_Id Tarea`)
    REFERENCES `gestor_rei`.`Tareas` (`Id Tarea`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tareas_has_Usuario_Usuario1`
    FOREIGN KEY (`Usuario_Id Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Institución` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Institución` (
  `id Institución` INT PRIMARY KEY AUTO_INCREMENT,
  `Nombre Institución` VARCHAR(60) NOT NULL,
  UNIQUE INDEX `Nombre Institución_UNIQUE` (`Nombre Institución` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Trabajadores asociados a Institución`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Trabajadores asociados a Institución` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Trabajadores asociados a Institución` (
  `Usuario_Id Usuario` INT NOT NULL,
  `Institución_id Institución` INT NOT NULL,
  PRIMARY KEY (`Usuario_Id Usuario`, `Institución_id Institución`),
  INDEX `fk_Usuario_has_Institución_Institución1_idx` (`Institución_id Institución` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Institución_Usuario1_idx` (`Usuario_Id Usuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Institución_Usuario1`
    FOREIGN KEY (`Usuario_Id Usuario`)
    REFERENCES `gestor_rei`.`Usuario` (`Id Usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Institución_Institución1`
    FOREIGN KEY (`Institución_id Institución`)
    REFERENCES `gestor_rei`.`Institución` (`id Institución`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gestor_rei`.`Objeto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gestor_rei`.`Objeto` ;

CREATE TABLE IF NOT EXISTS `gestor_rei`.`Objeto` (
  `id Objeto` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  `Num Inventario` INT NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `Estado` ENUM("Alta", "Baja", "Inactivo", "Averiado") NOT NULL,
  `Descripción Avería` VARCHAR(45) NULL,
  `Institución_id Institución` INT NOT NULL,
  UNIQUE INDEX `Num Inventario_UNIQUE` (`Num Inventario` ASC) VISIBLE,
  INDEX `fk_Objeto_Institución1_idx` (`Institución_id Institución` ASC) VISIBLE,
  CONSTRAINT `fk_Objeto_Institución1`
    FOREIGN KEY (`Institución_id Institución`)
    REFERENCES `gestor_rei`.`Institución` (`id Institución`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
