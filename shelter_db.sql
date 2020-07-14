CREATE SCHEMA IF NOT EXISTS `shelter` DEFAULT CHARACTER SET utf8 ;

USE shelter;

CREATE TABLE IF NOT EXISTS `shelter`.`user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(200) NOT NULL,
  `hash` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shelter`.`user_info` (
  `id_info` INT(11) NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(45) NOT NULL,
  `id_user` INT(11) NOT NULL,
  PRIMARY KEY (`id_info`),
  INDEX `fk_user_info_user_idx` (`id_user` ASC),
  CONSTRAINT `fk_user_info_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `shelter`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shelter`.`category` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_category`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shelter`.`animal` (
  `id_animal` INT(11) NOT NULL AUTO_INCREMENT,
  `animal_name` VARCHAR(150) NOT NULL,
  `description` MEDIUMTEXT NOT NULL,
  `age` FLOAT(11) NOT NULL,
  `passport` TINYINT(4) NULL DEFAULT 0,
  `vaccination` TINYINT(4) NULL DEFAULT 0,
  `id_category` INT(11) NOT NULL,
  `id_user` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_animal`),
  INDEX `fk_animal_category1_idx` (`id_category` ASC),
  INDEX `fk_animal_user1_idx` (`id_user` ASC),
  CONSTRAINT `fk_animal_category1`
    FOREIGN KEY (`id_category`)
    REFERENCES `shelter`.`category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `shelter`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shelter`.`img` (
  `id_img` INT(11) NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(250) NOT NULL,
  `main` TINYINT(4) NULL DEFAULT 0,
  `animal` INT(11) NOT NULL,
  PRIMARY KEY (`id_img`),
  INDEX `fk_img_animal1_idx` (`animal` ASC),
  CONSTRAINT `fk_img_animal1`
    FOREIGN KEY (`animal`)
    REFERENCES `shelter`.`animal` (`id_animal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shelter`.`comment` (
  `id_comment` INT(11) NOT NULL,
  `comment_text` MEDIUMTEXT NOT NULL,
  `added` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_comment_id` INT(11) NULL DEFAULT NULL,
  `id_animal` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  INDEX `fk_comment_comment1_idx` (`parent_comment_id` ASC),
  INDEX `fk_comment_animal1_idx` (`id_animal` ASC),
  INDEX `fk_comment_user1_idx` (`id_user` ASC),
  CONSTRAINT `fk_comment_comment1`
    FOREIGN KEY (`parent_comment_id`)
    REFERENCES `shelter`.`comment` (`id_comment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_animal1`
    FOREIGN KEY (`id_animal`)
    REFERENCES `shelter`.`animal` (`id_animal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `shelter`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

insert into category(name, description)
values ('cats', 'Кошки'), ('dogs', 'Собаки');

INSERT INTO animal(animal_name, description, age, passport, vaccination, id_category)
VALUES
('Граф', 'Очень добрый пес', 2.4, true, true, 2),
('Барсик', 'Ласковый кот', 0.7, true, true, 1),
('Степка', 'Умный кот', true, true, 3, 1),
('Боня', 'Милый щенок', false, false, 0.4, 2),
('Мурзик', 'Отличный друг', 2, true, true, 1);

insert into img(path, main, animal) values
         ('https://picsum.photos/id/237/400/600', true, 1),
         ('https://picsum.photos/id/237/400/600', false, 1),
         ('https://picsum.photos/id/237/400/600', false, 1),
         ('https://picsum.photos/id/237/400/600', false, 1),
         ('https://picsum.photos/id/1025/400/600', true, 4),
         ('https://picsum.photos/id/1026/400/600', false, 4),
         ('https://picsum.photos/id/1026/400/600', false, 4),
         ('https://picsum.photos/id/1026/400/600', false, 4),
         ('https://picsum.photos/id/219/400/600', true, 5),
         ('https://picsum.photos/id/219/400/600', false, 5),
         ('https://picsum.photos/id/219/400/600', false, 5),
         ('https://picsum.photos/id/219/400/600', false, 5),
         ('https://picsum.photos/id/40/400/600', true, 2),
         ('https://picsum.photos/id/40/400/600', false, 2),
         ('https://picsum.photos/id/40/400/600', false, 2),
         ('https://picsum.photos/id/40/400/600', false, 2),
         ('https://picsum.photos/id/593/400/600', true, 3),
         ('https://picsum.photos/id/593/400/600', false, 3),
         ('https://picsum.photos/id/593/400/600', false, 3),
         ('https://picsum.photos/id/593/400/600', false, 3);