CREATE TABLE `tk_tracking` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`visitor_id` VARCHAR(200) NOT NULL,
	`ip_client` VARCHAR(200) NULL DEFAULT NULL,
	`brower` VARCHAR(300) NOT NULL,
	`url_current` VARCHAR(3000) NOT NULL,
	`url_refer` VARCHAR(3000) NULL DEFAULT NULL,
	`session_id` VARCHAR(200) NOT NULL,
	`reg_dttm` DATETIME NOT NULL,
	`reg_time` BIGINT(20) NOT NULL COMMENT 'Number of second since 1900',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;
