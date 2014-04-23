ALTER TABLE `tracking_tracking`
	ADD COLUMN `interval` INT NULL DEFAULT NULL AFTER `session_id`;
	
ALTER TABLE `tracking_retracking`
	ADD COLUMN `interval` INT NULL DEFAULT NULL AFTER `session_id`;