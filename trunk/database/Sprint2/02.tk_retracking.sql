CREATE TABLE `tk_retracking` (
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`visitor_id` VARCHAR(200) NOT NULL,
	`tracking_id` VARCHAR(200) NOT NULL,
	`interval` INT(11) NOT NULL,
	`reg_dttm` DATETIME NOT NULL COMMENT 'Current date time',
	`reg_time` BIGINT(20) NOT NULL COMMENT 'Number of seconds from 1900',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=118;