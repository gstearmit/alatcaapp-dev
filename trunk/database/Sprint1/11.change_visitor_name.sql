ALTER TABLE `tracking_visitor`
	CHANGE COLUMN `name` `name` BIGINT ZEROFILL NULL AFTER `visitor_id`;		
update tracking_visitor set name = id;