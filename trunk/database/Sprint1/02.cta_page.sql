CREATE TABLE `tracking_cta_page` (
	`page_id` INT(11) NOT NULL AUTO_INCREMENT,
	`page_name` VARCHAR(255) NOT NULL,
	`page_url` VARCHAR(1000) NOT NULL,
	`cta_position` VARCHAR(255) NOT NULL,
	`description` VARCHAR(1000) NOT NULL,
	PRIMARY KEY (`page_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;