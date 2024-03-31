CREATE TABLE IF NOT EXISTS `db`.`activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `db`.`adventure_activity` (
  `activity_id` INT NOT NULL,
  `equipment_name` VARCHAR(45) NOT NULL,
  INDEX `activity_id_idx` (`activity_id` ASC),
  CONSTRAINT `activity_id`
    FOREIGN KEY (`activity_id`)
    REFERENCES `db`.`activity` (`activity_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `db`.`online_game_activity` (
  `activity_id` INT NOT NULL,
  `platform` VARCHAR(45) NOT NULL,
  INDEX `activity_id_2_idx` (`activity_id` ASC),
  CONSTRAINT `activity_id_2`
    FOREIGN KEY (`activity_id`)
    REFERENCES `db`.`activity` (`activity_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `db`.`sports_activity` (
  `activity_id` INT NOT NULL,
  `sports_type` VARCHAR(45) NOT NULL,
  INDEX `activity_id_3_idx` (`activity_id` ASC),
  CONSTRAINT `activity_id_3`
    FOREIGN KEY (`activity_id`)
    REFERENCES `db`.`activity` (`activity_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);