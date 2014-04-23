CREATE TABLE `tracking_identity` (
	`identity_id` BIGINT NOT NULL AUTO_INCREMENT,
	`visitor_id` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NULL,
	`phone` VARCHAR(255) NULL,
	`mobile` VARCHAR(255) NULL,
	`address` VARCHAR(255) NULL,
	`more_info` VARCHAR(500) NULL,
	PRIMARY KEY (`identity_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;