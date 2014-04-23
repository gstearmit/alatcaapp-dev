ALTER TABLE `zend_menugroup`
	ADD COLUMN `group_url` VARCHAR(500) NULL AFTER `group_name`;
ALTER TABLE `zend_menugroup`
	ADD COLUMN `group_icon` VARCHAR(100) NOT NULL DEFAULT 'icon-edit' AFTER `group_url`;