ALTER TABLE `tracking_visitor`
	ADD COLUMN `reg_dttm` DATETIME NULL DEFAULT NULL AFTER `customer_code`,
	ADD COLUMN `upd_dttm` DATETIME NULL DEFAULT NULL AFTER `reg_dttm`;
	
ALTER TABLE `tracking_tracking`
	ADD COLUMN `reg_dttm` DATETIME NULL DEFAULT NULL AFTER `interval`,
	ADD COLUMN `upd_dttm` DATETIME NULL DEFAULT NULL AFTER `reg_dttm`;
	
ALTER TABLE `tracking_retracking`
	ADD COLUMN `reg_dttm` DATETIME NULL DEFAULT NULL AFTER `interval`,
	ADD COLUMN `upd_dttm` DATETIME NULL DEFAULT NULL AFTER `reg_dttm`;