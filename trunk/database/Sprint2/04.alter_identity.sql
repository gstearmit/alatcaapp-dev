ALTER TABLE `tracking_identity`
	ADD COLUMN `ip` VARCHAR(50) NULL DEFAULT NULL AFTER `address`,
	ADD COLUMN `browser` VARCHAR(255) NULL DEFAULT NULL AFTER `ip`;