ALTER TABLE `tracking_cta_page`
	ADD COLUMN `success_url` VARCHAR(1000) NOT NULL AFTER `page_url`;