CREATE TABLE `tasks` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`email` VARCHAR(50) NOT NULL,
	`description` VARCHAR(50) NOT NULL,
	`done` ENUM('Y','N') NOT NULL DEFAULT 'N',
	`edited` ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY (`id`)
);